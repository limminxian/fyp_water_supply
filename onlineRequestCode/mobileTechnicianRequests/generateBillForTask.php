<?php include_once 'conn.php';
    $status = $_POST['status'];
    $ticketId = $_POST['ticketId'];
    $serviceType = $_POST['serviceType'];
    $technicianId = $_POST['technicianId'];

    $conn = getDB();
    
    if($conn) {
        $sql = "UPDATE ticket SET `STATUS` = '".$status."' WHERE ID = '".$ticketId."'";
        $res = mysqli_query($conn, $sql);
       if($res) {
            echo "Successfully updated ticket";
        }
    } else echo "Connection failed";

    
    if($conn) {
        $workloadSql = "UPDATE staff SET `WORKLOAD` = WORKLOAD - 1 WHERE ID = '".$technicianId."'";
        $workloadRes = mysqli_query($conn, $workloadSql);
        if($workloadRes) {
            echo "Successfully updated workload";
        }
    } else echo "Connection failed";


    $sql1 = "select t.TYPE, t.HOMEOWNER, t.SERVICEDATE, s.RATE 
    from ticket t inner join servicerate s 
    on t.TYPE = s.SERVICE 
    where t.ID = $ticketId and 
    s.EFFECTDATE = (SELECT MAX(s.EFFECTDATE) from servicerate s where s.SERVICE = $serviceType);";

	$SQL = "SELECT COMPANY FROM STAFF WHERE ID = '".$technicianId."'";
	$Result = mysqli_query($conn, $SQL);
	$companyID = mysqli_fetch_row($Result)[0];
	
    if($conn) {
        $res1 = mysqli_query($conn, $sql1);
        if($res1) {
            $count = 0;
            while($row = mysqli_fetch_assoc($res1)) {
                if($count == 0) {
                    $type = $row['TYPE'];  
                    $homeowner = $row['HOMEOWNER'];
                    $serviceDate = $row['SERVICEDATE'];
                    $serviceRate = $row['RATE'];
                    $count++;
                    $sql2 = "insert into bill (BILLINGDATE, HOMEOWNER, SERVICE, AMOUNT, COMPANY) values ('".$serviceDate."', '".$homeowner."', '".$type."', '".$serviceRate."', '".$companyID."')";
                    $res2 = mysqli_query($conn, $sql2);
                    if($res2) {
                        echo "Successfully inserted bill";
                    } else echo "Having trouble inserting the data into bill table";
                } 
            } 
        } else echo "Having trouble fetching the data for generating bill";
    } else echo "Connection failed";
?>