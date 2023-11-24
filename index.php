<?php

session_start();

require_once(__DIR__ . '/openai.php');

// Just simply return the html code and inject messages in it
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $messages = array();

    if (!empty($thread_id)) {
        $messages = $openai->list_thread_messages($thread_id);
    }
    require_once(__DIR__ . '/view.php');
}
