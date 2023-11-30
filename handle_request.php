<?php

// Do not process further exit, if get an empty request
if (empty($_GET['query']) || empty($_GET['thread_id'])) exit();

require_once(__DIR__ . '/openai.php');

$openai->add_message($_GET['thread_id'], $_GET['query']);
$openai->run_thread($_GET['thread_id']);

while ($openai->has_tool_calls) {
    $outputs = $openai->execute_tools($_GET['thread_id'], $openai->tool_call_id);
    $openai->submit_tool_outputs($_GET['thread_id'], $openai->tool_call_id, $outputs);
}

// Get and display the chatbot response
$messages = $openai->list_thread_messages($_GET['thread_id']);
$message = $messages[0];
$output = '';

if ($message['role'] == 'assistant') {
    
    foreach ($message['content'] as $msg) {
        $output .= "{$msg['text']['value']}";
    }
    exit($output);
}
