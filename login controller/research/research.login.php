<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Home</title>
  <link rel="icon" type="image/x-icon" href="../../dist/img/dapitan-log.png">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="../../CSS/fontawesome-free.css" rel="stylesheet" type="text/css">
   <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
 
   <!-- Custom styles for this template-->
   <link href="../../CSS/sb-admin.css" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-primary navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="../../index.php" class="nav-link">Home</a>
      </li>

      <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Publicize Research</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="../../pages/Public Research/public.baliktad.php" class="dropdown-item">Research </a></li>
              <li><a href="../../pages/Public Research/public_research.php" class="dropdown-item">Extension</a></li>
            </ul>
       </li>

      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Event</a>
      </li>
      <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Login As</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="research.login.php" class="dropdown-item">Research </a></li>
              <li><a href="../extension/extension.login.php" class="dropdown-item">Extension</a></li>
              <li><a href="../admin/admin.login.php" class="dropdown-item">Admin</a></li>
            </ul>
       </li>
    </ul>

    <!-- SEARCH FORM -->
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu -->
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index.php" class="brand-link">
      <img src="../../dist/img/dapitan-log.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Home</span>
    </a>

    <!-- Options -->
    
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item dropdown">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="nav-icon fa fa-copy"></i> Publick Research</a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                  <li><a href="../../pages/Public Research/public.baliktad.php" class="dropdown-item">Research </a></li>
                  <li><a href="../../pages/Public Research/public_research.php" class="dropdown-item">Extension</a></li>
                </ul>
              </li>

              <li class="nav-item dropdown">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="nav-icon fa fa-lock"></i> Login As</a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                  <li><a href="research.login.php" class="dropdown-item">Research </a></li>
                  <li><a href="../extension/extension.login.php" class="dropdown-item">Extension</a></li>
                  <li><a href="../admin/admin.login.php" class="dropdown-item">Admin</a></li>
                </ul>
              </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <body id="page-top">
 
        <!-- Page Wrapper -->
        <div id="wrapper">
     
     
     <div class="container">
     
     <!-- Outer Row -->
     <div class="row justify-content-center">
     
       <div class="col-xl-6 col-lg-6 col-md-6">
     
         <div class="card o-hidden border-0 shadow-lg my-5">
           <div class="card-body p-0">
             <!-- Nested Row within Card Body -->
             <div class="row">
               <div class="col-lg-12">
                 <div class="p-5">
                   <div class="text-center">
                     <h1 class="h4 text-gray-900 mb-4" style="font-size:30px; font-style:bold">Research Portal</h1>
                   </div>

                      <?php
                        if (isset($_GET['login'])){
                          $login = $_GET['login'];
                          ?><h4 style="background-color:#ff4d4d; border-radius:10px; color:white; text-align:center; padding-top:10px; padding-bottom:10px; font-size:20px"><?php echo $login; ?></h4><?php
                        }
                      ?>

                     <form class="user" action="../../res api/users account/Research/research.login.php" method="POST">

                        <div class="form-group" style="text-align:center">
                            <i class="fa fa-users" style="position:absolute; font-size:20px; margin-top:13px; margin-left:15px; color:c###"></i>
                            <select style="width:100%; height:50px; border-radius:20px; padding-left:50px" name="secretary_author" id="" class="input">
                                <option value="Secretary">Secretary</option>
                                <option value="Author">Author</option>
                            </select>
                        </div>

                        <div class="form-group" style="text-align:center">
                            <i class="fas fa-home" style="position:absolute; font-size:20px; margin-top:13px; margin-left:15px; color:c###"></i>
                            <select style="width:100%; height:50px; border-radius:20px; padding-left:50px" name="campus" id="" class="input">
                                <option value="Dapitan">Dapitan</option>
                                <option value="Dipolog">Dipolog</option>
                                <option value="Katipunan">Katipunan</option>
                                <option value="Siocon">Siocon</option>
                                <option value="Sibuco">Sibuco</option>
                                <option value="Tampilisan">Tampilisan</option>
                            </select>
                        </div>
                        <div class="form-group">
                          <i class="fa fa-user" style="position:absolute; font-size:20px; margin-top:13px; margin-left:20px; color:c###"></i>
                         <input style="padding-left:50px" type="text" name="username" class="form-control form-control-user" placeholder="Username">
                         </div>
                         <div class="form-group">
                         <i class="fa fa-lock" style="position:absolute; font-size:20px; margin-top:13px; margin-left:20px; color:c###"></i>
                         <input style="padding-left:50px" type="password" name="password" class="form-control form-control-user" placeholder="Password" id="id_password">
                         <i class="fa fa-eye-slash" style="font-size:20px; position:absolute; margin-top:-35px; margin-left: calc(100% - 165px); cursor:pointer" onclick="test()" id="eye"></i>
                         
                         <script>
                          var state = false;
                          function test(){
                            if (state){
                              document.getElementById("id_password").setAttribute("type", "password");
                              document.getElementById("eye").setAttribute("class", "fa fa-eye-slash");
                              state = false;
                            }else{
                              document.getElementById("id_password").setAttribute("type", "text");
                              document.getElementById("eye").setAttribute("class", "fa fa-eye");
                              state = true;
                            }
                          }
                         </script>
                        </div>
                 
                         <button style="font-size:25px" type="submit" name="login_btn" class="btn btn-primary btn-user btn-block"> Login </button>
                         <hr>
                     </form>
     
     
                 </div>
               </div>
             </div>
           </div>
         </div>
     
       </div>
     
     </div>
     
     </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="../../dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="../../plugins/chart/Chart.min.js"></script>
<script src="../../dist/js/demo.js"></script>
<script src="../../dist/js/pages/dashboard3.js"></script>
</body>
</html>
