<?php
    session_start();
    $code = $_SESSION['code'];
    if ($code === null){
      header("Location: ../index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Verify</title>
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
        <div class="card" id = "forgotPage">
            <div style="margin-top:5px; font-size:25px; color:darkblue; margin-left:10px">
                <i onclick="back()" style="cursor:pointer" class="fa fa-arrow-left"></i>
            </div>

            <div class="card-body login-card-body">
            <p class="login-box-msg" style="font-size:20px; font-family: areal; margin-top:-20px">Enter Code Sent To Email</p>

            <form action="../res api/recover account/verifyCode.php" method="post">
                <div class="input-group mb-3">
                <input type="text" class="form-control" name="code" placeholder="Enter Code">
                <div class="input-group-append">
                    <div class="input-group-text">
                    </div>
                </div>
                </div><?php 
          if (isset($_GET['invalid'])){
            $invalid = $_GET['invalid']; ?>
            <p id = "test" style="text-align:center; padding:2px; background-color:rgb(242, 162, 162);; color:red;"><?php echo $invalid; ?></p>      
            <script>
              const response = document.getElementById("test");
              setTimeout(() => {
                response.style.display = "none";
              }, 5000);
            </script>    
            <?php
          }
        ?>
                <div class="row">
                <div class="col-12">
                    <button type="submit" name="sendingCode" class="btn btn-primary btn-block">Send</button>
                </div>
                <!-- /.col -->
                </div>
            </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</body>

<script>
    function back(){
        window.history.back();
    }
</script>

</body>
</html>
