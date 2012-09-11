<?php
/**
 * @package WordPress
 * @subpackage SLife_Theme
 */
?>
<div style="float:right; width:50%">
<h3>热门文章</h3>
<ul>
<?php
$post_num = 5; // 數量設定.
$exclude_id = $post->ID;
$myposts = $wpdb->get_results("
  SELECT ID, post_title FROM $wpdb->posts
  WHERE ID != $exclude_id
  AND post_status = 'publish'
  AND post_type = 'post'
  ORDER BY comment_count
  DESC LIMIT $post_num
"); // get_results() since 0.71 /wp-includes/wp-db.php 
  foreach($myposts as $mypost) {
    echo '<li><a href="', get_permalink($mypost->ID), '">', $mypost->post_title, '</a></li>';
  $exclude_id .= ',' . $post->ID; // 記錄文章 ID, 讓 Related Posts 不重覆.(單獨使用可刪此行)
  }
?>
</ul>
</div>
<div style="float:right; width:45%">
<h3>相关文章</h3>
<ul>
<?php
$post_num = 5; // 數量設定.
//$exclude_id = $post->ID; // 單獨使用要開此行
global $posttags; $i = 0;
if ( $posttags ) { $tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->name . ',';
$args = array(
	'post_status' => 'publish',
	'tag_slug__in' => explode(',', $tags), // 只選 tags 的文章.
	'post__not_in' => explode(',', $exclude_id), // 排除已出現過的文章.
	'caller_get_posts' => 1, // 排除置頂文章.
	'orderby' => 'comment_date', // 依評論日期排序.
	'posts_per_page' => $post_num
);
query_posts($args); // query_posts() since 2.0.0 /wp-includes/classes.php
 while( have_posts() ) { the_post(); ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
    $exclude_id .= ',' . $post->ID; $i ++;
 } wp_reset_query();
}
if ( $i < $post_num ) { // 當 tags 文章數量不足, 再取 category 補足.
$cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
$args = array(
	'category__in' => explode(',', $cats), // 只選 category 的文章.
	'post__not_in' => explode(',', $exclude_id),
	'caller_get_posts' => 1,
	'orderby' => 'comment_date',
	'posts_per_page' => $post_num - $i
);
query_posts($args);
 while( have_posts() ) { the_post(); ?>
    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php
    $i ++;
 } wp_reset_query();
}
if ( $i  == 0 )  echo '<li>尚无相关文章</li>';
?>
</ul>
</div>
<div style="clear:both;"></div> 