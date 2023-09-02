<?php
require_once("../../../res api/configuration/config.php");
  session_start();
  
  if ($_SESSION['admin_id'] == ""){
    header("Location: ../../../index.php");
  }
  $_SESSION['admin_id'];
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
  <title>Publicize Research</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="../../../dist/img/dapitan-log.png">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../../plugins/bootstrap/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
        <a href="index.php" class="nav-link">Research & Extension Programs</a>
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
<!-- // ================================================================= END OF NOTIFICATION =============================================================================== -->

      <!-- Admin Profile -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $fetch['fullname']; ?></span>
          <img style="width:25px; height:25px" class="img-profile rounded-circle" src="../../../res api/users account/users/unit head/attributes/profile upload/<?=$fetch['image']; ?>">
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
          <img style="width:34px; height:34px" src="../../../res api/users account/users/unit head/attributes/profile upload/<?=$fetch['image']; ?>" class="img-profile rounded-circle">
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
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                R & E Programs
              </p>
            </a>
          </li>

<!-- =========================================================== RESEARCH WORKS ======================================================================================== -->
         <li class="nav-item has-treeview">
            <a href="../my added data/research.my.data.php" class="nav-link">
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
      </div>
    </section>

    <!-- Main content -->
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
        <form action="../../../res api/users account/Admin/change/change.pass.php?id=publicize" method="post">
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

    

    <!-- Edit Account -->
  

<div class="modal fade" id="yole123" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Author</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="#" method="POST">

        <div class="modal-body">
            
            <input type="hidden" id="update_id" name="my_id">
            
            <div class="form-group">
              <label>Select Either Research/Extension</label><br>
              <select class="form-control" name="RorE" id="">
                <option value="Research">Research</option>
                <option value="Extension">Extension</option>
              </select>
            </div>

            <div class="form-group">
              <label>Campus</label><br>
              <select class="form-control" name="campus" id="">
                <option value="Dapitan">Dapitan</option>
                <option value="Dipolog">Dipolog</option>
                <option value="Katipunan">Katipunan</option>
                <option value="Siocon">Siocon</option>
                <option value="Sibuco">Sibuco</option>
                <option value="Tampilisan">Tampilisan</option>
              </select>
            </div>
            <div class="form-group">
              <label>Full Name</label>
              <input type="text" name="fullname" id="name" class="form-control" placeholder="Full Name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="user" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="text" name="password" id="pass" class="form-control" placeholder="Password" required>
            </div>
        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            <button type="submit" name="edit_btn" class="btn btn-primary">Update</button>
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
              <img style="width:100px; height:100px" class="profile-user-img img-fluid img-circle" src="../../../res api/users account/users/unit head/attributes/profile upload/<?=$fetch['image']; ?>" alt="User profile picture">
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
            <form action="../../../res api/users account/Admin/update profile/update.profile.php?check=public" method="POST" enctype="multipart/form-data">
              <input type="hidden" value="<?php echo $admin_id; ?>" name = "id">
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

<!-- End of Editing Account -->

<!-- List Of Added Data -->

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><span style="font-size:20px">Research & Extension Programs
            </button><div class="form-group"></div>
    </h6>
  </div>
  <!-- ============================================================================================================================================= -->
  
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <!-- <div class="card-tools"> -->
              <div>
                  <div class="input-group input-group-sm" style="width: 330px; margin-left:-15px">

                    <input type="text" name="table_search" style="margin-left:10px" class="form-control float-right" id="search-input" placeholder="Search From Table...">
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
                <table id="my-table" style="font-size:13px">
                  <thead>
                  <tr>
                      <th class="s"></th>
                      <th class="s">Title</th>
                      <th class="s">Authors</th>
                      <th class="s">Status</th>
                      <th class="s">Research/Extension</th>
                      <th class="s">Campus</th>
                      <th class="s">College</th>
                      <th class="s">Date/Time Added</th>

                    </tr>
                  </thead>
                  <tbody style = "display:visible" id="all_id">
        
                  <?php 
                    $mysql = $conn->prepare("SELECT * FROM all_research_data WHERE publicize = :publicize AND isDelete = :isDelete");
                    $mysql->execute(['publicize' => "public", 'isDelete' => "not"]);

                    $count = $mysql->rowCount();
                    if ($count > 0){

                      while ($row = $mysql->fetch(PDO::FETCH_ASSOC)){?>
        
                      <tr class="hover">
                        <td style="display:none"><?php echo $row['id']; ?></td>
                        <td>
                        <form action="" method="post">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <!-- <li><a href="../../../plagiarism/percentage.php?id=<?php echo $row['id']; ?>" class="dropdown-item" onclick="loading()">Scan Document</a></li> -->
                            <li><a href="../../../res api/users account/Admin/download/index.php?id=<?php echo $row['id']; ?>" class="dropdown-item">Download</a></li>
                            <!-- <li>
                                <form action="" method="post">
                                <input type="hidden" name="more_data" value="">
                                <button name="Edit" type="button" class="dropdown-item more_data">More</button>
                            </form>
                            </li> -->
                          </ul></i></a>
                        </form>
                        </td>
                        <td data-title="Title: "><?php echo $row['research']; ?></td>
                        <td data-title="Authors: "><?php echo $row['authors']; ?></td>
                        <td data-title="Status: "><?php echo $row['status']; ?></td>
                        <td data-title="Research/Extension: "><?php echo $row['RorE']; ?></td>
                        <td data-title="Campus: "><?php echo $row['campus']; ?></td>
                        <td data-title="College: "><?php echo $row['college']; ?></td>
                        <td data-title="Date Added: "><?php echo $row['date']; ?></td>
                        <td class="exist"></td>
                      </tr>
                    <?php }}else{ ?>
                        <tr><td></td><td>No Data Found!</td></tr>
                    <?php } ?>
                  <!-- ====================================================================================================== -->
                  </tbody>

                </table>
              </div>

  <!-- ============================================================================================================================================ -->

  

<!-- End The List Of Data -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

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
      $('#name').val(data[1]);
      $('#user').val(data[2]);
      $('#pass').val(data[3]);

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

<script>
  function loading(){
    document.getElementById("loading").setAttribute("style", "display:visible");
    document.getElementById("mutedBody").setAttribute("style", "pointer-events: none;");
  }
</script>

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
