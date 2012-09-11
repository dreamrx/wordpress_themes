<?php
/*
Theme Name: A9
Version: 1.9.1
File Name: functions.php
*/

/* PHP warning message */
//error_reporting(E_ALL & ~E_NOTICE); // 偵錯用

/* Widgets API */
/*
if ( function_exists('register_sidebar') ) { // 不用
  register_sidebar(array(
    'name'=>'A9 '.__('Activate').__('Widgets'),
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
}
*/
// -- END ----------------------------------------

$host = $_SERVER['HTTP_HOST'];
$localhost = strstr($host, '192.168') || strstr($host, '127.0.0') || stristr($host, 'localhost') ? 1 : 0; // 判斷是否在本地

/* WordPress script loading  */
if ( !is_admin() ) { // 後台不用
  if ( $localhost == 0 ) { // 本地調試不用
    function my_init_method() {
      wp_deregister_script( 'jquery' ); // 取消原有的 jquery 定義
      wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.2.3/jquery.min.js', '', '1.2.3' ); // 自定義 jquery 文件位址
    }    
  add_action('init', 'my_init_method'); // 加入功能, 前台使用 wp_enqueue_script( '名稱' ) 加載
  }
wp_enqueue_script( 'a9', get_bloginfo('template_directory').'/a9.js', array('jquery'), '1.9.1', 0 ); // 全新自定義 script, 同時加載 
}
// -- END ----------------------------------------

