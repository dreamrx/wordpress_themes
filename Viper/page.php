<?php get_header(); ?>

<div id="layout">

<div id="content">
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
  <div id="post">
 <?php the_content(__('Read more'));?>
</div><!-- end post -->
 <?php endwhile; else: ?>
 <p><h2><strong>你怎么进来的？这里是404页面！</strong></h2></p>
   <p>你看看，什么都没有哦！</p>
   <p>或者说这个页面可能被我删掉了，或者调整了链接地址 　　Σ( ° △ °|||)</p>
 <?php endif; ?>
</div><!-- end #content-->

<?php get_sidebar(); ?>
</div> <!-- end #layout -->
<?php get_footer(); ?>