<?php
session_start([
    'cookie_lifetime' => 3600, 
    'cookie_httponly' => true, 
    'cookie_secure' => true, 
    'cookie_samesite' => 'Strict' 
]);