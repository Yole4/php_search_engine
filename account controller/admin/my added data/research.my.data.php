<?php
  require_once("../../../res api/configuration/config.php");
  session_start();
  if ($_SESSION['admin_id'] == ""){
    header("Location: ../../../index.php");
  }
  $admin_id = $_SESSION['admin_id'];

  $sql = $conn->prepare("SELECT * FROM research_secretary WHERE id = :id");
  if ($sql->execute(array('id' => $admin_id))){
    $fetch = $sql->fetch(PDO::FETCH_ASSOC);
    
  }
  $email = $fetch['email'];
  $password = $fetch['password'];
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Research List</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="../../../dist/img/dapitan-log.png">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../../plugins/datatables-bs4/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../plugins/datatables-responsive/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
         #loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background-color: lightblue;
            padding: 30px;
            font-size:30px;
            border-radius: 5px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
         }

         #plagiarismResult {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background-color: lightblue;
            padding: 30px;
            font-size:30px;
            border-radius: 5px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
         }

         #history {
          position: fixed;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          z-index: 9999;
          background-color: #fff;
          padding: 30px;
          /* font-size:10p; */
          border-radius: 5px;
          box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
          /* height: 85%;
          width: 75%; */
          /* max-width: 85%; */
          max-height: 85%;
          width:85%;
        }
        .testHover{
          margin: 20px 20px 0px 20px; text-align: center; background-color: darkcyan; cursor: pointer; padding: 3px 0 3px 0; border-radius: 5px; box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
        }
        .testHover:hover{
          background-color: rgb(6, 177, 177);
        }
      </style>
  
</head>

<!-- Disable Mouse Right Click -->
<script>
    document.addEventListener("contextmenu", function(event){
      event.preventDefault();
    });
</script>

<body oncontextmenu="return false" class="hold-transition sidebar-mini" id="mutedBody">

  
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-primary navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../admin.account.php" class="nav-link">Home</a>
      </li>
      
<!-- =============================================================== PUBLICIZE RESEARCH ================================================================================== -->
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../public research/index.php" class="nav-link">Research & Extension Programs</a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
<!-- // ================================================================= NOTIFICATION =============================================================================== -->
<li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"><?php 
          $sqls = $conn->prepare("SELECT * FROM research_secretary WHERE notification = :notification");
          $sqls->execute(['notification' => 0]);

          $fetchsql = $conn->prepare("SELECT * FROM all_research_data WHERE notification = :notification");
          $fetchsql->execute(['notification' => 0]);

          $countA = $sqls->rowCount();
          $countD = $fetchsql->rowCount();

          $count = $countA + $countD;

          if ($count == 0){ 
            
          }
          else{
              echo $count;
          }
          ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="background-color:rgb(214, 192, 192)">
          <span class="dropdown-item dropdown-header"><?php echo $count." Notifications"; ?></span>
          <div class="dropdown-divider"></div>
          
          <?php
            //initialize
            $array = array();
            $date = array();
            $countNotification = 0;
            if ($countA > 0){
              while ($get = $sqls->fetch(PDO::FETCH_ASSOC)){
                $getRorE = $get['RorE'];
                $getCampus = $get['campus'];
                $getCollege = $get['college'];
                $getAddedBy = $get['added_by'];
                $getRank = $get['rank'];
                $getFullname = $get['fullname'];
                $convertDate = $get['date'];

                date_default_timezone_set('Asia/Manila');

                //proposed date
                $getDate = date('F j, Y h:i:s', strtotime($convertDate));

                // who are those added by admin
                if ($getAddedBy == "Admin"){
                  // Research
                  if ($getRorE == "Research"){
                    if ($getRank == "Unit Head"){
                      $text = "You added unit head account from Research from ". $getCampus . " campus";
                      array_unshift($array, $text);
                      array_unshift($date, $getDate);
                      $countNotification = $countNotification + 1;

                    }else if ($getRank == "Chairperson"){
                      $text = "You added chairperson account from Research in ". $getCollege . " from ". $getCampus. " campus";
                      array_unshift($array, $text);
                      array_unshift($date, $getDate);
                      $countNotification = $countNotification + 1;

                    }else if ($getRank == "Author"){
                      $text = "You added author account from Research in ". $getCollege . " from ". $getCampus . " campus";
                      array_unshift($array, $text);
                      array_unshift($date, $getDate);
                      $countNotification = $countNotification + 1;

                    }
                  }
                  // Extension
                  else if ($getRorE == "Extension"){
                    if ($getRank == "Unit Head"){
                      $text = "You added unit head account from Extension from ". $getCampus . " campus";
                      array_unshift($array, $text);
                      array_unshift($date, $getDate);
                      $countNotification = $countNotification + 1;

                    }else if ($getRank == "Chairperson"){
                      $text = "You added chairperson account from Extension in ". $getCollege . " from ". $getCampus. " campus";
                      array_unshift($array, $text);
                      array_unshift($date, $getDate);
                      $countNotification = $countNotification + 1;

                    }else if ($getRank == "Author"){
                      $text = "You added author account from Extension in ". $getCollege . " from ". $getCampus . " campus";
                      array_unshift($array, $text);
                      array_unshift($date, $getDate);
                      $countNotification = $countNotification + 1;

                    }
                  }
                }
                
                // Who are those added by the unit head
                else if ($getAddedBy == "Unit Head"){
                  //Research
                  if ($getRorE == "Research"){
                    if ($getRank == "Chairperson"){
                      $text = "Unit Head from " . $getCampus . " added chairperson account in Research from ". $getCollege;
                      array_unshift($array, $text);
                      array_unshift($date, $getDate);
                      $countNotification = $countNotification + 1;

                    }else if ($getRank == "Author"){
                      $text = "Unit Head from " . $getCampus . " added author account in Research from ". $getCollege;
                      array_unshift($array, $text);
                      array_unshift($date, $getDate);
                      $countNotification = $countNotification + 1;

                    }
                  }
                  
                  //Extension
                  else if ($getRorE == "Extension"){
                    if ($getRank == "Chairperson"){
                      $text = "Unit Head from " . $getCampus . " added chairperson account in Extension from ". $getCollege;
                      array_unshift($array, $text);
                      array_unshift($date, $getDate);
                      $countNotification = $countNotification + 1;

                    }else if ($getRank == "Author"){
                      $text = "Unit Head from " . $getCampus . " added author account in Extension from ". $getCollege;
                      array_unshift($array, $text);
                      array_unshift($date, $getDate);
                      $countNotification = $countNotification + 1;

                    }
                  }
                }
                
                //who are those added by Chairperson 
                else if ($getAddedBy == "Chairperson"){
                  if ($getRorE == "Research"){
                    if ($getRank == "Author"){
                      $text = "Author from " . $getCollege . " in " . $getCampus . " added author account in Research";
                      array_unshift($array, $text);
                      array_unshift($date, $getDate);
                      $countNotification = $countNotification + 1;

                    }
                  }else if ($getRorE == "Extension"){
                    if ($getRank == "Author"){
                      $text = "Author from " . $getCollege . " in " . $getCampus . " added author account in Extension";
                      array_unshift($array, $text);
                      array_unshift($date, $getDate);
                      $countNotification = $countNotification + 1;

                    }
                  }
                }
              }
            }
            if ($countD > 0){
              while ($got = $fetchsql->fetch(PDO::FETCH_ASSOC)){
                $gotRorE = $got['RorE'];
                $gotCampus = $got['campus'];
                $gotCollege = $got['college'];
                $gotResearch = $got['research'];
                $gotProposed = $got['proposed'];
                $gotAddedBy = $got['added_by'];
                $gotStatus = $got['status'];
                $convertDate = $got['date'];

                date_default_timezone_set('Asia/Manila');

                //proposed date
                $gotDate = date('F j, Y h:i:s', strtotime($convertDate));

                //Added by Admin
                if ($gotAddedBy == "Admin"){
                  //Research
                  if ($gotRorE == "Research"){
                    $myData = "You added research data from ". $gotCollege. " in Research from " . $gotCampus . " campus";
                    array_unshift($array, $myData);
                    array_unshift($date, $gotDate);
                    $countNotification = $countNotification + 1;

                  }

                  //Extension
                  else if ($gotRorE == "Extension"){
                    $myData = "You added research data from ". $gotCollege. " in Extension from " . $gotCampus . " campus";
                    array_unshift($array, $myData);
                    array_unshift($date, $gotDate);
                    $countNotification = $countNotification + 1;
                  }

                }
                //added by Unit Head
                else if ($gotAddedBy == "Unit Head"){
                  //Research
                  if ($gotRorE == "Research"){
                    $myData = "Unit Head added research data from ". $gotCollege. " in Research from " . $gotCampus . " campus";
                    array_unshift($array, $myData);
                    array_unshift($date, $gotDate);
                    $countNotification = $countNotification + 1;

                  }

                  //Extension
                  else if ($gotRorE == "Extension"){
                    $myData = "Unit Head added research data from ". $gotCollege. " in Extension from " . $gotCampus . " campus";
                    array_unshift($array, $myData);
                    array_unshift($date, $gotDate);
                    $countNotification = $countNotification + 1;

                  }
                }

                //added by Chairperson
                else if ($gotAddedBy == "Chairperson"){
                  //Research
                  if ($gotRorE == "Research"){
                    $myData = "Chairperson added research data from ". $gotCollege. " in Research from " . $gotCampus . " campus";
                    array_unshift($array, $myData);
                    array_unshift($date, $gotDate);
                    $countNotification = $countNotification + 1;

                  }

                  //Extension
                  else if ($gotRorE == "Extension"){
                    $myData = "Chairperson added research data from ". $gotCollege. " in Extension from " . $gotCampus . " campus";
                    array_unshift($array, $myData);
                    array_unshift($date, $gotDate);
                    $countNotification = $countNotification + 1;

                  }
                }
              }
            }

            if ($countNotification > 5){
              $countNotification = 5;
            }

            //assign array notification for see all notification
            $arr = $array;
            $myDate = $date;

            foreach ($array as &$text){
              $text = substr($text, 0, 42);
            }

            $array = array_slice($array, 0, $countNotification);

            for ($k = 0; $k < $countNotification; $k++){
              ?>
              <a href="#" class="dropdown-item" style="font-size:12px; background-color:lightblue;">
                <i class="fas fa-bell mr-2"></i> <?php echo $array[$k]. "...."; ?></p>
                <p style="margin-left:22px; font-size:10px;color:rgb(105, 96, 96)"><?php echo $date[$k]; ?></p>
              </a><div style="margin:2px"></div>
            <?php }
            
          ?>
          
          <div class="dropdown-divider"></div>
          <a data-toggle="modal" data-target="#allNotification" style="cursor:pointer" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
