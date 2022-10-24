<?php
/**
 * Template Name: IGSL ALL STUDENT INFORMATION DATA
 */

get_header(  );

global $wpdb, $current_user;

//TO GET THE CURRENT USER INFO
 // wp_get_current_user();





 $user = wp_get_current_user();



?>

<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>

.rbtn{
 display: inline-grid;
 left:5%;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: white !important;
    /* border: 1px solid #2980B9!important; */
    background-color: #fffff !important; */
    /* background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #2980B9), color-stop(100%, #2980B9))!important;
    /* background: -webkit-linear-gradient(top, #2980B9 0%, #2980B9 100%)!important; */
    background: -moz-linear-gradient(top, #ffffff  100%, #ffffff  100%)!important;
    background: -ms-linear-gradient(top, #ffffff  100%, #ffffff  100%)!important;
    background: -o-linear-gradient(top, #ffffff 100%, #ffffff 100%)!important;
    background: linear-gradient(to bottom, #ffffff  100%, #ffffff  100%)!important;
    /* background-color: #ffffff !important; */
}
.calc{

  display: grid;
  grid-template-columns: auto auto;"
  grid-gap: 5%;
  justify-content: center;
  column-gap: 10%;
  vertical-align: middle;
  grid-template-areas:
     "a b";

   align-items: start;


}
.diva{
  grid-area: a;
}
.divb{
  grid-area: b;
}

.form{
    margin:0 auto;
    width: 20%;
    box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
    padding:5px;
      border: 3px solid #023d77;
}

td{

}

select {
  border: 3px solid #023d77;
  width: 30%;
}

table{


  border:3px solid #023d77;
  box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
  padding:50px;

}
th{

  border:1px solid #d4d4d4;
  text-align: center;
}
tr:hover{
  background-color: #f5f5f5;
}
td{
  border-collapse: collapse;
  border:1px solid #d4d4d4;
  border-spacing: 2px;
}

 #rdatamain_length {
   margin-left: 10%;
   padding: 10px;
 }
 button:focus {
     outline: 1px solid #fff;
     outline-offset: -4px;
 }

 button:active {
     transform: scale(0.99);
 }

td{
  text-align: center;
}
.dt-buttons{
    margin-left: 8%;
}
#rdatamain_filter {
  margin-right: 10%;
}

.dataTables_wrapper .dataTables_filter input {
  border: 3px solid #023d77 !important;

}
#rdatamain_paginate {
  margin-right: 10%;
}
#rdatamain_info {
  margin-left: 10%;
}


input[type] {
    font-size: 1.5rem !important;
    color: #023d77 !important;
    font-weight: bolder;
}


.dt-buttons {
  display:none;
}
#map { top: 0; bottom: 0; width: 90%; height:500px;
      margin: 0 auto;
      border:3px solid #023d77;
      box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
      padding:50px;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<script src="https://api.mapbox.com/mapbox.js/v3.2.1/mapbox.js"></script>
<link href="https://api.mapbox.com/mapbox.js/v3.2.1/mapbox.css" rel="stylesheet"/>
<script src="https://api.mapbox.com/mapbox.js/plugins/turf/v3.0.11/turf.min.js"></script>


</head>
<body onload="GeoTrack();">

<div style="display:grid; grid-template-columns: auto auto; margin: 0 auto; width: 165%;">
  <div id="map"></div>
  <div class="">
    <h3 style="margin-top:-5px">DIFFERENT LOCAL <br>AGENCY LIVE VIEW</h3>
    <img src="http://tone.x10.bz/wp-content/uploads/2022/10/live-share.png" alt="" style="height:450px">
  </div>
