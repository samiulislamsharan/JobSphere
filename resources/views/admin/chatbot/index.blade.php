@extends('front.layouts.app')

@section('content')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                            <li class="breadcrumb-item active">AI Chatbot</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.shared.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.account.shared.message')

                    <div class="card border-0 shadow mb-4">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">AI Admin Assistant</h3>
                            <button id="clear-chat" class="btn btn-sm btn-light">
                                <i class="fa fa-trash"></i> Clear Chat
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <!-- Chat Messages Container -->
                            <div id="chat-messages" class="p-4"
                                style="height: 500px; overflow-y: auto; background-color: #f8f9fa;">
                                <!-- Welcome Message -->
                                <div class="message bot-message mb-3">
                                    <div class="d-flex align-items-start">
                                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                            style="width: 40px; height: 40px; min-width: 40px;">
                                            <i class="fa fa-robot"></i>
                                        </div>
                                        <div class="message-content bg-white rounded p-3 shadow-sm" style="max-width: 70%;">
                                            <p class="mb-0">Hello! I'm your AI admin assistant. I can help you with:</p>
                                            <ul class="mb-0 mt-2">
                                                <li>Listing and searching users</li>
                                                <li>Viewing job postings and details</li>
                                                <li>Checking job applications</li>
                                                <li>Getting statistics and insights</li>
                                                <li>Answering questions about your data</li>
                                            </ul>
                                            <p class="mb-0 mt-2">What would you like to know?</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Chat Input -->
                            <div class="p-3 bg-white border-top">
                                <form id="chat-form">
                                    <div class="input-group">
                                        <input type="text" id="chat-input" class="form-control"
                                            placeholder="Ask me anything about users, jobs, or applications..."
                                            autocomplete="off" required>
                                        <button type="submit" class="btn btn-primary" id="send-button">
                                            <i class="fa fa-paper-plane me-1"></i> Send
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Example Questions -->
                    <div class="card border-0 shadow">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Example Questions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-outline-primary btn-sm mb-2 example-question w-100 text-start">
                                        Show me the latest users
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm mb-2 example-question w-100 text-start">
                                        How many users registered today?
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm mb-2 example-question w-100 text-start">
                                        List all active jobs
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-outline-primary btn-sm mb-2 example-question w-100 text-start">
                                        Show recent job applications
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm mb-2 example-question w-100 text-start">
                                        Which job has the most applications?
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm mb-2 example-question w-100 text-start">
                                        Get job statistics
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        #chat-messages {
            scroll-behavior: smooth;
        }

        .message {
            animation: fadeIn 0.3s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-message .message-content {
            background-color: #007bff !important;
            color: white !important;
        }

        .bot-message .message-content {
            white-space: pre-line;
        }

        .typing-indicator {
            display: inline-flex;
            align-items: center;
        }

        .typing-indicator span {
            height: 8px;
            width: 8px;
            background-color: #90949c;
            border-radius: 50%;
            display: inline-block;
            margin-right: 3px;
            animation: typing 1.4s infinite;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing {

            0%,
            60%,
            100% {
                transform: translateY(0);
            }

            30% {
                transform: translateY(-10px);
            }
        }
    </style>

    <script>
        let chatHistory = [];

        document.addEventListener('DOMContentLoaded', function() {
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatMessages = document.getElementById('chat-messages');
            const sendButton = document.getElementById('send-button');
            const clearButton = document.getElementById('clear-chat');
            const exampleQuestions = document.querySelectorAll('.example-question');

            // Handle form submission
            chatForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const message = chatInput.value.trim();
                if (!message) return;

                // Clear input and disable button
                chatInput.value = '';
                sendButton.disabled = true;
                chatInput.disabled = true;

                // Add user message
                addMessage(message, 'user');

                // Show typing indicator
                const typingId = showTypingIndicator();

                try {
                    const response = await fetch('{{ route('admin.chatbot.chat') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: message,
                            history: chatHistory
                        })
                    });

                    const data = await response.json();

                    // Remove typing indicator
                    removeTypingIndicator(typingId);

                    if (data.success) {
                        // Update chat history
                        chatHistory = data.history || [];

                        // Add bot response
                        addMessage(data.response, 'bot');
                    } else {
                        addMessage(data.response || 'Sorry, something went wrong.', 'bot');
                    }
                } catch (error) {
                    removeTypingIndicator(typingId);
                    addMessage('Sorry, I encountered an error. Please try again.', 'bot');
                    console.error('Chat error:', error);
                } finally {
                    sendButton.disabled = false;
                    chatInput.disabled = false;
                    chatInput.focus();
                }
            });

            // Handle example questions
            exampleQuestions.forEach(button => {
                button.addEventListener('click', function() {
                    chatInput.value = this.textContent.trim();
                    chatForm.dispatchEvent(new Event('submit'));
                });
            });

            // Clear chat
            clearButton.addEventListener('click', function() {
                if (confirm('Are you sure you want to clear the chat history?')) {
                    chatHistory = [];

                    // Keep only the welcome message
                    const messages = chatMessages.querySelectorAll('.message');
                    messages.forEach((msg, index) => {
                        if (index > 0) {
                            msg.remove();
                        }
                    });

                    fetch('{{ route('admin.chatbot.clear-history') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                }
            });

            function addMessage(text, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${sender}-message mb-3`;

                if (sender === 'user') {
                    messageDiv.innerHTML = `
                        <div class="d-flex align-items-start justify-content-end">
                            <div class="message-content bg-primary text-white rounded p-3 shadow-sm" style="max-width: 70%;">
                                <p class="mb-0">${escapeHtml(text)}</p>
                            </div>
                            <div class="avatar bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center ms-2" style="width: 40px; height: 40px; min-width: 40px;">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                    `;
                } else {
                    messageDiv.innerHTML = `
                        <div class="d-flex align-items-start">
                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; min-width: 40px;">
                                <i class="fa fa-robot"></i>
                            </div>
                            <div class="message-content bg-white rounded p-3 shadow-sm" style="max-width: 70%;">
                                <p class="mb-0">${escapeHtml(text)}</p>
                            </div>
                        </div>
                    `;
                }

                chatMessages.appendChild(messageDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function showTypingIndicator() {
                const typingDiv = document.createElement('div');
                typingDiv.className = 'message bot-message mb-3 typing-indicator-message';
                typingDiv.id = 'typing-' + Date.now();
                typingDiv.innerHTML = `
                    <div class="d-flex align-items-start">
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; min-width: 40px;">
                            <i class="fa fa-robot"></i>
                        </div>
                        <div class="message-content bg-white rounded p-3 shadow-sm">
                            <div class="typing-indicator">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                `;
                chatMessages.appendChild(typingDiv);
                chatMessages.scrollTop = chatMessages.scrollHeight;
                return typingDiv.id;
            }

            function removeTypingIndicator(id) {
                const typingDiv = document.getElementById(id);
                if (typingDiv) {
                    typingDiv.remove();
                }
            }

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
        });
    </script>
@endsection
