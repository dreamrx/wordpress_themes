<?php
/**
 * @package WordPress
 * @subpackage SLife_Theme
 */
?>
<?php get_header();?>
<div id="content">
<p>Sorry, but you are looking for something that isn&#8217;t here.</p>
<h3>Tag Cloud</h3>
<?php wp_tag_cloud('smallest=9&largest=22&unit=pt&number=200&format=flat&orderby=name&order=ASC');?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>