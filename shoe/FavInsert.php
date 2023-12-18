<?php
    require '../connect.php';

    if (isset($_POST['phone']) && isset($_POST['shoe'])){
        $phone = $_POST['phone'];
        $shoe = $_POST['shoe'];

        $sl_fav="SELECT * FROM yeuthich WHERE SDT = '$phone' AND MAGIAY = '$shoe'";
        $row_fav=mysqli_num_rows(mysqli_query($conn,$sl_fav));
        if ($row_fav == 0){
            $conn->query("SET foreign_key_checks = 0");
            $conn->query("INSERT INTO yeuthich VALUES('$phone', '$shoe')");
        }else{
            $conn->query("SET foreign_key_checks = 0");
            $conn->query("DELETE FROM yeuthich WHERE SDT = '$phone' AND MAGIAY = '$shoe'");
        }
    }
?>