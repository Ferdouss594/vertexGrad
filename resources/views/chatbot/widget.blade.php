<!-- chatbot widget -->
<div class="chatbot-widget" id="chatbotWidget" style="display: none;">
    <div class="chatbot-header">
        <div class="chatbot-title">
            <i class="fas fa-robot"></i>
            <span>🇾🇪 شات بوت المنصة اليمنية</span>
        </div>
        <button class="chatbot-close" onclick="toggleChatbot()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <div class="chatbot-header-info">
        <div class="info-badges">
            <span class="badge">📚 50+ موضوع</span>
            <span class="badge">⏰ 24/7 دعم</span>
            <span class="badge">🎯 100% دقة</span>
        </div>
    </div>
    
    <div class="chatbot-messages" id="chatMessages">
        <div class="message bot">
            <div class="message-content">
                👋 مرحباً بك في المنصة اليمنية! أنا شات بوت ذكي جاهز للإجابة عن كل أسئلتك. ماذا تريد أن تعرف؟
            </div>
            <div class="message-time">
                {{ now()->format('h:i A') }}
            </div>
        </div>
    </div>
    
    <div class="chatbot-suggestions" id="chatSuggestions">
        <button class="suggestion-btn" onclick="useSuggestion('📝 إضافة مشروع')">📝 إضافة مشروع</button>
        <button class="suggestion-btn" onclick="useSuggestion('💰 استثمار')">💰 استثمار</button>
        <button class="suggestion-btn" onclick="useSuggestion('🔐 تسجيل دخول')">🔐 تسجيل دخول</button>
        <button class="suggestion-btn" onclick="useSuggestion('⏳ حساب معلق')">⏳ حساب معلق</button>
        <button class="suggestion-btn" onclick="useSuggestion('🛠️ مشكلة تقنية')">🛠️ مشكلة تقنية</button>
        <button class="suggestion-btn" onclick="useSuggestion('📅 فعاليات')">📅 فعاليات</button>
        <button class="suggestion-btn" onclick="useSuggestion('📈 أرباح')">📈 أرباح</button>
        <button class="suggestion-btn" onclick="useSuggestion('📊 تقارير')">📊 تقارير</button>
        <button class="suggestion-btn" onclick="useSuggestion('💼 فرص عمل')">💼 فرص عمل</button>
        <button class="suggestion-btn" onclick="useSuggestion('💰 رسوم')">💰 رسوم</button>
    </div>
    
    <div class="chatbot-input">
        <input type="text" 
               id="chatInput" 
               placeholder="اكتب سؤالك هنا..."
               onkeypress="handleKeyPress(event)">
        <button onclick="sendMessage()">
            <i class="fas fa-paper-plane"></i> إرسال
        </button>
    </div>
    
    <div class="chatbot-footer">
        <small>🇾🇪 منصة يمنية - جميع الحقوق محفوظة © 2026 | للدعم: 777123456</small>
    </div>
</div>

<!-- زر فتح الشات -->
<button class="chatbot-toggle-btn" onclick="toggleChatbot()">
    <i class="fas fa-comment-dots"></i>
    <span class="chatbot-notification" id="chatNotification">1</span>
</button>

<style>
.chatbot-toggle-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    font-size: 24px;
    z-index: 9999;
    transition: transform 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chatbot-toggle-btn:hover {
    transform: scale(1.1);
}

.chatbot-widget {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 380px;
    height: 600px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    z-index: 9999;
    overflow: hidden;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    direction: rtl;
}

.chatbot-header {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chatbot-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: bold;
    font-size: 16px;
}

.chatbot-close {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    font-size: 18px;
}

.chatbot-header-info {
    padding: 10px 15px;
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

.info-badges {
    display: flex;
    justify-content: space-around;
    gap: 5px;
}

.badge {
    background: #e9ecef;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    color: #495057;
}

.chatbot-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f5f5f5;
}

.message {
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
}

.message.user {
    align-items: flex-start;
}

.message.bot {
    align-items: flex-end;
}

.message-content {
    max-width: 80%;
    padding: 12px 15px;
    border-radius: 15px;
    background: white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    text-align: right;
    font-size: 14px;
    line-height: 1.5;
    white-space: pre-wrap;
}