<!-- // =================================================================END OF NOTIFICATION =============================================================================== -->

      <!-- Admin Profile -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $fetch['fullname']; ?></span>
          <img style="width:25px; height:25px" class="img-profile rounded-circle" src="../../../res api/users account/users/unit head/attributes/profile upload/<?php echo $fetch['image']; ?>">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" data-toggle="modal" data-target="#profile" style="cursor:pointer"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
          </a>
          <a class="dropdown-item" data-toggle="modal" data-target="#change_password" style="cursor:pointer"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
              Change Password
          </a>
          <a class="dropdown-item" href="../../../res api/users account/Admin/logout/admin.logout.php" onclick="logout()">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </a>
        </div>
      </li>
      <!-- End of Profile -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../admin.account.php" class="brand-link">
      <img src="../../../dist/img/dapitan-log.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img style="width:34px; height:34px" src="../../../res api/users account/users/unit head/attributes/profile upload/<?php echo $fetch['image']; ?>" class="img-profile rounded-circle">
        </div>
        <div class="info">
          <a href="#" class="d-block" data-toggle="modal" data-target="#profile" style="cursor:pointer"><?php echo $fetch['fullname']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


        <!-- =========================================================== SCHEDULE FOR PRESENTATION ======================================================================================== -->
        <li class="nav-item has-treeview">
            <a href="../schedule for presentation/schedulePresentation.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p style="font-size:14.5px">
              Schedule For Presentation
              </p>
            </a>
          </li>
          
<!-- =========================================================== PUBLICIZE RESEARCH ======================================================================================== -->
          <li class="nav-item has-treeview">
            <a href="../public research/index.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                R & E Programs
              </p>
            </a>
          </li>

          

<!-- =========================================================== RESEARCH WORKS ======================================================================================== -->
          <li class="nav-item has-treeview">
            <a href="research.my.data.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                R & E Works
              </p>
            </a>
          </li>

<!-- =========================================================== UNIT HEAD ACCOUNT ======================================================================================== -->
          <li class="nav-item has-treeview">
            <a href="../add unit head account/addUnitHeadAccount.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Unit Head Accounts
              </p>
            </a>
          </li>

<!-- =========================================================== CHAIRPERSON ACCOUNTS ======================================================================================== -->

          <li class="nav-item has-treeview">
            <a href="../secretary account/research.secretary.account.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Chairperson Accounts
              </p>
            </a>
          </li>

<!-- =========================================================== AUTHOR ACCOUNTS ======================================================================================== -->

          <li class="nav-item has-treeview">
            <a href="../author/index.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Author Accounts
              </p>
            </a>
          </li>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2></h2>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<!-- Add Data -->

<!-- ===============================================  ALL NOTIFICATION  ========================================================================================== -->

<div class="modal fade" id="allNotification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color:rgb(214, 192, 192)">
        <h5 class="modal-title" id="exampleModalLabel"> Notifications</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"style="background-color:rgb(214, 192, 192)">
      <?php
              

              if ($countNotification == 0){
                echo "<span style='font-size:16px'>0 Notification Found!</span>";
              }else{
                for ($k = 0; $k < $count; $k++){
                  ?>
                  <a href="#" class="dropdown-item" style="font-size:12px; background-color:lightblue;">
                    <i class="fas fa-bell mr-2"></i> <?php echo $arr[$k]. "...."; ?></p>
                    <p style="margin-left:22px; font-size:10px;color:rgb(105, 96, 96)"><?php echo $myDate[$k]; ?></p>
                  </a><div style="margin:2px"></div>
                <?php }
              }
            ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="../../../res api/users account/Admin/add research data/index.php" method="POST" id="login-form" enctype="multipart/form-data"  onsubmit="loading()">
      <!-- <form action="../../../arraySampleAdd.php" method="POST" enctype="multipart/form-data"> -->
      <!-- <form action="../../../sampleAdd.php" method="POST" enctype="multipart/form-data"> -->

        <div class="modal-body">

            <div class="form-group">
              <label>Research/Extension</label><br>
              <select class="form-control" name="RorE">
                <option value="Research">Research</option>
                <option value="Extension">Extension</option>
              </select>
            </div>

            <div class="form-group">
              <label>Campus</label><br>
              <select class="form-control" name="campus" id="campus_id" onchange="choose_campus()">
                <option value="Dapitan">Dapitan</option>
                <option value="Dipolog">Dipolog</option>
                <option value="Katipunan">Katipunan</option>
                <option value="Siocon">Siocon</option>
                <option value="Sibuco">Sibuco</option>
                <option value="Tampilisan">Tampilisan</option>
              </select>
            </div>

      <!--====================== DAPITAN =======================-->
            <div class="form-group" style = "display:visible" id="dapitan">
              <label>College</label><br>
              <select class="form-control" name="college_dapitan" id="">
                <option value="CCS">CCS</option>
                <option value="CED">CED</option>
                <option value="CBA">CBA</option>
                <option value="CCJE">CCJE</option>
                <option value="CNAHS">CNAHS</option>
                <option value="CME">CME</option>
                <option value="COE">COE</option>
                <option value="CAS">CAS</option>
              </select>
            </div>
      <!--====================== DIPOLOG =======================-->
            <div class="form-group" style = "display:none" id="dipolog">
              <label>College</label><br>
              <select class="form-control" name="college_dipolog" id="">
                <option value="CED">CED</option>
                <option value="CAS">CAS</option>
                <option value="CIT">CIT</option>
                <option value="CBA">CBA</option>
                <option value="CCJE">CCJE</option>
              </select>
            </div>
      <!--====================== KATIPUNAN =======================-->
            <div class="form-group" style = "display:none" id="katipunan"> 
              <label>College</label><br>
              <select class="form-control" name="college_katipunan" id="">
                <option value="CBM">CBM</option>
                <option value="CAF">CAF</option>
                <option value="CCJE">CCJE</option>
                <option value="CCS">CCS</option>
                <option value="CED">CED</option>
              </select>
            </div>
      <!--====================== SIOCON =======================-->
            <div class="form-group" style = "display:none" id="siocon"> 
              <label>College</label><br>
              <select class="form-control" name="college_siocon" id="">
                <option value="CCS">CCS</option>
                <option value="CED">CED</option>
                <option value="CIT">CIT</option>
              </select>
            </div>
      <!--====================== SIBUCO =======================-->
            <div class="form-group" style = "display:none" id="sibuco"> 
              <label>College</label><br>
              <select class="form-control" name="college_sibuco" id="">
                <option value="#">#</option>
                <option value="#">#</option>
                <option value="#">#</option>
              </select>
            </div>
      <!--====================== TAMPILISAN =======================-->
            <div class="form-group" style = "display:none" id="tampilisan"> 
              <label>College</label><br>
              <select class="form-control" name="college_tampilisan" id="">
                <option value="CBA">CBA</option>
                <option value="CED">CED</option>
                <option value="SJCE">SJCE</option>
                <option value="SOE">SOE</option>
                <option value="CAF">CAF</option>
                <option value="CAS">CAS</option>
                <option value="CCS">CCS</option>
              </select>
            </div>

            <script>
              function choose_campus(){
                var check = document.getElementById("campus_id");
                if (check.value == "Dapitan"){
                  //dapitan
                  document.getElementById("dapitan").setAttribute("style", "display:visible");
                  document.getElementById("dipolog").setAttribute("style", "display:none");
                  document.getElementById("katipunan").setAttribute("style", "display:none");
                  document.getElementById("siocon").setAttribute("style", "display:none");
                  document.getElementById("sibuco").setAttribute("style", "display:none");
                  document.getElementById("tampilisan").setAttribute("style", "display:none");

                }
                else if (check.value == "Dipolog"){
                  //dipolog
                  document.getElementById("dapitan").setAttribute("style", "display:none");
                  document.getElementById("dipolog").setAttribute("style", "display:visible");
                  document.getElementById("katipunan").setAttribute("style", "display:none");
                  document.getElementById("siocon").setAttribute("style", "display:none");
                  document.getElementById("sibuco").setAttribute("style", "display:none");
                  document.getElementById("tampilisan").setAttribute("style", "display:none");
                }
                else if (check.value == "Katipunan"){
                  //Katipunan
                  document.getElementById("dapitan").setAttribute("style", "display:none");
                  document.getElementById("dipolog").setAttribute("style", "display:none");
                  document.getElementById("katipunan").setAttribute("style", "display:visible");
                  document.getElementById("siocon").setAttribute("style", "display:none");
                  document.getElementById("sibuco").setAttribute("style", "display:none");
                  document.getElementById("tampilisan").setAttribute("style", "display:none");
                }
                else if (check.value == "Siocon"){
                  //Siocon
                  document.getElementById("dapitan").setAttribute("style", "display:none");
                  document.getElementById("dipolog").setAttribute("style", "display:none");
                  document.getElementById("katipunan").setAttribute("style", "display:none");
                  document.getElementById("siocon").setAttribute("style", "display:visible");
                  document.getElementById("sibuco").setAttribute("style", "display:none");
                  document.getElementById("tampilisan").setAttribute("style", "display:none");
                }
                else if (check.value == "Sibuco"){
                  //Sibuco
                  document.getElementById("dapitan").setAttribute("style", "display:none");
                  document.getElementById("dipolog").setAttribute("style", "display:none");
                  document.getElementById("katipunan").setAttribute("style", "display:none");
                  document.getElementById("siocon").setAttribute("style", "display:none");
                  document.getElementById("sibuco").setAttribute("style", "display:visible");
                  document.getElementById("tampilisan").setAttribute("style", "display:none");
                }
                else if (check.value == "Tampilisan"){
                  //Tampilisan
                  document.getElementById("dapitan").setAttribute("style", "display:none");
                  document.getElementById("dipolog").setAttribute("style", "display:none");
                  document.getElementById("katipunan").setAttribute("style", "display:none");
                  document.getElementById("siocon").setAttribute("style", "display:none");
                  document.getElementById("sibuco").setAttribute("style", "display:none");
                  document.getElementById("tampilisan").setAttribute("style", "display:visible");
                }
              }
            </script>

            <div class="form-group">
                <label>Title</label>
                <input type="text" name="research" class="form-control" placeholder="Resesarch Title" required>
            </div>

            <div class="form-group">
                <label>Document</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            
            
            <div class="form-group">
              <label>Author <input type = "number" name="countAuthor" value = 0 onchange=numberOfAuthor(this.value) style="border-radius:5px; width:40px"></label>

            <div class="form-group" id = "sampleId" ></div>

              <script>
                
                function numberOfAuthor(val){
                  var author = "";
                  var email = "";
                  var s = 1;
      
                  for (var i = 0; i < val; i++){

                    author += '<input type="text" class="form-control" name="author' + s + '" id="' + i + '" placeholder="' + s + ' " required>';
                    author += '<input type="email" class="form-control" name="email'+ s +'" id="' + i + '" placeholder="Email" required><br>';
                    s++;
                  }
                  document.getElementById("sampleId").innerHTML = author;
                }
              </script>

            </div>
            <div class="form-group" style="margin-top:-20px">
              <label>Status</label><br>
              <select class="form-control" name="category" id="selectpsc" onchange="psc()">
                <option value="Proposed">Proposed</option>
                <option value="On-Going">On-Going</option>
                <option value="Completed">Completed</option>
              </select>
            </div>

            <div class="form-group" id = "proposed" style="display:visible">
              <label>Proposed</label>
              <input type="date" name="proposed" class="form-control" required>
            </div>

            <div class="form-group" id = "started" style="display:none">
              <label>Started</label>
              <input type="date" name="started" class="form-control">
            </div>

            <div class="form-group" id = "completed" style="display:none">
              <label>Completed</label>
              <input type="date" name="completed" class="form-control">
            </div>
            
            <script>
              function psc(){
                var check = document.getElementById("selectpsc");

                if (check.value == "Proposed"){
                  document.getElementById("proposed").setAttribute("style", "display:visible");
                  document.getElementById("started").setAttribute("style", "display:none");
                  document.getElementById("completed").setAttribute("style", "display:none");
                }
                else if (check.value == "On-Going"){
                  document.getElementById("proposed").setAttribute("style", "display:visible");
                  document.getElementById("started").setAttribute("style", "display:visible");
                  document.getElementById("completed").setAttribute("style", "display:none");
                }
                else if (check.value == "Completed") {
                  document.getElementById("proposed").setAttribute("style", "display:visible");
                  document.getElementById("started").setAttribute("style", "display:visible");
                  document.getElementById("completed").setAttribute("style", "display:visible");
                }
              }
              
            </script>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="add" class="btn btn-primary">Add</button>
        </div>
      </form>

    </div>
  </div>
