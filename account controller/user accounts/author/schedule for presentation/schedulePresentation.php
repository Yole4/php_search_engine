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
  <title>Schedule For Presentation</title>
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

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

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
          <span class="badge badge-warning navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">0 Notification Found!</span>
          <div class="dropdown-divider"></div>

                <!-- <table>
                    
                      <a href="#" class="dropdown-item" style="font-size:12px; background-color:lightblue;">
                        <i class="fas fa-bell mr-2"></i> <p style="margin-left:22px; "></p>
                        <p style="margin-left:22px; font-size:10px;color:rgb(105, 96, 96)"></p>
                      </a><div style="margin:2px"></div>
                    
                      <a href="#" class="dropdown-item" style="font-size:12px; background-color:white;">
                        <i class="fas fa-bell mr-2"></i><p style="margin-left:22px; "></p>
                        <p style="margin-left:22px; font-size:10px;color:rgb(105, 96, 96)"></p>
                      </a><div style="margin:2px"></div>
                    

                </table> -->
                

          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
<!-- // =================================================================END OF NOTIFICATION =============================================================================== -->

      <!-- Admin Profile -->
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $fetch['fullname']; ?></span>
          <img style="width:25px; height:25px" class="img-profile rounded-circle" src="../../../../res api/users account/users/unit head/attributes/profile upload/<?php echo $fetch['image']; ?>">
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
      <span class="brand-text font-weight-light">Author</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img style="width:25px; height:25px" class="img-profile rounded-circle" src="../../../../res api/users account/users/unit head/attributes/profile upload/<?php echo $fetch['image']; ?>">
        </div>
        <div class="info">
          <a href="#" class="d-block" data-toggle="modal" data-target="#profile" style="cursor:pointer"><?php echo $fetch['fullname'];?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

<!-- =========================================================== PUBLICIZE RESEARCH ======================================================================================== -->
        <li class="nav-item has-treeview" style="font-size:14px">
            <a href="schedulePresentation.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
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
            <a href="../my work/myWork.php" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                <?php echo $myRorE." "; ?>Works
              </p>
            </a>
          </li>

      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
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
        <form action="../../../../res api/users account/users/author/attributes/change password/index.php?id=schedule" method="post">
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
          <img style="width:100px; height:100px" class="img-profile rounded-circle" src="../../../../res api/users account/users/unit head/attributes/profile upload/<?php echo $fetch['image']; ?>">
            </div>
            <!-- <label for="file" id="uploadBtn"><i class="fa solid fa-camera" id="camIcon" style="cursor:pointer; font-size:30px; color:black; margin-left:calc(100% - 57.5%); position:absolute; margin-top:-50px; color:white"></i></label> -->

            <h3 class="profile-username text-center"><?php echo $fetch['fullname']; ?></h3>
            <p class="text-muted text-center">Author</p>

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
            <form action="../../../../res api/users account/users/author/attributes/edit profile/index.php?check=schedule" method="POST" enctype="multipart/form-data">
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

