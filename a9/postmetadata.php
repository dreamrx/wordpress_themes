<?php
/*
Theme Name: A9
Version: 1.9.1
File Name: postmetadata.php
*/
?>
<div class="postmetadata small">
	<?php if (is_sticky()) { ?><span class="sticky"> ※ <?php _e('Sticky'); ?>　</span><?php } ?>
	<img src="<?php bloginfo('stylesheet_directory'); ?>/img/category.gif" width="62" height="17" alt="" />
	- <?php the_category(',') ?>　
<?php $posttags = get_the_tags(); if ($posttags) { ?>
	<img src="<?php bloginfo('stylesheet_directory'); ?>/img/tags.gif" width="30" height="17" alt="" />
	- <?php the_tags('', ', ', ''); ?>　
<?php } ?>
	<img src="<?php bloginfo('stylesheet_directory'); ?>/img/date.gif" width="32" height="17" alt="" />
	- <?php the_time(get_option('date_format')); time_ago($type = 'post', $day = 30); ?>　
	<img src="<?php bloginfo('stylesheet_directory'); ?>/img/comments.gif" width="71" height="17" alt="" /> - 
	<?php comments_popup_link('(0)','(1)','(%)'); ?>
	<?php edit_post_link(__('(Edit)'),' - ',''); ?>
</div>