 
 <?php

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "red";


    $sdn = 'mysql:host=' . $host . ';dbname=' . $dbname;
    $conn = new PDO($sdn, $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

?>
