<!DOCTYPE html>
<html>
<head>
    <title>Upload File</title>
    <link rel="stylesheet" href="../assets/upload.css">
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
        preg_match('~(.+?)(?=\.)~',$_FILES['upload_file']['name'],$file_name);
        preg_match('~\.(.*)~',$_FILES['upload_file']['name'],$file_extension);
        $file_key = $file_name[0].'-time-'.time().$file_extension[0];
        $upload_url = add_new_file(AWS_DEFAULT_BUCKET, $file_key, $_FILES['upload_file']['tmp_name']);
        ?>
        <script>
            var parentScope = window.parent.angular.element((window.frameElement)).scope();
            parentScope.uploadFileUrl("<?php echo $upload_url ?>", "<?php echo $url_section ?>");
        </script>

        <?php
    }
}
?>
<form enctype="multipart/form-data" action="file_frame.php?session_key=<?php echo $session_key;?>&session_id=<?php echo $session_id ?>&url_section=<?php echo $url_section ?>" method="post">
    <label for="file">
        <input type="file" name="upload_file" id="file" class="upload-file" onChange="form.submit()"/> Upload
    </label>
</form>

</body>
</html>