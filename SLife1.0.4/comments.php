<?php
/**
 * @package WordPress
 * @subpackage SLife_Theme
 */
// Do not delete these lines
defined('ABSPATH') or die('This file can not be loaded directly.');
if ( post_password_required() ) { ?>
<p class="nocomments">This post is password protected. Enter the password to view comments.</p>
<?php return; } ?>
<!-- You can start editing here. -->
<div id="commentssection">
<?php if ( have_comments() ) : ?>
<h3 id="comments"><?php
$my_email = get_bloginfo ( 'admin_email' );
$str = "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_approved = '1' AND comment_type = '' AND comment_author_email";
$count_t = $post->comment_count;
$count_v = $wpdb->get_var("$str != '$my_email'");
$count_h = $wpdb->get_var("$str = '$my_email'");
echo $count_t, " 人发表的看法 (访客:", $count_v, " 次, 博主:", $count_h, " 次";
$count_p = count($comments_by_type['pings']);
if ( $count_p ) echo ", 引用:", $count_p, " 篇";
$count_e = ($count_t - $count_v - $count_h - $count_p);
if ( $count_e ) echo ", 其它:", $count_e, " 篇";
echo ")";
?>
</h3>
<ol class="commentlist">
<?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
</ol>
<div id="pagenavi"><?php paginate_comments_links('prev_next=0');?></div>
<?php else : // this is displayed if there are no comments so far ?>
<?php if ( comments_open() ) : ?>
<!-- If comments are open, but there are no comments. -->
<?php else : // comments are closed ?>
<!-- If comments are closed. -->
<p class="nocomments">Comments are closed.</p>
<?php endif; ?>
<?php endif; ?>
<?php if ( comments_open() ) : ?>
<div id="respond">
<h3><?php comment_form_title( '发表看法', 'Leave a Reply to %s' ); ?></h3>
<div class="cancel-comment-reply"><small><?php cancel_comment_reply_link(); ?></small></div>
<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
<?php else : ?>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform"><?php if ( is_user_logged_in() ) : ?>
<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p><?php else : ?>
<div id="comment-author-info">
<p title="您的马甲,必填!注册通用头像请到gravatar.com." style="margin-top:0;"><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" /><label for="author"><small>昵称 <?php if ($req) echo "(必填)"; ?></small></label></p>
<p title="您的邮箱,必填!但不会显示在网页上,您可能会收到回复通知邮件!"><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" /><label for="email"><small>邮件 <?php if ($req) echo "(必填)"; ?></small></label></p>
<p title="您的网站或者博客,不填就没办法回访喽!"><input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" size="22" tabindex="3" /><label for="url"><small>网址</small></label></p></div>
<?php if ( !empty($comment_author) ) { ?>
<div id="author-info" style="width:390px;">
<?php if ($comment_author_email == get_bloginfo ('admin_email')){ ?>
<img src="<?php echo bloginfo('template_directory'),'/images/my-avatar.gif' ?>" alt="" class="avatar" />
<?php } else { echo get_avatar($comment_author_email, $size = '60', $default = get_bloginfo('template_directory') . '/images/default60.jpg'); } ?>
<span class="author-name"><?php echo $comment_author ?></span>
<a href="javascript:showCommentAuthorInfo();">(换马甲)</a>
<br/>
<span class="author-name" style="font-size:14px"><?php echo WelcomeCommentAuthorBack($comment_author_email); ?></span>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
jQuery('#author-info').show();
jQuery('#comment-author-info').fadeTo(1, 0);
});
function showCommentAuthorInfo() {
jQuery('#author-info').hide();
jQuery('#comment-author-info').fadeTo('slow', 1);
}
</script>
<?php }  ?>
<?php endif; ?>
<div id="smiley" class="toggle" style="clear:both;padding:8px 0 0 5px;"><?php include(TEMPLATEPATH . '/smiley.php');?></div>
<div style="clear:both; padding:8px 0 0 0px; width:480px;"><a style="margin-left:6px;float: left;" href='javascript:embedImage();' >贴图</a><a style="margin-left:6px;float: left;" href='javascript:embedSmiley();' >表情</a>
<div class="tip">还可以输入<span class="counter" id="str">250</span>字</div>
</div>
<p style="margin:5px;"><textarea name="comment" id="comment" cols="100%" rows="6" tabindex="4"></textarea></p>
<p><input name="submit" type="submit" id="submit" tabindex="5" value="提交" />
<?php comment_id_fields(); ?></p>
<?php do_action('comment_form', $post->ID); ?>
</form>
<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>
</div>