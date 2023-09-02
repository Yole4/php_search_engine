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
            <a href="schedulePresentation.php" class="nav-link">
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
        <form action="../../../res api/users account/Admin/change/change.pass.php?id=schedule" method="post">
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
            <form action="../../../res api/users account/Admin/update profile/update.profile.php?check=schedule" method="POST" enctype="multipart/form-data">
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

<style>
      .left-side{
        position:absolute;
        width:30%;
        height:92.5%;
        
        
      }
      .right-side{
        position:absolute;
        width:53.5%;
        height:92.5%;
        margin-left:30%;
        height:92.5%;
        
      }
      .left-2{
        width:calc(100% - 20px);
        height:80%;
        overflow-y:scroll;
        background-color:white;
        margin-left:10px;
      }
      tr{
        text-align:left;
        
      }
      tr:hover{
        background-color:#f2f2f2;
        cursor:pointer;
      }
      th, td {
        text-align: center;
        padding: 0.5em;
        border-bottom: 5px solid #ddd;
      }
      .form-control:hover{
        border-color:lightblue;
      }
      
      
    </style>

    <div class="content-wrapper" id="container" style="">

      <div class="left-side" style="background-color:rgb(197, 203, 223)">
        <div class="left-1" style="border-radius:20px; margin-top:10px; background-color:blue; margin-left:10px; margin-right:10px">
          <p style="text-align:center;padding:5px;font-size:25px; color:white">Request Form</p>

        </div>
        <div class="input-group input-group-sm" style="">
          <select name="" id="TorA" onchange="TorA()" style="margin-left:10px; border-color:white; width:80px">
            <option value="title">Title</option>
            <option value="approved">Approved</option>
          </select>
            <input type="text" name="table_search" style="padding-left:10px; margin-left:10px;" class="form-control float-right" id="search-input" placeholder="Search Here...">
          <div class="input-group-append" style="margin-right:10px">
            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
          </div>
        </div><hr>

        <div class="left-2">
        <table id="myTable">
          <tbody id="title">

            <?php
              $table = $conn->prepare("SELECT * FROM schedule_presentation WHERE send_admin = :send_admin AND chairperson = :chairperson AND unit_head = :unit_head AND isDelete = :isDelete");
              $table->execute(['send_admin' => "Admin", 'chairperson' => "Approved", 'unit_head' => "Approved", 'isDelete' => "not"]);

              $countExist = $table->rowCount();
              $idArray = array();

              if ($countExist > 0){
                while ($sqlRow = $table->fetch(PDO::FETCH_ASSOC)){
                  // $idArray[] = $sqlRow['id'];
                  ?>
                  <tr onclick="displayData(this)">
                    <td style="display:none"><?php echo $sqlRow['id']; $idArray[] = $sqlRow['id']; ?></td>
                    <td><?php echo $sqlRow['research']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['campus']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['college']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['authors']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['remarks']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['chairperson']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['unit_head']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['admin']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['RorE']; ?></td>
                  </tr>
                <?php }
              }else{ ?>
                <tr><td></td><td>No Data Found!</td></tr>
              <?php }
            ?>
          </tbody>

          <tbody style="display:none" id="approved">

            <?php
              $table = $conn->prepare("SELECT * FROM schedule_presentation WHERE admin = :admin AND isDelete = :isDelete");
              $table->execute(['admin' => "Approved", 'isDelete' => "not"]);

              $countExist = $table->rowCount();
              $idArray = array();

              if ($countExist > 0){
                while ($sqlRow = $table->fetch(PDO::FETCH_ASSOC)){
                  // $idArray[] = $sqlRow['id'];
                  ?>
                  <tr onclick="displayData(this)">
                    <td style="display:none"><?php echo $sqlRow['id']; $idArray[] = $sqlRow['id']; ?></td>
                    <td><?php echo $sqlRow['research']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['campus']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['college']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['authors']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['remarks']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['chairperson']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['unit_head']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['admin']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['RorE']; ?></td>
                  </tr>
                <?php }
              }else{ ?>
                <tr><td></td><td>No Data Found!</td></tr>
              <?php }
            ?>
          </tbody>
          

        </table>

        <script>
          function TorA(){
            var change = document.getElementById("TorA").value;

            if (change == "title"){
              document.getElementById("title").setAttribute("style", "display:visible");
              document.getElementById("approved").setAttribute("style", "display:none");
            }else{
              document.getElementById("title").setAttribute("style", "display:none");
              document.getElementById("approved").setAttribute("style", "display:visible");
            }
          }
        </script>

        </div>


      </div>

      <div class="right-side" style="background-color:#f2f2f2f2; padding-left:40px; padding-right:40px; display:none" id="main">

        <h1 id="error" style="display:none; text-align:center">Something Went Wrong</h1>

        <div class="right-1" style="text-align:center; font-size:29px; padding-top:15px;" id="top">
          <span style="color:rgb(22, 56, 68)rgb(22, 56, 68)" id="researchId"><?php echo $myRorE; ?> Title</span><hr>
        </div>

        <!-- <input type="hidden" id="id" name="sampleId"> -->

        <div style="display:relative;">

              <div style="position:absolute; text-align:left">
                <label for="" style="padding-right:5px;">Chairperson:</label><span id="myChairperson1"></span>
              </div>
              <div style="position:absolute; margin-left:38%">
                <label for="" style="padding-right:5px;">Unit Head:</label><span id="myUnitHead1"></span>
              </div>
              <div style="position:absolute; margin-left:75%">
                <label for="" style="padding-right:5px;">Admin:</label><span id="myAdmin1"></span>
              </div>
            
            </div><br><hr>

          <div class="right-2" id="first" style="margin-top:-20px"><br>
            <label for="" style="padding-right:5px;">College:</label><span id="campusId">N/A</span><br>
            <label for="" style="padding-right:5px;">College:</label><span id="collegeId">N/A</span><br>
            <label for="" style="padding-right:5px;">Author/s:</label><span id="authorId">N/A</span><br>
            <!-- <label for="">Requested File:</label><a href="#">  Click Me To Download</a> -->
            <form action="../../../res api/users account/Admin/download schedule/index.php" method="POST">
              <input type="hidden" id="id" name="myId">
              <label for="">Requested File:</label>
              <input type="submit" name="download" value="Click Me To Download">
            </form>
          </div>

          <form action="../../../res api/users account/Admin/decline schedule/index.php" method="POST" enctype="multipart/form-data">

          <div class="form-group" id="second">
            <label for="" style="padding-right:5px">Additional Attachment (Optional):</label> <input type="file" name="file"><br>
            <label for="">Remarks (Optional)</label>
            <textarea name="remarks" id="saveRemarks" cols="30" rows="8" class="form-control" placeholder="Write Something..."></textarea>
          </div>

          <div class="right-3" id="third" style="display:relative">
            <div class="form-group" style="position:absolute">
            <label for=""></label>
              <div style="display:none">
                <input type="text" id="saveId" name="saveId">
                <input type="text" id="saveResearch" name="saveResearch">
                <input type="text" id="saveRorE" name="saveRorE">
                <input type="text" id="saveCampus" name="saveCampus">
                <input type="text" id="saveCollege" name="saveCollege">
                <input type="text" id="saveAuthors" name="saveAuthors">
              </div>
                <input type="submit" id="declinedId" class="btn btn-block btn-danger" style="background-color:" name="submitButton" value="Decline">
              
            </div>
          </form>

          <div class="form-group" id="this" style="position:absolute; margin-left:calc(70% - 18px);">
            <label for=""></label>
            <form action="../../../res api/users account/Admin/approved schedule/index.php" method="POST">
              <input type="hidden" id="sendId" name="sendId">
              <button type="submit" class="btn btn-block btn-primary" name="sendButton" style="margin-right:85px" id="forwardButton">Approved</button>
            </form>
          </div>
        </div>

      </div>

    </div>

