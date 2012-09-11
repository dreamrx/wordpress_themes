<?php
	if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.'); ?></p> 
	<?php
		return;
	}
?>

<?php if ( have_comments() ) : ?>
<?php if ( ! empty($comments_by_type['comment']) ) : ?>
	<ol class="commentlist clearfix">
	<?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
	</ol>
	<div class="right_border"><?php next_comments_link('下一页') ?></div><div class="left_border"><?php previous_comments_link('上一页') ?></div>
    <?php endif; ?>
    <?php if ( ! empty($comments_by_type['pings']) ) : ?>
<div class="ping_border">
<ol class="commentlist clearfix">
	<?php wp_list_comments('type=pings&callback=mytheme_comment'); ?>
</ol>
</div>
<?php endif; ?>
<?php else : ?>
	<?php if ('open' == $post->comment_status) : ?>
	<?php else : ?>
		<p class="nocomments">评论关闭。</p>
	<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>
<div id="respond">
<h3 class="clearfix"><span id="cancel-comment-reply"><?php cancel_comment_reply_link() ?></span></h3>
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
<?php else : ?>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php if ( $user_ID ) : ?>
<?php printf(__(' <a href="%1$s">%2$s</a> '), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account'); ?>"><?php _e('Log out &raquo;'); ?></a>
<?php else : ?>

<div id="author_info">
	<li class="author"><label for="author">昵称:<?php if ($req) _e(" "); ?></label><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1"/></li>
	<li class="email"><label for="email">邮箱:<?php if ($req) _e(" "); ?></label><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2"/></li>
	<li class="url"><label for="url">网址:</label><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" /></li>
</div>

<?php endif; ?>

<p><textarea name="comment" id="comment" cols="60" rows="10" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea></p>
<p><input name="submit" type="submit" id="submit" tabindex="5" value="提交评论/Ctrl+Enter" /><p>

<?php do_action('comment_form', $post->ID); ?>
<?php comment_id_fields(); ?> 
</form>

<?php endif; // If registration required and not logged in ?>
</div>
<?php if ( $ping_count ) : ?>

<div id="trackbacks-list" class="comments">
	<h3><?php printf($ping_count > 1 ? '%d Trackbacks' : '1 Trackback', $ping_count) ?></h3>
	<ol>
<?php foreach ( $comments as $comment ) : ?>
<?php if ( get_comment_type() != "comment" ) : ?>
	<li id="comment-<?php comment_ID() ?>">
	<?php comment_author_link(); ?>
<?php if ($comment->comment_approved == '0') echo('<i>Your trackback is awaiting moderation.</i>\n'); ?>
	</li>
<?php endif ?>
<?php endforeach; ?>
	</ol>
</div>

<?php endif ?>
<?php endif; ?>