.message.user .message-content {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
}

.message-time {
    font-size: 11px;
    color: #999;
    margin-top: 5px;
    margin-right: 5px;
}

.chatbot-suggestions {
    padding: 10px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    background: white;
    border-top: 1px solid #eee;
    max-height: 100px;
    overflow-y: auto;
}

.suggestion-btn {
    background: #f0f0f0;
    border: none;
    padding: 8px 15px;
    border-radius: 20px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s;
    white-space: nowrap;
}

.suggestion-btn:hover {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
}

.chatbot-input {
    display: flex;
    padding: 15px;
    background: white;
    border-top: 1px solid #eee;
    gap: 10px;
}

.chatbot-input input {
    flex: 1;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 25px;
    outline: none;
    font-size: 14px;
    text-align: right;
}

.chatbot-input button {
    padding: 0 20px;
    border-radius: 25px;
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
    border: none;
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: transform 0.3s;
}

.chatbot-input button:hover {
    transform: scale(1.05);
}

.chatbot-footer {
    padding: 10px;
    text-align: center;
    background: #f8f9fa;
    color: #6c757d;
    font-size: 11px;
    border-top: 1px solid #dee2e6;
}

.chatbot-notification {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}

.typing-indicator {
    display: flex;
    gap: 5px;
    padding: 10px;
}

.typing-indicator span {
    width: 8px;
    height: 8px;
    background: #999;
    border-radius: 50%;
    animation: typing 1s infinite ease-in-out;
}

.typing-indicator span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-indicator span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% { transform: translateY(0); }
    30% { transform: translateY(-10px); }
}

/* تنسيق الروابط */
.message-content a {
    color: inherit;
    text-decoration: underline;
}

.message.user .message-content a {
    color: white;
}

/* تنسيق القوائم */
.message-content ul, 
.message-content ol {
    margin: 5px 0;
    padding-right: 20px;
}

.message-content li {
    margin: 3px 0;
}
</style>

<script>
// إضافة Font Awesome
(function() {
    if (!document.querySelector('link[href*="font-awesome"]')) {
        const fontAwesome = document.createElement('link');
        fontAwesome.rel = 'stylesheet';
        fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css';
        document.head.appendChild(fontAwesome);
    }
})();

// متغيرات الشات
let isOpen = false;
let messageCount = 1;
const BOT_API_URL = 'http://127.0.0.1:5000/chat'; // رابط البوت

// دالة فتح/غلق الشات
window.toggleChatbot = function() {
    const widget = document.getElementById('chatbotWidget');
    const btn = document.querySelector('.chatbot-toggle-btn');
    
    if (isOpen) {
        widget.style.display = 'none';
        btn.style.display = 'flex';
    } else {
        widget.style.display = 'flex';
        btn.style.display = 'none';
    }
    
    isOpen = !isOpen;
};

// استخدام اقتراح
window.useSuggestion = function(text) {
    const input = document.getElementById('chatInput');
    if (input) {
        input.value = text;
        sendMessage();
    }
};

// إرسال رسالة للبوت الحقيقي
window.sendMessage = function() {
    const input = document.getElementById('chatInput');
    if (!input) return;
    
    const message = input.value.trim();
    if (message === '') return;
    
    // إضافة رسالة المستخدم
    addMessage(message, 'user');
    input.value = '';
    
    // إظهار مؤشر الكتابة
    showTypingIndicator();
    
    // إرسال للبوت
    fetch(BOT_API_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ 
            message: message,
            session_id: getSessionId() // لإبقاء المحادثة مستمرة
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        hideTypingIndicator();
        
        // البوت اليمني يرجع {response: "الرد"} أو {answer: "الرد"}
        const botResponse = data.response || data.answer || data.message || 'عذراً، لم أفهم سؤالك';
        addMessage(botResponse, 'bot');
    })
    .catch(error => {
        console.error('Error:', error);
        hideTypingIndicator();
        addMessage('❌ عذراً، البوت غير متصل. الرجاء التأكد من تشغيل البوت أو المحاولة لاحقاً.', 'bot');
    });
};

