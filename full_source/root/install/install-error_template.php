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
<h1 style="margin:10px">DPortal CMS/DBlog install</h1>

<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<h5 class="titre">Error!</h5>
<div style="padding:5px">
<p>You already has been installed DPortal CMS. Before use DPortal CMS, please remove &quot;install&quot; directory, then, click <strong>Continue</strong>. </p>
<p>If you want to reinstall DPortal CMS, rename or delete the file &quot;config/config.inc.php&quot;  and click <strong>Start over</strong>. Installer will try remove the given file. Elsewhere. you may remove or delete them manually. </p>
<p style="font-size:15px;text-align:center"><a href="../index.php">Return</a> | <a onclick="return confirm('Are you sure to REMOVE &quot;config.inc.php&quot; and start Installation over?');" href="<?php echo $_SERVER['PHP_SELF']; ?>?START_OVER">Start over</a></p>
</div>
</div>
</div>
</body>
</html>
