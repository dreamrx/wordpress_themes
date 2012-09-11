<?php
/*
Theme Name: A9
Version: 1.9.1
File Name: searchform.php
*/
?>
<form method="get" id="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
 <div>
  <label class="screen-reader-text" for="s"><?php _e('Search for:'); ?></label>
  <input type="text" value="<?php global $s; echo esc_html($s, 1); ?>" name="s" id="s" />
  <input type="submit" id="searchsubmit" value="<?php esc_attr_e('Search'); ?>" />
 </div>
</form>
 