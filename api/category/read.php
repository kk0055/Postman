<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');

include_once '../../config/Database.php';
include_once '../../models/category.php';

//Instantiate DB & conncet
$database = new Database();
$db = $database->connect();

//INstantiate blog post
$category = new Category($db);


//Blog post query
//Category.phpのreadfunctionを読み込み
$result = $category->read();
//Get row count   行の数を返すメソッド。
$num = $result->rowCount();

//CHeck if any posts
if($num > 0) {
 //cat array
 $cat_arr = array();
 //Jsonではなくdataを配列で取得
 $cat_arr['data'] = array();

 //$resultから連想配列でfetchする。$rowに代入
 while($row = $result->fetch(PDO::FETCH_ASSOC)) {
   //配列からシンボルテーブルに変数をインポート
   extract($row);
   
   //Array Key => Value
   $cat_item = array(
     'id' => $id,
     'name' => $name,
    
   );
   //$post_itemを$posts_arr['data']の最後に追加
   array_push($cat_arr['data'],$cat_item);
 }

 //Turn to Json & output
 echo json_encode($cat_arr);

}else {
  //No post
  echo  json_encode(array('message' => 'No Categories Found'));

}
