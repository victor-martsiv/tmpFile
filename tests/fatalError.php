<?php

require_once __DIR__ . '/../vendor/autoload.php';
$tmpHandler = new \KnightWithKnife\Tmp\File($_SERVER['TEMP_FILE']);
trigger_error('Fatal error!', E_USER_ERROR);