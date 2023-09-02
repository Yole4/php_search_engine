<?php
    session_start();

    if(isset($_POST['sendingCode'])){
        $code = $_POST['code'];
        $codeVerification = $_SESSION['code'];

        if ($code === $codeVerification){
            header("Location: ../../Confirm Email/createNewPassword.php");
        }else{
            header("Location: ../../Confirm Email/sendCode.php?invalid=Invalid Code Please Try Again!");
        }
    }
    else{
        header("Location: ../../index.php");
    }
?>