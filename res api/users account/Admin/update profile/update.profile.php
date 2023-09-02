<?php
    include_once("../../../configuration/config.php");
    session_start();

    if (isset($_POST['save'])){

        $id = $_POST['id'];
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $currentEmail = $_POST['currentEmail'];

        $image = $_FILES['file']['name'];
        $image_size = $_FILES['file']['size'];
        $tmp_name = $_FILES['file']['tmp_name'];
        $error = $_FILES['file']['error'];

        $test = false;

        if ($error == 0){
            if ($image_size > 1100000){
                $result = "Image file is too large!";
                $test = false;
            }
            else{
                $image_extension = pathinfo($image, PATHINFO_EXTENSION);
                $image_lower = strtolower($image_extension);

                $allowed_image = array("jpg", "jpeg", "png");

                if (in_array($image_lower, $allowed_image)){
                    $new_image = uniqid("IMG-", true). '.' . $image_lower;
                    $image_upload = '../../users/unit head/attributes/profile upload/' . $new_image;
                    move_uploaded_file($tmp_name, $image_upload);

                    if ($email != $currentEmail){
                        $checkEmail = $conn->prepare("SELECT * FROM research_secretary WHERE email = :email AND isDelete = :isDelete");
                        
                        $checkEmail->execute(['email' => $email, 'isDelete' => "not"]);
                        $countEmail = $checkEmail->rowCount();

                        if ($countEmail > 0){
                            $result = "Email is already in used!";
                            $test = false;
                        }else{
                            $sql = $conn->prepare("UPDATE research_secretary SET image = :image, fullname = :fullname, email = :email, phone_number = :phone_number WHERE id = :id");
                            $sql->execute([
                                'image' => $new_image, 
                                'id' => $id,
                                'fullname' => $fullname,
                                'email' => $email,
                                'phone_number' => $phone_number
                            ]);

                            $count = $sql->rowCount();
                            if ($count > 0){
                                $result = "Profile successfully updated!";
                                $test = true;
                            }else{
                                $result = "Something wrong from the image!";
                                $test = false;
                            }
                        }
                    }
                    else{
                        $sql = $conn->prepare("UPDATE research_secretary SET image = :image, fullname = :fullname, email = :email, phone_number = :phone_number WHERE id = :id");
                        $sql->execute([
                            'image' => $new_image, 
                            'id' => $id,
                            'fullname' => $fullname,
                            'email' => $email,
                            'phone_number' => $phone_number
                        ]);

                        $count = $sql->rowCount();
                        if ($count > 0){
                            $result = "Profile successfully updated!";
                            $test = true;
                        }else{
                            $result = "Something wrong from the image!";
                            $test = false;
                        }
                    }

                }else{
                    $result = "Can't upload this file type!";
                    $test = false;
                }
            }
        }else{
            $result = "Something error!";
            $test = false;
        }

        if (isset($_GET['check'])){
            $check = $_GET['check'];
        }

        if ($test){
            if ($check == "home"){
                header("Location: ../../../../account controller/admin/admin.account.php?success=$result");
            }
            else if ($check == "unit head"){
                header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?success=$result");
            }
            else if ($check == "author"){
                header("Location: ../../../../account controller/admin/author/index.php?success=$result");
            }
            else if ($check == "research work"){
                header("Location: ../../../../account controller/admin/my added data/research.my.data.php?success=$result");
            }
            else if ($check == "public"){
                header("Location: ../../../../account controller/admin/public research/index.php?success=$result");
            }
            else if ($check == "schedule"){
                header("Location: ../../../../account controller/admin/schedule for presentation/schedulePresentation.php?success=$result");
            }
            else if ($check == "chairperson"){
                header("Location: ../../../../account controller/admin/secretary account/research.secretary.account.php?success=$result");
            }
        }else{
            if ($check == "home"){
                header("Location: ../../../../account controller/admin/admin.account.php?already=$result");
            }
            else if ($check == "unit head"){
                header("Location: ../../../../account controller/admin/add unit head account/addUnitHeadAccount.php?already=$result");
            }
            else if ($check == "author"){
                header("Location: ../../../../account controller/admin/author/index.php?already=$result");
            }
            else if ($check == "research work"){
                header("Location: ../../../../account controller/admin/my added data/research.my.data.php?already=$result");
            }
            else if ($check == "public"){
                header("Location: ../../../../account controller/admin/public research/index.php?already=$result");
            }
            else if ($check == "schedule"){
                header("Location: ../../../../account controller/admin/schedule for presentation/schedulePresentation.php?already=$result");
            }
            else if ($check == "chairperson"){
                header("Location: ../../../../account controller/admin/secretary account/research.secretary.account.php?already=$result");
            }
        }
    }else{
        header("Location: ../../../../index.php");
    }
?>