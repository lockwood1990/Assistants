<?php

if (empty($_GET['thread_id'])) exit();

require_once(__DIR__ . '/openai.php');

$thread_list_filename = __DIR__ . '/threads_list';
$openai->delete_thread($_GET['thread_id']);
delete_thread_list($thread_list_filename, $_GET['thread_id']);

exit();
