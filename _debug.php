<?php

session_start();

header('Content-Type: application/json');
exit(json_encode(unserialize($_SESSION['threads'])));
