<?php
    $conn = mysqli_connect("us-cdbr-east-06.cleardb.net", "bbd12ae4b2fcc3", "df9ea7aa", "heroku_80d6ea926f679b3");
    //$conn = mysqli_connect("localhost", "root", "", "fyp");
    if($conn) {
        $selectedarea = $_GET['area'];
        $sql = "select ID, STREET, BLOCKNO, UNITNO, POSTALCODE, AREA, HOUSETYPE
            from homeowner
            where area = '$selectedarea'
            group by POSTALCODE";
        $res = mysqli_query($conn, $sql);
        $addresses = array(); 
        if($res) {
            while($row = mysqli_fetch_assoc($res)) {
                $addresses[] = array("status" => "success", "message" => "Data fetched", "ID" => $row['ID'], "STREET" => $row['STREET'], 
                "BLOCKNO" => $row['BLOCKNO'], "UNITNO" => $row['UNITNO'], "POSTALCODE" => $row['POSTALCODE'], "AREA" => $row['AREA'], "HOUSETYPE" => $row['HOUSETYPE']);
            } 
        } else $addresses = array("status" => "failed", "message" => "Having trouble fetching the data");
    } else $addresses = array("status" => "failed", "message" => "Database connection failed");
    echo json_encode(array("addresses" => $addresses), JSON_PRETTY_PRINT);
?>