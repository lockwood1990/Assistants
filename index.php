<?php

require_once(__DIR__ . '/openai.php');

// Just simply return the html code and inject messages in it
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $thread_list_filename = __DIR__ . '/threads_list';

    // This data below will be consumed inside the HTML "view.php"
    $threads = get_thread_list($thread_list_filename);
    $requested_thread_id = !empty($_GET['thread_id'])
        ? $_GET['thread_id']
        : end($threads)['assistant_id'];

    if (empty($requested_thread_id)) {
        $requested_thread_id = $openai->create_thread('Hello');
        // $openai->run_thread($requested_thread_id);
        append_thread_list($thread_list_filename, $requested_thread_id);
        $threads = get_thread_list($thread_list_filename);
    }
    $messages = $openai->list_thread_messages($requested_thread_id);

    require_once(__DIR__ . '/view.php');
}
