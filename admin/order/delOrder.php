<?php
  require "../../connect.php";

  if (isset($_POST['orderID'])){
    $orderID = $_POST['orderID'];
    $conn->query("SET foreign_key_checks = 0");
    $conn->query("DELETE FROM donhang WHERE MADON = '$orderID'");
    $conn->query("DELETE FROM chitiet_donhang WHERE MADON = '$orderID'");
    echo 1;
  }else echo 0;
?>