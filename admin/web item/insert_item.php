<?php
require "../../connect.php";

function validatePrice($price)
{
  $price = trim($price);

  if (ctype_digit($price)) {
    return true;
  } else {
    return false;
  }
}

function validateColor($color)
{
  $color = trim($color);
  if (ctype_digit($color)) {
    return false;
  } else {
    return true;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_FILES["imageInputMain"])) {
    $fileMain = $_FILES["imageInputMain"];
  }

  if (isset($_FILES["imageInputSide"])) {
    $fileSide = $_FILES["imageInputSide"];
    $fileSide1 = $fileSide['name'][0];
    $filePathSide1 = $fileSide['tmp_name'][0];
    $fileSide2 = $fileSide['name'][1];
    $filePathSide2 = $fileSide['tmp_name'][1];
    $fileSide3 = $fileSide['name'][2];
    $filePathSide3 = $fileSide['tmp_name'][2];
  }

  $productName = $_POST["name"];
  $color = $_POST["color"];
  $type = $_POST["type"];
  $price = $_POST["price"];
  $brand = $_POST["brand"];
  $relatedInfo = $_POST["related_info"];
  $url = "";
  $uploadPathMain = "";
  $uploadPathSide1 = "";
  $uploadPathSide2 = "";
  $uploadPathSide3 = "";
  $size = "35,36,37,38,39,40,41,42,43,44,45,46";
  $image_url = "";
  switch ($brand) {
    case "NIKE":
      $brand = "Nike";
      $url = "Nike/uploads";
      break;
    case "ADIDAS":
      $brand = "Adidas";
      $url = "Adidas/uploads";
      break;
    case "BITIS":
      $brand = "Biti's";
      $brand = $conn->real_escape_string($brand);
      $url = "Biti_s/uploads";
      break;
    case "VANS":
      $brand = "Vans";
      $url = "Vans/uploads";
      break;
    case "CONVERSE":
      $brand = "Converse";
      $url = "Converse/uploads";
      break;
    case "NEW BALANCE":
      $brand = "New Balance";
      $url = "New Balance/uploads";
      break;
  }
  $uploadPathMain = $url . "/" . $fileMain['name'];
  $uploadPathSide1 = $url . "/" . $fileSide1;
  $uploadPathSide2 = $url . "/" . $fileSide2;
  $uploadPathSide3 = $url . "/" . $fileSide3;
  $image_url = $uploadPathMain . " | " . $uploadPathSide1 . " | " . $uploadPathSide2 . " | " . $uploadPathSide3;
  if (!validatePrice($price)) {
    echo "<script> alert('Giá tiền không được chứa chữ'); window.location.href='add-item.php';</script>";
    exit();
  }
  if (!validateColor($color)) {
    echo "<script>alert('Màu sắc không được chứa chữ'); window.location.href='add-item.php';</script>";
    exit();
  }

  move_uploaded_file($fileMain['tmp_name'], '../../images/' . $uploadPathMain);
  move_uploaded_file($filePathSide1, '../../images/' . $uploadPathSide1);
  move_uploaded_file($filePathSide2, '../../images/' . $uploadPathSide2);
  move_uploaded_file($filePathSide3, '../../images/' . $uploadPathSide3);

  $productID = $productName . " " . $color;
  $query = mysqli_query($conn, "SELECT HANG_ID FROM hanggiay WHERE TENHANG = '$brand'");
  $query = mysqli_fetch_row($query);
  $getID = $query[0];

  $query = "SELECT * FROM chitiet_giay";
  $count_query = mysqli_num_rows(mysqli_query($conn, $query));
  $count_query = $count_query + 1;

  $conn->query("SET foreign_key_checks = 0");
  $conn->query("INSERT INTO giay VALUES('$productID', '$getID', '$productName', '$image_url', '$price', '$relatedInfo')");
  $conn->query("INSERT INTO chitiet_giay VALUES('$count_query', '$productID', '$color', '$size', '$type')");

  echo "<script>alert('Thêm thành công'); window.location.href='add-item.php';</script>";
}
