<?php
    require_once("../../../configuration/config.php");
    session_start();

    if ($_SESSION['admin_id'] == ""){
        header("Location: ../../../../index.php");
    }

    if (isset($_POST['edit_btn'])){
        $id = $_POST['my_id'];
        $RorE = $_POST['RorE'];
        $campus = $_POST['campus'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $currentEmail = $_POST['currentEmail'];

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

        //start
        if ($email != $currentEmail){
            $checkEmail = $conn->prepare("SELECT * FROM research_secretary WHERE email = :email AND isDelete = :isDelete");
            $checkEmail->execute(['email' => $email, 'isDelete' => "not"]);
            
            $checkCount = $checkEmail->rowCount();
            if ($checkCount > 0){
                header("Location: ../../../../account controller/admin/author/index.php?success=Email is already in used!");
            }else{
                $stmt = $conn->prepare("UPDATE research_secretary SET RorE = :RorE, campus = :campus, fullname = :fullname, email = :email, college = :college WHERE id = :id");
                $stmt->execute(array(
                    'fullname' => $fullname,
                    'email' => $email,
                    'id' => $id,
                    'college' => $college,
                    'RorE' => $RorE,
                    'campus' => $campus
                ));

                $ihap = $stmt->rowCount();

                if ($ihap > 0){
                    header("Location: ../../../../account controller/admin/author/index.php?success=Author account has been successfully updated!");
                }
            }
        }else{
            $stmt = $conn->prepare("UPDATE research_secretary SET RorE = :RorE, campus = :campus, fullname = :fullname, email = :email, college = :college WHERE id = :id");
            $stmt->execute(array(
                'fullname' => $fullname,
                'email' => $email,
                'id' => $id,
                'college' => $college,
                'RorE' => $RorE,
                'campus' => $campus
            ));

            $ihap = $stmt->rowCount();

            if ($ihap > 0){
                header("Location: ../../../../account controller/admin/author/index.php?success=Author account has been successfully updated!");
            }else{
                header("Location: ../../../../account controller/admin/author/index.php?success=Nothing change!");
            }
        }
        //end
    }else{
        header("Location: ../../../../index.php");
    }
?>