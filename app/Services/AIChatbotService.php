<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AIChatbotService
{
    private array $conversationHistory = [];
    private array $tools;

    public function __construct()
    {
        $this->tools = $this->defineTools();
    }

    /**
     * Process user message and generate AI response
     */
    public function chat(string $userMessage, array $history = []): array
    {
        $this->conversationHistory = $history;

        // Add user message to history
        $this->conversationHistory[] = [
            'role' => 'user',
            'content' => $userMessage
        ];

        try {
            // Call OpenAI with function calling
            $response = OpenAI::chat()->create([
                'model' => config('openai.model', 'gpt-4-turbo-preview'),
                'messages' => $this->buildMessages(),
                'tools' => $this->tools,
                'tool_choice' => 'auto',
                'temperature' => 0.7,
                'max_tokens' => 1000,
            ]);

            $message = $response->choices[0]->message;

            // Check if AI wants to call a function
            if (isset($message->toolCalls) && !empty($message->toolCalls)) {
                return $this->handleToolCalls($message->toolCalls);
            }

            // Return the AI's text response
            $assistantMessage = $message->content ?? 'I apologize, but I could not generate a response.';

            $this->conversationHistory[] = [
                'role' => 'assistant',
                'content' => $assistantMessage
            ];

            return [
                'response' => $assistantMessage,
                'history' => $this->conversationHistory
            ];
        } catch (\Exception $e) {
            Log::error('AI Chatbot Error: ' . $e->getMessage());

            return [
                'response' => 'I apologize, but I encountered an error processing your request. Please try again.',
                'history' => $this->conversationHistory,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Build messages for OpenAI API
     */
    private function buildMessages(): array
    {
        $systemMessage = [
            'role' => 'system',
            'content' => $this->getSystemPrompt()
        ];

        return array_merge([$systemMessage], $this->conversationHistory);
    }

    /**
     * Get system prompt for the AI
     */
    private function getSystemPrompt(): string
    {
        return "You are an intelligent admin assistant for JobSphere, a job portal application.
You have access to the database and can help administrators with various tasks:

- List and search users
- View job postings and their details
- Check job applications and who applied to which jobs
- Get statistics about users, jobs, and applications
- Search and filter data based on various criteria
- Provide insights and summaries

Always be helpful, professional, and provide accurate information from the database.
When presenting data, format it clearly and concisely.
If you need to perform a database query, use the available tools.
Current date: " . now()->format('Y-m-d');
    }

    /**
     * Define available tools/functions for the AI
     */
    private function defineTools(): array
    {
        return [
            [
                'type' => 'function',
                'function' => [
                    'name' => 'list_users',
                    'description' => 'List users with optional filtering and pagination',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'limit' => [
                                'type' => 'integer',
                                'description' => 'Number of users to return (default: 10)',
                            ],
                            'search' => [
                                'type' => 'string',
                                'description' => 'Search term for user name or email',
                            ],
                            'role' => [
                                'type' => 'string',
                                'description' => 'Filter by user role (user or employer)',
                                'enum' => ['user', 'employer', 'admin']
                            ],
                        ],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_user_stats',
                    'description' => 'Get statistics about users',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'list_jobs',
                    'description' => 'List job postings with optional filtering',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'limit' => [
                                'type' => 'integer',
                                'description' => 'Number of jobs to return (default: 10)',
                            ],
                            'search' => [
                                'type' => 'string',
                                'description' => 'Search term for job title or company',
                            ],
                            'status' => [
                                'type' => 'string',
                                'description' => 'Filter by job status',
                                'enum' => ['active', 'inactive']
                            ],
                        ],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_job_details',
                    'description' => 'Get detailed information about a specific job',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'job_id' => [
                                'type' => 'integer',
                                'description' => 'The ID of the job',
                            ],
                        ],
                        'required' => ['job_id'],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'list_job_applications',
                    'description' => 'List job applications with optional filtering',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'limit' => [
                                'type' => 'integer',
                                'description' => 'Number of applications to return (default: 10)',
                            ],
                            'job_id' => [
                                'type' => 'integer',
                                'description' => 'Filter by specific job ID',
                            ],
                            'user_id' => [
                                'type' => 'integer',
                                'description' => 'Filter by specific user ID',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_application_stats',
                    'description' => 'Get statistics about job applications',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'search_applications_by_job',
                    'description' => 'Find which users applied to a specific job by job title or ID',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'job_title' => [
                                'type' => 'string',
                                'description' => 'Job title to search for',
                            ],
                            'job_id' => [
                                'type' => 'integer',
                                'description' => 'Job ID to search for',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_categories',
                    'description' => 'List all job categories',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [],
                    ],
                ],
            ],
            [
                'type' => 'function',
                'function' => [
                    'name' => 'get_job_types',
                    'description' => 'List all job types (Full-time, Part-time, etc.)',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [],
                    ],
                ],
            ],
        ];
    }

    /**
     * Handle tool/function calls from AI
     */
    private function handleToolCalls(array $toolCalls): array
    {
        $toolResults = [];

        foreach ($toolCalls as $toolCall) {
            $functionName = $toolCall->function->name;
            $arguments = json_decode($toolCall->function->arguments, true);

            // Execute the function
            $result = $this->executeFunction($functionName, $arguments);

            $toolResults[] = [
                'role' => 'tool',
                'tool_call_id' => $toolCall->id,
                'content' => json_encode($result)
            ];
        }

        // Add tool results to conversation history
        $this->conversationHistory[] = [
            'role' => 'assistant',
            'content' => null,
            'tool_calls' => array_map(function ($toolCall) {
                return [
                    'id' => $toolCall->id,
                    'type' => 'function',
                    'function' => [
                        'name' => $toolCall->function->name,
                        'arguments' => $toolCall->function->arguments
                    ]
                ];
            }, $toolCalls)
        ];

        foreach ($toolResults as $toolResult) {
            $this->conversationHistory[] = $toolResult;
        }

        // Make another API call with the tool results
        $response = OpenAI::chat()->create([
            'model' => config('openai.model', 'gpt-4-turbo-preview'),
            'messages' => $this->buildMessages(),
            'temperature' => 0.7,
            'max_tokens' => 1000,
        ]);

        $finalMessage = $response->choices[0]->message->content;

        $this->conversationHistory[] = [
            'role' => 'assistant',
            'content' => $finalMessage
        ];

        return [
            'response' => $finalMessage,
            'history' => $this->conversationHistory
        ];
    }

    /**
     * Execute a function based on name and arguments
     */
    private function executeFunction(string $functionName, array $arguments): mixed
    {
        return match ($functionName) {
            'list_users' => $this->listUsers($arguments),
            'get_user_stats' => $this->getUserStats(),
            'list_jobs' => $this->listJobs($arguments),
            'get_job_details' => $this->getJobDetails($arguments),
            'list_job_applications' => $this->listJobApplications($arguments),
            'get_application_stats' => $this->getApplicationStats(),
            'search_applications_by_job' => $this->searchApplicationsByJob($arguments),
            'get_categories' => $this->getCategories(),
            'get_job_types' => $this->getJobTypes(),
            default => ['error' => 'Function not found']
        };
    }

    // ==================== Tool Implementation Methods ====================

    private function listUsers(array $args): array
    {
        $query = User::query();
        $limit = $args['limit'] ?? 10;

        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (isset($args['role'])) {
            $query->where('role', $args['role']);
        }

        $users = $query->latest()
            ->limit($limit)
            ->get(['id', 'name', 'email', 'role', 'created_at'])
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'registered' => $user->created_at->format('Y-m-d H:i:s')
                ];
            });

        return [
            'total' => $users->count(),
            'users' => $users->toArray()
        ];
    }

    private function getUserStats(): array
    {
        return [
            'total_users' => User::count(),
            'total_employers' => User::where('role', 'employer')->count(),
            'total_job_seekers' => User::where('role', 'user')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
            'new_users_this_week' => User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
        ];
    }

    private function listJobs(array $args): array
    {
        $query = Job::with(['user', 'category', 'jobType']);
        $limit = $args['limit'] ?? 10;

        if (isset($args['search'])) {
            $search = $args['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        if (isset($args['status'])) {
            $query->where('status', $args['status']);
        }

        $jobs = $query->latest()
            ->limit($limit)
            ->get()
            ->map(function ($job) {
                return [
                    'id' => $job->id,
                    'title' => $job->title,
                    'company' => $job->company_name,
                    'location' => $job->location,
                    'salary' => $job->salary,
                    'status' => $job->status,
                    'category' => $job->category?->name,
                    'job_type' => $job->jobType?->name,
                    'posted_by' => $job->user?->name,
                    'created_at' => $job->created_at->format('Y-m-d H:i:s')
                ];
            });

        return [
            'total' => $jobs->count(),
            'jobs' => $jobs->toArray()
        ];
    }

    private function getJobDetails(array $args): array
    {
        $job = Job::with(['user', 'category', 'jobType', 'jobApplications'])
            ->find($args['job_id']);

        if (!$job) {
            return ['error' => 'Job not found'];
        }

        return [
            'id' => $job->id,
            'title' => $job->title,
            'description' => $job->description,
            'company' => $job->company_name,
            'location' => $job->location,
            'salary' => $job->salary,
            'status' => $job->status,
            'category' => $job->category?->name,
            'job_type' => $job->jobType?->name,
            'posted_by' => $job->user?->name,
            'posted_by_email' => $job->user?->email,
            'total_applications' => $job->jobApplications->count(),
            'created_at' => $job->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $job->updated_at->format('Y-m-d H:i:s')
        ];
    }

    private function listJobApplications(array $args): array
    {
        $query = JobApplication::with(['user', 'job']);
        $limit = $args['limit'] ?? 10;

        if (isset($args['job_id'])) {
            $query->where('job_id', $args['job_id']);
        }

        if (isset($args['user_id'])) {
            $query->where('user_id', $args['user_id']);
        }

        $applications = $query->latest()
            ->limit($limit)
            ->get()
            ->map(function ($app) {
                return [
                    'id' => $app->id,
                    'user_name' => $app->user?->name,
                    'user_email' => $app->user?->email,
                    'job_title' => $app->job?->title,
                    'company' => $app->job?->company_name,
                    'applied_at' => $app->created_at->format('Y-m-d H:i:s')
                ];
            });

        return [
            'total' => $applications->count(),
            'applications' => $applications->toArray()
        ];
    }

    private function getApplicationStats(): array
    {
        return [
            'total_applications' => JobApplication::count(),
            'applications_today' => JobApplication::whereDate('created_at', today())->count(),
            'applications_this_week' => JobApplication::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'applications_this_month' => JobApplication::whereMonth('created_at', now()->month)->count(),
            'most_applied_job' => $this->getMostAppliedJob(),
            'most_active_applicant' => $this->getMostActiveApplicant(),
        ];
    }

    private function searchApplicationsByJob(array $args): array
    {
        $query = JobApplication::with(['user', 'job']);

        if (isset($args['job_id'])) {
            $query->where('job_id', $args['job_id']);
        } elseif (isset($args['job_title'])) {
            $query->whereHas('job', function ($q) use ($args) {
                $q->where('title', 'like', "%{$args['job_title']}%");
            });
        }

        $applications = $query->get()
            ->map(function ($app) {
                return [
                    'applicant' => $app->user?->name,
                    'email' => $app->user?->email,
                    'job' => $app->job?->title,
                    'company' => $app->job?->company_name,
                    'applied_at' => $app->created_at->format('Y-m-d H:i:s')
                ];
            });

        return [
            'total' => $applications->count(),
            'applications' => $applications->toArray()
        ];
    }

    private function getCategories(): array
    {
        $categories = Category::withCount('jobs')
            ->get()
            ->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'total_jobs' => $cat->jobs_count
                ];
            });

        return [
            'total' => $categories->count(),
            'categories' => $categories->toArray()
        ];
    }

    private function getJobTypes(): array
    {
        $types = JobType::withCount('jobs')
            ->get()
            ->map(function ($type) {
                return [
                    'id' => $type->id,
                    'name' => $type->name,
                    'total_jobs' => $type->jobs_count
                ];
            });

        return [
            'total' => $types->count(),
            'job_types' => $types->toArray()
        ];
    }

    private function getMostAppliedJob(): ?array
    {
        $job = Job::withCount('jobApplications')
            ->orderBy('job_applications_count', 'desc')
            ->first();

        if (!$job) {
            return null;
        }

        return [
            'title' => $job->title,
            'company' => $job->company_name,
            'applications' => $job->job_applications_count
        ];
    }

    private function getMostActiveApplicant(): ?array
    {
        $user = User::withCount('jobApplications')
            ->orderBy('job_applications_count', 'desc')
            ->first();

        if (!$user) {
            return null;
        }

        return [
            'name' => $user->name,
            'email' => $user->email,
            'applications' => $user->job_applications_count
        ];
    }
}
