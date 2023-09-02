<?php
    require_once("../configuration/config.php");
    session_start();
    if (isset($_POST['login'])){

        $email = $_POST["email"];
        $password = $_POST["password"];

        $hashPassword = hash('sha256', $password);
        $isDelete = "not";

        $adminchecker = "SELECT * FROM research_secretary WHERE email = :email AND password = :password AND isDelete = :isDelete";
        $stmt = $conn->prepare($adminchecker);
        $email = htmlspecialchars(strip_tags($email));
        $isDelete = htmlspecialchars(strip_tags($isDelete));
        $hashPassword = htmlspecialchars(strip_tags($hashPassword));
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":isDelete", $isDelete);
        $stmt->bindParam(":password", $hashPassword);

        $stmt->execute();

        $count = $stmt->rowCount();

        if ($count > 0){
            $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $user_id = $fetch['id'];
            $rank = $fetch['rank'];
            $pass = $fetch['password'];

            if ($hashPassword === $pass){
                if ($rank == "Unit Head"){
                    //Unit Head
                    $_SESSION['user_id'] = $user_id;
                    header("Location: ../../account controller/user accounts/unit head/index.php");
                }
                else if ($rank == "Chairperson"){
                    //Chairperson
                    $_SESSION['user_id'] = $user_id;
                    header("Location: ../../account controller/user accounts/chairperson/index.php");
                }
                else if ($rank == "Author"){
                    //Author
                    $_SESSION['user_id'] = $user_id;
                    header("Location: ../../account controller/user accounts/author/index.php");
                }
                else if ($rank == "Admin"){
                    $_SESSION['admin_id'] = $user_id;
                    header("Location: ../../account controller/admin/admin.account.php");
                }
            }else{
                $_SESSION['backEmail'] = $email;
                $_SESSION['backPassword'] = $password;
                header("Location: ../../index.php?invalid=Email or password is incorrect!");
            }
           
        }
        else{
            $_SESSION['backEmail'] = $email;
            $_SESSION['backPassword'] = $password;
            header("Location: ../../index.php?invalid=Email or password is incorrect!");
        }
    }else{
        header("Location: ../../index.php");
    }
?>