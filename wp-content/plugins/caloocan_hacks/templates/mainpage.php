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
<head>
  <style>

     .plus{
      box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
      padding:4%;
      width: 23rem;
     }
     .md{
       font-size:3rem;
     }



     @media only screen and (min-width: 1201px) {
      .cards{
          display:grid;
           grid-template-columns: auto auto auto!important;
           gap:2%;
           width:100%;
      }
      .diba{
          width: 90% !important;
      }

      form{
        height: 700px !important;
      }
    }

     @media only screen and (max-width: 1200px) {
      .cards{
          display:grid;
           grid-template-columns: auto auto!important;
           gap:2%;
           width:100%;
      }
      .diba{
          width: 90% !important;
      }

      form{
        height: 700px !important;
      }
    }

    @media only screen and (max-width: 900px) {
     .cards{
         display:grid;
          grid-template-columns: auto  !important;
          gap:2%;
          width:100%;
     }
     .diba{
         width: 90% !important;
     }

     form{
       height: 700px !important;
     }
   }

    .diba{

      margin: 0 auto;
      box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
      padding:10px;
      width: 30%;
      border: 3px solid #0693e3;
    }
    form{
      height: 600px;
    }




  </style>
</head>
<div class="wibground" style="background-color:black; padding:5%; color:#ffff; opacity: 0.8; margin:0 auto; z-index: 11111; background-image:url('http://tone.x10.bz/wp-content/uploads/2022/10/308094504_473867857854864_6216624982456165007_n-1.png'); height:70vh;width: 100%;background-repeat:no-repeat;  background-position: center; ">
    <div style="z-index:9999999999999999 !important;width:50%;">
      <h2 style="text-align:justify"><br>
        <span style=" font-size: 5rem; margin-left: -5px"> Every child is special. Save Them From The Fear. </span>
    </h2>
    <br>
    <button onclick="location.href='http://tone.x10.bz/report-incident/'" type="button" name="button">Report an Incident</button>

    </div>


</div>
  <br>
<div style="text-align:center;font-size: 2rem">
  <span style="font-size: 3rem; font-weight:bolder">Tone</span> is simply a depiction of two innocent Filipino<br>
   youngsters, 'Toto and Nene.' Victims of sexual exploitation<br>
    online require assistance in raising awareness and bridging the <br>
    reporting gap in the said concern.
</div>


<br>

<div class="cards" style="display:grid; grid-template-columns: auto auto auto;width: 50%; margin: 0 auto">

        <div class="card plus" >
        <img src="http://tone.x10.bz/wp-content/uploads/2022/10/eductae-everyone.png" class="card-img-top" alt="..." style="height:25%;">
        <div class="card-body">
          <h5 class="card-title md">Educate Everyone</h5>
          <p class="card-text">Inform everyone about the online sexual exploitation of youngsters. They can delve deeper and learn that the government has enacted legislation to address this issue.</p>
          <a href="tone.x10.bz/what-is-osec/" class="btn btn-primary">View more</a>
        </div>
      </div>

      <div class="card plus" >
        <img src="http://tone.x10.bz/wp-content/uploads/2022/10/report-a-crime-on-line.jpg" class="card-img-top" alt="..." style="height:25%;">
        <div class="card-body">
          <h5 class="card-title md">Report Incident</h5>
          <p class="card-text">Provide an opportunity for anyone who is aware of a sexual exploitation incident that warrants reporting or raising concerns with the authorities</p>
          <a href="http://tone.x10.bz/report-incident/" class="btn btn-primary">View more</a>
        </div>
      </div>

      <div class="card plus" >
        <img src="http://tone.x10.bz/wp-content/uploads/2022/10/join-the-movement.jpg" class="card-img-top" alt="..." style="height:25%; width:105% !important">
        <div class="card-body">
          <h5 class="card-title md">Join Movement</h5>
          <p class="card-text">Create an organization or movement to help publicize the objective of this website and campaigns to encourage everyone to speak up and allow the government to address these concerns as soon as possible.</p>
          <a href="http://tone.x10.bz/join-tone-movement-and-be-one-of-us/" class="btn btn-primary">View more</a>
        </div>
      </div>
