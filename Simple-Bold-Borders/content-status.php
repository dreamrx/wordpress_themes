					<div class="date-container"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><span class="date"><?php the_time('H:i:G  j  F,  Y'); ?></span></a></div>
					<div class="postContent"><a href="<?php the_permalink() ?>"><?php echo get_avatar($post->post_author, 28); ?></a><?php the_content('继续阅读'); ?></div>
					<div class="postNotes"><?php comments_popup_link(__('0 评论'), __('1 评论'), __('%  评论')); ?></div>