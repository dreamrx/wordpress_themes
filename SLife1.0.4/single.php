<?php
/**
 * @package WordPress
 * @subpackage SLife_Theme
 */
?>
<?php get_header();?>
<div id="content">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
<div class="postmetadata"><p><span class="date_ico"><?php the_time('Y-m-d') ?></span> <span class="category_ico"><?php the_category(', ') ?></span><span class="admin_ico"><?php the_author() ?></span><span class="comments_ico"><?php comments_popup_link('抢沙发', '有 1 位童鞋发表了意见', '有 % 位童鞋发表了意见'); ?></span><span class="tags_ico"><?php if (function_exists('the_tags')) { the_tags('', ', ', ''); } ?></span></p></div>
<div class="entry"><?php the_content('<p>Continue reading &rarr;</p>'); ?></div>
<div id="center"><?php include(TEMPLATEPATH . '/query-posts.php'); ?></div>
</div>
<div id="scrollbox">
<ul>
<?php
$counts = $wpdb->get_results("SELECT COUNT(comment_author) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 1 MONTH ) AND user_id='0' AND comment_author != '闲云野鹤' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author ORDER BY cnt DESC LIMIT 30");
$mostactive ='';
foreach ($counts as $count) {
$a = get_bloginfo('wpurl') . '/avatar/' . md5(strtolower($count->comment_author_email)) . '.jpg';
$c_url = $count->comment_author_url;
if ($c_url == '') $c_url = 'http://blog.xianyunyehe.net/';
$mostactive .= '<li>' . '<a rel="external nofollow" target="_blank" href="'. $c_url . '" title="' . $count->comment_author . ' 童鞋本月推荐自己 '. $count->cnt . ' 次"><img src="' . $a . '" alt="' . $count->comment_author . ' ('. $count->cnt . 'comments)" class="avatar" style="margin:0 5px 0 0;width:40px;height:40px;"/></a></li>';
}
echo $mostactive;
?>
</ul>
</div>
<?php comments_template(); ?>
<?php endwhile; else: ?>
<h2 class="notfound">看你干的好事，把我的博客页面搞了一个大窟窿！！</h2>
<div class="entry">
<p><img src="<?php bloginfo('stylesheet_directory'); ?>/images/404.jpg" height="315" width="351" alt="404" style="display:block; margin:0 auto; border:0;"/></p>
</div>
<?php endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>