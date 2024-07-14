<?php
 //   error_reporting(0);
  require "connexion.php";
  $connexion = new DB;// connect to the database 
  $conn = $connexion->connexionPdo();
  $data = array();
  
  $request_method=$_SERVER["REQUEST_METHOD"];
  switch($request_method)
  {
    case 'GET':
      // Retrive user ID 
      if(!empty($_GET["id"]))
      {
        $id=intval($_GET["id"]);
        getUser($id);
      }
      else
      {
            getUsers();
      }
      break;
    default:
      // Invalid Request Method
      header("HTTP/1.0 405 Method Not Allowed");
      break;
  }

  /**
   *  This function helps to get all users lists
   */
  function getUsers(){
  global $conn;
  try{
  $query = "SELECT * FROM users" ;
  $stmt = $conn->prepare($query);
  $stmt->execute();
  while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
      $data['users'][] = $rows;
  }
  header("Content-Type:application/json");
  // output json data 
  echo json_encode($data);
 }catch(PDOException $e){
  error_log("An error occured !");
  return false;
 }
}


/**
 *  Fetch a specific user 
 */
function getUser($id){
      global $conn;
      try{
      $query = "SELECT * FROM users WHERE u_22id = :id_22" ;
      $stmt = $conn->prepare($query);
      $stmt->bindParam(":id_22",$id);
      $stmt->execute();
      while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
          $data['user'][] = $rows;
      }
      header("Content-Type:application/json");
      // output json data 
      echo json_encode($data);
    }catch(PDOException $e){
      error_log("An error occured !");
       return false;
     }
}

?>