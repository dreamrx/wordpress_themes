<?php get_header(); ?>
<div id="layout">
<div id="content">
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2><!-- 信息栏 --> 
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
 
 <?php endwhile ?>
 
 <!--如果不用pagenavi翻页插件，把这下面的代码和"替换开始"后的代码 替换一下
  <div id="postnavigation"><?php previous_posts_link('&laquo; 上一页') ?> <?php next_posts_link('下一页 &raquo;') ?> </div>
   -->

 	<!-- 替换开始 -->	<div id="postnavigation">
  				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>  
 				</div>
	<!--替换结束 -->
    
 <!-- end .postnavigation -->
 <?php else: ?>
 
  <p><h2><strong>没有搜索到</strong></h2></p>
  <p>换个关键词试试，不过估计也不会有……<p/>
  <p><?php include (TEMPLATEPATH . '/searchform.php'); ?></p>
  
 <?php endif; ?>


</div><!-- end #content -->

<?php get_sidebar(); ?>
</div> <!-- end #layout -->
<?php get_footer(); ?>