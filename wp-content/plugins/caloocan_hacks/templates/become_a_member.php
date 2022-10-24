<?php


 get_header( );


  function getUserIpAddr(){
      if(!empty($_SERVER['HTTP_CLIENT_IP'])){
          //ip from share internet
          $ip = $_SERVER['HTTP_CLIENT_IP'];
      }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
          //ip pass from proxy
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      }else{
          $ip = $_SERVER['REMOTE_ADDR'];
      }
      return $ip;
  }


?>
  <h2 style="text-align:center"><br>
    <span style="font-weight:bolder; font-size: 3rem; text-align:center">Join Tone Movement <br>and Be One of Us!  </span>
  </h2>

<?php
    //API LINK
   $apilink = "http://ipinfo.io/";

   //CREATING A FULL API LINK TO DISPLAY THE DATA OF THE CURRENT USER
   $apiUrl =  $apilink . getUserIpAddr() . '?token=8e5b76a114f4eb';

   // GET THE API RESPONSE
   $response = wp_remote_get($apiUrl);

   // DECODE AND DISPLAY THE DATA
   $api_response = json_decode( wp_remote_retrieve_body( $response ), true );

   //var_dump($api_response);


     //DECLARING ALL THE NEEDED DATA

      $ip_address = $api_response['ip'];
      $city = $api_response['city'];
      $region = $api_response['region'];
      $longhitude = $api_response['loc'];
      $isp_used = $api_response['org'];


     // CREATING A INSERT TO TABLE EVERY USER VISITED THE PAGE

     global $wpdb;

     $timezone  = +8; //(GMT +8:00) Philippines
     ///$timenow = gmdate("H", time() + 3600*($timezone+date("I")));
     $timenow = gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));

     //INSERT DATA TO THE DATABASE
   //   $insertdata = $wpdb->insert('ip_location_data',
   //   array(
   //     'ip_address' => $ip_address,
   //     'city' => $city,
   //     'region' => $region,
   //     'longhitude' => $longhitude,
   //     'isp_used' => $isp_used,
   //     'datetime' => $timenow
   //   )
   // );

 ?>
 <html>
 <head>
    <style>
  .diba{

    margin: 0 auto;
    box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
    padding:10px;
    width: 30%;
    border: 3px solid #0693e3;
  }
  form{
    height: 700px;
  }


  @media only screen and (max-width: 1200px) {
   .diba{
       width: 50% !important;
   }

   form{
     height: 700px !important;
   }
}


  </style>

  <script src=
       "https://www.google.com/recaptcha/api.js" async defer>
   </script>


 </head>


  <div class="diba" >
      <form  method="post" style="margin: 0 auto; width: 100%;">
        <br>

        <div class="form-control">
            <label for="fullname">Full Name (Surname, First Name, Middle Name) <br>
              (e.g., Dela Cruz, Juan C.) </label>

                <input type="text" name="fullname" class="form-control">
                <label for="address">Address </label>
                <input type="text" name="address" class="form-control">
                <label for="phone">Phone </label>
                <input type="text" name="phone" class="form-control">
                <label for="question">Do you know a person who has been sexually abused online?  </label>

                <table style="width:20%">
                  <tr>

                    <td>
                      <input type="radio" id="Yes" name="question" value="Yes">
                      <label for="html">Yes</label>
                    </td>
                    <td>
                      <input type="radio" id="No" name="question" value="No">
                      <label for="No">No</label>
                    </td>
                  </tr>
                </table>


                <label for="reason">Reason for wanting to join the movement </label>
                <input type="text" name="reasons" class="form-control">


        </div>
        <br>

           <input name="form_nonce" type="hidden" value="<?=wp_create_nonce('caloocan-nonce')?>" />

           <!-- div to show reCAPTCHA -->
            <div class="g-recaptcha"
                data-sitekey="6LesjZciAAAAAFdLOmvdKAbbdlOa8XJXn_n3ReYp" style="width:auto !important">
            </div>
            <br>

        <button type="submit" name="submits" >Submit</button>
          <br>
      </form>
  </div>



  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 </html>


<?php


if (isset($_POST['submits'])){


  $nonce = $_POST['form_nonce'];

  if (!wp_verify_nonce($nonce,'caloocan-nonce'))

  {
     wp_redirect( "http://iscphack2022.elementfx.com/",  302 );

  }else

  {



//  echo $message;

  //API LINK
 $apilink = "http://ipinfo.io/";

 //CREATING A FULL API LINK TO DISPLAY THE DATA OF THE CURRENT USER
 $apiUrl =  $apilink . getUserIpAddr() . '?token=8e5b76a114f4eb';

 // GET THE API RESPONSE
 $response = wp_remote_get($apiUrl);

 // DECODE AND DISPLAY THE DATA
 $api_response = json_decode( wp_remote_retrieve_body( $response ), true );

 //var_dump($api_response);


   //DECLARING ALL THE NEEDED DATA

    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $phone =  $_POST['phone'];
    $abused_report =  $_POST['question'];
    $reasons =  $_POST['reasons'];


   // CREATING A INSERT TO TABLE EVERY USER VISITED THE PAGE

   global $wpdb;

   $timezone  = +8; //(GMT +8:00) Philippines
   ///$timenow = gmdate("H", time() + 3600*($timezone+date("I")));
   $timenow = gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));


  //INSERT DATA TO THE DATABASE
  $insertdata = $wpdb->insert('memberships',
  array(
    'fullname' => $fullname,
    'address' => $address,
    'phone' => $phone,
    'abused_report' => $abused_report,
    'reasons' => $reasons,
    'datetime' => $timenow

  )
);

 if($insertdata == true){

   echo "<script language = javascript>
             swal.fire({
             icon: 'success',
             title: 'Your Application Has Been Sent!',
             text: 'Thank you we will work it, Please wait a reply from us Thank you!.',
             type: 'success',
             showCancelButton: false,
             closeOnConfirm: false,
             confirmButtonText: 'Confirm',
             showLoaderOnConfirm: true })
             .then(function() {

                   window.location = 'http://iscphack2022.elementfx.com/';

               });

         </script>";
 }else{
   //
   echo "error";
 }

}

}

?>
 <?php

 get_footer( );

 ?>
