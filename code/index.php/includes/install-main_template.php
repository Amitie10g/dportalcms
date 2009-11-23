<?php //if(!defined('INSTALLER')) die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Instalar DPortal CMS/DBlog</title>
<link rel="stylesheet" type="text/css" href="default.css" />

<script type="text/javascript" src="{{$smarty.const.DPORTAL_PATH}}/external_links.js"></script>

<script type="text/javascript">
      <!--
      function items(id){
         var obj = document.getElementById('item_' + id)
         if(obj.style.display == 'block') obj.style.display = 'none'
         else obj.style.display = 'block'
      }

      //-->
</script>
 
	<style type="text/css">
       .titleItem{
          cursor: pointer;
          font-weight: bold;
          text-align:center;
       }
       .content{
          font-weight: normal;
          margin:0;
          padding:0;
          display:none;
		  background:#cccccc;
		  border:none;
       }
       .content p{
          margin: 3px;
       }
	   
	   .incorrect {
		background:#AA5555;
	   }
	   tr.incorrect{
	   	padding:10px 0 !important;
	   }
	</style>

</head>

<body>

<div style="width:600px;margin:auto">
<form method="post" action="install.php?INSTALL">
<h1 style="margin:10px">DPortal CMS installer </h1>

<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<h5 class="titre">General information </h5>
<div style="padding:5px">
<p><strong>Thanks to test DPortal CMS in your Website. This one-step installer install this CMS quickly .</strong></p>
<p>If you use <strong>phpBB3</strong>, please be sure to Login with the Administrator account before continue.</p>
<p>This program is still in developement, but currently is suitable for personal and community Websites. I Strongly recommended to do not install in comercial Websites. Please read the files README and LICENSE for more details. </p>
</div>
</div>

<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<h5 class="titre">Website configuration </h5>
<div style="padding:5px">
<a href="#top" onclick="items(1)" title="Show/hide information"><strong>Please indicate a Sitename and description</strong></a>
<div id="item_1" class="content">
<p>The Sitename is the Name that is displayed in Title, and must be short. The Site description is a Description of your Website, and must be clear. That appears in META Description tag. </p>

<p>If your server supports <strong>mod_rewrite</strong>, you can enable Canonical URLs by enable the Checkbox.</p>
<p>Sitename must have between 5 to 20 characters,l and can be have spaces. Special characters (tildes, etc) will be converted to HTML Entities (6 characters instead 1). Actually, 30 characters are allowed (included HTML entities), but the INPUT allows only 20.</p>
<p>Site description must have between 5 to 100 characters, and don't be null. </p>
</div>
<table style="width:350px;margin:0;float:center;margin:auto;">
  <tr>
    <td style="text-align:right">Sitename: </td>
    <td><input <?php if($error_data != null &&  !$error_data['check_site']) echo 'class="incorrect"'; ?>type="text" name="sitename" value="<?php if($error_data['sitename']) echo $error_data['sitename']; ?>" style="width:100%" /><?php if($error_data != null &&  !$error_data['check_site']) echo "<br />\nPlease fill with the correct data"; ?></td>
  </tr>
  <tr>
    <td style="text-align:right">Descriptión</td>
    <td><input <?php if($error_data != null &&  !$error_data['check_sitedesc']) echo 'class="incorrect"'; ?>type="text" name="sitedesc" value="<?php if($error_data['check_sitedesc']) echo $error_data['sitedesc']; ?>" style="width:100%" /><?php if($error_data != null &&  !$error_data['check_sitedesc']) echo "<br />\nPlease fill with the correct data"; ?></td>
  </tr>
  <tr>
    <td colspan="2" style="text-align:center"><p><label><input type="checkbox" name="use_rewrite" value="true" />
    Use Canonical URLs  (<strong>mod_rewrite</strong>)</label>
    </p></td>
    </tr>
</table>
</div>
</div>

<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<h5 class="titre">User data </h5>
<div style="padding:5px">
<a href="#top" onclick="items(2)" title="Show/hide information"><strong>The User and Password for access</strong></a>
<div id="item_2" class="content">
<p>Please indicate an <strong>Username and password</strong>. This is obligatory, but if you use phpBB3, the Administrator account of <strong>phpBB3</strong> will be used for Login instead of the integrated account.</p>
<p>Username must  have between 3 to 15 characters. Only alphanumeric, spaces and '-' and '_' are allowed.</p>
<p>Password can have any characters, between 5 to 20.</p>
</div>
<table style="width:350px;margin:0;float:center;margin:auto;">
  <tr>
    <td style="text-align:right">Username: </td>
    <td><input <?php if($error_data != null &&  !$error_data['check_user']) echo 'class="incorrect"'; ?>type="text" name="user" value="<?php if($error_data['user']) echo $error_data['user'] ?>" style="width:100%" /><?php if($error_data != null &&  !$error_data['check_user']) echo "<br />\nPlease fill with the correct data"; ?></td>
  </tr>
  <tr>
    <td style="text-align:right">Password: </td>
    <td><input <?php if($error_data != null &&  !$error_data['check_pass']) echo 'class="incorrect"'; ?>type="password" name="password" style="width:100%" /><?php if($error_data != null &&  !$error_data['check_pass']) echo "<br />\nPlease fill with the correct data"; ?></td>
  </tr>
</table>
</div>
</div>

<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<h5 class="titre">phpBB3 integration </h5>
<div style="padding:5px">
<a href="#top" onclick="items(3)" title="Show/hide information"><strong>phpBB path</strong></a>
<div id="item_3" class="content">
<p>If you use <strong>phpBB3</strong>, you must fill the following with the full path to your Forum, relative to the DocumentRoot of your Website (ex /forum/).</p>
<p>The path must have slashes in extremes of the string (ex '/<em>forum</em>/' or '/site/forum/'. If you din't want to use phpBB3, you can leave empty. </p>
</div>
<table style="width:350px;margin:0;float:center;margin:auto;"  cellspacing="0">
  <tr>
    <td style="text-align:right">Path to phpBB</td>
    <td><input <?php if($error_data != null &&  !$error_data['check_phpbb_dir']) echo 'class="incorrect"'; ?>type="text" name="phpbb_dir" value="<?php if($error_data['check_phpbb_dir']) echo $error_data['phpbb_dir'] ?>" style="width:100%" /><br /><?php if($error_data != null &&  !$error_data['check_phpbb_dir']) echo 'Please fill with the correct data.'; ?></td>
  </tr>
</table>
</div>
</div>
<div style="float:center;margin:auto;text-align:center"><input type="submit" value ="    Install!    " style="font-size:22px" /></div>
</form>
</div>
</body>
</html>
