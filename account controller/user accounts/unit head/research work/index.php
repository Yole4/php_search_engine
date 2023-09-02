<?php
require_once("../../../../res api/configuration/config.php");
  session_start();
  
  if ($_SESSION['user_id'] == ""){
    header("Location: ../../../../index.php");
  }
  $_SESSION['user_id'];
  $user_id = $_SESSION['user_id'];

  $sql = $conn->prepare("SELECT * FROM research_secretary WHERE id = :id");
  if ($sql->execute(array('id' => $user_id))){
    $fetch = $sql->fetch(PDO::FETCH_ASSOC);
    
  }
  $email = $fetch['email'];
  $password = $fetch['password'];
  $myRorE = $fetch['RorE'];
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $myRorE." "; ?> List</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="../../../../dist/img/dapitan-log.png">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../../plugins/fontawesome-free/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../../../plugins/datatables-bs4/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../../plugins/datatables-responsive/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../../dist/css/adminlte.min.css">
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
          margin: 50px 20px 0px 20px; text-align: center; background-color: darkcyan; cursor: pointer; padding: 3px 0 3px 0; border-radius: 5px; box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
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

<body oncontextmenu="return false" class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-primary navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../index.php" class="nav-link">Home</a>
      </li>
      
<!-- =============================================================== PUBLICIZE RESEARCH ================================================================================== -->
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../public research/index.php" class="nav-link"><?php echo $myRorE." "; ?>Programs</a>
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

          $RorE = $fetch['RorE'];
          $campus = $fetch['campus'];

          $unitHeadCheck = $conn->prepare("SELECT * FROM all_research_data WHERE notification = :notification AND RorE = :RorE AND campus = :campus AND added_by = :added_by");
          $unitHeadCheck->execute([
            'notification' => 0,
            'RorE' => $RorE,
            'campus' => $campus,
            'added_by' => "Unit Head"
          ]);

          $chairpersonCheck = $conn->prepare("SELECT * FROM all_research_data WHERE notification = :notification AND RorE = :RorE AND campus = :campus AND added_by = :added_by");
          $chairpersonCheck->execute([
            'notification' => 0,
            'RorE' => $RorE,
            'campus' => $campus,
            'added_by' => "Chairperson"
          ]);

          $sqls = $conn->prepare("SELECT * FROM research_secretary WHERE notification = :notification AND RorE = :RorE AND campus = :campus AND added_by = :added_by AND rank = :rank");
          $sqls->execute([
            'notification' => 0,
            'RorE' => $RorE,
            'campus' => $campus,
            'added_by' => "Unit Head",
            'rank' => "Chairperson"
          ]);

          $authorCheck = $conn->prepare("SELECT * FROM research_secretary WHERE notification = :notification AND RorE = :RorE AND campus = :campus AND added_by = :added_by AND rank = :rank");
          $authorCheck->execute([
            'notification' => 0,
            'RorE' => $RorE,
            'campus' => $campus,
            'added_by' => "Unit Head",
            'rank' => "Author"
          ]);

          $ChairpersonAuthorCheck = $conn->prepare("SELECT * FROM research_secretary WHERE notification = :notification AND RorE = :RorE AND campus = :campus AND added_by = :added_by AND rank = :rank");
          $ChairpersonAuthorCheck->execute([
            'notification' => 0,
            'RorE' => $RorE,
            'campus' => $campus,
            'added_by' => "Chairperson",
            'rank' => "Author"
          ]);

          $chairpersonAddAuthor = $ChairpersonAuthorCheck->rowCount();
          $authorCount = $authorCheck->rowCount();
          $chairpersonCount = $chairpersonCheck->rowCount();
          $dataCount = $unitHeadCheck->rowCount();
          $accountCount = $sqls->rowCount();

          $count = $dataCount + $accountCount + $chairpersonCount + $authorCount + $chairpersonAddAuthor;

          if (($accountCount == 0) && ($dataCount == 0) && ($authorCount == 0) && ($chairpersonCount == 0) && ($chairpersonAddAuthor == 0)){ 
            echo "";
            }
            else{
              echo $count;
          }
          
          ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="background-color:rgb(214, 192, 192)">
          <span class="dropdown-item dropdown-header"><?php echo $count ." New Notification"; ?></span>
          <div class="dropdown-divider"></div>
                    
          <?php

            $thisRorE = $fetch['RorE'];
            $thisCampus = $fetch['campus'];

            $test = 0;
            $dates = array();
            $array = array();

            $test1 = 0;
            $dates1 = array();
            $array1 = array();

            $frontNot = 5;

            $sql = $conn->prepare("SELECT * FROM all_research_data WHERE notification = :notification");
              $sql->execute(['notification' => 0]);
              $count = $sql->rowCount();
              if ($count > 0){
                  while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                      $added_by = $row['added_by'];
                      $RorE = $row['RorE'];
                      $campus = $row['campus'];
                      $college = $row['college'];
                      $convertDate = $row['date'];

                      date_default_timezone_set('Asia/Manila');

                      //proposed date
                      $date = date('F j, Y h:i:s', strtotime($convertDate));

                      if (($added_by == "Unit Head") && ($RorE == $thisRorE) && ($campus == $thisCampus)){
                          $str = "You added research data from " . $college;
                          array_unshift($array1, $str);
                          array_unshift($dates1, $date);
                          $test1 = $test1 + 1;
                          
                      }else if (($added_by == "Chairperson") && ($RorE == $thisRorE) && ($campus == $thisCampus)){
                          $str = "Chairperson Added research data from " . $college;
                          array_unshift($array1, $str);
                          array_unshift($dates1, $date);
                          $test1 = $test1 + 1;
                      }
                      
                  }
                  
              }

              $sqlAccount = $conn->prepare("SELECT * FROM research_secretary WHERE notification = :notification");
              if ($sqlAccount->execute(['notification' => 0])){
                while ($accountRow = $sqlAccount->fetch(PDO::FETCH_ASSOC)){
                  $accountAddedBy = $accountRow['added_by'];
                  $accountRorE = $accountRow['RorE'];
                  $accountCampus = $accountRow['campus'];
                  $accountCollege = $accountRow['college'];
                  $accountDate = $accountRow['date'];
                  $accountRank = $accountRow['rank'];
                  $accountFullname = $accountRow['fullname'];

                  if (($accountAddedBy == "Unit Head") && ($accountRorE == $thisRorE) && ($accountCampus == $thisCampus)){
                    if ($accountRank == "Chairperson"){
                      //unit head add chairperson account
                      $accountStr = "You've successfully added ". $accountFullname . " as Chairperson from " . $accountCollege;
                      array_unshift($array1, $accountStr);
                      array_unshift($dates1, $accountDate);
                      $test1 = $test1 + 1;
                    }else if ($accountRank == "Author"){
                      //Unit head add author account
                      $accountStr = "You've successfully added ". $accountFullname . " as Author from " . $accountCollege;
                      array_unshift($array1, $accountStr);
                      array_unshift($dates1, $accountDate);
                      $test1 = $test1 + 1;
                    }
                  }else if (($accountAddedBy == "Chairperson") && ($accountRorE == $thisRorE) && ($accountCampus == $thisCampus)){
                    if ($accountRank == "Author"){
                      //Chairperson add author account
                      $accountStr = "Chairperson added Author from " . $accountCollege;
                      array_unshift($array1, $accountStr);
                      array_unshift($dates1, $accountDate);
                      $test1 = $test1 + 1;
                    }
                  }
                }

                
                  // $text = substr($text, 0, 50);
                  if ($test1 > 5){
                    $test1 = 5;
                  }
                    foreach ($array1 as &$text){
                      $text = substr($text, 0, 42);
                    }
                    $array1 = array_slice($array1, 0, $test1);

                    for ($k = 0; $k < $test1; $k++){
                      ?>
                      <a href="#" class="dropdown-item" style="font-size:12px; background-color:lightblue;">
                        <i class="fas fa-bell mr-2"></i> <?php echo $array1[$k]. "...."; ?></p>
                        <p style="margin-left:22px; font-size:10px;color:rgb(105, 96, 96)"><?php echo $dates1[$k]; ?></p>
                      </a><div style="margin:2px"></div>
                    <?php }
                  
                  
              }
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
          <img style="width:25px; height:25px" class="img-profile rounded-circle" src="../../../../res api/users account/users/unit head/attributes/profile upload/<?=$fetch['image']; ?>">
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
          <a class="dropdown-item" data-toggle="modal" data-target="#profile" style="cursor:pointer"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
          </a>
          <a class="dropdown-item" data-toggle="modal" data-target="#change_password" style="cursor:pointer"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
              Change Password
          </a>
          <a class="dropdown-item" href="../../../../res api/users account/Admin/logout/admin.logout.php" onclick="logout()">
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
    <a href="../index.php" class="brand-link">
      <img src="../../../../dist/img/dapitan-log.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Unit Head</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img style="width:34px; height:34px" src="../../../../res api/users account/users/unit head/attributes/profile upload/<?=$fetch['image']; ?>" class="img-profile rounded-circle">
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
              <?php echo $myRorE." "; ?>Programs
              </p>
            </a>
          </li>

          

