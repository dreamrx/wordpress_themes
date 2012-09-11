<?php
/*
Theme Name: A9
Version: 1.9.1
File Name: archive.php
*/
?>
<?php get_header(); ?>

<?php get_sidebar(); ?>

<div id="content">

<?php if (have_posts()) : ?>

<?php include(TEMPLATEPATH . '/query-info.php'); ?>

<?php while (have_posts()) : the_post(); ?>

<div class="entry">

	<h2 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e('View Post'); ?>: <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

<p><?php echo get_the_excerpt(); ?> 
<a class="more-link" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e('View Post'); ?>: <?php the_title_attribute(); ?>"><?php _e('(more...)'); ?></a>
</p>

<?php include(TEMPLATEPATH . '/postmetadata.php'); ?>

</div>

<?php endwhile; ?>

<?php endif; ?>

<div id="pagenavi"><?php pagenavi(); ?></div>

</div> <!-- #content -->

<?php get_footer(); ?> 