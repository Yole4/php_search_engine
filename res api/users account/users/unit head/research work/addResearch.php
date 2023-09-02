<?php
    require_once("../../../../configuration/config.php");
    session_start();

    if ($_SESSION['user_id'] == ""){
        header("Location: ../../../../../index.php");
    }

    if (isset($_POST['add'])){

        $RorE = $_POST['RorE'];
        $campus = $_POST['campus'];
        $countAuthor = $_POST['countAuthor'];
        $status = $_POST['category'];
        $dateProposed = $_POST['proposed'];
        $dateStarted = $_POST['started'];
        $dateCompleted = $_POST['completed'];

        //check the status
        //initialize checkProposed, checkOngoing, checkCompleted
        $checkProposed = false;
        $checkOngoing = false;
        $checkCompleted = false;

        if ($status === "Proposed"){
            $checkProposed = true;
        }else if ($status === "On-Going"){
            $checkOngoing = true;
        }else if ($status == "Completed"){
            $checkCompleted = true;
        }

        $added_by = "Unit Head";
        $rank = "Author";

        //set time zone to manila
        date_default_timezone_set('Asia/Manila');
        $date = date('F j, Y g:i:a');

        //proposed date
        $proposed = date('F j, Y', strtotime($dateProposed));

        //started date
        $started = date('F j, Y', strtotime($dateStarted));

        //completed date
        $completed = date('F j, Y', strtotime($dateCompleted));


        // given default image
        $image = "givenProfile.png";

        // get the value of college
        $research = $_POST['research'];
        $college = $_POST['college'];


        $arrayAuthor = array();
        $arrayEmail = array();

        $me = 1;
        for ($sample = 0; $sample < $countAuthor; $sample++){
            $authorField = 'author' . $me;
            $emailField = 'email' . $me;
            $me++;

            $arrayAuthor[] = $_POST[$authorField];
            $arrayEmail[] = $_POST[$emailField];
            
        }
        $authors = implode(', ',$arrayAuthor);

        $string = "abcdefjhigklmnopqrstuvwxyzABCDEFJHIGKLMNOPQRSTUVWXYZ1234567890";
        $randomPassword = substr(str_shuffle($string),0,8);

        $numbers = "abcdefjhijkLMNOPQRSTUvWxYz1234567890";
        $idSign = substr(str_shuffle($string),0,10);

        //$file = $_FILES('file');
        // print_r($_FILES('file'));
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
                    $file_destination = '../attributes/research documents/'. $file_name_new;
                    move_uploaded_file($file_temp, $file_destination); 

                    // check if the research is already exist!.
                    $checktitle = $conn->prepare("SELECT * FROM all_research_data WHERE research=:research AND isDelete = :isDelete");
                    $checktitle->execute(array(
                        'research' => $research,
                        'isDelete' => "not"
                    ));
                    $count = $checktitle->rowCount();

                    $checker = false;
                    
                    if ($count == 0){  # Change equal sign(==) to greater than sign(>) to execute the program else display research title is already exist!

                        if ($checkProposed){
                            $started = "";
                            $completed = "";   
                        }else if ($checkOngoing){
                            $completed = "";
                        }

                        $sql = $conn->prepare("INSERT INTO all_research_data SET research = :research, proposed = :proposed, started = :started, completed = :completed, document = :document, file_name = :file_name, authors = :authors, status = :status, id_sign = :id_sign, RorE = :RorE, campus = :campus, college = :college, added_by = :added_by, getname = :getname");
                        $sql->execute(array(
                            'research' => $research,
                            'authors' => $authors,
                            'status' => $status,
                            'id_sign' => $idSign,
                            'RorE' => $RorE,
                            'campus' => $campus,
                            'college' => $college,
                            'added_by' => $added_by,
                            'file_name' => $file_name,
                            'document' => $file_destination,
                            'proposed' => $proposed,
                            'started' => $started,
                            'completed' => $completed,
                            'getname' => $file_name_new
                        ));
                        $diff = $sql->rowCount();

                        if ($diff > 0){

                            $historySql = $conn->prepare("INSERT INTO history SET research = :research, proposed = :proposed, started = :started, completed = :completed, document = :document, file_name = :file_name, authors = :authors, status = :status, RorE = :RorE, campus = :campus, college = :college, added_by = :added_by, getname = :getname");
                            $historySql->execute(array(
                                'research' => $research,
                                'authors' => $authors,
                                'status' => $status,
                                'RorE' => $RorE,
                                'campus' => $campus,
                                'college' => $college,
                                'added_by' => $added_by,
                                'file_name' => $file_name,
                                'document' => $file_destination,
                                'proposed' => $proposed,
                                'started' => $started,
                                'completed' => $completed,
                                'getname' => $file_name_new
                            ));

                            if ($countAuthor == 0){
                                $countAuthor = -1;
                            }

                            $hashRandomPassword = hash("sha256", $randomPassword);

                            for ($o = 0; $o < $countAuthor; $o++){

                                // $sqls = $conn->prepare("SELECT * FROM research_secretary WHERE email = :email AND rank = :rank");
                                // $sqls->execute(['email' => $arrayEmail[$o], 'rank' => "Author"]);

                                // $sqlsCount = $sqls->rowCount();

                                // if ($sqlsCount == 0){
                                    $insertAccount = $conn->prepare("INSERT INTO research_secretary SET fullname = :fullname, email = :email, password = :password, RorE = :RorE, campus = :campus, college = :college, rank = :rank, added_by = :added_by, date = :date, image = :image, id_sign = :id_sign");
                                    $insertAccount->execute(array(
                                        'fullname' => $arrayAuthor[$o],
                                        'email' => $arrayEmail[$o],
                                        'password' => $hashRandomPassword,
                                        'RorE' => $RorE,
                                        'campus' => $campus,
                                        'college' => $college,
                                        'rank' => $rank,
                                        'added_by' => $added_by,
                                        'date' => $date,
                                        'image' => $image,
                                        'id_sign' => $idSign
                                    ));
                                    
                                    $insertCount = $insertAccount->rowCount();
                                    
                                    if ($insertCount > 0){

                                        $subject = "Account Access";
                                        $body = "You can access now to JRMSU Research Development and Extension Portal using this email: " . $arrayEmail[$o] . " and password:" . $randomPassword . " given by the " . $added_by . " from " . $campus . " campus under the " . $college . " as " . $rank . "\n\n" . "Click here to login: jrmsu-red-smp.great-site.net";
                                        $string = array('recipient' => $arrayEmail[$o], 'subject' => $subject, 'body' => $body);

                                        $url = "https://script.google.com/macros/s/AKfycbw6EZkKfYk8KZ2zCUVfWmdr_B9h07UKMwwLvKGwCGxMP1Pc7rqun5I9dQ9iQsbhSzWAnA/exec";

                                        $ch = curl_init($url);

                                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                        $result = curl_exec($ch);

                                        $success = "Research data and author accounts has been successfully added!";
                                        $checker = true;
                                    }
                                // }else{
                                    
                                //     $got = $sqls->fetch(PDO::FETCH_ASSOC);
                                //     $myID = $got['id'];
                                //     $myId_sign = $got['id_sign'];
                                //     $myNewId_sign = $myId_sign.",". $idSign;

                                //     echo $myID. "<br>";
                                //     echo $myId_sign . "<br>";
                                //     echo $myNewId_sign . "<br>";
                                //     $stmt = $conn->prepare("UPDATE research_secretary SET id_sign = :id_sign WHERE id = :id");

                                //     if ($stmt->execute(['id_sign' => $myNewId_sign, 'id' => $myID])){

                                //         $subject = "Account Access";
                                //         $body = "You have new ". $RorE . " in titled ". $research . " from ". $campus. " campus college of " . $college . " added by " . $added_by ."."."\n\n" . "Click here to login: jrmsu-red-smp.great-site.net";
                                //         $string = array('recipient' => $arrayEmail[$o], 'subject' => $subject, 'body' => $body);

                                //         $url = "https://script.google.com/macros/s/AKfycbw6EZkKfYk8KZ2zCUVfWmdr_B9h07UKMwwLvKGwCGxMP1Pc7rqun5I9dQ9iQsbhSzWAnA/exec";

                                //         $ch = curl_init($url);

                                //         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                                //         curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
                                //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                //         $result = curl_exec($ch);

                                //         echo "<br><br>" . $myNewId_sign . "<br><br>";
                                //     }else{
                                //         echo "something wrong with author";
                                //     }
                                // }
                            }
                        }else{
                            $error = "Research has been successfully added and author's are not!";
                            $checker = false;
                        }
                        
                    }
                    else{
                        $error = "Research title is already exist!";
                        $checker = false;
                    }
                    if ($checker){
                        header("Location: ../../../../../account controller/user accounts/unit head/research work/index.php?success=$success");
                    }else{
                        header("Location: ../../../../../account controller/user accounts/unit head/research work/index.php?already=$error");
                    }
                    
                }else{
                    header("Location: ../../../../../account controller/user accounts/unit head/research work/index.php?already=File is too large to upload!");
                }
            }else{
                header("Location: ../../../../../account controller/user accounts/unit head/research work/index.php?already=There was an error in uploading your file!");
            }
        }else{
            header("Location: ../../../../../account controller/user accounts/unit head/research work/index.php?already=You connot upload this file type!");
        }
    }else{
        header("Location: ../../../../../index.php");
    }
?>
