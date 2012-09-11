<?php
if ( function_exists('register_nav_menus') ) {
	register_nav_menus(array('primary' => '头部导航栏'));
}

function ajax_post(){
	if( isset($_GET['action'])&& $_GET['action'] == 'ajax_post'){
		query_posts("paged=" . $_GET['pag']);
		if(have_posts()){while (have_posts()):the_post();?>
			<div id="essay-<?php the_ID(); ?>" class="essay-home">
				<div class="essay-ico ico-<?php $category = get_the_category();echo $category[0]->category_nicename; ?>"></div>
				<div class="essay-title">
					<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				</div>
				<div class="essay-msg">
					<?php the_time('Y年m月d日'); ?>&nbsp;>&nbsp;<?php the_category(',') ?>&nbsp;>&nbsp;<?php the_tags('', '&nbsp;.&nbsp;', ' '); ?>&nbsp;&isin;&nbsp;<?php comments_popup_link('我抢沙发', '1 条评论', '% 条评论'); ?>
				</div>
			</div>
		<?php endwhile;}
		die();
		}else{return;}
}
add_action('init', 'ajax_post');

function ajax_comment(){
	if( isset($_GET['action'])&& $_GET['action'] == 'ajax_comment'  ){
		$comments = get_comments('post_id='. $_GET['post']);
		if( 'desc' != get_option('comment_order') ){
			$comments = array_reverse($comments);
		}
		wp_list_comments('callback=mytheme_comment&type=comment&page=' . $_GET['page'] . '&per_page=' . get_option('comments_per_page'), $comments);
	die;
	}
}
add_action('init', 'ajax_comment');

if ( !function_exists('index') ) {
	function index( $p = 2 ) { 
		if ( is_singular() ) return;
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return; 
		if ( empty( $paged ) ) $paged = 1;
		if ( $paged == 1 ) echo "<a id='prev' style='display:none' href='#'> 上一页 </a>";
		if ( $paged > 1 ) echo "<a id='prev' href='", esc_html( get_pagenum_link( $paged - 1 ) ), "'>上一页</a> ";
		echo "<span id='nnum'>" . $paged . "</span>/<span id='mnum'>" . $max_page . "</span>";
		if ( $paged < $max_page  ) echo "<a id='next' href='", esc_html( get_pagenum_link( $paged + 1) ), "'>下一页</a> ";
	}
}

function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;?>
<li id="li-comment-<?php comment_ID() ?>" >
	<div id="comment-<?php comment_ID(); ?>" class="comment-body">
		<div class="commentmeta"><?php echo get_avatar( $comment, $size = '35'); ?></div>
		<div class="comments">
			<?php if ($comment->comment_approved == '0') : ?>
			<em><?php _e('Your comment is awaiting moderation.') ?></em>
			<?php endif; ?>
			<div class="reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('@')))) ?></div>
			<div class="vcard"><?php printf(__('<span class="name">%s</span>'), get_comment_author_link()) ?><?php if (!$parent_id=$comment->comment_parent) {printf(__('<span class="date-time">%1$s %2$s</span>'),get_comment_date(),get_comment_time());} ?></div>
			<div class="text"><?php comment_text() ?></div>
		</div>
	</div>
<?php
}

include('includes/control.php');

?>