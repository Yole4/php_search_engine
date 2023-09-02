<?php
    require_once("../../../../configuration/config.php");
    session_start();

    if ($_SESSION['user_id'] == ""){
        header("Location: ../../../../../index.php");
    }

    if (isset($_POST['submitButton'])){

        $id = $_POST['saveId'];

        // $requestFile = $_POST['requestFile'];
        $anotherRemarks = $_POST['remarks'];

        date_default_timezone_set('Asia/Manila');
        $date = date('F j, Y g:i:a');

        // echo $requestFile, $remarks, $RorE, $campus, $college, $research;
        $file_name = $_FILES['file']['name'];
        $file_temp = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_error = $_FILES['file']['error'];
        $file_type = $_FILES['file']['type'];

        $file_exp = explode('.', $file_name);
        $file_actual = strtolower(end($file_exp));

        $allowed = array('pdf', 'docx');

        $checker = false;
        
        if ($file_size == 0){
            // $checker = false;
            $sql = $conn->prepare("UPDATE schedule_presentation SET remarks = :remarks WHERE id = :id");
            $sql->execute([
                'remarks' => $anotherRemarks,
                'id' => $id
            ]);

            $countSql = $sql->rowCount();

            // if ($countSql > 0){
                header("Location: ../../../../../account controller/user accounts/unit head/schedule for presentation/schedulePresentation.php?success=Data has been saved!");
            
        }else{
            $checker = true;
        }
        if ($checker){
            if (in_array($file_actual, $allowed)){
                if ($file_error === 0){
                    if ($file_size < 5242880){
                        $file_name_new = uniqid('', true).".".$file_actual;
                        $file_destination = '../attributes/requested files/'. $file_name_new;
                        move_uploaded_file($file_temp, $file_destination); 

                        $sql = $conn->prepare("UPDATE schedule_presentation SET request_file = :request_file, file_name = :file_name, remarks = :remarks WHERE id = :id");
                        $sql->execute([
                            'request_file' => $file_destination,
                            'file_name' => $file_name,
                            'remarks' => $anotherRemarks,
                            'id' => $id
                        ]);

                        $countSql = $sql->rowCount();

                        if ($countSql > 0){
                            header("Location: ../../../../../account controller/user accounts/unit head/schedule for presentation/schedulePresentation.php?success=Data has been saved!");
                        }

                    }else{
                        header("Location: ../../../../../account controller/user accounts/unit head/schedule for presentation/schedulePresentation.php?already=File is too large to upload!");
                    }
                }else{
                    header("Location: ../../../../../account controller/user accounts/unit head/schedule for presentation/schedulePresentation.php?already=There was an error in uploading your file!");
                }
            }else{
                header("Location: ../../../../../account controller/user accounts/unit head/schedule for presentation/schedulePresentation.php?already=You connot upload this file type!");
            }
        }
    }else{
        header("Location: ../../../../../index.php");
    }
?>