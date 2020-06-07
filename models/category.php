<?php 

class Category {
//DB
private $conn;
 private $table = 'categories';
 
public $id;
public $name;
public $created_at;

  //Constructor with DB
  public function __construct($db) {
    $this->conn = $db;
  }

  //Get categories
  public function read() {

  //Create query
  $query = 'SELECT 
  id,
  name,
  created_at
FROM
'.$this->table.'
  ORDER BY 
  created_at DESC';

  //Prepare statement
  $stmt = $this->conn->prepare($query);
  $stmt->execute();
  
  return $stmt;


  }

  //GEt single Category

  public function read_single(){
//create query
$query = 'SELECT 
  id,
  name
FROM
'.$this->table.'
WHERE id =?
LIMIT 0,1';

//プリペアドステートメント
$stmt = $this->conn->prepare($query);
//Bind
$stmt->bindParam(1,$this->id);

//Execute query
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//Set properties
$this->id = $row['id'];
$this->name = $row['name'];
  
  }
  

}