<?php //if(!defined('INSTALLER')) die(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DPortal CMS installer</title>
<link rel="stylesheet" type="text/css" href="../default.css" />

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
		background:#CC5555;
		color: #FFCCCC;
		font-weight: bold;
		text-align:center;
	   }
	   tr.incorrect{
	   	padding:10px 0 !important;
	   }
	</style>

</head>

<body>

<?php if(!$already_installed && !$installed){ ?>
<div style="width:600px;margin:auto">
<h1 style="margin:10px">DPortal CMS installer</h1>

<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<h5 class="titre">General information </h5>
<div style="padding:5px">
<p><strong>Thanks to test <strong>DPortal Blog</strong>. In few steps you will install your own Blog without DBMS!</strong></p>
<p>Please read carefully the documentation. Them have important information about the installation and the program.</p>
<p>And finally, check if the server have write permissions to the content and configuration files BEFORE install.</p>
<? if(empty($_GET['step'])){ ?>
<p style="text-align:center"><strong><a href="<?php echo $_SERVER['PHP_SELF'] ?>?step=site_conf#site_conf">Next step &gt;&gt;</a></strong></p>
<? } ?>

</div> 
</div>

<? } ?>

<?php if($_SESSION['data_error']){ ?>
<div class="incorrect" style="border:2px #000000 solid;padding:2px;margin:0 0 20px 0">
<h5 class="titre">Errors</h5>
<div style="text-align:left">
<?php if($_SESSION['error_sitename']) echo "* Site Name has incorrect data.<br />\n"; ?>
<?php if($_SESSION['error_sitedesc']) echo "* Site Description has incorrect data.<br />\n"; ?>
<?php if($_SESSION['error_email']) echo "* Admin email has incorrect format.<br />\n"; ?>
<?php if($_SESSION['error_user']) echo "* These Username is not permited.<br />\n"; ?>
<?php if($_SESSION['error_password']) echo "* Password is in incorrect format.<br />\n"; ?>
<?php if($_SESSION['error_nick']) echo "* These Nick has incorrect format.<br />\n"; ?>
<?php if($_SESSION['error_phpbbdir']) echo "* You've entered the path in incorrect formmat.<br />\n"; ?>
<?php if($_SESSION['error_siteid']) echo "* You've entered the Site ID in incorrect format!.<br />\n"; ?>
<?php if($_SESSION['error_documentroot']) echo "* DocumentRoot should be a valid directory name.<br />\n"; ?>
<?php if($_SESSION['error_homedir']) echo "* Home directory should be a valid directory name.<br />\n"; ?>
</div>
</div>
<?php } ?>



<?php if(empty($_GET['step'])){ ?>
</div>
</body>
</html>
<?php } ?>