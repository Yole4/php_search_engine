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
  <title>My <?php echo " ".$myRorE." "; ?></title>
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
          <span class="badge badge-warning navbar-badge">1</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">1 Notification Found!</span>
          <div class="dropdown-divider"></div>
            <?php
              $idSign = $fetch['id_sign'];
              $checkId = $conn->prepare("SELECT * FROM all_research_data WHERE notification = :notification AND isDelete = :isDelete AND id_sign = :id_sign");
              $checkId->execute(['notification' => 0, 'isDelete' => "not", 'id_sign' => $idSign]);
              $countCheck = $checkId->rowCount();

              date_default_timezone_set('Asia/Manila');
              $currentDate = date('F j, Y g:i:a');

              $notificationAuthor = array();
              $notificationDate = array();

              if ($countCheck > 0){
                $getId = $checkId->fetch(PDO::FETCH_ASSOC);
              } 
              $addedBy = $getId['added_by'];
              $RorE = $getId['RorE'];
              $getDate = $getId['date'];

              $updateDate = date('F j, Y h:i:s', strtotime($getDate));
              
              if ($getId['status'] == "Proposed"){
                $notBody = "$addedBy added you as proposed status";
                array_unshift($notificationAuthor, $notBody);
                array_unshift($notificationDate, $getId['date']);
              }
              
              else if ($getId['status'] == "On-Going"){
                $notBody = "$addedBy approved your $RorE data."; // Your $RorE is now On-Going
                array_unshift($notificationAuthor, $notBody);
                array_unshift($notificationDate, $getId['date']);
              }
              
              else if ($getId['status'] == "Completed"){
                $notBody = "You're $RorE is now Completed!";
                array_unshift($notificationAuthor, $notBody);
                array_unshift($notificationDate, $getId['date']);
              }
              
              ?>
              <table>
                <a href="#" class="dropdown-item" style="font-size:12px; background-color:lightblue;">
                  <i class="fas fa-bell mr-2"></i><?php echo $notificationAuthor[0]; ?>
                  <p style="margin-left:22px; font-size:10px;color:rgb(105, 96, 96)"><?php echo $updateDate; ?></p>
                </a><div style="margin:2px"></div>
              
                <!-- <a href="#" class="dropdown-item" style="font-size:12px; background-color:white;">
                  <i class="fas fa-bell mr-2"></i>test
                  <p style="margin-left:22px; font-size:10px;color:rgb(105, 96, 96)">date</p>
                </a><div style="margin:2px"></div> -->
              </table>
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
            <a href="../schedule for presentation/schedulePresentation.php" class="nav-link">
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
            <a href="myWork.php" class="nav-link">
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
        <form action="../../../../res api/users account/users/author/attributes/change password/index.php?id=my work" method="post">
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
            <form action="../../../../res api/users account/users/author/attributes/edit profile/index.php?check=my work" method="POST" enctype="multipart/form-data">
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

