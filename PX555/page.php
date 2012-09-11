<?php get_header(); ?>
<div id="content">
	<div id="essay-single">
		<div class="single-all">
			<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="essay-title">
				<h2><a rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			</div>
			<div class="essay-content"><?php the_content(); ?></div>
			<?php endwhile; endif; ?>
		</div>
		<div id="comments"><?php comments_template('', true); ?></div>
	</div>
<?php get_footer(); ?>