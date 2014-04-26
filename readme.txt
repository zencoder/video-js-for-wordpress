=== Video.js - HTML5 Video Player for Wordpress ===
Contributors: nosecreek, Steve Heffernan, schnere
Donate link: http://ncrk.ca/videojs
Tags: html5, video, player, javascript
Requires at least: 2.7
Tested up to: 3.9
Stable tag: 4.5.0
License: LGPLv3
License URI: http://www.gnu.org/licenses/lgpl-3.0.html

Self-hosted responsive HTML5 video for WordPress, built on the widely used Video.js HTML5 video player. Embed video in your post or page using HTML5.

== Description ==

A video plugin for WordPress built on the Video.js HTML5 video player library. Allows you to embed video in your post or page using HTML5 with Flash fallback support for non-HTML5 browsers.

View [videojs.com](http://videojs.com) for additional information.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the `videojs-html5-video-player-for-wordpress` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the [videojs] shortcode in your post or page using the following options.

##Video Shortcode Options
-------------------------

### mp4
The location of the h.264/MP4 source for the video.
    
    [videojs mp4="http://video-js.zencoder.com/oceans-clip.mp4"]

### ogg
The location of the Theora/Ogg source for the video.

    [videojs ogg="http://video-js.zencoder.com/oceans-clip.ogg"]

### webm
The location of the VP8/WebM source for the video.

    [videojs webm="http://video-js.zencoder.com/oceans-clip.webm"]
    
### youtube
The location of the YouTube source for the video.

    [videojs youtube="http://www.youtube.com/watch?v=DJU6ppZAaec"]

### poster
The location of the poster frame for the video.

    [videojs poster="http://video-js.zencoder.com/oceans-clip.png"]

### width
The width of the video.

    [videojs width="640"]

### height
The height of the video.

    [videojs height="264"]

### preload
Start loading the video as soon as possible, before the user clicks play.
Use 'auto', 'metadata', or 'none'. Auto will preload when the browser or device allows it. Metadata will load only the meta data of the video.

    [videojs preload="auto"]

### autoplay
Start playing the video as soon as it's ready. Use 'true' or 'false'.

    [videojs autoplay="true"]

### loop
Causes the video to start over as soon as it ends. Use 'true' or 'false'.

    [videojs loop="true"]

### controls
Use 'false' to hide the player controls.

    [videojs controls="false"]

### muted
Use 'true' to initially mute video.

    [videojs muted="true"]
        
### id
Add a custom ID to your video player.

    [videojs id="movie-id"]
    
### class
Add a custom class to your player. Use full for floating the video player using 'alignleft' or 'alignright'.

    [videojs class="alignright"]

### Tracks
Text Tracks are a function of HTML5 video for providing time triggered text to the viewer. To use tracks use the [track] shortcode inside of the [video] shortcode. You can set values for the kind, src, srclang, label, and default attributes. More information is available in the [Video.js Documentation](http://videojs.com/docs/tracks/).

    [videojs][track kind="captions" src="http://video-js.zencoder.com/oceans-captions.vtt" srclang="en" label="English" default="true"][/videojs]

### All Attributes Example

    [videojs mp4="http://video-js.zencoder.com/oceans-clip.mp4" ogg="http://video-js.zencoder.com/oceans-clip.ogg" webm="http://video-js.zencoder.com/oceans-clip.webm" poster="http://video-js.zencoder.com/oceans-clip.png" preload="auto" autoplay="true" width="640" height="264" id="movie-id" class="alignleft" controls="false" muted="true"][track kind="captions" src="http://example.com/path/to/captions.vtt" srclang="en" label="English" default="true"][/videojs]
    

##Video.js Settings Screen
--------------------------
The values set here will be the default values for all videos, unless you specify differently in the shortcode. Uncheck "Use CDN hosted version?" if you want to use a self-hosted copy of Video.js instead of the CDN hosted version. *Using the CDN hosted version is preferable in most situations.*

If you are using a responsive WordPress theme, you may want to check the *Responsive Video* checkbox.

Uncheck the *Use the [video] shortcode?* option __only__ if you are using WordPress 3.6+ and wish to use the [video] tag for MediaElement.js. You will still be able to use the [videojs] tag to embed videos using Video.js.


== Changelog ==

= 4.5.0 =

* Updated to use Video.js 4.5
* Various fixes for YouTube videos
* Changed the way js/css is loaded to allow use of do_shortcode()
* Added Muted option

= 4.3.1 =

* Fixed a bug with YouTube videos

= 4.3.0 =

* Updated to use Video.js 4.3
* Added YouTube plugin for video.js
* Added option to select YouTube video source

= 4.2.0 =

* Changed Video.js version to 4.2
* Removed IE6 support for responsive sites, allowing the removal of black bars from the top/bottom of videos
* Only loads plugin javascript/css on pages where the shortcode is use (Wordpress 3.6+)

= 4.0.0 =

* Updated to use Video.js 4. This is a major update to Video.js so please test this plugin with your site before using it in production. A description of changes in the new version is available at http://blog.videojs.com/post/50021214078/video-js-4-0-now-available.
* Added custom color options to the admin page to allow for easy styling of the player.
* Added a default aspect ratio for responsive videos (16:9).
* Changed the default shortcode to [videojs] (for better compatibility with future WordPress versions).

= 3.2.3 =

* Added a shortcode generator to the tinymce editor
* Added "Using Video.js" section and contextual help to admin screen
* New "Responsive Video" option for sites with a responsive layout
* Enqueue scripts and styles

= 3.2.2 =

* Fixed preload="none".

= 3.2.1 =

* Added support for tracks.
* Added loop support.
* Added the ability to disable controls.
* Fixed a bug with the autoplay attribute.
* Fixed mixed-content warnings on SSL pages.
* Added a license to the plugin folder (LGPLv3).

= 3.2.0 =

* Fixed a bug with the self-hosted option.
* Updated self-hosted files to Video.js 3.2.0.

= 3.0.1 =

* Added an options page to set default values for you video players.
* Added an option to use a self-hosted version of the script instead of the CDN hosted version.
* Added a new class="" option to the shortcode.
* Minor bug fixes.

= 3.0 =

* Completely re-worked for Video.js 3.0, which uses a CDN to host the script and the same HTML/CSS skin and JavaScript API for HTML5 and Flash Video.
* See videojs.com for specific changes to the script.
* Removed files used by old versions of Video.js.

= 2.0.2 = 

* Upgraded to version 2.0.2 of VideoJS. See videojs.com for specific version updates.

= 1.1.3 = 

* Added poster to Flash fallback

= 1.1.2 = 

* Updated to VideoJS 1.1.2
* Fixed the default plugin folder name.
* Fixed an issue with autoplay not working correctly.

= 1.0.1 =

* Updated to latest version of VideoJS

= 1.0 =

* First release.
