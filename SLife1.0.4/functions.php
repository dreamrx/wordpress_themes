<?php
/**
 * @package WordPress
 * @subpackage slife_Theme
 */

/* is_localhost */
function is_localhost() {
  $host = $_SERVER['HTTP_HOST'];
  $localhost = strstr($host, '192.168.1') || strstr($host, '127.0.0') || stristr($host, 'localhost') ? 1 : 0;
  return $localhost;
}
/* WordPress script loading  */
if ( !is_admin() ) { // 後台不用
  if ( !is_localhost() ) { // 本地調試不用
    function my_init_method() {
      wp_deregister_script( 'jquery' ); // 取消原有的 jquery 定義
      wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js', '', '1.4.2' ); // 自定義 jquery 文件位址
    }    
  add_action('init', 'my_init_method'); // 加入功能, 前台使用 wp_enqueue_script( '名稱' ) 加載
  }
wp_enqueue_script( 'all', get_bloginfo('template_directory').'/all.js', array('jquery'), '1.0.1', 0 ); // 全新自定義 script, 同時加載 
}
// -- END ----------------------------------------
/*中文截断专用函数*/
if ( !function_exists('cut_str')) {
function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
	{
		if($code == 'UTF-8')
		{
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
			preg_match_all($pa, $string, $t_string);
			if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."...";
			return join('', array_slice($t_string[0], $start, $sublen));
		}
		else
		{
			$start = $start*2;
			$sublen = $sublen*2;
			$strlen = strlen($string);
			$tmpstr = '';
			for($i=0; $i<$strlen; $i++)
			{
				if($i>=$start && $i<($start+$sublen))
				{
					if(ord(substr($string, $i, 1))>129) $tmpstr.= substr($string, $i, 2);
					else $tmpstr.= substr($string, $i, 1);
				} 
				if(ord(substr($string, $i, 1))>129) $i++;
			}
			if(strlen($tmpstr)<$strlen ) $tmpstr.= "...";
			return $tmpstr;
		}
}
}
// -- END ----------------------------------------
/*最近评论*/
function recentcomments($commentsnum = 10, $extractlength = 16, $extractuser = '') {
	global $wpdb;
	$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email, comment_content AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND comment_author != '$extractuser' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $commentsnum";
	$comments = $wpdb->get_results($sql);
	foreach ($comments as $comment) {
	$output .= "\n<li>".my_avatar($comment->comment_author_email, 32 ,$alt)."<a href=\"" . htmlspecialchars(get_comment_link( $comment->comment_ID )) . "\" title=\"on " .$comment->post_title . "\">" . cut_str(strip_tags($comment->com_excerpt),$extractlength) . "</a><br /><span class='comment_author'>by " . $comment->comment_author . "</span></li>";	//new
	}
	$output = convert_smilies($output);
	return $output;
}
// -- END ----------------------------------------
/*获得热评文章*/
function simple_get_most_viewed($posts_num=10, $days=30){
global $wpdb;
$sql = "SELECT `ID` , `post_title` , `comment_count` FROM $wpdb->posts
WHERE `post_type` = 'post' AND TO_DAYS( now( ) ) - TO_DAYS( `post_date` ) < $days
ORDER BY `comment_count` DESC LIMIT 0 , $posts_num ";
$posts = $wpdb->get_results($sql);
$output = "";
foreach ($posts as $post){
$output .= "\n<li><a href= \"".get_permalink($post->ID)."\" rel=\"bookmark\" title=\"".$post->post_title."\" >".$post->post_title."</a></li> ";
}
echo $output;
}
//获得热评文章结束
//welcome message
function WelcomeCommentAuthorBack($email = ''){
	if(empty($email)){
		return;
	}
	global $wpdb;

	$past_30days = gmdate('Y-m-d H:i:s',((time()-(24*60*60*30))+(get_option('gmt_offset')*3600)));
	$sql = "SELECT count(comment_author_email) AS times FROM $wpdb->comments
					WHERE comment_approved = '1'
					AND comment_author_email = '$email'
					AND comment_date >= '$past_30days'";
	$times = $wpdb->get_results($sql);
	$times = ($times[0]->times) ? $times[0]->times : 0;
	$message = $times ? sprintf(__('过去30天内您评论了<strong>%1$s</strong>次，感谢关注~' ), $times) : '您很久都没有留言了，这次想说点什么吗？';

	return $message;
}
//end
/* HTTP Gzip */
if ( !is_localhost() ) { // 本地調試不用
function wp_gzip() {
// Dont use on Admin HTML editor
if ( strstr($_SERVER['REQUEST_URI'], '/js/tinymce') )
return false;
// Can't use zlib.output_compression and ob_gzhandler at the same time
if ( ( ini_get('zlib.output_compression') == 'On' || ini_get('zlib.output_compression_level') > 0 ) || ini_get('output_handler') == 'ob_gzhandler' )
return false;
// Load HTTP Compression if correct extension is loaded
if (extension_loaded('zlib') && !ob_start('ob_gzhandler'))
    ob_start();
}
add_action('init', 'wp_gzip');
}
// -- END ----------------------------------------
/* comment_mail_notify v1.0 by willin kan. (有勾選欄, 由訪客決定) */
function comment_mail_notify($comment_id) {
  $admin_notify = '1'; // admin 要不要收回覆通知 ( '1'=要 ; '0'=不要 )
  $admin_email = get_bloginfo ('admin_email'); // $admin_email 可改為你指定的 e-mail.
  $comment = get_comment($comment_id);
  $comment_author_email = trim($comment->comment_author_email);
  $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
  global $wpdb;
  if ($wpdb->query("Describe {$wpdb->comments} comment_mail_notify") == '')
    $wpdb->query("ALTER TABLE {$wpdb->comments} ADD COLUMN comment_mail_notify TINYINT NOT NULL DEFAULT 0;");
  if (($comment_author_email != $admin_email && isset($_POST['comment_mail_notify'])) || ($comment_author_email == $admin_email && $admin_notify == '1'))
    $wpdb->query("UPDATE {$wpdb->comments} SET comment_mail_notify='1' WHERE comment_ID='$comment_id'");
  $notify = $parent_id ? get_comment($parent_id)->comment_mail_notify : '0';
  $spam_confirmed = $comment->comment_approved;
  if ($parent_id != '' && $spam_confirmed != 'spam' && $notify == '1') {
    $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); // e-mail 發出點, no-reply 可改為可用的 e-mail.
    $to = trim(get_comment($parent_id)->comment_author_email);
    $subject = '您在 [' . get_option("blogname") . '] 的留言有了回复';
    $message = '
    <div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px; border-radius:5px;">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />'
       . trim(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . ' 給您的回复:<br />'
       . trim($comment->comment_content) . '<br /></p>
      <p>您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回复完整内容</a></p>
      <p>欢迎再次点击 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p>(此邮件又系统发出,请勿回复.)</p>
    </div>';
	$message = convert_smilies($message);
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}
add_action('comment_post', 'comment_mail_notify');
/* 自動加勾選欄 */
function add_checkbox() {
  echo '<input type="checkbox" name="comment_mail_notify" id="comment_mail_notify" value="comment_mail_notify" checked="checked" style="margin:7px 0 0 6px;" /><label for="comment_mail_notify">有人回复时邮件通知我</label>';
}
add_action('comment_form', 'add_checkbox');
// -- END ----------------------------------------
/* UTF-8 substr() for none mb_substr() */
if ( !function_exists('mb_substr') ) {
  function mb_substr( $str, $start, $length, $encoding ) {
    return preg_replace( '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start . '}'.
    '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $length . '}).*#s', '$1', $str);
  }
}
/* Time Ago by Willin Kan. */
function time_ago( $type = 'commennt', $day = 14 ) {
  $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
  if (date('U') - $d('U') > 60*60*24*$day) return;
  printf(' (%s前)', human_time_diff($d('U'), current_time('timestamp')));
}
// -- END ----------------------------------------
/*添加版权信息*/
function copyright($content) {
	if(is_single()||is_feed()) {
		$content.='<div style="border-left:3px solid #999999;padding-left:5px;margin:10px 0 0 0">
<span style="font-weight: bold;">版权所有&copy; 闲云野鹤 </span>| 本文采用 <a title="署名-非商业性使用-相同方式共享" rel="external nofollow" target="_blank" href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.zh">BY-NC-SA</a> 进行授权
<br/>
转载需注明 转自: 《<a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a>》
<div id="share">分享此篇文章到:<a rel="nofollow" id="facebook-share" title="Facebook">Facebook</a><a rel="nofollow" id="twitter-share" title="Twitter">Twitter</a><a rel="nofollow" id="delicious-share" title="Delicious">Delicious</a><a rel="nofollow" id="kaixin001-share" title="开心网">开心网</a><a rel="nofollow" id="renren-share" title="人人网">人人网</a><a rel="nofollow" id="douban-share" title="豆瓣">豆瓣</a><a rel="nofollow" id="sina-share" title="新浪微博">新浪微博</a><a rel="nofollow" id="netease-share" title="网易微博">网易微博</a><a rel="nofollow" id="tencent-share" title="腾讯微博">腾讯微博</a></div>
</div>';
	}
	return $content;
}
add_filter ('the_content', 'copyright');
// -- END ----------------------------------------
/* Auto-description v1.3 by Willin Kan. */
function head_meta_desc() {
  global $s, $post;
  $description = '';
  $blog_name = get_bloginfo('name');
  if ( is_singular() ) {
    if( !empty( $post->post_excerpt ) ) {
      $text = $post->post_excerpt;
    } else {
      $text = $post->post_content;
    }
    $description = trim( str_replace( array( "\r\n", "\r", "\n", "　", " "), " ", str_replace( "\"", "'", strip_tags( $text ) ) ) );
    if ( !( $description ) ) $description = $blog_name . " - " . trim( wp_title('', false) );
  } elseif ( is_home () )    { $description = $blog_name . " - " . get_bloginfo('description') . " 關注 WordPress"; // 首頁要自己加
  } elseif ( is_tag() )      { $description = $blog_name . "关于 '" . single_tag_title('', false) . "' 的文章";
  } elseif ( is_category() ) { $description = $blog_name . "关于 '" . single_cat_title('', false) . "' 的文章";
  } elseif ( is_archive() )  { $description = $blog_name . "在: '" . trim( wp_title('', false) ) . "' 的文章";
  } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
  } else { $description = $blog_name . "关于 '" . trim( wp_title('', false) ) . "' 的文章";
  }
  $description = mb_substr( $description, 0, 97, 'utf-8' ) . '..';
  echo "<meta name=\"description\" content=\"$description\" />\n";
}
add_action('wp_head', 'head_meta_desc');
/* Auto-keywords v1.6 by Willin Kan. */
function tags_category_to_keywords() {
  global $s, $post;
  $keywords = '';
  if ( is_single() ) {
    if ( get_the_tags( $post->ID ) ) {
      foreach ( get_the_tags( $post->ID ) as $tag ) $keywords .= $tag->name . ', ';
    }
    foreach ( get_the_category( $post->ID ) as $category ) $keywords .= $category->cat_name . ', ';
    $keywords = substr_replace( $keywords, "" , -2 );
  } elseif ( is_home () )    { $keywords = "demo, wordpress"; // 首頁要自己加
  } elseif ( is_tag() )      { $keywords = single_tag_title('', false);
  } elseif ( is_category() ) { $keywords = single_cat_title('', false);
  } elseif ( is_search() )   { $keywords = esc_html( $s, 1 );
  } else { $keywords = trim( wp_title('', false) );
  }
  if ( $keywords ) {
    echo "<meta name=\"keywords\" content=\"$keywords\" />\n";
  }
}
add_action('wp_head', 'tags_category_to_keywords');
// -- END ----------------------------------------
/* Mini Pagenavi v1.0 by Willin Kan. Edit by zwwooooo */
if ( !function_exists('pagenavi') ) {
	function pagenavi( $p = 5 ) { // 取当前页前后各 2 页
		if ( is_singular() ) return; // 文章与插页不用
		global $wp_query, $paged;
		$max_page = $wp_query->max_num_pages;
		if ( $max_page == 1 ) return; // 只有一页不用
		if ( empty( $paged ) ) $paged = 1;
		
		if ( $paged > 1 ) p_link( $paged - 1, '上一页', '« 上一页' );/* 如果当前页大于1就显示上一页链接 */
		if ( $paged > $p + 1 ) p_link( 1, '最前页' );
		if ( $paged > $p + 2 ) echo '... ';
		for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { // 中间页
			if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='page-numbers current'>{$i}</span> " : p_link( $i );
		}
		if ( $paged < $max_page - $p - 1 ) echo '... ';
		if ( $paged < $max_page - $p ) p_link( $max_page, '最后页' );
		if ( $paged < $max_page ) p_link( $paged + 1,'下一页', '下一页 »' );/* 如果当前页不是最后一页显示下一页链接 */
	}
	function p_link( $i, $title = '', $linktype = '' ) {
		if ( $title == '' ) $title = "第 {$i} 页";
		if ( $linktype == '' ) { $linktext = $i; } else { $linktext = $linktype; }
		echo "<a class='page-numbers' href='", esc_html( get_pagenum_link( $i ) ), "' title='{$title}'>{$linktext}</a> ";
	}
}
// -- END ----------------------------------------
/**添加 flash player */
function myplayer($atts, $content=null){
extract(shortcode_atts(array("auto"=>'no',"loop"=>'no'),$atts));
return '<object type="application/x-shockwave-flash" data="'.get_bloginfo("template_url").'/player.swf?soundFile='.$content.'" width="290" height="30">
<param name="movie" value="'.get_bloginfo("template_url").'/player.swf?soundFile='.$content.'" />
<param name="wmode" value="transparent" />
</object>';
}
add_shortcode('music','myplayer');
/* Mini Gavatar Cache by Willin Kan. */
function my_avatar( $email, $size = '42', $default = '', $alt = false ) {
  $alt = (false === $alt) ? '' : esc_attr( $alt );
  $f = md5( strtolower( $email ) );
  $a = get_bloginfo('wpurl'). '/avatar/'. $f. '.jpg';// 如果想放在 wp-content 路徑之下, 改為 $a = WP_CONTENT_URL;
  $e = ABSPATH. 'avatar/'. $f. '.jpg';// 如果想放在 wp-content 路徑之下, 改為 $e = WP_CONTENT_DIR. '/avatar/'. $f. '.jpg';
  $t = 1209600; //設定14天, 單位:秒
  if ( empty($default) ) $default = get_bloginfo('template_directory'). '/images/my-avatar.gif';
  if ( !is_file($e) || (time() - filemtime($e)) > $t ){ //當頭像不存在或文件超過14天才更新
    $r = get_option('avatar_rating');
    //$g = sprintf( "http://%d.gravatar.com", ( hexdec( $f{0} ) % 2 ) ). '/avatar/'. $f. '?s='. $size. '&d='. $default. '&r='. $r; // wp 3.0 的服務器
    $g = 'http://www.gravatar.com/avatar/'. $f. '?s='. $size. '&d='. $default. '&r='. $r; // 舊服務器 (哪個快就開哪個)
    copy($g, $e); $a = esc_attr($g);
  }
  if (filesize($e) < 500) copy($default, $e);
  $avatar = "<img title='{$alt}' alt='{$alt}' src='{$a}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
  return apply_filters('my_avatar', $avatar, $email, $size, $default, $alt);
}
// -- END ----------------------------------------
/* 貼圖 by willin kan. */
function embed_images($content) {
  $content = preg_replace('/\[img=?\]*(.*?)(\[\/img)?\]/e', '"<img src=\"$1\" alt=\"" . basename("$1") . "\" />"', $content);
  return $content;
}
add_filter('comment_text', 'embed_images'); 
// -- END ----------------------------------------
/* 文章开头插入广告 */
function insertAD($content) {
	if(is_single()) {
		$html = '<p class="ad"></p>';//文章开头广告
		$content = $html . $content;
	}
	return $content;
}
add_filter ('the_content', 'insertAD');
// -- END ----------------------------------------
?>
<?php
/* Widgets API */
if (function_exists('register_sidebar')){
	register_sidebar(array(
		'before_widget' => '<ul style="clear:both;"><li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li></ul>',
    'before_title' => '<h3 class="widgettitle">',
    'after_title' => '</h3>',
	));
}
// -- END ----------------------------------------
?>
<?php
function show_posts_link() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1);
}
?>
<?php
function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;
	global $commentcount;
	if(!$commentcount) { //初始化楼层计数器
		$page = get_query_var('cpage')-1;
		$cpp=get_option('comments_per_page');//获取每页评论数
		$commentcount = $cpp * $page;
	}
   ?>
   <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
     <div id="div-comment-<?php comment_ID(); ?>">
     <div class="comment-author vcard">
       <?php if (($comment->comment_author_email) == get_bloginfo ('admin_email')){ ?>
       <img src="<?php echo bloginfo('template_directory'),'/images/my-avatar.gif'; ?>" alt="博主" class="avatar" />
       <?php } else { echo my_avatar($comment->comment_author_email, $size = '32', $default = get_bloginfo('template_directory') . '/images/default.jpg'); } ?>
     </div>
      <div class="commentmetadata">
      <p style="margin:0;">&nbsp;&nbsp;&nbsp;<span class="admin_ico"><?php comment_author_link() ?></span><span class="date_ico"><a href="<?php echo esc_attr( get_comment_link( $comment->comment_ID ) ); ?>"><?php echo get_comment_date(), ' ', get_comment_time(); time_ago(); ?></a></span><span class="reply_ico"><?php comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span><span><?php edit_comment_link(__('(Edit)'),''); ?>&nbsp;</span><span style="float:right;z-index:-1;font-family:'Georgia';font-size:40px;line-height:1em;color:#ccc;margin:0;"><?php if(!$parent_id = $comment->comment_parent) {printf('%1$s楼', ++$commentcount);}?>&nbsp;</span></p>
      </div>
	  <?php if ($comment->comment_approved == '0') : ?>
         <p style="font-size:10px; background:#fafafa; padding:2px 8px; margin:12px 0 0 0; text-align:center;"><em><?php _e('Your comment is awaiting moderation.') ?></em></p>
         <br />
      <?php endif; ?>
	  <?php comment_text() ?>
      </div>
<?php } ?>