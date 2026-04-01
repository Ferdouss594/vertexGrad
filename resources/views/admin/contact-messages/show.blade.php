@extends('layouts.app')

@section('title', 'Contact Message Details')

@section('content')
<style>
    .contact-message-show-page {
        padding-bottom: 28px;
    }

    .contact-message-show-page .page-header-card {
        background: linear-gradient(135deg, #0d1b4c 0%, #1b00ff 100%);
        border-radius: 20px;
        padding: 28px 30px;
        color: #fff;
        box-shadow: 0 12px 30px rgba(27, 0, 255, 0.18);
    }

    .contact-message-show-page .page-header-card h3 {
        margin: 0;
        font-weight: 700;
        color: #fff;
    }

    .contact-message-show-page .page-header-card p {
        margin: 8px 0 0;
        opacity: 0.9;
    }

    .contact-message-show-page .content-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    .contact-message-show-page .content-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef2f7;
    }

    .contact-message-show-page .content-card-header h5 {
        margin: 0;
        font-weight: 700;
        color: #0f172a;
    }

    .contact-message-show-page .content-card-body {
        padding: 24px;
    }

    .contact-message-show-page .info-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: 6px;
    }

    .contact-message-show-page .info-value {
        font-size: 14px;
        font-weight: 600;
        color: #0f172a;
        word-break: break-word;
    }

    .contact-message-show-page .message-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 18px;
        font-size: 14px;
        line-height: 1.8;
        color: #1e293b;
        white-space: pre-line;
    }

    .contact-message-show-page .reply-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 14px;
    }

    .contact-message-show-page .reply-box:last-child {
        margin-bottom: 0;
    }

    .contact-message-show-page .reply-meta {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 8px;
        font-weight: 600;
        line-height: 1.6;
    }

    .contact-message-show-page .reply-text {
        font-size: 14px;
        color: #0f172a;
        line-height: 1.8;
        white-space: pre-line;
    }

    .contact-message-show-page .badge-soft {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .2px;
        white-space: nowrap;
    }

    .contact-message-show-page .badge-status-new {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .contact-message-show-page .badge-status-progress {
        background: #fff7ed;
        color: #c2410c;
    }

    .contact-message-show-page .badge-status-replied {
        background: #ecfdf5;
        color: #15803d;
    }

    .contact-message-show-page .badge-status-closed {
        background: #f1f5f9;
        color: #475569;
    }

    .contact-message-show-page .badge-type-guest {
        background: #f8fafc;
        color: #475569;
    }

    .contact-message-show-page .badge-type-student {
        background: #eef2ff;
        color: #4338ca;
    }

    .contact-message-show-page .badge-type-investor {
        background: #ecfeff;
        color: #0f766e;
    }

    .contact-message-show-page .form-control,
    .contact-message-show-page .form-select {
        border-radius: 12px;
        min-height: 44px;
        border: 1px solid #dbe4f0;
        box-shadow: none;
    }

    .contact-message-show-page textarea.form-control {
        min-height: 180px;
    }

    .contact-message-show-page .btn-soft {
        border-radius: 12px;
        font-weight: 700;
        padding: 10px 16px;
        text-decoration: none;
        border: 1px solid #dbe4f0;
        background: #fff;
        color: #0f172a;
    }

    .contact-message-show-page .btn-soft:hover {
        text-decoration: none;
        color: #0f172a;
        background: #f8fafc;
    }

    .contact-message-show-page .right-stack > .content-card + .content-card {
        margin-top: 24px;
    }

    .contact-message-show-page .page-main-row {
        margin-bottom: 24px;
    }

    .contact-message-show-page .template-helper {
        font-size: 12px;
        color: #64748b;
        margin-top: 8px;
        line-height: 1.6;
    }

    .contact-message-show-page .template-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
</style>

@php
    $statusClass = match($contactMessage->status) {
        'new' => 'badge-status-new',
        'in_progress' => 'badge-status-progress',
        'replied' => 'badge-status-replied',
        'closed' => 'badge-status-closed',
        default => 'badge-status-closed',
    };

    $senderTypeClass = match($contactMessage->sender_type) {
        'student' => 'badge-type-student',
        'investor' => 'badge-type-investor',
        default => 'badge-type-guest',
    };

    $defaultTemplateKey = match($contactMessage->subject) {
        'academic' => 'academic_ack',
        'investor' => 'investor_ack',
        'support' => 'support_ack',
        default => 'general_ack',
    };
@endphp

<div class="pd-ltr-20 xs-pd-20-10 contact-message-show-page">
    <div class="min-height-200px">

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm" style="border-radius: 14px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm" style="border-radius: 14px;">
                <ul class="mb-0 pl-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="page-header-card mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 15px;">
                <div>
                    <h3>Contact Message #{{ $contactMessage->id }}</h3>
                    <p>Review, reply, and update the inquiry from the management panel professionally.</p>
                </div>

                <div class="d-flex flex-wrap" style="gap: 10px;">
                    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-light btn-soft">
                        <i class="fa fa-arrow-left mr-1"></i> Back to Messages
                    </a>
                </div>
            </div>
        </div>

        <div class="row page-main-row align-items-start">
            <div class="col-xl-8 mb-4">
                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h5>Message Details</h5>
                    </div>

                    <div class="content-card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="info-label">Sender Name</div>
                                <div class="info-value">{{ $contactMessage->name }}</div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="info-label">Email Address</div>
                                <div class="info-value">{{ $contactMessage->email }}</div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="info-label">Subject</div>
                                <div class="info-value">{{ $contactMessage->subject_label }}</div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="info-label">Sender Type</div>
                                <div class="info-value">
                                    <span class="badge-soft {{ $senderTypeClass }}">
                                        {{ $contactMessage->sender_type_label }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="info-label">Current Status</div>
                                <div class="info-value">
                                    <span class="badge-soft {{ $statusClass }}">
                                        {{ $contactMessage->status_label }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="info-label">Submitted At</div>
                                <div class="info-value">{{ $contactMessage->created_at?->format('Y-m-d h:i A') }}</div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="info-label">Frontend User ID</div>
                                <div class="info-value">{{ $contactMessage->sender_user_id ?? 'Guest / None' }}</div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="info-label">IP Address</div>
                                <div class="info-value">{{ $contactMessage->ip_address ?? 'N/A' }}</div>
                            </div>

                            <div class="col-12">
                                <div class="info-label">Message Content</div>
                                <div class="message-box">{{ $contactMessage->message }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-card mb-4">
                    <div class="content-card-header">
                        <h5>Reply History</h5>
                    </div>

                    <div class="content-card-body">
                        @forelse($contactMessage->replies as $reply)
                            <div class="reply-box">
                                <div class="reply-meta">
                                    Replied by {{ $reply->admin?->name ?? 'System User' }}
                                    • {{ $reply->sent_at?->format('Y-m-d h:i A') ?? $reply->created_at?->format('Y-m-d h:i A') }}
                                    • Channel: {{ ucfirst($reply->channel) }}
                                    • {{ $reply->is_sent ? 'Sent' : 'Draft / Not Sent' }}
                                </div>
                                <div class="reply-text">{{ $reply->reply_message }}</div>
                            </div>
                        @empty
                            <div class="text-muted">No replies have been sent yet.</div>
                        @endforelse
                    </div>
                </div>

                <div class="content-card">
                    <div class="content-card-header">
                        <h5>Internal Notes</h5>
                    </div>

                    <div class="content-card-body">
                        <form action="{{ route('admin.contact-messages.notes.store', $contactMessage) }}" method="POST" class="mb-4">
                            @csrf

                            <div class="mb-3">
                                <label for="note" class="info-label" style="display:block;">Add Internal Note</label>
                                <textarea
                                    id="note"
                                    name="note"
                                    class="form-control"
                                    placeholder="Write an internal note..."
                                    required
                                    style="min-height: 120px;"
                                >{{ old('note') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-dark w-100" style="border-radius: 12px; font-weight: 700;">
                                <i class="fa fa-sticky-note mr-1"></i> Save Internal Note
                            </button>
                        </form>

                        @forelse($contactMessage->notes as $note)
                            <div class="reply-box">
                                <div class="reply-meta">
                                    Note by {{ $note->admin?->name ?? 'System User' }}
                                    • {{ $note->created_at?->format('Y-m-d h:i A') }}
                                </div>
                                <div class="reply-text">{{ $note->note }}</div>
                            </div>
                        @empty
                            <div class="text-muted">No internal notes yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-xl-4 mb-4">
                <div class="right-stack">
                    <div class="content-card">
                        <div class="content-card-header">
                            <h5>Update Status</h5>
                        </div>

                        <div class="content-card-body">
                            <form action="{{ route('admin.contact-messages.update-status', $contactMessage) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <div class="mb-3">
                                    <label for="status" class="info-label" style="display:block;">Select Status</label>
                                    <select id="status" name="status" class="form-select" required>
                                        <option value="new" {{ $contactMessage->status === 'new' ? 'selected' : '' }}>New</option>
                                        <option value="in_progress" {{ $contactMessage->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="replied" {{ $contactMessage->status === 'replied' ? 'selected' : '' }}>Replied</option>
                                        <option value="closed" {{ $contactMessage->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary w-100" style="border-radius: 12px; font-weight: 700;">
                                    <i class="fa fa-save mr-1"></i> Save Status
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="content-card">
                        <div class="content-card-header">
                            <h5>Send Reply</h5>
                        </div>

                        <div class="content-card-body">
                            <form action="{{ route('admin.contact-messages.reply', $contactMessage) }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="reply_template" class="info-label" style="display:block;">Quick Reply Template</label>
                                    <select id="reply_template" class="form-select">
                                        <option value="">Select a template</option>
                                        <option value="academic_ack" {{ $defaultTemplateKey === 'academic_ack' ? 'selected' : '' }}>Academic Inquiry Acknowledgement</option>
                                        <option value="investor_ack" {{ $defaultTemplateKey === 'investor_ack' ? 'selected' : '' }}>Investor Inquiry Acknowledgement</option>
                                        <option value="support_ack" {{ $defaultTemplateKey === 'support_ack' ? 'selected' : '' }}>Support Response</option>
                                        <option value="general_ack" {{ $defaultTemplateKey === 'general_ack' ? 'selected' : '' }}>General Response</option>
                                    </select>
                                    <div class="template-helper">
                                        Choose a professional reply template, then review and edit the message before sending.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="template-actions">
                                        <button type="button" id="apply_template_btn" class="btn btn-outline-primary btn-sm" style="border-radius: 10px; font-weight: 700;">
                                            Apply Template
                                        </button>

                                        <button type="button" id="clear_template_btn" class="btn btn-outline-secondary btn-sm" style="border-radius: 10px; font-weight: 700;">
                                            Clear
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="reply_message" class="info-label" style="display:block;">Reply Message</label>
                                    <textarea
                                        id="reply_message"
                                        name="reply_message"
                                        class="form-control"
                                        placeholder="Write your reply here..."
                                        required
                                    >{{ old('reply_message') }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-success w-100" style="border-radius: 12px; font-weight: 700;">
                                    <i class="fa fa-paper-plane mr-1"></i> Send Reply by Email
                                </button>
                            </form>

                            <hr>

                            <div class="text-muted" style="font-size: 13px; line-height: 1.7;">
                                Sending a reply will save it in the reply history and automatically update the message status to <strong>Replied</strong>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const templateSelect = document.getElementById('reply_template');
    const applyBtn = document.getElementById('apply_template_btn');
    const clearBtn = document.getElementById('clear_template_btn');
    const replyTextarea = document.getElementById('reply_message');

    if (!templateSelect || !applyBtn || !clearBtn || !replyTextarea) return;

    const templates = {
        academic_ack: `Hello {{ $contactMessage->name }},

Thank you for contacting VertexGrad regarding your academic submission.

We have received your inquiry and our team will review it shortly. If additional information is needed, we will contact you.

Best regards,
VertexGrad Team`,

        investor_ack: `Hello {{ $contactMessage->name }},

Thank you for your interest in VertexGrad and for reaching out regarding investment opportunities.

We have received your inquiry and the management team will review it shortly. We will contact you if any additional details are needed.

Best regards,
VertexGrad Team`,

        support_ack: `Hello {{ $contactMessage->name }},

Thank you for contacting VertexGrad support.

We have received your message and will review the issue as soon as possible. If needed, our team will follow up with you for further clarification.

Best regards,
VertexGrad Team`,

        general_ack: `Hello {{ $contactMessage->name }},

Thank you for reaching out to VertexGrad.

We have received your message and will get back to you shortly.

Best regards,
VertexGrad Team`
    };

    function applySelectedTemplate() {
        const selected = templateSelect.value;

        if (selected && templates[selected]) {
            replyTextarea.value = templates[selected];
            replyTextarea.focus();
        }
    }

    applyBtn.addEventListener('click', function () {
        applySelectedTemplate();
    });

    templateSelect.addEventListener('change', function () {
        applySelectedTemplate();
    });

    clearBtn.addEventListener('click', function () {
        replyTextarea.value = '';
        replyTextarea.focus();
    });

    if (!replyTextarea.value.trim() && templateSelect.value) {
        applySelectedTemplate();
    }
});
</script>
@endpush