</div>



  <table id="rdatamain" class="hover row-border" style="width: 80%; top: 20%; margin-top:50%">
      <thead>
          <tr>
              <th>ID</th>
              <th>IP ADDRESS</th>
              <th>CITY</th>
              <th>REGION</th>
              <th>LOCATION</th>
              <th>ISP USED</th>
              <th>DATE TIME</th>
              <th>INCIDENT FILE</th>
              <th>PERSONA</th>

              <th>REPORTS</th>
              <th>ACTION</th>



          </tr>
      </thead>
      <tbody>

        <!-- MAKING FOR LOOP FOR DISPLAYING DATA FROM DATABASE -->

        <?php

        $results = $wpdb->get_results("SELECT * FROM `ip_location_data` ");

          foreach ($results as $rvalue) {

        ?>
        <tr>
          <td style="font-size: 2rem">
            <?php

            echo ++$i;
           ?>

          </td>
          <td style="font-size: 2rem">
            <?php echo $rvalue->ip_address; ?>


          <td style="font-size: 2rem">
            <?php echo $rvalue->city; ?>
          </td>
          <td style="font-size: 2rem">
              <?php echo $rvalue->region; ?>
          </td>
          <td style="font-size: 2rem">
              <?php echo $rvalue->longhitude; ?>
          </td>
          <td style="font-size: 2rem">
              <?php echo $rvalue->isp_used; ?>
          </td>
          <td style="font-size: 2rem">
              <?php echo $rvalue->datetime; ?>
          </td>
          <td style="font-size: 2rem">
              <?php echo $rvalue->incident_file; ?>
          </td>
          <td style="font-size: 2rem">
              <?php echo $rvalue->victim_contributor; ?>
          </td>

          <td style="font-size: 2rem">
              <?php echo $rvalue->message; ?>
          </td>
          <td>
            <input type="hidden" id="valses" value="<?php echo $rvalue->idkey; ?>">
              <button  onclick="addNRecord('<?php echo $rvalue->idkey; ?>')" type="button" name="button" class="btn btn-success"data-toggle="modal" data-target="#myModal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
  <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
</svg></button>
          </td>



        </tr>
      <?php } ?>
      </tbody>

 <!-- FOREACH TABLE CLOSING TAGS  -->


  </table>






  <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"> </script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"> </script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"> </script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
    L.mapbox.accessToken = 'pk.eyJ1IjoiYW50aXN0YXRpYzE4OSIsImEiOiJja3I5emxzdWQyZ3o4MnZwZGY4eHVmN3hwIn0.dawZ_CPyvNtZpO2GHkqpKQ';

    const hospitals = {
    'type': 'FeatureCollection',
    'features': [
    {
    'type': 'Feature',
    'properties': {
    'Name': 'Victim 1',
    'Address': '2250 Leestown Rd'
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [122.5677, 10.7034]
    }
    },
    {
    'type': 'Feature',
    'properties': {
    'Name': 'Victim 2',
    'Address': '150 N Eagle Creek Dr'
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [122.5687, 10.7024]
    }
    },
    {
    'type': 'Feature',
    'properties': {
    'Name': 'Victim 3',
    'Address': '1740 Nicholasville Rd'
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [122.5667, 10.7024]
    }
    },
    {
    'type': 'Feature',
    'properties': {
    'Name': 'Victim 4',
    'Address': '1101 Veterans Dr'
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [122.5679, 10.7024]
    }
    },
    {
    'type': 'Feature',
    'properties': {
    'Name': 'Victim 5',
    'Address': '1900 Richmond Rd'
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [122.5681, 10.7027]
    }
    },
    {
    'type': 'Feature',
    'properties': {
    'Name': 'Victim 6',
    'Address': '627 W Fourth St'
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [121.0400, 64.6567]
    }
    },
    {
    'type': 'Feature',
    'properties': {
    'Name': 'Cardinal Hill Rehabilitation Hospital',
    'Address': '2050 Versailles Rd'
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [121.0400, 74.6567]
    }
    },
    {
    'type': 'Feature',
    'properties': {
    'Name': 'St. Joseph Hospital',
    'ADDRESS': '1 St Joseph Dr'
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [121.0400, 84.6567]
    }
    },
    {
    'type': 'Feature',
    'properties': {
    'Name': 'UK Healthcare Good Samaritan Hospital',
    'Address': '310 S Limestone'
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [121.0400, 94.6567]
    }
    },
    {
    'type': 'Feature',
    'properties': {
    'Name': 'UK Medical Center',
    'Address': '800 Rose St'
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [121.0400, 104.6567]
    }
    }
    ]
    };
    const libraries = {
    'type': 'FeatureCollection',
    'features': [
    {
    'type': 'Feature',
    'properties': {
    'Name': 'Police Station 1 Tel: 0945 863 22 35 or (02) 2 420 6460',
    'Address': '2185 Versailles Rd',

    },
    'geometry': {
    'type': 'Point',
    'coordinates': [122.5677, 10.7024]
    }
    },
    {
    'type': 'Feature',
    'properties': {
    'Name': 'Police Station 2 Tel: (032) 410 84 83',
    'Address': '2185 Versailles Rd'
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [122.5665, 10.7024]
    }
    }
    ]
    };

    const buildings = {
    'type': 'FeatureCollection',
    'features': [
    {
    'type': 'Feature',
    'properties': {
    'Name': 'DSWD 1 Tel: 0945 863 22 35 or (02) 2 420 6460',
    'Address': '2185 Versailles Rd',

    },
    'geometry': {
    'type': 'Point',
    'coordinates': [122.5677, 10.7004]
    }
    },
    {
    'type': 'Feature',
    'properties': {
    'Name': 'DSWD Tel: (032) 410 84 83',
    'Address': '2185 Versailles Rd'
    },
    'geometry': {
    'type': 'Point',
    'coordinates': [122.5669, 10.7104]
    }
    }
    ]
    };

    // Add marker color, symbol, and size to hospital GeoJSON
    for (const hospital of hospitals.features) {
    hospital.properties['marker-color'] = '#DC143C';
    hospital.properties['marker-symbol'] = 'marker';
    hospital.properties['marker-size'] = 'small';
    }

    // Add marker color, symbol, and size to library GeoJSON
    for (const library of libraries.features) {
    library.properties['marker-color'] = '#4169E1';
    library.properties['marker-symbol'] = 'police';
    library.properties['marker-size'] = 'small';
    }

    // Add marker color, symbol, and size to library GeoJSON
    for (const building of buildings.features) {
    building.properties['marker-color'] = '#F59E42';
    building.properties['marker-symbol'] = 'embassy';
    building.properties['marker-size'] = 'small';
    }


    const map = L.mapbox
    .map('map')
    .setView([122.5677, 10.7024], 10)
    .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/light-v10'));
    map.scrollWheelZoom.disable();

    const hospitalLayer = L.mapbox.featureLayer(hospitals).addTo(map);
    const libraryLayer = L.mapbox.featureLayer(libraries).addTo(map);
    const buildingLayer = L.mapbox.featureLayer(buildings).addTo(map);
    map.fitBounds(libraryLayer.getBounds());

    // Bind a popup to each feature in hospitalLayer and libraryLayer
    hospitalLayer
    .eachLayer((layer) => {
    layer.bindPopup(`<strong>${layer.feature.properties.Name}</strong>`, {
    closeButton: false
    });
    })
    .addTo(map);

    libraryLayer
    .eachLayer((layer) => {
    layer.bindPopup(layer.feature.properties.Name, {
    closeButton: false
    });
    })
    .addTo(map);


    buildingLayer
    .eachLayer((layer) => {
    layer.bindPopup(layer.feature.properties.Name, {
    closeButton: false
    });
    })
    .addTo(map);





    // Open popups on hover
    libraryLayer.on('mouseover', (event) => event.layer.openPopup());
    hospitalLayer.on('mouseover', (event) => event.layer.openPopup());
    buildingLayer.on('mouseover', (event) => event.layer.openPopup());

    // Reset marker size to small
    function reset() {
    const hospitalFeatures = hospitalLayer.getGeoJSON();


    for (const hospital of hospitalFeatures.features) {
    hospital.properties['marker-size'] = 'small';
    }
    hospitalLayer.setGeoJSON(hospitalFeatures);




    for (const building of buildingFeatures.features) {
    building.properties['marker-size'] = 'small';
        }
    buildingLayer.setGeoJSON(buildingFeatures);


    }

    // When a library is clicked, do the following
    libraryLayer.on('click', (e) => {
    // Reset any and all marker sizes to small
    reset();
    const hospitalFeatures = hospitalLayer.getGeoJSON();
    const buildingFeatures = buildingLayer.getGeoJSON();

    // Using Turf, find the nearest hospital to library clicked
    const nearestHospital = turf.nearest(e.layer.feature, hospitalFeatures);
    // Change the nearest hospital to a large marker
    nearestHospital.properties['marker-size'] = 'large';
    // Add the new GeoJSON to hospitalLayer
    hospitalLayer.setGeoJSON(hospitalFeatures);
    buildingLayer.setGeoJSON(buildingFeatures);
    // Bind popups to new hospitalLayer and open popup
    // for nearest hospital
    hospitalLayer.eachLayer((layer) => {
    layer.bindPopup(`<strong>${layer.feature.properties.Name}</strong>`, {
    closeButton: false
    });
    if (layer.feature.properties['marker-size'] === 'large') {
    layer.openPopup();
    }
    });

    buildingLayer.eachLayer((layer) => {
    layer.bindPopup(`<strong>${layer.feature.properties.Name}</strong>`, {
    closeButton: false
    });
    if (layer.feature.properties['marker-size'] === 'large') {
    layer.openPopup();
    }
    });


    });

    // When the map is clicked on anywhere, reset all
    // hospital markers to small
    map.on('click', () => reset());
    </script>


    <script>


  //
  // mapboxgl.accessToken = 'pk.eyJ1IjoiYW50aXN0YXRpYzE4OSIsImEiOiJja3I5emxzdWQyZ3o4MnZwZGY4eHVmN3hwIn0.dawZ_CPyvNtZpO2GHkqpKQ';
  // const map = new mapboxgl.Map({
  //   container: 'map',
  //   style: 'mapbox://styles/examples/cjgiiz9ck002j2ss5zur1vjji',
  //   center: [ 121.0400, 14.6567 ],
  //   zoom: 10.7
  // });
  //
  // map.on('click', (event) => {
  //   const features = map.queryRenderedFeatures(event.point, {
  //     layers: ['chicago-parks']
  //   });
  //   if (!features.length) {
  //     return;
  //   }
  //   const feature = features[0];
  //
  //   const popup = new mapboxgl.Popup({ offset: [0, -15] })
  //     .setLngLat(feature.geometry.coordinates)
  //     .setHTML(
  //       `<h3>${feature.properties.title}</h3><p>${feature.properties.description}</p>`
  //     )
  //     .addTo(map);
  // });



    </script>

    <script>
    // 	// TO MAKE THE MAP APPEAR YOU MUST
    // 	// ADD YOUR ACCESS TOKEN FROM
    // 	// https://account.mapbox.com
    // 	mapboxgl.accessToken = 'pk.eyJ1IjoiYW50aXN0YXRpYzE4OSIsImEiOiJja3I5emxzdWQyZ3o4MnZwZGY4eHVmN3hwIn0.dawZ_CPyvNtZpO2GHkqpKQ';
    // const map = new mapboxgl.Map({
    // container: 'map',
    // // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
    // style: 'mapbox://styles/mapbox/streets-v11',
    // center: [ 121.0400, 14.6567 ],
    // zoom: 14
    // });
    //
    //
    //         /* Given a query in the form "lng, lat" or "lat, lng"
    //         * returns the matching geographic coordinate(s)
    //         * as search results in carmen geojson format,
    //         * https://github.com/mapbox/carmen/blob/master/carmen-geojson.md */
    //         const coordinatesGeocoder = function (query) {
    //         // Match anything which looks like
    //         // decimal degrees coordinate pair.
    //         const matches = query.match(
    //         /^[ ]*(?:Lat: )?(-?\d+\.?\d*)[, ]+(?:Lng: )?(-?\d+\.?\d*)[ ]*$/i
    //         );
    //         if (!matches) {
    //         return null;
    //         }
    //
    //         function coordinateFeature(lng, lat) {
    //         return {
    //         center: [lng, lat],
    //         geometry: {
    //         type: 'Point',
    //         coordinates: [lng, lat]
    //         },
    //         place_name: 'Lat: ' + lat + ' Lng: ' + lng,
    //         place_type: ['coordinate'],
    //         properties: {},
    //         type: 'Feature'
    //         };
    //         }
    //
    //         const coord1 = Number(matches[1]);
    //         const coord2 = Number(matches[2]);
    //         const geocodes = [];
    //
    //         if (coord1 < -90 || coord1 > 90) {
    //         // must be lng, lat
    //         geocodes.push(coordinateFeature(coord1, coord2));
    //         }
    //
    //         if (coord2 < -90 || coord2 > 90) {
    //         // must be lat, lng
    //         geocodes.push(coordinateFeature(coord2, coord1));
    //         }
    //
    //         if (geocodes.length === 0) {
    //         // else could be either lng, lat or lat, lng
    //         geocodes.push(coordinateFeature(coord1, coord2));
    //         geocodes.push(coordinateFeature(coord2, coord1));
    //         }
    //
    //         return geocodes;
    //         };
    //
    //
    //         // Add the control to the map.
    //         map.addControl(
    //         new MapboxGeocoder({
    //         accessToken: mapboxgl.accessToken,
    //         localGeocoder: coordinatesGeocoder,
    //         zoom: 15,
    //         placeholder: 'Try: -40, 170',
    //         mapboxgl: mapboxgl,
    //         reverseGeocode: true
    //         })
    //         );
    //
    //
    //

    </script>



