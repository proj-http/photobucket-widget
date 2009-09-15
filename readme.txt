=== Plugin Name ===
Contributors: freephp
Donate link: http://xfuxing.com/
Tags: photobucket,widget,sidebar,images,gallery,thickbox
Requires at least: 2.7.1
Tested up to: 2.8.4
Stable tag: 0.8

photobucket Widget works as a widget, making very easy for you to embed in sidebars from your photobucket account!

== Description ==

This widget allows you to show pictures from your photobucket account in your blog's sidebar. Install the plugin and make the minimum configurations.

This plug-in from photobucket to get your photos, and generate "Width of photo" px-size square thumbnail saved in your site's directory.The special effects plug-in support "thickbox".If you are using "thickbox" effects, make sure you add the "jQuery" and "thickbox".

Because picasa can not browse in my area, so I turned to photobucket, and the production of this plug-in.

== Installation ==

The plugin is simple to install:

1. Download the zip file
2. Unpack the archive and copy the files into a directory called "photobucket-widget" in your plugin directory (normally .../wp-content/plugins/). That's it!
3. Activate plugin
4. Go to Appearance -> Widgets for configuration. Before using the plugin.

== Frequently Asked Questions ==

= How to get my photobucket feeds url? =

1. login your photobucket.
2. See bottom of the page "Feed for all yourID content" of the Link Properties

= How to set the width of images? =

1. "Width of photo" in option,and use "px" unit.

= Why open a Web page after the installation of plug-in is very slow? =

1. As the plug-in from photobucket to obtain photos and cut into thumbnail pictures exist locally, so for the first time will appear slower when the thumbnail is generated, when after generation will not have this happen.
2. If you are using a period of time after the change of "Width of photo", plug-in will re-generate the thumbnails, this case also slow, but after re-generate the thumbnails, this does not happen again.

= Why are pictures placeholder shape than more I set the "width of photo" ? =

1. The images actual width = "Width of photo" + "Padding of photo" * 2 + "Border of photo" * 2 + "Space between photos" * 2
2. The images actual height = The images actual width

= Where to save thumbnails? =

1. http:// your blog's url / your upload directory /thumb_SHe/

= What is the name of thumbnail? =

1. th_ your set of "width of photo" _ filename of your original image .jpg (eg. th_125_CIMG5798.jpg)

= How to completely uninstall? =

1. Remove "photobucket Widget" in widgets.
2. Deactivate "photobucket Widget" in plugins.
3. Delete "photobucket-widget" in "wp-content/plugins".
4. Delete directory of save thumbnails.
5. Delete "widget_photobucket" in options your database tables.
6. OK,Plug-ins and its subsidiary data has completely disappeared from WordPress of your.

If you have additional questions, please message in my blog, I will reply you as soon as possible, thank you for using "photobucket Widget". Have a nice day.

== Screenshots ==

1. screenshot-1.jpg

== Changelog ==

= 0.9 [SEP 15, 2009] =
* Error Display: "PHP Error: Call to undefined function exif_imagetype()"
* This is because the PHP configuration issue, because not taken into account using the "exif_imagetype" function result.
* Thank "revelc(http://hply.info)" proposed BUG.

= 0.8 [SEP 11, 2009] =
* First release.
