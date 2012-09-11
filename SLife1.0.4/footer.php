<?php
/**
 * @package WordPress
 * @subpackage SLife_Theme
 */
?>
<div id="footer">
<p>&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?> | Powered by <a href="http://wordpress.org/">WordPress</a> | Theme by <a href="http://blog.xianyunyehe.net/" title="WordPress themes">闲云野鹤</a> | <strong style="color:#496">Valid</strong> <a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0">XHTML 1.0</a>&amp; <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3" title="This page validates as CSS 3.0">CSS 3.0</a> <br /><?php
if ( function_exists('wp_gzip') ) { ?><strong style="color:#94a">Gzipped</strong><?php } // 啟用 gzip 才出現
?>&nbsp;&nbsp;<?php
wp_register('', '　');
$comment_author_email = isset($_COOKIE['comment_author_email_' . COOKIEHASH]) ? $_COOKIE['comment_author_email_' . COOKIEHASH] : '';
if ( $comment_author_email == get_bloginfo ('admin_email') ) { wp_loginout(); } // 只有博主才看得到 '登录'
?></p>
</div> <!-- end footer -->
</div> <!-- end container -->
<?php wp_footer(); ?>
</body>
</html>