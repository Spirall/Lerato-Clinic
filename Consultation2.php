<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['email']) || $_SESSION['right'] != 'doctor') {
    header("Location: signout.php");
}
date_default_timezone_set('Africa/Johannesburg');
?>

<!DOCTYPE html>
<!--
This is consultation step 2 page, we get the patient comment and assign diagnosis
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lerato Clinic</title>
        <?php
        include 'Classes/CssLink.html';
        ?>
        <link rel="stylesheet" href="Classes/ModifiedCss.css">

<!--        script to save comment everytime leave the textarea-->
      <script>
    function savecomment() {
        
        var comment = document.getElementById("comment").value;
        comment = comment.trim();
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                
            }
        }
        xmlhttp.open("GET","Doctor/savecomment.php?q="+comment,true);
        xmlhttp.send();
    
}
    
    </script>  
        
        
</head>

    <body>
        <?php
//c     call navigation
        include 'Pages/DoctorHeader.html';

//c     call connection to mysql
        include 'Classes/connection.php';
        
        if(isset($_POST['Remove'])){
           $constno = $_POST['consultno'];
           $idc10 = $_POST['icd10_code'];
           $Selectquery = "delete from prescription where icd10_code = '$idc10' and consultationno = $constno";
           $queryresults = mysql_query($Selectquery);
        }
        ?>

        <div class ="jumbotron" style="margin-top: -15px;">
            <div class="container"  align="center" style="padding-left: 10%;  margin-top: -20px;">
                <div class="panel panel-default col-lg-9">
                    <div class="panel-body">
                        <div class="page-header"   style="margin-bottom: 0;">
                            Consultation Page <br>Step 2
                        </div>
                        <p></p>
                        <?php
                        if(isset($_GET['Weight'])){
                        $_SESSION['patientid'] = $_GET['patientid'];
                        $_SESSION['Weight'] = $_GET['Weight'];
                        $_SESSION['bloodpressure'] = $_GET['bloodpressure'];
                        $_SESSION['consultationo'] = $_GET['consultationo'];
                        }
                        $patientid = $_SESSION['patientid'];
                        $weight = $_SESSION['Weight'];
                        $bloodpressure = $_SESSION['bloodpressure'];
                        $consultationno = $_SESSION['consultationo'];
                        
                        if(isset($_POST['add'])){        
                        $icd10 = $_POST['Diagnosis'];
                        if(!empty($icd10)){
                        $Selectquery = "insert into prescription(icd10_code,consultationno) value('$icd10','$consultationno')";
                        $queryresults = mysql_query($Selectquery);
                        }}
        
                        
                        $time = date('H:i');
                        $_SESSION['consultationno'] = $consultationno;
                        //insert start time, weight and blood pressure into this consultationno
                        $Selectquery = "update consultation set starttime = '$time',patientweight = '$weight' ,PatientBloodPresure = '$bloodpressure' where consultationno = $consultationno";
                        $queryresults = mysql_query($Selectquery);


                        //get patient details toconsult
                        $Selectquery = "select surname, firstname, gender, dob from patient where patientid = '$patientid'";
                        $queryresults = mysql_query($Selectquery);
                        $result = mysql_fetch_row($queryresults);
                        echo "Patient $result[0] $result[1]";
                        ?>
                        <p></p>
                        <form action="Consultation3.php" method="GET"> 
                        <div class="row">
                            <div class="col-lg-8">
                                <label for="Gender" class="" style="margin-bottom:0px">COMMENT</label>
                                <div>   
                                    <textarea rows='7'id="comment" onblur="savecomment()" maxlength="200" class='form-control' name="comment" autofocus required><?php if(isset($_SESSION['comment'])){echo $_SESSION['comment']; }?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <br>
                                <br>
                                <br>
                                <div>
                                    <?php
                                    $hasdiagnosis = "";
                                    $Selectquery = "select d.icd10_code, d.symptoms from diagnosis d,prescription p where d.icd10_code = p.icd10_code and p.consultationno = $consultationno";
                                    $queryresults = mysql_query($Selectquery);
                                    while($rows1 = mysql_fetch_row($queryresults)){
                                      $hasdiagnosis =   $rows1[0];
                                    }
                                    if(!empty($hasdiagnosis)){
                                    ?>
                                    
                                    <button type="submit" name= "next2" class="btn btn-default form-control">
                                      Next >>
                                    </button> 
                                    <?php
                                    }else{
                                    echo "<button type='submit' name= '' class='btn btn-default form-control' disabled>".
                                      "Next >>".
                                    "</button>";
                                    }
                                    ?>
                                </div>
                                <br>
                                    <a href="Consultation.php?patientid=<?php echo $patientid ?>&search=">
                                    <button type="button" name= "next2" class="btn btn-default form-control">
                                      << Back
                                    </button>
                                        </a>
                            </div>
                        </div>
                        </form>
                        <br>
                        <div class="row">
                            <div class="col-lg-3">
                            </div>
                            <form action="Consultation2.php" method="POST">
                            <div class="col-lg-7">
                                <div class="col-lg-9">
                                    <label for="Gender" class="" style="margin-bottom:0px">Diagnosis</label> 
                                    <select name = 'Diagnosis' class="form-control" id="icd10" required>
                                        <option value =''>-----</option>
                                        <?php
                                        $icdcodefromdb = array();
                                        $icdcodefromprescr = array();
                                        
                                        $Selectquery = "select icd10_code from diagnosis";
                                        $queryresults = mysql_query($Selectquery);
                                        
                                        while ($result = mysql_fetch_row($queryresults)) {
                                         $icdcodefromdb[] = $result[0];
                                        }
                                        
                                        $Selectquery2 = "select icd10_code from prescription where consultationno = $consultationno";
                                        $queryresults2 = mysql_query($Selectquery2);
                                        while ($result2 = mysql_fetch_row($queryresults2)) {
                                        $icdcodefromprescr[] = $result2[0];
                                        }
                                        
                                        $diagndispla = array_diff($icdcodefromdb,$icdcodefromprescr);
                                        
                                        foreach ($diagndispla as $diagno) {
                                        $Selectquery3 = "select * from diagnosis where icd10_code = '$diagno'";
                                        $queryresults3 = mysql_query($Selectquery3);   
                                        $result = mysql_fetch_row($queryresults3);   
                                         echo "<option value ='$result[0]'>$result[0]  --> $result[1]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="Gender" class="" style="margin-bottom:0px"></label>
                                    <button type="submit" class="btn btn-default form-control" name="add" onclick="">
                                        ADD
                                    </button>   
                                </div>
                            </div>
                          </form>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-lg-1">
                            </div>

                            <div class="col-lg-11" id="showtable">
                               <form action="Consultation2.php" method="POST">
                                    <div style="height: 200px;overflow:scroll">
                                        <table border="1" class="table-responsive" style="background-color:#eee;width: 99%" align="center">
                                            <tr align="center">
                                                <td>ICD10 CODE</td>
                                                <td>Symptom</td>
                                                <td>Remove</td>
                                            </tr>

                                            <?php
                                            $Selectquery = "select distinct(d.icd10_code) from diagnosis d,prescription p where d.icd10_code = p.icd10_code and p.consultationno = $consultationno";
                                            $queryresults = mysql_query($Selectquery);

                                            while ($rows = mysql_fetch_row($queryresults)) {
                                            $Selectquery2 = "select symptoms from diagnosis where icd10_code = '$rows[0]'";
                                            $queryresults2 = mysql_query($Selectquery2);
                                            $rows2 = mysql_fetch_row($queryresults2)    
                                                ?>
                                                <tr align="center" style="font-size: 12px">
                                                    <td>&nbsp;<?php echo $rows[0]; ?>&nbsp;</td>
                                                    <td>&nbsp;<?php echo $rows2[0]; ?>&nbsp;</td>
                                                    <td>
                                                        <input type="hidden" name="icd10_code" value="<?php echo $rows[0]; ?>">
                                                        <input type="hidden" name="consultno" value="<?php echo $consultationno; ?>">
                                                        <button type="submit" name= "Remove" class="btn btn-default">
                                                            Remove
                                                        </button>  
                                                    </td>
                                                </tr>   
                                            <?php
                                            }
                                            ?>

                                        </table>
                                    </div>           
                                </form>
                                
                            </div>

                        </div>
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
