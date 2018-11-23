<?php include('database_connection.php');

function fetch_user_from_db($username)
{
  $statement = $pdo->prepare("SELECT * FROM users WHERE username = :username");
  
  $statement->execute(
    [
      ":username" => $username
    ]
  );

  return $statement->fetch(PDO::FETCH_ASSOC);
}