<?php get_header(); ?>
<div id="content">
	<div id="essay-single">
		<div class="single-all">
			<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
			<div id="essay-<?php the_ID(); ?>" class="essay-one">
			<div class="essay-content">
<?php
    $query="SELECT COUNT(comment_ID) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 24 MONTH ) AND user_id='0' AND comment_author_email != 'afcold@gmail.com' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT 54";
    $wall = $wpdb->get_results($query);
    $maxNum = $wall[0]->cnt;
    foreach ($wall as $comment) 
    {
        $width = round(36 / ($maxNum / $comment->cnt),2);
        $tmp = "<li title='".$comment->comment_author." @".$comment->cnt."'>
			<div class='active-img'>".get_avatar($comment->comment_author_email, 36)."</div>
			<div class='active-bg'>
				<div class='active-degree' style='width:".$width."px'></div>
			</div>
			</li>
			";
        $output .= $tmp; 
     }
    $output = "<div id='readerswall'><ul>".$output."</ul></div>";
    echo $output ;
?>

				<ul class="links">
					<?php wp_list_bookmarks(array('title_li' => '', 'categorize' => '0','orderby' => 'id')); ?>
				</ul>
			</div>
			</div>
			<?php endwhile; endif; ?>
		</div><!--single-all-->
		
	</div><!--end essay-->
<?php get_footer(); ?>