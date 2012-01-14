<?php
/**
 * @package Video.js
 * @version 3.0
 */
/*
Plugin Name: Video.js - HTML5 Video Player for WordPress
Plugin URI: http://videojs.com/
Description: A video plugin for WordPress built on the widely used Video.js HTML5 video player library. Allows you to embed video in your post or page using HTML5 with Flash fallback support for non-HTML5 browsers.
Author: <a href="http://steveheffernan.com">Steve Heffernan</a>, <a href="http://www.nosecreekweb.ca">Dustin Lammiman</a>
Version: 3.0
*/

function add_videojs_header(){
  echo "";
  echo <<<_end_
  <link href="http://vjs.zencdn.net/c/video-js.css" rel="stylesheet">
  <script src="http://vjs.zencdn.net/c/video.js"></script>
_end_;
}
add_action('wp_head','add_videojs_header');

function video_shortcode($atts){
  extract(shortcode_atts(array(
    'mp4' => '',
    'webm' => '',
    'ogg' => '',
    'poster' => '',
    'width' => '',
    'height' => '',
    'preload' => false,
    'autoplay' => false,
  ), $atts));

  // MP4 Source Supplied
  if ($mp4)
    $mp4_source = '<source src="'.$mp4.'" type=\'video/mp4\' />';

  // WebM Source Supplied
  if ($webm)
    $webm_source = '<source src="'.$webm.'" type=\'video/webm; codecs="vp8, vorbis"\' />';

  // Ogg source supplied
  if ($ogg)
    $ogg_source = '<source src="'.$ogg.'" type=\'video/ogg; codecs="theora, vorbis"\' />';
  
  // Poster image supplied
  if ($poster)
    $poster_attribute = ' poster="'.$poster.'"';
  
  // Preload the video?
  if ($preload)
    $preload_attribute = 'preload="'+$preload+'"';

  // Autoplay the video?
  if ($autoplay)
    $autoplay_attribute = " autoplay";
  else
    $autoplay_attribute = "";

  $videojs .= <<<_end_

  <!-- Begin Video.js -->
  <video class="video-js vjs-default-skin" width="{$width}" height="{$height}"{$poster_attribute} controls {$preload_attribute}{$autoplay_attribute} data-setup="{}">
    {$mp4_source}
    {$webm_source}
    {$ogg_source}
  </video>
  <!-- End Video.js -->

_end_;

  return $videojs;

}
add_shortcode('video', 'video_shortcode');

?>
