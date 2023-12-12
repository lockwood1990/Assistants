<?php

// 24 Hours
$SESSION_TIMEOUT = 60 * 60 * 24;

ini_set("session.gc_maxlifetime", $SESSION_TIMEOUT);
ini_set("session.cookie_lifetime", $SESSION_TIMEOUT);

session_start();

require_once(__DIR__ . '/openai.php');

// Just simply return the html code and inject messages in it
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $requested_thread_id = $_GET['thread_id'];
    $threads = get_thread_list();

    if (empty($requested_thread_id)) {

        if (count($threads) > 0) {
            $requested_thread_id = end($threads)['thread_id'];
        } else {
            $requested_thread_id = $openai->create_thread('Hello');
            append_thread_list($requested_thread_id);
            $threads = get_thread_list();
        }
    }

    // This data below will be consumed inside the HTML "view.php"
    $messages = $openai->list_thread_messages($requested_thread_id);

    require_once(__DIR__ . '/view.php');
}
