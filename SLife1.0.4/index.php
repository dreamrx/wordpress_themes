<?php
/**
 * @package WordPress
 * @subpackage SLife_Theme
 */
?>
<?php get_header();?>
<div id="content">
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
    <h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="阅读 <?php the_title(); ?>"><?php the_title(); ?></a></h2>
    <div class="menuheader-open"></div>
	<div class="post-entry">
	<p><?php echo mb_strimwidth(strip_tags(apply_filters('the_content', $post->post_content)), 0, 300,"..."); /* 300为字符数，注意这个要保持偶数，300即150个中文 */ ?></p>
	</div>
	 <div class="postmetadata"><p><span class="date_ico"><?php the_time('Y-m-d') ?></span> <span class="category_ico"><?php the_category(', ') ?></span><span class="admin_ico"><?php the_author() ?></span><span class="comments_ico"><?php comments_popup_link('抢沙发', '有 1 位童鞋发表了意见', '有 % 位童鞋发表了意见'); ?></span><span class="tags_ico">&nbsp;<?php if (function_exists('the_tags')) { the_tags('', ', ', ''); } ?></span></p></div>
	</div>
<?php endwhile; ?>
	<div id="pagenavi"><?php pagenavi(); ?></div>
<?php else : ?>
	<h2 class="notfound">怎么找也没找到你想要的，再重新找找？</h2>
	<?php include (TEMPLATEPATH . '/altsearchform.php'); ?>
<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>