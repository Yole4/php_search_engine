<?php
    require_once("../../../configuration/config.php");
    session_start();

    if ($_SESSION['admin_id'] == ""){
        header("Location: ../../../../index.php");
    }
    if (isset($_POST['save'])){
        $id = $_POST['id'];
        $curPass = $_POST['curPass'];
        $newPass = $_POST['newPass'];
        $conPass = $_POST['conPass'];

        $newPass = hash("sha256", $newPass);
        $conPass = hash("sha256", $conPass);
        $curPass = hash("sha256", $curPass);

        $rank = "Author";

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

                    $existPass = $conn->prepare("SELECT * FROM research_secretary WHERE password = :password AND rank = :rank");
                    $newPass = htmlspecialchars(strip_tags($newPass));
                    $rank = htmlspecialchars(strip_tags($rank));
                    $existPass->bindParam(":password", $newPass);
                    $existPass->bindParam(":rank", $rank);

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
                        $error = "Invalid new password! try another one!";
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
            if ($check == "admin"){
                header("Location: ../../../../account controller/admin/admin.account.php?success=$error");
            }
            else if ($check == "author"){
                header("Location: ../../../../account controller/admin/author/index.php?success=$error");
            }
            else if ($check == "research"){
                header("Location: ../../../../account controller/admin/my added data/research.my.data.php?success=$error");
            }
            else if ($check == "chairperson"){
                header("Location: ../../../../account controller/admin/secretary account/research.secretary.account.php?success=$error");
            }
            else if ($check == "unit head"){
                header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?success=$error");
            }
            else if ($check == "publicize"){
                header("Location: ../../../../account controller/admin/public research/index.php?success=$error");
            }
            else if ($check == "schedule"){
                header("Location: ../../../../account controller/admin/schedule for presentation/schedulePresentation.php?success=$error");
            }
        }
        else{
            if ($check == "admin"){
                header("Location: ../../../../account controller/admin/admin.account.php?already=$error");
            }
            else if ($check == "author"){
                header("Location: ../../../../account controller/admin/author/index.php?already=$error");
            }
            else if ($check == "research"){
                header("Location: ../../../../account controller/admin/my added data/research.my.data.php?already=$error");
            }
            else if ($check == "chairperson"){
                header("Location: ../../../../account controller/admin/secretary account/research.secretary.account.php?already=$error");
            }
            else if ($check == "unit head"){
                header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?already=$error");
            }
            else if ($check == "publicize"){
                header("Location: ../../../../account controller/admin/public research/index.php?already=$error");
            }
            else if ($check == "schedule"){
                header("Location: ../../../../account controller/admin/schedule for presentation/schedulePresentation.php?already=$error");
            }
        }
    }else{
        header("Location: ../../../../index.php");
    }
?>