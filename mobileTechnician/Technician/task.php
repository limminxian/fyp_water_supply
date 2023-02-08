<?php
    $conn = mysqli_connect("us-cdbr-east-06.cleardb.net", "bbd12ae4b2fcc3", "df9ea7aa", "heroku_80d6ea926f679b3");
    //$conn = mysqli_connect("localhost", "root", "", "fyp");
    if($conn){
         // table - field
        // homeowner - name (from user table)
        // ticket - type
        // ticket - description
        // ticket - status
        // where clause = area (from homeowner table)
        // task - id
        // 

        $selectedarea = $_GET['area'];
        $technicianId = $_GET['technicianID'];

        // $sql1 ="select t.HOMEOWNER, t.STATUS, t.TYPE, t.DESCRIPTION, t.SERVICEDATE, i.NAME
        // from ticket t, tickettype i, task u, 
        // where t.type = i.id and u.ticket = t.type";

        $sql = "select t.ID, t.STATUS, t.DESCRIPTION, t.SERVICEDATE, y.NAME as SERVICETYPE, u.NAME, h.STREET, h.BLOCKNO, h.UNITNO, h.POSTALCODE, h.AREA
        from ticket t 
        inner join task a on t.ID = a.TICKET 
        inner join tickettype y on t.TYPE = y.ID 
        inner join users u on t.HOMEOWNER = u.ID 
        inner join homeowner h on t.HOMEOWNER = h.ID 
        where a.TECHNICIAN = '$technicianId' and h.area = '$selectedarea'";

        // $sql = "select h.STREET, h.BLOCKNO, h.UNITNO, h.POSTALCODE, h.AREA, u.NAME, t.STATUS, t.DESCRIPTION, k.NAME as SERVICETYPE, t.ID
        //     from users u 
        //     inner join homeowner h on u.ID = h.ID
        //     inner join ticket t on h.ID = t.HOMEOWNER
        //     inner join tickettype k on t.TYPE = k.ID
        //     where h.area = '$selectedarea'";

        $res = mysqli_query($conn, $sql);
        $tasks = array();
        if($res) {
            while($row = mysqli_fetch_assoc($res)) {
                $tasks[] = array("status" => "success", "message" => "Data fetched", "STREET" => $row['STREET'], "BLOCKNO" => $row['BLOCKNO'], "UNITNO" => $row['UNITNO'], "POSTALCODE" => $row['POSTALCODE'], 
                "AREA" => $row['AREA'], "NAME" => $row['NAME'], "STATUS" => $row ['STATUS'], "DESCRIPTION" => $row['DESCRIPTION'], "SERVICETYPE" => $row['SERVICETYPE'], "ID" => $row['ID'], "SERVICEDATE" => $row['SERVICEDATE']);
            }
        } else $tasks = array("status" => "failed", "message" => "Having trouble fetching the data");
    } else $tasks = array("status" => "failed", "message" => "Database connection failed");
    echo json_encode(array("tasks" => $tasks), JSON_PRETTY_PRINT);
?>