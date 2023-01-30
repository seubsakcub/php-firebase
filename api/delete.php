<?php
require('../sessions/auth.php');
require('../controllers/firebase.php');
$con = new Firebase();

$id = isset($_POST['id']) ? $_POST['id'] : '';

if($id == ''){
    echo 'Error: Invalid ID.';
    exit();
}

$delete = $con->delete('user',$id);
$delete = json_decode($delete, true);

if(!empty($delete['error'])){
   echo $delete['error'];
}
else{
    echo "success";
}


?>