<div class="modal fade" id="requestForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Request Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="../../../../res api/users account/users/author/request form/requestForm.php" method="POST" enctype="multipart/form-data">

        <?php
          $idSign = $fetch['id_sign'];

          $title = $conn->prepare("SELECT * FROM all_research_data WHERE id_sign = :id_sign");
          if ($title->execute(['id_sign' => $idSign])){
            $getTitle = $title->fetch(PDO::FETCH_ASSOC);
          }
          $researchTitle = $getTitle['research'];    
          $authors = $getTitle['authors'];      
          $status = $getTitle['status'];
          

          if ($status == "Proposed"){
            $stat = "none";
            $display = "visible";
          }else{
            $stat = "visible";
            $display = "none";
          }
        ?>
        <div style="display:<?php echo $display; ?>; text-align:center">
          <h4 style="color:red">You are not yet approved!</h4>
        </div>
          <div style="display:<?php echo $stat; ?>">
            <input type="hidden" value="<?php echo $researchTitle; ?>" name="researchTitle">
            <input type="hidden" value="<?php echo $fetch['RorE']; ?>" name="RorE">
            <input type="hidden" value="<?php echo $fetch['campus']; ?>" name="campus">
            <input type="hidden" value="<?php echo $fetch['college']; ?>" name="college">
            <input type="hidden" value="<?php echo $authors; ?>" name="authors">
            <div class="form-group">
              <label for="">Request File</label>
              <input type="file" class="form-control" name="file" required>
            </div>

            <div class="form-group">
              <label for="">Remarks (Optional)</label>
              <textarea class="form-control" name="remarks" placeholder="Write Anything..." id="" cols="30" rows="6"></textarea>
            </div>

              <div class="form-group" style="text-align:center">
                <input type="submit" value="Send To Chairperson" id="savebutton" name="sendToChairperson" class="btn btn-primary" style="width:100%">
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

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

      <div class="left-side" style="background-color:rgb(197, 203, 223); padding-top:20px">

        <div style="padding-left:10px;">
          <span style="font-size:30px; padding-right:10px">Request Form</span>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#requestForm">
              Add Request
            </button>
        </div><hr>

        <div class="left-2">
        <table id="myTable">
          <tbody>
            <?php
              $sqlSchedule = $conn->prepare("SELECT * FROM schedule_presentation WHERE research = :research AND isDelete = :isDelete");
              $sqlSchedule->execute(['research' => $researchTitle, 'isDelete' => "not"]);

              $countSchedule = $sqlSchedule->rowCount();

              if ($countSchedule > 0){
                while ($sqlRow = $sqlSchedule->fetch(PDO::FETCH_ASSOC)){ ?>
                  <tr onclick="displayData(this)">
                    <td style="display:none"><?php echo $sqlRow['id']; ?></td>
                    <td><?php echo $sqlRow['research']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['campus']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['college']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['authors']; ?></td>
                    <td style="display:none"><?php echo $sqlRow['remarks']; ?></td>
                  </tr>
                <?php }
              }
            ?>
          </tbody>

        </table>
        </div>


      </div>
      <input type="hidden" id="id">

      <div class="right-side" style="background-color:#f2f2f2f2; padding-left:40px; padding-right:40px; display:none" id="main">

        <h1 id="error" style="display:none; text-align:center">Something Went Wrong</h1>

        <div class="right-1" style="text-align:center; font-size:29px; padding-top:15px;" id="top">
          <span style="color:rgb(22, 56, 68)rgb(22, 56, 68)" id="researchId"><?php echo $myRorE; ?> Title</span><hr>
        </div>

        <?php
          $position = $conn->prepare("SELECT * FROM schedule_presentation WHERE research = :research");
          if ($position->execute(['research' => $researchTitle])){
            $getPosition = $position->fetch(PDO::FETCH_ASSOC);
          }

        ?>

        <form action="../../../../res api/users account/users/author/save button/save.php?id=<?php echo $getPosition['id']; ?>" method="POST" enctype="multipart/form-data">

        <div class="right-2" id="first">
            <div style="display:none">
              <label for="" style="padding-right:5px"><span>Campus: </span></label><span id="campusId">N/A</span><br>
              <label for="" style="padding-right:5px"><span>College: </span></label><span id="collegeId">N/A</span><br>
            </div>
            <div style="display:relative;">
              <!-- <div style="text-align:center">
                <h5>Status</h5>
              </div> -->

              <?php
                $chairperson = $getPosition['chairperson'];
                $unit_head = $getPosition['unit_head'];
                $admin = $getPosition['admin'];

                if ($chairperson == "Approved"){
                  $cColor = "blue";
                  $cDot = "none";
                }else{
                  $cColor = "red";
                  $cDot = "visible";
                }

                if ($unit_head == "Approved"){
                  $uColor = "blue";
                  $uDot = "none";
                }else{
                  $uColor = "red";
                  $uDot = "visible";
                }

                if ($admin == "Approved"){
                  $aColor = "blue";
                  $aDot = "none";
                }else{
                  $aColor = "red";
                  $aDot = "visible";
                }
              ?>  

              <div style="position:absolute; text-align:left">
                <label for="" style="padding-right:5px;">Chairperson:</label><span style="color:<?php echo $cColor; ?>"><?php echo $getPosition['chairperson']; ?><span style="display:<?php echo $cDot; ?>">...</span></span>
              </div>
              <div style="position:absolute; margin-left:38%">
                <label for="" style="padding-right:5px;">Unit Head:</label><span style="color:<?php echo $uColor; ?>"><?php echo $getPosition['unit_head']; ?><span style="display:<?php echo $uDot; ?>">...</span></span>
              </div>
              <div style="position:absolute; margin-left:75%">
                <label for="" style="padding-right:5px;">Admin:</label><span style="color:<?php echo $aColor; ?>"><?php echo $getPosition['admin']; ?><span style="display:<?php echo $aDot; ?>">...</span></span>
              </div>
            
            </div><br><hr>
            <label for="" style="padding-right:5px">Author/s:</label><span id="authorId">N/A</span><br>
            <label for="">Requested File:</label><a href="../../../../res api/users account/users/author/download/download.php?id=<?php echo $getPosition['id']; ?>">  Click Me To Download</a>
            <div>
              <label for="" style="padding-right:5px">Add another file (Optional)</label><input type="file" name="file">
              <!-- <input type="file" class="form-control" > -->
            </div>
          </div>
          <div class="form-group" id="second">
            <label for="">Remarks (Optional)</label>
            <textarea name="updateRemarks" id="saveRemarks" cols="30" rows="8" class="form-control" placeholder="Write Something..."></textarea>
          </div>

          <div class="right-3" id="third">

                <input type="text" id="saveId" name="saveId" style="display:none">
                <input type="text" id="saveResearch" name="saveResearch" style="display:none">
                <input type="text" id="saveRorE" name="saveRorE" style="display:none">
                <input type="text" id="saveCampus" name="saveCampus" style="display:none">
                <input type="text" id="saveCollege" name="saveCollege" style="display:none">
                <input type="text" id="saveAuthors" name="saveAuthors" style="display:none">
                <input type="text" id="saveRequestFile" name="saveRequestFile" style="display:none">
                <input type="text" id="saveAdditional" name="saveAdditional" style="display:none">

                <input type="submit" name="submitButton" class="btn btn-block btn-primary" style="background-color:" value="Save">
              
          </form>
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
        document.getElementById('researchId').innerHTML = data[1];
        document.getElementById('saveResearch').value = data[1];
        document.getElementById('campusId').innerHTML = data[2];
        document.getElementById('saveCampus').value = data[2];
        document.getElementById('collegeId').innerHTML = data[3];
        document.getElementById('saveCollege').value = data[3];
        document.getElementById('authorId').innerHTML = data[4];
        document.getElementById('saveAuthors').value = data[4];
        document.getElementById('saveRemarks').value = data[5];
      }
    }
  </script>



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
      $('#status1').val(data[4]);
      $('#proposed1').val(data[5]);
      $('#started1').val(data[6]);
      $('#completed1').val(data[7]);

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
