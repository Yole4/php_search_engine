<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/x-icon" href="../../dist/img/dapitan-log.png">
</head>
<style>

        @keyframes animate{
            from{
                transform: rotate(0deg);
                box-shadow: 5px 10px 15px blue;
            }
            to{
                transform: rotate(360deg);
                box-shadow: 5px 10px 15px yellow;
                
            }
        }
        .spanStyle{
            margin: 0;
            padding: 0;
            position: absolute;
            transform-origin: 0 100px;
            left: 50%;
            font-size: 18.9px;
            font-weight: bold;
            font-family: Arial, Helvetica; 
            color: yellow;
        }
        .loading-bar{
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

    </style>
<style>
    .loader {
      display: none; /* added to hide the loader by default */
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .circle {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 20px solid gray;
      border-top: 20px solid blue;
      animation: spin 1s linear infinite;
      animation-play-state: paused;
    }

    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .loading-body{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
  </style>
<style>
    body{
        width:60%;
        /* max-height:90%; */
        /* height:1000px; */
        margin-left:20%;
        margin-top:45px;
        /* background-color:gray; */
        background: #092756;
        background: -moz-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%),-moz-linear-gradient(top,  rgba(57,173,219,.25) 0%, rgba(42,60,87,.4) 100%), -moz-linear-gradient(-45deg,  #670d10 0%, #092756 100%);
        background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -webkit-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -webkit-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
        background: -o-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -o-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -o-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
        background: -ms-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), -ms-linear-gradient(top,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), -ms-linear-gradient(-45deg,  #670d10 0%,#092756 100%);
        background: -webkit-radial-gradient(0% 100%, ellipse cover, rgba(104,128,138,.4) 10%,rgba(138,114,76,0) 40%), linear-gradient(to bottom,  rgba(57,173,219,.25) 0%,rgba(42,60,87,.4) 100%), linear-gradient(135deg,  #670d10 0%,#092756 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3E1D6D', endColorstr='#092756',GradientType=1 );
            }
    .container{
        overflow-y:scroll;
        height:600px;
        background-color:#fff;
        padding:10px 50px 10px 50px;
        box-shadow: 0px 0px 20px 0px darkblue;
        border-radius:15px;
        border-color: green;
        border: 10px solid white;
    }
    .style-back{
        margin:0; padding:0; width:0; height:0; margin-left:-30%;
    }
    .back-button{
        padding:10px; width:70px; border-radius:10px; font-size:20px; box-shadow:0 0 20px red; border-color:white;
        cursor: pointer;
    }
    .back-button:hover{
        background-color:#ffffffff;
    }
</style>
<body oncontextmenu="return false" id="bodyId">

    <div class="style-back" id="unclickable">
        <button onclick="back()" class="back-button">Back</button>
    </div>
    <div class="container">
<?php
    require_once("../vendor/autoload.php");
    require_once("../../res api/configuration/config.php");

    if (isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = $conn->prepare("SELECT getname FROM all_research_data WHERE id = :id");
        $sql->execute(['id' => $id]);
        $sqlCount = $sql->rowCount();

        if ($sqlCount > 0){
            $row = $sql->fetch(PDO::FETCH_ASSOC);
        }
        $docxName = $row['getname'];
        $filename = "../../res api/users account/users/unit head/attributes/research documents/". $docxName;
    }

    use PhpOffice\PhpWord\IOFactory;

    $phpWord = IOFactory::load($filename);

    $writer = IOFactory::createWriter($phpWord, 'HTML');

    $writer->save('html.html');

    echo file_get_contents('html.html');
?>

<style>
    .continue-button{
        padding:10px; width:250px; border-radius:10px; background-color:white; cursor:pointer; font-size:20px; text-decoration: none;
        box-shadow:0px 0px 15px blue;
    }
    .continue-button:hover{
        background-color:red;
        font-size:22px;
        color:white;
    }
</style>
</div>
<div class="continue" style="margin:15px 0 15px 0; text-align:right">
    <a class="continue-button" href="../percentage.php?id=<?php echo $id; ?>" onclick="loading()" id="scan">Scan for plagiarism</a>
</div>
</body>
    <div class="loading-body">
        <div class="loader">
            <div class="circle"></div>
        </div>
    </div>
  <script>
    function showLoading() {
      var loader = document.querySelector('.loader');
      var circle = document.querySelector('.circle');
      loader.style.display = 'flex'; /* show the loader */
      circle.style.animationPlayState = 'running'; /* start the animation */
      document.getElementById("unclickable").setAttribute("style", "pointer-events: none;");
      document.getElementById("scan").setAttribute("style", "pointer-events: none;");
    }
  </script>

<script>
    function back(){
        window.history.back();
    }
</script>

<!-- #####################  LOADING DIV #################################### -->

<div id="loading" class="loading-bar" style="display:none">
    <div class="container" style="display: flex;
    text-align: center;
    justify-content: center;
    align-items: center; height:160px;overflow: hidden; border-radius:100%; width:85px
    ">
        <div class="text" style="position: absolute;
        height: 200px;
        width: 200px;
        border: solid rgba(27, 2, 252, 0.127);
        background-color: blue;
        border-radius: 50%;
        margin: 0;
        padding: 0;">
            <p id="text" style="margin: 0;
            padding: 0;
            height: 200px;
            width: 200px;
            border-radius: 50%;
            animation: animate 8s linear infinite;">JRMSU-RESEARCH-DEVELOPMENT-AND-EXTENSION-</p>
        </div>
        <div><img src="../../CSS/img/logo.png" id="photo" style="position: relative;
            margin: 0;
            padding: 0;" width="150px" height="150px" class="logo"></div>
    </div>
</div>

<!-- <button onclick="loading()">Click Me</button> -->

<!-- Loading Animation -->
<script>
    // function onclick(){
        const text = document.getElementById
        ('text');
        text.innerHTML = text.textContent.replace
        (/\S/g,"<span class=spanStyle>$&</span>");
        const ele = document.querySelectorAll
        ('span');
        for(var i = 1;i<ele.length;i++){
            ele[i].style.transform="rotate("+i*8.8+"deg)"; 
        }
    // }
</script>

<!-- Loading Loader -->
<script>
    function loading(){
        document.getElementById("loading").setAttribute("style", "display:visible");
        document.getElementById("unclickable").setAttribute("style", "pointer-events: none;");
        document.getElementById("scan").setAttribute("style", "pointer-events: none;");
        // document.getElementById("bodyId").setAttribute("style", "filter:blur(3px);");
        // document.getElementById("loading").setAttribute("style", "filter:blur(0px);");
    }
</script>

</html>