<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Percentage</title>
    <link rel="icon" type="image/x-icon" href="../dist/img/dapitan-log.png">
</head>
<body oncontextmenu="return false">
    <?php

        session_start();

        $result = $_SESSION['similar'];
        $orig = $_SESSION['originality'];
        $similarSentence = $_SESSION['similarSentence'];
        $link = $_SESSION['link'];
        
        $decimalValue = $result/100;
        $finalValue = number_format($decimalValue, 2);
        
        $percent = 472-472*$finalValue;

        $origDecimal = $orig/100;
        $finalOrig = number_format($origDecimal, 2);

        $originality = 427-427*$finalOrig;
    ?>
    <style>
        .back-button {
          cursor: pointer;
          display: inline-flex;
          align-items: center;
          padding: 8px 12px;
          background-color: darkcyan;
          color: #333;
          border: none;
          border-radius: 4px;
          font-size: 16px;
          font-weight: bold;
          transition: background-color 0.3s ease;
          position: absolute;
          margin-bottom: -450px;
        }
        .done{
            width: 340px;
            padding: 5px;
            font-size: 25px;
            border-radius: 10px;
            cursor: pointer;
        }
    
        .back-button:hover {
          background-color: #e0e0e0;
        }
    
        .back-button i {
          margin-right: 8px;
        }
      </style>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
        .container{
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 40px;
            background: rgba(4, 4, 11, 0.935); 
            height: 100vh;
            align-items: center;
            justify-content: center; 
            display: flex;
        }
        .bar{
            width: 160px;
            height: 160px;
            position: relative;
        }
        .outer_similarities{
            height: 160px;
            width: 160px;
            border-radius: 100%;
            padding: 20px;
            background: rgba(83, 188, 30, 0.702);
        }
        .inner_similarities{
            height: 120px;
            width: 120px; 
            background: rgba(223, 17, 48, 0.645);
            border-radius: 70%;
            display: flex; 
            align-items: center;
            justify-content: center;
            flex-direction: column; 
            box-shadow: inset 2px 2px 4px -1px rgba(0,0,0,0.2);
        }
        #number{
            font-weight: 600px;
            color: #0dee18c8;
            display: flex; 
            align-items: center;
            justify-content: center;
        }
        circle{ 
            fill: none;
            stroke: url(#Simi_Color);
            stroke-width: 10px;
            stroke-dasharray: 472;
            stroke-dashoffset: 472;
            animation: animate  2s linear forwards;
        }
        @keyframes animate{100%{stroke-dashoffset: <?php echo $percent; ?>;}}
        svg{
            position: absolute;
            top: 0;
            left: 0;
        }
        /* Design for the differences */
        .outer_differences{
            height: 160px;
            width: 160px;
            border-radius: 50%;
            padding: 20px;
            background: rgba(174, 174, 6, 0.702);
        }
        .inner_differences{
            height: 120px;
            width: 120px;
            border-radius: 50%;
            display: flex;
            background: rgba(7, 7, 214, 0.471);
            align-items: center;
            justify-content: center;
            flex-direction: column; 
            box-shadow: inset 4px 4px 6px -1px rgba(0,0,0,0.2);
        }
        #dif{
            font-weight: 600px;
            color: #100e0e;
            display: flex;
            color: rgb(178, 141, 7); 
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        circle{ 
            fill: none;
            stroke: url(#GradientColor);
            stroke-width: 10px;
            stroke-dasharray: 472;
            stroke-dashoffset: 472;
            animation: animate  2s linear forwards;
        }
        @keyframes animate{100%{stroke-dashoffset: <?php echo $originality; ?>;}}
        svg{
            position: absolute;
            top: 0;
            left: 0;
        }
        #loading {
          position: fixed;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
          z-index: 9999;
          background-color: #fff;
          padding: 30px;
          font-size:30px;
          border-radius: 5px;
          box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
          /* height: 85%;
          width: 75%; */
          max-width: 75%;
          max-height: 85%;
        }
        .testHover{
          margin: 50px 20px 0px 20px; text-align: center; background-color: darkcyan; cursor: pointer; padding: 3px 0 3px 0; border-radius: 5px; box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
        }
        .testHover:hover{
          background-color: rgb(6, 177, 177);
        }
    </style>

<div class="container">
    <div class="back-button" style="margin-top: -100px;">
        <button class="done">Done</button>
    </div>

    <div class="back-button" style="margin-top: 25px;" onclick="view()">
      <button class="done" style="font-size: 20px;">Vew Similar Sentences</button>
    </div>
    <div class="bar">
        <div class="outer_similarities">
            <div class="inner_similarities">
                <div id="number">
                </div>
                <small>Similarities</small>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="160px" height="160px">
            <defs>
               <linearGradient id="Simi_Color">
                  <stop offset="50%" stop-color="red" />
                  <stop offset="100%" stop-color="blue"/>
               </linearGradient>
            </defs>
            <circle cx="80" cy="80" r="70" stroke-linecap="round" />
        </svg>
    </div>
    <div class="bar">
        <div class="outer_differences">
            <div class="inner_differences">
                <div id="dif"></div>
                <small>Originality</small>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="160px" height="160px">
            <defs>
               <linearGradient id="GradientColor">
                  <stop offset="0%" stop-color="red" />
                  <stop offset="50%" stop-color="blue">
               </linearGradient>
            </defs>
            <circle cx="80" cy="80" r="70" stroke-linecap="round" />
        </svg>
    </div>
</div>

<div id="loading" style="display: none;">
  <div style="text-align: center; margin: 20px 20px 20px 20px;">
    <span>Plagiarized detected every sentences</span>
  </div>
  <div class="similar-area" style="text-align: left; color: red; margin: 0 20px 20px 20px; overflow-y: scroll; max-height: 430px; font-size:20px">
      <?php
        $totalSentencesPlagiarized = count($similarSentence);
        if ($totalSentencesPlagiarized > 0){
            for ($sP = 0; $sP < $totalSentencesPlagiarized; $sP++)
            {
                $index = $sP + 1;
                $sentence = $similarSentence[$sP];
                $linkInSentence = $link[$sP];
                echo "<p>$index. $sentence</p><a style=color:blue href=$linkInSentence>$linkInSentence</a><br/><br>";
            }
        }else{
            echo "<p style=color:lightblue; font-size:25px;>No similarities detected!</p>";
        }
      ?>
  </div>
  <div class="testHover" onclick="hide()">
    <span>Close</span>
  </div>
</div>

<script>
  var max = document.getElementById("loading").clientHeight;
  document.getElementById("scrollView").style.height = max + "px";
  function hide(){
    document.getElementById("loading").setAttribute("style", "display:none");
  }

  function view(){
    document.getElementById("loading").setAttribute("style", "display:visible");
  }
</script>

<script>
    let number = document.getElementById("number");
    let counter = -1; 
    setInterval(() =>{
        if(counter == <?php echo round($result); ?>){
            clearInterval();
        }else{
            counter += 1;
            number.innerHTML = counter + "%";
        }
    },25);
    // Design for the differences
    let dif = document.getElementById("dif");
    let count = -1;
    setInterval(() =>{
        if(count == <?php echo round($orig); ?>){
            clearInterval();
        }else{
            count += 1;
            dif.innerHTML = count +"%";
        }
    },20);
</script>

<script>
    // JavaScript code to navigate back when the back button is clicked
    document.querySelector(".back-button").addEventListener("click", function() {
        // window.history.back();
        window.history.go(-2);
    });
</script>

</body>
</html>