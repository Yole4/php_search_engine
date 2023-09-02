<?php
    require_once("../../../configuration/config.php");
    session_start();

    if ($_SESSION['admin_id'] == ""){
        header("Location: ../../../../index.php");
    }

    if (isset($_GET['delete'])){
        $id = $_GET['delete'];

        $sql = $conn->prepare("UPDATE research_secretary SET isDelete = :isDelete, notification = :notification WHERE id = :id");
        $sql->execute(['id' => $id, 'isDelete' => "Deleted", 'notification' => 1]);

        $count = $sql->rowCount();
        if ($count > 0){
            header("Location: ../../../../account controller/admin/author/index.php?success=Author account has been successfully deleted!");
        }
        else{
            header("Location: ../../../../account controller/admin/author/index.php?already=Something went wrong!");
        }
    }else{
        header("Location: ../../../../index.php");
    }
?>