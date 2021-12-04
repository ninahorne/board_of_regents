=== Plugin Name ===
Contributors: localsync, dark-prince
Donate link: https://revmakx.com
Tags: clone, migrate, local sync, local site, dev site, duplicate site, duplicator, cloning, migration, simple cloning, easiest cloning, free cloning
Requires at least: 3.0.1
Tested up to: 5.7
Stable tag: 1.0.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Clone live site to the local site and vice versa.

== Description ==

LocalSync provides you the easiest way to clone or migrate a site from one server to another in the click of a button.<br>

== Why LocalSync? == 

<h2><strong>Simplest Cloning Tool</strong></h2>Just install the LocalSync plugin on the destination site and the live site and start syncing, no need to enter FTP details.<br><br>
<h2><strong>Incremental Cloning</strong></h2>Only the changed files are cloned from the source site to the destination site. So the cloning process is faster.<br><br>
<h2><strong>Load Images From Live Site</strong></h2>With LocalSync you can directly load the images of Live site, so that you do not need to copy media files which will save a lot of time during the cloning process.<br><br>
<h2><strong>Clone Live Site To Local Computer</strong></h2>With LocalSync you can clone any production site to your Local Computer (MAMP, LAMP, XAMP, etc..).

== Installation ==

1. Spin off a WP site on the local server or any online servers.
2. Install "Local Sync Plugin" on the WP site created as mentioned above and activate it.
3. Go to "Local Sync Settings" and select "This is local site" button.
4. Install Local Sync Plugin on the live WP site.
5. Go to "Local Sync Settings" and select "This is prod site" button.
6. Login with your Local Sync account (created on https://localsync.io) on the live WP site.
7. Copy the prod key and go to the Local Sync Settings on the local WP site.
8. Paste the prod key, and Add Site.
9. Now you are ready to perform the sync operations from the Local Site.

== Screenshots ==

1. Local Site settings page.

== Frequently Asked Questions ==

= Can I clone the site to any server instead of the local server? =

Yes you can clone the live site to any proper WP site setup in any servers.

= Where is the documentation for your plugin? =

Visit <a href="https://docs.localsync.io">https://docs.localsync.io</a> for the documentation.

== Changelog ==

= 1.0.5 =
*Release Date - 22 Apr 2021*

* Fix : Not able to install LocalSync plugin on WPTimeCapsule's staging site.
* Fix : Not able to include, exclude Files/Folders on WPTimeCapsule plugin settings page when LocalSync plugin is active.

* Improvement : LOCAL_SYNC_DOWNLOAD_CHUNK_SIZE constant is introduced.
* Improvement : LOCAL_SYNC_UPLOAD_CHUNK_SIZE constant is introduced.

= 1.0.4 =
*Release Date - 12 Apr 2021*

* Fix : False positive virus warning by Windows Defender.
* Fix : Not able to get file data for downloading the file in a few cases.

* Improvement : Tested upto WordPress 5.7.

= 1.0.3 =
*Release Date - 28 Feb 2020*

* Improvement : Calculating modified files logic improved.

= 1.0.2 =
*Release Date - 21 Feb 2020*

* Fix : Pages built with elementor collapsed after cloning, in some cases.
* Fix : Replacing site URL failed, in some cases.
* Fix : Syncing on Windows OS failed.

* Improvement : Excluding few unnecessary DB tables by default.

= 1.0.1 =
*Release Date - 17 Feb 2020*

* Improvement : Major improvements.

= 1.0 =
* First Version

== Upgrade Notice ==

= 1.0 =
First Version
