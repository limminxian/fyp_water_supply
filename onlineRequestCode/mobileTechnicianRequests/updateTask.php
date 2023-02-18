<?php include_once 'conn.php';
if (!empty($_POST['status'] && !empty($_POST['ticketId']))) {
    $conn = getDB();
    //$conn = mysqli_connect("us-cdbr-east-06.cleardb.net", "bbd12ae4b2fcc3", "df9ea7aa", "heroku_80d6ea926f679b3");
    //$conn = mysqli_connect("localhost", "root", "", "fyp");
    $status = $_POST['status'];
    $id = $_POST['ticketId'];
    if($conn) {
        $sql = "UPDATE ticket SET `STATUS` = '".$status."' WHERE ID = '".$id."'";
        $res = mysqli_query($conn, $sql);
        if($res) {
            echo "Status edited successfully";
        }
    } else echo "Connection failed";
} else echo "Status and ticketId is null";
?>