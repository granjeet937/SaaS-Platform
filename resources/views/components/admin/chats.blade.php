<style>
    /* ===================== CHAT MODAL ===================== */
    .chat-modal {
        border-radius: 12px;
        overflow: hidden;
    }

    /* ===================== HEADER ===================== */
    .chat-header {
        color: #fff;
    }

    .chat-header h6 {
        font-size: 15px;
        font-weight: 600;
    }

    .chat-header small {
        font-size: 12px;
        color: #d9fdd3;
    }

    /* ===================== CHAT BODY ===================== */
    .chat-body {
        display: flex;
        flex-direction: column;
        gap: 10px;
        height: 380px;
        overflow-y: auto;
        background: #efeae2;
        padding: 15px;
    }

    /* ===================== MESSAGE BUBBLES ===================== */
    .chat-message {
        max-width: 75%;
        padding: 8px 12px;
        border-radius: 8px;
        margin-bottom: 8px;
        font-size: 14px;
        line-height: 1.4;
        word-wrap: break-word;
    }

    /* Sent (Green) */
    .chat-message.sent {
        background: #d9fdd3;
        align-self: flex-end;
        border-top-right-radius: 0;
    }

    /* Received (White) */
    .chat-message.received {
        background: #ffffff;
        align-self: flex-start;
        border-top-left-radius: 0;
    }

    .chat-message p {
        margin: 0;
    }

    /* Time */
    .chat-time {
        font-size: 11px;
        color: #667781;
        margin-top: 4px;
        text-align: right;
    }

    .chat-message.received .chat-time {
        text-align: left;
    }

    /* ===================== FOOTER ===================== */
    .chat-footer {
        border-top: 1px solid #ddd;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
    }

    .chat-footer input {
        flex: 1;
        border-radius: 20px;
        padding: 10px 15px;
    }

    .chat-footer button {
        border-radius: 50%;
        width: 40px;
        height: 40px;
    }

    /* ===================== USER LIST ===================== */
    .chat-user {
        display: flex;
        align-items: center;
        padding: 10px;
        gap: 10px;
        cursor: pointer;
    }

    .chat-user:hover {
        background: #f0f2f5;
    }

    .chat-user img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .chat-body {
        overflow-y: scroll;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .chat-body::-webkit-scrollbar {
        display: none;
    }

    /* ===== DATE SEPARATOR (WhatsApp style) ===== */
    .chat-date {
        text-align: center;
        margin: 15px 0;
        font-size: 12px;
        color: #667781;
        position: relative;
    }

    .chat-date::before,
    .chat-date::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 30%;
        height: 1px;
        background: #ddd;
    }

    .chat-date::before {
        left: 0;
    }

    .chat-date::after {
        right: 0;
    }

    /* ===== MESSAGE TICKS ===== */
    .chat-tick {
        font-size: 12px;
        margin-left: 6px;
        color: #8696a0;
    }

    .chat-tick.read {
        color: #34b7f1;
        /* WhatsApp blue tick */
    }

    .chat-image {
        max-width: 210px;
        max-height: 210px;
        width: auto;
        height: auto;
        border-radius: 5px;
        object-fit: cover;
    }

    @media (max-width: 576px) {
        #chatModal .modal-dialog {
            margin: 0;
            max-width: 100%;
            height: 100%;
        }

        #chatModal .modal-content {
            height: 100vh;
            border-radius: 0;
        }

        #chatModal .chat-body {
            height: calc(100vh - 130px);
            overflow-y: auto;
        }
    }

    .new-msg-indicator {
        position: absolute;
        bottom: 75px;
        right: 15px;
        background: #25d366;
        color: #fff;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        z-index: 999;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .new-msg-indicator span {
        font-weight: bold;
    }
</style>

