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
        //call navigation 
        include './Clerk/ClerkHeader.php';
        //call connection to mysql
        include './Classes/connection.php';
        ?>
        
        
        <script src="bootstrap/js/jquery-1.11.2.min.js"> </script>
        <script>
        $(document).ready(function(){
             $("#btnsortdate").click(function(){
              $("#date").fadeIn("fast");
            });
        });
        </script>
     </head>

    <body>
    <div class ="jumbotron" style="margin-top: -15px;">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="panel panel-default col-md-10" style="border: solid; margin-top: -20px;">
                <div class="panel-body" style="">
                    <div class="page-header">
                        <h4 align ="center" style="padding-top: 0px">List of Patient Report</h4>
                                </div>
                                
                     <div class="row"> 
                            <div class="col-md-6">
                                <div>
                                    <button type="submit" id ="btnsortdate" name="submitdates" class="btn btn-default form-control">Sort By Date</button>
                                </div>                                                                                                      
                            </div> 
                            <div class="col-md-6">
                                <div>
                                    <a href="PatientList.php"><button type="button" id="" name="" class="btn btn-default form-control">Reset</button></a>
                                </div>                                                                                                      
                            </div>
                        </div>
                                    <p></p>
                                    <h4 align="center" style="color: ">
                                     <?php
                                     //display title of the consultation report type
                                     if(isset($_POST['submitdates'])){
                                    $from = date( 'd-M-Y',strtotime($_POST['From']));
                                    $to = date( 'd-M-Y',strtotime($_POST['To']));
                                    
                                    if($from <= $to){
                                    echo "$from - $to";
                                    }else{
                                     echo "<b style='color: #F80000'>Incorrect date, from date $from can not be greater than to date $to</b>";   
                                    }
                                    
                                    }else{
                                     echo " Full Patient List Report"; 
                                    }
                                     ?>
                                     </h4>  
                                    <p></p>
                            <div style="height: 200px;overflow:scroll">
                                <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center">
                                   <tr align="center">
                                     <td><b>ID</b></td>
                                     <td><b>Title</b></td>
                                     <td><b>Full Name</b></td>
                                     <td><b>Date of Birth</b></td>
                                     <td><b>Cell Phone</b></td>
                                     <td><b>Email</b></td>
                                     <td><b>Address</b></td>
                                     <td><b>Date Registered</b></td>
                                    </tr>
                                    
                                    <?php
                                    $from = "";
                                    $to = "";
                                    $patientid = "";
                                    $Nopatient = 0;
                                    if(isset($_POST['submitdates'])){
                                    //if search for specific dates pressed
                                    $from = date( 'Y-m-d H:i:s',strtotime($_POST['From']));
                                    $to = date( 'Y-m-d H:i:s',strtotime($_POST['To']));
                                    
                                    $Selectquery = "select * from patient where registerdate between '$from' and '$to'";
                                    $queryresults = mysql_query($Selectquery);   
                                    
                                    }else{
                                    $Selectquery = "select * from patient";
                                    $queryresults = mysql_query($Selectquery);   
                                    }
                                    
                                    while($rows = mysql_fetch_row($queryresults)){
                                    ?>
                                    <tr align="center" style="font-size: 12px">
                                    <td>&nbsp;<?php echo $rows[0]; ?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[3];?>&nbsp;</td>
                                    <td>&nbsp;<?php echo "$rows[1] $rows[2]"; ?>&nbsp;</td>
                                    <td>&nbsp;<?php 
                                    $dob = date("Y-m-d",  strtotime($rows[4]));
                                    echo $dob; ?>&nbsp;
                                    </td>
                                    <td>&nbsp;<?php echo $rows[8]?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[9]?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[10]?>&nbsp;</td>
                                    <td>&nbsp;<?php echo $rows[13]; ?>&nbsp;</td>
                                    </tr>   
                                    <?php
                                    $Nopatient+=1;
                                    
                                    }
                                    
                                    ?>
                                    
                                </table>
                            </div>
                                    <p></p>
                    <div class="row">
                        <div class="col-md-9">
                        </div>
                        <div class="col-md-3">
                            <label>Number of Patient: <?php echo $Nopatient ?></label>
                        </div>
                    </div>
                        </div>
                       </div>
                </div>   
                  
            
            
            
            <?php
           include 'Clerk/PopdateInterval4.php';
        ?>
        
            
                
        <div class="row">
                      <div class="col-lg-4"></div>
              <div class="col-lg-4">
                  <div>
                  <form action="PrintListPatientReport.php" target="_blank" method="get">
                      <input type="hidden" name="From" value="<?php echo $from?>">
                      <input type="hidden" name="To" value="<?php echo $to?>">
                        <button type="submit" name= "convert" class="btn btn-default form-control">
                          Print
                        </button>
                    </form>
                   </div>
              </div>
         </div>
    </div>
        <?php
        include 'Pages/Footer.php';
        include 'Classes/JsScript.html';
        ?>
        </body>
</html>
