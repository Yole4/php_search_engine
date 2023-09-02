<?php
    require_once("../../../../configuration/config.php");
    session_start();
    
    if ($_SESSION['user_id'] == ""){
        header("Location: ../../../../../index.php");
    }

    if (isset($_GET['delete'])){
        $id = $_GET['delete'];

        date_default_timezone_set('Asia/Manila');
        $date = date('F j, Y g:i:a');

        $select = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
        if ($select->execute(['id' => $id])){
            $row = $select->fetch(PDO::FETCH_ASSOC);
        }
        $research = $row['research'];
        $idSign = $row['id_sign'];

        $toDelete = $conn->prepare("UPDATE research_secretary SET isDelete = :isDelete, notification = :notification WHERE id_sign = :id_sign");
        $toDelete->execute(['id_sign' => $idSign, 'isDelete' => "Deleted", 'notification' => 1]);

        $mysql = $conn->prepare("UPDATE schedule_presentation SET isDelete = :isDelete WHERE research = :research");
        $mysql->execute(['research' => $research, 'isDelete' => "Deleted"]);

        $sql = $conn->prepare("UPDATE all_research_data SET isDelete = :isDelete, notification = :notification WHERE id = :id");
        if ($sql->execute(['id' => $id, 'isDelete' => "Deleted", 'notification' => 1])){

            $body = "You've successfully deleted data";
            $not = $conn->prepare("INSERT INTO notification SET body = :body, date = :date");
            $not->execute(['body' => $body, 'date' => $date]);

            //######    DO SOMETHING FROM NOTIFICATION ###########

            header("Location: ../../../../../account controller/user accounts/unit head/research work/index.php?success=Data and account/s has been successfully deleted!");
        }
        else{
            header("Location: ../../../../../account controller/user accounts/unit head/research work/index.php?already=Something went wrong!");
        }  
    }else{
        header("Location: ../../../../../index.php");
    }
?>