<!-- =========================================================== RESEARCH WORKS ======================================================================================== -->
          <li class="nav-item has-treeview">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
              <?php echo $myRorE." "; ?>Works
              </p>
            </a>
          </li>

<!-- =========================================================== CHAIRPERSON ACCOUNTS ======================================================================================== -->

          <li class="nav-item has-treeview">
            <a href="../chairperson account/index.php" class="nav-link">
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
                Author Account
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
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

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

<!-- ================================================ ALL NOTIFICATION ========================================================== -->

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
              $sql = $conn->prepare("SELECT * FROM all_research_data WHERE notification = :notification");
              $sql->execute(['notification' => 0]);
              $count = $sql->rowCount();
              if ($count > 0){
                  while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                      $added_by = $row['added_by'];
                      $RorE = $row['RorE'];
                      $campus = $row['campus'];
                      $college = $row['college'];
                      $convertDate = $row['date'];

                      date_default_timezone_set('Asia/Manila');

                      //proposed date
                      $date = date('F j, Y h:i:s', strtotime($convertDate));

                      if (($added_by == "Unit Head") && ($RorE == $thisRorE) && ($campus == $thisCampus)){
                          $str = "You added research data from " . $college;
                          array_unshift($array, $str);
                          array_unshift($dates, $date);
                          $test = $test + 1;
                          
                      }else if (($added_by == "Chairperson") && ($RorE == $thisRorE) && ($campus == $thisCampus)){
                          $str = "Chairperson Added research data from " . $college;
                          array_unshift($array, $str);
                          array_unshift($dates, $date);
                          $test = $test + 1;
                      }
                      
                  }
                  
              }

              $sqlAccount = $conn->prepare("SELECT * FROM research_secretary WHERE notification = :notification");
              if ($sqlAccount->execute(['notification' => 0])){
                while ($accountRow = $sqlAccount->fetch(PDO::FETCH_ASSOC)){
                  $accountAddedBy = $accountRow['added_by'];
                  $accountRorE = $accountRow['RorE'];
                  $accountCampus = $accountRow['campus'];
                  $accountCollege = $accountRow['college'];
                  $accountDate = $accountRow['date'];
                  $accountRank = $accountRow['rank'];
                  $accountFullname = $accountRow['fullname'];

                  if (($accountAddedBy == "Unit Head") && ($accountRorE == $thisRorE) && ($accountCampus == $thisCampus)){
                    if ($accountRank == "Chairperson"){
                      //unit head add chairperson account
                      $accountStr = "You've successfully added ". $accountFullname . " as Chairperson from " . $accountCollege;
                      array_unshift($array, $accountStr);
                      array_unshift($dates, $accountDate);
                      $test = $test + 1;
                    }else if ($accountRank == "Author"){
                      //Unit head add author account
                      $accountStr = "You've successfully added ". $accountFullname . " as Author from " . $accountCollege;
                      array_unshift($array, $accountStr);
                      array_unshift($dates, $accountDate);
                      $test = $test + 1;
                    }
                  }else if (($accountAddedBy == "Chairperson") && ($accountRorE == $thisRorE) && ($accountCampus == $thisCampus)){
                    if ($accountRank == "Author"){
                      //Chairperson add author account
                      $accountStr = "Chairperson added Author from " . $accountCollege;
                      array_unshift($array, $accountStr);
                      array_unshift($dates, $accountDate);
                      $test = $test + 1;
                    }
                  }
                }

                for ($t = 0; $t < $test; $t++){ ?>
                  <a href="#" class="dropdown-item" style="font-size:12px; background-color:lightblue;">
                    <i class="fas fa-bell mr-2" style = "margin-top:10px"></i> <?php echo $array[$t]; ?></p>
                    <p style="margin-left:22px; margin-top:-15px; font-size:10px;color:rgb(105, 96, 96)"><?php echo $dates[$t]; ?></p>
                  </a><div style="margin:2px"></div>
                <?php }
              } 
              if ($test == 0){
                echo "<span style='font-size:16px'>0 Notification Found!</span>";
              }
            ?>
      </div>
    </div>
  </div>
</div>

<!-- Add Data -->

