<?php
/**
 * @package VideoJS
 * @version 1.0
 */
/*
Plugin Name: HTML5 Video Player using VideoJS
Plugin URI: http://videojs.com/
Description: A video plugin for WordPress built on the VideoJS HTML5 video player library. Allows you to embed video in your post or page using HTML5 with Flash fallback support for non-HTML5 browsers.
Author: Steve Heffernan
Version: 1.0
Author URI: http://steveheffernan.com
License: LGPLv3
*/

function add_videojs_header(){
  $dir = WP_PLUGIN_URL.'/video-js-wp/video-js/';
  echo <<<_end_
  <link rel="stylesheet" href="{$dir}video-js.css" type="text/css" media="screen" title="Video JS" charset="utf-8">
  <script src="{$dir}video.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" charset="utf-8">
    window.onload = function(){
      VideoJS.setup();
    }
  </script>
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
  if ($mp4) {
    $mp4_source = '<source src="'.$mp4.'" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\'>';
    $mp4_link = '<a href="'.$mp4.'">MP4</a>';
  }

  // WebM Source Supplied
  if ($webm) {
    $webm_source = '<source src="'.$webm.'" type=\'video/webm; codecs="vp8, vorbis"\'>';
    $webm_link = '<a href="'.$webm.'">WebM</a>';
  }

  // Ogg source supplied
  if ($ogg) {
    $ogg_source = '<source src="'.$ogg.'" type=\'video/ogg; codecs="theora, vorbis"\'>';
    $ogg_link = '<a href="'.$ogg.'">Ogg</a>';
  }

  if ($poster) {
    $poster_attribute = 'poster="'.$poster.'"';
    $image_fallback = <<<_end_
      <!-- Image Fallback -->
      <img src="$poster" width="$width" height="$height" alt="Poster Image" title="No video playback capabilities." />
_end_;
  }

  if ($preload) {
    $preload_attribute = "preload";
    $flow_player_preload = ',"autoBuffering":true';
  }

  if ($autoplay) {
    $autoplay_attribute = "autoplay";
    $flow_player_autoplay = ',"autoPlay":false';
  }

  $videojs .= <<<_end_

    <!-- Begin VideoJS -->
    <div class="video-js-box">
      <!-- Using the Video for Everybody Embed Code http://camendesign.com/code/video_for_everybody -->
      <video class="video-js" width="{$width}" height="{$height}" {$poster_attribute} controls {$preload_attribute} {$autoplay_attribute}>
      {$mp4_source}
      {$webm_source}
      {$ogg_source}
      <!-- Flash Fallback. Use any flash video player here. Make sure to keep the vjs-flash-fallback class. -->
      <object class="vjs-flash-fallback" width="{$width}" height="{$height}" type="application/x-shockwave-flash"
        data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
        <param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" />
        <param name="allowfullscreen" value="true" />
        <param name="flashvars" value='config={"clip":{"url":"$mp4" $flow_player_autoplay $flow_player_preload }}' />
        {$image_fallback}
      </object>
    </video>
    <!-- Download links provided for devices that can't play video in the browser. -->
    <p class="vjs-no-video"><strong>Download Video:</strong>
      {$mp4_link}
      {$webm_link}
      {$ogg_link}
      <br>
      <!-- Support VideoJS by keeping this link. -->
      <a href="http://videojs.com">HTML5 Video Player</a> by <a href="http://videojs.com">VideoJS</a>
    </p>
  </div>
  <!-- End VideoJS -->

_end_;

  return $videojs;

}
add_shortcode('video', 'video_shortcode');

?>