/* HTTP Gzip */
if ( $localhost == 0 ) { // 本地調試不用
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


/* UTF-8 substr() for none mb_substr() */
if ( !function_exists('mb_substr') ) {
  function mb_substr( $str, $start, $length, $encoding ) {
    return preg_replace( '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $start . '}'.
    '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $length . '}).*#s', '$1', $str);
  }
}

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
  } elseif ( is_tag() )      { $description = $blog_name . "有關 '" . single_tag_title('', false) . "' 的文章";
  } elseif ( is_category() ) { $description = $blog_name . "有關 '" . single_cat_title('', false) . "' 的文章";
  } elseif ( is_archive() )  { $description = $blog_name . "在: '" . trim( wp_title('', false) ) . "' 的文章";
  } elseif ( is_search() )   { $description = $blog_name . ": '" . esc_html( $s, 1 ) . "' 的搜索結果";
  } else { $description = $blog_name . "有關 '" . trim( wp_title('', false) ) . "' 的文章";
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
  } elseif ( is_home () )    { $keywords = "willin, kan, wordpress"; // 首頁要自己加
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


/* wp_list_comments() callback */
function mytheme_comment($comment, $args, $depth) {
 $GLOBALS['comment'] = $comment; ?>
 <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
   <div id="div-comment-<?php comment_ID(); ?>">
     <div class="comment-author vcard">
       <?php if (($comment->comment_author_email) == get_bloginfo ('admin_email')){ ?>
       <img src="<?php echo bloginfo('template_directory'),'/img/my-avatar.gif'; ?>" alt="" class="avatar" />
       <?php } else { echo my_avatar($comment->comment_author_email, $size = '42', $default = get_bloginfo('template_directory') . '/img/default.jpg'); } ?>
       <?php printf( ('<cite>%s ~</cite>'), get_comment_author_link() ); ?>
     </div>
     <div class="comment-meta commentmetadata"><a href="<?php echo esc_attr( get_comment_link( $comment->comment_ID ) ); ?>"><?php echo get_comment_date(), ' ', get_comment_time(); time_ago(); ?></a>
      <?php edit_comment_link(__('(Edit)'),' - ',''); ?></div>
      <?php comment_text(); ?>
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.'); ?></em>
         <br />
      <?php endif; ?>
     <div class="reply">
       <?php comment_reply_link( array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
     </div>

   </div>
<?php }
// -- END ----------------------------------------


/* Mini Gavatar Cache by Willin Kan. */
function my_avatar( $email, $size = '42', $default = '', $alt = false ) {
  $alt = (false === $alt) ? '' : esc_attr( $alt );
  $f = md5( strtolower( $email ) );
  $a = get_bloginfo('wpurl'). '/avatar/'. $f. '.jpg';
  $e = ABSPATH. 'avatar/'. $f. '.jpg';
  $t = 1209600; //設定14天, 單位:秒
  if ( empty($default) ) $default = get_bloginfo('template_directory'). '/img/default.jpg';
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


/* Time Ago by Willin Kan. */
function time_ago( $type = 'commennt', $day = 14 ) {
  $d = $type == 'post' ? 'get_post_time' : 'get_comment_time';
  if (date('U') - $d('U') > 60*60*24*$day) return;
  printf(' (%s ago)', human_time_diff($d('U'), current_time('timestamp')));
}
// -- END ----------------------------------------


/* Mini Pagenavi v1.0 by Willin Kan. */
function pagenavi( $p = 2 ) { // 取當前頁前後各 2 頁
  if ( is_singular() ) return; // 文章與插頁不用
  global $wp_query, $paged;
  $max_page = $wp_query->max_num_pages;
  if ( $max_page == 1 ) return; // 只有一頁不用
  if ( empty( $paged ) ) $paged = 1;
  // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; // 頁數
  if ( $paged > $p + 1 ) p_link( 1, __('first') );
  if ( $paged > $p + 2 ) echo "<span class='dots'> ... </span>";
  for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { // 中間頁
    if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<span class='page-numbers current'>{$i}</span> " : p_link( $i );
  }
  if ( $paged < $max_page - $p - 1 ) echo "<span class='dots'> ... </span>";
  if ( $paged < $max_page - $p ) p_link( $max_page, __('last') );
}
function p_link( $i, $title = '' ) {
  if ( $title == '' ) $title = __('Pages')." {$i}";
  echo "<a class='page-numbers' href='", esc_attr( get_pagenum_link( $i ) ), "' title='{$title}'>{$i}</a> ";
}
// -- END ----------------------------------------

/* <<小牆>> Anti-Spam v1.81 by Willin Kan. */
//建立
class anti_spam {
  function anti_spam() {
    if ( !current_user_can('level_0') ) {
      add_action('template_redirect', array($this, 'w_tb'), 1);
      add_action('init', array($this, 'gate'), 1);
      add_action('preprocess_comment', array($this, 'sink'), 1);
    }
  }
  //設欄位
  function w_tb() {
    if ( is_singular() ) {
      ob_start(create_function('$input','return preg_replace("#textarea(.*?)name=([\"\'])comment([\"\'])(.+)/textarea>#",
      "textarea$1name=$2w$3$4/textarea><textarea name=\"comment\" cols=\"100%\" rows=\"4\" style=\"display:none\"></textarea>",$input);') );
    }
  }
  //檢查
  function gate() {
    if ( !empty($_POST['w']) && empty($_POST['comment']) ) {
      $_POST['comment'] = $_POST['w'];
    } else {
      $request = $_SERVER['REQUEST_URI'];
      $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']         : '隱瞞';
      $IP      = isset($_SERVER["HTTP_VIA"])     ? $_SERVER["HTTP_X_FORWARDED_FOR"]. ' (透過代理)' : $_SERVER["REMOTE_ADDR"];
      $way     = isset($_POST['w'])              ? '手動操作'                       : '未經評論表格';
      $spamcom = isset($_POST['comment'])        ? $_POST['comment']                : null;
      $_POST['spam_confirmed'] = "請求: ". $request. "\n來路: ". $referer. "\nIP: ". $IP. "\n方式: ". $way. "\n內容: ". $spamcom. "\n -- 記錄成功 --";
    }
  }
  //處理
  function sink( $comment ) {
  $email = $comment['comment_author_email'];
  $g = 'http://www.gravatar.com/avatar/'. md5( strtolower( $email ) ). '?d=404';
  $headers = @get_headers( $g );
    if ( !preg_match("|200|", $headers[0]) ) {
      add_filter('pre_comment_approved', create_function('', 'return "0";'));
    }
    if ( !empty($_POST['spam_confirmed']) ) {
      if ( in_array( $comment['comment_type'], array('pingback', 'trackback') ) ) return $comment; //不管 Trackbacks/Pingbacks
      //方法一: 直接擋掉, 將 die(); 前面兩斜線刪除即可.
      //die();
      //方法二: 標記為 spam, 留在資料庫檢查是否誤判.
      add_filter('pre_comment_approved', create_function('', 'return "spam";'));
      $comment['comment_content'] = "[ 小牆判斷這是Spam! ]\n". $_POST['spam_confirmed'];
    }
    return $comment;
  }
}
$anti_spam = new anti_spam();
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
    $subject = '您在 [' . get_option("blogname") . '] 的留言有了回應';
    $message = '
      <div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px; border-radius:5px;">
      <p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
      <p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />'
       . trim(get_comment($parent_id)->comment_content) . '</p>
      <p>' . trim($comment->comment_author) . ' 給您的回應:<br />'
       . trim($comment->comment_content) . '<br /></p>
      <p>您可以點擊 <a href="' . esc_attr(get_comment_link($parent_id, array('type' => 'comment'))) . '">查看回應完整內容</a></p>
      <p>歡迎再度光臨 <a href="' . get_option('home') . '">' . get_option('blogname') . '</a></p>
      <p>(此郵件由系統自動發出, 請勿回覆.)</p>
      </div>';
    $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
    $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
    wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
  }
}
add_action('comment_post', 'comment_mail_notify');
// -- END ----------------------------------------


/* 貼圖 by willin kan. */
function embed_images($content) {
  $content = preg_replace('/\[img=?\]*(.*?)(\[\/img)?\]/e', '"<img src=\"$1\" alt=\"" . basename("$1") . "\" />"', $content);
  return $content;
}
add_filter('comment_text', 'embed_images'); 
// -- END ----------------------------------------

?>