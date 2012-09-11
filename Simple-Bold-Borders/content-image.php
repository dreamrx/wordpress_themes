					<div class="date-container"><span class="date"><?php the_time(' j  F,  Y'); ?></span></div>
					<div class="postContent"><?php the_content(''); ?></div>
					<div class="postInfo">
						<div class="postTags"><h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2></div>
						<div class="postNotes"><?php comments_popup_link(__('0 评论'), __('1 评论'), __('%  评论')); ?></div>
						<div class="clear"></div>
					</div>