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
        include './Pages/Header.php';
        ?>

        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?&sensor=false">
        </script>


        <script type = "text/javascript">
            function initialize() {
                var middle = new google.maps.LatLng(-26.710503, 27.858921);
                var latlng = new google.maps.LatLng(-26.710099, 27.857190);
                var latlng2 = new google.maps.LatLng(-26.710572, 27.860909);

                var myOptions = {
                    zoom: 17,
                    center: middle,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };

                var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);



                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: "<b>Lerato Clinic</b>",
                    animation: google.maps.Animation.DROP
                });

                var infowindow = new google.maps.InfoWindow();


                infowindow.setContent("<b>Lerato Clinic</b>");
                infowindow.open(map, marker);



                var marker2 = new google.maps.Marker({
                    position: latlng2,
                    map: map,
                    title: "<b>Vaal University Of Technology</b>",
                    animation: google.maps.Animation.DROP
                });

                var infowindow2 = new google.maps.InfoWindow();

                infowindow2.setContent("<b>Vaal University Of Technology</b>");
                infowindow2.open(map, marker2);



            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>



    </head>
<body onload="initialize()">
    <h2 align="center">Lerato Clinic</h2>
    <br>
    <div class="row" style="  margin-top: -10px;">
        <div class="col-lg-6">

            <div id = "map_canvas" style="width: 100%;height: 400px" align="center">
            </div> 

        </div>
        <div class="col-lg-6">

            <div class="panel panel-default">
                <div class="panel-body" >
                    <div >
                        <h4 align='center'>About Us</h4>
                        <span style="font-size: 13px">Lerato Clinic is a limited comprehensive health care business that was founded by Doctor Mohau Phillip Bodibe in October 2013 with vision of providing general practice health care services to students and people staying around Vaal University of Technology main campus.</span>
                    </div> 
                    <br>
                    <div >
                        <h4 align='center'>MISSION</h4> 
                        <span style="font-size: 13px">Lerato Clinic’s primary mission is to help VUT main campus students by providing them with a 24/7 affordable health care services and also provide mobile health care services around Vanderbijlpark.
                            Lerato Clinic strives to provide superior general practice health services in a caring environment and to make a positive, measurable difference in the health of individuals in the VUT main campus community it serves.</span>
                    </div>
                    <br>
                    <div>
                        <h4 align='center'>VISION</h4>
                        <span style="font-size: 13px">Lerato Clinic will continue to be leading health care delivery system in the great VUT main campus community, as evidenced by the highest clinic quality, patient safety, patients and employee satisfaction. This will be achieved through unending focus on patient-centred and compassionate care.</span> 
                    </div>
                    <br>
                    <div>
                        <h4 align='center'>Contact Us</h4>
                        <span style="font-size: 13px"> 
                            <b>Email:</b>  Mohau@lantic.net<br>
                        <b>Tel No:</b> 082 968 6857<br>
                        <b>Fax Number:</b> 086 604 5137  <br>
                        </span> 
                    </div>
                </div>
            </div>


        </div>
    </div>

</body>
</html>
