<?php

require_once(__DIR__ . '/openai.php');

$thread_list_filename = __DIR__ . '/threads_list';
$thread_id = $openai->create_thread('Hello');
$openai->run_thread($thread_id);
append_thread_list($thread_list_filename, $thread_id);

exit();
