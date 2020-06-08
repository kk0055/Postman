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

//Create category
public function create() {
  $query = 'INSERT INTO ' .
  $this->table . '
  SET
  name =:name';

  //Prepare statement
  $stmt = $this->conn->prepare($query);
 
  //Clean data
  $this->name = htmlspecialchars(strip_tags($this->name));

  //Bind
  $stmt->bindParam(':name' , $this->name);

  //Execute
  if($stmt->execute()) {
    return true;
  }

  //Error
  printf("Error: $s.\n",$stmt->error);

  return false;

} 

//Update cate
public function update() {
  //query作成
  $query = 'UPDATE ' .
  $this->table . '
  SET
  name = :name
  WHERE id =:id  ';

  //Prepare statement
  $stmt = $this->conn->prepare($query);

    // Clean data
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->id = htmlspecialchars(strip_tags($this->id));
  // Bind data
  $stmt-> bindParam(':name', $this->name);
  $stmt-> bindParam(':id', $this->id);

  // Execute query
  if($stmt->execute()) {
    return true;
  }

  // Print error if something goes wrong
  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  //Delete category
  public function delete() {
    //Query
    $query = 'DELETE FROM' 
    .$this->table . '
    WHERE id = :id';

     //Prepare statement
  $stmt = $this->conn->prepare($query);
    // clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    //Bind data
    $stmt->bindParam(':id', $this->id);

    //Execute
    if($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: $s.\n", $stmt->error);

    return false;
    
  }
}
