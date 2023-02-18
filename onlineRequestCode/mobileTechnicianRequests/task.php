<?php include_once 'conn.php';
    $conn = getDB();
    //$conn = mysqli_connect("us-cdbr-east-06.cleardb.net", "bbd12ae4b2fcc3", "df9ea7aa", "heroku_80d6ea926f679b3");
    //$conn = mysqli_connect("localhost", "root", "", "fyp");
    if($conn){
        $selectedarea = $_GET['area'];
        $technicianId = $_GET['technicianID'];

        $sql = "select t.ID, t.STATUS, t.DESCRIPTION, t.SERVICEDATE, y.NAME as SERVICETYPE, u.NAME, h.ID as HOMEOWNERID, h.STREET, h.BLOCKNO, h.UNITNO, h.POSTALCODE, h.AREA, a.ID as TASKID
        from ticket t 
        inner join task a on t.ID = a.TICKET 
        inner join servicetype y on t.TYPE = y.ID 
        inner join users u on t.HOMEOWNER = u.ID 
        inner join homeowner h on t.HOMEOWNER = h.ID 
        where a.TECHNICIAN = '$technicianId' and h.area = '$selectedarea'
        order by t.STATUS desc";

        $res = mysqli_query($conn, $sql);
        $tasks = array();
        if($res) {
            while($row = mysqli_fetch_assoc($res)) {
                $tasks[] = array("status" => "success", "message" => "Data fetched", "STREET" => $row['STREET'], "BLOCKNO" => $row['BLOCKNO'], "UNITNO" => $row['UNITNO'], "POSTALCODE" => $row['POSTALCODE'], 
                "AREA" => $row['AREA'], "NAME" => $row['NAME'], "STATUS" => $row ['STATUS'], "DESCRIPTION" => $row['DESCRIPTION'], "SERVICETYPE" => $row['SERVICETYPE'], "ID" => $row['ID'], "SERVICEDATE" => $row['SERVICEDATE'], "TASKID" => $row['TASKID'], "HOMEOWNERID" => $row['HOMEOWNERID']);
            }
        } else $tasks = array("status" => "failed", "message" => "Having trouble fetching the data");
    } else $tasks = array("status" => "failed", "message" => "Database connection failed");
    echo json_encode(array("tasks" => $tasks), JSON_PRETTY_PRINT);
?>