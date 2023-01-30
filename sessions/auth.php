<?php
session_name('phpfirebase');
session_start();

$session_error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
$session_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
$session_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
$session_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$session_level = isset($_SESSION['level']) ? $_SESSION['level'] : '';

?>