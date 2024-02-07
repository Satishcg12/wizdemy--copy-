<?php
// Change upload size limit
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);




//site config
define('SITE_NAME', 'Wizdemy');
define('SITE_DOMAIN', $_SERVER['HTTP_HOST']);

define('ROOT_DIR', __DIR__ . '/');

//db config
define('DATABASE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '@Satish_00');
define('DB_NAME', 'wizdemy');
define('DB_PORT', '3306');