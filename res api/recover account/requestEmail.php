<?php
    require_once("../configuration/config.php");
    session_start();

    if(isset($_POST['sendRequest'])){
        $email = $_POST['email'];

        $numbers = "1234567890";
        $code = substr(str_shuffle($numbers),0,6);

        $sql = $conn->prepare("SELECT * FROM research_secretary WHERE email = :email");
        $sql->execute(['email' => $email]);
        $count = $sql->rowCount();
        
        if ($count > 0) {
            $get = $sql->fetch(PDO::FETCH_ASSOC);

            $id = $get['id'];
            $myEmail = $get['email'];

            $subject = "Verification Code";
            $body = "Your Verification code is ". $code;
            $string = array('recipient' => $myEmail, 'subject' => $subject, 'body' => $body);

            $url = "https://script.google.com/macros/s/AKfycbw6EZkKfYk8KZ2zCUVfWmdr_B9h07UKMwwLvKGwCGxMP1Pc7rqun5I9dQ9iQsbhSzWAnA/exec";

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);

            $_SESSION['code'] = $code;
            $_SESSION['id'] = $id;
            header("Location: ../../Confirm Email/sendCode.php");
        }else{
            $_SESSION['lastEmail'] = $email;
            header("Location: ../../index.php?already=Email Not Found!");
        }

    }else{
        header("Location: ../../index.php");
    }
?>