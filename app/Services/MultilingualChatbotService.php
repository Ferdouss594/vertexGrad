<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Conversation;
use App\Models\User;

class MultilingualChatbotService
{
    protected $apiUrl;
    protected $timeout = 2; // 2 seconds timeout
    
    public function __construct()
    {
        $this->apiUrl = env('CHATBOT_API_URL', 'http://localhost:5000');
    }
    
    /**
     * معالجة رسالة المستخدم
     */
    public function processMessage($message, $user = null, $sessionId = null)
    {
        try {
            // 1. استدعاء Python API
            $prediction = $this->callPythonApi($message);
            
            // 2. التحقق من النجاح
            if (!$prediction || !($prediction['success'] ?? false)) {
                return $this->getFallbackResponse($message, $user);
            }
            
            // 3. توليد الرد المناسب
            $response = $this->generateResponse(
                $prediction['intent'],
                $prediction['language'],
                $user,
                $prediction['confidence']
            );
            
            // 4. حفظ المحادثة
            $conversation = $this->saveConversation(
                $message,
                $response,
                $prediction,
                $user,
                $sessionId
            );
            
            // 5. إضافة إجراءات مقترحة
            $actions = $this->getSuggestedActions($prediction['intent'], $user);
            
            return [
                'success' => true,
                'message' => $response,
                'intent' => $prediction['intent'],
                'confidence' => $prediction['confidence'],
                'language' => $prediction['language'],
                'actions' => $actions,
                'suggestions' => $this->getFollowUpSuggestions($prediction['intent'], $prediction['language']),
                'conversation_id' => $conversation?->id
            ];
            
        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());
            return $this->getFallbackResponse($message, $user);
        }
    }
    
    /**
     * استدعاء Python API
     */
    protected function callPythonApi($message)
    {
        try {
            $response = Http::timeout($this->timeout)->post($this->apiUrl . '/chat', [
                'message' => $message
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            Log::warning('Python API returned error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to call Python API: ' . $e->getMessage());
        }
        
        return null;
    }
    
    /**
     * توليد الرد المناسب
     */
    protected function generateResponse($intent, $language, $user, $confidence)
    {
        // ردود مخصصة لكل نية
        $responses = [
            'project_submission' => [
                'ar' => "📝 **لتقديم مشروع جديد:**\n\n" .
                        "1️⃣ سجل الدخول إلى حسابك\n" .
                        "2️⃣ اضغط على 'تقديم مشروع' في القائمة\n" .
                        "3️⃣ املأ معلومات المشروع\n" .
                        "4️⃣ ارفع الملفات المطلوبة\n" .
                        "5️⃣ انتظر مراجعة المشرف\n\n" .
                        "هل تريد مساعدة في خطوة محددة؟",
                
                'en' => "📝 **To submit a new project:**\n\n" .
                        "1️⃣ Login to your account\n" .
                        "2️⃣ Click on 'Submit Project' in the menu\n" .
                        "3️⃣ Fill project information\n" .
                        "4️⃣ Upload required files\n" .
                        "5️⃣ Wait for supervisor review\n\n" .
                        "Do you need help with a specific step?"
            ],
            
            'investment' => [
                'ar' => "💰 **مرحباً بك في منصة الاستثمار!**\n\n" .
                        "📊 **المشاريع المتاحة:** " . $this->getAvailableProjectsCount() . " مشروع\n\n" .
                        "يمكنك الآن:\n" .
                        "• تصفح جميع المشاريع المتاحة\n" .
                        "• مشاهدة تفاصيل كل مشروع\n" .
                        "• التواصل مع أصحاب المشاريع\n" .
                        "• تقديم عروض تمويل\n\n" .
                        "هل تريد تصفح المشاريع الآن؟",
                
                'en' => "💰 **Welcome to the investment platform!**\n\n" .
                        "📊 **Available projects:** " . $this->getAvailableProjectsCount() . " projects\n\n" .
                        "You can now:\n" .
                        "• Browse all available projects\n" .
                        "• View project details\n" .
                        "• Contact project owners\n" .
                        "• Submit funding offers\n\n" .
                        "Would you like to browse projects now?"
            ],
            
            'account_approval' => [
                'ar' => function() use ($user) {
                    if (!$user) {
                        return "🔐 لتتبع حالة حسابك، يرجى تسجيل الدخول أولاً.";
                    }
                    
                    $status = $user->approved_at ? '✅ **مفعل**' : '⏳ **قيد المراجعة**';
                    $days = $user->created_at ? $user->created_at->diffInDays(now()) : 0;
                    
                    return "👤 **حالة حسابك:** $status\n\n" .
                           "📅 **تاريخ التسجيل:** " . ($user->created_at ? $user->created_at->format('Y-m-d') : '-') . "\n" .
                           "⏱️ **مدة الانتظار:** $days يوم\n\n" .
                           "سيصلك إشعار فور اكتمال التفعيل.";
                },
                
                'en' => function() use ($user) {
                    if (!$user) {
                        return "🔐 To track your account status, please login first.";
                    }
                    
                    $status = $user->approved_at ? '✅ **Activated**' : '⏳ **Pending Review**';
                    $days = $user->created_at ? $user->created_at->diffInDays(now()) : 0;
                    
                    return "👤 **Your account status:** $status\n\n" .
                           "📅 **Registration date:** " . ($user->created_at ? $user->created_at->format('Y-m-d') : '-') . "\n" .
                           "⏱️ **Waiting time:** $days days\n\n" .
                           "You'll be notified once activation is complete.";
                }
            ],
            
            'technical_support' => [
                'ar' => "🛠️ **الدعم الفني جاهز لمساعدتك!**\n\n" .
                        "**حلول سريعة للمشاكل الشائعة:**\n" .
                        "1️⃣ تحديث الصفحة (F5)\n" .
                        "2️⃣ استخدام متصفح Chrome أو Firefox\n" .
                        "3️⃣ مسح ذاكرة التخزين المؤقت\n" .
                        "4️⃣ تسجيل الخروج ثم الدخول مجدداً\n\n" .
                        "📞 **للتواصل المباشر:**\n" .
                        "• البريد: support@platform.com\n" .
                        "• الهاتف: 777123456\n\n" .
                        "مازالت المشكلة قائمة؟ أخبرنا بالتفصيل.",
                
                'en' => "🛠️ **Technical support is here to help!**\n\n" .
                        "**Quick solutions for common issues:**\n" .
                        "1️⃣ Refresh the page (F5)\n" .
                        "2️⃣ Use Chrome or Firefox browser\n" .
                        "3️⃣ Clear cache and cookies\n" .
                        "4️⃣ Logout and login again\n\n" .
                        "📞 **Contact us directly:**\n" .
                        "• Email: support@platform.com\n" .
                        "• Phone: 777123456\n\n" .
                        "Still having issues? Tell us more details."
            ],
            
            'report_inquiry' => [
                'ar' => "📊 **مرحباً بك في نظام التقارير**\n\n" .
                        "**التقارير المتاحة:**\n" .
                        "• تقرير المشاريع\n" .
                        "• تقرير المستثمرين\n" .
                        "• تقرير الطلاب\n" .
                        "• إحصائيات المنصة\n\n" .
                        "📥 **طريقة التحميل:**\n" .
                        "1. ادخل على لوحة التحكم\n" .
                        "2. اختر 'التقارير'\n" .
                        "3. حدد نوع التقرير\n" .
                        "4. اختر صيغة (Excel أو PDF)",
                
                'en' => "📊 **Welcome to the reporting system**\n\n" .
                        "**Available reports:**\n" .
                        "• Projects report\n" .
                        "• Investors report\n" .
                        "• Students report\n" .
                        "• Platform statistics\n\n" .
                        "📥 **How to download:**\n" .
                        "1. Go to dashboard\n" .
                        "2. Choose 'Reports'\n" .
                        "3. Select report type\n" .
                        "4. Choose format (Excel or PDF)"
            ],
            
            'calendar_events' => [
                'ar' => "📅 **الأحداث القادمة:**\n\n" .
                        $this->getUpcomingEvents('ar') . "\n\n" .
                        "لإضافة حدث جديد، استخدم التقويم في لوحة التحكم.",
                
                'en' => "📅 **Upcoming events:**\n\n" .
                        $this->getUpcomingEvents('en') . "\n\n" .
                        "To add a new event, use the calendar in the dashboard."
            ],
            
            'general_info' => [
                'ar' => "🌟 **مرحباً بك في منصتنا!**\n\n" .
                        "**عن المنصة:**\n" .
                        "منصة يمنية لريادة الأعمال والاستثمار\n\n" .
                        "**التواصل:**\n" .
                        "• البريد: info@platform.com\n" .
                        "• الهاتف: 777123456\n\n" .
                        "كيف يمكنني مساعدتك اليوم؟",
                
                'en' => "🌟 **Welcome to our platform!**\n\n" .
                        "**About us:**\n" .
                        "A Yemeni platform for entrepreneurship and investment\n\n" .
                        "**Contact:**\n" .
                        "• Email: info@platform.com\n" .
                        "• Phone: 777123456\n\n" .
                        "How can I help you today?"
            ]
        ];
        
        // إذا كان الرد دالة، نفذها
        if (isset($responses[$intent][$language]) && is_callable($responses[$intent][$language])) {
            return $responses[$intent][$language]();
        }
        
        // إذا كان الرد نصاً
        if (isset($responses[$intent][$language])) {
            return $responses[$intent][$language];
        }
        
        // رد افتراضي
        return $language == 'ar'
            ? "شكراً لتواصلك. كيف يمكنني مساعدتك اليوم؟"
            : "Thank you for contacting us. How can I help you today?";
    }
    
    /**
     * إجراءات مقترحة حسب النية
     */
    protected function getSuggestedActions($intent, $user)
    {
        $actions = [];
        
        switch ($intent) {
            case 'project_submission':
                $actions[] = [
                    'text' => ['ar' => 'تقديم مشروع', 'en' => 'Submit Project'],
                    'url' => route('project.submit.step1'),
                    'icon' => 'plus-circle'
                ];
                break;
                
            case 'investment':
                $actions[] = [
                    'text' => ['ar' => 'عرض المشاريع', 'en' => 'View Projects'],
                    'url' => route('projects.index'),
                    'icon' => 'briefcase'
                ];
                break;
                
            case 'account_approval':
                if ($user) {
                    $actions[] = [
                        'text' => ['ar' => 'الملف الشخصي', 'en' => 'Profile'],
                        'url' => route('profile'),
                        'icon' => 'user'
                    ];
                }
                break;
                
            case 'report_inquiry':
                if ($user && in_array($user->type, ['manager', 'supervisor'])) {
                    $actions[] = [
                        'text' => ['ar' => 'التقارير', 'en' => 'Reports'],
                        'url' => route('reports.platform'),
                        'icon' => 'chart-bar'
                    ];
                }
                break;
        }
        
        return $actions;
    }
    
    /**
     * اقتراحات متابعة
     */
    protected function getFollowUpSuggestions($intent, $language)
    {
        $suggestions = [
            'project_submission' => [
                'ar' => ['متطلبات المشروع', 'نماذج مشاريع', 'شروط القبول'],
                'en' => ['project requirements', 'project templates', 'acceptance criteria']
            ],
            'investment' => [
                'ar' => ['شروط الاستثمار', 'أفضل المشاريع', 'عوائد الاستثمار'],
                'en' => ['investment terms', 'best projects', 'investment returns']
            ],
            'technical_support' => [
                'ar' => ['تحديث المتصفح', 'مسح الكاش', 'الاتصال بالدعم'],
                'en' => ['browser update', 'clear cache', 'contact support']
            ]
        ];
        
        return $suggestions[$intent][$language] ?? [];
    }
    
    /**
     * حفظ المحادثة في قاعدة البيانات
     */
    protected function saveConversation($message, $response, $prediction, $user, $sessionId)
    {
        try {
            return Conversation::create([
                'user_id' => $user->id ?? null,
                'session_id' => $sessionId ?? session()->getId(),
                'message' => $message,
                'response' => $response,
                'intent' => $prediction['intent'],
                'language' => $prediction['language'],
                'confidence' => $prediction['confidence'],
                'metadata' => [
                    'probabilities' => $prediction['probabilities'] ?? [],
                    'user_type' => $user->type ?? 'guest',
                    'timestamp' => now()->toIso8601String()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to save conversation: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * رد احتياطي في حالة فشل API
     */
    protected function getFallbackResponse($message, $user)
    {
        $lang = $this->detectLanguageSimple($message);
        
        return [
            'success' => true,
            'message' => $lang == 'ar'
                ? "عذراً، الخدمة غير متاحة حالياً. يرجى المحاولة لاحقاً أو التواصل مع الدعم الفني."
                : "Sorry, service is currently unavailable. Please try again later or contact support.",
            'intent' => 'fallback',
            'confidence' => 0,
            'language' => $lang,
            'actions' => [
                [
                    'text' => ['ar' => 'الدعم الفني', 'en' => 'Support'],
                    'url' => '/support',
                    'icon' => 'headset'
                ]
            ],
            'suggestions' => []
        ];
    }
    
    /**
     * كشف اللغة بطريقة بسيطة
     */
    protected function detectLanguageSimple($text)
    {
        return preg_match('/[\x{0600}-\x{06FF}]/u', $text) ? 'ar' : 'en';
    }
    
    /**
     * عدد المشاريع المتاحة
     */
    protected function getAvailableProjectsCount()
    {
        try {
            return \App\Models\Project::where('status', 'pending')->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    /**
     * الأحداث القادمة
     */
    protected function getUpcomingEvents($lang)
    {
        try {
            $events = \App\Models\Calendar::where('start', '>', now())
                ->orderBy('start')
                ->limit(3)
                ->get();
            
            if ($events->isEmpty()) {
                return $lang == 'ar' ? 'لا توجد أحداث قادمة' : 'No upcoming events';
            }
            
            $text = '';
            foreach ($events as $event) {
                $text .= "• **{$event->title}** - " . $event->start->format('Y-m-d') . "\n";
            }
            
            return $text;
            
        } catch (\Exception $e) {
            return $lang == 'ar' ? 'لا توجد أحداث' : 'No events';
        }
    }
}