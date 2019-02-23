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
This is medication page report
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
                <div class="col-lg-2"></div>

                <div class="panel panel-default col-md-8" style="border: solid; margin-top: -20px">
                    <div class="panel-body">
                        <div class="page-header">
                            <h4 align ="center" style="padding-top: 0px">Medication Report</h4>
                        </div>
                        <p></p>
                        <form action="MedicationReport.php" method="get">
                        <div class="row"> 
                            <div class="col-md-3">
                                <div>
                                    <button type="submit" id ="btnsortdate" name="inhouse" class="btn btn-default form-control">In House Medicine</button>
                                </div>                                                                                                      
                            </div> 
                            <div class="col-md-3">
                                <div>
                                    <button type="submit" id ="btnsortdate" name="notinhouse" class="btn btn-default form-control">Not In House Medicine</button>
                                </div>                                                                                                      
                            </div>
                            <div class="col-md-3">
                                <div>
                                    <button type="submit" id="btnpatientid" name="discontinued" class="btn btn-default form-control">Discontinued Medicine</button>
                                </div>                                                                                                      
                            </div> 
                            <div class="col-md-3">
                                <div>
                                    <button type="submit" id="btnpatientid" name="outofstock" class="btn btn-default form-control">Out of Stock</button>
                                </div>                                                                                                      
                            </div>
                        </div>
                        </form>
                        
                        <p></p>
                        <div style="height: 250px;overflow:scroll">
                            <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center">
                                <tr align="center" style="background-color: #FFFFFF">
                                    <td><b>Name</b></td>
                                    <td><b>Description</b></td>
                                    <td><b>In House</b></td>
                                    <td><b>Quantity</b></td>
                                    <td><b>Discontinue</b></td>
                                    <td><b>Update</b></td>
                                </tr>
                                <?php
                                
                                if(isset($_GET['inhouse'])){
                                $Selectquery = "select * from medication where inhouse= 'Y'";
                                $queryresults = mysql_query($Selectquery);   
                                }else if(isset($_GET['notinhouse'])){
                                $Selectquery = "select * from medication where inhouse= 'N'";
                                $queryresults = mysql_query($Selectquery); 
                                }else if(isset($_GET['discontinued'])){
                                 $Selectquery = "select * from medication where discontinue= 'Y'";
                                $queryresults = mysql_query($Selectquery);    
                                }else if(isset($_GET['outofstock'])){
                                 $Selectquery = "select * from medication where qty < 1 and inhouse= 'Y'";
                                $queryresults = mysql_query($Selectquery);   
                                }else{
                                $Selectquery = "select * from medication";
                                $queryresults = mysql_query($Selectquery);    
                                }
                                
                                $discontinued = 0;
                                $outofstck = 0;
                                $inhouse = 0;
                                $notinhouse = 0;


                                while ($result = mysql_fetch_row($queryresults)) {

                                    if ($result[3] == "Y") {
                                        $inhouse +=1;
                                        if ($result[5] != 'Y') {
                                            if ($result[4] < 1) {
                                                $outofstck+=1;
                                                echo "<tr align='center' style='background-color: #F80000;font-size:13px'>";
                                            } else {
                                                echo "<tr align='center' style='background-color: #2aabd2;font-size:13px'>";
                                            }
                                            $result[5] = 'No';
                                        } else {
                                            if ($result[4] < 1) {
                                            $outofstck+=1;
                                            
                                            }
                                            $result[5] = 'Yes';
                                            $discontinued +=1;
                                            echo "<tr align='center' style='background-color: #0000CC;color:#eee;font-size:13px'>";
                                        }
                                        $result[3] = "Yes";
                                    } else {
                                        if ($result[5] != 'Y') {
                                            $notinhouse+=1;
                                            $result[4] = "-";
                                            $result[5] = 'No';
                                            echo "<tr align='center' style='font-size:13px'>";
                                        } else {

                                            $discontinued +=1;
                                            $notinhouse +=1;
                                            $result[4] = "-";
                                            echo "<tr align='center' style='background-color: #0000CC;color:#eee;font-size:13px'>";
                                            $result[5] = 'Yes';
                                        }
                                        $result[3] = "No";
                                    }
                                    ?>
                                    <td style='color:'><?php echo $result[1] ?></td>
                                    <td><?php echo $result[2] ?></td>
                                    <td><?php echo $result[3] ?></td>
                                    <td><?php echo $result[4] ?></td>
                                    <td><?php echo $result[5] ?></td>
                                    <td> <form action="UpdateMed2.php" method="get">
                                            <input type="hidden" name="medname" value="<?php echo $result[1] ?>" >

                                            <input type="submit" class="btn-default" value="Update" name="submitmedname" style="color: #000;width: 100%">
                                        </form>
                                    </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                        <p></p>

                        <div class="row">
                            <div class="col-md-3">
                                <label>Discontinue:&nbsp;</label><?php echo $discontinued ?>
                            </div>
                            <div class="col-md-3">
                                <label>In House:&nbsp;</label><?php echo $inhouse ?>
                            </div>
                            <div class="col-md-3">
                                <label>Out Of Stock:&nbsp;</label><?php echo $outofstck ?>
                            </div>   
                            <div class="col-md-3">
                                <label>Not In House:&nbsp;</label><?php echo $notinhouse ?>
                            </div>   
                        </div>

                        <p></p>
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4">
                                <div>
                                    <a href="MedicationReport.php"> 
                                        <button type="submit" name= "convert" class="btn btn-default form-control">
                                            Reset
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <div>
                        <form action="PrintMedicationReport.php" target="_blank" method="get">
                            <?php
                            if(isset($_GET['inhouse'])){
                                echo "<input type='hidden' name='inhouse' value=''>";  
                                }else if(isset($_GET['notinhouse'])){
                                echo "<input type='hidden' name='notinhouse' value=''>";
                                }else if(isset($_GET['discontinued'])){
                                  echo "<input type='hidden' name='discontinued' value=''>";    
                                }else if(isset($_GET['outofstock'])){
                                echo "<input type='hidden' name='outofstock' value=''>";  
                                }
                            ?>
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
