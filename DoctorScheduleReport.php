<?php
if (!isset($_SESSION)) {
    session_start();

    if (!isset($_SESSION['email']) || $_SESSION['right'] != 'admin') {
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<!--
This is the main Administrator page
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>

        <?php
        include './Classes/CssLink.html';
        ?>

    </head>
    <?php
    //call navigation 
    include './Pages/AdminHeader.html';

    //call connection to mysql
    include './Classes/connection.php';
    ?>


    <body>
        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="row">
                <div class="col-lg-2">

                </div>

                <div class="panel panel-default col-md-8" style="border: solid; margin-top: -20px">
                    <div class="panel-body"> 
                        <div class="panel-body">
                            <div class="page-header">
                                <h4 align ="center" style="padding-top: 0px">Doctor Schedule</h4>
                            </div>

                            <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center">
                            <tr align="center">
                                <td><b>Day</b></td>
                                <td><b>Doctor ID</b></td>
                                <td><b>Full Name</b></td>
                                <td><b>Start Time</b></td>
                                <td><b>End Time</b></td>
                            </tr>
                            
                            
                            <tr align='center' style="background-color: #269abc">
                                <td><b>Monday</b></td>
                            <?php
                            $Selectquery = "select s.starttime, s.endtime, s.doctorid, d.surname, d.firstname from schedule s, doctor d where s.doctorid= d.doctorid and s.days='Monday'";
                            $queryresults = mysql_query($Selectquery);
                            $starttime = array();
                            $endtime = array();
                            $doctid = array();
                            $fullname = array();
                            while($rows = mysql_fetch_row($queryresults)){
                             $starttime[] = $rows[0];
                             $endtime[] = $rows[1];
                             $doctid[] = $rows[2];
                             $fullname[] = "$rows[3] $rows[4]";   
                            }
                            ?>
                                <td>
                            <?php
                            for($i = 0;$i<count($doctid);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $doctid[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($fullname);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $fullname[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($starttime);$i++){
                            if($starttime[$i] < 12){
                                $starttime[$i]= $starttime[$i].":00 AM";
                            }else{
                               $starttime[$i]= $starttime[$i].":00 PM"; 
                            } 
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $starttime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($endtime);$i++){
                                if($endtime[$i] < 12){
                                $endtime[$i]= $endtime[$i].":00 AM";
                            }else{
                               $endtime[$i]= $endtime[$i].":00 PM"; 
                            }
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $endtime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                
                           </tr>
                               
                           
                            <!--For Tuesday-->
                              <tr align='center' style="background-color: #419641">
                                <td><b>Tuesday</b></td>
                            <?php
                            $Selectquery = "select s.starttime, s.endtime, s.doctorid, d.surname, d.firstname from schedule s, doctor d where s.doctorid= d.doctorid and s.days='Tuesday'";
                            $queryresults = mysql_query($Selectquery);
                            $starttime = array();
                            $endtime = array();
                            $doctid = array();
                            $fullname = array();
                            while($rows = mysql_fetch_row($queryresults)){
                             $starttime[] = $rows[0];
                             $endtime[] = $rows[1];
                             $doctid[] = $rows[2];
                             $fullname[] = "$rows[3] $rows[4]";   
                            }
                            ?>
                                <td>
                            <?php
                            for($i = 0;$i<count($doctid);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $doctid[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($fullname);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $fullname[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($starttime);$i++){
                            if($starttime[$i] < 12){
                                $starttime[$i]= $starttime[$i].":00 AM";
                            }else{
                               $starttime[$i]= $starttime[$i].":00 PM"; 
                            } 
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $starttime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($endtime);$i++){
                                if($endtime[$i] < 12){
                                $endtime[$i]= $endtime[$i].":00 AM";
                            }else{
                               $endtime[$i]= $endtime[$i].":00 PM"; 
                            }
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $endtime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                
                           </tr>
                           
                          
                           <!--For Wednesday-->
                           <tr align='center' style="background-color: #eee">
                                <td><b>Wednesday</b></td>
                            <?php
                            $Selectquery = "select s.starttime, s.endtime, s.doctorid, d.surname, d.firstname from schedule s, doctor d where s.doctorid= d.doctorid and s.days='Wednesday'";
                            $queryresults = mysql_query($Selectquery);
                            $starttime = array();
                            $endtime = array();
                            $doctid = array();
                            $fullname = array();
                            while($rows = mysql_fetch_row($queryresults)){
                             $starttime[] = $rows[0];
                             $endtime[] = $rows[1];
                             $doctid[] = $rows[2];
                             $fullname[] = "$rows[3] $rows[4]";   
                            }
                            ?>
                                <td>
                            <?php
                            for($i = 0;$i<count($doctid);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $doctid[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($fullname);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $fullname[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($starttime);$i++){
                            if($starttime[$i] < 12){
                                $starttime[$i]= $starttime[$i].":00 AM";
                            }else{
                               $starttime[$i]= $starttime[$i].":00 PM"; 
                            } 
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $starttime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($endtime);$i++){
                                if($endtime[$i] < 12){
                                $endtime[$i]= $endtime[$i].":00 AM";
                            }else{
                               $endtime[$i]= $endtime[$i].":00 PM"; 
                            }
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $endtime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                
                           </tr>
                           
                           
                           <!--For Thursday-->
                           <tr align='center' style="background-color: #9acfea">
                                <td><b>Thursday</b></td>
                            <?php
                            $Selectquery = "select s.starttime, s.endtime, s.doctorid, d.surname, d.firstname from schedule s, doctor d where s.doctorid= d.doctorid and s.days='Thursday'";
                            $queryresults = mysql_query($Selectquery);
                            $starttime = array();
                            $endtime = array();
                            $doctid = array();
                            $fullname = array();
                            while($rows = mysql_fetch_row($queryresults)){
                             $starttime[] = $rows[0];
                             $endtime[] = $rows[1];
                             $doctid[] = $rows[2];
                             $fullname[] = "$rows[3] $rows[4]";   
                            }
                            ?>
                                <td>
                            <?php
                            for($i = 0;$i<count($doctid);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $doctid[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($fullname);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $fullname[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($starttime);$i++){
                            if($starttime[$i] < 12){
                                $starttime[$i]= $starttime[$i].":00 AM";
                            }else{
                               $starttime[$i]= $starttime[$i].":00 PM"; 
                            } 
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $starttime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($endtime);$i++){
                                if($endtime[$i] < 12){
                                $endtime[$i]= $endtime[$i].":00 AM";
                            }else{
                               $endtime[$i]= $endtime[$i].":00 PM"; 
                            }
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $endtime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                
                           </tr>
                           
                           
                          <!-- For Friday-->
                           <tr align='center' style="background-color: #b2dba1">
                                <td><b>Friday</b></td>
                            <?php
                            $Selectquery = "select s.starttime, s.endtime, s.doctorid, d.surname, d.firstname from schedule s, doctor d where s.doctorid= d.doctorid and s.days='Friday'";
                            $queryresults = mysql_query($Selectquery);
                            $starttime = array();
                            $endtime = array();
                            $doctid = array();
                            $fullname = array();
                            while($rows = mysql_fetch_row($queryresults)){
                             $starttime[] = $rows[0];
                             $endtime[] = $rows[1];
                             $doctid[] = $rows[2];
                             $fullname[] = "$rows[3] $rows[4]";   
                            }
                            ?>
                                <td>
                            <?php
                            for($i = 0;$i<count($doctid);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $doctid[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($fullname);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $fullname[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($starttime);$i++){
                            if($starttime[$i] < 12){
                                $starttime[$i]= $starttime[$i].":00 AM";
                            }else{
                               $starttime[$i]= $starttime[$i].":00 PM"; 
                            } 
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $starttime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($endtime);$i++){
                                if($endtime[$i] < 12){
                                $endtime[$i]= $endtime[$i].":00 AM";
                            }else{
                               $endtime[$i]= $endtime[$i].":00 PM"; 
                            }
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $endtime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                
                           </tr>
                           
                           <!--For Saturday-->
                           <tr align='center' style="background-color: #d58512">
                                <td><b>Saturday</b></td>
                            <?php
                            $Selectquery = "select s.starttime, s.endtime, s.doctorid, d.surname, d.firstname from schedule s, doctor d where s.doctorid= d.doctorid and s.days='Saturday'";
                            $queryresults = mysql_query($Selectquery);
                            $starttime = array();
                            $endtime = array();
                            $doctid = array();
                            $fullname = array();
                            while($rows = mysql_fetch_row($queryresults)){
                             $starttime[] = $rows[0];
                             $endtime[] = $rows[1];
                             $doctid[] = $rows[2];
                             $fullname[] = "$rows[3] $rows[4]";   
                            }
                            ?>
                                <td>
                            <?php
                            for($i = 0;$i<count($doctid);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $doctid[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($fullname);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $fullname[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($starttime);$i++){
                            if($starttime[$i] < 12){
                                $starttime[$i]= $starttime[$i].":00 AM";
                            }else{
                               $starttime[$i]= $starttime[$i].":00 PM"; 
                            } 
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $starttime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($endtime);$i++){
                                if($endtime[$i] < 12){
                                $endtime[$i]= $endtime[$i].":00 AM";
                            }else{
                               $endtime[$i]= $endtime[$i].":00 PM"; 
                            }
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $endtime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                
                           </tr>
                           
                           <!--For Sunday-->
                           <tr align='center' style="background-color: #ff0">
                               <td><b>Sunday</b></td>
                            <?php
                            $Selectquery = "select s.starttime, s.endtime, s.doctorid, d.surname, d.firstname from schedule s, doctor d where s.doctorid= d.doctorid and s.days='Sunday'";
                            $queryresults = mysql_query($Selectquery);
                            $starttime = array();
                            $endtime = array();
                            $doctid = array();
                            $fullname = array();
                            while($rows = mysql_fetch_row($queryresults)){
                             $starttime[] = $rows[0];
                             $endtime[] = $rows[1];
                             $doctid[] = $rows[2];
                             $fullname[] = "$rows[3] $rows[4]";   
                            }
                            ?>
                                <td>
                            <?php
                            for($i = 0;$i<count($doctid);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $doctid[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($fullname);$i++){
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $fullname[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($starttime);$i++){
                            if($starttime[$i] < 12){
                                $starttime[$i]= $starttime[$i].":00 AM";
                            }else{
                               $starttime[$i]= $starttime[$i].":00 PM"; 
                            } 
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $starttime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                <td>
                            <?php
                            for($i = 0;$i<count($endtime);$i++){
                                if($endtime[$i] < 12){
                                $endtime[$i]= $endtime[$i].":00 AM";
                            }else{
                               $endtime[$i]= $endtime[$i].":00 PM"; 
                            }
                                
                            echo "<table border = '1' width='100%'><tr><td align='center'>".
                              $endtime[$i].  
                                 "</td></tr></table>";
                            }
                            ?>
                                </td>
                                
                           </tr>
                                
                           
                            </table>

                            
                        </div>
                    </div>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            
            <div class='row'>
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <a href="PrintDoctorSchedule.php" target="_blank">
                    <input type="button" class="btn btn-default form-control" value='Print Doctor Schedule'>
                     </a>
                    </div>
                
            </div>
            
        </div>
<?php
include 'Pages/Footer.php';
include 'Classes/JsScript.html';
?>
    </body>
</html>
