<link href="style.css" rel="stylesheet" type="text/css" />
<div id="sidebar">
<div class="rss"><a  href="<?php bloginfo('rss2_url'); ?>"><span>RSS</span></a></div>
 <?php include (TEMPLATEPATH . '/searchform.php'); ?>
  
   
   <ul>




	<!-- 分类 -->
	<li>
    <?php wp_list_categories('show_count=1&orderby=order&title_li=<h2>Categories</h2>'); ?>
   </li>

    <!-- 博主信息 -->
     <li>
     <h2>About Author</h2>
     <ul class="author-layout">
       <div class="author"> </div> <b>　博主称呼</b> <p>一些介绍</p>
       <p>编辑主题sidebar</p>
       <p>自行填写内容</p>
     </ul>
   </li>
   
   <!-- 最近文章 -->
   <li>
    <h2>Recent Posts</h2>
    <?php get_archives('postbypost', 5); ?>
   
   </li>

   <!-- 最近评论 -->
   <li>  
     <h2>Recent Comments</h2>
     <ul class="sidecom">
       <?php $comments=get_comments('number=6');
				$wpchres=get_option('blog_charset');
				foreach($comments as $comment){
					echo '<li  class="sidecom2"><a href="'.get_comment_link().'" title="发表于 '.get_the_title($comment->comment_post_ID).'">'.get_comment_author().'</a>: '.mb_substr($comment->comment_content,0,25,$wpchres).'...</li>';
				}?>           
     </ul>
    </li>
    
	<!-- 边栏扩展代码 -->
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
  <?php endif; ?>
 </ul>
</div><!-- end #sidebar -->