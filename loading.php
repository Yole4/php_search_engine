<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logo</title>
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
</head>
<body>
    <div>
        <h1>welcome to my webiste</h1>
        <form action="php.php" method="POST" onsubmit="loading()">
            <input type="submit" value="Submit Here" name="submit">
        </form>
        <span>sample</span>
    </div>
</body>

<div id="loading" class="loading-bar" style="display:none">
    <div class="container" style="display: flex;
    text-align: center;
    justify-content: center;
    align-items: center;
    min-height: 100vh;">
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
        <div><img src="CSS/img/logo.png" id="photo" style="position: relative;
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
    }
    // $(window).on('load', function() {
    //     $(".container").fadeOut("slow");
    // });
</script>


</html>