</div>
<!-- End of Adding Data -->

<div class="modal fade" id="change_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../../../res api/users account/Admin/change/change.pass.php?id=research" method="post" onsubmit="loading()">
          <input type="hidden" name="id" value="<?php echo $admin_id; ?>"> 
          <div class="form-group">
              <span>Current Password</span> 
              <input class="form-control" type="password" name="curPass" placeholder="Current Password" id="curPass" required> 
              <i class="fa fa-eye-slash" style="font-size:20px; cursor:pointer; position:absolute; margin-top:-29px; margin-left: calc(100% - 75px);" onclick="curChange()" id="curEye"></i>
          </div>
          <div class="form-group">
              <span>New Password</span> 
              <input class="form-control" type="password" name="newPass" placeholder="New Password" id="newPass" required> 
              <i class="fa fa-eye-slash" style="font-size:20px; cursor:pointer; position:absolute; margin-top:-29px; margin-left: calc(100% - 75px);" onclick="newChange()" id="newEye"></i>
          </div>
          <div class="form-group">
              <span>Confirm Password</span> 
              <input class="form-control" type="password" name="conPass" placeholder="Confirm Password" id="conPass" required> 
              <i class="fa fa-eye-slash" style="font-size:20px; cursor:pointer; position:absolute; margin-top:-29px; margin-left: calc(100% - 75px);" onclick="conChange()" id="conEye"></i>
          </div>
          <div class="modal-footer"> 
              <button type="button" class="btn btn-secondary" data-dismiss="modal" name="cancel">Cancel</button>
              <button type="submit" name="save" class="btn btn-primary">Save</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<div class="modal fade" id="yole123" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="../../../res api/users account/Admin/add research data/editResearch.php" method="POST" enctype="multipart/form-data" onsubmit="loading()">

        <div class="modal-body">

            <input type="hidden" id="update_id" name="my_id">
            <input type="hidden" id="document1">
            <!-- <input type="text" id="stats"> -->
            <?php
              // echo $_SESSION['realId'];
            ?>
            <!-- <script>
              var statusValue = document.getElementById("stats").value;

            </script> -->

            <input type="hidden" id="Programs" name="programs">
            <input type="hidden" id="campuses">
            <input type="hidden" id="colleges">
            

            <div class="form-group">
              <label>Research/Extension</label><br>
              <select class="form-control" name="RorE" id="rId">
                <option value="Research">Research</option>
                <option value="Extension">Extension</option>
              </select>
            </div>

            <div class="form-group">
              <label>Campus</label><br>
              <select class="form-control" name="campus" id="campus_ids" onchange="choose_campuses()">
                <option value="Dapitan">Dapitan</option>
                <option value="Dipolog">Dipolog</option>
                <option value="Katipunan">Katipunan</option>
                <option value="Siocon">Siocon</option>
                <option value="Sibuco">Sibuco</option>
                <option value="Tampilisan">Tampilisan</option>
              </select>
            </div>

            <input type="hidden" id="collegeData">
      <!--====================== DAPITAN =======================-->
            <div class="form-group" style = "display:visible" id="dapitans">
              <label>College</label><br>
              <select class="form-control" name="college_dapitan" id="dapitanId">
                <option value="CCS">CCS</option>
                <option value="CED">CED</option>
                <option value="CBA">CBA</option>
                <option value="CCJE">CCJE</option>
                <option value="CNAHS">CNAHS</option>
                <option value="CME">CME</option>
                <option value="COE">COE</option>
                <option value="CAS">CAS</option>
              </select>
            </div>
      <!--====================== DIPOLOG =======================-->
            <div class="form-group" style = "display:none" id="dipologs">
              <label>College</label><br>
              <select class="form-control" name="college_dipolog" id="dipologId">
                <option value="CED">CED</option>
                <option value="CAS">CAS</option>
                <option value="CIT">CIT</option>
                <option value="CBA">CBA</option>
                <option value="CCJE">CCJE</option>
              </select>
            </div>
      <!--====================== KATIPUNAN =======================-->
            <div class="form-group" style = "display:none" id="katipunans"> 
              <label>College</label><br>
              <select class="form-control" name="college_katipunan" id="katipunanId">
                <option value="CBM">CBM</option>
                <option value="CAF">CAF</option>
                <option value="CCJE">CCJE</option>
                <option value="CCS">CCS</option>
                <option value="CED">CED</option>
              </select>
            </div>
      <!--====================== SIOCON =======================-->
            <div class="form-group" style = "display:none" id="siocons"> 
              <label>College</label><br>
              <select class="form-control" name="college_siocon" id="sioconId">
                <option value="CCS">CCS</option>
                <option value="CED">CED</option>
                <option value="CIT">CIT</option>
              </select>
            </div>
      <!--====================== SIBUCO =======================-->
            <div class="form-group" style = "display:none" id="sibucos"> 
              <label>College</label><br>
              <select class="form-control" name="college_sibuco" id="sibucoId">
                <option value="#">#</option>
                <option value="#">#</option>
                <option value="#">#</option>
              </select>
            </div>
      <!--====================== TAMPILISAN =======================-->
            <div class="form-group" style = "display:none" id="tampilisans"> 
              <label>College</label><br>
              <select class="form-control" name="college_tampilisan" id="tampilisanId">
                <option value="CBA">CBA</option>
                <option value="CED">CED</option>
                <option value="SJCE">SJCE</option>
                <option value="SOE">SOE</option>
                <option value="CAF">CAF</option>
                <option value="CAS">CAS</option>
                <option value="CCS">CCS</option>
              </select>
            </div>

            <script>
              function choose_campuses(){
                var check = document.getElementById("campus_ids");
                if (check.value == "Dapitan"){
                  //dapitans
                  document.getElementById("dapitans").setAttribute("style", "display:visible");
                  document.getElementById("dipologs").setAttribute("style", "display:none");
                  document.getElementById("katipunans").setAttribute("style", "display:none");
                  document.getElementById("siocons").setAttribute("style", "display:none");
                  document.getElementById("sibucos").setAttribute("style", "display:none");
                  document.getElementById("tampilisans").setAttribute("style", "display:none");

                }
                else if (check.value == "Dipolog"){
                  //dipologs
                  document.getElementById("dapitans").setAttribute("style", "display:none");
                  document.getElementById("dipologs").setAttribute("style", "display:visible");
                  document.getElementById("katipunans").setAttribute("style", "display:none");
                  document.getElementById("siocons").setAttribute("style", "display:none");
                  document.getElementById("sibucos").setAttribute("style", "display:none");
                  document.getElementById("tampilisans").setAttribute("style", "display:none");
                }
                else if (check.value == "Katipunan"){
                  //Katipunan
                  document.getElementById("dapitans").setAttribute("style", "display:none");
                  document.getElementById("dipologs").setAttribute("style", "display:none");
                  document.getElementById("katipunans").setAttribute("style", "display:visible");
                  document.getElementById("siocons").setAttribute("style", "display:none");
                  document.getElementById("sibucos").setAttribute("style", "display:none");
                  document.getElementById("tampilisans").setAttribute("style", "display:none");
                }
                else if (check.value == "Siocon"){
                  //Siocon
                  document.getElementById("dapitans").setAttribute("style", "display:none");
                  document.getElementById("dipologs").setAttribute("style", "display:none");
                  document.getElementById("katipunans").setAttribute("style", "display:none");
                  document.getElementById("siocons").setAttribute("style", "display:visible");
                  document.getElementById("sibucos").setAttribute("style", "display:none");
                  document.getElementById("tampilisans").setAttribute("style", "display:none");
                }
                else if (check.value == "Sibuco"){
                  //Sibuco
                  document.getElementById("dapitans").setAttribute("style", "display:none");
                  document.getElementById("dipologs").setAttribute("style", "display:none");
                  document.getElementById("katipunans").setAttribute("style", "display:none");
                  document.getElementById("siocons").setAttribute("style", "display:none");
                  document.getElementById("sibucos").setAttribute("style", "display:visible");
                  document.getElementById("tampilisans").setAttribute("style", "display:none");
                }
                else if (check.value == "Tampilisan"){
                  //Tampilisan
                  document.getElementById("dapitans").setAttribute("style", "display:none");
                  document.getElementById("dipologs").setAttribute("style", "display:none");
                  document.getElementById("katipunans").setAttribute("style", "display:none");
                  document.getElementById("siocons").setAttribute("style", "display:none");
                  document.getElementById("sibucos").setAttribute("style", "display:none");
                  document.getElementById("tampilisans").setAttribute("style", "display:visible");
                }
              }
            </script>

            <div class="form-group">
                <label>Document</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Title</label>
                <input type="hidden" name="research" id="research1" class="form-control" placeholder="Resesarch Title" required>
                <input type="text" class="form-control" id="research2" disabled>
            </div>
            <div class="form-group">
              <label>Author</label>
              <input type="text"  id="author1" class="form-control" placeholder="Author" disabled>
              <input type="hidden" name="author" id="author2" class="form-control" placeholder="Author">
            </div>
            <div class="form-group">
              <input type="hidden" id="status1">
              <label>Status</label><br>
              <select class="form-control" name="category" id="editselectpsc" onchange="editpsc()">
                <option value="Proposed">Proposed</option>
                <option value="On-Going">On-Going</option>
                <option value="Completed">Completed</option>
              </select>
            </div>

            <div class="form-group" id = "pro" style="display:visible">
              <label>Proposed</label>
              <input type="date" name="proposed" id="proposed1" class="form-control">
            </div>
            <div class="form-group" id = "star" style="display:none">
              <label>Started</label>
              <input type="date" name="started" id="started1" class="form-control">
            </div>
            <div class="form-group" id = "statusCompleted" style="display:none">
              <label>Completed</label>
              <input type="date" name="completed" id="completed1" class="form-control">
            </div>
            <script>
              function editpsc(){
                var check = document.getElementById("editselectpsc");

                if (check.value == "Proposed"){
                  document.getElementById("pro").setAttribute("style", "display:visible");
                  document.getElementById("star").setAttribute("style", "display:none");
                  document.getElementById("statusCompleted").setAttribute("style", "display:none");
                }
                else if (check.value == "On-Going"){
                  document.getElementById("pro").setAttribute("style", "display:visible");
                  document.getElementById("star").setAttribute("style", "display:visible");
                  document.getElementById("statusCompleted").setAttribute("style", "display:none");
                }
                else if (check.value == "Completed") {
                  document.getElementById("pro").setAttribute("style", "display:visible");
                  document.getElementById("star").setAttribute("style", "display:visible");
                  document.getElementById("statusCompleted").setAttribute("style", "display:visible");
                }
              }
              
            </script>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="add" class="btn btn-primary">Update</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Profile -->
