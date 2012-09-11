<?php
/*
Theme Name: A9
Version: 1.9.1
File Name: single.php
*/
?>
<?php get_header(); ?>

<?php get_sidebar(); ?>

<div id="content">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

<div class="entry">
<div class="scrolling"><a href="#center" title="scrolling">▼</a></div>
	<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

	<div class="single-entry">
		<?php the_content(); ?>
		<?php wp_link_pages('before='.__('Continue').__('Reading').'... &after=&pagelink=[ % ]'); ?>
	</div>

<?php include(TEMPLATEPATH . '/postmetadata.php'); ?>

<div id="center">
<?php include(TEMPLATEPATH . '/query-posts.php'); ?>
</div>

<?php include(TEMPLATEPATH . '/navigation.php'); ?>

</div> <!-- .entry -->

<?php comments_template('', true); ?>
<div class="scrolling" style="margin-right:15px;"><a href="#center" title="scrolling">▲</a></div>

<?php endwhile; else: ?>

<?php include(TEMPLATEPATH . '/no-matched.php'); ?>

<?php endif; ?>

</div> <!-- #content -->

<?php get_footer(); ?> 