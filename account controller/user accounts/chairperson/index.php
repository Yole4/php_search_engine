<?php
  require_once("../../../res api/configuration/config.php");
  session_start();
  if ($_SESSION['user_id'] == ""){
    header("Location: ../../../index.php");
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
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Welcome Chairperson</title>
  <link rel="icon" type="image/x-icon" href="../../../dist/img/dapitan-log.png">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
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
        <a href="index.php" class="nav-link">Home</a>
      </li>


<!-- =============================================================== PUBLICIZE RESEARCH ================================================================================== -->

      <li class="nav-item d-none d-sm-inline-block">
        <a href="public research/index.php" class="nav-link"><?php echo $myRorE." "; ?>Programs</a>
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

          $thisRorE = $fetch['RorE'];
          $thisCampus = $fetch['campus'];
          $thisCollege = $fetch['college'];

          $chairpersonCheck = $conn->prepare("SELECT * FROM all_research_data WHERE notification = :notification AND RorE = :RorE AND campus = :campus AND college = :college AND added_by = :added_by");
          $chairpersonCheck->execute([
            'notification' => 0,
            'RorE' => $thisRorE,
            'campus' => $thisCampus,
            'college' => $thisCollege,
            'added_by' => "Chairperson"
          ]);

          $ChairpersonAuthorCheck = $conn->prepare("SELECT * FROM research_secretary WHERE notification = :notification AND RorE = :RorE AND campus = :campus AND college = :college AND added_by = :added_by AND rank = :rank");
          $ChairpersonAuthorCheck->execute([
            'notification' => 0,
            'RorE' => $thisRorE,
            'campus' => $thisCampus,
            'college' => $thisCollege,
            'added_by' => "Chairperson",
            'rank' => "Author"
          ]);

          $authorCount = $ChairpersonAuthorCheck->rowCount();
          $chairpersonCount = $chairpersonCheck->rowCount();

          $count = $chairpersonCount + $authorCount;

          if (($authorCount == 0) && ($chairpersonCount == 0)){ 
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
            //college

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

                      if (($added_by == "Chairperson") && ($RorE == $thisRorE) && ($campus == $thisCampus) && ($college == $thisCollege)){
                          $str = "You've successfully Added research data from " . $college;
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

                  if (($accountAddedBy == "Chairperson") && ($accountRorE == $thisRorE) && ($accountCampus == $thisCampus) && ($accountCollege == $thisCollege)){
                    if ($accountRank == "Author"){
                      //Chairperson add author account
                      $accountStr = "You've successfully added Author from " . $accountCollege;
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

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
      <img src="../../../dist/img/dapitan-log.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Chairperson</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
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

<!-- =========================================================== PUBLICIZE RESEARCH ======================================================================================== -->
          <li class="nav-item has-treeview" style="font-size:14px">
            <a href="schedule for presentation/schedulePresentation.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Schedule For Presentation
              </p>
            </a>
          </li>

          <!-- Start of Research -->
<!-- =========================================================== PUBLICIZE RESEARCH ======================================================================================== -->
          <li class="nav-item has-treeview">
            <a href="public research/index.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                <?php echo $myRorE." "; ?>Programs
              </p>
            </a>
          </li>
          <!-- End of Research -->

<!-- =========================================================== RESEARCH WORKS ======================================================================================== -->
          <li class="nav-item has-treeview">
            <a href="research works/index.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                <?php echo $myRorE." "; ?>Works
              </p>
            </a>
          </li>

<!-- =========================================================== AUTHOR ACCOUNTS ======================================================================================== -->

          <li class="nav-item has-treeview">
            <a href="author/index.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Author Accounts
              </p>
            </a>
          </li>
          
      </nav>
    </div>
  </aside>

<!-- =============================================== ALL NOTIFICATION ============================================================= -->

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

            $test = 0;
            $array = array();
            $dates = array();

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

                      if (($added_by == "Chairperson") && ($RorE == $thisRorE) && ($campus == $thisCampus)){
                          $str = "You've successfully added research data from " . $college;
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

                  if (($accountAddedBy == "Chairperson") && ($accountRorE == $thisRorE) && ($accountCampus == $thisCampus)){
                    if ($accountRank == "Author"){
                      //unit head add chairperson account
                      $accountStr = "You've successfully added ". $accountFullname . " as Author Account from " . $accountCollege;
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
        <form action="../../../res api/users account/users/chairperson/attributes/change password/index.php?id=home" method="post">
          <input type="hidden" name="id" value="<?php echo $user_id; ?>"> 
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
              <img class="profile-user-img img-fluid img-circle" src="../../../res api/users account/users/unit head/attributes/profile upload/<?php echo $fetch['image']; ?>" style="width:100px; height:100px" alt="User profile picture" style="width:100px; height:100px; border: 2px solid blue">
            </div>
            <!-- <label for="file" id="uploadBtn"><i class="fa solid fa-camera" id="camIcon" style="cursor:pointer; font-size:30px; color:black; margin-left:calc(100% - 57.5%); position:absolute; margin-top:-50px; color:white"></i></label> -->

            <h3 class="profile-username text-center"><?php echo $fetch['fullname']; ?></h3>
            <p class="text-muted text-center">Chairperson</p>

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
            <form action="../../../res api/users account/users/chairperson/attributes/edit profile/index.php?check=home" method="POST" enctype="multipart/form-data">
              <input type="hidden" value="<?php echo $user_id; ?>" name = "id">
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

<?php
  if (isset($_GET['already'])){
    $update = $_GET['already']; ?>
    <div id = "test" class="alert alert-danger alert-dismissible" style="margin-left:250px">
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
  if (isset($_GET['success'])){
    $update = $_GET['success']; ?>
    <div id = "test" class="alert alert-success alert-dismissible" style="margin-left:250px">
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

    <!-- Main content -->
    <style>
    .contain{
      position:absolute;
      max-width:100%;
      height:auto;
      margin-top:45px;
      padding:0;
    }
    .text{
      width:auto;
      height:auto;
      position:absolute;
      top:14%;
      left:50%;
      transform:translate(-50%, -50%);
      color:white;
      text-align:center;
      font-size:23px;
      font-weight:bold;
      text-shadow: 2px 2px 2px rgb(0,0,0,0.5);
      font-family:"Castellar";
    }
    .phone{
      display:none;
    }
    @media screen and (max-width: 767px) {
      .back1{
        display:none;
      }
      .text{
        display:none;
      }
      .phone{
        display:block;
      }
    }
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color:background: #092756;
  background: -moz-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%),-moz-linear-gradient(top,  rgba(57,173,219,.25) 0%, rgba(42,60,87,.4) 100%), -moz-linear-gradient(-45deg,  #670d10 0%, #092756 100%);
  background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -webkit-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -webkit-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
  background: -o-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -o-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -o-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
  background: -ms-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -ms-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -ms-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
  background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), linear-gradient(to bottom,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), linear-gradient(135deg,  #670d10 0%,#092756 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3E1D6D', endColorstr='#092756',GradientType=1 );">
    <div class="contain">
      <img src="../../../CSS/img/jrmsuOffice.jpeg" style="height:100%; width:100%" alt="">
      <div class="back1" style="position:absolute; top:14%; left:50%; transform:translate(-50%, -50%); background-color:yellow; height:120px; filter:blur(100px); width:600px"></div>
      <div class="back1" style="position:absolute; top:14%; left:50%; transform:translate(-50%, -50%); background-color:violet; height:120px; filter:blur(200px); width:600px"></div>
      <div class="phone" style="position:absolute; top:14%; left:50%; transform:translate(-50%, -50%); background-color:yellow; height:50px; filter:blur(100px); width:450px;"></div>
      <div class="phone" style="position:absolute; top:14%; left:50%; transform:translate(-50%, -50%); background-color:violet; height:50px; filter:blur(200px); width:450px;"></div>
      <div class="phone" style="position:absolute; top:14%; left:50%; transform:translate(-50%, -50%); color:white; height:50px;font-family:Castellar; width:450px; text-align:center"><p>Vice President for Research Development and Extension</p></div>
      <div class="text">Vice President for Research Development and Extension</div>
    </div>
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>

</div>

<!-- jQuery -->
<script src="../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="../../../dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="../../../plugins/chart/Chart.min.js"></script>
<script src="../../../dist/js/demo.js"></script>
<script src="../../../dist/js/pages/dashboard3.js"></script>

<script>
    function logout(){
        var result = confirm("Are you sure you wan't to logout?");
        if (result == false){
            event.preventDefault();
        }
    }
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
</body>
</html>
