<?php
    require_once("../../../../configuration/config.php");
    session_start();

    if ($_SESSION['user_id'] == ""){
        header("Location: ../../../../../index.php");
    }
    $myId = $_SESSION['user_id'];

    $public = $_SESSION['public'];
    
    if (isset($_GET['id'])){
        $id = $_GET['id'];

        date_default_timezone_set('Asia/Manila');
        $date = date('F j, Y g:i:a');

        $sql = $conn->prepare("SELECT * FROM research_secretary WHERE id = :id");
        if ($sql->execute(['id' => $myId])){
            $row = $sql->fetch(PDO::FETCH_ASSOC);
        }
        $name = $row['fullname'];
        $RorE = $row['RorE'];
        $campus = $row['campus'];
        $college = $row['college'];
        $position = "Author";

        if ($public == "Set Public"){
            $sql = $conn->prepare("UPDATE all_research_data SET publicize = :publicize WHERE id = :id");
            $sql->execute(['publicize' => "public", 'id' => $id]);

            $count = $sql->rowCount();
            if ($count > 0){

                $body = $name. " set their research into public!";
                $stmt = $conn->prepare("INSERT INTO notification SET body = :body, RorE = :RorE, campus = :campus, college = :college, position = :position, date = :date");
                $stmt->execute(array(
                    'body' => $body,
                    'RorE' => $RorE,
                    'campus' => $campus,
                    'college' => $college,
                    'position' => $position,
                    'date' => $date
                ));
                $c = $stmt->rowCount();
                if ($c > 0){
                    echo "success";
                }else{
                    echo "something went wrong!";
                    echo $name, $RorE, $campus, $college, $position;
                    echo $id;
                }

                header("Location: ../../../../../account controller/user accounts/author/my work/myWork.php?success=Your research is now available on public.");
            }else{
                header("Location: ../../../../../account controller/user accounts/author/my work/myWork.php?already=Something is error!");
            }
        }else if ($public == "Retrieve from public"){
            $sql = $conn->prepare("UPDATE all_research_data SET publicize = :publicize WHERE id = :id");
            $sql->execute(['publicize' => "not", 'id' => $id]);

            $count = $sql->rowCount();
            if ($count > 0){

                $body = $name. " retrieve their research from public!";
                $stmt = $conn->prepare("INSERT INTO notification SET body = :body, RorE = :RorE, campus = :campus, college = :college, position = :position, date = :date");
                $stmt->execute(array(
                    'body' => $body,
                    'RorE' => $RorE,
                    'campus' => $campus,
                    'college' => $college,
                    'position' => $position,
                    'date' => $date
                ));

                header("Location: ../../../../../account controller/user accounts/author/my work/myWork.php?success=Research has been retrieved from public.");
            }else{
                header("Location: ../../../../../account controller/user accounts/author/my work/myWork.php?already=Something is error!");
            }
        }
    }else{
        header("Location: ../../../../../index.php");
    }
?>