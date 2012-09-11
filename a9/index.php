<?php
/*
Theme Name: A9
Version: 1.9.1
File Name: index.php
*/
?>
<?php get_header(); ?>

<?php get_sidebar(); ?>

<div id="content">

<?php if (have_posts()) : ?>

<?php include(TEMPLATEPATH . '/query-info.php'); ?>

<?php while (have_posts()) : the_post(); ?>

<div class="entry">
<?php if ( is_single() ) { ?>
<div class="scrolling"><a href="#center" title="scrolling">▼</a></div>
<?php } ?>

	<?php $hhead = is_singular() ? 'h1' : 'h2'; ?>
	<<?php echo $hhead; ?> class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('View Post'); ?>: <?php the_title_attribute(); ?>"><?php the_title(); ?></a></<?php echo $hhead; ?>>

<?php if ( is_single() ) { ?>
	<div class="single-entry">
		<?php the_content(__('(more...)')); ?>
		<?php wp_link_pages('before='.__('Continue').__('Reading').'... &after=&pagelink=[ % ]'); ?>
	</div>

		<?php
			} elseif ( is_page() ) {
				 the_content(); 

			} else { ?>
		<p>
			<?php	echo get_the_excerpt(); ?> 
			<a class="more-link" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php _e('View Post'); ?>: <?php the_title_attribute(); ?>"><?php _e('(more...)'); ?></a>
		</p>
<?php } ?>

<?php if ( !is_page() ) include(TEMPLATEPATH . '/postmetadata.php'); ?>

<?php if ( is_single() ) { ?>

<div id="center">
<?php include(TEMPLATEPATH . '/query-posts.php'); ?>
</div>

<?php include(TEMPLATEPATH . '/navigation.php'); ?>

<?php } ?>

</div>

<?php comments_template('', true); ?>

<?php endwhile; else: ?>

<?php include(TEMPLATEPATH . '/no-matched.php'); ?>

<?php endif; ?>

<div id="pagenavi"><?php pagenavi(); ?></div>

</div> <!-- #content -->

<?php get_footer(); ?> 