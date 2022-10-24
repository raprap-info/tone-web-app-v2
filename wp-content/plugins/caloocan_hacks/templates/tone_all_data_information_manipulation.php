<?php
//ADDING NEW DATA TO THE CHAPEL ATTENDANCE MONITORING VIA AJAX JQUERY


global $wpdb;
  // HEADER FOR JSON FORMAT
   //header('Content-Type: application/json');




//CUSTOM GET FROM DIFFENT TABLE NAME


if(isset($_POST['valses'])){

      $uniqueid = $_POST['valses'];


      // $seldata = $wpdb->get_row("SELECT * FROM ip_location_data WHERE idkey = '$uniqueid' ");
      //
      //   echo json_encode( $seldata );

      // $timezonen  = +8; //(GMT +8:00) Philippines
      // $datenown = gmdate("d-M-Y", time() + 3600*($timezonen+date("I")));
      //


       //  //API LINK
       // $apilink = "http://ipinfo.io/";
       //
       // //CREATING A FULL API LINK TO DISPLAY THE DATA OF THE CURRENT USER
       // $apiUrl =  $apilink . getUserIpAddr() . '?token=8e5b76a114f4eb';
       //
       // // GET THE API RESPONSE
       // $response = wp_remote_get($apiUrl);
       //
       // // DECODE AND DISPLAY THE DATA
       // $api_response = json_decode( wp_remote_retrieve_body( $response ), true );
       //
       // //var_dump($api_response);


         //DECLARING ALL THE NEEDED DATA

          // $ip_address = $api_response['ip'];
          // $city = $api_response['city'];
          // $region = $api_response['region'];
          // $longhitude = $api_response['loc'];
          // $isp_used = $api_response['org'];


          // $incifile = $_POST['reportsfile'];
          // $vocontrib  = $_POST['mediums'];
          $message = "CONFIRMED";
          // $getlinks  = $getlinkssst;
          //
          // $website_link = $_POST['website_link'];

         // CREATING A INSERT TO TABLE EVERY USER VISITED THE PAGE

         global $wpdb;

         // $timezone  = +8; //(GMT +8:00) Philippines
         // ///$timenow = gmdate("H", time() + 3600*($timezone+date("I")));
         // $timenow = gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));


        //INSERT DATA TO THE DATABASE
        $insertdata = $wpdb->update('ip_location_data',
        array(

          'message' => $message

        ),
        array( 'idkey' => $uniqueid )
      );















}




?>
