<?php

require_once("res api/configuration/config.php");

// // $email = "sample@gmail.com";
// $password = "123";

// $hashPassword = hash("sha256", $password);
// $id = 106;


// $sql = $conn->prepare("UPDATE research_secretary SET password = :password WHERE id = :id");
// $password = htmlspecialchars(strip_tags($password));
// $id = htmlspecialchars(strip_tags($id));

// $sql->bindParam(":password", $hashPassword);
// $sql->bindParam(":id", $id);

// $sql->execute();

// $count = $sql->rowCount();
// if ($count > 0){
//     echo "Sample password has been successfully added!";
// }else{
//     echo "not";
// }


// $hashPassword = hash("sha256", $password);

// // echo "Helo";
// // echo "<br/>";

// $mySql = $conn->prepare("SELECT * FROM testing WHERE email = :email");
// $email = htmlspecialchars(strip_tags($email));
// $mySql->bindParam(":email", $email);
// $mySql->execute();
// $count = $mySql->rowCount();

// if ($count > 0){
//     $row = $mySql->fetch(PDO::FETCH_ASSOC);
// }
// $getPassword = $row['password'];
// echo "Password in DB: $getPassword<br>";
// echo "Input Password: $hashPassword";

// if (password_verify($getPassword, $hashPassword)){
//     echo "success";
// }else{
//     echo "<br>not";
// }
// if ($getPassword == $hashPassword){
//     echo "success";
// }



// // $email = $_POST['email'];
// // $password = $_POST['password'];

// // $hashPassword = hash("sha256", $password);

// $sql = $conn->prepare("SELECT * FROM testing WHERE email = :email AND password = :password");
// $email = htmlspecialchars(strip_tags($email));
// $sql->bindParam(":email", $email);
// $sql->bindParam(":password", $hashPassword);
// $sql->execute();

// $count = $sql->rowCount();

// if ($count > 0) {
//     // Successful login
//     session_start();
//     $_SESSION['email'] = $email;
//     // header("Location: dashboard.php"); // Redirect to dashboard
//     echo "Successfully login";
// } else {
//     // Invalid login
//     // header("Location: login.php?error=1"); // Redirect back to login page with error parameter
//     echo "something went wrong";
// }


// $sql = $conn->prepare("SELECT * FROM ")
sleep(5);
?>
