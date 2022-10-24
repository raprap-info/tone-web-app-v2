<?php
/**
 * The default template for displaying content
 *
 * Used for both singular and index.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
* @package Bloglog
 * @since 1.0.0
 */

$bloglog_default = bloglog_get_default_theme_options();
$video_autoplay = esc_attr( get_post_meta(get_the_ID(), 'twp_video_autoplay', true) );
if( $video_autoplay == '' || $video_autoplay == 'global' ){

    $video_autoplay = isset($bloglog_home_section->section_video_autoplay) ? $bloglog_home_section->section_video_autoplay : '';
    if( $video_autoplay == '' || $video_autoplay == 'global' ){
        $video_autoplay = get_theme_mod( 'ed_autoplay', $bloglog_default['ed_autoplay'] );
    }

}

$ratio_value = get_post_meta( get_the_ID(), 'twp_aspect_ratio', true );
if( $ratio_value == '' || $ratio_value == 'global' ){
    
    $ratio_value = isset( $bloglog_home_section->section_video_ratio ) ? $bloglog_home_section->section_video_ratio : '';

    if( $ratio_value == '' || $ratio_value == 'global' ){
        $ratio_value = get_theme_mod( 'post_video_aspect_ration', $bloglog_default['post_video_aspect_ration'] );
    }

}

bloglog_video_content_render( $class1 = 'post', $class2 = 'video-id', $class3 = 'video-main-wraper', $ratio_value, $video_autoplay );