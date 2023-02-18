<?php include_once 'conn.php';
    $id = $_POST['homeownerId'];
    $waterUsage = $_POST['waterUsage'];

    $conn = getDB();
    //$conn = mysqli_connect("us-cdbr-east-06.cleardb.net", "bbd12ae4b2fcc3", "df9ea7aa", "heroku_80d6ea926f679b3");
    //$conn = mysqli_connect("localhost", "root", "", "fyp");
    

    //update waterusage
    if($conn) {
        $sql1 = "SELECT MAX(RECORDDATE) as RECORDDATE from waterusage where HOMEOWNER = $id";
        $res1 = mysqli_query($conn, $sql1);
        if($res1) {
            while($dateRow = mysqli_fetch_assoc($res1)) {
                $maxRecordDate = $dateRow['RECORDDATE'];
                $sql = "UPDATE waterusage SET `WATERUSAGE(L)` = '".$waterUsage."' WHERE HOMEOWNER = '".$id."' and RECORDDATE = '".$maxRecordDate."'";
                $res = mysqli_query($conn, $sql);
                if($res) {
                    echo "Water usage editted successfully";
                } else echo "Water usage not editted successfully";
            }
        } else echo "Not able to fetch maximum date";
    } else echo "Connection failed";
    

    $sql1 = "select r.RATE, s.ID
    from servicetype s inner join servicerate r
    on s.ID = r.SERVICE
    where s.NAME = 'water supply'
    and r.EFFECTDATE = (SELECT MAX(r.EFFECTDATE) from servicerate r inner join servicetype s on s.ID = r.SERVICE where s.NAME = 'water supply');";

    $sql2 = "select HOMEOWNER, `WATERUSAGE(L)`, RECORDDATE
    from waterusage
    where HOMEOWNER = '".$id."' and RECORDDATE = (SELECT MAX(RECORDDATE) from waterusage where HOMEOWNER = $id)";

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
                        $sql3 = "select BILLINGDATE from bill where HOMEOWNER = '".$id."' 
                        and BILLINGDATE = (SELECT MAX(BILLINGDATE) from bill where HOMEOWNER = $id)";

                        $res3 = mysqli_query($conn, $sql3);

                        if($res3) {
                            while($row3 = mysqli_fetch_assoc($res3)) {
                                $billingDate = $row3['BILLINGDATE'];
                                
                                $sql4 = "update bill set AMOUNT = '".$amount."' WHERE HOMEOWNER = '".$id."' 
                                and BILLINGDATE = '".$billingDate."'";

                                $res4 = mysqli_query($conn, $sql4);

                                if($res4) {
                                    echo "Successfully updatted bill";
                                } else echo "Having trouble inserting the data into bill table";
                            } 
                        } else echo "Having trouble getting date from bill table";
                    }
                } else echo "Having trouble getting date from waterusage table";
            }
        } else echo "Having trouble fetching the data rom servicerate table";
    } else echo "Connection failed";
?>