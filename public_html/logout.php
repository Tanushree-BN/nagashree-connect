<?php
require_once __DIR__ . '/functions/helpers.php';
$_SESSION = [];
session_destroy();
redirect_to('/');