// إضافة رسالة للشات
function addMessage(text, sender) {
    const messages = document.getElementById('chatMessages');
    if (!messages) return;
    
    const time = new Date().toLocaleTimeString('ar-EG', { 
        hour: '2-digit', 
        minute: '2-digit' 
    });
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${sender}`;
    messageDiv.innerHTML = `
        <div class="message-content">${formatMessage(text)}</div>
        <div class="message-time">${time}</div>
    `;
    
    messages.appendChild(messageDiv);
    messages.scrollTop = messages.scrollHeight;
}

// تنسيق الرسالة (تحويل الروابط والنصوص)
function formatMessage(text) {
    if (!text) return '';
    
    // تحويل النص للـ HTML مع الحفاظ على التنسيق
    let formatted = escapeHtml(text);
    
    // تحويل الروابط إلى وصلات
    formatted = formatted.replace(
        /(https?:\/\/[^\s]+)/g, 
        '<a href="$1" target="_blank">$1</a>'
    );
    
    // تحويل السطور الجديدة
    formatted = formatted.replace(/\n/g, '<br>');
    
    return formatted;
}

// إظهار مؤشر الكتابة
function showTypingIndicator() {
    const messages = document.getElementById('chatMessages');
    if (!messages) return;
    
    const indicator = document.createElement('div');
    indicator.id = 'typingIndicator';
    indicator.className = 'message bot';
    indicator.innerHTML = `
        <div class="message-content">
            <div class="typing-indicator">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    `;
    messages.appendChild(indicator);
    messages.scrollTop = messages.scrollHeight;
}

// إخفاء مؤشر الكتابة
function hideTypingIndicator() {
    const indicator = document.getElementById('typingIndicator');
    if (indicator) {
        indicator.remove();
    }
}

// معالجة الضغط على Enter
window.handleKeyPress = function(event) {
    if (event.key === 'Enter') {
        sendMessage();
    }
};

// الحصول على Session ID للمحادثة
function getSessionId() {
    let sessionId = localStorage.getItem('chatSessionId');
    if (!sessionId) {
        sessionId = 'session_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
        localStorage.setItem('chatSessionId', sessionId);
    }
    return sessionId;
}

// دالة لحماية الـ HTML من الحقن
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// التحقق من اتصال البوت
function checkBotConnection() {
    fetch('http://127.0.0.1:5000/health') // افترض أن البوت لديه نقطة للتحقق
        .then(response => {
            if (response.ok) {
                console.log('✅ البوت متصل');
            } else {
                console.log('⚠️ البوت غير متصل');
            }
        })
        .catch(() => {
            console.log('⚠️ البوت غير متصل');
        });
}

// تهيئة الشات
document.addEventListener('DOMContentLoaded', function() {
    console.log('🇾🇪 شات بوت المنصة اليمنية جاهز');
    checkBotConnection();
});
// بعد إضافة رد البوت
function addMessage(text, sender) {
    // الكود الموجود...
    
    // إذا كان الرد من البوت، أضيفي تقييم
    if (sender === 'bot' && !text.includes('مؤشر الكتابة')) {
        setTimeout(() => {
            addRatingButtons(lastMessageId);
        }, 500);
    }
}

function addRatingButtons(messageId) {
    const messages = document.getElementById('chatMessages');
    const ratingDiv = document.createElement('div');
    ratingDiv.className = 'message-rating';
    ratingDiv.innerHTML = `
        <div class="rating-buttons">
            <span>هل كان الرد مفيداً؟</span>
            <button onclick="rateChat(${messageId}, 5)">⭐⭐⭐⭐⭐</button>
            <button onclick="rateChat(${messageId}, 4)">⭐⭐⭐⭐</button>
            <button onclick="rateChat(${messageId}, 3)">⭐⭐⭐</button>
            <button onclick="rateChat(${messageId}, 2)">⭐⭐</button>
            <button onclick="rateChat(${messageId}, 1)">⭐</button>
        </div>
    `;
    messages.appendChild(ratingDiv);
}

function rateChat(chatId, rating) {
    fetch(`/chat/rate/${chatId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ rating: rating })
    });
}
</script>