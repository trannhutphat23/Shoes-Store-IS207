<?php
    require "../../connect.php";

    if (isset($_POST['searchVal'])) {
        $value = $_POST['searchVal'];
        echo $value;
    }
?>