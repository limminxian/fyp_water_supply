<?php
function getdb(){
$servername = "localhost";
$username = "root";
$password = "";
$db = "fyp";
try {
   
    $conn = mysqli_connect($servername, $username, $password, $db);
     //echo "Connected successfully"; 
    }
catch(exception $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
}

function createTables(){

// sql to create table
$createTables = "

CREATE TABLE IF NOT EXISTS ROLE (
ID INT(6) UNSIGNED AUTO_INCREMENT,
NAME VARCHAR(30),
DESCRIPTION VARCHAR(50),
PRIMARY KEY (ID)
);

CREATE TABLE IF NOT EXISTS USER (
ID INT(6) UNSIGNED AUTO_INCREMENT,
NAME VARCHAR(30),
EMAIL VARCHAR(50) unique,
PASSWORD VARCHAR(16),
TYPE INT(6),
STATUS VARCHAR(10),
PRIMARY KEY (ID),
FOREIGN KEY (TYPE) REFERENCES ROLE(ID)
);

CREATE TABLE IF NOT EXISTS COMPANY (
ID INT(6),
NUMBER VARCHAR(30),
STREET VARCHAR(30),
POSTALCODE INT(6),
DESCRIPTION VARCHAR(50),
PRIMARY KEY (ID),
FOREIGN KEY (ID) REFERENCES USER(ID)
);

CREATE TABLE IF NOT EXISTS STAFF (
ID INT(6),
COMPANY INT(6),
PRIMARY KEY (ID),
FOREIGN KEY (ID) REFERENCES USER(ID),
FOREIGN KEY (COMPANY) REFERENCES COMPANY(ID)
);

CREATE TABLE IF NOT EXISTS HOMEOWNER (
ID INT(6),
NUMBER VARCHAR(30),
STREET VARCHAR(30),
BLOCKNO VARCHAR(5),
UNITNO VARCHAR(6),
POSTALCODE INT(6),
HOUSETYPE VARCHAR(50),
NOOFPEOPLE INT(2),
PRIMARY KEY (ID),
FOREIGN KEY (ID) REFERENCES USER(ID)
);

CREATE TABLE IF NOT EXISTS TICKETTYPE (
ID INT(6),
NAME VARCHAR(30),
DESCRIPTION VARCHAR(50),
PRIMARY KEY (ID)
);


CREATE TABLE IF NOT EXISTS TICKET (
ID INT(6),
HOMEOWNER INT(6),
CUSTOMERSERVICE INT(6),
STATUS VARCHAR(6),
TYPE INT(6),
DESCRIPTION VARCHAR(50),
PRIMARY KEY (ID),
FOREIGN KEY (HOMEOWNER) REFERENCES HOMEOWNER(ID),
FOREIGN KEY (CUSTOMERSERVICE) REFERENCES STAFF(ID),
FOREIGN KEY (TYPE) REFERENCES TICKETTYPE(ID)
);

CREATE TABLE IF NOT EXISTS TASK (
ID INT(6),
DESCRIPTION VARCHAR(50),
SERVICEDATE DATE,
DURATION INT(2),
TECHNICIAN INT(6),
TICKET INT(6),
PRIMARY KEY (ID),
FOREIGN KEY (TECHNICIAN) REFERENCES TECHNICIAN(ID),
FOREIGN KEY (TICKET) REFERENCES TICKET(ID)
);

CREATE TABLE IF NOT EXISTS CHEMICAL (
ID INT(6),
NAME VARCHAR(30),
DESCRIPTION VARCHAR(30),
AMOUNT INT(6),
USAGETIME INT(5),
COMPANY INT(6),
PRIMARY KEY (ID),
FOREIGN KEY (COMPANY) REFERENCES COMPANY(ID)
);

CREATE TABLE IF NOT EXISTS EQUIPTYPE (
ID INT(6),
NAME VARCHAR(30),
DESCRIPTION VARCHAR(30),
AMOUNT INT(6),
REPLACEMENTPERIOD INT(5),
DEVICEGUARANTEE INT(5),
COMPANY INT(6),
PRIMARY KEY (ID),
FOREIGN KEY (COMPANY) REFERENCES COMPANY(ID)
);

CREATE TABLE IF NOT EXISTS EQUIPMENT (
ID INT(6),
TYPE INT(6),
QUANTITY INT(3),
INSTALLATIONDATE DATE,
HOMEOWNER INT(6),
TASK INT(6),
PRIMARY KEY (ID),
FOREIGN KEY (TYPE) REFERENCES EQUIPTYPE(ID),
FOREIGN KEY (HOMEOWNER) REFERENCES HOMEOWNER(ID),
FOREIGN KEY (TASK) REFERENCES TASK(ID)
);

CREATE TABLE IF NOT EXISTS SERVICES (
ID INT(6),
NAME VARCHAR(30),
RATE INT(3),
COMPANY INT(6),
PRIMARY KEY (ID),
FOREIGN KEY (COMPANY) REFERENCES COMPANY(ID)
);

CREATE TABLE IF NOT EXISTS WATERUSAGE (
RECORDDATE DATE,
HOMEOWNER INT(6),
WATERUSAGE INT(3),
PRIMARY KEY (RECORDDATE,HOMEOWNER),
FOREIGN KEY (HOMEOWNER) REFERENCES HOMEOWNER(ID)
);

CREATE TABLE IF NOT EXISTS PAYMENT (
ID INT(6),
METHOD VARCHAR(30),
HOMEOWNER INT(6),
CARDNO INT(16),
CVV INT(3),
BILLINGADDRESS VARCHAR(100),
PRIMARY KEY (ID),
FOREIGN KEY (HOMEOWNER) REFERENCES HOMEOWNER(ID)
);

CREATE TABLE IF NOT EXISTS BILL (
PAYMENTDATE DATE,
HOMEOWNER INT(6),
SERVICE INT(6),
AMOUNT INT(5),
PAYMENT INT(6),
PRIMARY KEY (PAYMENTDATE,HOMEOWNER),
FOREIGN KEY (HOMEOWNER) REFERENCES HOMEOWNER(ID),
FOREIGN KEY (SERVICE) REFERENCES SERVICE(ID),
FOREIGN KEY (PAYMENT) REFERENCES PAYMENT(ID)
);

CREATE TABLE IF NOT EXISTS RATING (
COMPANY INT(6),
NOOFSTAR INT(1),
PRIMARY KEY (COMPANY),
FOREIGN KEY (COMPANY) REFERENCES COMPANY(ID)
);

";
$con=getdb();
mysqli_multi_query($con, $createTables);
}

function createSuperadmin(){
	
$hashed = password_hash("123Admin.",PASSWORD_DEFAULT);
$createAdmin ="

INSERT INTO `USER` (`NAME`,`EMAIL`,`PASSWORD`,`TYPE`, `STATUS`)
    SELECT 'Admin1','admin@gmail.com','".$hashed."',1, 'ACTIVE'
    WHERE NOT EXISTS
        (SELECT id FROM `USER` WHERE EMAIL = 'admin@gmail.com');

";
$con=getdb();
mysqli_query($con, $createAdmin);
echo mysqli_error($con);
}
?>