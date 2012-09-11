<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
			?>
<link href="style.css" rel="stylesheet" type="text/css" />


			<p class="nocomments">This post is password protected. Enter the password to view comments.</p>

			<?php
			return;
		}
	}

	/* This variable is for alternating comment background */
	$oddcomment = 'class="alt" ';
?>

<!-- You can start editing here. -->
<div id="comments">
<div id="top">Top</div>

<div id="yaapc-comments">


<?php echo $post->ID; ?>
</span>



<?php if ($comments) : ?>



	<h3><?php comments_number('暂时没有回复', '现在只有1个回复', '已经有%个回复' );?></h3>



	<ol class="commentlist">

	<?php foreach ($comments as $comment) : ?>
	<?php $comment_type = get_comment_type(); ?>
	<?php if($comment_type == 'comment') { ?>
	<?php if (($comment->user_id==get_the_author_ID())||($comment->comment_author_email==get_the_author_email())): ?>               
	<li class="admin" id="comment-<?php comment_ID() ?>"> 
			
			<?php if ($comment->comment_approved == '0') : ?>
			<em>哎呀，评论误判进入审核中……放心，博主会筛选的！</em>
			<?php endif; ?>
			
            
            
            
            
			<span class="mid">
 
			<?php if (function_exists('get_avatar')) : ?>
				<?php echo get_avatar( $comment, 32 ); ?>
			<?php else : ?>
		<?php endif; ?>
        
  <div id=commentinfo>  
  <cite><?php comment_author_link() ?></cite>
  <div id="commentdata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('Y.m.j') ?> <?php comment_time('G:H') ?></a> <?php edit_comment_link('edit','&nbsp;&nbsp;',''); ?> <?php if(function_exists("yus_reply")) yus_reply(); ?></div>
  
  </div>
        
<div id=commenttext> <?php comment_text() ?> </div>
            
			</span>
			
		</li>
        

		<?php endif; ?>
        
        
        

<?php if(($comment->user_id!=get_the_author_ID())&&($comment->comment_author_email!=get_the_author_email())): ?> 
		<li <?php echo $oddcomment; ?>id="comment-<?php comment_ID() ?>">


			

			<?php if ($comment->comment_approved == '0') : ?>
			<em>哎呀，评论误判进入审核中……放心，博主会筛选的！</em>
			<?php endif; ?>
			
			<span class="mid">
 
			<?php if (function_exists('get_avatar')) : ?>
				<?php echo get_avatar( $comment, 32 ); ?>
			<?php else : ?>
		<?php endif; ?>
        
  <div id=commentinfo>  
  
  <cite><?php comment_author_link() ?></cite>
  <div id="commentdata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('Y.m.j') ?> <?php comment_time('G:H') ?></a> <?php edit_comment_link('edit','&nbsp;&nbsp;',''); ?> <?php if(function_exists("yus_reply")) yus_reply(); ?></div>
  </div>
        
<div id=commenttext> <?php comment_text() ?> </div>
              
			</span>
            
		<?php endif; ?>

	<?php
		/* Changes every other comment to a different class */
		$oddcomment = ( empty( $oddcomment ) ) ? 'class="alt" ' : '';
	?>

	<?php } else { $trackback = true; } ?>
	<?php endforeach; /* end for each comment */ ?>

	</ol>
   

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		</div>
		<p class="nocomments">Comments are closed.</p>

	<?php endif; ?>
<?php endif; ?>
</div><!-- 评论 翻页 -->

<?php if ($trackback == true) { ?>
<h3 id="tp">Trackbacks & Pingbacks</h3>
<ul>
<?php foreach ($comments as $comment) : ?>
<?php $comment_type = get_comment_type(); ?>
<?php if($comment_type != 'comment') { ?>
<li class="ping"><h4><?php comment_author_link() ?></h4>
<?php comment_text() ?></li>
<?php } ?>
<?php endforeach; ?>
</ul>
<?php } ?>



<?php if ('open' == $post->comment_status) : ?>
<h3 id="respond">发表评论</h3>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p class="logged">You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>



<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p class="logged">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a></p>

<?php else : ?>



<!--保留
<p class="in"><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" />
<label for="author">Name (填上，别匿名了)  <?php if ($req) echo ""; ?></label></p>

<p class="in"><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" />
<label for="email">Mail (用于显<a href="http://www.gravatar.com">Gravata</a>头像) <?php if ($req) echo ""; ?></label></p>

<p class="in"><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" />
<label for="url">Website</label></p>
-->



<!--引用用代码开始-->
<!-- 有资料的访客 -->
<?php if ( $comment_author != "" ) : ?>
	<!--
		转换显示状态用的 JavaScript
		Q1: 为什么这段代码放在这里呢?
		A1: 因为只有当访客有资料时, 它才被用上, 这样可以减少无资料访客下载页面时的开销.
		Q2: 为什么不用外部文件将 JavaScript 放起来? 也许那样维护起来更方便.
		A2: 因为它只在这个地方用到了. 而且加载文件的数量也会影响页面下载速度, 为了这么点字节的代码, 不值得新开一个文件.
	-->
	<script type="text/javascript">function setStyleDisplay(id, status){document.getElementById(id).style.display = status;}</script>
	<div class="form_row small">
		<!-- 访客昵称 (随便欢迎一下) -->
		<?php printf(__('Welcome back <strong>%s</strong>.'), $comment_author) ?>
 
		<!-- 更改按钮 (点击后: 隐藏更改按钮, 显示取消按钮, 显示资料输入框) -->
		<span id="show_author_info"><a href="javascript:setStyleDisplay('author_info','');setStyleDisplay('show_author_info','none');setStyleDisplay('hide_author_info','');"><?php _e('Change &raquo;'); ?></a></span>
 
		<!-- 取消按钮 (点击后: 显示更改按钮, 隐藏取消按钮, 隐藏资料输入框) -->
		<span id="hide_author_info"><a href="javascript:setStyleDisplay('author_info','none');setStyleDisplay('show_author_info','');setStyleDisplay('hide_author_info','none');"><?php _e('Close &raquo;'); ?></a></span>
	</div>
<?php endif; ?>
 
<!-- 资料输入框 -->
<div id="author_info">
	<div class="form_row">
		<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" />
		<label for="author" ><?php _e('昵称'); ?> <?php if ($req) _e('(必填)'); ?></label>
	</div>
	<div class="form_row">
		<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" />
		<label for="email" ><?php _e('邮箱');?> <?php if ($req) _e('(用于显<a href="http://www.gravatar.com">Gravata</a>头像，必填)'); ?></label>
	</div>
	<div class="form_row">
		<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" />
		<label for="url" ><?php _e('Website'); ?></label>
	</div>
 
</div>
 
<!-- 有资料的访客 -->
<?php if ( $comment_author != "" ) : ?>
	<!-- 隐藏取消按钮, 隐藏资料输入框 -->
	<script type="text/javascript">setStyleDisplay('hide_author_info','none');setStyleDisplay('author_info','none');</script>
<?php endif; ?>

<!--引用用代码结束-->

<?php endif; ?>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->
<div id="icons"><?php if (function_exists('highslide_emoticons')) : ?>
	<?php highslide_emoticons(); ?>
<?php endif; ?></div>
<p class="text"><textarea name="comment" id="comment" cols="105" rows="10" tabindex="4" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
</p>

<div id="submit"><input name="submit" type="submit" id="submit" class="submit" tabindex="5" value="发送" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />




</div>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>

<?php endif; // if you delete this the sky will fall on your head ?>
</div>