<div id="right-sidebar" class="settings-panel">
    <i class="settings-close fa fa-times"></i>
    <ul class="nav nav-tabs" id="setting-panel" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="todo-tab" data-toggle="tab" href="#todo-section" role="tab"
                aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="chats-tab" data-toggle="tab" href="#chats-section" role="tab"
                aria-controls="chats-section">CHATS</a>
        </li>
    </ul>
    <div class="tab-content" id="setting-content">
        <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel"
            aria-labelledby="todo-section">
            <div class="add-items d-flex px-3 mb-0">
                <form class="form w-100">
                    <div class="form-group d-flex">
                        <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                        <button type="submit" class="add btn btn-primary todo-list-add-btn"
                            id="add-task-todo">Add</button>
                    </div>
                </form>
            </div>
            <div class="list-wrapper px-3">
                <ul class="d-flex flex-column-reverse todo-list">
                    <li>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="checkbox" type="checkbox">
                                Team review meeting at 3.00 PM
                            </label>
                        </div>
                        <i class="remove fa fa-times-circle"></i>
                    </li>
                    <li>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="checkbox" type="checkbox">
                                Prepare for presentation
                            </label>
                        </div>
                        <i class="remove fa fa-times-circle"></i>
                    </li>
                    <li>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="checkbox" type="checkbox">
                                Resolve all the low priority tickets due today
                            </label>
                        </div>
                        <i class="remove fa fa-times-circle"></i>
                    </li>
                    <li class="completed">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="checkbox" type="checkbox" checked>
                                Schedule meeting for next week
                            </label>
                        </div>
                        <i class="remove fa fa-times-circle"></i>
                    </li>
                    <li class="completed">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="checkbox" type="checkbox" checked>
                                Project review
                            </label>
                        </div>
                        <i class="remove fa fa-times-circle"></i>
                    </li>
                </ul>
            </div>
            <div class="events py-4 border-bottom px-3">
                <div class="wrapper d-flex mb-2">
                    <i class="fa fa-times-circle text-primary mr-2"></i>
                    <span>Feb 11 2018</span>
                </div>
                <p class="mb-0 font-weight-thin text-gray">Creating component page</p>
                <p class="text-gray mb-0">build a js based app</p>
            </div>
            <div class="events pt-4 px-3">
                <div class="wrapper d-flex mb-2">
                    <i class="fa fa-times-circle text-primary mr-2"></i>
                    <span>Feb 7 2018</span>
                </div>
                <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
                <p class="text-gray mb-0 ">Call Sarah Graves</p>
            </div>
        </div>
        <!-- To do section tab ends -->
        <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
            <div class="d-flex align-items-center justify-content-between border-bottom">
                <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
                <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 font-weight-normal">See
                    All</small>
            </div>
            <ul class="chat-list">
                @forelse ($users as $user)
                    <li class="list chat-user" data-email="{{ $user->email }}" data-name="{{ $user->fullname }}"
                        data-image="{{ asset($user->image ?? 'images/default-user.png') }}">

                        <div class="profile">
                            <img src="{{ asset($user->image ?? 'images/default-user.png') }}" alt="image">
                            <span class="online"></span>
                        </div>

                        <div class="info">
                            <p>{{ $user->fullname }}</p>
                            <p>{{ ucwords($user->role) }}</p>
                        </div>

                        <small class="text-muted my-auto">Admin</small>
                    </li>
                @empty
                    <li class="text-center text-muted p-3">No admin users found</li>
                @endforelse
            </ul>
        </div>
        <!-- chat tab ends -->
    </div>
</div>

<div class="modal fade" id="chatModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-top modal-md modal-fullscreen-sm-down">
        <div class="modal-content chat-modal h-100">
            <!-- Header -->
            <div class="modal-header chat-header bgcolor">
                <div class="d-flex align-items-center gap-2">
                    <img id="chatUserImage" class="rounded-circle" width="40" height="40">
                    <div>
                        <h6 class="mb-0" id="chatUserName"></h6>
                        <small>Online</small>
                    </div>
                </div>

                <!-- 3 Dot Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-sm text-white p-0" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v fs-5"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" id="closeChat">
                                <i class="fas fa-times me-2"></i> Close chat
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" href="javascript:void(0)" id="deleteAllChat">
                                <i class="fas fa-trash me-2"></i> Delete all chat
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <input type="hidden" id="conversationId">
            <!-- Messages -->
            <div class="modal-body chat-body flex-grow-1" id="chatMessages"></div>
            <div id="newMsgIndicator" class="new-msg-indicator d-none">
                <span id="newMsgCount">1</span> New message ↓
            </div>

            <!-- Footer -->
            <div class="modal-footer chat-footer bgcolor">
                <input type="text" class="form-control" id="chatInput" placeholder="Type a message">
                <button class="btn btn-primary" id="sendBtn">
                    <i class="fa fa-paper-plane" style="margin-left: -6px; font-size: 1.5rem;"></i>
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const closeBtn = document.getElementById('closeChat');
        const deleteBtn = document.getElementById('deleteAllChat');

        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                const modalEl = document.getElementById('chatModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            });
        }

        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {

                const conversationId = document.getElementById('conversationId').value;
                if (!conversationId) return;

                if (!confirm('Are you sure you want to delete all chats?')) return;

                fetch('{{ route('chat.deleteAll') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            conversation_id: conversationId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('chatMessages').innerHTML = '';
                        }
                    });
            });
        }

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatModalEl = document.getElementById('chatModal');
        chatModalEl.addEventListener('shown.bs.modal', function() {

            const closeBtn = document.querySelector('.settings-close');

            if (closeBtn) {
                closeBtn.click();
            } else {}
        });
    });
</script>

