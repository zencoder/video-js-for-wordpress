=== VideoJS for Wordpress ==
Contributors: Steve Heffernan
Tags: html5, video, player, javascript
Requires at least: 2.6
Tested up to: 3.0.1
Stable tag: 1.0

Allows you to embed video in your post or page using HTML5, with Flash fallback support for non-HTML5 browsers.

== Description ==

A video plugin for WordPress built on the VideoJS HTML5 video player library. Allows you to embed video in your post or page using HTML5 with Flash fallback support for non-HTML5 browsers.

View [VideoJS.com](http://videojs.com/) for more information.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the `video-js-wp` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the [video] shortcode in your post or page using the following options.

Video Shortcode Options
-----------------------

### mp4
The location of the h.264/MP4 source for the video.
    
    [video mp4="http://video-js.zencoder.com/oceans-clip.mp4"]

### ogg
The location of the Theora/Ogg source for the video.

    [video ogg="http://video-js.zencoder.com/oceans-clip.ogg"]

### webm
The location of the VP8/WebM source for the video.

    [video ogg="http://video-js.zencoder.com/oceans-clip.ogg"]

### poster
The location of the poster frame for the video.

    [video poster="http://video-js.zencoder.com/oceans-clip.png"]

### width
The width of the video.

    [video width="640"]

### height
The height of the video.

    [video height="264"]

### preload
Start loading the video as soon as possible, before the user clicks play.

    [video preload="true"]

### autoplay
Start playing the video as soon as it's ready.

    [video autoplay="true"]

### All Attributes Example

    [video mp4="http://video-js.zencoder.com/oceans-clip.mp4" ogg="http://video-js.zencoder.com/oceans-clip.ogg" webm="http://video-js.zencoder.com/oceans-clip.webm" poster="http://video-js.zencoder.com/oceans-clip.png" preload="true" autoplay="true" width="640" height="264"]


== Changelog ==

= 1.0 =
* First release.