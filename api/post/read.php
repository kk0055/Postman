<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//Instantiate DB & conncet
$database = new Database();
$db = $database->connect();

//INstantiate blog post
$post = new Post($db);


//Blog post query
$result = $post->read();
//Get row count   行の数を返すメソッド。
$num = $result->rowCount();

//CHeck if any posts
if($num > 0) {
 //Post array
 $posts_arr = array();
 //Jsonではなくdataを配列で取得
 $posts_arr['data'] = array();

 //$resultから連想配列でfetchする。$rowに代入
 while($row = $result->fetch(PDO::FETCH_ASSOC)) {
   //配列からシンボルテーブルに変数をインポート
   extract($row);
   
   //Array Key => Value
   $post_item = array(
     'id' => $id,
     'title' => $title,
     //HTML エンティティを対応する文字列に変換
     'body' => html_entity_decode($body),
     'author' => $author,
     'category_id' => $category_id,
     'category_name' => $category_name



   );
   //$post_itemを$posts_arr['data']の最後に追加
   array_push($posts_arr['data'],$post_item);
 }

 //Turn to Json & output
 echo json_encode($posts_arr);

}else {
  //No post
  echo  json_encode(array('message' => 'No posts Found'));

}
