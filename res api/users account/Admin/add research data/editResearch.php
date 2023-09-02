<?php
    require_once("../../../configuration/config.php");
    session_start();

    if ($_SESSION['admin_id'] == ""){
        header("Location: ../../../../index.php");
    }
    
    if (isset($_POST['add'])){
        $id = $_POST['my_id'];
        $RorE = $_POST['RorE'];
        $campus = $_POST['campus'];

        $college_dapitan = $_POST['college_dapitan'];
        $college_dipolog = $_POST['college_dipolog'];
        $college_katipunan = $_POST['college_katipunan'];
        $college_siocon = $_POST['college_siocon'];
        $college_sibuco = $_POST['college_sibuco'];
        $college_tampilisan = $_POST['college_tampilisan'];

        if ($campus == "Dapitan"){
            $college = $college_dapitan;
        }
        else if ($campus == "Dipolog"){
            $college = $college_dipolog;
        }
        else if ($campus == "Katipunan"){
            $college = $college_katipunan;
        }
        else if ($campus == "Siocon"){
            $college = $college_siocon;
        }
        else if ($campus == "Sibuco"){
            $college = $college_sibuco;
        }
        else if ($campus == "Tampilisan"){
            $college = $college_tampilisan;
        }

        $research = $_POST['research'];
        $author = $_POST['author'];
        $status = $_POST['category'];
        $dateProposed = $_POST['proposed'];
        $dateStarted = $_POST['started'];
        $dateCompleted = $_POST['completed'];

        //set time zone to manila
        date_default_timezone_set('Asia/Manila');
        $date = date('F j, Y g:i:a');

        //proposed date
        $proposed = date('F j, Y', strtotime($dateProposed));

        //started date
        $started = date('F j, Y', strtotime($dateStarted));

        //completed date
        $completed = date('F j, Y', strtotime($dateCompleted));

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
                    $file_destination = '../../users/unit head/attributes/research documents/'. $file_name_new;
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

                        $historySql = $conn->prepare("INSERT INTO history SET research = :research, proposed = :proposed, started = :started, completed = :completed, document = :document, file_name = :file_name, authors = :authors, status = :status, RorE = :RorE, campus = :campus, college = :college, added_by = :added_by, getname = :getname");
                        $historySql->execute(array(
                            'research' => $research,
                            'authors' => $author,
                            'status' => $status,
                            'RorE' => $RorE,
                            'campus' => $campus,
                            'college' => $college,
                            'added_by' => "Admin",
                            'file_name' => $file_name,
                            'document' => $file_destination,
                            'proposed' => $historyProposed,
                            'started' => $historyOnGoing,
                            'completed' => $historyCompleted,
                            'getname' => $file_name_new
                        ));

                        $sql = "UPDATE all_research_data SET getname = :getname, research = :research, RorE = :RorE, campus = :campus, college = :college, authors = :authors, status = :status, proposed = :proposed, started = :started, completed = :completed, document = :document, file_name = :file_name WHERE id = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute(array(
                            'research' => $research,
                            'RorE' => $RorE,
                            'campus' => $campus,
                            'college' => $college,
                            'authors' => $author,
                            'status' => $status,
                            'proposed' => $historyProposed,
                            'started' => $historyOnGoing,
                            'completed' => $historyCompleted,
                            'document' => $file_destination,
                            'file_name' => $file_name,
                            'getname' => $file_name_new,
                            'id' => $id
                        ));
                        $good = $stmt->rowCount();
                        if ($good > 0){
                            $_SESSION['author'] = $_POST['author'];

                            $body = "Data has been successfully updated into Completed";
                            $not = $conn->prepare("INSERT INTO notification SET body = :body, date = :date");
                            $not->execute(['body' => $body, 'date' => $date]);

                            header("Location: ../../../../account controller/admin/my added data/research.my.data.php?success=Research has been successully updated!");
                        }
                        else{
                            header("Location: ../../../../account controller/admin/my added data/research.my.data.php?already=Something went wrong!");
                        }

                       
    
                    }catch(PDOException $e){
                        echo $e->getMessage();
                    }
                    
                }else{
                    header("Location: ../../../../account controller/admin/my added data/research.my.data.php?already=File is too large to upload!");
                }
            }else{
                header("Location: ../../../../account controller/admin/my added data/research.my.data.php?already=There was an error in uploading your file!");
            }
        }else{
            header("Location: ../../../../account controller/admin/my added data/research.my.data.php?already=You connot upload this file type!");
        }
    }else{
        header("Location: ../../../../index.php");
    }
?>

