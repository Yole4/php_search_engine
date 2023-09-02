<?php
    require_once("../../../../configuration/config.php");
    session_start();

    if ($_SESSION['user_id'] == ""){
        header("Location: ../../../../../index.php");
    }

    if (isset($_POST['sendButton'])){
        $id = $_POST['sendId'];
        $approved = "Approved";
        $send_unit_head = "Unit Head";

        $mysql = $conn->prepare("SELECT * FROM schedule_presentation WHERE id = :id");
        $mysql->execute(['id' => $id]);

        $exist = $mysql->rowCount();

        if ($exist > 0){
            $get = $mysql->fetch(PDO::FETCH_ASSOC);
        }

        $AorN = $get['chairperson'];

        if ($AorN == "Approved"){
            header("Location: ../../../../../account controller/user accounts/chairperson/schedule for presentation/schedulePresentation.php?already=Data is already approved!");
        }
        else{
            $sql = $conn->prepare("UPDATE schedule_presentation SET chairperson = :chairperson, send_unit_head = :send_unit_head WHERE id = :id");
            $sql->execute(['id' => $id, 'chairperson' => $approved, 'send_unit_head' => $send_unit_head]);

            $count = $sql->rowCount();

            if ($count > 0){
                //success
                header("Location: ../../../../../account controller/user accounts/chairperson/schedule for presentation/schedulePresentation.php?success=Data has been sent to Unit Head!");
            }
        }
    }else{
        header("Location: ../../../../../index.php");
    }
?>