<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ChatLog;

class ChatbotController // <- بدون extends Controller
{
    public function widget()
    {
        return view('chatbot.widget');
    }
    
    public function sendMessage(Request $request)
    {
        try {
            // تسجيل سؤال المستخدم
            $chatLog = ChatLog::create([
                'session_id' => session()->getId(),
                'user_id' => auth()->id(),
                'user_email' => auth()->user()->email ?? null,
                'user_name' => auth()->user()->name ?? 'زائر',
                'message' => $request->message,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'intent' => $this->detectIntent($request->message)
            ]);
            
            // إرسال الطلب لبايثون بوت
            $response = Http::timeout(10)->post('http://127.0.0.1:5000/chat', [
                'message' => $request->message,
                'session_id' => session()->getId()
            ]);
            
            if ($response->successful()) {
                $botResponse = $response->json('response') ?? $response->json('answer') ?? $response->json('message');
                
                // تحديث سجل المحادثة بالرد
                $chatLog->update([
                    'response' => $botResponse,
                    'resolved' => $this->checkIfResolved($botResponse)
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => $botResponse,
                    'suggestions' => $response->json('suggestions', [])
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'عذراً، حدث خطأ في الاتصال'
            ]);
            
        } catch (\Exception $e) {
            // تسجيل الخطأ في حالة فشل الاتصال
            if (isset($chatLog)) {
                $chatLog->update([
                    'response' => 'فشل الاتصال بالبوت',
                    'error' => $e->getMessage()
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'البوت غير متصل حالياً. الرجاء التأكد من تشغيل خدمة البوت أو المحاولة لاحقاً.'
            ]);
        }
    }
    
    // كشف نية المستخدم
    private function detectIntent($message)
    {
        $message = strtolower($message);
        
        $intents = [
            'مشروع' => ['مشروع', 'project', 'اضافة', 'انشاء', 'إضافة', 'إنشاء', 'مشروعي'],
            'استثمار' => ['استثمار', 'invest', 'ربح', 'money', 'أموال', 'استثماري'],
            'تسجيل' => ['تسجيل', 'login', 'دخول', 'register', 'اشتراك', 'حساب'],
            'دعم' => ['دعم', 'مساعدة', 'help', 'support', 'استفسار', 'سؤال'],
            'مشكلة' => ['مشكلة', 'خطأ', 'error', 'bug', 'عطل', 'لا يعمل'],
            'فعاليات' => ['فعاليات', 'events', 'ندوات', 'مؤتمرات', 'دورات'],
            'تقارير' => ['تقارير', 'reports', 'احصائيات', 'إحصائيات', 'تحليل'],
            'فرص عمل' => ['فرص', 'وظائف', 'عمل', 'توظيف', 'jobs'],
            'رسوم' => ['رسوم', 'أسعار', 'تكلفة', 'مصاريف', 'دفع']
        ];
        
        foreach ($intents as $intent => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    return $intent;
                }
            }
        }
        
        return 'عام';
    }
    
    private function checkIfResolved($response)
    {
        // كلمات تدل على حل المشكلة
        $resolutionWords = ['تم', 'سوف', 'سيتم', 'يمكنك', 'اضغط', 'رابط', 'أدخل', 'حسناً', 'تم بنجاح'];
        
        foreach ($resolutionWords as $word) {
            if (str_contains($response, $word)) {
                return true;
            }
        }
        
        return false;
    }
    
    public function getSuggestions()
    {
        return response()->json([
            '📝 إضافة مشروع',
            '💰 استثمار',
            '🔐 تسجيل دخول',
            '⏳ حساب معلق',
            '🛠️ مشكلة تقنية',
            '📅 فعاليات',
            '📈 أرباح',
            '📊 تقارير',
            '💼 فرص عمل',
            '💰 رسوم'
        ]);
    }
    
    // تقييم المحادثة
    public function rateChat(Request $request, $id)
    {
        $chat = ChatLog::find($id);
        if ($chat) {
            $chat->update([
                'rating' => $request->rating,
                'feedback' => $request->feedback
            ]);
            
            return response()->json(['success' => true, 'message' => 'تم تسجيل التقييم شكراً لك']);
        }
        
        return response()->json(['success' => false, 'message' => 'المحادثة غير موجودة']);
    }
    
    // جلب سجل المحادثات للمستخدم
    public function getChatHistory()
    {
        $chats = ChatLog::where('session_id', session()->getId())
                        ->orWhere('user_id', auth()->id())
                        ->orderBy('created_at', 'desc')
                        ->limit(50)
                        ->get();
        
        return response()->json($chats);
    }
    
    // تصدير المحادثة
    public function exportChat($id)
    {
        $chat = ChatLog::find($id);
        if (!$chat) {
            return response()->json(['success' => false, 'message' => 'المحادثة غير موجودة']);
        }
        
        $text = "محادثة مع البوت اليمني\n";
        $text .= "====================\n\n";
        $text .= "السؤال: {$chat->message}\n";
        $text .= "الرد: {$chat->response}\n";
        $text .= "التاريخ: {$chat->created_at}\n";
        
        return response($text)
                ->header('Content-Type', 'text/plain')
                ->header('Content-Disposition', 'attachment; filename="chat.txt"');
    }
}