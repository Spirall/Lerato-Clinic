<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['email']) || $_SESSION['right'] != 'doctor') {
    header("Location: signout.php");
}

include './Classes/connection.php';
date_default_timezone_set('Africa/Johannesburg');

//set the doctor id number into the consltation and
$consultationno = $_SESSION['consultationo'];
$doctoremail = $_SESSION['email'];
$patientid = $_SESSION['patientid'];

$Selectquery = "select doctorid from doctor where email = '$doctoremail'";
$queryresults = mysql_query($Selectquery);
$row = mysql_fetch_row($queryresults);
$id = $row[0];
$time = date('H:i');
$Selectquery = "update consultation set doctorid = '$id', endtime = '$time' where consultationno = $consultationno";
$queryresults = mysql_query($Selectquery);


$Selectquery = "select max(paymentno) from payment where patientid = '$patientid' ";
$queryresults = mysql_query($Selectquery);
$paymentno = mysql_fetch_row($queryresults);

$Selectquery = "select paymenttype from payment where paymentno = '$paymentno[0]' ";
$queryresults = mysql_query($Selectquery);
$paymenttype = mysql_fetch_row($queryresults);


if($paymenttype[0] != 'Medical Aid'){
$Selectquery = "select dob from patient where patientid = '$patientid' ";
$queryresults = mysql_query($Selectquery);
$row = mysql_fetch_row($queryresults);
$dob = $row[0];

$Selectquery = "select outstandingbalance from account where patientid = '$patientid' ";
$queryresults = mysql_query($Selectquery);
$row = mysql_fetch_row($queryresults);
$outstandingbalance = $row[0];

$age = date('Y-m-d') - $dob;

if ($age > 14) {
    $Selectquery = "select price from consultationprice where `type` = 'Adult' ";
    $queryresults = mysql_query($Selectquery);
    $row = mysql_fetch_row($queryresults);
    
    $outstandingbalance = $outstandingbalance + $row[0];    
} else {
    $Selectquery = "select price from consultationprice where `type` = 'Child' ";
    $queryresults = mysql_query($Selectquery);
    $row = mysql_fetch_row($queryresults);
    
    $outstandingbalance = $outstandingbalance + $row[0];
}

$Selectquery = "update account set outstandingbalance = $outstandingbalance where patientid = '$patientid' ";
$queryresults = mysql_query($Selectquery);

}







unset($_SESSION['patientid']);
unset($_SESSION['Weight']);
unset($_SESSION['bloodpressure']);
unset($_SESSION['consultationo']);
unset($_SESSION['comment']);

$_SESSION['consultation'] = True;

header("Location: Consultation.php");
exit();
?>

<!DOCTYPE html>
<html>

</html>
