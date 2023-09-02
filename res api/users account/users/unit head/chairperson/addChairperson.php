<?php
    require_once("../../../../configuration/config.php");
    session_start();

    if ($_SESSION['user_id'] == ""){
        header("Location: ../../../../../index.php");
    }
    
    if (isset($_POST['addsec'])){
        $campus = $_POST['campus'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rank = "Chairperson";
        $image = "givenProfile.png";
        $added_by = "Unit Head";
        $college = $_POST['college'];
        $RorE = $_POST['RorE'];

        date_default_timezone_set('Asia/Manila');
        $date = date('F j, Y g:i:a');

        $subject = "Account Access";
        $body = "The " . $added_by.strtoupper() . " added you as an " . $rank.strtoupper() . " for " . $RorE.strtoupper() . " from " . $campus.strtoupper(). " Campus under the college of " . $college.strtoupper() . ", You can now access using this email: " . $email . " and password: " . $password . "\n\n" . "Click here to login: jrmsu-red-smp.great-site.net";

        $checkusername = $conn->prepare("SELECT * FROM research_secretary WHERE email = :email AND isDelete = :isDelete");
        $checkusername->execute(array(
            'email' => $email,
            'isDelete' => "not"
        ));
        $count = $checkusername->rowCount();

        $hashPassword = hash("sha256", $password);

        if ($count==0){
            //$sql = $conn->prepare("INSERT INTO research_secretary (fullname, email, password, campus) VALUES (:fullname, :email, :password, :campus)");
            $sql = $conn->prepare("INSERT INTO research_secretary SET image = :image, RorE = :RorE, campus = :campus, added_by = :added_by, fullname = :fullname, email = :email, password = :password, rank = :rank, college = :college, date = :date");
            
            
            if ($sql->execute(array(
                'image' => $image,
                'RorE' => $RorE,
                'campus' => $campus,
                'added_by' => $added_by,
                'fullname' => $fullname,
                'email' => $email,
                'password' => $hashPassword,
                'rank' => $rank,
                'college' => $college,
                'date' => $date
            ))){
                $string = array('recipient' => $email, 'subject' => $subject, 'body' => $body);

                $url = "https://script.google.com/macros/s/AKfycbw6EZkKfYk8KZ2zCUVfWmdr_B9h07UKMwwLvKGwCGxMP1Pc7rqun5I9dQ9iQsbhSzWAnA/exec";
                // $id = "AKfycby1yFimiQaKMhrlU7yO7HDQmOn6DC4LMEGDlkNcC8UuUVs9Eh-J2fqf0iN_mN6PxdDVTw";

                $ch = curl_init($url);

                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $result = curl_exec($ch);

                header("Location: ../../../../../account controller/user accounts/unit head/chairperson account/index.php?success=Chairperson account has been successfully added!");
            }else{
                header("Location: ../../../../../account controller/user accounts/unit head/chairperson account/index.php?already=Faild to add!");
                
            }
        }
        else{
            header("Location: ../../../../../account controller/user accounts/unit head/chairperson account/index.php?already=Email is already in used!");
        }
        
    }else{
        header("Location: ../../../../../index.php");
    }
?>