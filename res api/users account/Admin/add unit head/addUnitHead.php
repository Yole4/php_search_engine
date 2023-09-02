<?php
    require_once("../../../configuration/config.php");

    if (isset($_POST['addUnitHead'])){
        $campus = $_POST['sec_campus'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $RorE = $_POST['RorE'];
        $rank = "Unit Head";
        $image = "givenProfile.png";
        $added_by = "Admin";

        $hashPassword = hash('sha256', $password);
        
        date_default_timezone_set('Asia/Manila');
        $date = date('F j, Y g:i:a');

        $subject = "Account Access";
        $body = "you can now access to JRMSU Research Development And Extension Portal from " . $RorE.strtoupper() . " in " . $campus.strtoupper() . " as " . $rank.strtoupper() . " using this email: " . $email . " and password: " . $password . "\n\n" . "Click here to login: jrmsu-red-smp.great-site.net";

        $checkusername = $conn->prepare("SELECT * FROM research_secretary WHERE email = :email AND isDelete = :isDelete");
        $checkusername->execute(array(
            'email' => $email,
            'isDelete' => "not"
        ));
        $count = $checkusername->rowCount();

        if ($count==0){

            $sql = $conn->prepare("INSERT INTO research_secretary SET image = :image, added_by = :added_by, fullname = :fullname, email = :email, campus = :campus, password = :password, RorE = :RorE, rank = :rank, date = :date");
            
            
            if ($sql->execute(array(
                'image' => $image,
                'added_by' => $added_by,
                'fullname' => $fullname,
                'email' => $email,
                'password' => $hashPassword,
                'campus' => $campus,
                'RorE' => $RorE,
                'rank' => $rank,
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

                header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?success=Unit head account has been successfully added!");
            }else{
                header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?already=Faild to add!");
                
            }
        }
        else{
            header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?already=Email is already in used!");
        }
    }else{
        header("Location: ../../../../index.php");
    }
?>