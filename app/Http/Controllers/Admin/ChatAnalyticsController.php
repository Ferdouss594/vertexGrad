<?php
// app/Http/Controllers/Admin/ChatAnalyticsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatAnalyticsController extends Controller
{
    public function index()
    {
        // إحصائيات عامة
        $stats = [
            'total_chats' => DB::table('chat_logs')->count(),
            'chats_today' => DB::table('chat_logs')->whereDate('created_at', today())->count(),
            'avg_rating' => DB::table('chat_logs')->whereNotNull('rating')->avg('rating') ?? 0,
            'resolved_rate' => $this->calculateResolvedRate(),
        ];
        
        // أكثر الأسئلة شيوعاً
        $commonQuestions = DB::table('chat_logs')
            ->select('message', DB::raw('count(*) as count'))
            ->groupBy('message')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
        
        // محادثات غير محلولة
        $unresolvedChats = DB::table('chat_logs')
            ->where('response', 'like', '%لم أتمكن%')
            ->orWhere('response', 'like', '%عذراً%')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
        
        // آخر المحادثات
        $recentChats = DB::table('chat_logs')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();
        
        return view('admin.chat.analytics', compact(
            'stats', 
            'commonQuestions', 
            'unresolvedChats', 
            'recentChats'
        ));
    }
    
    private function calculateResolvedRate()
    {
        $total = DB::table('chat_logs')->count();
        if ($total == 0) return 0;
        
        $unresolved = DB::table('chat_logs')
            ->where('response', 'like', '%لم أتمكن%')
            ->orWhere('response', 'like', '%عذراً%')
            ->count();
        
        return (($total - $unresolved) / $total) * 100;
    }
    
    public function export()
    {
        $chats = DB::table('chat_logs')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $filename = "chat_analytics_" . date('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];
        
        $callback = function() use ($chats) {
            $file = fopen('php://output', 'w');
            
            // رؤوس الأعمدة
            fputcsv($file, ['ID', 'المستخدم', 'الرسالة', 'الرد', 'التقييم', 'التاريخ']);
            
            foreach ($chats as $chat) {
                fputcsv($file, [
                    $chat->id,
                    $chat->user_name ?? 'زائر',
                    $chat->message,
                    $chat->response,
                    $chat->rating ?? '-',
                    $chat->created_at
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}