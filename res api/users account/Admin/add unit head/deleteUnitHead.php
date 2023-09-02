<?php
    require_once("../../../configuration/config.php");
    session_start();

    if ($_SESSION['admin_id'] == ""){
        header("Location: ../../../../index.php");
    }

    if (isset($_GET['delete'])){
        $id = $_GET['delete'];

        $sql = $conn->prepare("UPDATE research_secretary SET isDelete = :isDelete, notification = :notification WHERE id = :id");
        $sql->execute(['id' => $id, 'notification' => 1, 'isDelete' => "Deleted"]);

        $count = $sql->rowCount();
        if ($count > 0){
            header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?success=Unit head account has been successfully deleted!");
        }
        else{
            header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?already=Error!");
        }
    }else{
        header("Location: ../../../../index.php");
    }
?>