<?php get_header(); ?>
<div id="layout">
<div id="content">
 <?php is_tag(); ?>
  <?php if (have_posts()) : ?>

   <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
   <?php /* If this is a category archive */ if (is_category()) { ?>
    <h2>Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
   <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
    <h2>Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
   <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
    <h2>Archive for <?php the_time('F jS, Y'); ?></h2>
   <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
    <h2>Archive for <?php the_time('F, Y'); ?></h2>
   <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
    <h2>Archive for <?php the_time('Y'); ?></h2>
   <?php /* If this is an author archive */ } elseif (is_author()) { ?>
    <h2>Author Archive</h2>
   <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
    <h2>Blog Archives</h2>
   <?php } ?>

  <?php while (have_posts()) : the_post(); ?>
  
   <h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
   <!-- 信息栏 --> 
<div  class="info">
<div  class="infoline"> </div>
<div  id="div"><?php the_time('Y.m.j'); ?></div>
<div  class="verline"> </div> 
<div  id="div"><?php the_category(', ') ?></div> 
<div  class="verline"> </div> 
<div  id="div"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>  </div> 
<?php if(function_exists('the_views')){?> <div  class="verline"> </div><div  id="div"><?php the_views();}?></div> 
<?php edit_post_link(' <div  class="verline"> </div><div  id="div">Edit </div>');?>
<div  class="infoline"> </div>
</div><!-- end .info -->

   <div id="post">
 <?php the_content(__('Read more'));?>
</div><!-- end post -->
  
   <div id="postmeta">
    Tags:<?php the_tags(' ', ',', ' '); ?>
 </div><!-- end .postmeta -->

  

  <?php endwhile; ?>

  <!--如果不用pagenavi翻页插件，把这下面的代码和"替换开始"后的代码 替换一下
  <div id="postnavigation"><?php previous_posts_link('&laquo; 上一页') ?> <?php next_posts_link('下一页 &raquo;') ?> </div>
   -->

 	<!-- 替换开始 -->	<div id="postnavigation">
  				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>  
 				</div>
	<!--替换结束 -->
    
 <!-- end .postnavigation -->
 
 <?php else : ?>

  <h2>Not Found</h2>
  <p>Try using the search form below</p>
  <?php include (TEMPLATEPATH . '/searchform.php'); ?>

 <?php endif; ?>
</div><!-- end #content -->

<?php get_sidebar(); ?>
</div> <!-- end #layout -->
<?php get_footer(); ?>