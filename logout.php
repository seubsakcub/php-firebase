<?php
require('./sessions/auth.php');
session_destroy();
header('Location: ./login.php');

?>