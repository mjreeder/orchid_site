<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
    <style>
        .upload-file{
            width: 0.1px;
        	height: 0.1px;
        	opacity: 0;
        	overflow: hidden;
            position: absolute;
        	z-index: -1;
        }

        .upload-file + label {
            cursor: pointer;
            background-color: #01997B;
            color: white;
            font-family: Raleway, sans-serif;
            font-size: 14px;
            padding: 10px 15px;
            display: inline-block;
            -webkit-box-shadow: 1px 1px 8px 0 rgba(0,0,0,0.28);
            -moz-box-shadow: 1px 1px 8px 0 rgba(0,0,0,0.28);
            box-shadow: 1px 1px 8px 0 rgba(0,0,0,0.28);
            text-align: center;
            border-radius: 5px;
            font-weight: 600;
            border: none;
            margin-left: 12px;
        }

    body {
    margin: 0;
    }

    </style>
</head>
<body>

<?php
error_reporting(E_ALL);
ini_set("display_errors",true);

require_once "aws_file_uploader.php";
require_once "database.php";

function validate_admin_session($request, $response){
    //todo need to look into whether the user is valid 
    return true;
}


$session_key = $_GET['session_key'];
$session_id = $_GET['session_id'];
$url_section = $_GET['url_section'];
if(!validate_admin_session($_REQUEST, null)){
    die("invalid session info");
}

if($_SERVER['REQUEST_METHOD']=="POST"){

    if(isset($_FILES['upload_file'])){
        $newWidth  = 600;
        $newHeight = 600;
        preg_match('~(.+?)(?=\.)~',$_FILES['upload_file']['name'],$file_name);
        preg_match('$.*\.(.*)$',$_FILES['upload_file']['name'],$file_extension);
        $source;

        if($file_extension[1] == "jpg" || $file_extension[1] == "jpeg" || $file_extension[1] == "JPEG" || $file_extension[1] == "JPG"){
            $source = imagecreatefromjpeg($_FILES['upload_file']['tmp_name']);

        }

        else if($file_extension[1] == "png" || $file_extension[1] == "PNG"){
            $source = imagecreatefrompng($_FILES['upload_file']['tmp_name']);
        }



        list($width, $height) = getimagesize($_FILES['upload_file']['tmp_name']);

        if($width > $height){
            $newHeight = $newHeight * ($height/$width);
        }else{
            $newWidth = $newWidth * ($width/$height);
        }

//        var_dump($newWidth);
//        die($newHeight);

        $newImage = imagecreatetruecolor($newWidth, $newHeight);


        imagecopyresized($newImage , $source, 0,  0,  0,  0, $newWidth, $newHeight, $width , $height);
        $file_key = $file_name[0].'-time-'.time().".".$file_extension[1];
//        $file_key = $newImage.'-time-'.time().$file_extension[0];
        $thumb_key = $file_name[0].'-time-'.time()."_thumb.".$file_extension[1];

        $upload_url = add_new_file(AWS_DEFAULT_BUCKET, $file_key, $_FILES['upload_file']['tmp_name']);


        $stringdata;
        ob_start();
        imagepng($newImage);
        $stringdata = ob_get_contents();
        ob_end_clean();

        $thumb_url = add_new_thumbnail_file(AWS_DEFAULT_BUCKET, $thumb_key, $stringdata);


        ?>
        <script>
            var parentScope = window.parent.angular.element((window.frameElement)).scope();
            parentScope.uploadFileUrl("<?php echo $upload_url ?>", "<?php echo $url_section ?>", "<?php echo $thumb_url; ?>");
        </script>

        <?php
    }
}
?>
<form enctype="multipart/form-data" action="file_frame.php?session_key=<?php echo $session_key;?>&session_id=<?php echo $session_id ?>&url_section=<?php echo $url_section ?>" method="post">

    <input type="file" name="upload_file" id="upload-file" class="upload-file" onChange="form.submit()"/>
    <label for="upload-file">Choose a file</label>

</form>

</body>
</html>











