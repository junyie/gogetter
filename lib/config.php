<?php
// MUTE NOTICES
error_reporting(E_ALL & ~E_NOTICE);

// DATABASE SETTINGS - CHANGE THESE TO YOUR OWN
define('DB_HOST', 'localhost');
define('DB_NAME', 'gogetter_project');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// FILE PATH - AUTOMATIC
// ! Manually change this if you are getting path problems !
define('PATH_LIB', __DIR__ . DIRECTORY_SEPARATOR);

// START SESSION
session_start();
?>