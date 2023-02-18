<?php include_once 'conn.php';
    $id = $_POST['homeownerId'];
    $waterUsage = $_POST['waterUsage'];
    $recordDate = $_POST['sqlDate'];

    $conn = getDB();
    //$conn = mysqli_connect("us-cdbr-east-06.cleardb.net", "bbd12ae4b2fcc3", "df9ea7aa", "heroku_80d6ea926f679b3");
    //$conn = mysqli_connect("localhost", "root", "", "fyp");
    
	$companyID = null;
	
	$SQL = "SELECT SUBSCRIBE FROM HOMEOWNER WHERE ID = '".$id."'";
	$Result = mysqli_query($conn, $SQL);
	if (mysqli_num_rows($Result) != 0) {
		$companyID = mysqli_fetch_row($Result)[0];
	} else {
		$companyID = null;
		echo "homeowner not subscribed yet";
	}
	
	
    //insert waterusage
    iF($conn) {
        $sql = "insert into waterusage (RECORDDATE, HOMEOWNER, `WATERUSAGE(L)`) values ('".$recordDate."', '".$id."', '".$waterUsage."')";
        $res = mysqli_query($conn, $sql);
        if($res) {
            echo "Water usage added successfully";
        } else echo "Water usage not added successfully";
    } else echo "Connection failed";
    

    $sql1 = "select r.RATE, s.ID
    from servicetype s inner join servicerate r
    on s.ID = r.SERVICE
    where s.NAME = 'water supply'
    and r.EFFECTDATE = (SELECT MAX(r.EFFECTDATE) from servicerate r inner join servicetype s on s.ID = r.SERVICE where s.NAME = 'water supply');";

    $sql2 = "select HOMEOWNER, `WATERUSAGE(L)`, RECORDDATE
    from waterusage
    where HOMEOWNER = $id and RECORDDATE = (SELECT MAX(RECORDDATE) from waterusage where HOMEOWNER = $id)";

    if($conn) {
        $res1 = mysqli_query($conn, $sql1);
        if($res1) {
            while($row1 = mysqli_fetch_assoc($res1)) {
                
                $rate = $row1['RATE'];
                $type = $row1['ID'];

                $res2 = mysqli_query($conn, $sql2);

                if($res2) {
                    while($row2 = mysqli_fetch_assoc($res2)) {
                        $homeOwner = $row2['HOMEOWNER'];
                        $waterUsage = $row2['WATERUSAGE(L)'];
                        $recordDate = $row2['RECORDDATE'];

                        $amount = $rate * $waterUsage;

                        $sql3 = "insert into bill (BILLINGDATE, HOMEOWNER, SERVICE, AMOUNT, COMPANY)  VALUES 
                        (DATE_ADD('".$recordDate."', INTERVAL 1 DAY), '".$homeOwner."', '".$type."', '".$amount."', '".$companyID."')";
                        $res3 = mysqli_query($conn, $sql3);
                        
                        if($res3) {
                            echo "Successfully inserted bill";
                        } else echo "Having trouble inserting the data into bill table";
                    }
                } else echo "Having trouble getting date from waterusage table";
            }
        } else echo "Having trouble fetching the data rom servicerate table";
    } else echo "Connection failed";
?>