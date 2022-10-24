<?php

get_header();

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>


  </head>
  <body>


    <br>
    <?php
           $timezone  = +8; //(GMT +8:00) Philippines
           $timenow = gmdate("H", time() + 3600*($timezone+date("I")));
           //echo gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));
           // $timenow = 17;

          // echo $timenow;

           if($timenow >= 24 || $timenow < 12){
            $clocknow = "Good Morning";
            } elseif($timenow === 13 || $timenow < 18 ) {
                $clocknow = "Good Afternoon";
            }elseif($timenow === 18 || $timenow <= 24){
                $clocknow = "Good Evening";
            }elseif ($timenow === 12) {
              $clocknow = "Good Noon";
            }


        ?>
    <h3 style="text-align: center;"><?php echo $clocknow ?> <br><?php echo "$current_user->display_name";?></h3>
    <br>



    </div>

    <div id="chart-container" style="width: 80% !important; margin:0 auto">
            <canvas id="graphCanvas"></canvas>

        </div>
    <div style="margin-top: 3%;"></div>

   <script>
        $(document).ready(function () {
            showGraph();
        });




        function showGraph()
        {
            {
                $.post("http://iscphack2022.elementfx.com/api-caloocan-hackz/",

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
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"> </script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"> </script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"> </script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

  </body>
</html>
<?php
get_footer();

?>
