<?php

// Include the OpenAI Assistant PHP SDK
require_once(
    __DIR__ . '/php-open-ai-assistant-sdk-main/src/OpenAIAssistant.php'
);

$api_key = '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';
$assistant_id = 'asst_Uyq4THiwFk60UEMPQsb6T4oN';
$openai = new \Erdum\OpenAIAssistant($api_key, $assistant_id);

function get_thread_list($filename)
{
    $file = fopen($filename, 'a+');
    $threads = array();

    while ($row = fgets($file)) {
        $assistant = explode(' - ', $row);
        array_push($threads, array(
            'assistant_id' => trim($assistant[1]),
            'timestamp' => $assistant[0]
        ));
    }
    fclose($file);
    return $threads;
}

function append_thread_list($filename, $thread_id)
{
    $file = fopen($filename, 'a+');
    $entry = date('Y-m-d H:i:s') . ' - ' . $thread_id . PHP_EOL;
    fwrite($file, $entry);
    fclose($file);
}
