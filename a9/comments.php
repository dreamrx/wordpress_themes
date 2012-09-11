<?php
/*
Theme Name: A9
Version: 1.9.1
File Name: comments.php
*/
?>
<?php
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p><?php _e('Enter your password to view comments'); ?></p>
	<?php return; } ?>

<?php if ( have_comments() ) : ?>

<h3 id="comments"><?php
$my_email = get_bloginfo ( 'admin_email' );
$str = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = $post->ID 
AND comment_approved = '1' AND comment_type = '' AND comment_author_email";
$count_t = $post->comment_count;
$count_v = $wpdb->get_var("$str != '$my_email'");
$count_h = $wpdb->get_var("$str = '$my_email'");
echo $count_t, " 篇回應 (訪客:", $count_v, " 篇, 博主:", $count_h, " 篇";
$count_p = count($comments_by_type['pings']);
 if ( $count_p ) echo ", 引用:", $count_p, " 篇";
$count_e = ($count_t - $count_v - $count_h - $count_p);
 if ( $count_e ) echo ", 其它:", $count_e, " 篇";
echo ")";
?>
</h3>

<ol class="commentlist"><?php wp_list_comments('type=comment&callback=mytheme_comment') ?></ol>

<div id="pagenavi">
<?php paginate_comments_links('prev_next=0');?>
</div>

<?php endif; ?><!-- end if ( have_comments() ) : -->

<?php if ( comments_open() ) : ?>

<div id="respond" class="no_webshot">

<h3><?php comment_form_title(__('Leave a Reply'), __('Leave a Reply to %s')); ?></h3>

<div class="cancel-comment-reply">
	<?php cancel_comment_reply_link(); ?>
</div>

<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url( get_permalink() ) );?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( is_user_logged_in() ) { ?>

<p><?php printf(__('Logged in as %s.'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account') ?>"><?php _e('Log out &raquo;'); ?></a></p>

<?php } else { ?>

<div id="comment-author-info">

<p style="margin-top:0;"><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="14" tabindex="1" />
<label for="author"><small>名稱(必需)</small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="25" tabindex="2" />
<label for="email"><small>電子郵件 (不會被公開, 必需)</small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="36" tabindex="3" />
<label for="url"><small>網站</small></label></p>

</div>

<?php if ( !empty($comment_author) ) { ?>
			<div id="author-info">
				<?php if ($comment_author_email == get_bloginfo ('admin_email')){ ?>
				<img src="<?php echo bloginfo('template_directory'),'/img/my-avatar.gif' ?>" alt="" class="avatar" />
				<?php } else { echo get_avatar($comment_author_email, $size = '60', $default = get_bloginfo('template_directory') . '/img/default60.jpg'); } ?>
				<span class="author-name"><?php echo $comment_author ?></span>
				<a href="javascript:showCommentAuthorInfo();">(更改)</a>
			</div>
			<script type="text/javascript">
			//<![CDATA[
				jQuery(document).ready(function() {
					jQuery('#author-info').show();
					jQuery('#comment-author-info').fadeTo(1, 0);
				});
				function showCommentAuthorInfo() {
					jQuery('#author-info').hide();
					jQuery('#comment-author-info').fadeTo('slow', 1);
				}
			//]]>
			</script>
<?php } } ?>

<div id="smiley" class="toggle" style="clear:both;margin-left:15px;"><?php include(TEMPLATEPATH . '/smiley.php');?></div>
<div style="clear:both;">
 <a style="margin-left:12px;" href='javascript:embedImage();' >貼圖</a>
 <a style="margin-left:6px;" href='javascript:embedSmiley();' >表情</a>
 <span style="font-size:12px;margin-left:30px;">( ps. 若要貼代碼, 請將 "&lt;" 改成 "&amp;lt;" 即可, 此方法在所有 WP 網站均適用. )</span>
</div>
<p style="margin:5px;"><textarea name="comment" id="comment" cols="58" rows="5" tabindex="4" onkeydown="if(event.ctrlKey&amp;&amp;event.keyCode==13){document.getElementById('submit').click();return false};"></textarea></p>

<p>
<input type="submit" name="submit" id="submit" tabindex="5" value="<?php _e('Submit'); ?>" />
<input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked" style="width: auto;margin-left:20px;" /><label for="comment_mail_notify">有人回覆時郵件通知我</label>
<?php comment_id_fields(); ?>
<?php do_action('comment_form', $post->ID); ?>
</p>

</form>

<?php endif; ?>
</div> <!-- #respond -->

	<?php $Pingbacks = $comments_by_type['pings']; if ( ! empty($Pingbacks) ) : ?>
		<h3 id="pings">Trackbacks/Pingbacks</h3>
		<ol class="inverse_color">
		<?php foreach ( array_reverse( $Pingbacks ) as $comment) : ?>
			<li id="comment-<?php comment_ID( ); ?>" class="comment"><cite><?php comment_author_link(); ?></cite> <span class="pingdate"> --- <?php comment_date() ?></span></li>
		<?php endforeach; ?>
		</ol>
	<?php endif; ?>


<p class="inverse_color" style="text-align:center;"><?php post_comments_feed_link(__('<abbr title="Really Simple Syndication">RSS</abbr> feed for comments on this post.')); ?>
<?php if ( pings_open() ) : ?>
	<a href="<?php trackback_url() ?>" rel="trackback"><?php _e('TrackBack <abbr title="Universal Resource Locator">URL</abbr>'); ?></a>
<?php endif; ?>
</p>

<?php else : ?>
<h4 class="query-info" style="margin:0 6px 15px">此文章的評論已關閉.</h4>
<?php endif; ?>