<script>
$(document).ready(function() {
    $('#rdatamain').DataTable( {
     // "lengthMenu": [[ 100, 150, 250, -1 ],[ '100', '150', '250', 'ALL' ],
     "lengthMenu": [ [50, 75, 100, -1], [50, 75, 100, "All"] ],
     order: [[0, 'desc']],
     dom: 'Bfrltip',

     //    buttons: [
     //   // { extend: 'copy', className: 'rbtn btn-primary glyphicon glyphicon-duplicate' },
     //   { extend: 'csv', className: 'rbtn btn-primary glyphicon glyphicon-save-file' },
     //   //{ extend: 'excel', className: 'rbtn btn-primary glyphicon glyphicon-list-alt' },
     //   // { extend: 'pdf', className: 'rbtn btn-primary glyphicon glyphicon-file' },
     //   // { extend: 'print', className: 'rbtn btn-primary glyphicon glyphicon-print' },
     //   // { extend: 'create', className: 'rbtn btn-primary glyphicon glyphicon-plus'},
     //   {
     //            text: 'ADD',
     //            className: 'rbtn btn-primary glyphicon glyphicon-plus',
     //            action: function ( e, dt, node, config ) {
     //                  onclick="getStudent('<?php echo $stnumbersd ?>')";
     //
     //            }
     //         }
     //
     //   {
     //        extend: 'excelHtml5',className: 'rbtn btn-primary glyphicon glyphicon-list-alt',
     //        exportOptions: {
     //            columns: [ 2 ]
     //        }
     //    },
     //
     // ],
      dom: '<dtlfBterspacer>',
     responsive: true
    } );


} );



