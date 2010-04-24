<?php //if(!defined('INSTALLER')) die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DPortal CMS/DBlog installer</title>
<link rel="stylesheet" type="text/css" href="default.css" />
</head>

<body>

<div style="width:600px;margin:auto">
<h1 style="margin:10px">DPortal CMS install</h1>

<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<h5 class="titre">Information</h5>
<div style="padding:5px">
<p><strong>Error!</strong></p>
<p>The following direcorries should be <strong>writable</strong> in order to install <strong>DPortal CMS</strong>:</p>
<ul>
	<li>/config</li>
	<li>/content</li>
	<li>/comments</li>
	<li>/entries</li>
	<li>/images/gallery</li>
	<li>/videos</li>
	<li>/smarty/templates_c</li>
	<li>/smarty/cache</li>
	<li>/backups</li>
	<li>/updates</li>
</ul>

<p>Please review if above folders have the proper permissions to write, in order to create the files for content and configuration.</p>


<p style="font-size:15px;text-align:center"><a href="<?= $_SERVER['PHP_SELF']; ?>">Retry</a></p>

</div>
</div>
</body>
</html>