<div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:400px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

              <!-- Profile Image -->
            

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img style="width:100px; height:100px" class="profile-user-img img-fluid img-circle" src="../../../res api/users account/users/unit head/attributes/profile upload/<?php echo $fetch['image']; ?>" alt="User profile picture">
            </div>
            <!-- <label for="file" id="uploadBtn"><i class="fa solid fa-camera" id="camIcon" style="cursor:pointer; font-size:30px; color:black; margin-left:calc(100% - 57.5%); position:absolute; margin-top:-50px; color:white"></i></label> -->

            <h3 class="profile-username text-center"><?php echo $fetch['fullname']; ?></h3>
            <p class="text-muted text-center">Admin</p>

            <hr>
            <div class="form-group">
              <label for="">Email</label>
              <input type="email" class="form-control" id="yourEmail" readonly value="<?php echo $fetch['email']; ?>">
            </div>
            <div class="form-group">
              <label for="">Phone Number</label>
              <input type="text" class="form-control" id="cellphoneNumber" readonly value="<?php echo $fetch['phone_number']; ?>">
            </div>

            <div class="form-group" style="text-align:center">
              <button id="savebutton" class="btn btn-primary" style="width:100%" data-toggle="modal" data-target="#editProfile" style="cursor:pointer">Edit Profile</button>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>

<!-- Edit Profile -->

<div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width:400px">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

              <!-- Profile Image -->

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <form action="../../../res api/users account/Admin/update profile/update.profile.php?check=research work" method="POST" enctype="multipart/form-data">
              <input type="hidden" value="<?php echo $admin_id; ?>" name = "id">
              <input type="hidden" value="<?php echo $fetch['email'];?>" name="currentEmail">
              <div class="form-group">
                <label for="">Profile Picture</label>
                <input type="file" name="file" class="form-control" id="yourEmail" value="<? echo $fetch['image']; ?>" required>
              </div>
              <div class="form-group">
                <label for="">Full Name</label>
                <input type="text" class="form-control" name="fullname" id="yourEmail" value="<?php echo $fetch['fullname']; ?>" required>
              </div>
              <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" name = "email" id="yourEmail" value="<?php echo $fetch['email']; ?>" required>
              </div>
              <div class="form-group">
                <label for="">Phone Number</label>
                <input type="text" class="form-control" name="phone_number" id="cellphoneNumber" value="<?php echo $fetch['phone_number']; ?>" required>
              </div>

              <div class="form-group" style="text-align:center">
                <button id="savebutton" name="save" class="btn btn-primary" style="width:100%">Save Profile</button>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
</div>

<!-- Add Author -->

<?php
  if (isset($_GET['success'])){
    $update = $_GET['success']; ?>
    <div id = "test" class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h5><i class="icon fas fa-check"></i> Alert!</h5>
      <?php echo $update; ?>

      <script>
        const response = document.getElementById("test");
        setTimeout(() => {
          response.style.display = "none";
        }, 4000);
      </script> 

    </div>
    <?php
  }
?>
<?php
  if (isset($_GET['already'])){
    $update = $_GET['already']; ?>
    <div id = "test" class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <h5><i class="icon fas fa-check"></i> Alert!</h5>
      <?php echo $update; ?>

      <script>
        const response = document.getElementById("test");
        setTimeout(() => {
          response.style.display = "none";
        }, 4000);
      </script> 

    </div>
    <?php
  }
?>



<!-- End of Adding Author -->

<div class="container-fluid">
    <!-- Left navbar links -->
    <ul class="navbar-nav" style="margin-left:85%; font-size:20px; margin-top:-40px;">
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small">Generate Document</span>
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown" style="margin-left:-300px; width:300px; text-align:center">
          <form action="../../../res api/users account/Admin/create document/createDocument.php" method="POST">
            <div class="form-group" style="width:80%; margin-left:10%; margin-top:20px">
              <select class="form-control" style="text-align:center;" name="selectOption">
                <option value="All">All</option>
                <option value="Research">Research</option>
                <option value="Extension">Extension</option>
              </select>
            </div>

            <div class="form-group" id = "proposed" style="width:80%; margin-left:10%">
              <span>Start Date: </span><input style="margin-left:10px; width:150px; border-color:lightblue" type="date" name="startDate">
            </div>

            <div class="form-group" id = "proposed" style="width:80%; margin-left:10%">
              <span>End Date: </span><input style="margin-left:10px; width:150px; border-color:lightblue" type="date" name="endDate">
            </div>

            <div class="modal-footer">
              <button type="submit" style="width:80%; margin-right:10%" name="generate" class="btn btn-primary">Generate</button>
            </div>
          </form>
        </div>
      </li>
    </ul>

