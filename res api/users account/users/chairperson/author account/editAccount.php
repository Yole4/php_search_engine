<?php
    require_once("../../../../configuration/config.php");
    session_start();

    if ($_SESSION['user_id'] == ""){
        header("Location: ../../../../../index.php");
    }

    if (isset($_POST['edit_btn'])){
        $id = $_POST['my_id'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $currentEmail = $_POST['currentEmail'];

        //start
        if ($email != $currentEmail){
            $checkEmail = $conn->prepare("SELECT * FROM research_secretary WHERE email = :email AND isDelete = :isDelete");
            $checkEmail->execute(['email' => $email, 'isDelete' => "not"]);
            
            $checkCount = $checkEmail->rowCount();
            if ($checkCount > 0){
                header("Location: ../../../../../account controller/user accounts/chairperson/author/index.php?already=Email is already in used!");
            }else{
                $stmt = $conn->prepare("UPDATE research_secretary SET fullname = :fullname, email = :email WHERE id = :id");
                $stmt->execute(array(
                    'fullname' => $fullname,
                    'email' => $email,
                    'id' => $id
                ));

                $ihap = $stmt->rowCount();

                if ($ihap > 0){
                    header("Location: ../../../../../account controller/user accounts/chairperson/author/index.php?success=Author has been successfully updated!");
                }
            }
        }else{
            $stmt = $conn->prepare("UPDATE research_secretary SET fullname = :fullname, email = :email WHERE id = :id");
            $stmt->execute(array(
                'fullname' => $fullname,
                'email' => $email,
                'id' => $id
            ));

            $ihap = $stmt->rowCount();

            if ($ihap > 0){
                header("Location: ../../../../../account controller/user accounts/chairperson/author/index.php?success=Author has been successfully updated!");
            }else{
                header("Location: ../../../../../account controller/user accounts/chairperson/author/index.php?success=Nothing change!");
            }
        }
        //end
    }else{
        header("Location: ../../../../../index.php");
    }
?>