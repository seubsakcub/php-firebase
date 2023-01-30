<?php
require('../sessions/auth.php');
require('../controllers/firebase.php');
$con = new Firebase();

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$level = isset($_POST['level']) ? $_POST['level'] : 'user';

if($password != $confirm_password){
    $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
    header('Location: ../add.php');
    exit();
}

foreach($_POST as $key => $value){
    if($value == ""){
        $_SESSION['error'] = 'โปรดกรอกข้อมูลให้ครบถ้วน';
        header("Location: ../add.php");
        exit();
    }
 }
 


$check = $con->select("user", "email", "EQUAL", $email);
$result = json_decode($check, true);

if(empty($result)){
    $res = $con->insert('user',[
        'username'=>$username,
        'email'=>$email,
        'password'=>md5($password),
        'level'=>$level
    ]);
    $data = json_decode($res, true);
    if(!empty($data)){
        header("Location: ../index.php");
    }
    else{
        $_SESSION['error'] = 'ไม่สามารถเพิ่มผู้ใช้ได้';
        header('Location: ../add.php');
    }
}
else{
    if(!empty($result['error'])){
        $_SESSION['error'] = $result['error'];
    }
    else{
        $_SESSION['error'] = 'อีเมลนี้ถูกใช้งานแล้ว';
    }
    header('Location: ../add.php');
}


?>