<!-- ############################################ GET DATA AND DISPLAY  ############################################# -->

  
  <script>
    function displayData(row) {
      // Get all td elements within the clicked table row
      var tds = row.querySelectorAll('td');
      
      // Create an array to hold the extracted text content
      var data = [];
      
      // Loop through the td elements and extract text content
      for (var i = 0; i < tds.length; i++) {
        data.push(tds[i].textContent);
      }
      
      // Set input field values using the extracted data array
      
      if (data[0] == ""){
        document.getElementById("error").style.display = "block";
        document.getElementById("main").style.display = "block";
        document.getElementById("top").style.display = "none";
        document.getElementById("first").style.display = "none";
        document.getElementById("second").style.display = "none";
        document.getElementById("third").style.display = "none";
      }else{
        document.getElementById("error").style.display = "none";
        document.getElementById("main").style.display = "block";
        document.getElementById("top").style.display = "block";
        document.getElementById("first").style.display = "block";
        document.getElementById("second").style.display = "block";
        document.getElementById("third").style.display = "block";
        document.getElementById('id').value = data[0];
        document.getElementById('saveId').value = data[0];
        document.getElementById('sendId').value = data[0];
        document.getElementById('researchId').innerHTML = data[1];
        document.getElementById('saveResearch').value = data[1];
        document.getElementById('campusId').innerHTML = data[2];
        document.getElementById('saveCampus').value = data[2];
        document.getElementById('collegeId').innerHTML = data[3];
        document.getElementById('saveCollege').value = data[3];
        document.getElementById('authorId').innerHTML = data[4];
        document.getElementById('saveAuthors').value = data[4];
        document.getElementById('saveRemarks').value = data[5];
        document.getElementById('saveRorE').value = data[9];

        // #################### Chairperson ####################################
        if (data[6] == "Approved"){
          document.getElementById('myChairperson1').innerHTML = data[6];
          document.getElementById('myChairperson1').setAttribute("style", "color:blue");
        }else{
          document.getElementById('myChairperson1').innerHTML = data[6]+"...";
          document.getElementById('myChairperson1').setAttribute("style", "color:red");
        }

        // #################### Unit Head ####################################
        if (data[7] == "Approved"){
          document.getElementById('myUnitHead1').innerHTML = data[7];
          document.getElementById('myUnitHead1').setAttribute("style", "color:blue");
        }else{
          document.getElementById('myUnitHead1').innerHTML = data[7]+"...";
          document.getElementById('myUnitHead1').setAttribute("style", "color:red");
        }

        // #################### Chairperson ####################################
        if (data[8] == "Approved"){
          document.getElementById('declinedId').setAttribute("style", "display:none");
          document.getElementById('this').setAttribute("style", "margin:0px");
          document.getElementById('myAdmin1').innerHTML = data[8];
          document.getElementById('myAdmin1').setAttribute("style", "color:blue");
        }else if (data[8] == "Pending"){
          document.getElementById('myAdmin1').innerHTML = data[8]+"...";
          document.getElementById('myAdmin1').setAttribute("style", "color:red");
        }else{
          //declined
          document.getElementById('myAdmin1').innerHTML = data[8];
          document.getElementById('myAdmin1').setAttribute("style", "color:red");
        }
      }
    }
  </script>
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
