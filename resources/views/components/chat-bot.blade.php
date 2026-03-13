{{-- resources/views/components/chat-bot-vite.blade.php --}}
<div>
    <!-- زر فتح الشات -->
    <button class="chat-toggle-btn" onclick="toggleChat()" id="chatToggleBtn">
        💬
        <span class="notification-badge" id="notificationBadge">1</span>
    </button>

    <!-- نافذة الشات -->
    <div class="chat-widget" id="chatWidget">
        <!-- الهيدر -->
        <div class="chat-header">
            🤖 شات بوت المنصة اليمنية
            <div class="chat-header-small">نحن هنا لمساعدتك</div>
        </div>

        <!-- الباجات -->
        <div class="chat-badges">
            <span class="badge">🎯 100% دقة</span>
            <span class="badge">📚 50+ موضوع</span>
            <span class="badge">🇾🇪 100% يمني</span>
        </div>

        <!-- منطقة المحادثة -->
        <div class="chat-messages" id="chatMessages">
            <div class="message bot">
                <div class="message-content">
                    👋 مرحباً بك في المنصة اليمنية! أنا شات بوت ذكي جاهز للإجابة عن كل أسئلتك. ماذا تريد أن تعرف؟
                </div>
            </div>
        </div>

        <!-- الاقتراحات السريعة -->
        <div class="chat-suggestions">
            <div class="suggestions-title">🔍 اقتراحات سريعة:</div>
            <div class="suggestions-grid">
                <button class="suggestion-btn" onclick="useSuggestion('كيف أضيف مشروع')">📝 إضافة مشروع</button>
                <button class="suggestion-btn" onclick="useSuggestion('كيف أستثمر')">💰 استثمار</button>
                <button class="suggestion-btn" onclick="useSuggestion('كم نسبة الأرباح')">📈 أرباح</button>
            </div>
        </div>

        <!-- منطقة الإدخال -->
        <div class="chat-input-area">
            <input type="text" id="messageInput" placeholder="اكتب سؤالك هنا..." 
                   onkeypress="if(event.key === 'Enter') sendMessage()">
            <button class="send-btn" onclick="sendMessage()">📨</button>
        </div>
    </div>
</div>