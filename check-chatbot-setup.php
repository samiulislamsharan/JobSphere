#!/usr/bin/env php
<?php

/**
 * AI Chatbot Setup Verification Script
 *
 * This script verifies that the AI chatbot is properly configured.
 */

echo "\n==========================================\n";
echo "AI Chatbot Configuration Checker\n";
echo "==========================================\n\n";

// Check if running from project root
if (!file_exists('artisan')) {
    echo "❌ Error: Please run this script from the project root directory.\n";
    exit(1);
}

$errors = [];
$warnings = [];

// Check 1: .env file exists
echo "✓ Checking .env file...";
if (!file_exists('.env')) {
    echo " ❌ FAILED\n";
    $errors[] = ".env file not found. Copy .env.example to .env";
} else {
    echo " ✅ PASSED\n";
}

// Check 2: OpenAI API Key
echo "✓ Checking OpenAI API Key...";
$envContent = file_exists('.env') ? file_get_contents('.env') : '';
if (
    strpos($envContent, 'OPENAI_API_KEY=') === false ||
    preg_match('/OPENAI_API_KEY=\s*$/m', $envContent)
) {
    echo " ⚠️  WARNING\n";
    $warnings[] = "OPENAI_API_KEY is not set in .env file";
} else {
    echo " ✅ PASSED\n";
}

// Check 3: Config file
echo "✓ Checking OpenAI config file...";
if (!file_exists('config/openai.php')) {
    echo " ❌ FAILED\n";
    $errors[] = "config/openai.php not found";
} else {
    echo " ✅ PASSED\n";
}

// Check 4: Service class
echo "✓ Checking AIChatbotService...";
if (!file_exists('app/Services/AIChatbotService.php')) {
    echo " ❌ FAILED\n";
    $errors[] = "app/Services/AIChatbotService.php not found";
} else {
    echo " ✅ PASSED\n";
}

// Check 5: Controller
echo "✓ Checking ChatbotController...";
if (!file_exists('app/Http/Controllers/Admin/ChatbotController.php')) {
    echo " ❌ FAILED\n";
    $errors[] = "app/Http/Controllers/Admin/ChatbotController.php not found";
} else {
    echo " ✅ PASSED\n";
}

// Check 6: View
echo "✓ Checking chatbot view...";
if (!file_exists('resources/views/admin/chatbot/index.blade.php')) {
    echo " ❌ FAILED\n";
    $errors[] = "resources/views/admin/chatbot/index.blade.php not found";
} else {
    echo " ✅ PASSED\n";
}

// Check 7: Routes
echo "✓ Checking routes...";
$routesContent = file_exists('routes/web.php') ? file_get_contents('routes/web.php') : '';
if (strpos($routesContent, 'ChatbotController') === false) {
    echo " ❌ FAILED\n";
    $errors[] = "Chatbot routes not found in routes/web.php";
} else {
    echo " ✅ PASSED\n";
}

// Check 8: Composer packages
echo "✓ Checking OpenAI package...";
$composerLock = file_exists('composer.lock') ? json_decode(file_get_contents('composer.lock'), true) : null;
$hasOpenAI = false;
if ($composerLock && isset($composerLock['packages'])) {
    foreach ($composerLock['packages'] as $package) {
        if ($package['name'] === 'openai-php/laravel') {
            $hasOpenAI = true;
            break;
        }
    }
}
if (!$hasOpenAI) {
    echo " ❌ FAILED\n";
    $errors[] = "openai-php/laravel package not installed. Run: composer require openai-php/laravel";
} else {
    echo " ✅ PASSED\n";
}

// Summary
echo "\n==========================================\n";
echo "Summary\n";
echo "==========================================\n\n";

if (empty($errors) && empty($warnings)) {
    echo "✅ All checks passed! Your AI chatbot is ready to use.\n\n";
    echo "Next steps:\n";
    echo "1. Add your OpenAI API key to .env file\n";
    echo "2. Run: php artisan config:clear\n";
    echo "3. Access the chatbot at: /admin/chatbot\n";
} else {
    if (!empty($errors)) {
        echo "❌ Errors found:\n";
        foreach ($errors as $error) {
            echo "   • $error\n";
        }
        echo "\n";
    }

    if (!empty($warnings)) {
        echo "⚠️  Warnings:\n";
        foreach ($warnings as $warning) {
            echo "   • $warning\n";
        }
        echo "\n";
    }

    echo "Please fix the issues above before using the chatbot.\n";
}

echo "\n==========================================\n";
echo "Configuration Details\n";
echo "==========================================\n\n";
echo "Chatbot URL: /admin/chatbot\n";
echo "Controller: App\\Http\\Controllers\\Admin\\ChatbotController\n";
echo "Service: App\\Services\\AIChatbotService\n";
echo "Documentation: AI_CHATBOT_README.md\n\n";

exit(empty($errors) ? 0 : 1);
