<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('./sessions/auth.php');
require('./controllers/firebase.php');

if($session_name == ''){
    header("Location: ./login.php");
}

$con = new Firebase();
$data = $con->select('user');
$data = json_decode($data,true);


$datatable = '';
$i=1;
foreach($data as $key => $row){
    if(!empty($row['email']) && $row['email'] != ''){
        $datatable.= '<tr>
            <td>'.$i.'</td>
            <td>
                <img src="'.(!empty($row['picture']) ? $row['picture'] : './dist/images/user-blue.png').'" class="rounded-pill" style="width: 50px; height: 50px;">
                '.$row['username'].'
            </td>
            <td>'.$row['email'].'</td>
            <td class="text-center">
                <span class="badge badge-pill '.($row['level'] == 'admin' ? 'badge-success' : 'badge-secondary').'">'.$row['level'].'</span>
            </td>
            <td class="text-right">
                <a href="./edit.php?id='.$key.'">
                    <button type="button" class="btn btn-sm rounded-pill btn-warning"><i class="fas fa-edit"></i> แก้ไข</button>
                </a>
                <button type="button" onclick="delete_user(\''.$key.'\')" class="btn btn-sm rounded-pill btn-danger"><i class="fas fa-trash"></i> ลบ</button>
            </td>
        </tr>';
        $i++;
    }
}

?>

<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php include('./layers/header.php');?>
	<title>Template by SJantamala</title>
</head>
<body>
    <?php include('./layers/nav.php');?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
                <h3 class="mt-5">List User
                    <a href="./add.php" class="float-right">
                        <button type="button" class="btn btn-sm rounded-pill btn-primary"><i class="fas fa-plus"></i> เพิ่มสมาชิก</button>
                    </a>
                </h3>
				<table class="table">
                    <tr>
                        <th>#</th>
                        <th>ชื่อผู้ใช้</th>
                        <th>อีเมล</th>
                        <th class="text-center">สิทธิ์</th>
                        <th class="text-right">...</th>
                    </tr>
                    <?=$datatable;?>
                </table>
			</div>
		</div>
	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>
    <script>
        function delete_user(id){
            if(confirm('ต้องการลบข้อมูลผู้ใช้ ใช่หรือไม่?')){
                $.post('./api/delete.php', {id: id} , function(res){
                    if(res == 'success'){
                        alert('ลบข้อมูลเรียบร้อย');
                        window.location = document.URL;
                    }
                    else{
                        alert('เกิดข้อผิดพลาด');
                    }
                });
            }
        }
    </script>
</body>
</html>