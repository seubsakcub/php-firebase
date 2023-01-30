<?php
require('./sessions/auth.php');

$alert = '';
if($session_error != ""){   
    $alert = '<p class="text-danger">'.$session_error.'</p>';
    $_SESSION['error'] = null;
}
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Register</title>

  </head>
  <body>
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-5 mt-5">
            <h3 class="text-secondary">Register User</h3>
            <div class="card">
                <div class="card-body">
                    <form action="./api/register.php" method="POST">
                        <div class="form-group">
                            <label for="">อีเมล</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">ชื่อผู้ใช้</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="">รหัสผ่าน</label>
                            <input type="text" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">ยืนยัน รหัสผ่าน</label>
                            <input type="text" name="confirm_password" class="form-control">
                        </div>
                        <div class="">
                            <?=$alert;?>
                            <button type="submit" name="submit"  value="register" class="btn btn-primary">ลงทะเบียน</button>
                        </div>
                        <p class="mt-3">หากมีบัญชีผู้ใช้อยู่แล้ว? <a href="./login.php">เข้าสู่ระบบ</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>