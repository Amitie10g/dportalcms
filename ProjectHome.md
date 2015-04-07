# DPortal CMS #

**_Updates and Bugfixes at jul 10 2011 (Dportal Blog published)_**

## Downloads and Updates via SVN ##

DPortal CMS is available in SVN. You can download the full source (the same contents in the Traball), or only the updated files (that may change frequently).

**Download now and check/update the code via SVN:**

> `svn checkout http://dportalcms.googlecode.com/svn updates`

**Full source via SVN (same contents than Tarball):**

> `svn checkout http://dportalcms.googlecode.com/svn full_source`

**DPortal Blog is also available via SVN (does NOT include Smarty!):**

> `svn checkout http://dportalcms.googlecode.com/svn dportal_blog`

**Important:**

After downloading and installing DPortal CMS, you should check and update the code via SVN in order to fix bugs. Actual versions will be published periodically, and code updates and bug fixes will be tosted to SVN.

## Description ##

**DPortal CMS** is a simple **Content Management System** written in **PHP**, Free and Open Source, that **does not need a Database engine**. Instead, use **Plain text** files and CSV and INI config files. This CMS uses **Smarty Template engine** and other free third party libraries.

I admit, I have obtained many pieces of code for building this Porject, but this is the spirit of the Free Software: Reutilize the code.

This Project is not intended to compete or be a replacement for most popular CMS as **Joomla!** or **Drupal**. I only provide a simple solution for communities and developers that find a "Not-database-dependient" CMS, and I hope that this CMS will be usefull for everyone.


## Features: ##

  * Really easy to install and manage.
  * Use **Plain text** files instead **Database engine**.
  * Integrated with **phpBB3**.
  * Nice **Dock-like** Javascript menu (accessible).
  * **Categories support** and **dinamicaly created** menu.
  * **Feed sindication** and for Blog and Gallery and **XML Sitemap** generator for Sections.
  * **Memcached** support.
  * **Free Software**.


## Includes ##

  * **Portal**, with editable pages (you can create your own pages).
  * **Blog**, where you can post your daily life. Includes **Atom Feed** with full or limited entries(summary of each), and Feed for the entry (summary).
  * **Image Gallery**, easy to configure and with FEED.
  * **Media player**, where you can publish videos with Streaming support (requires FFMPEG libraries).
  * And, of course, the **Control panel** (required).

You can install all or many of these modules. Other subprojects as DBlog will be provided in a separate package.

**Important notes:**

  * **Scripts and libraries**, for security reasons, should be placed in separated directories. config, content and others sensible directories should be places OUTSIDE to public access (DOCUMENT\_ROOT). Also, before installing **DPortal CMS** you may to edit **/includes/constants.php** file to point correctly to Directories for configuration, content and public access scripts. See Documentation for more indormation.

  * **Smarty** WILL NOT BE INCLUDED in future releases. Please [download and install the latest stable version of Smarty](http://www.smarty.net/download.php) yourself (**Smarty2**, **Smarty3** is not tested!!!), or ask to your Webserver administator how to install Smarty. Also, Smarty is available as part of Debian distribution ([smarty](http://packages.debian.org/squeeze/smarty); [smarty-gettext](http://packages.debian.org/squeeze/smarty-gettext) and [smarty-validate packages](http://packages.debian.org/squeeze/smarty-validate) are optionals).

  * **TinyMCE**, for comfort reasons, is included (especifically, tinymce\_3.3.2). Please update if necesary. See Documentation for more information. Also, TinyMCE is part of the Debian distribution ([tinymce](http://packages.debian.org/squeeze/tinymce) or [tinymce2](http://packages.debian.org/squeeze/tinymce2)).

  * **Highslide JS** is user for display the Image gallery, but is not included, and you may to download and install separatelly. You can install Highslide JS in the DPortal CMS root directory; DPortal CMS is ready to use Highslide JS when installed. Also, you can use your own Gallery (including Flash) by using the Feed of each gallery. You can download Highslide JS form the official Website, http://highslide.com/

## Developement ##

Currently, the program has not a regular **Version number**, because is **still in development** and may contains many Bugs and inconsistences.
A version dev indicates that is in developement. A date (31-08) indicates the Date of release. I publish only Updates (updates-only) weekly (or more than once per week), and monthly I will to publish **Full releases** of the Developement version.

I appreciate you try this program in your Website.

**Please report Bugs.**