<script>
    let activeConversationId = null;

    document.querySelectorAll('.chat-user').forEach(user => {
        user.addEventListener('click', function() {

            const userEmail = this.dataset.email;
            const adminName = this.dataset.name;
            const adminImage = this.dataset.image;

            document.getElementById('chatUserName').innerText = adminName;
            document.getElementById('chatUserImage').src = adminImage;

            fetch('/admin/chat/start', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_email: userEmail
                    })
                })
                .then(res => res.json())
                .then(data => {
                    activeConversationId = data.id;
                    document.getElementById('conversationId').value = data.id;
                    document.getElementById('chatMessages').innerHTML = '';
                    loadMessages(data.id);
                });

            new bootstrap.Modal(document.getElementById('chatModal')).show();
        });
    });

    document.getElementById('sendBtn').addEventListener('click', function() {

        const input = document.getElementById('chatInput');
        const message = input.value.trim();

        if (!message || !activeConversationId) return;

        document.getElementById('chatMessages').innerHTML += `
            <div class="chat-message sent">
                <p>${message}</p>
                <div class="chat-time">${getCurrentTime()}</div>
            </div>
        `;

        const chatBody = document.getElementById('chatMessages');
        chatBody.scrollTop = chatBody.scrollHeight;

        input.value = '';

        fetch('/admin/chat/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    conversation_id: activeConversationId,
                    message: message
                })
            })
            .then(res => res.json())
            .then(() => {
                loadMessages(activeConversationId);
            });

    });
</script>
<script>
    function getCurrentTime() {
        const now = new Date();
        return now.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });
    }
</script>
<script>
    document.getElementById('chatInput').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.getElementById('sendBtn').click();
        }
    });
</script>
<script>
    function getDateLabel(dateStr) {
        const msgDate = new Date(dateStr);
        const today = new Date();
        const yesterday = new Date();
        yesterday.setDate(today.getDate() - 1);

        if (msgDate.toDateString() === today.toDateString()) {
            return 'Today';
        }

        if (msgDate.toDateString() === yesterday.toDateString()) {
            return 'Yesterday';
        }

        return msgDate.toLocaleDateString('en-IN', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }
</script>
<script>
    function isUserAtBottom(chatBox) {
        const threshold = 60;
        return chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight < threshold;
    }
</script>
<script>
    function loadMessages(conversationId) {
        fetch(`/admin/chat/messages/${conversationId}`)
            .then(res => res.json())
            .then(messages => {

                const chatBox = document.getElementById('chatMessages');
                const indicator = document.getElementById('newMsgIndicator');
                const countEl = document.getElementById('newMsgCount');

                const wasAtBottom = isUserAtBottom(chatBox);
                const oldScrollHeight = chatBox.scrollHeight;

                chatBox.innerHTML = '';
                let lastDateLabel = '';

                messages.forEach(msg => {

                    const currentDateLabel = getDateLabel(msg.created_at);

                    if (lastDateLabel !== currentDateLabel) {
                        chatBox.innerHTML += `<div class="chat-date">${currentDateLabel}</div>`;
                        lastDateLabel = currentDateLabel;
                    }

                    const isSent =
                        msg.sender_email === "{{ Auth::guard('admin')->user()->email }}";

                    let tickHtml = '';
                    if (isSent) {
                        tickHtml = msg.is_read ?
                            '<span class="chat-tick read">✓✓</span>' :
                            '<span class="chat-tick">✓</span>';
                    }

                    chatBox.innerHTML += `
                    <div class="chat-message ${isSent ? 'sent' : 'received'}">
                        ${msg.image
                            ? `<a href="${msg.image}" target="_blank">
                                   <img src="${msg.image}" class="chat-image"/>
                               </a>`
                            : `<p>${msg.message}</p>`
                        }
                        <div class="chat-time">
                            ${new Date(msg.created_at).toLocaleTimeString([], {
                                hour: '2-digit',
                                minute: '2-digit'
                            })}
                            ${tickHtml}
                        </div>
                    </div>
                `;
                });

                const newScrollHeight = chatBox.scrollHeight;

                if (wasAtBottom) {
                    chatBox.scrollTop = chatBox.scrollHeight;
                    indicator.classList.add('d-none');
                    newMsgCount = 0;
                } else if (newScrollHeight > oldScrollHeight) {
                    newMsgCount++;
                    countEl.innerText = newMsgCount;
                    indicator.classList.remove('d-none');
                }
            });
    }


    document.getElementById('newMsgIndicator').addEventListener('click', function() {
        const chatBox = document.getElementById('chatMessages');
        chatBox.scrollTop = chatBox.scrollHeight;

        this.classList.add('d-none');
        newMsgCount = 0;
    });


    setInterval(() => {
        if (activeConversationId) {
            loadMessages(activeConversationId);
        }
    }, 1000);
</script>
