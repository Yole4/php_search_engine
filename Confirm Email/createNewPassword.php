<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Verifying</title>
  <link rel="icon" type="image/x-icon" href="../dist/img/dapitan-log.png">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<!-- Disable Mouse Right Click -->
<script>
    document.addEventListener("contextmenu", function(event){
      event.preventDefault();
    });
</script>

<body oncontextmenu="return false" class="hold-transition login-page" style="background: #092756;
  background: -moz-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%),-moz-linear-gradient(top,  rgba(57,173,219,.25) 0%, rgba(42,60,87,.4) 100%), -moz-linear-gradient(-45deg,  #670d10 0%, #092756 100%);
  background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -webkit-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -webkit-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
  background: -o-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -o-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -o-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
  background: -ms-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -ms-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -ms-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
  background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), linear-gradient(to bottom,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), linear-gradient(135deg,  #670d10 0%,#092756 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3E1D6D', endColorstr='#092756',GradientType=1 );">

    <div class="login-box">
    <!-- /.login-logo -->
        <div class="card" id = "loginPage"><div style="margin-top:5px; font-size:25px; color:darkblue; margin-left:10px">
                <i onclick="back()" style="cursor:pointer" class="fa fa-arrow-left"></i>
            </div>
            <div class="card-body login-card-body">
            <p class="login-box-msg" style="font-size:23px; font-family: areal; margin-top:-20px">Create New Password</p>

            <form action="../res api/recover account/createNewPassword.php" method="post">
                <div class="input-group mb-3">
                <input type="password" class="form-control" name="newPass" id="myPass" placeholder="New Password" REQUIRED>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span id="newPass" onclick="showNew()" style="cursor:pointer" class="fas fa-eye-slash"></span>
                    </div>
                </div>
                </div>
                <div class="input-group mb-3">
                <input type="password" class="form-control" name="conPass" id="myNewPass" placeholder="Confirm Password" REQUIRED>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span id="conPass" onclick="showCon()" style="cursor:pointer" class="fa fa-eye-slash"></span>
                    </div>
                </div>
                </div>
                <?php 
                if (isset($_GET['invalid'])){
                    $invalid = $_GET['invalid'];
                    $newPass = $_SESSION['newPass'];
                    $conPass = $_SESSION['conPass']; ?>
                    <input type="hidden" value="<?php echo $newPass; ?>" id="backNew">
                    <input type="hidden" value="<?php echo $conPass; ?>" id="backCon">
                    <script>
                        var newPass = document.getElementById("backNew").value;
                        var conPass = document.getElementById("backCon").value;
                        document.getElementById("myPass").value = newPass;
                        document.getElementById("myNewPass").value = conPass;
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
                <button type="submit" name="createNew" class="btn btn-primary btn-block">Confirm</button>
                </div>
            </form>


            <!-- /.login-card-body -->
        </div>
    </div>
</body>

<script>
    function back(){
        window.history.back();
    }
</script>

<script>
    var state = false;
    function showNew(){
        if (state){
            document.getElementById("myPass").setAttribute("type", "password");
            document.getElementById("newPass").setAttribute("class", "fa fa-eye-slash");
            state = false;
        }else{
            document.getElementById("myPass").setAttribute("type", "text");
            document.getElementById("newPass").setAttribute("class", "fa fa-eye");
            state = true;
        }
    }

    var states = false;
    function showCon(){
        if (states){
            document.getElementById("myNewPass").setAttribute("type", "password");
            document.getElementById("conPass").setAttribute("class", "fa fa-eye-slash");
            states = false;
        }else{
            document.getElementById("myNewPass").setAttribute("type", "text");
            document.getElementById("conPass").setAttribute("class", "fa fa-eye");
            states = true;
        }
    }
</script>
</body>
</html>
