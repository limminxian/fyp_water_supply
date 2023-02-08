<?php
if (!empty($_POST['homeownerId'] && !empty($_POST['waterUsage']))) {
    $conn = mysqli_connect("us-cdbr-east-06.cleardb.net", "bc292174f8cae7", "68916e25", "heroku_a43ceec7a5c075b");
    //$conn = mysqli_connect("us-cdbr-east-06.cleardb.net", "bbd12ae4b2fcc3", "df9ea7aa", "heroku_80d6ea926f679b3");
    //$conn = mysqli_connect("localhost", "root", "", "fyp");
    $id = $_POST['homeownerId'];
    $waterUsage = $_POST['waterUsage'];
    if($conn) {
        $sql = "UPDATE waterusage SET `WATERUSAGE` = '".$waterUsage."' WHERE HOMEOWNER = '".$id."'";
        $res = mysqli_query($conn, $sql);
        if($res) {
            echo "Water usage editted successfully";
        }
    } else echo "Connection failed";
} else echo "HomeownerId and water usage is null";
?>