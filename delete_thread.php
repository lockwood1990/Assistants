<?php

if (empty($_GET['thread_id'])) exit();

require_once(__DIR__ . '/openai.php');

$result = $openai->delete_thread($_GET['thread_id']);
delete_thread_list($_GET['thread_id']);

exit($result);
