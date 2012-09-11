<?php
	$desc = false;
	$anchor_text = $href = filter_var(trim($post->post_content), FILTER_VALIDATE_URL);
	$matches = array();
	if(!$href && preg_match('/<a [^>]*href=[\"\']?([^\"\'\s]+)/i', $post->post_content, $matches)) {
		$anchor_text = $href = $matches[1];
		$desc = get_the_excerpt();
	}
	if($post->post_title) {
		$anchor_text = $post->post_title;
	}
?>
					<div class="date-container"><span class="date"><?php the_time(' j  F,  Y'); ?></span></div>
					<div class="postContent"><?php the_content(''); ?></div>
					<div class="postInfo">
						<div class="postTags"><h2><a href="<?php echo $href; ?>" title="<?php echo $anchor_text; ?>"><?php echo $anchor_text; ?></a></h2></div>
						<div class="postNotes"><?php comments_popup_link(__('0 评论'), __('1 评论'), __('%  评论')); ?></div>
						<div class="clear"></div>
					</div>