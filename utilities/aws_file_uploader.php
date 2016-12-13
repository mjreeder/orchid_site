<?php


require_once '../vendor/autoload.php';
require_once "./aws_file_upload_constants.php";
require_once "./Config.php";

$CONFIG = Config::AWS();

$options = [
    'version'     => 'latest',
    'region'      => $CONFIG["region"],
    'credentials' => [
        'key'    => $CONFIG["key"],
        'secret' => $CONFIG["secret"],
    ],
];


$s3Client = new \Aws\S3\S3Client($options);


function does_bucket_exist($bucket){
    global $s3Client;
    $buckets = $s3Client->listBuckets()["Buckets"];
    foreach($buckets as $buck){
        if($buck["Name"]==$bucket){

            return true;
        }
    }
    return false;
}

function build_aws_url($key){
    return BASE_DOMAIN.$key;
}




//adds a file to an amazon s3 bucket and returns the url or null on failure.
function add_new_file($bucket, $key, $file_path){
    global $s3Client;
    //check if bucket exists;
    if(!does_bucket_exist($bucket)){
        return null;
    }

    try{
        //if this is successful then the key is already being used
        $s3Client->getObject(["Key"=>$key,"Bucket"=>$bucket]);
        return null;
    }catch(Exception $e){
        //add object to bucket
        $model = $s3Client->putObject(["Key"=>$key,"Bucket"=>$bucket, "SourceFile"=>$file_path]);
        return build_aws_url($key);
    }


}

function add_new_thumbnail_file($bucket, $key, $string_data){
    global $s3Client;
    //check if bucket exists;
    if(!does_bucket_exist($bucket)){
        return null;
    }

    try{
        //if this is successful then the key is already being used
        $s3Client->getObject(["Key"=>$key,"Bucket"=>$bucket]);
        return null;
    }catch(Exception $e){
        //add object to bucket
        $model = $s3Client->putObject(["Key"=>$key,"Bucket"=>$bucket, "Body"=>$string_data]);
        return build_aws_url($key);
    }
}

function list_all_files_in_bucket($bucket){
    global $s3Client;
    $objects = $s3Client->listObjects(["Bucket"=>$bucket])["Contents"];
    $result_objects = [];
    foreach($objects as $object){
        $result_objects[] = array("key"=>$object["Key"], "url"=>build_aws_url($object["Key"]));
    }
    return $result_objects;
}