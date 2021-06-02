<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>PHP</title>
  <link rel="stylesheet" href="./styles.css">
</head>

<body>
  <div class="otvet" style="text-align: center;">
    <?php
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = @$_SERVER['REMOTE_ADDR'];
    if (filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
    elseif (filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
    else $ip = $remote;
    

    $connect = mysqli_connect("localhost:3307", "root", "", "lab8");
    $querynum = "SELECT * FROM `lab8` WHERE 1";
    $result = mysqli_query($connect, $querynum);
    $numip = 0;
    while ($data = mysqli_fetch_array($result)) {
      if ($data['ip'] == $ip) {
        $numip = ($data['num'] + 1);
      }
    }
    $a = mysqli_query($connect, "SELECT COUNT(1) FROM `lab8` WHERE ip='$ip'");
    $b = mysqli_fetch_array($a);
    echo "<h2 style=margin:0>Общее колличество посещений сайта: $numip</h2><br/>";
    echo "<h2 style='padding:0px;margin:0 0 20px 0;'>Tекущий ip: $ip </h2>";
    if ($b[0] == 0) {
      $query = "INSERT INTO `lab8` (`num`,`ip`) VALUES (3,'$ip')";
      $result = mysqli_query($connect, $query);
    } else {
      $query = "UPDATE `lab8` SET `num`='$numip' WHERE `ip`='$ip'";
      $result = mysqli_query($connect, $query);
    }

    $query = "SELECT * FROM `lab8` ORDER BY `num` DESC";
    $result = mysqli_query($connect, $query);
    echo '<table style="margin:auto">';
    while ($data = mysqli_fetch_array($result)) {
      echo "<tr>" . "<th>ip: " . $data['ip'] . " </th>" . "<th> Посещений: " . $data['num']. "</th>" . "</tr>";
    }
    ?>
</body>

</html>