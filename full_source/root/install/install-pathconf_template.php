<form method="post" action="<?= $_SERVER['PHP_SELF'] ?>?step=ready">
<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<h5 class="titre">Site ID and Paths configuration </h5>
<div style="padding:5px">
<strong>Please fill with proper data. </strong>
<div>
<p>Please read the Documentation about Site ID and paths. You SHOULD edit manually the path of the libraries.</p>
</div>

<table style="width:100%;margin:0;float:center;margin:auto;">
  <tr>
    <td width="130" style="text-align:right;width:auto; vertical-align:top">Site ID: </td>
    <td><input <?php if($_SESSION['error_siteid']) echo 'class="incorrect"'; ?>type="text" name="site_id" value="<?php echo sha1("$sitename " . time() . $_SERVER['PHP_SELF']); ?>" style="width:100%;text-align:left" /><br />
	<label><input type="checkbox" name="site_id_default" value="1" checked="checked" />
	Use default Site ID (recommended). </label></td>
  </tr>
  <tr>
    <td style="text-align:right;width:auto">DPortal Absolute path: </td>
    <td><input type="text" name="dportal_absolute_path"  value="<?php echo $dportal_absolute_path; ?>" style="width:100%;text-align:left" readonly="readonly" /></td>
  </tr>
  <tr>
    <td style="text-align:right;width:auto">DocumentRoot: </td>
    <td><input <?php if($_SESSION['error_documentroot']) echo 'class="incorrect"'; ?>type="text" name="document_root" value="<?php echo $_SESSION['documentroot']; ?>" style="width:100%;text-align:left" /></td>
  </tr>
  <tr>
    <td style="text-align:right;width:auto">Libraries path: </td>
    <td><input <?php if($_SESSION['error_libs_dir']) echo 'class="incorrect"'; ?>type="text" name="libs_dir" value="<?php echo $_SESSION['libs_dir']; ?>" style="width:100%;text-align:left" /></td>
  </tr>
</table>
</div>
</div>

<div style="float:center;margin:auto;text-align:center">
  <input name="submit" type="submit" style="font-size:22px" value ="    Next step    " />
</div>

</form>

</div>
</body>
</html>