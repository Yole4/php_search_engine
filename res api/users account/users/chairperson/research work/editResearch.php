<?php
    require_once("../../../../configuration/config.php");
    session_start();

    if ($_SESSION['user_id'] == ""){
        header("Location: ../../../../../index.php");
    }
    
    if (isset($_POST['add'])){
        $id = $_POST['my_id'];
        $research = $_POST['research'];
        $author = $_POST['author'];
        $status = $_POST['category'];
        $proposed = $_POST['proposed'];
        $started = $_POST['started'];
        $completed = $_POST['completed'];
        $college = $_POST['college'];
        $historyRorE = $_POST['historyRorE'];
        $historyCampus = $_POST['historyCampus'];

        $file_name = $_FILES['file']['name'];
        $file_temp = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_error = $_FILES['file']['error'];
        $file_type = $_FILES['file']['type'];

        $file_exp = explode('.', $file_name);
        $file_actual = strtolower(end($file_exp));

        $allowed = array('docx');

        if (in_array($file_actual, $allowed)){
            if ($file_error === 0){
                if ($file_size < 5242880){
                    $file_name_new = uniqid('', true).".".$file_actual;
                    $file_destination = '../../unit head/attributes/research documents/'. $file_name_new;
                    move_uploaded_file($file_temp, $file_destination); 

                    try{

                        if ($status == "Proposed"){
                            $historyProposed = $proposed;
                            $historyOnGoing = "";
                            $historyCompleted = "";
                        }else if ($status == "On-Going"){
                            $historyProposed = $proposed;
                            $historyOnGoing = $started;
                            $historyCompleted = "";
                        }else if ($status == "Completed"){
                            $historyProposed = $proposed;
                            $historyOnGoing = $started;
                            $historyCompleted = $completed;
                        }

                        $historySql = $conn->prepare("INSERT INTO history SET RorE = :RorE, campus = :campus, research = :research, proposed = :proposed, started = :started, completed = :completed, document = :document, file_name = :file_name, authors = :authors, status = :status, college = :college, added_by = :added_by, getname = :getname");
                        $historySql->execute(array(
                            'RorE' => $historyRorE,
                            'campus' => $historyCampus,
                            'research' => $research,
                            'authors' => $author,
                            'status' => $status,
                            'college' => $college,
                            'added_by' => "Chairperson",
                            'file_name' => $file_name,
                            'document' => $file_destination,
                            'proposed' => $historyProposed,
                            'started' => $historyOnGoing,
                            'completed' => $historyCompleted,
                            'getname' => $file_name_new
                        ));

                        $sql = "UPDATE all_research_data SET added_by = :added_by, getname = :getname, college = :college, research = :research, authors = :authors, status = :status, proposed = :proposed, started = :started, completed = :completed, document = :document, file_name = :file_name WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(array(
                            'college' => $college,
                            'research' => $research,
                            'authors' => $author,
                            'status' => $status,
                            'proposed' => $historyProposed,
                            'started' => $historyOnGoing,
                            'completed' => $historyCompleted,
                            'document' => $file_destination,
                            'file_name' => $file_name,
                            'getname' => $file_name_new,
                            'added_by' => "Chairperson",
                            'id' => $id
                        ));
                        $good = $stmt->rowCount();
                        if ($good > 0){
                            $_SESSION['author'] = $_POST['author'];
                            header("Location: ../../../../../account controller/user accounts/chairperson/research works/index.php?success=Research has been successully updated!");
                        }
                        else{
                            header("Location: ../../../../../account controller/user accounts/chairperson/research works/index.php?already=Faild to Add Data!");
                        }
                    
                        
    
                    }catch(PDOException $e){
                        echo $e->getMessage();
                    }
                    
                }else{
                    header("Location: ../../../../../account controller/user accounts/chairperson/research works/index.php?already=File is too large to upload!");
                }
            }else{
                header("Location: ../../../../../account controller/user accounts/chairperson/research works/index.php?already=There was an error in uploading your file!");
            }
        }else{
            header("Location: ../../../../../account controller/user accounts/chairperson/research works/index.php?already=You connot upload this file type!");
        }
    }else{
        header("Location: ../../../../../index.php");
    }
?>

