					<div class="date-container"><span class="date"><?php the_time(' j  F,  Y'); ?></span></div>
					<div class="postContent">
						<div class="postHead"><?php the_post_thumbnail(array(500,500)); ?></div>
						<?php the_content(''); ?>
						<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
					</div>