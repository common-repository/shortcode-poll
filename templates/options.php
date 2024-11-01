<div class="wrap">
<h2><?php echo strtoupper(self::PLUGIN_NAME) .' '. __('options page',self::CLASS_NAME)?>:</h2>

<form name="form" action="" method="post">
  <p>&nbsp;</p>

<table class="form-table">
  <tr>
		<td width="30"><label ><?php _e('Title',self::CLASS_NAME)?></label></td>
		<td> <input name="title" type="text" value="<?php echo $options["title"]?>" class="regular-text" />
		&nbsp;</td>
	</tr>       
</table>

<p class="submit">
	 <input type="submit" name="submit" value="<?php _e('Save Changes',self::CLASS_NAME)?>" class="button-primary" />
</p>
  </form>
  
<hr />
<p>
<ul>
<li><?php _e("Visit Plugin's page:",self::CLASS_NAME)?> <a href="<?php _e("http://blogwordpress.ws/plugin-shortcode-poll",self::CLASS_NAME) ?>" target="_blank"><?php echo self::PLUGIN_NAME ?></a>
</li>
<li>
<?php _e("Visit Autor's blog:",self::CLASS_NAME)?> <a href="<?php _e('http://blogwordpress.ws',self::CLASS_NAME)?>" target="_blank">Anderson Makiyama</a>
</li>
</ul>
</p>  
</div>