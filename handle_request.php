<?php

session_start();

require_once(__DIR__ . '/openai.php');

// Do not process further exit, if get an empty request
if (empty($_GET['userInput'])) exit();
$userInput = $_GET['userInput'];

if (empty($thread_id)) {
    $thread_id = $openai->create_thread($userInput);
    $_SESSION['thread_id'] = $thread_id;
} else {
    $openai->add_message($thread_id, $userInput);
}
$openai->run_thread($thread_id);

while ($openai->has_tool_calls) {
    $outputs = $openai->execute_tools($thread_id, $openai->tool_call_id);
    $openai->submit_tool_outputs($thread_id, $openai->tool_call_id, $outputs);
}

// Get and display the chatbot response
$messages = $openai->list_thread_messages($thread_id);
$message = $messages[0];
$output = '';

if ($message['role'] == 'assistant') {
    
    foreach ($message['content'] as $msg) {
        $output .= "{$msg['text']['value']}";
    }
    exit($output);
}
