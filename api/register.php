<?php
require('../sessions/auth.php');
require('../controllers/firebase.php');
$con = new Firebase();

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

if($password != $confirm_password){
    $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
    header('Location: ../register.php');
    exit();
}
if($username == '' || $password == '' || $email == ''){
    $_SESSION['error'] = 'โปรดกรอกข้อมูลให้ครบถ้วน';
    header('Location: ../register.php');
    exit();
}


$check = $con->select("user", "email", "EQUAL", $email);
$result = json_decode($check, true);

if(empty($result)){
    $res = $con->insert('user',[
        'username'=>$username,
        'email'=>$email,
        'password'=>md5($password),
        'level'=>'user'
    ]);
    $data = json_decode($res, true);
    Firebase::print_r($data);
    if(!empty($data)){
        $_SESSION['user_name'] = $username;
        $_SESSION['user_id'] = $data['name'];
        $_SESSION['email'] = $email;
        $_SESSION['level'] = 'user';
        header("Location: ../index.php");
    }
    else{
        $_SESSION['error'] = 'ไม่สามารถลงทะเบียนได้';
        header('Location: ../register.php');
    }
}
else{
    if(!empty($result['error'])){
        $_SESSION['error'] = $result['error'];
    }
    else{
        $_SESSION['error'] = 'อีเมลนี้ถูกใช้งานแล้ว';
    }
    header('Location: ../register.php');
}


?>