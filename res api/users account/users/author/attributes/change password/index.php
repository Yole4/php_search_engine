<?php
    require_once("../../../../../configuration/config.php");
    session_start();

    if ($_SESSION['user_id'] == ""){
        header("Location: ../../../../../../index.php");
    }

    if (isset($_POST['save'])){
        $id = $_POST['id'];
        $curPass = $_POST['curPass'];
        $newPass = $_POST['newPass'];
        $conPass = $_POST['conPass'];

        $curPass = hash("sha256", $curPass);
        $newPass = hash("sha256", $newPass);
        $conPass = hash("sha256", $conPass);

        $test = false;

        if ($newPass === $conPass){
            $sql = $conn->prepare("SELECT password FROM research_secretary WHERE id = :id");
            $id = htmlspecialchars(strip_tags($id));
            $sql->bindParam(":id", $id);
            $sql->execute();
            $count = $sql->rowCount();

            if ($count > 0){
                $get = $sql->fetch(PDO::FETCH_ASSOC);
                $password = $get['password'];

                if ($password === $curPass){

                    $existPass = $conn->prepare("SELECT * FROM research_secretary WHERE password = :password");
                    $newPass = htmlspecialchars(strip_tags($newPass));
                    $existPass->bindParam(":password", $newPass);

                    $existCount = $existPass->rowCount();

                    if ($existCount == 0){
                        $stmt = $conn->prepare("UPDATE research_secretary SET password = :password WHERE id = :id");
                        $newPass = htmlspecialchars(strip_tags($newPass));
                        $id = htmlspecialchars(strip_tags($id));
                        $stmt->bindParam(":password", $newPass);
                        $stmt->bindParam(":id", $id);
                        $stmt->execute();
                        $tempCount = $stmt->rowCount();

                        if ($tempCount > 0){
                            $error = "Password has been successfully updated!";
                            $test = true;
                        }
                        else{
                            $error = "Something Went Wrong!";
                            $test = false;
                        }
                    }else{
                        $error = "Invalid new password! Please try again!";
                        $test = false;
                    }
                    
                }
                else{
                    $error = "Invalid Current Password!";
                    $test = false;
                }
                
            }
        }else{
            $error = "New Password and Confirm Password Not Match!";
            $test = false;
        }

        if (isset($_GET['id'])){
            $check = $_GET['id']; 
        }
        

        if ($test){
            if ($check == "home"){
                header("Location: ../../../../../../account controller/user accounts/author/index.php?success=$error");
            }
            else if ($check == "schedule"){
                header("Location: ../../../../../../account controller/user accounts/author/schedule for presentation/schedulePresentation.php?success=$error");
            }
            else if ($check == "public research"){
                header("Location: ../../../../../../account controller/user accounts/author/public research/index.php?success=$error");
            }
            else if ($check == "my work"){
                header("Location: ../../../../../../account controller/user accounts/author/my work/myWork.php?success=$error");
            }
        }
        else{
            if ($check == "home"){
                header("Location: ../../../../../../account controller/user accounts/author/index.php?already=$error");
            }
            else if ($check == "schedule"){
                header("Location: ../../../../../../account controller/user accounts/author/schedule for presentation/schedulePresentation.php?already=$error");
            }
            else if ($check == "public research"){
                header("Location: ../../../../../../account controller/user accounts/author/public research/index.php?already=$error");
            }
            else if ($check == "my work"){
                header("Location: ../../../../../../account controller/user accounts/author/my work/myWork.php?already=$error");
            }
        }
    }else{
        header("Location: ../../../../../../index.php");
    }
?>