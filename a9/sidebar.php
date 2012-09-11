<?php
/*
Theme Name: A9
Version: 1.9.1
File Name: sidebar.php
*/
?>
	<div id="sidebar">
		<ul>

			<li class="widget"><h3><?php _e('Pages'); ?></h3>
				<ul class="slide-area">
				<li><a href="<?php echo get_option('home'); ?>/" title="<?php _e('Home'); ?>"><?php _e('Home'); ?></a></li>
				<?php wp_list_pages('title_li='); ?>
				</ul>
			</li>

<?php if ( is_singular() || is_archive() || is_search()) { ?>
			<li class="widget"><h3><?php _e('Recent Posts'); ?></h3>
				<ul class="slide-area small">
				<?php wp_get_archives('title_li=&type=postbypost&limit=10'); ?>
				</ul>
			</li>
<?php } ?>

<?php if ( function_exists('get_most_viewed') && is_home() ) { ?>
			<li class="widget"><h3><?php _e('Most Popular'); ?></h3>
				<ul class="slide-area small">
				<?php get_most_viewed('post', 10); ?>
				</ul>
			</li>
<?php } ?>

<?php if ( !is_archive() && !is_home() ) { ?>
			<li class="widget"><h3><?php _e('Categories'); ?></h3>
				<ul class="slide-area">
				<?php wp_list_categories('title_li=&show_count=1'); ?>
				</ul>
			</li>
<?php } ?>

<?php if ( is_home() || is_single() ) { ?>
			<li class="widget">
<h3><?php _e('Recent Comments'); ?></h3>
<ul class="recentcomments slide-area">
<?php
$my_email = get_bloginfo ('admin_email');
$rc_comms = $wpdb->get_results("
  SELECT ID, post_title, comment_ID, comment_author, comment_author_email, comment_content
  FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts
  ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID)
  WHERE comment_approved = '1'
  AND comment_type = ''
  AND post_password = ''
  AND comment_author_email != '$my_email'
  ORDER BY comment_date_gmt
  DESC LIMIT 10
");
$rc_comments = '';
foreach ($rc_comms as $rc_comm) {
  $a = get_bloginfo('wpurl'). '/avatar/'.md5(strtolower($rc_comm->comment_author_email)).'.jpg';
  $rc_comments .= "<li><img src='" . $a . "' alt='' title='" . $rc_comm->comment_author . "' class='avatar' /><a href='"
    . get_permalink($rc_comm->ID) . "#comment-" . $rc_comm->comment_ID
  //. htmlspecialchars(get_comment_link( $rc_comm->comment_ID, array('type' => 'comment'))) // 可取代上一行, 會顯示 cpage, 但較耗資源
    . "' title='on " . $rc_comm->post_title . "'>" . convert_smilies(embed_images(strip_tags($rc_comm->comment_content)))
    . "</a></li>\n";
}
echo $rc_comments;
?>
</ul>
			</li>

			<li class="widget"><h3><?php _e('Links'); ?></h3>
				<ul class="blogroll slide-area">
				<?php wp_list_bookmarks('title_li=&categorize=0'); ?>
				</ul>
			</li>
<?php } ?>

<?php if ( is_archive() ) { ?>
			<li class="widget"><h3><?php _e('Select Month'); ?></h3>
				<ul class="slide-area">
				<?php wp_get_archives('show_post_count=true'); ?>
				</ul>
			</li>
<?php } ?>

		</ul>

	</div>   