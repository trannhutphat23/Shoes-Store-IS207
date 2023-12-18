<?php
    require "../connect.php";

    if (isset($_POST['trashID'])){
        $trashID = $_POST['trashID'];

        $query = mysqli_query($conn, "SELECT * FROM chitiet_donhang WHERE MADON = '$trashID'");
        $row_query = mysqli_num_rows($query);
        if ($row_query == 1){
            $conn->query("DELETE FROM chitiet_donhang WHERE MADON = '$trashID'");
            $conn->query("DELETE FROM donhang WHERE MADON = '$trashID'");
        }else{
            $conn->query("DELETE FROM chitiet_donhang WHERE MADON = '$trashID'");
        }
    }
?>