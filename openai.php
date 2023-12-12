<?php

session_start();

// Include the OpenAI Assistant PHP SDK
require_once(
    __DIR__ . '/php-open-ai-assistant-sdk-main/src/OpenAIAssistant.php'
);

$api_key = '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';
$assistant_id = 'asst_Uyq4THiwFk60UEMPQsb6T4oN';
$openai = new \Erdum\OpenAIAssistant($api_key, $assistant_id);

function get_thread_list()
{
    $threads = array();

    if (empty($_SESSION['threads'])) return $threads;
    $threads = unserialize($_SESSION['threads']);

    return $threads;
}

function append_thread_list($thread_id)
{
    $threads = get_thread_list();
    array_push($threads, array(
        'thread_id' => $thread_id,
        'timestamp' => date('Y-m-d H:i:s')
    ));
    $_SESSION['threads'] = serialize($threads);
}

function delete_thread_list($thread_id)
{
    $threads = get_thread_list();
    $filtered_threads = array_filter(
        $threads,
        function ($item) use ($thread_id) {
            return $thread_id != $item['thread_id'];
        }
    );
    $_SESSION['threads'] = serialize($filtered_threads);
}
