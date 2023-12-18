<?php
    require "../connect.php";
    session_start();

    if (isset($_POST['getSDT'])){
        $phone = $_POST['getSDT'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $currentDate = date('Y-m-d', time());
        $change = 0;
        $query = mysqli_query($conn, "SELECT * FROM donhang WHERE SDT = '$phone'");
        while ($rowData=mysqli_fetch_assoc($query)) {
            $getDate = $rowData['NGAYGIAO'];
            $getID = $rowData['MADON'];
            if ($getDate <= $getDate){
                $conn->query("UPDATE donhang SET TINHTRANG = 'DELIVERED' WHERE SDT = '$phone' AND MADON = '$getID'");
                $change = 1;
            }
        }
        echo $change;
    }
?>
