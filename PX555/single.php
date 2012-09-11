<?php get_header(); ?>
<div id="content">
	<div id="essay-single">
		<div class="single-all">
			<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="essay-title">
				<h2><a rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			
<p class="essay-msg"><?php the_time('Y-m-d G:i'); ?>&nbsp;>&nbsp;<?php the_category(',') ?>&nbsp;>&nbsp;<?php the_tags('', '&nbsp;.&nbsp;', ' '); ?>&nbsp;>&nbsp;<?php comments_popup_link('我抢沙发', '1 条评论', '% 条评论'); ?></p>
</div>
			<div class="essay-content"><?php the_content(); ?></div>
			<div id="post-navi"><span><?php if (get_previous_post()) {  echo '下一篇：'; previous_post_link('《%link》'); } else {echo "已经是最后";}; ?></span><?php if (get_next_post()) {  echo '上一篇：'; next_post_link('《%link》'); } else {echo "已经是第一篇";}; ?></div>
			<?php endwhile; endif; ?>
		</div>
		<div id="comments"><?php comments_template('', true); ?></div>
	</div>
<?php get_footer(); ?>