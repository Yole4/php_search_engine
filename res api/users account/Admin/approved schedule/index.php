<?php
    require_once("../../../configuration/config.php");
    session_start();

    if ($_SESSION['admin_id'] == null){
        header("Location: ../../../../index.php");
    }

    if (isset($_POST['sendButton'])){
        $id = $_POST['sendId'];
        $approved = "Approved";

        $mysql = $conn->prepare("SELECT * FROM schedule_presentation WHERE id = :id");
        $mysql->execute(['id' => $id]);

        $exist = $mysql->rowCount();

        if ($exist > 0){
            $get = $mysql->fetch(PDO::FETCH_ASSOC);
        }

        $AorN = $get['admin'];

        if ($AorN == "Approved"){
            header("Location: ../../../../account controller/admin/schedule for presentation/schedulePresentation.php?already=Data is already approved!");
        }
        else{
            $sql = $conn->prepare("UPDATE schedule_presentation SET admin = :admin WHERE id = :id");
            $sql->execute(['id' => $id, 'admin' => $approved]);

            $count = $sql->rowCount();

            if ($count > 0){
                //success
                header("Location: ../../../../account controller/admin/schedule for presentation/schedulePresentation.php?success=Data has been approved!");
            }
        }
    }else{
        header("Location: ../../../../index.php");
    }
?>