</div>
<br>


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


  <script src=
       "https://www.google.com/recaptcha/api.js" async defer>
   </script>


 </head>

  <body >





  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
      function GeoTrack(){
        Swal.fire({
          title: 'Do you want to Accept?',
          text: 'We do this to make our website more personal and user-friendly For example cookies enable you to submitted a file But your privacy is all that matters So its up to you to decide whether you want to enable or disbale cookies',

          showCancelButton: true,
          confirmButtonText: 'Yes',

        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            Swal.fire('Thank You for confirming!', '', 'success');
          }
        })
      }
  </script>

</body>
 </html>

<?php

if (  isset( $_POST['submits'] ) ) {


          $allowed_extensions = array( 'jpg', 'jpeg', 'png');
          $file_type = wp_check_filetype( $_FILES['wpcfu_file']['name'] );
          $file_extension = $file_type['ext'];

          // Check for valid file extension
          if ( ! in_array( $file_extension, $allowed_extensions ) ) {

            // wp_die( sprintf(  esc_html__( 'Invalid file extension, only allowed: %s', 'theme-text-domain' ), implode( ', ', $allowed_extensions ) ) );
          //   wp_redirect( "https://igsl-portal.igsl.asia",302 );
            //wp_die( '<h1>You need a higher level of permission.</h1><p>Sorry, you are not allowed to manage terms in this taxonomy.</p>' );

          }

          $file_size = $_FILES['wpcfu_file']['size'];
          $allowed_file_size = 5632000; // Here we are setting the file size limit to 500 KB = 500 × 1024

          // Check for file size limit
          if ( $file_size >= $allowed_file_size ) {
            echo "File size limit exceeded ";
          }

        //  These files need to be included as dependencies when on the front end.
          require_once( ABSPATH . 'wp-admin/includes/image.php' );
          require_once( ABSPATH . 'wp-admin/includes/file.php' );
          require_once( ABSPATH . 'wp-admin/includes/media.php' );

          // Let WordPress handle the upload.
          // Remember, 'wpcfu_file' is the name of our file input in our form above.
          // Here post_id is 0 because we are not going to attach the media to any post.
          $attachment_id = media_handle_upload( 'wpcfu_file', 0 );

          if ( is_wp_error( $attachment_id ) ) {

            // There was an error uploading the image.
          //  wp_die( $attachment_id->get_error_message() );

          } else {
            // We will redirect the user to the attachment page after uploading the file successfully.
            $getlinkssst =  get_the_permalink( $attachment_id ) ;

          }


          //echo   $getlinkssst . "xxxxxxxxxxxx";

} //closing tag of if isset



?>
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

    $ip_address = $api_response['ip'];
    $city = $api_response['city'];
    $region = $api_response['region'];
    $longhitude = $api_response['loc'];
    $isp_used = $api_response['org'];


    $incifile = $_POST['reportsfile'];
    $vocontrib  = $_POST['mediums'];
    $message = $_POST['message'];
    $getlinks  = $getlinkssst;

    $website_link = $_POST['website_link'];

   // CREATING A INSERT TO TABLE EVERY USER VISITED THE PAGE

   global $wpdb;

   $timezone  = +8; //(GMT +8:00) Philippines
   ///$timenow = gmdate("H", time() + 3600*($timezone+date("I")));
   $timenow = gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));


  //INSERT DATA TO THE DATABASE
  $insertdata = $wpdb->insert('ip_location_data',
  array(
    'ip_address' => $ip_address,
    'city' => $city,
    'region' => $region,
    'longhitude' => $longhitude,
    'isp_used' => $isp_used,
    'datetime' => $timenow,
    'incident_file' => $incifile,
    'victim_contributor' => $vocontrib,
    'message' => $message,
    'photo_uploaded' => $getlinks,
    'website_link'  => $website_link
  )
);

 if($insertdata == true){

   echo "<script language = javascript>
             swal.fire({
             icon: 'success',
             title: 'Your Report Has Been Sent!',
             text: 'Thank you we will work it right away, Please wait a reply from us Thank you!.',
             type: 'success',
             showCancelButton: false,
             closeOnConfirm: false,
             confirmButtonText: 'Confirm',
             showLoaderOnConfirm: true })
             .then(function() {

                   window.location = 'http://tone.x10.bz';

               });

         </script>";
 }else{

 }

}

}

?>
 <?php

 get_footer( );

 ?>
