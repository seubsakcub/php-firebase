<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('./sessions/auth.php');
require('./controllers/firebase.php');
require('./controllers/mainController.php');

$alert = '';
if($session_error != ""){   
    $alert = '<p class="text-danger">'.$session_error.'</p>';
    $_SESSION['error'] = null;
}

$con = new Firebase();
$main = new mainController();

$id = isset($_GET['id']) ? $_GET['id'] : '';
if($id == '') {
    include('./404.html');
    exit();
}

$data = $con->select('user/'.$id);
$data = json_decode($data, true);

if(empty($data)){
    include('./404.html');
    exit();
}
$email = $data['email'];
$username = $data['username'];
$level = $main->level($data['level']);
$picture = (!empty($data['picture']) ? $data['picture'] : '');

$display = 'd-none';
if($session_level == 'admin'){
    $display = '';
}



?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include('./layers/header.php');?>
    <title>Edit user</title>

    <style>
        #viewpicture {
            width: 200px;
            height: 200px;
            object-fit: cover;
            cursor: pointer;
        }
        .change-picture {
            background-color: rgba(0, 0, 0, .4);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border-radius: 10px;
            color: #fff;
            padding: 5px 10px;
            cursor: pointer;
        }
        .change-picture:hover {
            background-color: rgba(0,0,0,.7);
        }
    </style>

  </head>
  <body>
    <?php include('./layers/nav.php');?>
    <div class="row justify-content-center mx-0">
        <div class="col-md-3 mt-5 text-center">
            <div class="position-relative">
                <i class="change-picture">คลิกเพื่อเปลี่ยนรูปภาพ</i>
                <img id="viewpicture" src="<?=($picture != '' ? $picture : './dist/images/user-blue.png');?>" class="rounded-pill">
            </div>
            
        </div>
        <div class="col-md-6 mt-5">
            <h3 class="text-secondary text-center">แก้ไขข้อมูลสมาชิก</h3>
            <div class="card">
                <div class="card-body">
                    <form action="./api/edit.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="tempimage" value="<?=$picture;?>">
                        <input type="file" name="upfile" id="upfile" class="d-none">
                        <input type="hidden" name="id" value="<?=$id;?>">
                        <div class="form-group">
                            <label for="">อีเมล</label>
                            <input type="email" class="form-control" value="<?=$email;?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="">ชื่อผู้ใช้</label>
                            <input type="text" name="username" class="form-control" value="<?=$username;?>" required>
                        </div>
                        <div class="border-top py-3 <?=$display;?>">
                            <div class="form-group">
                                <label for="">รหัสผ่าน</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">ยืนยัน รหัสผ่าน</label>
                                <input type="text" name="confirm_password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">สิทธิ์การใช้งาน</label>
                                <select name="level" class="custom-select">
                                    <?=$level;?>
                                </select>
                            </div>
                        </div>
                        <div class="">
                            <?=$alert;?>
                            <button type="submit" name="submit"  value="register" class="btn btn-warning"><i class="fas fa-edit"></i> อัพเดท</button>
                            <a href="./">
                                <button type="button" class="btn btn-secondary">ยกเลิก</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
    <script src="./dist/js/upfile.js"></script>
    <script>
        $(document).ready(function(){
            $('.change-picture').click(function(){
                $('#upfile').click();
            });
        });
    </script>
  </body>
</html>