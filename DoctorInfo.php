<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>
    <?php
        include './Classes/CssLink.html';
    ?>
    </head> 
    <body>
        <?php
        include "./Pages/Header.php";
        //include javascript class to call doctor info
        include './Classes/DoctorInfoscript.html';
        
        //include the connection class
        include './Classes/connection.php';
        ?>

        
            
        <div class ="jumbotron" style="margin-top: -15px;padding-top: 25px;">
            <div class="appoint">
                <div class="container"  align="center" style="padding-left: 10%;">
                    <div class="panel panel-default col-lg-9">
                        <div class="panel-body">
                                <div class="page-header">
                                    <h4 align ="center" style="padding-top: 0px">Doctor Information</h4>
                                </div>

                            </div>
                                <div id="info">
                                   <div class="row">
                                         <div class="col-md-6">
                                          <?php
                                               $Selectquery = "select Surname,firstname,email,doctor_descr,Profilpicture,gender,doctorid from doctor";
                                                $queryresults = mysql_query($Selectquery);
                                                $surname = array();
                                                $firstname = array();
                                                $email = array();
                                                $descr = array();
                                                $picture = array();
                                                $gender = array();

                                                while ($rows = mysql_fetch_row($queryresults)) {
                                                    $surname[] = $rows[0];
                                                    $firstname[] = $rows[1];
                                                    $email[] = $rows[2];
                                                    $descr[] = $rows[3];
                                                    $picture[] = $rows[4];
                                                    $gender[] = $rows[5];
                                                    $id[] = $rows[6];
                                                }
                                             
                                                if ($picture[0] != 'None') {
                                                    echo "<img src='Images/Stuff/Doctor/$picture[0]' width='90%' style='border-radius: 10px;background-color:#660099;height: 200px;' align='center'>";
                                                }
                                                else {
                                                    if ($gender[0] == 'F') {
                                                        echo "<img src='Images/Stuff/Woman.png' width='90%' style='border-radius: 10px;background-color:#660099;height: 200px;' align='center'>";
                                                    } else {
                                                        echo "<img src='Images/Stuff/Man.png' width='90%' style='border-radius: 10px;background-color:#660099;height: 200px;' align='center'>";
                                                    }
                                                }
                                                
                                                ?>
                                        
                                            </div>
                                       <div class="col-md-6" style="padding-bottom: 15px">
                                                
                                               <table border="0" class="table-responsive" style="background-color:#eee;border-radius:0px">
                                                    <tr>
                                                        <td style="padding: 7px;">
                                                            Name:  
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <?php echo "Dr. ", $surname[0] ," ", $firstname[0]; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 7px;">
                                                            Description: 
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <?php echo $descr[0]; ?> 
                                                        </td>
                                                    </tr>
                                                    <tr><td style="padding: 7px;">
                                                            Office: 
                                                        </td><td style="padding: 7px;">
                                                            31 Lerato Avenue, SE 7 Vanderbijlpark
                                                            Gauteng
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 7px;">
                                                            Email:
                                                        </td>
                                                        <td style="padding: 7px;">
                                                            <?php echo $email[0]; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 7px;">
                                                            Hours:
                                                        </td>
                                                        <td style="padding: 7px;font-size: 11px">
                                                            <?php
                                                            $Selectquery1 = "select days,starttime,endtime from schedule where doctorid = '$id[0]' ";
                                                            $queryresults1 = mysql_query($Selectquery1);
                                                            while ($Result = mysql_fetch_row($queryresults1)) {
                                                                $starttime;
                                                                $endtime;
                                                                if ($Result[1] < 12) {
                                                                    $starttime = $Result[1] . ":00 AM";
                                                                } else {
                                                                    $starttime = $Result[1] . ":00 PM";
                                                                }
                                                                if ($Result[2] < 12) {
                                                                    $endtime = $Result[2] . ":00 AM";
                                                                } else {
                                                                    $endtime = $Result[2] . ":00 PM";
                                                                }
                                                                Echo "$Result[0] : $starttime - $endtime<br>";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                               </table>

                                          </div>  
                                        </div>
                                        
                                        
<!--                                    </div> -->
                                </div>

                                <a href='#' class="left carousel-control" onclick="getpreviousdoctor()">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <?php
                                $Selectquery = "select count(*) from doctor";
                                $queryresults = mysql_query($Selectquery);
                                $rows = mysql_fetch_row($queryresults);
                                $count = $rows[0];

                                echo "<a href='#' class='right carousel-control' onclick='getnextdoctor($count)'>"
                                ?>
                                <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
        
        
        
        
        <?php
        include "./Pages/Footer.php";
        include 'Classes/JsScript.html';
        ?>
   </body>
</html>
