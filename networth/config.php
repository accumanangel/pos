<?php
 /**
  * DATABASE CONNECTION CLASS
  */
 class Database
 {
  private $servername;
  private $username;
  private $password;
  private $dbname;


  public function connect()
  {
      $this->servername="localhost";
      $this->username="root";
      $this->password="******";
      $this->dbname="networth";

      try {
        $dsn="mysql:host=".$this->servername.";dbname=".$this->dbname.";";
        $pdo=new PDO($dsn,$this->username,$this->password);
        return $pdo;
        echo "Connected";

      } catch (PDOException $e) {
        echo "Connection failed: ".$e->getMessage();
      }
  }
 }
?>




