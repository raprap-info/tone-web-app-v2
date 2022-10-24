<?php
/**
*Plugin Name: RapRap Plugin Grab Template
*Description: This will be our template them grabbing plugin
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}else{



function my_template_array()
{
  $temps = [];
  $temps['caloocanhacks.php'] = "HACKS 2022 TEMPLATE";
  $temps['caloocanhackz_dashboard.php'] = "DASHBOARD TEMPLATE";
  $temps['api_caloocanhackz.php'] = "ALL DATA API";
	$temps['statistic_reports.php'] = "STATISTIC REPORTS PAGE";
	$temps['upload_photo.php'] = "UPLOAD PHOTOS";
	$temps['become_a_member.php'] = "BECOME A MEMBER";
	$temps['jointone_dashboard.php'] = "JOIN TONE DASHBOARD";
	$temps['tone_all_data_information_manipulation.php'] = "ALL DATA MANIPULATION";
	$temps['geolocation_confirm.php'] ="GEOLOCATION CONFIRM";
	$temps['mainpage.php'] = "MAIN PAGE TONE";



  return $temps;
}


function my_template_register($page_templates, $theme, $post)
{
  $templates = my_template_array();

  foreach ($templates as $tk=>$tv)
  {
      $page_templates[$tk] = $tv;
  }
  return $page_templates;
}

add_filter('theme_page_templates','my_template_register',10,3);

function my_template_select($template)
{
  global $post, $wp_query, $wpdb;

  $page_temp_slug = get_page_template_slug( $post->ID);

  $templates = my_template_array();

  if(isset($templates[$page_temp_slug]))
  {
    $template = plugin_dir_path(__FILE__).'templates/' .$page_temp_slug;



  }
  return $template;

  // echo '<pre>Preformatted:';print_r($page_temp_slug); echo'</pre>';
}





add_filter('template_include','my_template_select', 99);




} //closing tag for abspath
