<?php
    include "connection.php";

    $target = $_POST['target'];
    $attribute = $_POST['attribute'];
    $value = $_POST['value'];

    $sql = "SELECT * FROM $target WHERE `$attribute` = '$value'";

    if (isset($_POST['addition'])) $sql .= $_POST['addition'];

    $sqlRun = mysqli_query($connection,$sql);

    echo mysqli_num_rows($sqlRun);
?>