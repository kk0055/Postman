<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-with');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB & conncet
$database = new Database();
$db = $database->connect();

//INstantiate blog post
$post = new Post($db);

//Get raw posted data  
//JSON エンコードされた文字列を受け取り、それを PHP の変数に変換
//file_get_contents — ファイルの内容を全て文字列に読み込む

$data = json_decode(file_get_contents("php://input"));

//Set ID to update
$post->id = $data->id;

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

//Update post
if($post->update()) {
  echo json_encode(
    array('message' => 'Post Updated')
  );
}else{
  echo json_encode(
    array('message' => 'Post not Updated')
  );
}