<!-- DataTales Example -->
<div class="card shadow mb-4" id = "data1">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><span style="font-size:20px"><span id = "a1" style="display:visible; font-size:20px">Research & Extension Works</span><span id = "a5" style="display:none">Approved Research & Extension Programs</span><span id = "a2" style="display:none">R & E On-Going Papers</span><span id = "a3" style = "display:none">R & E Completed Papers</span><span id = "a4" style="display:none">Proposed R & E Papers</span></span>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
              Add Data
            </button>
    </h6>
  </div>

  <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <!-- <div class="card-tools"> -->
              <div>
                  <div class="input-group input-group-sm" style="width: 330px; margin-left:-15px">
                  <select name="" id="showRorE"  style="width:100px; border-color:#ccc; color:rgb(117, 107, 107)" onchange="showRorE()">
                    <option value="all">All</option>
                    <option value="myProposed">Proposed</option>
                    <option value="on-going">On-Going</option>
                    <option value="myCompleted">Completed</option>
                    <option value="myApproved">Approved Papers</option>
                    </select>

                  <script>
                    function showRorE(){
                      var get = document.getElementById("showRorE");
                      if (get.value == "all"){
                        document.getElementById("all").setAttribute("style", "display:visible");
                        document.getElementById("bwesetProposed").setAttribute("style", "display:none");
                        document.getElementById("on-going").setAttribute("style", "display:none");
                        document.getElementById("bwesetCompleted").setAttribute("style", "display:none");
                        document.getElementById("proposedDate").setAttribute("style", "display:visible");
                        document.getElementById("startedDate").setAttribute("style", "display:visible");
                        document.getElementById("completedDate").setAttribute("style", "display:visible");
                        document.getElementById("a1").setAttribute("style", "display:visible");
                        document.getElementById("a2").setAttribute("style", "display:none");
                        document.getElementById("a3").setAttribute("style", "display:none");
                        document.getElementById("a4").setAttribute("style", "display:none");
                        document.getElementById("a5").setAttribute("style", "display:none");
                        document.getElementById("approved").setAttribute("style", "display:none");
                      }
                      else if (get.value == "myProposed"){
                        document.getElementById("all").setAttribute("style", "display:none");
                        document.getElementById("bwesetProposed").setAttribute("style", "display:visible");
                        document.getElementById("on-going").setAttribute("style", "display:none");
                        document.getElementById("bwesetCompleted").setAttribute("style", "display:none");
                        document.getElementById("proposedDate").setAttribute("style", "display:visible");
                        document.getElementById("startedDate").setAttribute("style", "display:none");
                        document.getElementById("completedDate").setAttribute("style", "display:none");
                        document.getElementById("a1").setAttribute("style", "display:none");
                        document.getElementById("a2").setAttribute("style", "display:none");
                        document.getElementById("a3").setAttribute("style", "display:none");
                        document.getElementById("approved").setAttribute("style", "display:none");
                        document.getElementById("a5").setAttribute("style", "display:none");
                        document.getElementById("a4").setAttribute("style", "display:visible");
                      }
                      else if (get.value == "on-going"){
                        document.getElementById("all").setAttribute("style", "display:none");
                        document.getElementById("bwesetProposed").setAttribute("style", "display:none");
                        document.getElementById("on-going").setAttribute("style", "display:visible");
                        document.getElementById("bwesetCompleted").setAttribute("style", "display:none");
                        document.getElementById("proposedDate").setAttribute("style", "display:visible");
                        document.getElementById("startedDate").setAttribute("style", "display:visible");
                        document.getElementById("completedDate").setAttribute("style", "display:none");
                        document.getElementById("a1").setAttribute("style", "display:none");
                        document.getElementById("a2").setAttribute("style", "display:visible");
                        document.getElementById("a3").setAttribute("style", "display:none");
                        document.getElementById("a4").setAttribute("style", "display:none");
                        document.getElementById("approved").setAttribute("style", "display:none");
                        document.getElementById("a5").setAttribute("style", "display:none");
                      }else if (get.value == "myCompleted"){
                        document.getElementById("all").setAttribute("style", "display:none");
                        document.getElementById("bwesetProposed").setAttribute("style", "display:none");
                        document.getElementById("on-going").setAttribute("style", "display:none");
                        document.getElementById("bwesetCompleted").setAttribute("style", "display:visible");
                        document.getElementById("proposedDate").setAttribute("style", "display:visible");
                        document.getElementById("startedDate").setAttribute("style", "display:visible");
                        document.getElementById("completedDate").setAttribute("style", "display:visible");
                        document.getElementById("a1").setAttribute("style", "display:none");
                        document.getElementById("a2").setAttribute("style", "display:none");
                        document.getElementById("a3").setAttribute("style", "display:visible");
                        document.getElementById("a4").setAttribute("style", "display:none");
                        document.getElementById("approved").setAttribute("style", "display:none");
                        document.getElementById("a5").setAttribute("style", "display:none");
                      }else{
                        document.getElementById("all").setAttribute("style", "display:none");
                        document.getElementById("bwesetProposed").setAttribute("style", "display:none");
                        document.getElementById("on-going").setAttribute("style", "display:none");
                        document.getElementById("bwesetCompleted").setAttribute("style", "display:none");
                        document.getElementById("proposedDate").setAttribute("style", "display:visible");
                        document.getElementById("startedDate").setAttribute("style", "display:visible");
                        document.getElementById("completedDate").setAttribute("style", "display:visible");
                        document.getElementById("a1").setAttribute("style", "display:none");
                        document.getElementById("a2").setAttribute("style", "display:none");
                        document.getElementById("a3").setAttribute("style", "display:none");
                        document.getElementById("a4").setAttribute("style", "display:none");
                        document.getElementById("approved").setAttribute("style", "display:visible");
                        document.getElementById("a5").setAttribute("style", "display:visible");
                      }
                    }
                   </script>

                    <input  type="text" name="table_search" style="margin-left:10px" class="form-control float-right" id="search-input" placeholder="Search From Table...">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>

              <style>
                table {
                  width: 100%;
                  border-collapse: collapse;
                  border-spacing: 0;
                  margin-bottom: 1em;
                }
                th{
                  background-color:lightgreen;
                }
                .hover:hover{
                  background-color:rgb(187, 187, 222);
                }
                .exist{
                  display: none;
                }
                th, td {
                  text-align: left;
                  padding: 0.5em;
                  border-bottom: 1px solid #ddd;
                }
                tr:nth-child(odd) {
                  background-color: white;
                }
                tr:nth-child(even) {
                  background-color: #ddd;
                }
                @media screen and (max-width: 767px) {
                  .s{
                      display: none;
                  }
                  .exist{
                    display:block;
                    background-color: white;
                    padding: 20px;
                  }
                  th, td {
                    display: block;
                    width: 100%;
                  }
                  th:before {
                    content: attr(data-title);
                    float: left;
                    font-weight: bold;
                  }
                  td:before {
                    content: attr(data-title) " ";
                    float: left;
                    font-weight: bold;
            
                  }
                }
              </style>
              
              <div class="card-body table-responsive p-0" style="height: 450px;">
              <table id="my-table" style="display:visible; font-size:13px">
                  <thead>
                  <tr>
                      <th class="s"></th>
                      <th class="s">Title</th>
                      <th class="s">Authors</th>
                      <th class="s">Status</th>
                      <th id = "proposedDate" style="display:visible" class="s">Proposed Date</th>
                      <th class="s" id = "startedDate" style="display:visible">Started Date</th>
                      <th id="completedDate" class="s" style="display:visible">Completed Date</th>
                      <th class="s">Research/Extension</th>
                      <th class="s">Campus</th>
                      <th class="s">College</th>
                      <th class="s">Added By</th>
                      <th class="s">Originality</th>
                      <th class="s">Similarity</th>

                    </tr>
                  </thead>

                  <tbody style = "display:visible" id="all">
        
                    <?php 
                        $mystmt = $conn->prepare("SELECT * FROM all_research_data WHERE isDelete = :isDelete");
                        $mystmt->execute(['isDelete' => "not"]);
                        $founds = $mystmt->rowCount();

                        if ($founds > 0){
                            while ($row = $mystmt->fetch(PDO::FETCH_ASSOC)){
                                $getStatus = $row['status'];

                                if (($getStatus === "On-Going") || ($getStatus === "Completed" || ($getStatus === "Proposed"))){
                                    $rowId = $row['id'];

                                    $sql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                                    $sql->bindParam(":id", $rowId);
                                    $sql->execute();
                                    $count = $sql->rowCount();

                                    if ($count > 0){
                                        while ($gots = $sql->fetch(PDO::FETCH_ASSOC)){ ?>
                                            <tr class="hover">
                                              <td style="display:none"><?php echo $gots['id']; ?></td>
                                              <td>
                                                <form method="post">
                                                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                                                  <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                                    <!-- Check either document is scan or not -->
                                                    <?php
                                                      $scanSql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                                                      if ($scanSql->execute(['id' => $gots['id']])){
                                                        $scanResult = $scanSql->fetch(PDO::FETCH_ASSOC);
                                                      }
                                                      $resultSign = $scanResult['result_sign'];

                                                      if ($resultSign == null){
                                                        $display = "Scan Document";
                                                      }else{
                                                        $display = "Scan Document Again";
                                                      }
                                                    ?>
                                                    <li><a href="../../../plagiarism/view document/viewDocument.php?id=<?php echo $gots['id']; ?>" class="dropdown-item" onclick="loading()"><?php echo $display; ?></a></li>
                                                    <li><a href="../../../plagiarism/create certificate result/createCertificate.php?id=<?php echo $gots['id']; ?>" class="dropdown-item" onclick="result()">Download Plagiarism Result</a></li>
                                                    <li><a href="../../../res api/users account/Admin/download/index.php?id=<?php echo $gots['id']; ?>" class="dropdown-item">Download</a></li>
                                                    <li><form action="research.my.data.php" method="POST">
                                                      <input type="hidden" value="<?php echo $gots['id']; ?>" name="historyId">
                                                      <input type="submit" class="dropdown-item" value="History" name="history">
                                                    </form></li>
                                                    <li><form method="post">
                                                      <input type="hidden" name="realId" value="<?php echo $gots['id']; ?>">
                                                      <button name="Edit" type="button" class="dropdown-item edit_me">Edit</button>
                                                    </form></li>
                                                    <li><form action="../../../res api/users account/Admin/add research data/deleteResearch.php?delete=<?php echo $gots['id']; ?>" method="post">
                                                      <input type="hidden" name="edit_data" value="">
                                                      <button name="Edit" onclick="del()" type="submit" class="dropdown-item">Delete</button>
                                                    </form></li>
                                                  </ul></i></a>
                                                </form>

                                              </td>
                                              <td data-title="Title: "><?php echo $gots['research']; ?></td>
                                              <td data-title="Authors: "><?php echo $gots['authors']; ?></td>
                                              <td data-title="Status: "><?php echo $gots['status']; ?></td>
                                              <td data-title="Proposed Date: "><?php echo $gots['proposed']; ?></td>
                                              <td data-title="Started Date: "><?php echo $gots['started']; ?></td>
                                              <td data-title="Completed Date: "><?php echo $gots['completed']; ?></td>
                                              <td data-title="Research/Extension: "><?php echo $gots['RorE']; ?></td>
                                              <td data-title="Campus: "><?php echo $gots['campus']; ?></td>
                                              <td data-title="College: "><?php echo $gots['college']; ?></td>
                                              <td data-title="Added By: "><?php echo $gots['added_by']; ?></td>
                                              <td style="color:blue" data-title="Originality: "><?php echo $gots['originality']; ?>%</td>
                                              <td style="color:red" data-title="Similarity: "><?php echo $gots['similarity']; ?>%</td>
                                              <td class="exist"></td>
                                            </tr>
                                            
                                        <?php }
                                    }else{  ?>
                                        <tr><td></td><td>No Data Found!</td></tr>
                                    <?php }

                                }
                            }
                        }
                    ?>
                  <!-- ====================================================================================================== -->
                  </tbody>

                  <tbody style = "display:none" id="bwesetProposed">
        
                    <?php 
                        $mystmt = $conn->prepare("SELECT * FROM all_research_data WHERE isDelete = :isDelete");
                        $mystmt->execute(['isDelete' => "not"]);  
                        $founds = $mystmt->rowCount();

                        if ($founds > 0){
                            while ($rows = $mystmt->fetch(PDO::FETCH_ASSOC)){
                                $secretStatus = $rows['status'];

                                if ($secretStatus === "Proposed"){
                                    $rowId = $rows['id'];

                                    $sqll = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                                    $sqll->bindParam(":id", $rowId);
                                    $sqll->execute();
                                    $count1 = $sqll->rowCount();
                                    
                                    if ($count1 > 0){
                                        while ($gets = $sqll->fetch(PDO::FETCH_ASSOC)){ ?>
                                            <tr class="hover">
                                            <td style="display:none"><?php echo $gets['id']; ?></td>
                                            <td>
                                              <form action="" method="post">
                                                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                                                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                                  <!-- Check either document is scan or not -->
                                                  <?php
                                                      $scanSql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                                                      if ($scanSql->execute(['id' => $gets['id']])){
                                                        $scanResult = $scanSql->fetch(PDO::FETCH_ASSOC);
                                                      }
                                                      $resultSign = $scanResult['result_sign'];

                                                      if ($resultSign == null){
                                                        $display = "Scan Document";
                                                      }else{
                                                        $display = "Scan Document Again";
                                                      }
                                                    ?>
                                                  <li><a href="../../../plagiarism/view document/viewDocument.php?id=<?php echo $gets['id']; ?>" class="dropdown-item" onclick="loading()"><?php echo $display; ?></a></li>
                                                  <li><a href="../../../plagiarism/create certificate result/createCertificate.php?id=<?php echo $gets['id']; ?>" class="dropdown-item" onclick="result()">Download Plagiarism Result</a></li>
                                                  <li><a href="../../../res api/users account/Admin/download/index.php?id=<?php echo $gets['id']; ?>" class="dropdown-item">Download</a></li>
                                                  <li><form action="research.my.data.php" method="POST">
                                                      <input type="hidden" value="<?php echo $gets['id']; ?>" name="historyId">
                                                      <input type="submit" class="dropdown-item" value="History" name="history">
                                                    </form></li>
                                                  <li><form action="" method="post">
                                                    <input type="hidden" name="edit_data" value="">
                                                    <button name="Edit" type="button" class="dropdown-item edit_me">Edit</button>
                                                  </form></li>
                                                  <li><form action="../../../res api/users account/Admin/add research data/deleteResearch.php?delete=<?php echo $gets['id']; ?>" method="post">
                                                    <input type="hidden" name="edit_data" value="">
                                                    <button name="Edit" onclick="del()" type="submit" class="dropdown-item">Delete</button>
                                                  </form></li>
                                                </ul></i></a>
                                              </form>

                                            </td>
                                            <td data-title="Title: "><?php echo $gets['research']; ?></td>
                                            <td data-title="Authors: "><?php echo $gets['authors']; ?></td>
                                            <td data-title="Status: "><?php echo $gets['status']; ?></td>
                                            <td data-title="Proposed Date: "><?php echo $gets['proposed']; ?></td>
                                            <td data-title="Research/Extension: "><?php echo $gets['RorE']; ?></td>
                                            <td data-title="Campus: "><?php echo $gets['campus']; ?></td>
                                            <td data-title="College: "><?php echo $gets['college']; ?></td>
                                            <td data-title="Added By: "><?php echo $gets['added_by']; ?></td>
                                            <td style="color:blue" data-title="Originality: "><?php echo $gets['originality']; ?>%</td>
                                              <td style="color:red" data-title="Similarity: "><?php echo $gets['similarity']; ?>%</td>
                                            <td class="exist"></td>
                                            </tr>
                                            
                                        <?php }
                                    }else{  ?>
                                        <tr><td></td><td>No Data Found!</td></tr>
                                    <?php }

                                }
                            }
                        }
                    ?>
                  <!-- ====================================================================================================== -->
                  </tbody>


                  <tbody style = "display:none" id="on-going">
        
                    <?php 
                        $mysql = $conn->prepare("SELECT * FROM all_research_data WHERE isDelete = :isDelete");
                        $mysql->execute(['isDelete' => "not"]);
                        $found = $mysql->rowCount();

                        if ($found > 0){
                            while ($row = $mysql->fetch(PDO::FETCH_ASSOC)){
                                $rowStatus = $row['status'];

                                if ($rowStatus === "On-Going"){
                                    $rowId = $row['id'];

                                    $sql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                                    $sql->bindParam(":id", $rowId);
                                    $sql->execute();
                                    $count = $sql->rowCount();

                                    if ($count > 0){
                                        while ($get = $sql->fetch(PDO::FETCH_ASSOC)){ ?>
                                            <tr class="hover">
                                            <td style="display:none"><?php echo $get['id']; ?></td>
                                            <td>
                                              <form action="" method="post">
                                                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                                                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                                  <!-- Check either document is scan or not -->
                                                  <?php
                                                      $scanSql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                                                      if ($scanSql->execute(['id' => $get['id']])){
                                                        $scanResult = $scanSql->fetch(PDO::FETCH_ASSOC);
                                                      }
                                                      $resultSign = $scanResult['result_sign'];

                                                      if ($resultSign == null){
                                                        $display = "Scan Document";
                                                      }else{
                                                        $display = "Scan Document Again";
                                                      }
                                                    ?>
                                                  <li><a href="../../../plagiarism/view document/viewDocument.php?id=<?php echo $get['id']; ?>" class="dropdown-item" onclick="loading()"><?php echo $display; ?></a></li>
                                                  <li><a href="../../../plagiarism/create certificate result/createCertificate.php?id=<?php echo $get['id']; ?>" class="dropdown-item" onclick="result()">Download Plagiarism Result</a></li>
                                                  <li><a href="../../../res api/users account/Admin/download/index.php?id=<?php echo $get['id']; ?>" class="dropdown-item">Download</a></li>
                                                  <li><form action="research.my.data.php" method="POST">
                                                      <input type="hidden" value="<?php echo $get['id']; ?>" name="historyId">
                                                      <input type="submit" class="dropdown-item" value="History" name="history">
                                                    </form></li>
                                                  <li><form action="" method="post">
                                                    <input type="hidden" name="edit_data" value="">
                                                    <button name="Edit" type="button" class="dropdown-item edit_me">Edit</button>
                                                  </form></li>
                                                  <li><form action="../../../res api/users account/Admin/add research data/deleteResearch.php?delete=<?php echo $get['id']; ?>" method="post">
                                                    <input type="hidden" name="edit_data" value="">
                                                    <button name="Edit" onclick="del()" type="submit" class="dropdown-item">Delete</button>
                                                  </form></li>
                                                </ul></i></a>
                                              </form>

                                            </td>
                                            <td data-title="Title: "><?php echo $get['research']; ?></td>
                                            <td data-title="Authors: "><?php echo $get['authors']; ?></td>
                                            <td data-title="Status: "><?php echo $get['status']; ?></td>
                                            <td data-title="Proposed Date: "><?php echo $get['proposed']; ?></td>
                                            <td data-title="Started Date: "><?php echo $get['started']; ?></td>
                                            <td data-title="Research/Extension: "><?php echo $get['RorE']; ?></td>
                                            <td data-title="Campus: "><?php echo $get['campus']; ?></td>
                                            <td data-title="College: "><?php echo $get['college']; ?></td>
                                            <td data-title="Added By: "><?php echo $get['added_by']; ?></td>
                                            <td style="color:blue" data-title="Originality: "><?php echo $get['originality']; ?>%</td>
                                              <td style="color:red" data-title="Similarity: "><?php echo $get['similarity']; ?>%</td>
                                            <td class="exist"></td>
                                            </tr>
                                            
                                        <?php }
                                    }else{  ?>
                                        <tr><td></td><td>No Data Found!</td></tr>
                                    <?php }

                                }
                            }
                        }
                    ?>
                  <!-- ====================================================================================================== -->
                  </tbody>

                  <tbody style = "display:none" id="bwesetCompleted">
        
                    <?php 
                        $mysql = $conn->prepare("SELECT * FROM all_research_data WHERE isDelete = :isDelete");
                        $mysql->execute(['isDelete' => "not"]);
                        $found = $mysql->rowCount();

                        if ($found > 0){
                            while ($row = $mysql->fetch(PDO::FETCH_ASSOC)){
                                $rowStatus = $row['status'];

                                if ($rowStatus === "Completed"){
                                    $rowId = $row['id'];

                                    $sql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                                    $sql->bindParam(":id", $rowId);
                                    $sql->execute();
                                    $count = $sql->rowCount();

                                    if ($count > 0){
                                        while ($get = $sql->fetch(PDO::FETCH_ASSOC)){ ?>
                                            <tr class="hover">
                                            <td style="display:none"><?php echo $get['id']; ?></td>
                                            <td>
                                              <form action="" method="post">
                                                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                                                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                                  <!-- Check either document is scan or not -->
                                                  <?php
                                                      $scanSql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                                                      if ($scanSql->execute(['id' => $get['id']])){
                                                        $scanResult = $scanSql->fetch(PDO::FETCH_ASSOC);
                                                      }
                                                      $resultSign = $scanResult['result_sign'];

                                                      if ($resultSign == null){
                                                        $display = "Scan Document";
                                                      }else{
                                                        $display = "Scan Document Again";
                                                      }
                                                    ?>
                                                  <li><a href="../../../plagiarism/view document/viewDocument.php?id=<?php echo $get['id']; ?>" class="dropdown-item" onclick="loading()"><?php echo $display; ?></a></li>
                                                  <li><a href="../../../plagiarism/create certificate result/createCertificate.php?id=<?php echo $get['id']; ?>" class="dropdown-item" onclick="result()">Download Plagiarism Result</a></li>
                                                  <li><a href="../../../res api/users account/Admin/download/index.php?id=<?php echo $get['id']; ?>" class="dropdown-item">Download</a></li>
                                                  <li><form action="research.my.data.php" method="POST">
                                                      <input type="hidden" value="<?php echo $get['id']; ?>" name="historyId">
                                                      <input type="submit" class="dropdown-item" value="History" name="history">
                                                    </form></li>
                                                  <li><form action="" method="post">
                                                    <input type="hidden" name="edit_data" value="">
                                                    <button name="Edit" type="button" class="dropdown-item edit_me">Edit</button>
                                                  </form></li>
                                                  <li><form action="../../../res api/users account/Admin/add research data/deleteResearch.php?delete=<?php echo $get['id']; ?>" method="post">
                                                    <input type="hidden" name="edit_data" value="">
                                                    <button name="Edit" onclick="del()" type="submit" class="dropdown-item">Delete</button>
                                                  </form></li>
                                                </ul></i></a>
                                              </form>

                                            </td>
                                            <td data-title="Title: "><?php echo $get['research']; ?></td>
                                            <td data-title="Authors: "><?php echo $get['authors']; ?></td>
                                            <td data-title="Status: "><?php echo $get['status']; ?></td>
                                            <td data-title="Proposed Date: "><?php echo $get['proposed']; ?></td>
                                            <td data-title="Started Date: "><?php echo $get['started']; ?></td>
                                            <td data-title="Completed Date: "><?php echo $get['completed']; ?></td>
                                            <td data-title="Research/Extension: "><?php echo $get['RorE']; ?></td>
                                            <td data-title="Campus: "><?php echo $get['campus']; ?></td>
                                            <td data-title="College: "><?php echo $get['college']; ?></td>
                                            <td data-title="Added By: "><?php echo $get['added_by']; ?></td>
                                            <td style="color:blue" data-title="Originality: "><?php echo $get['originality']; ?>%</td>
                                              <td style="color:red" data-title="Similarity: "><?php echo $get['similarity']; ?>%</td>
                                            <td class="exist"></td>
                                            </tr>
                                            
                                        <?php }
                                    }else{  ?>
                                        <tr><td></td><td>No Data Found!</td></tr>
                                    <?php }

                                }
                            }
                        }
                    ?>
                  <!-- ====================================================================================================== -->
                  </tbody>

                  <tbody style = "display:none" id="approved">
        
                    <?php 
                        $mysql = $conn->prepare("SELECT * FROM all_research_data WHERE isDelete = :isDelete");
                        $mysql->execute(['isDelete' => "not"]);
                        $found = $mysql->rowCount();

                        if ($found > 0){
                            while ($row = $mysql->fetch(PDO::FETCH_ASSOC)){
                                $rowStatus = $row['status'];

                                if (($rowStatus === "Completed") || ($rowStatus === "On-Going")){
                                    $rowId = $row['id'];

                                    $sql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                                    $sql->bindParam(":id", $rowId);
                                    $sql->execute();
                                    $count = $sql->rowCount();

                                    if ($count > 0){
                                        while ($get = $sql->fetch(PDO::FETCH_ASSOC)){ ?>
                                            <tr class="hover">
                                            <td style="display:none"><?php echo $get['id']; ?></td>
                                            <td>
                                              <form action="" method="post">
                                                  <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                                                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                                  <!-- Check either document is scan or not -->
                                                  <?php
                                                      $scanSql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                                                      if ($scanSql->execute(['id' => $get['id']])){
                                                        $scanResult = $scanSql->fetch(PDO::FETCH_ASSOC);
                                                      }
                                                      $resultSign = $scanResult['result_sign'];

                                                      if ($resultSign == null){
                                                        $display = "Scan Document";
                                                      }else{
                                                        $display = "Scan Document Again";
                                                      }
                                                    ?>
                                                  <li><a href="../../../plagiarism/view document/viewDocument.php?id=<?php echo $get['id']; ?>" class="dropdown-item" onclick="loading()"><?php echo $display; ?></a></li>
                                                  <li><a href="../../../plagiarism/create certificate result/createCertificate.php?id=<?php echo $get['id']; ?>" class="dropdown-item" onclick="result()">Download Plagiarism Result</a></li>
                                                  <li><a href="../../../res api/users account/Admin/download/index.php?id=<?php echo $get['id']; ?>" class="dropdown-item">Download</a></li>
                                                  <li><form action="research.my.data.php" method="POST">
                                                      <input type="hidden" value="<?php echo $get['id']; ?>" name="historyId">
                                                      <input type="submit" class="dropdown-item" value="History" name="history">
                                                    </form></li>
                                                  <li><form action="" method="post">
                                                    <input type="hidden" name="edit_data" value="">
                                                    <button name="Edit" type="button" class="dropdown-item edit_me">Edit</button>
                                                  </form></li>
                                                  <li><form action="../../../res api/users account/Admin/add research data/deleteResearch.php?delete=<?php echo $get['id']; ?>" method="post">
                                                    <input type="hidden" name="edit_data" value="">
                                                    <button name="Edit" onclick="del()" type="submit" class="dropdown-item">Delete</button>
                                                  </form></li>
                                                </ul></i></a>
                                              </form>

                                            </td>
                                            <td data-title="Title: "><?php echo $get['research']; ?></td>
                                            <td data-title="Authors: "><?php echo $get['authors']; ?></td>
                                            <td data-title="Status: "><?php echo $get['status']; ?></td>
                                            <td data-title="Proposed Date: "><?php echo $get['proposed']; ?></td>
                                            <td data-title="Started Date: "><?php echo $get['started']; ?></td>
                                            <td data-title="Completed Date: "><?php echo $get['completed']; ?></td>
                                            <td data-title="Research/Extension: "><?php echo $get['RorE']; ?></td>
                                            <td data-title="Campus: "><?php echo $get['campus']; ?></td>
                                            <td data-title="College: "><?php echo $get['college']; ?></td>
                                            <td data-title="Added By: "><?php echo $get['added_by']; ?></td>
                                            <td style="color:blue" data-title="Originality: "><?php echo $get['originality']; ?>%</td>
                                            <td style="color:red" data-title="Similarity: "><?php echo $get['similarity']; ?>%</td>
                                            <td class="exist"></td>
                                            </tr>
                                            
                                        <?php }
                                    }else{  ?>
                                        <tr><td></td><td>No Data Found!</td></tr>
                                    <?php }

                                }
                            }
                        }
                    ?>
                  <!-- ====================================================================================================== -->
                  </tbody>

                </table>
    </div>
  </div>
