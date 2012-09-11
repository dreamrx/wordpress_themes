<?php
/*
Theme Name: A9
Version: 1.9.1
Template Name: guestbook
File Name: page.php
*/
?>
<?php get_header(); ?>

<?php get_sidebar(); ?>

<div id="content">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="entry">

	<h1 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

		<?php the_content(); ?>

</div>

<?php comments_template('', true); ?>

<?php endwhile; else: ?>

<?php include(TEMPLATEPATH . '/no-matched.php'); ?>

<?php endif; ?>

</div> <!-- #content -->

<?php get_footer(); ?>   