<!-- DataTales Example -->
<div class="card shadow mb-4" id = "data1">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary"><span style="font-size:20px">My Works</span>
    </h6>
  </div>

  <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
              <!-- <div class="card-tools"> -->
              <div>
              <div class="input-group input-group-sm" style="width: 330px; margin-left:-15px">
                    

                    <input type="text" name="table_search" style="margin-left:10px" class="form-control float-right" id="search-input" placeholder="Search From The Table">
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
                      <th class="s" style="text-align: center;">Proposed Date</th>
                      <th class="s" style="text-align: center;">Started Date</th>
                      <th class="s" style="text-align: center;">Completed Date</th>
                      <th class="s" style="text-align: center;">Added By</th>
                      <th class="s">Date Added</th>
                      <th class="s">Originality</th>
                      <th class="s">Similarity</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $id_sign = $fetch['id_sign'];
                    $college = $fetch['college'];
                    $campus = $fetch['campus'];
                    $mysql = $conn->prepare("SELECT * FROM all_research_data WHERE id_sign = :id_sign AND college = :college AND campus = :campus AND isDelete = :isDelete");
                    $mysql->execute(['id_sign' => $id_sign, 'college' => $college, 'campus' => $campus, 'isDelete' => "not"]);

                    $count = $mysql->rowCount();
                    if ($count > 0){
                    while ($row = $mysql->fetch(PDO::FETCH_ASSOC)){ 
                      
                      if ($row['college'] != ""){?>
        
                      <tr>
                        <td style="display:none"><?php echo $row['id']; ?></td>
                        <td>
                        <form action="#" method="post">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"></a>
                          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                          <li><a href="../../../../plagiarism/create certificate result/createCertificate.php?id=<?php echo $row['id']; ?>" class="dropdown-item" onclick="result()">Download Plagiarism Result</a></li>
                            <li><a href="../../../../res api/users account/users/unit head/download/index.php?id=<?php echo $row['id']; ?>" class="dropdown-item">Download</a></li>
                            <li><form action="myWork.php" method="POST">
                              <input type="hidden" value="<?php echo $row['id']; ?>" name="historyId">
                              <input type="submit" class="dropdown-item" value="History" name="history">
                            </form></li> 
                            <li>
                              <?php
                                if ($row['publicize'] == "not"){
                                  $publicize = "Set Public";
                                }else if ($row['publicize'] == "public"){
                                  $publicize = "Retrieve from public";
                                }
                                $_SESSION['public'] = $publicize;
                              ?>
                              <a href="../../../../res api/users account/users/author/publicize/publicize.php?id=<?php echo $row['id']; ?>" onclick="public()" class="dropdown-item"><?php echo $publicize; ?></a></li>
                            
                          </ul></i></a>
                        </form>
                        </td>
                        <td data-title="Title: "><?php echo $row['research']; ?></td>
                        <td data-title="Authors: "><?php echo $row['authors']; ?></td>
                        <td data-title="Status: "><?php echo $row['status']; ?></td>
                        <td data-title="Proposed Date: "><?php echo $row['proposed']; ?></td>
                        <td data-title="Started Date: "><?php echo $row['started']; ?></td>
                        <td data-title="Completed Date: "><?php echo $row['completed']; ?></td>
                        <td data-title="Added By: "><?php echo $row['added_by']; ?></td>
                        <td data-title="Date Added: "><?php echo $row['date']; ?></td>
                        <td data-title="Originality: " style="color:blue"><?php echo $row['originality']; ?>%</td>
                        <td data-title="Similarity: " style="color:red"><?php echo $row['similarity']; ?>%</td>
                        <td class="exist"></td>
                      </tr>
                    <?php }}}else{ ?>
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
    function public(){
      <?php if ($publicize == "Set Public"){?>
        var result = confirm("Are you sure you wan't to set this research into public? all have access on this portal will see it.");
        if (result == false){
            event.preventDefault();
        }
      <?php }else{ ?>
        var result = confirm("Are you sure you wan't to retrieve into public? anyone won't see it.");
        if (result == false){
            event.preventDefault();
        }
      <?php } ?>
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
                          <li><a href="../../../../res api/users account/users/author/download/historyDownload.php?id=<?php echo $historyRow['id']; ?>" class="dropdown-item">Download</a></li>
                        </ul></i></a>
                      </form>
                    </td>
                    <td><?php echo $historyRow['research']; ?></td>
                    <td><?php echo $historyRow['authors']; ?></td>
                    <td><?php echo $historyRow['status']; ?></td>
                    <td><?php echo $historyRow['proposed']; ?></td>
                    <td><?php echo $historyRow['started']; ?></td>  
                    <td><?php echo $historyRow['completed']; ?></td>
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
    const added = row.querySelector('td:nth-child(9)').textContent.toLowerCase();
    const foundMatch = research.includes(searchString) || authors.includes(searchString) || status.includes(searchString) || added.includes(searchString);

    row.style.display = foundMatch ? 'table-row' : 'none';
  });
});
</script>

</body>
</html>
