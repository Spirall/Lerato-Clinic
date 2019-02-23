<?php
if (!isset($_SESSION)) {
    session_start();
    
    if(!isset($_SESSION['email']) || $_SESSION['right'] != 'clerk'){
    header("Location: signout.php");
}
}
?>

<!DOCTYPE html>
<!--
This is a page to add or update Patient, we got two options here, add or update
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>
        
        <?php
        include './Classes/CssLink.html';
        //call connection to mysql
        include './Classes/connection.php';
        ?>
        
     </head>

    <body onload="myFunction()">
    <div class ="jumbotron" style="margin-top: -10px;">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="panel panel-default col-md-10" style="border: solid; margin-top: -0px;">
                <div class="panel-body" style="">
                    <div class="page-header">
                        <h4 align ="center" style="padding-top: 0px">Consultation Report</h4>
                    </div>   
                    <p></p>
                    <h4 align="center" style="color: ">
                    <?php
                                     //display title of the consultation report type
                                     if(!empty($_GET['From'])){
                                    $from = date( 'd-M-Y',strtotime($_GET['From']));
                                    $to = date( 'd-M-Y',strtotime($_GET['To']));
                                    
                                    if($from <= $to){
                                    echo "$from - $to";
                                    }else{
                                     echo "<b style='color: #F80000'>Incorrect date, from date $from can not be greater than to date $to</b>";   
                                    }
                                    
                                    }else if(!empty($_GET['patientid'])){
                                    $patientid = $_GET['patientid']; 
                                    
                                    $Selectquery = "select surname,firstname from patient where patientid = '$patientid'";
                                    $queryresults = mysql_query($Selectquery);
                                    $patientnames = mysql_fetch_row($queryresults);
                                     if(!empty($patientnames[0])){       
                                    echo "Consultation Report For $patientnames[0] $patientnames[1]"; 
                                     }else{
                                    echo "<b style='color: #F80000'>Patient Not Found</b>";    
                                    }
                                    }else{
                                     echo " Full Consultation Report"; 
                                    }
                                     ?>
                    </h4>
                    <p></p>
                                <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center">
                                   <tr align="center">
                                     <td>Patient ID</td>
                                     <td>Patient Title</td>
                                     <td>Patient Full Name</td>
                                     <td>Doctor Full Name</td>
                                     <td>Consultation Date</td>
                                    </tr>
                                    
                                    <?php
                                    $NoConsultation = 0;
                                    if(!empty($_GET['From'])){
                                    //if search for specific dates pressed
                                    $from = $_GET['From'];
                                    $to = $_GET['To'];
                                    $Selectquery = "select p.patientid ,p.title, p.surname,p.firstname,d.surname,d.firstname,c.consultationdate from patient p,doctor d,consultation c where (p.patientid = c.patientid) and (c.doctorid = d.doctorid) and (c.consultationdate between '$from' and '$to') order by c.consultationdate desc";
                                    $queryresults = mysql_query($Selectquery);   
                                    }else if(!empty($_GET['patientid'])){
                                     //if search for specific patient pressed
                                    $patientid = $_GET['patientid']; 
                                    $Selectquery = "select p.patientid ,p.title, p.surname,p.firstname,d.surname,d.firstname,c.consultationdate from patient p,doctor d,consultation c where (p.patientid = c.patientid) and (c.doctorid = d.doctorid) and (p.patientid = '$patientid') order by c.consultationdate desc";
                                    $queryresults = mysql_query($Selectquery);    
                                    }else{
                                    $Selectquery = "select p.patientid ,p.title, p.surname,p.firstname,d.surname,d.firstname,c.consultationdate from patient p,doctor d,consultation c where p.patientid = c.patientid and c.doctorid = d.doctorid order by c.consultationdate desc";
                                    $queryresults = mysql_query($Selectquery);   
                                    }
                                    
                                    while($rows = mysql_fetch_row($queryresults)){
                                        $patientfullname = "$rows[2] $rows[3]";
                                        $doctorfullname = "$rows[4] $rows[5]";
                                        
                                    ?>
                                    <tr align="center" style="font-size: 12px">
                                    <td>&nbsp;<?php echo $rows[0]; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[1];?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $patientfullname; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $doctorfullname; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[6]; ?>&nbsp;</td>
                                    </tr>   
                                    <?php
                                    $NoConsultation+=1;
                                    }
                                    ?>
                                    
                                </table>
                        </div>
                            <div class="row">
                                <div class="col-md-9">
                                </div>
                                <div class="col-md-3">
                            <label>Number of Consultation: <?php echo $NoConsultation ?></label>
                                </div>
                            </div>
                       </div>
                </div>   
                </div>
       <script>
            function myFunction() {
                window.print();
            }
        </script>
    </body>
        
</html>
