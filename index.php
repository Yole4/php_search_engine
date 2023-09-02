<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>JRMSU RED</title>
  <link rel="icon" type="image/x-icon" href="dist/img/dapitan-log.png">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
         /* .landing-site{
          box-shadow:0px 0px 25px blue; border-radius:10px; text-align:center; font-size:2.5rem; color:whitesmoke; margin-top:55px; font-family:algerian; text-shadow: 2px 10px 5px rgba(0, 0, 0, 0.5); width:60%; margin-left:20%
         } */
         @media screen and (max-width: 900px) {
            .landing-site{
              font-size:28px;
              /* margin-top:0px; */
              width:90%;
              margin-left:5%;
            }
         }
      </style>
  
</head> 

<!-- =================================================== ADMIN LOGIN ==================================================== -->
<body oncontextmenu="return false" class="hold-transition login-page" style="background: #092756;
  background: -moz-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%),-moz-linear-gradient(top,  rgba(57,173,219,.25) 0%, rgba(42,60,87,.4) 100%), -moz-linear-gradient(-45deg,  #670d10 0%, #092756 100%);
  background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -webkit-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -webkit-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
  background: -o-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -o-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -o-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
  background: -ms-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -ms-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -ms-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
  background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), linear-gradient(to bottom,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), linear-gradient(135deg,  #670d10 0%,#092756 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3E1D6D', endColorstr='#092756',GradientType=1 );">

<!-- <div class="landing-site">
  <span style="">Vice President For Research Development And Extension</span>
</div> -->

<div class="login-box" style="width:450px">
  <!-- /.login-logo -->

  <div class="card" id = "loginPage" style="padding: 0px 20px 0px 20px">
    <div class="card-body login-card-body">
      <!-- <p class="login-box-msg" style="font-size:23px; font-family: areal;">ACCOUNT LOGIN</p> -->
      <div style="text-align:center">
      <img style="width:120px; height:120px" src="CSS/img/logo.png" alt="" ></div>
      <p style="text-align:center; font-size:20px"><strong>Vice President of Research Development And Extension</strong></p>
      
      <form action="res api/users account/index.php" method="post" id=login-form onsubmit="loading()">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" id="myEmail" REQUIRED>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" id = "idPass" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-eye-slash" style="cursor:pointer;" onclick="changePass()" id = "eye"></span>
            </div>
          </div>
        </div>

        <script>
            var pass = false;
            function changePass(){
              if (pass){
                  document.getElementById("idPass").setAttribute("type", "password");
                  document.getElementById("eye").setAttribute("class", "fa fa-eye-slash");
                  pass = false;
              }else{
                  document.getElementById("idPass").setAttribute("type", "text");
                  document.getElementById("eye").setAttribute("class", "fa fa-eye");
                  pass = true;
              }
            }

        </script>
        <?php 
          if (isset($_GET['invalid'])){
            $invalid = $_GET['invalid'];
            $getEmail = $_SESSION['backEmail'];
            $getPassword = $_SESSION['backPassword']; ?>
            <input type="hidden" value="<?php echo $getEmail; ?>" id="backEmail">
            <input type="hidden" value="<?php echo $getPassword; ?>" id="backPassword">
            <script>
              var email = document.getElementById("backEmail").value;
              var password = document.getElementById("backPassword").value;
              document.getElementById("myEmail").value = email;
              document.getElementById("idPass").value = password;
            </script>
            <p id = "test" style="text-align:center; padding:2px; background-color:rgb(242, 162, 162);; color:red;"><?php echo $invalid; ?></p>      
            <script>
              const response = document.getElementById("test");
              setTimeout(() => {
                response.style.display = "none";
              }, 3000);
            </script>    
            <?php
          }
        ?>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
        </div>
        <div id = "t">test</div>
        <script>
          const t = document.getElementById("t");
          t.style.display = 'none';
          setTimeout(() => {
            t.style.display = 'none';
          }, 3000);
        </script>

        <!-- login sign in -->
        <div>
          <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
        </div>
      </form>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <p style="color: red; cursor:pointer" onclick="forgot()">Forgot Password</p>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>

  <!-- ================================================= FORGOT PASSWORD ======================================================= -->

  <div class="card" style="display:none" id = "forgotPage">
    <div class="card-body login-card-body">
      <p class="login-box-msg" style="font-size:20px; font-family: areal;">Request email to reset password</p>

      <form action="res api/recover account/requestEmail.php" onsubmit="loading()" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Enter Your Email" id="inputEmail" required>
          <div class="input-group-append">
            <div class="input-group-text" id="fontStyle">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <?php 
          if (isset($_GET['already'])){
            $already = $_GET['already']; 
            $lastEmail = $_SESSION['lastEmail']; ?>
            <input type="hidden" id="getEmail" value="<?php echo $lastEmail; ?>">
            <script>
              var email = document.getElementById("getEmail").value;
              document.getElementById("inputEmail").value = email;
              document.getElementById("inputEmail").setAttribute("style", "border-color:red");
              document.getElementById("fontStyle").setAttribute("style", "border-color:red");
              document.getElementById("loginPage").setAttribute("style", "display:none");
              document.getElementById("forgotPage").setAttribute("style", "display:visible");
            </script>
            <p id = "test" style="text-align:center; padding:2px; background-color:rgb(242, 162, 162);; color:red;"><?php echo $already; ?></p>      
            <script>
              setTimeout(() => {
                document.getElementById("test").setAttribute("style", "display:none");
              }, 3000);
            </script>
            <?php
          }
        ?>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="sendRequest" class="btn btn-primary btn-block">Send Request</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <p style="color: blue; cursor:pointer" onclick="loginPage()">Login</p>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>

  <script>
    function forgot(){
      document.getElementById("loginPage").setAttribute("style", "display:none");
      document.getElementById("forgotPage").setAttribute("style", "display:visible");
    }
    function loginPage(){
      document.getElementById("loginPage").setAttribute("style", "display:visible");
      document.getElementById("forgotPage").setAttribute("style", "display:none");
    }
  </script>

</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="plugins/chart/Chart.min.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard3.js"></script>

<!-- Disable Mouse Right Click -->
<script>
    document.addEventListener("contextmenu", function(event){
      event.preventDefault();
    });
</script>

<div id="loading" style="display:none;">
    Loading...
</div>

<script>
  function loading(){
    document.getElementById("loading").setAttribute("style", "display:visible");
  }
</script>

</body>
</html>
