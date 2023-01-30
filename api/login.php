<?php
require('../sessions/auth.php');
require('../controllers/firebase.php');
$con = new Firebase();

$password = isset($_POST['password']) ? $_POST['password'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';


if($email == '' || $password == ''){
    $_SESSION['error'] = 'โปรดกรอกข้อมูลให้ครบถ้วน';
    header('Location: ../register.php');
    exit();
}


$check = $con->select("user", "email", "EQUAL", $email);
$result = json_decode($check, true);


if(empty($result)){
    $_SESSION['error'] = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง';
    header('Location: ../login.php');
}
else{
    $key = array_keys($result)[0];
    #Firebase::print_r($result);
    if($result[$key]['password'] == md5($password)){
        $_SESSION['user_id'] = $key;
        $_SESSION['user_name'] = $result[$key]['username'];
        $_SESSION['email'] = $result[$key]['email'];
        $_SESSION['level'] = $result[$key]['level'];
        header('Location: ../index.php');
    }
    else{
        $_SESSION['error'] = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง';
        header('Location: ../login.php');
    }
}


?>