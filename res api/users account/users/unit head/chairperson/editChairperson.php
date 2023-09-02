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
        $college = $_POST['college'];
        $currentEmail = $_POST['currentEmail'];

        //start
        if ($email != $currentEmail){
            $checkEmail = $conn->prepare("SELECT * FROM research_secretary WHERE email = :email AND isDelete = :isDelete");
            $checkEmail->execute(['email' => $email, 'isDelete' => "not"]);
            
            $checkCount = $checkEmail->rowCount();
            if ($checkCount > 0){
                header("Location: ../../../../../account controller/user accounts/unit head/chairperson account/index.php?already=Email is already in used!");
            }else{
                $stmt = $conn->prepare("UPDATE research_secretary SET fullname = :fullname, email = :email, college = :college WHERE id = :id");
                $stmt->execute(array(
                    'fullname' => $fullname,
                    'email' => $email,
                    'id' => $id,
                    'college' => $college
                ));

                $ihap = $stmt->rowCount();

                if ($ihap > 0){
                    header("Location: ../../../../../account controller/user accounts/unit head/chairperson account/index.php?success=Chairperson has been successfully updated!");
                }
            }
        }else{
            $stmt = $conn->prepare("UPDATE research_secretary SET fullname = :fullname, email = :email, college = :college WHERE id = :id");
            $stmt->execute(array(
                'fullname' => $fullname,
                'email' => $email,
                'id' => $id,
                'college' => $college
            ));

            $ihap = $stmt->rowCount();

            if ($ihap > 0){
                header("Location: ../../../../../account controller/user accounts/unit head/chairperson account/index.php?success=Chairperson has been successfully updated!");
            }else{
                header("Location: ../../../../../account controller/user accounts/unit head/chairperson account/index.php?success=Nothing change!");
            }
        }
        //end
    }else{
        header("Location: ../../../../../index.php");
    }
?>