</div>

<!-- End The List Of Data -->
</div>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../../plugins/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="../../../plugins/datatables-responsive/dataTables.responsive.min.js"></script>
<script src="../../../plugins/datatables-responsive/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../../dist/js/demo.js"></script>
<!-- page script -->

<script src="../../../add-data.js"></script>
<script>
    function logout(){
        var result = confirm("Are you sure you wan't to logout?");
        if (result == false){
            event.preventDefault();
        }
    }
</script>

<script>
    function del(){
        var result = confirm("Are you sure you wan't to delete this account? Author can't no longer access this.");
        if (result == false){
            event.preventDefault();
        }
        // document.getElementById("loading").setAttribute("style", "display:visible");
    }
</script>

<script>
  $(document).ready(function(){
    $('.edit_me').on('click', function(){
      $('#yole123').modal('show');

      $tr = $(this).closest('tr');
      var data = $tr.children("td").map(function(){
        return $(this).text();
      }).get();

      console.log(data);

      $('#update_id').val(data[0]);
      $('#Programs').val(data[8]);
      $('#campuses').val(data[9]);
      $('#colleges').val(data[10]);
      $('#document1').val(data[1]);
      $('#research1').val(data[2]);
      $('#research2').val(data[2]);
      $('#author1').val(data[3]);
      $('#author2').val(data[3]);
      $('#status1').val(data[4]);
      $('#stats').val(data[4]);
      $('#proposed1').val(data[5]);
      $('#started1').val(data[6]);
      $('#completed1').val(data[7]);
      $('#rId').val(data[8]);
      $('#campus_ids').val(data[9]);
      $('#collegeData').val(data[10]);
      $('#editselectpsc').val(data[4]);

      // date_default_timezone_set('Asia/Manila');

      // var myProposed = data[5];
      // var myStarted = data[6];
      // var myCompleted = data[7];

      // var date1 = new Date(myProposed);
      // var date2 = new Date(myStarted);
      // var date3 = new Date(myCompleted);

      // date1.setFullYear(date.getFullyYear() - 1);
      // date2.setFullYear(date.getFullyYear() - 1);
      // date3.setFullYear(date.getFullyYear() - 1);

      // var formatDate1 = date1.toISOString().substring(0, 10);
      // var formatDate2 = date1.toISOString().substring(0, 10);
      // var formatDate3 = date1.toISOString().substring(0, 10);

      // $('#proposed1').value = formatDate1;
      // $('#started1').value = formatDate2;
      // $('#completed1').value = formatDate3;

      if (data[4] == "Proposed"){
        document.getElementById("pro").setAttribute("style", "display:visible");
        document.getElementById("star").setAttribute("style", "display:none");
        document.getElementById("com").setAttribute("style", "display:none");
      }
      else if (data[4] == "On-Going"){
        document.getElementById("pro").setAttribute("style", "display:visible");
        document.getElementById("star").setAttribute("style", "display:visible");
        document.getElementById("com").setAttribute("style", "display:none");
      }
      else if (data[4] == "Completed") {
        document.getElementById("pro").setAttribute("style", "display:visible");
        document.getElementById("star").setAttribute("style", "display:visible");
        document.getElementById("com").setAttribute("style", "display:none");
      }

      if (data[9] == "Dapitan"){
        //dapitans
        document.getElementById("dapitans").setAttribute("style", "display:visible");
        document.getElementById("dipologs").setAttribute("style", "display:none");
        document.getElementById("katipunans").setAttribute("style", "display:none");
        document.getElementById("siocons").setAttribute("style", "display:none");
        document.getElementById("sibucos").setAttribute("style", "display:none");
        document.getElementById("tampilisans").setAttribute("style", "display:none");

        document.getElementById("dapitanId").value = data[10];

      }
      else if (data[9] == "Dipolog"){
        //dipologs
        document.getElementById("dapitans").setAttribute("style", "display:none");
        document.getElementById("dipologs").setAttribute("style", "display:visible");
        document.getElementById("katipunans").setAttribute("style", "display:none");
        document.getElementById("siocons").setAttribute("style", "display:none");
        document.getElementById("sibucos").setAttribute("style", "display:none");
        document.getElementById("tampilisans").setAttribute("style", "display:none");

        document.getElementById("dipologId").value = data[10];
      }
      else if (data[9] == "Katipunan"){
        //Katipunan
        document.getElementById("dapitans").setAttribute("style", "display:none");
        document.getElementById("dipologs").setAttribute("style", "display:none");
        document.getElementById("katipunans").setAttribute("style", "display:visible");
        document.getElementById("siocons").setAttribute("style", "display:none");
        document.getElementById("sibucos").setAttribute("style", "display:none");
        document.getElementById("tampilisans").setAttribute("style", "display:none");

        document.getElementById("katipunanId").value = data[10];
      }
      else if (data[9] == "Siocon"){
        //Siocon
        document.getElementById("dapitans").setAttribute("style", "display:none");
        document.getElementById("dipologs").setAttribute("style", "display:none");
        document.getElementById("katipunans").setAttribute("style", "display:none");
        document.getElementById("siocons").setAttribute("style", "display:visible");
        document.getElementById("sibucos").setAttribute("style", "display:none");
        document.getElementById("tampilisans").setAttribute("style", "display:none");

        document.getElementById("sioconId").value = data[10];
      }
      else if (data[9] == "Sibuco"){
        //Sibuco
        document.getElementById("dapitans").setAttribute("style", "display:none");
        document.getElementById("dipologs").setAttribute("style", "display:none");
        document.getElementById("katipunans").setAttribute("style", "display:none");
        document.getElementById("siocons").setAttribute("style", "display:none");
        document.getElementById("sibucos").setAttribute("style", "display:visible");
        document.getElementById("tampilisans").setAttribute("style", "display:none");

        document.getElementById("sibucoId").value = data[10];
      }
      else if (data[9] == "Tampilisan"){
        //Tampilisan
        document.getElementById("dapitans").setAttribute("style", "display:none");
        document.getElementById("dipologs").setAttribute("style", "display:none");
        document.getElementById("katipunans").setAttribute("style", "display:none");
        document.getElementById("siocons").setAttribute("style", "display:none");
        document.getElementById("sibucos").setAttribute("style", "display:none");
        document.getElementById("tampilisans").setAttribute("style", "display:visible");

        document.getElementById("tampilisanId").value = data[10];
      }

    });
  });
