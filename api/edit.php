<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('../sessions/auth.php');
require('../controllers/firebase.php');
require('../vendor/autoload.php');
$con = new Firebase();



$id = isset($_POST['id']) ? $_POST['id'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
$level = isset($_POST['level']) ? $_POST['level'] : 'user';

$tempimage = isset($_POST['tempimage']) ? $_POST['tempimage'] : '';




use Kreait\Firebase\Factory;

$storageBucket = STORAGE_BUCKET;
$storage = (new Factory())
    ->withServiceAccount(STORAGE_SERVICE)
    ->withDefaultStorageBucket($storageBucket)
    ->createStorage();
$bucket =  $storage->getBucket();

if($password != "") {
    if($password != $confirm_password){
        $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
        header('Location: ../edit.php?id='.$id);
        exit();
    }
}

$addiamge = '';
if(isset($_FILES['upfile'])){
    $folder = 'folder1/';
    $extension = pathinfo($_FILES['upfile']['name'], PATHINFO_EXTENSION);
    $filename = 'image-'.rand(0,9999).'.'.$extension;

    try{
        if($_FILES['upfile']['size'] > 0){
            $bucket->upload(
                file_get_contents($_FILES['upfile']['tmp_name']),
                [
                    'name'=>$folder.$filename
                ]
            );
            $genurl = Firebase::getStorage($storageBucket, $folder, $filename);
            $addiamge = $genurl;
            if($tempimage != ""){
                $decodeimage = Firebase::matchStorage($tempimage);
                if($decodeimage != ""){
                    $deleteimage = $bucket->object($decodeimage)->delete();
                }
                
            }
        }
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
}

$opt = [
    'username'=>$username,
    'level'=>$level
];
if($password != ""){
    $opt+=[
        'password'=>md5($password)
    ];
}
if($addiamge != "") {
    $opt+=[
        'picture'=>$addiamge
    ];
}

$data = $con->update('user/'.$id, $opt);
if(!empty($data['error'])){
    $_SESSION['error'] = $data['error'];
}
else{
    
    header("Location: ../");
    exit();
}


?>