<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add <?php echo " ".$myRorE." "; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="../../../../res api/users account/users/unit head/research work/addResearch.php" method="POST" enctype="multipart/form-data">

        <div class="modal-body">

        <input type="hidden" name="RorE" value="<?php echo $fetch['RorE']; ?>">
        <input type="hidden" name="campus" value="<?php echo $fetch['campus']; ?>">

        <?php
              $campus = $fetch['campus'];
              if ($campus == "Dapitan"){ ?>
          <!--====================== DAPITAN =======================-->
                <div class="form-group" id="dapitan">
                  <label>College</label><br>
                  <select class="form-control" name="college" id="">
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
              <?php }
              
              else if ($campus == "Dipolog"){ ?>
          <!--====================== DIPOLOG =======================-->
                <div class="form-group" id="dipolog">
                  <label>College</label><br>
                  <select class="form-control" name="college" id="">
                    <option value="CED">CED</option>
                    <option value="CAS">CAS</option>
                    <option value="CIT">CIT</option>
                    <option value="CBA">CBA</option>
                    <option value="CCJE">CCJE</option>
                  </select>
                </div>
              <?php }

              else if ($campus == "Katipunan"){ ?>
          <!--====================== KATIPUNAN =======================-->
                <div class="form-group" id="katipunan"> 
                  <label>College</label><br>
                  <select class="form-control" name="college" id="">
                    <option value="CBM">CBM</option>
                    <option value="CAF">CAF</option>
                    <option value="CCJE">CCJE</option>
                    <option value="CCS">CCS</option>
                    <option value="CED">CED</option>
                  </select>
                </div>
              <?php }

              else if ($campus == "Siocon"){ ?>
          <!--====================== SIOCON =======================-->
                  <div class="form-group" id="siocon"> 
                    <label>College</label><br>
                    <select class="form-control" name="college" id="">
                      <option value="CCS">CCS</option>
                      <option value="CED">CED</option>
                      <option value="CIT">CIT</option>
                    </select>
                  </div>     
              <?php }

              else if ($campus == "Sibuco"){ ?>
          <!--====================== SIBUCO =======================-->
                <div class="form-group" id="sibuco"> 
                  <label>College</label><br>
                  <select class="form-control" name="college" id="">
                    <option value="#">#</option>
                    <option value="#">#</option>
                    <option value="#">#</option>
                  </select>
                </div>                 
              <?php }

              else if ($campus == "Tampilisan"){ ?>
          <!--====================== TAMPILISAN =======================-->
                <div class="form-group" id="tampilisan"> 
                  <label>College</label><br>
                  <select class="form-control" name="college" id="">
                    <option value="CBA">CBA</option>
                    <option value="CED">CED</option>
                    <option value="SJCE">SJCE</option>
                    <option value="SOE">SOE</option>
                    <option value="CAF">CAF</option>
                    <option value="CAS">CAS</option>
                    <option value="CCS">CCS</option>
                  </select>
                </div>                    
              <?php }
            ?>

            <div class="form-group">
                <label>Title</label>
                <input type="text" name="research" class="form-control" placeholder="Resesarch Title" required>
            </div>

            <div class="form-group">
                <label>Document</label>
                <input type="file" name="file" class="form-control" required>
            </div>
            
            
            <div class="form-group">
              <label>Author/s <input type = "number" name="countAuthor" value = 0 onchange=numberOfAuthor(this.value) style="border-radius:5px; width:40px"></label>

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
            <div class="form-group">
              <label>Status</label><br>
              <select class="form-control" name="category" id="selectpsc" onchange="psc()">
                <option value="Proposed">Proposed</option>
                <option value="On-Going">On-Going</option>
                <option value="Completed">Completed</option>
              </select>
            </div>

            <div class="form-group" id = "proposed" style="display:visible">
              <label>Proposed</label>
              <input type="date" name="proposed" class="form-control">
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
        <form action="../../../../res api/users account/users/unit head/attributes/change password/index.php?id=research work" method="post">
          <input type="hidden" name="id" value="<?php echo $fetch['id']; ?>"> 
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
        <h5 class="modal-title" id="exampleModalLabel">Edit <?php echo " ".$myRorE." "; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="../../../../res api/users account/users/unit head/research work/editResearch.php" method="POST" enctype="multipart/form-data">

        <div class="modal-body">
            
            <input type="hidden" id="update_id" name="my_id">
            <input type="hidden" id="document1">
            <input type="hidden" value="<?php echo $campus; ?>" id="campusId" name="historyCampus">
            <input type="hidden" value="<?php echo $fetch['RorE']; ?>" id="" name="historyRorE">

            <?php
              if ($campus == "Dapitan"){ ?>
          <!--====================== DAPITAN =======================-->
                <div class="form-group" id="dapitan">
                  <label>College</label><br>
                  <select class="form-control" name="college" id="dapitanId">
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
              <?php }
              
              else if ($campus == "Dipolog"){ ?>
          <!--====================== DIPOLOG =======================-->
                <div class="form-group" id="dipolog">
                  <label>College</label><br>
                  <select class="form-control" name="college" id="dipologId">
                    <option value="CED">CED</option>
                    <option value="CAS">CAS</option>
                    <option value="CIT">CIT</option>
                    <option value="CBA">CBA</option>
                    <option value="CCJE">CCJE</option>
                  </select>
                </div>
              <?php }

              else if ($campus == "Katipunan"){ ?>
          <!--====================== KATIPUNAN =======================-->
                <div class="form-group" id="katipunan"> 
                  <label>College</label><br>
                  <select class="form-control" name="college" id="katipunanId">
                    <option value="CBM">CBM</option>
                    <option value="CAF">CAF</option>
                    <option value="CCJE">CCJE</option>
                    <option value="CCS">CCS</option>
                    <option value="CED">CED</option>
                  </select>
                </div>
              <?php }

              else if ($campus == "Siocon"){ ?>
          <!--====================== SIOCON =======================-->
                  <div class="form-group" id="siocon"> 
                    <label>College</label><br>
                    <select class="form-control" name="college" id="sioconId">
                      <option value="CCS">CCS</option>
                      <option value="CED">CED</option>
                      <option value="CIT">CIT</option>
                    </select>
                  </div>     
              <?php }

              else if ($campus == "Sibuco"){ ?>
          <!--====================== SIBUCO =======================-->
                <div class="form-group" id="sibuco"> 
                  <label>College</label><br>
                  <select class="form-control" name="college" id="sibucoId">
                    <option value="#">#</option>
                    <option value="#">#</option>
                    <option value="#">#</option>
                  </select>
                </div>                 
              <?php }

              else if ($campus == "Tampilisan"){ ?>
          <!--====================== TAMPILISAN =======================-->
                <div class="form-group" id="tampilisan"> 
                  <label>College</label><br>
                  <select class="form-control" name="college" id="tampilisanId">
                    <option value="CBA">CBA</option>
                    <option value="CED">CED</option>
                    <option value="SJCE">SJCE</option>
                    <option value="SOE">SOE</option>
                    <option value="CAF">CAF</option>
                    <option value="CAS">CAS</option>
                    <option value="CCS">CCS</option>
                  </select>
                </div>                    
              <?php }
            ?>

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
              <label>Author/s</label>
              <input type="text"  id="author1" class="form-control" placeholder="Author" disabled>
              <input type="hidden" name="author" id="author2" class="form-control" placeholder="Author">
            </div>
            <div class="form-group">
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
            <div class="form-group" id = "star" style="display: none;">
              <label>Started</label>
              <input type="date" name="started" id="started1" class="form-control">
            </div>
            <div class="form-group" id = "com" style="display: none;">
              <label>Completed</label>
              <input type="date" name="completed" id="completed1" class="form-control">
            </div>
            <script>
              function editpsc(){
                var check = document.getElementById("editselectpsc");

                if (check.value == "Proposed"){
                  document.getElementById("pro").setAttribute("style", "display:visible");
                  document.getElementById("star").setAttribute("style", "display:none");
                  document.getElementById("com").setAttribute("style", "display:none");
                }
                else if (check.value == "On-Going"){
                  document.getElementById("pro").setAttribute("style", "display:visible");
                  document.getElementById("star").setAttribute("style", "display:visible");
                  document.getElementById("com").setAttribute("style", "display:none");
                }
                else if (check.value == "Completed") {
                  document.getElementById("pro").setAttribute("style", "display:visible");
                  document.getElementById("star").setAttribute("style", "display:visible");
                  document.getElementById("com").setAttribute("style", "display:visible");
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
              <img style="width:100px; height:100px" class="profile-user-img img-fluid img-circle" src="../../../../res api/users account/users/unit head/attributes/profile upload/<?=$fetch['image']; ?>" alt="User profile picture">
            </div>
            <!-- <label for="file" id="uploadBtn"><i class="fa solid fa-camera" id="camIcon" style="cursor:pointer; font-size:30px; color:black; margin-left:calc(100% - 57.5%); position:absolute; margin-top:-50px; color:white"></i></label> -->

            <h3 class="profile-username text-center"><?php echo $fetch['fullname']; ?></h3>
            <p class="text-muted text-center">Unit Head</p>

            <hr>
            <div class="form-group">
              <label for="">Email</label>
              <input type="text" class="form-control" id="yourEmail" readonly value="<?php echo $fetch['email']; ?>">
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
            <form action="../../../../res api/users account/users/unit head/attributes/change profile/index.php?check=research work" method="POST" enctype="multipart/form-data">
              <input type="hidden" value="<?php echo $fetch['id']; ?>" name = "id">
              <input type="hidden" value="<?php echo $fetch['email'];?>" name="currentEmail">
              <div class="form-group">
                <label for="">Profile Picture</label>
                <input type="file" name="file" class="form-control" id="yourEmail" value="" required>
              </div>
              <div class="form-group">
                <label for="">Full Name</label>
                <input type="text" class="form-control" name="fullname" id="yourEmail" value="<?php echo $fetch['fullname']; ?>" required>
              </div>
              <div class="form-group">
                <label for="">Email</label>
                <input type="text" class="form-control" name = "email" id="yourEmail" value="<?php echo $fetch['email']; ?>" required>
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
          <form action="../../../../res api/users account/users/unit head/create document/index.php" method="POST">

            <input type="hidden" value="<?php echo $fetch['RorE']; ?>" name="RorE">
            <input type="hidden" value="<?php echo $fetch['campus']; ?>" name="campus">

            <div class="form-group" id = "proposed" style="width:80%; margin-left:10%; margin-top:20px">
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



  <?php
    $myRorE = $fetch['RorE'];
  ?>

<!-- DataTales Example -->
<div class="card shadow mb-4" id = "data1">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><span style="font-size:20px"><span id = "a1" style="display:visible; font-size:20px"><?php echo $myRorE." "; ?>Works</span><span id = "a5" style="display:none">Approved <?php echo " ".$myRorE." "; ?> Programs</span><span id = "a2" style="display:none"><?php echo $myRorE." "; ?> On-Going Papers</span><span id = "a3" style = "display:none"><?php echo $myRorE." "; ?> Completed Papers</span><span id = "a4" style="display:none">Proposed <?php echo " ".$myRorE." "; ?> Papers</span></span>
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
                  <select name="" id="showRorE"  style="width:100px; border-color:#ccc; color:rgb(117, 107, 107)" onchange="option()">
                    <option value="all">All</option>
                    <option value="myProposed">Proposed</option>
                    <option value="on-going">On-Going</option>
                    <option value="myCompleted">Completed</option>
                    <option value="myApproved">Approved Papers</option>
                    </select>
                
                    <script>
                      var get = document.getElementById("showRorE");
                      function option(){
                        
                        if (get.value == "all"){
                          document.getElementById("all").setAttribute("style", "display:visible");
                          document.getElementById("thisProposed").setAttribute("style", "display:none");
                          document.getElementById("on-going").setAttribute("style", "display:none");
                          document.getElementById("thisCompleted").setAttribute("style", "display:none");
                          document.getElementById("approved").setAttribute("style", "display:none");
                          document.getElementById("a1").setAttribute("style", "display:visible");
                          document.getElementById("a2").setAttribute("style", "display:none");
                          document.getElementById("a3").setAttribute("style", "display:none");
                          document.getElementById("a4").setAttribute("style", "display:none");
                          document.getElementById("dateProposed").setAttribute("style", "display:visible");
                          document.getElementById("dateStarted").setAttribute("style", "display:visible");
                          document.getElementById("a5").setAttribute("style", "display:none");
                          document.getElementById("dateCompleted").setAttribute("style", "display:visible");


                        }else if (get.value == "myProposed"){
                          document.getElementById("all").setAttribute("style", "display:none");
                          document.getElementById("thisProposed").setAttribute("style", "display:visible");
                          document.getElementById("on-going").setAttribute("style", "display:none");
                          document.getElementById("thisCompleted").setAttribute("style", "display:none");
                          document.getElementById("approved").setAttribute("style", "display:none");
                          document.getElementById("a1").setAttribute("style", "display:none");
                          document.getElementById("a2").setAttribute("style", "display:none");
                          document.getElementById("a3").setAttribute("style", "display:none");
                          document.getElementById("a4").setAttribute("style", "display:visible");
                          document.getElementById("dateProposed").setAttribute("style", "display:visible");
                          document.getElementById("dateStarted").setAttribute("style", "display:none");
                          document.getElementById("a5").setAttribute("style", "display:none");
                          document.getElementById("dateCompleted").setAttribute("style", "display:none");
                          
                        }else if (get.value == "on-going"){
                          document.getElementById("all").setAttribute("style", "display:none");
                          document.getElementById("thisProposed").setAttribute("style", "display:none");
                          document.getElementById("on-going").setAttribute("style", "display:visible");
                          document.getElementById("thisCompleted").setAttribute("style", "display:none");
                          document.getElementById("approved").setAttribute("style", "display:none");
                          document.getElementById("a1").setAttribute("style", "display:none");
                          document.getElementById("a2").setAttribute("style", "display:visible");
                          document.getElementById("a3").setAttribute("style", "display:none");
                          document.getElementById("a4").setAttribute("style", "display:none");
                          document.getElementById("dateProposed").setAttribute("style", "display:visible");
                          document.getElementById("dateStarted").setAttribute("style", "display:visible");
                          document.getElementById("a5").setAttribute("style", "display:none");
                          document.getElementById("dateCompleted").setAttribute("style", "display:none");
                          

                        }else if (get.value == "myCompleted"){
                          document.getElementById("all").setAttribute("style", "display:none");
                          document.getElementById("thisProposed").setAttribute("style", "display:none");
                          document.getElementById("on-going").setAttribute("style", "display:none");
                          document.getElementById("thisCompleted").setAttribute("style", "display:visible");
                          document.getElementById("approved").setAttribute("style", "display:none");
                          document.getElementById("a1").setAttribute("style", "display:none");
                          document.getElementById("a2").setAttribute("style", "display:none");
                          document.getElementById("a3").setAttribute("style", "display:visible");
                          document.getElementById("a5").setAttribute("style", "display:none");
                          document.getElementById("a4").setAttribute("style", "display:none");
                          document.getElementById("dateProposed").setAttribute("style", "display:visible");
                          document.getElementById("dateStarted").setAttribute("style", "display:visible");
                          document.getElementById("dateCompleted").setAttribute("style", "display:visible");
                          
                        }else{
                          document.getElementById("all").setAttribute("style", "display:none");
                          document.getElementById("thisProposed").setAttribute("style", "display:none");
                          document.getElementById("on-going").setAttribute("style", "display:none");
                          document.getElementById("thisCompleted").setAttribute("style", "display:none");
                          document.getElementById("approved").setAttribute("style", "display:visible");
                          document.getElementById("a1").setAttribute("style", "display:none");
                          document.getElementById("a2").setAttribute("style", "display:none");
                          document.getElementById("a3").setAttribute("style", "display:none");
                          document.getElementById("a4").setAttribute("style", "display:none");
                          document.getElementById("a5").setAttribute("style", "display:visible");
                          document.getElementById("dateProposed").setAttribute("style", "display:visible");
                          document.getElementById("dateStarted").setAttribute("style", "display:visible");
                          document.getElementById("dateCompleted").setAttribute("style", "display:visible");
                          
                        }
                      }
                    </script>

                    <input type="text" name="table_search" style="margin-left:10px" class="form-control float-right" id="search-input" placeholder="Search From The Table...">
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
                <table id="my-table">
                  <thead>
          <tr>
            <th class="s"></th>
            <th class="s">Title</th>
            <th class="s">Authors</th>
            <th class="s">Status</th>
            <th class="s" style="text-align: center; display:visible" id = "dateProposed">Proposed Date</th>
            <th class="s" style="text-align: center; display:visible" id = "dateStarted">Started Date</th>
            <th class="s" style="text-align: center; display:visible" id = "dateCompleted">Completed Date</th>
            <th class="s">College</th>
            <th class="s">Originality</th>
            <th class="s">Similarity</th>
            <th class="s" style="text-align: center;">Added By</th>

          </tr>
        </thead>
        <tbody style="display:visible" id="all">
        <!-- =================================== ALL RESEARCH DATA ===================================================== -->

            <?php 
              $RorE = $fetch['RorE'];

              $mysql = $conn->prepare("SELECT * FROM all_research_data WHERE isDelete = :isDelete");
              $mysql->execute(['isDelete' => "not"]);

              $count = $mysql->rowCount();

              $tester = 0;
              if ($count > 0){
                
              while ($row = $mysql->fetch(PDO::FETCH_ASSOC)){ 
                $getRorE = $row['RorE'];
                $getCampus =$row['campus'];
                $getCollege = $row['college'];
                $getAddedBy = $row['added_by'];

                if ($row['college'] != ""){ 
                  if ((($getRorE == $RorE) && ($getCampus == $campus)) || (($getRorE == $RorE) && ($getCampus == $campus))){  
                $tester = $tester + 1;
                ?>
                    <tr class="hover">
                    <td style="display:none"><?php echo $row['id']; ?></td>
                      <td>
                        <form action="" method="post">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <!-- Check either document is scan or not -->
                            <?php
                              $scanSql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                              if ($scanSql->execute(['id' => $row['id']])){
                                $scanResult = $scanSql->fetch(PDO::FETCH_ASSOC);
                              }
                              $resultSign = $scanResult['result_sign'];

                              if ($resultSign == null){
                                $display = "Scan Document";
                              }else{
                                $display = "Scan Document Again";
                              }
                            ?>
                            <li><a href="../../../../plagiarism/view document/viewDocument.php?id=<?php echo $row['id']; ?>" class="dropdown-item" onclick="loading()"><?php echo $display; ?></a></li>
                            <li><a href="../../../../plagiarism/create certificate result/createCertificate.php?id=<?php echo $row['id']; ?>" class="dropdown-item" onclick="result()">Download Plagiarism Result</a></li>
                            <li><a href="../../../../res api/users account/users/unit head/download/index.php?id=<?php echo $row['id']; ?>" class="dropdown-item">Download</a></li>
                            <li><form action="index.php" method="POST">
                              <input type="hidden" value="<?php echo $row['id']; ?>" name="historyId">
                              <input type="submit" class="dropdown-item" value="History" name="history">
                            </form></li>
                            <li>
                              <form action="" method="post">
                              <input type="hidden" name="edit_data" value="">
                              <button name="Edit" type="button" class="dropdown-item edit_me">Edit</button>
                            </form>
                            </li>
                            <li>
                              <form action="../../../../res api/users account/users/unit head/research work/deleteResearch.php?delete=<?php echo $row['id']; ?>" method="post">
                              <input type="hidden" name="edit_data" value="">
                              <button name="Edit" onclick="del()" type="submit" class="dropdown-item">Delete</button>
                            </form>
                          </li>
                          </ul></i></a>
                        </form>

                      </td>
                      
                      <td data-title="Title: "><?php echo $row['research']; ?></td>
                      <td data-title="Authors: "><?php echo $row['authors']; ?></td>
                      <td data-title="Status: "><?php echo $row['status']; ?></td>
                      <td data-title="Proposed Date: "><?php echo $row['proposed']; ?></td>
                      <td data-title="Started Date: "><?php echo $row['started']; ?></td>
                      <td data-title="Completed Date: "><?php echo $row['completed']; ?></td>
                      <td data-title="College: "><?php echo $row['college']; ?></td>
                      <td style="color:blue" data-title="Originality: "><?php echo $row['originality']; ?>%</td>
                      <td style="color:red" data-title="Similarity: "><?php echo $row['similarity']; ?>%</td>
                      <td data-title="Added By: "><?php if ($row['added_by'] == "Unit Head"){ echo "You"; }else{ echo $row['added_by']; }; ?></td>

                  </tr>
                <?php }
                 ?>

                  <?php }}} if ($tester == 0){ ?>
                    <tr><td></td><td>No Data Found!</td></tr>
                  <?php } ?>
        </tbody>

        <tbody style="display:none" id="thisProposed">
        <!-- =================================== ALL RESEARCH DATA ===================================================== -->

            <?php 
              $RorE = $fetch['RorE'];

              $mysql = $conn->prepare("SELECT * FROM all_research_data WHERE isDelete = :isDelete");
              $mysql->execute(['isDelete' => "not"]);

              $count = $mysql->rowCount();

              $tester = 0;
              if ($count > 0){
                
              while ($row = $mysql->fetch(PDO::FETCH_ASSOC)){ 
                $getRorE = $row['RorE'];
                $getCampus =$row['campus'];
                $getCollege = $row['college'];
                $getAddedBy = $row['added_by'];
                $getStatus = $row['status'];

                if ($row['college'] != ""){ 
                  if ((($getRorE == $RorE) && ($getCampus == $campus)) || (($getRorE == $RorE) && ($getCampus == $campus))){  
                $tester = $tester + 1;

                if ($getStatus === "Proposed"){
                  ?>
                    <tr class="hover">
                    <td style="display:none"><?php echo $row['id']; ?></td>
                      <td>
                        <form action="" method="post">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <!-- Check either document is scan or not -->
                            <?php
                              $scanSql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                              if ($scanSql->execute(['id' => $row['id']])){
                                $scanResult = $scanSql->fetch(PDO::FETCH_ASSOC);
                              }
                              $resultSign = $scanResult['result_sign'];

                              if ($resultSign == null){
                                $display = "Scan Document";
                              }else{
                                $display = "Scan Document Again";
                              }
                            ?>
                            <li><a href="../../../../plagiarism/view document/viewDocument.php?id=<?php echo $row['id']; ?>" class="dropdown-item" onclick="loading()"><?php echo $display; ?></a></li>
                            <li><a href="../../../../plagiarism/create certificate result/createCertificate.php?id=<?php echo $row['id']; ?>" class="dropdown-item" onclick="result()">Download Plagiarism Result</a></li>
                            <li><a href="../../../../res api/users account/users/unit head/download/index.php?id=<?php echo $row['id']; ?>" class="dropdown-item">Download</a></li>
                            <li><form action="index.php" method="POST">
                              <input type="hidden" value="<?php echo $row['id']; ?>" name="historyId">
                              <input type="submit" class="dropdown-item" value="History" name="history">
                            </form></li>
                            <li>
                              <form action="" method="post">
                              <input type="hidden" name="edit_data" value="">
                              <button name="Edit" type="button" class="dropdown-item edit_me">Edit</button>
                            </form>
                            </li>
                            <li>
                              <form action="../../../../res api/users account/users/unit head/research work/deleteResearch.php?delete=<?php echo $row['id']; ?>" method="post">
                              <input type="hidden" name="edit_data" value="">
                              <button name="Edit" onclick="del()" type="submit" class="dropdown-item">Delete</button>
                            </form>
                          </li>
                          </ul></i></a>
                        </form>

                      </td>
                      
                      <td data-title="Title: "><?php echo $row['research']; ?></td>
                      <td data-title="Authors: "><?php echo $row['authors']; ?></td>
                      <td data-title="Status: "><?php echo $row['status']; ?></td>
                      <td data-title="Proposed Date: "><?php echo $row['proposed']; ?></td>
                      <td data-title="College: "><?php echo $row['college']; ?></td>
                      <td style="color:blue" data-title="Originality: "><?php echo $row['originality']; ?>%</td>
                      <td style="color:red" data-title="Similarity: "><?php echo $row['similarity']; ?>%</td>
                      <td data-title="Added By: "><?php if ($row['added_by'] == "Unit Head"){ echo "You"; }else{ echo $row['added_by']; }; ?></td>

                  </tr>
                <?php }
                }
                 ?>

                  <?php }}} if ($tester == 0){ ?>
                    <tr><td></td><td>No Data Found!</td></tr>
                  <?php } ?>
        </tbody>

        <tbody style="display:none" id="on-going">
        <!-- =================================== ALL RESEARCH DATA ===================================================== -->

            <?php 
              $RorE = $fetch['RorE'];

              $mysql = $conn->prepare("SELECT * FROM all_research_data WHERE isDelete = :isDelete");
              $mysql->execute(['isDelete' => "not"]);

              $count = $mysql->rowCount();

              $tester = 0;
              if ($count > 0){
                
              while ($row = $mysql->fetch(PDO::FETCH_ASSOC)){ 
                $getRorE = $row['RorE'];
                $getCampus =$row['campus'];
                $getCollege = $row['college'];
                $getAddedBy = $row['added_by'];
                $getStatus = $row['status'];

                if ($row['college'] != ""){ 
                  if ((($getRorE == $RorE) && ($getCampus == $campus)) || (($getRorE == $RorE) && ($getCampus == $campus))){  
                $tester = $tester + 1;

                if ($getStatus === "On-Going"){
                  ?>
                    <tr class="hover">
                    <td style="display:none"><?php echo $row['id']; ?></td>
                      <td>
                        <form action="" method="post">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <!-- Check either document is scan or not -->
                            <?php
                              $scanSql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                              if ($scanSql->execute(['id' => $row['id']])){
                                $scanResult = $scanSql->fetch(PDO::FETCH_ASSOC);
                              }
                              $resultSign = $scanResult['result_sign'];

                              if ($resultSign == null){
                                $display = "Scan Document";
                              }else{
                                $display = "Scan Document Again";
                              }
                            ?>
                            <li><a href="../../../../plagiarism/view document/viewDocument.php?id=<?php echo $row['id']; ?>" class="dropdown-item" onclick="loading()"><?php echo $display; ?></a></li>
                            <li><a href="../../../../plagiarism/create certificate result/createCertificate.php?id=<?php echo $row['id']; ?>" class="dropdown-item" onclick="result()">Download Plagiarism Result</a></li>
                            <li><a href="../../../../res api/users account/users/unit head/download/index.php?id=<?php echo $row['id']; ?>" class="dropdown-item">Download</a></li>
                            <li><form action="index.php" method="POST">
                              <input type="hidden" value="<?php echo $row['id']; ?>" name="historyId">
                              <input type="submit" class="dropdown-item" value="History" name="history">
                            </form></li>
                            <li>
                              <form action="" method="post">
                              <input type="hidden" name="edit_data" value="">
                              <button name="Edit" type="button" class="dropdown-item edit_me">Edit</button>
                            </form>
                            </li>
                            <li>
                              <form action="../../../../res api/users account/users/unit head/research work/deleteResearch.php?delete=<?php echo $row['id']; ?>" method="post">
                              <input type="hidden" name="edit_data" value="">
                              <button name="Edit" onclick="del()" type="submit" class="dropdown-item">Delete</button>
                            </form>
                          </li>
                          </ul></i></a>
                        </form>

                      </td>
                      
                      <td data-title="Title: "><?php echo $row['research']; ?></td>
                      <td data-title="Authors: "><?php echo $row['authors']; ?></td>
                      <td data-title="Status: "><?php echo $row['status']; ?></td>
                      <td data-title="Proposed Date: "><?php echo $row['proposed']; ?></td>
                      <td data-title="Started Date: "><?php echo $row['started']; ?></td>
                      <td data-title="College: "><?php echo $row['college']; ?></td>
                      <td style="color:blue" data-title="Originality: "><?php echo $row['originality']; ?>%</td>
                      <td style="color:red" data-title="Similarity: "><?php echo $row['similarity']; ?>%</td>
                      <td data-title="Added By: "><?php if ($row['added_by'] == "Unit Head"){ echo "You"; }else{ echo $row['added_by']; }; ?></td>

                  </tr>
                <?php }
                }
                 ?>

                  <?php }}} if ($tester == 0){ ?>
                    <tr><td></td><td>No Data Found!</td></tr>
                  <?php } ?>
        </tbody>

        <tbody style="display:none" id="thisCompleted">
        <!-- =================================== ALL RESEARCH DATA ===================================================== -->

            <?php 
              $RorE = $fetch['RorE'];

              $mysql = $conn->prepare("SELECT * FROM all_research_data WHERE isDelete = :isDelete");
              $mysql->execute(['isDelete' => "not"]);

              $count = $mysql->rowCount();

              $tester = 0;
              if ($count > 0){
                
              while ($row = $mysql->fetch(PDO::FETCH_ASSOC)){ 
                $getRorE = $row['RorE'];
                $getCampus =$row['campus'];
                $getCollege = $row['college'];
                $getAddedBy = $row['added_by'];
                $getStatus = $row['status'];

                if ($row['college'] != ""){ 
                  if ((($getRorE == $RorE) && ($getCampus == $campus)) || (($getRorE == $RorE) && ($getCampus == $campus))){  
                $tester = $tester + 1;

                if ($getStatus === "Completed"){
                  ?>
                    <tr class="hover">
                    <td style="display:none"><?php echo $row['id']; ?></td>
                      <td>
                        <form action="" method="post">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <!-- Check either document is scan or not -->
                            <?php
                              $scanSql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                              if ($scanSql->execute(['id' => $row['id']])){
                                $scanResult = $scanSql->fetch(PDO::FETCH_ASSOC);
                              }
                              $resultSign = $scanResult['result_sign'];

                              if ($resultSign == null){
                                $display = "Scan Document";
                              }else{
                                $display = "Scan Document Again";
                              }
                            ?>
                            <li><a href="../../../../plagiarism/view document/viewDocument.php?id=<?php echo $row['id']; ?>" class="dropdown-item" onclick="loading()"><?php echo $display; ?></a></li>
                            <li><a href="../../../../plagiarism/create certificate result/createCertificate.php?id=<?php echo $row['id']; ?>" class="dropdown-item" onclick="result()">Download Plagiarism Result</a></li>
                            <li><a href="../../../../res api/users account/users/unit head/download/index.php?id=<?php echo $row['id']; ?>" class="dropdown-item">Download</a></li>
                            <li><form action="index.php" method="POST">
                              <input type="hidden" value="<?php echo $row['id']; ?>" name="historyId">
                              <input type="submit" class="dropdown-item" value="History" name="history">
                            </form></li>
                            <li>
                              <form action="" method="post">
                              <input type="hidden" name="edit_data" value="">
                              <button name="Edit" type="button" class="dropdown-item edit_me">Edit</button>
                            </form>
                            </li>
                            <li>
                              <form action="../../../../res api/users account/users/unit head/research work/deleteResearch.php?delete=<?php echo $row['id']; ?>" method="post">
                              <input type="hidden" name="edit_data" value="">
                              <button name="Edit" onclick="del()" type="submit" class="dropdown-item">Delete</button>
                            </form>
                          </li>
                          </ul></i></a>
                        </form>

                      </td>
                      
                      <td data-title="Title: "><?php echo $row['research']; ?></td>
                      <td data-title="Authors: "><?php echo $row['authors']; ?></td>
                      <td data-title="Status: "><?php echo $row['status']; ?></td>
                      <td data-title="Proposed Date: "><?php echo $row['proposed']; ?></td>
                      <td data-title="Started Date: "><?php echo $row['started']; ?></td>
                      <td data-title="Completed Date: "><?php echo $row['completed']; ?></td>
                      <td data-title="College: "><?php echo $row['college']; ?></td>
                      <td style="color:blue" data-title="Originality: "><?php echo $row['originality']; ?>%</td>
                      <td style="color:red" data-title="Similarity: "><?php echo $row['similarity']; ?>%</td>
                      <td data-title="Added By: "><?php if ($row['added_by'] == "Unit Head"){ echo "You"; }else{ echo $row['added_by']; }; ?></td>

                  </tr>
                <?php }
                }
                 ?>

                  <?php }}} if ($tester == 0){ ?>
                    <tr><td></td><td>No Data Found!</td></tr>
                  <?php } ?>
        </tbody>

        <tbody style="display:none" id="approved">
        <!-- =================================== ALL RESEARCH DATA ===================================================== -->

            <?php 
              $RorE = $fetch['RorE'];

              $mysql = $conn->prepare("SELECT * FROM all_research_data WHERE isDelete = :isDelete");
              $mysql->execute(['isDelete' => "not"]);

              $count = $mysql->rowCount();

              $tester = 0;
              if ($count > 0){
                
              while ($row = $mysql->fetch(PDO::FETCH_ASSOC)){ 
                $getRorE = $row['RorE'];
                $getCampus =$row['campus'];
                $getCollege = $row['college'];
                $getAddedBy = $row['added_by'];
                $getStatus = $row['status'];

                if ($row['college'] != ""){ 
                  if ((($getRorE == $RorE) && ($getCampus == $campus)) || (($getRorE == $RorE) && ($getCampus == $campus))){  
                $tester = $tester + 1;

                if (($getStatus === "On-Going") || ($getStatus === "Completed")){
                  ?>
                    <tr class="hover">
                    <td style="display:none"><?php echo $row['id']; ?></td>
                      <td>
                        <form action="" method="post">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <!-- Check either document is scan or not -->
                            <?php
                              $scanSql = $conn->prepare("SELECT * FROM all_research_data WHERE id = :id");
                              if ($scanSql->execute(['id' => $row['id']])){
                                $scanResult = $scanSql->fetch(PDO::FETCH_ASSOC);
                              }
                              $resultSign = $scanResult['result_sign'];

                              if ($resultSign == null){
                                $display = "Scan Document";
                              }else{
                                $display = "Scan Document Again";
                              }
                            ?>
                            <li><a href="../../../../plagiarism/view document/viewDocument.php?id=<?php echo $row['id']; ?>" class="dropdown-item" onclick="loading()"><?php echo $display; ?></a></li>
                            <li><a href="../../../../plagiarism/create certificate result/createCertificate.php?id=<?php echo $row['id']; ?>" class="dropdown-item" onclick="result()">Download Plagiarism Result</a></li>
                            <li><a href="../../../../res api/users account/users/unit head/download/index.php?id=<?php echo $row['id']; ?>" class="dropdown-item">Download</a></li>
                            <li><form action="index.php" method="POST">
                              <input type="hidden" value="<?php echo $row['id']; ?>" name="historyId">
                              <input type="submit" class="dropdown-item" value="History" name="history">
                            </form></li> 
                            <li>
                              <form action="" method="post">
                              <input type="hidden" name="edit_data" value="">
                              <button name="Edit" type="button" class="dropdown-item edit_me">Edit</button>
                            </form>
                            </li>
                            <li>
                              <form action="../../../../res api/users account/users/unit head/research work/deleteResearch.php?delete=<?php echo $row['id']; ?>" method="post">
                              <input type="hidden" name="edit_data" value="">
                              <button name="Edit" onclick="del()" type="submit" class="dropdown-item">Delete</button>
                            </form>
                          </li>
                          </ul></i></a>
                        </form>

                      </td>
                      
                      <td data-title="Title: "><?php echo $row['research']; ?></td>
                      <td data-title="Authors: "><?php echo $row['authors']; ?></td>
                      <td data-title="Status: "><?php echo $row['status']; ?></td>
                      <td data-title="Proposed Date: "><?php echo $row['proposed']; ?></td>
                      <td data-title="Started Date: "><?php echo $row['started']; ?></td>
                      <td data-title="Completed Date: "><?php echo $row['completed']; ?></td>
                      <td data-title="College: "><?php echo $row['college']; ?></td>
                      <td style="color:blue" data-title="Originality: "><?php echo $row['originality']; ?>%</td>
                      <td style="color:red" data-title="Similarity: "><?php echo $row['similarity']; ?>%</td>
                      <td data-title="Added By: "><?php if ($row['added_by'] == "Unit Head"){ echo "You"; }else{ echo $row['added_by']; }; ?></td>

                  </tr>
                <?php }
                }
                 ?>

                  <?php }}} if ($tester == 0){ ?>
                    <tr><td></td><td>No Data Found!</td></tr>
                  <?php } ?>
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
<script src="../../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../../../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../../../plugins/datatables-bs4/dataTables.bootstrap4.min.js"></script>
<script src="../../../../plugins/datatables-responsive/dataTables.responsive.min.js"></script>
<script src="../../../../plugins/datatables-responsive/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../../../dist/js/demo.js"></script>
<!-- page script -->

<script src="../../../../add-data.js"></script>
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
        var result = confirm("Are you sure you wan't to delete this research? Author won't see it.");
        if (result == false){
            event.preventDefault();
        }
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
      $('#document1').val(data[1]);
      $('#research1').val(data[2]);
      $('#research2').val(data[2]);
      $('#author1').val(data[3]);
      $('#author2').val(data[3]);
      $('#editselectpsc').val(data[4]);
      $('#proposed1').val(data[5]);
      $('#started1').val(data[6]);
      $('#completed1').val(data[7]);

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

      var campus = document.getElementById("campusId").value;
      
      if (campus == "Dapitan"){
        //dapitans

        document.getElementById("dapitanId").value = data[8];

      }
      else if (campus == "Dipolog"){
        //dipologs

        document.getElementById("dipologId").value = data[8];
      }
      else if (campus == "Katipunan"){
        //Katipunan

        document.getElementById("katipunanId").value = data[8];
      }
      else if (campus == "Siocon"){
        //Siocon

        document.getElementById("sioconId").value = data[8];
      }
      else if (campus == "Sibuco"){
        //Sibuco

        document.getElementById("sibucoId").value = data[8];
      }
      else if (campus == "Tampilisan"){
        //Tampilisan

        document.getElementById("tampilisanId").value = data[8];
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
                          <li><a href="../../../../res api/users account/users/unit head/download/historyDownload.php?id=<?php echo $historyRow['id']; ?>" class="dropdown-item">Download</a></li>
                        </ul></i></a>
                      </form>
                    </td>
                    <td><?php echo $historyRow['research']; ?></td>
                    <td><?php echo $historyRow['authors']; ?></td>
                    <td><?php echo $historyRow['status']; ?></td>
                    <td><?php echo $historyRow['proposed']; ?></td>
                    <td><?php echo $historyRow['started']; ?></td>  
                    <td><?php echo $historyRow['completed']; ?></td>
                    <td><?php echo $historyRow['college']; ?></td>
                    <td><?php echo $historyRow['added_by']; ?></td>
                    <td style="color:blue">50%</td>
                    <td style="color:red">50%</td>
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

<script>
  function loading(){
    document.getElementById("loading").setAttribute("style", "display:visible");
  }

  function history(){
    document.getElementById("history").setAttribute("style", "display:visible");
    document.getElementById("mutedBody").setAttribute("style", "pointer-events: none;");
  }

  function hide(){
    document.getElementById("history").setAttribute("style", "display:none");
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
    const college = row.querySelector('td:nth-child(8)').textContent.toLowerCase();
    // const added = row.querySelector('td:nth-child(9)').textContent.toLowerCase();
    const foundMatch = research.includes(searchString) || authors.includes(searchString) || status.includes(searchString) || college.includes(searchString);

    row.style.display = foundMatch ? 'table-row' : 'none';
  });
});
</script>

</body>
</html>

<!-- Searching from search field is not yet -->
