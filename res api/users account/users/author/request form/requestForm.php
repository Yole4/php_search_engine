<?php
    require_once("../../../../configuration/config.php");
    session_start();

    if ($_SESSION['user_id'] == ""){
        header("Location: ../../../../../index.php");
    }

    if (isset($_POST['sendToChairperson'])){
        // $requestFile = $_POST['requestFile'];
        $remarks = $_POST['remarks'];
        $RorE = $_POST['RorE'];
        $campus = $_POST['campus'];
        $college = $_POST['college'];
        $research = $_POST['researchTitle'];
        $authors = $_POST['authors'];

        $sentTo = "Chairperson";

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

        if (in_array($file_actual, $allowed)){
            if ($file_error === 0){
                if ($file_size < 5242880){
                    $file_name_new = uniqid('', true).".".$file_actual;
                    $file_destination = '../attributes/requested files/'. $file_name_new;
                    move_uploaded_file($file_temp, $file_destination); 

                    $select = $conn->prepare("SELECT * FROM schedule_presentation WHERE research = :research AND isDelete = :isDelete");
                    $select->execute(['research' => $research, 'isDelete' => "not"]);
                    $selectCount = $select->rowCount();

                    if ($selectCount == 0){
                        $sql = $conn->prepare("INSERT INTO schedule_presentation SET authors = :authors, request_file = :request_file, file_name = :file_name, remarks = :remarks, RorE = :RorE, campus = :campus, college = :college, date = :date, research = :research, send_chairperson = :send_chairperson");
                        $sql->execute(array(
                            'authors' => $authors,
                            'request_file' => $file_destination,
                            'file_name' => $file_name,
                            'remarks' => $remarks,
                            'RorE' => $RorE,
                            'campus' => $campus,
                            'college' => $college,
                            'research' => $research,
                            'date' => $date,
                            'send_chairperson' => $sentTo
                        ));

                        $sqlCount = $sql->rowCount();

                        if ($sqlCount > 0){
                            $myId = $_SESSION['user_id'];
                            $notification = $conn->prepare("SELECT * FROM research_secretary WHERE id = :id");
                            if ($notification->execute(['id' => $myId])){
                                $row = $notification->fetch(PDO::FETCH_ASSOC);
                            }
                            $RorE = $row['RorE'];
                            $campus = $row['campus'];
                            $college = $row['college'];
                            $position = "Author";
                            $sendTo = "Chairperson";

                            $body = $research. " request for schedule for presentation";

                            $send = $conn->prepare("INSERT INTO notification SET body = :body, RorE = :RorE, campus = :campus, college = :college, position = :position, send_chairperson = :send_chairperson, date = :date");
                            $send->execute(array(
                                'body' => $body,
                                'RorE' => $RorE,
                                'campus' => $campus,
                                'college' => $college,
                                'position' => $position,
                                'send_chairperson' => $sendTo,
                                'date' => $date
                            ));

                            header("Location: ../../../../../account controller/user accounts/author/schedule for presentation/schedulePresentation.php?success=Request file send successfully!");
                        }
                    }else{
                        header("Location: ../../../../../account controller/user accounts/author/schedule for presentation/schedulePresentation.php?already=You've already requested!");
                    }

                }else{
                    header("Location: ../../../../../account controller/user accounts/author/schedule for presentation/schedulePresentation.php?already=File is too large to upload!");
                }
            }else{
                header("Location: ../../../../../account controller/user accounts/author/schedule for presentation/schedulePresentation.php?already=There was an error in uploading your file!");
            }
        }else{
            header("Location: ../../../../../account controller/user accounts/author/schedule for presentation/schedulePresentation.php?already=You connot upload this file type!");
        }
    }else{
        header("Location: ../../../../../index.php");
    }
?>