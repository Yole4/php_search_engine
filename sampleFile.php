<?php
  require_once("res api/configuration/config.php");

  ?>
  <span>Delete Account</span>
    <form action="sampleFile.php" method="Post">
      <select name="select" id="">
        <option value="Chairperson">Chairperson</option>
        <option value="Unit Head">Unit Head</option>
        <option value="Author">Author</option>
      </select>
      <input type="submit" name="delete" value="submit">
    </form>

  <span>Delete Data</span>
  <form action="sampleFile.php" method="POST">
    <input type="submit" value="DELETE" name="dataDelete">
  </form>

  <span>Delete plagiarism result</span>
  <form action="sampleFile.php" method="POST">
    <input type="submit" value="DELETE" name="deleteResult">
  </form>

  <span>Delete History</span>
  <form action="sampleFile.php" method="POST">
    <input type="submit" value="DELETE" name="deleteHistory">
  </form>

  <span>Delete Schedule</span>
  <form action="sampleFile.php" method="POST">
    <input type="submit" name="deleteSchedule" value="DELETE">
  </form>

  <span>Delete Notification</span>
  <form action="sampleFile.php" method="POST">
    <input type="submit" name="deleteNot" value="DELETE">
  </form>
  <?php

if (isset($_POST['deleteNot'])){
  $sql = $conn->query("SELECT * FROM notification");
  $sql->execute();
  $count = $sql->rowCount();
  if ($count > 0){
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
      $id = $row['id'];
      $stmt = $conn->prepare("DELETE FROM notification WHERE id = :id");
      $stmt->execute(['id' => $id]);

      $st = $stmt->rowCount();
      if ($st > 0){
        echo "delete successfully";
      }
    }
  }
}

if (isset($_POST['deleteSchedule'])){
  $sql = $conn->query("SELECT * FROM schedule_presentation");
  $sql->execute();
  $count = $sql->rowCount();
  if ($count > 0){
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
      $id = $row['id'];
      $stmt = $conn->prepare("DELETE FROM schedule_presentation WHERE id = :id");
      $stmt->execute(['id' => $id]);

      $st = $stmt->rowCount();
      if ($st > 0){
        echo "delete successfully";
      }
    }
  }
}

if (isset($_POST['dataDelete'])){
  $sql = $conn->query("SELECT * FROM all_research_data");
  $sql->execute();
  $count = $sql->rowCount();
  if ($count > 0){
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
      $id = $row['id'];
      $stmt = $conn->prepare("DELETE FROM all_research_data WHERE id = :id");
      $stmt->execute(['id' => $id]);

      $st = $stmt->rowCount();
      if ($st > 0){
        echo "delete successfully";
      }
    }
  }
}

if (isset($_POST['deleteHistory'])){
  $sql = $conn->query("SELECT * FROM history");
  $sql->execute();
  $count = $sql->rowCount();
  if ($count > 0){
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
      $id = $row['id'];
      $stmt = $conn->prepare("DELETE FROM history WHERE id = :id");
      $stmt->execute(['id' => $id]);

      $st = $stmt->rowCount();
      if ($st > 0){
        echo "delete successfully";
      }
    }
  }
}

if (isset($_POST['deleteResult'])){
  $sql = $conn->query("SELECT * FROM plagiarism_result");
  $sql->execute();
  $count = $sql->rowCount();
  if ($count > 0){
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
      $id = $row['id'];
      $stmt = $conn->prepare("DELETE FROM plagiarism_result WHERE id = :id");
      $stmt->execute(['id' => $id]);

      $st = $stmt->rowCount();
      if ($st > 0){
        echo "delete successfully";
      }
    }
  }
}

if (isset($_POST['delete'])){
  $rank = $_POST['select'];
  $sql = $conn->prepare("SELECT * FROM research_secretary WHERE rank = :rank");
  // $sql = $conn->query("SELECT * FROM all_research_data");
  $sql->execute(['rank' => $rank]);
  $count = $sql->rowCount();
  if ($count > 0){
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
      $id = $row['id'];
      $stmt = $conn->prepare("DELETE FROM research_secretary WHERE id = :id");
      $stmt->execute(['id' => $id]);

      $st = $stmt->rowCount();
      if ($st > 0){
        echo "delete successfully";
      }
    }
  }else{
    echo "not Delete";
  }
}
?>
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
      </style>
      <form action="" method="POST">
        <input type="submit" onlick="loading()">
      </form>

      <div class="loading" style="display:none" id="loading">
        Loading..
      </div>
      <script>
        function loading(){
        document.getElementById("loading").setAttribute("style", "display:visible");}
      </script>
