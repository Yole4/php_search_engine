
<?php
	require_once("../../../../configuration/config.php");
    session_start();

    if ($_SESSION['user_id'] == ""){
        header("Location: ../../../../../index.php");
    }
    // ../../users/unit head/attributes/research documents/63f1da5c8f8155.65760610.docx
    // ../../users/unit head/attributes/research documents/63f1dfa2a6c1a4.80654731.docx
    // system flow, class diagram, entity RD.docx
	if(ISSET($_POST['download'])){
		$file = $_POST['myId'];
		$query = $conn->prepare("SELECT * FROM schedule_presentation WHERE id= :id");
		if ($query->execute(['id' => $file])){
            $fetch = $query->fetch(PDO::FETCH_ASSOC);
    
            header("Content-Disposition: attachment; filename = " .$fetch['file_name']);
            header("Content-Type: application/octet-stream;");
            readfile($fetch['request_file']);
        }
	}else{
        header("Location: ../../../../../index.php");
    }
?>
