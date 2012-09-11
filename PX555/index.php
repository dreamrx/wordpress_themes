<?php get_header(); ?>
<div id="content">
	<div id="essay">
	<div id="essay-content">
	<div class="postlist">
		<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
		<div id="essay-<?php the_ID(); ?>" class="essay-home">
			<div class="essay-ico ico-<?php $category = get_the_category();echo $category[0]->category_nicename; ?>"></div>
			<div class="essay-title"><h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2></div>
			<div class="essay-msg">
				<?php the_time('Y-m-d'); ?>&nbsp;>&nbsp;<?php the_category(',') ?>&nbsp;>&nbsp;<?php the_tags('', '&nbsp;.&nbsp;', ' '); ?>&nbsp;>&nbsp;<?php comments_popup_link('我抢沙发', '1 条评论', '% 条评论'); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
	</div>
	<?php if (is_home()&& $paged<2) { ?>
	<div class="postlist">
		<?php query_posts('offset=8') ; while (have_posts()) : the_post(); ?>
		<div id="essay-<?php the_ID(); ?>" class="essay-home">
			<div class="essay-ico ico-<?php $category = get_the_category();echo $category[0]->category_nicename; ?>"></div>
			<div class="essay-title"><h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2></div>
			<div class="essay-msg">
				<?php the_time('Y-m-d'); ?>&nbsp;>&nbsp;<?php the_category(',') ?>&nbsp;>&nbsp;<?php the_tags('', '&nbsp;.&nbsp;', ' '); ?>&nbsp;>&nbsp;<?php comments_popup_link('我抢沙发', '1 条评论', '% 条评论'); ?>
			</div>
		</div>
		<?php endwhile; ?>
	</div>
	<?php } ?>
	</div>
	</div>
	<div id="pagelist">
		<?php if (function_exists('index')) { index(); } ?>
	</div>
<?php get_footer(); ?>