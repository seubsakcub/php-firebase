<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('./vendor/autoload.php');
require('./controllers/firebase.php');


use Kreait\Firebase\Factory;

$storageBucket = 'tutorial-php-4.appspot.com';
$storage = (new Factory())
    ->withServiceAccount('./tutorial-php-4-firebase-adminsdk-hfcyj-1144468b4d.json')
    ->withDefaultStorageBucket($storageBucket)
    ->createStorage();
$bucket =  $storage->getBucket();

if(isset($_POST['submit']) && $_POST['submit'] == 'upload'){

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
                echo "OK upload";
                echo '<a href="'.$genurl.'" target="_blank">'.$genurl.'</a>';
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }
}

?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="upfile" id="upfile">
    <button type="submit" name="submit" value="upload">Upload</button>
</form>