<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AIChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected $chatbotService;

    public function __construct(AIChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    /**
     * Display the chatbot interface
     */
    public function index()
    {
        return view('admin.chatbot.index');
    }

    /**
     * Handle chat message
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'sometimes|array'
        ]);

        $message = $request->input('message');
        $history = $request->input('history', []);

        try {
            // Process the message using AI
            $result = $this->chatbotService->chat($message, $history);

            return response()->json([
                'success' => true,
                'response' => $result['response'],
                'history' => $result['history']
            ]);
        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage(), [
                'message' => $message,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'response' => 'I apologize, but I encountered an error. Please try again or contact support if the issue persists.',
                'error' => app()->environment('local') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Clear chat history
     */
    public function clearHistory(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Chat history cleared'
        ]);
    }
}
