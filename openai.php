<?php

// Include the OpenAI Assistant PHP SDK
require_once(
    __DIR__ . '/php-open-ai-assistant-sdk-main/src/OpenAIAssistant.php'
);

$thread_id = isset($_SESSION['thread_id']) ? $_SESSION['thread_id'] : null;
$api_key = '';
$assistant_id = '';
$openai = new \Erdum\OpenAIAssistant($api_key, $assistant_id);
