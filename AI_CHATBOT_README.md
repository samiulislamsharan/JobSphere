# AI Chatbot Integration for JobSphere Admin Panel

This document explains how to set up and use the AI-powered chatbot for the JobSphere admin panel.

## Overview

The AI chatbot is an intelligent assistant that helps administrators interact with the JobSphere application using natural language. It can perform various tasks such as:

- Listing and searching users
- Viewing job postings and their details
- Checking job applications
- Getting statistics and insights
- Answering questions about the database

## Features

### AI-Powered Function Calling

The chatbot uses OpenAI's function calling feature to interact with your database intelligently. It can:

- Understand natural language queries
- Automatically choose the appropriate database operation
- Format and present data in a user-friendly way
- Maintain conversation context

### Available Commands

The chatbot can handle queries like:

- "Show me the latest 20 users"
- "How many users registered today?"
- "List all active jobs"
- "Which job has the most applications?"
- "Show job applications for Software Engineer position"
- "Get statistics about users"
- "Who applied to the job with ID 5?"
- "List all job categories"

## Installation & Setup

### Step 1: Install Dependencies

The OpenAI PHP package has already been installed via Composer:

```bash
composer require openai-php/laravel
```

### Step 2: Get OpenAI API Key

1. Go to [OpenAI Platform](https://platform.openai.com/)
2. Sign up or log in to your account
3. Navigate to API Keys section
4. Create a new API key
5. Copy the API key (you won't be able to see it again!)

### Step 3: Configure Environment Variables

Add your OpenAI API key to your `.env` file:

```env
OPENAI_API_KEY=sk-proj-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
OPENAI_ORGANIZATION=org-xxxxxxxxxxxxxxxxxxxxxxxx
OPENAI_MODEL=gpt-4-turbo-preview
```

**Note:**

- `OPENAI_ORGANIZATION` is optional
- You can use `gpt-3.5-turbo` for faster and cheaper responses, or `gpt-4-turbo-preview` for better accuracy

### Step 4: Clear Cache

Clear your configuration cache:

```bash
php artisan config:clear
php artisan cache:clear
```

## Usage

### Accessing the Chatbot

1. Log in to the admin panel
2. Navigate to the "AI Chatbot" menu item in the sidebar
3. Start chatting with the assistant!

### Example Conversations

#### Example 1: User Statistics

**You:** "How many users do we have?"
**Bot:** "You currently have 150 total users:

- 120 job seekers
- 25 employers
- 5 admins

10 new users registered today."

#### Example 2: Job Applications

**You:** "Show me who applied to the Software Engineer position"
**Bot:** "I found 8 applications for the Software Engineer position:

- John Doe (john@example.com) - Applied on 2026-01-20
- Jane Smith (jane@example.com) - Applied on 2026-01-19
  ..."

#### Example 3: Statistics

**You:** "What's our most popular job?"
**Bot:** "The most applied job is:

- Title: Senior Full-Stack Developer
- Company: Tech Corp
- Total Applications: 45"

## Architecture

### Files Structure

```
app/
├── Http/
│   └── Controllers/
│       └── Admin/
│           └── ChatbotController.php
└── Services/
    └── AIChatbotService.php

config/
└── openai.php

resources/
└── views/
    └── admin/
        └── chatbot/
            └── index.blade.php

routes/
└── web.php
```

### How It Works

1. **User Input**: Admin sends a message through the chat interface
2. **API Call**: Frontend sends the message to the Laravel backend
3. **AI Processing**:
    - `AIChatbotService` sends the message to OpenAI
    - OpenAI analyzes the request and determines if it needs to call a function
    - If a function is needed, OpenAI returns function call parameters
4. **Database Query**: Service executes the appropriate database query
5. **AI Response**: OpenAI formats the database results into natural language
6. **Display**: Response is shown to the user in the chat interface

### Available Functions

The chatbot has access to these functions:

- `list_users`: List users with filtering and pagination
- `get_user_stats`: Get user statistics
- `list_jobs`: List job postings with filtering
- `get_job_details`: Get detailed information about a specific job
- `list_job_applications`: List job applications with filtering
- `get_application_stats`: Get application statistics
- `search_applications_by_job`: Find applications for a specific job
- `get_categories`: List all job categories
- `get_job_types`: List all job types

### Conversation History

The chatbot maintains conversation history during the session, allowing it to:

- Understand context from previous messages
- Handle follow-up questions
- Provide coherent multi-turn conversations

## Customization

### Adding New Functions

To add new capabilities to the chatbot:

1. **Define the function** in `AIChatbotService::defineTools()`:

```php
[
    'type' => 'function',
    'function' => [
        'name' => 'get_revenue_stats',
        'description' => 'Get revenue statistics',
        'parameters' => [
            'type' => 'object',
            'properties' => [
                'period' => [
                    'type' => 'string',
                    'description' => 'Time period (daily, weekly, monthly)',
                    'enum' => ['daily', 'weekly', 'monthly']
                ],
            ],
        ],
    ],
]
```

2. **Implement the function** in `AIChatbotService::executeFunction()`:

```php
private function executeFunction(string $functionName, array $arguments): mixed
{
    return match($functionName) {
        // ... existing functions
        'get_revenue_stats' => $this->getRevenueStats($arguments),
        default => ['error' => 'Function not found']
    };
}
```

3. **Create the method**:

```php
private function getRevenueStats(array $args): array
{
    // Your implementation
    return [
        'total_revenue' => 5000,
        'period' => $args['period']
    ];
}
```

### Changing AI Model

Update the `.env` file:

```env
# For better quality (more expensive)
OPENAI_MODEL=gpt-4

# For faster responses (cheaper)
OPENAI_MODEL=gpt-3.5-turbo

# For the latest GPT-4 Turbo (recommended)
OPENAI_MODEL=gpt-4-turbo-preview
```

### Modifying System Prompt

Edit the `getSystemPrompt()` method in `AIChatbotService.php` to customize the AI's behavior and personality.

## Security Considerations

1. **Authentication**: The chatbot is protected by the `auth` and `admin` middleware
2. **API Key**: Never commit your OpenAI API key to version control
3. **Rate Limiting**: Consider implementing rate limiting for API calls
4. **Data Exposure**: The chatbot has access to sensitive data - only allow trusted admins

## Cost Management

OpenAI API usage is billed per token. To manage costs:

1. **Use appropriate models**:
    - GPT-3.5-turbo is ~10x cheaper than GPT-4
    - GPT-4-turbo-preview offers a good balance

2. **Limit response length**: Set appropriate `max_tokens` in API calls

3. **Monitor usage**: Check your OpenAI dashboard regularly

4. **Implement caching**: Cache common queries if needed

## Troubleshooting

### "API key not valid" error

- Verify your API key in `.env`
- Make sure you've run `php artisan config:clear`
- Check if the key is properly set in OpenAI dashboard

### "Model not found" error

- Ensure you have access to the model (GPT-4 requires separate access)
- Use `gpt-3.5-turbo` as a fallback

### Slow responses

- Consider using `gpt-3.5-turbo` instead of GPT-4
- Reduce the `max_tokens` parameter
- Check your internet connection

### Function calls not working

- Verify your function definitions match the OpenAI format
- Check Laravel logs for errors
- Ensure database relationships are properly defined

## Future Enhancements

Potential improvements:

1. **Voice Input**: Add speech-to-text for voice queries
2. **Data Visualization**: Generate charts and graphs from data
3. **Scheduled Reports**: Automate regular reports via chatbot
4. **Multi-language Support**: Support multiple languages
5. **Export Data**: Allow exporting query results
6. **Advanced Analytics**: Integrate with analytics tools

## Support

For issues or questions:

- Check Laravel logs: `storage/logs/laravel.log`
- OpenAI API status: https://status.openai.com/
- OpenAI documentation: https://platform.openai.com/docs

## License

This integration is part of the JobSphere application and follows the same license.