</script>



  <script>

   function addNRecord(){

    let valses = $('#valses').val();

    console.log(valses)
     $.post("http://tone.x10.bz/all-data-manipulation/", {

       valses:valses



    },function(data,status){



        Swal.fire({
          title: 'Do you want to confirm?',

          showCancelButton: true,
          confirmButtonText: 'Save',

        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            Swal.fire('New Record has been added!', '', 'success').then(function(){
                window.location = 'http://tone.x10.bz/tone-dashboard/';
            });
          }
        })

    });
  }





  </script>


<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// calendar js here
flatpickr("input[type=date]", {
  dateFormat: "d-m-Y",
});

</script>



</body>
</html>

<?php

if(isset($_POST['issuedcopy'])){


    $nonce = $_POST['form_nonce'];

    if (!wp_verify_nonce($nonce,'rap-nonce'))

    {
       wp_redirect( "https://igsl-portal.igsl.asia/",  302 );

    }else

    {


      global $wpdb;

        $studentnum = $_POST['studnt'];

        echo $gethash;
        //GET THE FULLDATE TODAY
        $timezone  = +8; //(GMT +8:00) Philippines
        //$timenow = gmdate("H", time() + 3600*($timezone+date("I")));
        $cudate = gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));






          if(  $insertdata == true) {
            echo "<script language = javascript>
                      swal.fire({
                      icon: 'success',
                      title: 'Your Inputs Has Been Saved!',
                      text: 'You can view your inputs now',
                      type: 'success',
                      showCancelButton: false,
                      closeOnConfirm: false,
                      confirmButtonText: 'Confirm',
                      showLoaderOnConfirm: true })
                      .then(function() {

                            window.location = 'http://iscphack2022.elementfx.com/caloocanhackz-dashboard/';

                        });

                  </script>";
          }



    }

}


?>





<?php

get_footer(  );

 ?>