</script>

<script>
  var cur = false;
  var newPass = false;
  var con = false;
  function curChange(){
    if (cur){
        document.getElementById("curPass").setAttribute("type", "password");
        document.getElementById("curEye").setAttribute("class", "fa fa-eye-slash");
        cur = false;
    }else{
        document.getElementById("curPass").setAttribute("type", "text");
        document.getElementById("curEye").setAttribute("class", "fa fa-eye");
        cur = true;
    }
  }

  function newChange(){
    if (newPass){
        document.getElementById("newPass").setAttribute("type", "password");
        document.getElementById("newEye").setAttribute("class", "fa fa-eye-slash");
        newPass = false;
    }else{
        document.getElementById("newPass").setAttribute("type", "text");
        document.getElementById("newEye").setAttribute("class", "fa fa-eye");
        newPass = true;
    }
  }

  function conChange(){
    if (con){
        document.getElementById("conPass").setAttribute("type", "password");
        document.getElementById("conEye").setAttribute("class", "fa fa-eye-slash");
        con = false;
    }else{
        document.getElementById("conPass").setAttribute("type", "text");
        document.getElementById("conEye").setAttribute("class", "fa fa-eye");
        con = true;
    }
  }
</script>

<div id="loading" style="display:none;">
    Loading...
</div>

