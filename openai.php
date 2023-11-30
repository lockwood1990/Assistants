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
            'thread_id' => trim($assistant[1]),
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

function delete_thread_list($filename, $thread_id)
{
    $filtered_list = array();
    $file = fopen($filename, 'w+');

    while ($row = fgets($file)) {

        if (!str_contains($row, $thread_id)) {
            array_push($filtered_list, $row);
        }
    }
    $data = implode(PHP_EOL, $filtered_list);
    fwrite($file, $data);
    fclose($file);
}
