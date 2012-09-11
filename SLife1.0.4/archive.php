<?php
/**
 * @package WordPress
 * @subpackage SLife_Theme
 */
?>
<?php get_header();?>
<div id="content">
<?php if (have_posts()) : ?>
<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>				
<h2 class="archivetitle">以下是 <?php echo single_cat_title(); ?> 的文章</h2>
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<h2 class="archivetitle">以下是 <?php the_time('Y-m-d'); ?> 的文章</h2>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<h2 class="archivetitle">以下是 <?php the_time('Y-m'); ?> 的文章</h2>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<h2 class="archivetitle">以下是 <?php the_time('Y'); ?> 的文章</h2>
<?php /* If this is a search */ } elseif (is_search()) { ?>
<h2 class="archivetitle">以下是搜索结果</h2>
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
<h2 class="archivetitle">作者存档</h2>
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
<h2 class="archivetitle">博客存档</h2>
<?php } ?>
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
<h2 class="notfound">Sorry, Not Found. Please try again.</h2>
<?php include (TEMPLATEPATH . '/altsearchform.php'); ?>
<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>