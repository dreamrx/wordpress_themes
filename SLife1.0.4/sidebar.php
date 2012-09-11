<?php
/**
 * @package WordPress
 * @subpackage SLife_Theme
 */
?>
<div id="sidebar">
<ul>
	<li class="widget">
<div id="sidebar-tab">
	<div id="tab-title">
		<h3><span id="tab-1" class="current"><?php if (is_home()) {echo "最新评论";} else {echo "最新文章";} ?></span><span id="tab-2">热评文章</span><span id="tab-3">随机文章</span><span id="tab-4"><?php if (is_home()) {echo "标签云";} else {echo "归档";} ?></span></h3>
	</div>
	<div id="tab-content">
		<?php if (is_home()) { ?>
		<ul class="tab-1 recentcomments">
			<?php if (function_exists('recentcomments')) { echo recentcomments(8,15,''); } ?>
		</ul>
		<?php } else { ?> 
		<ul class="tab-1">
			<?php wp_get_archives('title_li=&type=postbypost&limit=10'); ?>
		</ul>
		<?php } ?>

		<ul class="tab-2">
			<?php if (function_exists('simple_get_most_viewed')) { simple_get_most_viewed(10, 365); } ?>
		</ul>

		<ul class="tab-3">
			<?php
			$rand_posts = get_posts('numberposts=10&orderby=rand');
			foreach( $rand_posts as $post ) {
			?>
			<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php } ?>
		</ul>
        <?php if (is_home()) { ?>
		<ul class="tab-4">
			<li><?php wp_tag_cloud('smallest=9&largest=18'); ?></li>
		</ul>
        <?php } else { ?>
        <ul class="tab-4">
			<?php wp_get_archives('show_post_count=true'); ?>
		</ul>
        <?php } ?>
	</div>
</div>
	</li>
</ul>
<?php if (is_singular() || is_archive() || is_home() ) { ?>
<?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar() ) : ?>
<?php endif; ?>
<?php } ?>
<?php if ( is_home()) { ?>
<ul style="clear:both; padding-top:3px;">
<li class="widget">
<h3>友情链接</h3>
<ul class="slife-links">
<?php wp_list_bookmarks('title_li=&categorize=0&orderby=id'); ?>
</ul>
</li>
</ul>
<?php } ?>
</div>