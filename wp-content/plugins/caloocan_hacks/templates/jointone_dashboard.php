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
#map { top: 0; bottom: 0; width: 80%; height:500px;
      margin: 0 auto;
      border:3px solid #023d77;
      box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
      padding:50px;
  }
</style>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>


</head>
<body>


     <!-- <canvas id="myChart" style="width:100%;max-width:600px; margin: 0 auto;"></canvas> -->
     <div id="chart-container" style="width: 50% !important; margin:0 auto">
             <canvas id="graphCanvas"></canvas>

         </div>
         <br>
         <h4 style="text-align:center"> OVER ALL ACTIVE REPORTS HERE IN THE PHILIPPINES </h4>

  <table id="rdatamain" class="hover row-border" style="width: 80%; top: 20%; margin-top:50%">
      <thead>
        <tr>
          <th colspan="7"><h4>TONE ACTIVE CONTRIBUTORS AND MEMBERS</h4></th>

        </tr>
          <tr>
              <th>ID</th>
              <th>FULL NAME</th>
              <th>ADDRESS</th>
              <th>PHONE</th>
              <th>ABUSED CASE REPORT</th>
              <th>REASONS</th>
              <th>DATE TIME</th>



          </tr>
      </thead>
      <tbody>

        <!-- MAKING FOR LOOP FOR DISPLAYING DATA FROM DATABASE -->

        <?php

        $results = $wpdb->get_results("SELECT * FROM `memberships` ");

          foreach ($results as $rvalue) {

        ?>
        <tr>
          <td style="font-size: 2rem">
            <?php

            echo ++$i;
           ?>

          </td>
          <td style="font-size: 2rem">
            <?php echo $rvalue->fullname; ?>


          <td style="font-size: 2rem">
            <?php echo $rvalue->address; ?>
          </td>
          <td style="font-size: 2rem">
              <?php echo $rvalue->phone; ?>
          </td>
          <td style="font-size: 2rem">
              <?php echo $rvalue->abused_report; ?>
          </td>
          <td style="font-size: 2rem">
              <?php echo $rvalue->reasons; ?>
          </td>
          <td style="font-size: 2rem">
              <?php echo $rvalue->datetime; ?>
          </td>




        </tr>
      <?php } ?>
      </tbody>

 <!-- FOREACH TABLE CLOSING TAGS  -->


  </table>


  <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

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
         $(document).ready(function () {
             showGraph();
         });




         function showGraph()
         {
             {
                 $.post("http://tone.x10.bz/api-caloocan-hackz/",

                  function (data)
                {
                    //console.log(data);
                     var name = [];
                     var marks = [];

                    for (var i in data) {



                        name.push(data[i]. city );
                        marks.push(data[i]. ctnumbs);
                    }

           //SAMPLE DATA


                    var chartdata = {


                           labels:  name,


             // SAMPLE DATASETS
             datasets: [
                            {
                              label: 'Daily Activity',

                              //backgroundColor: '#ffcd56',
                 backgroundColor: [
                   'rgba(255, 99, 132, 0.7)',
                   'rgba(255, 159, 64, 0.7)',
                   'rgba(255, 205, 86, 0.7)',
                   'rgba(75, 192, 192, 0.7)',
                   'rgba(54, 162, 235, 0.7)',
                   'rgba(153, 102, 255, 0.7)',
                   'rgba(201, 203, 207, 0.7)',
                   'rgba(255, 99, 132, 0.7)',
                   'rgba(255, 159, 64, 0.7)',
                   'rgba(255, 205, 86, 0.7)',
                   'rgba(75, 192, 192, 0.7)',
                   'rgba(54, 162, 235, 0.7)',
                   'rgba(153, 102, 255, 0.7)',
                   'rgba(201, 203, 207, 0.7)'

                   ],
                   // borderColor: '#46d5f1',
                               //hoverBackgroundColor: '#46d5f1',
                              hoverBorderColor: '#666666',
                              data: marks
                           }
                      ]




                    };




                     var graphTarget = $("#graphCanvas");

                     var barGraph = new Chart(graphTarget, {
                         type: 'doughnut',
                         data: chartdata,
             options: {
             responsive: true
             },
              axisX:{
                labelFontSize: 50,
              },
                     });
                 });
             }
         }
         </script>

       <script>
       var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
       var yValues = [55, 49, 44, 24, 15];
       var barColors = [
         "#b91d47",
         "#00aba9",
         "#2b5797",
         "#e8c3b9",
         "#1e7145"
       ];

       new Chart("myChart", {
         type: "doughnut",
         data: {
           labels: xValues,
           datasets: [{
             backgroundColor: barColors,
             data: yValues
           }]
         },
         options: {
           title: {
             display: true,
             text: "World Wide Wine Production 2018"
           }
         }
       });
       </script>



<script>
$(document).ready(function() {
    $('#rdatamain').DataTable( {
     // "lengthMenu": [[ 100, 150, 250, -1 ],[ '100', '150', '250', 'ALL' ],
     "lengthMenu": [ [50, 75, 100, -1], [50, 75, 100, "All"] ],
     //order: [[1, 'asc']],
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
