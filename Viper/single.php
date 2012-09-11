<?php get_header(); ?>

<div id="layout">

    <div id="content">
 
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <h2><a href="<?php echo get_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        
        <!-- 信息栏 --> 
        <div  class="info">
            <div  class="infoline"> </div>
            <div  id="div"><?php the_time('Y.m.j'); ?></div>
            <div  class="verline"> </div> 
            <div  id="div"><?php the_category(', ') ?></div> 
            <div  class="verline"> </div> 
            <div  id="div"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></div>

            <?php if(function_exists('the_views')){?> 
                <div  class="verline"> </div>
                <div  id="div"><?php the_views();}?></div> 
            
            <?php edit_post_link(' <div  class="verline"> </div><div id="div">Edit </div>');?>
        <div  class="infoline"> </div>
    </div> <!-- end .info -->  

   
       <div id="post">
 <?php the_content(__('Read more'));?>
</div><!-- end post -->

        <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

        <div id="postmeta">
            Tags:<?php the_tags(' ', ',', ' '); ?>
        </div><!-- end .postmeta -->
 
        <div class="post-nav">
            <span class="previous">上一篇：<?php next_post_link('%link');?></span>
            <span class="next">下一篇：<?php previous_post_link('%link');?></span>
        </div><!-- post-nav -->
 
 
        <?php comments_template(); ?>
  
  
        <?php endwhile ?>
        <?php else: ?>
            <p><h2><strong>你怎么进来的？这里是404页面！</strong></h2></p>
            <p>你看看，什么都没有哦！</p>
            <p>或者说这个页面可能被我删掉了，或者调整了链接地址 　　Σ( ° △ °|||)</p>
        <?php endif; ?>
    </div><!-- end #content -->

<?php get_sidebar(); ?>
</div> <!-- end #layout -->
<?php get_footer(); ?>