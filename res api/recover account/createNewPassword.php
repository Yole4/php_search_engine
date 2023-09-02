<?php
    require_once("../configuration/config.php");
    session_start();

    if (isset($_POST['createNew'])){
        $password = $_POST['newPass'];
        $conPass = $_POST['conPass'];
        $id = $_SESSION['id'];
        if ($id === null){
            header("Location: ../../index.php");
        }

        if ($password === $conPass){

            $stmt = $conn->prepare("SELECT rank FROM research_secretary WHERE id = :id");
            if ($stmt->execute(['id' => $id])){
                $get = $stmt->fetch(PDO::FETCH_ASSOC);
                $rank = $get['rank'];

                $sql = $conn->prepare("UPDATE research_secretary SET password = :password WHERE id = :id");
                if ($sql->execute(['password' => $password, 'id' => $id])){

                    if ($rank == "Admin"){
                        $_SESSION['admin_id'] = $id;
                        header("Location: ../../account controller/admin/admin.account.php");
                    }
                    else if ($rank == "Unit Head"){
                        $_SESSION['user_id'] = $id;
                        header("Location: ../../account controller/user accounts/unit head/index.php");
                    }
                    else if ($rank == "Chairperson"){
                        $_SESSION['user_id'] = $id;
                        header("Location: ../../account controller/user accounts/chairperson/index.php");
                    }
                    if ($rank == "Author"){
                        $_SESSION['user_id'] = $id;
                        header("Location: ../../account controller/user accounts/author/index.php");
                    }
                }
            }
        }else{
            $_SESSION['newPass'] = $password;
            $_SESSION['conPass'] = $conPass;
            header("Location: ../../Confirm Email/createNewPassword.php?invalid=New password and confirm password not match!");
        }
    }
    else{
        header("Location: ../../index.php");
    }
?>