<div id="history" style="display: none;">
  <div style="text-align: left; margin: 20px 20px 20px 20px; font-size:20px; color:darkblue">
    <span>History</span>
  </div>
  <div class="similar-area" style="text-align: left; margin: 0 20px 20px 20px; overflow-y: scroll; max-height: 430px; font-size:20px">
      <table style="font-size:13px">
        <thead>
          <th></th>
          <th>Title</th>
          <th>Authors</th>
          <th>Status</th>
          <th>Proposed Date</th>
          <th>Started Date</th>
          <th>Completed Date</th>
          <th>Research/Extension</th>
          <th>Campus</th>
          <th>College</th>
          <th>Added By</th>
          <th>Originality</th>
          <th>Similarity</th>
          <th>Date</th>
        </thead>
        
        <tbody>

          <?php
            if (isset($_POST['history'])){
              $historyId = $_POST['historyId'];

              $getHistoryResearch = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
              if ($getHistoryResearch->execute(['id' => $historyId])){
                $getHistoryId = $getHistoryResearch->fetch(PDO::FETCH_ASSOC);
              }
              $getResearchHistoryResult = $getHistoryId['research'];

              $historySql = $conn->prepare("SELECT * FROM history WHERE research = :research");
              if ($historySql->execute(['research' => $getResearchHistoryResult])){
                while($historyRow = $historySql->fetch(PDO::FETCH_ASSOC)){ 
                  $getStatusDate = $historyRow['date']; 
                  date_default_timezone_set('Asia/Manila');
                  $date = date('F j, Y g:i:a');

                  //proposed date
                  $statusDate = date('F j, Y h:i:s', strtotime($getStatusDate)); ?>
                  <tr>
                    <td style="display:none"><?php echo $historyRow['id']; ?></td>
                    <td>
                      <form method="post">
                          <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                          <li><a href="../../../res api/users account/Admin/download/downloadHistory.php?id=<?php echo $historyRow['id']; ?>" class="dropdown-item">Download</a></li>
                        </ul></i></a>
                      </form>
                    </td>
                    <td><?php echo $historyRow['research']; ?></td>
                    <td><?php echo $historyRow['authors']; ?></td>
                    <td><?php echo $historyRow['status']; ?></td>
                    <td><?php echo $historyRow['proposed']; ?></td>
                    <td><?php echo $historyRow['started']; ?></td>  
                    <td><?php echo $historyRow['completed']; ?></td>
                    <td style="text-align:center"><?php echo $historyRow['RorE']; ?></td>
                    <td><?php echo $historyRow['campus']; ?></td>
                    <td><?php echo $historyRow['college']; ?></td>
                    <td><?php echo $historyRow['added_by']; ?></td>
                    <td style="color:blue"><?php  ?></td>
                    <td style="color:red"><?php  ?></td>
                    <td><?php echo $statusDate; ?></td>
                  </tr>
                <?php }
              }
            }
          ?>
        </tbody>
      </table>
  </div>
  <div class="testHover" onclick="hide()">
    <span>Close</span>
  </div>
</div>

<div id="plagiarismResult" style="display:none">
  If document is not yet scanned by plagiarism checker then make a button to continue scan and automatic download after scan
  if document is already scanned then download the certificate
</div>

<?php 
  // $plagiarismResultSql = $conn->prepare("SELECT * FROM ")
?>

<script>

  function history(){
    document.getElementById("history").setAttribute("style", "display:visible");
    document.getElementById("mutedBody").setAttribute("style", "pointer-events: none;");
  }

  function hide(){
    document.getElementById("history").setAttribute("style", "display:none");
  }

  function view(){
    document.getElementById("history").setAttribute("style", "display:visible");
    // document.getElementById("mutedBody").setAttribute("style", "pointer-events: none;");
  }

  function loading(){
    document.getElementById("loading").setAttribute("style", "display:visible");
    document.getElementById("mutedBody").setAttribute("style", "pointer-events: none;");
  }
</script>

<?php
  if (isset($_POST['history'])){ ?>
    <script>
      document.getElementById("history").setAttribute("style", "display:visible");
    </script>
  <?php }
?>

<!-- Search Process -->
<script>
    const searchInput = document.getElementById('search-input');
    const tableRows = document.querySelectorAll('#my-table tbody tr');

    searchInput.addEventListener('input', () => {
    const searchString = searchInput.value.toLowerCase();

    tableRows.forEach(row => {

    
    const research = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
    const authors = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
    const status = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
    const RorE = row.querySelector('td:nth-child(6)').textContent.toLowerCase();
    const campus = row.querySelector('td:nth-child(7)').textContent.toLowerCase();
    const college = row.querySelector('td:nth-child(8)').textContent.toLowerCase();
    const foundMatch = research.includes(searchString) || authors.includes(searchString) || status.includes(searchString) || RorE.includes(searchString) || campus.includes(searchString) || college.includes(searchString);

    row.style.display = foundMatch ? 'table-row' : 'none';
  });
});
</script>

</body>
</html>
