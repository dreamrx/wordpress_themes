<?php
/**
 * @package WordPress
 * @subpackage SLife_Theme
 */
?>
<form method="get" id="altsearchform" action="<?php bloginfo('url'); ?>/">
<div><input type="text" value="没事搜一下..." onfocus="if (this.value == '没事搜一下...') {this.value = '';}" onblur="if (this.value == '') {this.value = '没事搜一下...';}"  name="s" id="s" /><input type="submit" id="searchsubmit" value="Search" /></div>
</form>