<?php
    require_once("../../../configuration/config.php");
    session_start();

    if ($_SESSION['admin_id'] == ""){
        header("Location: ../../../../index.php");
    }

    if (isset($_POST['edit_btn'])){
        $id = $_POST['my_id'];
        $RorE = $_POST['RorE'];
        $campus = $_POST['campus'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $currentEmail = $_POST['currentEmail'];

        if ($email != $currentEmail){
            $checkEmail = $conn->prepare("SELECT * FROM research_secretary WHERE email = :email AND isDelete = :isDelete");
            $checkEmail->execute(['email' => $email, 'isDelete' => "not"]);
            
            $checkCount = $checkEmail->rowCount();
            if ($checkCount > 0){
                header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?already=Email is already in used!");
            }else{
                $stmt = $conn->prepare("UPDATE research_secretary SET RorE = :RorE, campus = :campus, fullname = :fullname, email = :email WHERE id = :id");
                $stmt->execute(array(
                    'campus' => $campus,
                    'RorE' => $RorE,
                    'fullname' => $fullname,
                    'email' => $email,
                    'id' => $id
                ));

                $ihap = $stmt->rowCount();

                if ($ihap > 0){
                    header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?success=Unit Head account has been successfully updated!");
                }
            }
        }else{
            $mysql = $conn->prepare("UPDATE research_secretary SET RorE = :RorE, campus = :campus, fullname = :fullname, email = :email WHERE id = :id");
            $mysql->execute(array(
                'campus' => $campus,
                'RorE' => $RorE,
                'fullname' => $fullname,
                'email' => $email,
                'id' => $id
            ));

            $countEmail = $mysql->rowCount();

            if ($countEmail > 0){
                header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?success=Unit Head account has been successfully updated!");
            }else{
                header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?success=Nothing Change!");
            }
        }
    }else{
        header("Location: ../../../../index.php");
    }
?> 