<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB & conncet
$database = new Database();
$db = $database->connect();

// models/PostのPostをインスタンス化
$post = new Post($db);


//Get ID インスタンス化した$postのidメソッド呼び出して入力されたidがセットされていればidメソッドに代入
$post->id = isset($_GET['id'])? $_GET['id'] : die();

//$postのread_singleメソッドを実行
$post->read_single();

//Create array 
$post_arr = array(
  'id' => $post->id,
  'title' => $post->title,
  'body' =>$post->body,
  'author' => $post->author,
  'category_id' => $post->category_id,
  'category_name' => $post->category_name
);

print_r(json_encode($post_arr ));
