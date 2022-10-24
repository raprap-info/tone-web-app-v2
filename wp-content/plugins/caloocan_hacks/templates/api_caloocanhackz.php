<?php
/**
 * Template Name: API ENDPOINTS DATA FOR SCHOLARSHIP DETAILS DISPLAY
 */



            // Adding header for page will recognize this is a json format

            header('Content-Type: application/json');




            //$sql = $wpdb->get_results(" SELECT COUNT(DISTINCT Name) AS Name, sum(case when Program_Name = Program_Name then 1 else 0 end) AS Pname,Program_Name FROM student_registartion_sy_2022_2023 GROUP BY Program_Name  ");

            $timezone  = +8; //(GMT +8:00) Philippines
            $gecurrentmonth  = gmdate("m", time() + 3600*($timezone+date("I")));
            $gelastyer  = gmdate("Y", time() + 3600*($timezone+date("I")));



            $gdataapi = $wpdb->get_results("SELECT  SUM(idkey) AS ctnumbs, city, region, isp_used, datetime  FROM ip_location_data GROUP BY city ");

          
                  $json = json_encode($gdataapi, JSON_PRETTY_PRINT);
                  echo $json;














?>
