<form method="post" action="<?= $_SERVER['PHP_SELF'] ?>?step=path_conf">
<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<a name="site_conf"></a>
<h5 class="titre">Blog  configuration</h5>
<div style="padding:5px">
<a href="#top" onClick="items(1)" title="Show/hide information"><strong>Please indicate a Blog nameand description</strong></a>
<div id="item_1" class="content">
<p>The <strong>Blog name</strong>  is the Name that is displayed in Title and Search engines, and must be short. The Site description is a Description of your Website, and must be clear. That appears in META Description tag.</p>

<p>If your server supports <strong>mod_rewrite</strong>, you can enable Canonical URLs by enable the Checkbox.</p>
<p>Sitename must have between 5 to 20 characters, and can have spaces. Special characters (tildes, etc) will be converted to HTML Entities (6 characters instead 1).</p>
<p>Site description must have between 5 to 100 characters, and shouldn't be null. </p>
</div>
<table style="width:500px;margin:0;float:center;margin:auto;">
  <tr>
    <td style="text-align:right">Sitename: </td>
    <td><input <?php if($_SESSION['error_sitename']) echo 'class="incorrect"'; ?>type="text" name="sitename" value="<?php echo $_SESSION['sitename']; ?>" style="width:100%;text-align:left" /></td>
  </tr>
  <tr>
    <td style="text-align:right">Description: </td>
    <td><input <?php if($_SESSION['error_sitedesc']) echo 'class="incorrect"'; ?>type="text" name="sitedesc" value="<?php echo $_SESSION['site_desc']; ?>" style="width:100%;text-align:left" /></td>
  </tr>
  <tr>
    <td style="text-align:right">Admin email: </td>
    <td><input <?php if($_SESSION['error_email']) echo 'class="incorrect"'; ?>type="text" name="email" value="<?php echo $_SESSION['email']; ?>" style="width:100%;text-align:left" /></td>
  </tr>
  <tr>
    <td style="text-align:right">
      <select name="lang" style="width:90px"title="Select language (default English)">
      <option value="en" selected="selected" disabled="disabled">Language</option>
      <?php 
      
      	foreach(glob(LANG_PATH.'*.ini') as $langfile){
		$lang_content = parse_ini_file($langfile);
      ?><option value="<?= $lang_content['lang_name'] ?>"><?= $lang_content['lang_fullname']?></option>
      <?php } ?>

      </select>
    </td>
    <td style="text-align:center"><p><label><input type="checkbox" name="use_rewrite" value="1" />
    Use Canonical URLs  (<strong>mod_rewrite</strong>)</label>
    </p></td>
    </tr>
</table>
</div>
</div>

<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<h5 class="titre">Memcached support</h5>
<div style="padding:5px">
<a href="#top" onclick="items(50)" title="Show/hide information"><strong>You can enable Memcached support to improve performance.</strong></a>
<div id="item_50" class="content">
<p>To enable Memcached support, please fill the following with the Memcached Server 
("localhost" by default) and the Memcached port (11211 by default).</p>
<p>Leave empty to disable Memcached.</p>
<p><b>Warning:</b> If you enable Memcached here and the parameters are incorrect, or Memcached is not supported by your
Webserver, Smarty Caching will be disabled!</p>
</div>
</div>
<table style="width:500px;margin:0;float:center;margin:auto;">
    <tr>
    <td style="text-align:right;width:135px">Memcached server:</td>
    <td><input type="text" name="memcached_server" style="width:210px;text-align:left" />&nbsp;<b>localhost</b> <em>by default</em></td>
    </tr>
    <tr>
    <td style="text-align:right">Memcached port:</td>
    <td><input type="text" name="memcached_port" style="width:50px;text-align:left" />&nbsp;<b>11211</b> <em> by default</em></td>
    </tr>
</table>
</div>

<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<h5 class="titre">User data</h5>
<div style="padding:5px">
<a href="#top" onclick="items(2)" title="Show/hide information"><strong>The User and Password for access</strong></a>
<div id="item_2" class="content">
<p>Please indicate an <strong>Username and password</strong>. Username must  have between 3 to 15 characters. Only alphanumeric, spaces and '-' and '_' are allowed. Password can have any characters, between 5 to 20.</p>
</div>
<table style="width:500px;margin:0;float:center;margin:auto;">
  <tr>
    <td style="text-align:right">Username: </td>
    <td><input <?php if($_SESSION['error_user']) echo 'class="incorrect"'; ?>type="text" name="user" value="<?php echo $_SESSION['user']; ?>" style="width:100%;text-align:left" /></td>
  </tr>
  <tr>
    <td style="text-align:right">Password: </td>
    <td><input <?php if($_SESSION['error_password']) echo 'class="incorrect"'; ?>type="password" name="password" style="width:100%;text-align:left" /></td>
  </tr>
    <tr>
    <td style="text-align:right">Nick: </td>
    <td><input <?php if($_SESSION['error_nick']) echo 'class="incorrect"'; ?>type="text" name="nick" value="<?php echo $_SESSION['nick']; ?>" style="width:100%;text-align:left" /></td>
  </tr>
</table>
</div>
</div>

<div style="border:2px solid;background:#CCCCCC;padding:2px;margin:0 0 20px 0">
<h5 class="titre">Google CSE </h5>
<div style="padding:5px">
<a href="#top" onClick="items(3)" title="Show/hide information"><strong>Google Custom Search options</strong></a>
<div id="item_3" class="content">
<p>You can use the <strong>Google Custom Search</strong> Element integrated in DPortal Blog. In order to use them, you must provide your Google CSE Key; you can create one in <a href="http://google.com/cse">http://google.com/cse </a></p>
</div>
<table style="width:500px;margin:0;float:center;margin:auto;"  cellspacing="0">
  <tr>
    <td style="text-align:right">Google CSE key : </td>
    <td><input type="text" name="cse_key" value="<?php echo $_SESSION['cse_key']; ?>" style="width:100%" /></td>
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