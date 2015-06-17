=== Plugin Name ===
Contributors: vuzzu
Tags: sidebar, widget, area
Requires at least: 2.2.0
Tested up to: 4.2.2
Stable tag: 4.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple Sidebar Manager helps you to manage the sidebars with ease.

== Description ==

By installing and activating Simple Sidebar Manager, the plugin will add 2 pages on Wordpress admin and a metabox to post/page form.
The settings page located below Settings menu of Wordpress with label "Simple Sidebar Manager", this page helps you manage the support of post types of plugin.
The other page labeled "Sidebars" is located right next to Settings menu of Wordpress, in this page you can manage your future dynamic sidebars.

Each registered sidebar, registered dynamically or hard coded will be listed on the metabox titled "Simple Sidebar Manager" which will appear on side panel of the post/page form.

The last touch from your end:
In order to fully function the plugin you/your developer have/has to implement the calls to dynamic sidebar within the sidebar.php file.

Implementation guide:
While you are logged into Wordpress admin navigate to Plugins > Editor and select Simple Sidebar Manager plugin, after doing so click on sidebar.example.php and you will find 2 examples of calling sidebar using bootstrap css framework, you can grab a block of code which one you want to use, copy and paste it into the sidebar.php file located in root directory of your current theme. You must be sure you are not breaking anything, keep a backup file of sidebar.php for any occasion so you can revert your changes.


== Installation ==

1. Upload `simple-sidebar-manager` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Read the implementation guide above

== Screenshots ==

1. The settings page where you can extend the support of post type.
2. Sidebars page is the page where you can manage your dynamic sidebars (widget areas).
3. The metabox on the sidepanel of post/page form.
