<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<h5 class="titre">Ready to install</h5>
<div style="padding:5px">
  <p>You are ready to install DPortal CMS. If the following information is correct, press Install. Elsewhere, press Reset to start over.</p>
  <p><strong>Warning</strong>: Unless you selected Default Site ID, you SHOULD copy or rename the content directory &quot;libs/dportalcms_default&quot; with the Site ID given bellow (change the &quot;default&quot; in the directory name to the site ID).</p>
</div>

<div style="text-align:left;margin: 10px auto 0 auto">
  <div style="text-align:center">
  <table width="100%" border="0" style="margin:auto">
    <tr>
      <th style="text-align:right">Sitename:&nbsp;</th>
      <td style="text-align:left"><?php echo $sitename; ?></td>
	</tr>
    <tr>
      <th style="text-align:right">Site description:&nbsp;</th>
      <td style="text-align:left"><?php echo $site_desc; ?></td>
	  </tr>
    <tr>
      <th style="text-align:right">Admin Email:&nbsp;</th>
      <td style="text-align:left"><?php echo $admin_email; ?></td>
	</tr>
    <tr>
      <th style="text-align:right">Use canonical URLs:&nbsp;</th>
      <td style="text-align:left"><?php if($use_rewrite){ echo Yes; }else{ echo No; } ?></td>  
	  </tr>
    <tr>
      <th style="text-align:right">Username:&nbsp;</th>
      <td style="text-align:left"><?php echo $user; ?></td>
	</tr>
    <tr>
      <th style="text-align:right">Nick (optional):&nbsp;</th>
      <td style="text-align:left"><?php echo $nick; ?></td>
	</tr>
    <tr>
      <th style="text-align:right">phpBB directory:&nbsp;</th>
      <td style="text-align:left"><?php echo $phpbb_dir; ?></td>
	</tr>
    <tr>
      <th style="text-align:right">Site ID:&nbsp;</th>
      <td style="text-align:left"><?php echo $site_id; ?></td>
	</tr>
	<tr>
      <th style="text-align:right">DPortal Absolute path:&nbsp;</th>
      <td style="text-align:left"><?php echo dirname(dirname(__FILE__)); ?></td>
	</tr>
	<tr>
      <th style="text-align:right">DocumentRoot:&nbsp;</th>
	  <td style="text-align:left"><?php echo $document_root; ?></td>
	</tr>
	<tr>
      <th style="text-align:right">Libraries path:&nbsp;</th>
      <td style="text-align:left"><?php echo $libs_dir; ?></td>
	</tr>
	<tr>
      <th style="text-align:right">Memcached:&nbsp;</th>
      <td style="text-align:left"><?php if(!empty($memcached_server)){ echo "Enabled"; }else{ echo "Disabled"; } ?></td>
	</tr>
	<?php if(!empty($memcached_server)){ ?>


	<tr>
      <th style="text-align:right">Memcached server:&nbsp;</th>
      <td style="text-align:left"><?php echo $memcached_server; ?></td>
	</tr>
	<tr>
      <th style="text-align:right">Memcached port:&nbsp;</th>
      <td style="text-align:left"><?php echo $memcached_port; ?></td>
	</tr>
	<?php } ?>
  </table>
  </div>
</div>

<div style="float:center;margin:20px;text-align:center;font-size: 15px">
  <a href="<?= $_SERVER['PHP_SELF'] ?>?INSTALL">Install</a> | <a href="<?= $_SERVER['PHP_SELF'] ?>?START_OVER">Start over</a>
</div>

</div>

</div>
</body>
</html>