<?php
/*
Theme Name: A9
Version: 1.9.1
File Name: footer.php
*/
?>
</div> <!-- #wrapper -->

<div id="footer">

	<p>
		<a href="<?php echo get_option('home'); ?>/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> is <strong style="color:#992">Powered</strong> by
		<a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress<?php echo ' ' , get_bloginfo ( 'version' ); ?></a>, 
		<strong style="color:#a61">A9</strong> Theme by <a href="http://kan.willin.org/" title="A9 designer">Willin Kan</a>, <strong style="color:#496">Valid</strong> <a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.1">XHTML 1.1</a>
		&amp; <a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3" title="This page validates as CSS 3.0">CSS 3.0</a> 
		
		<strong style="color:#a35">Coded but IE</strong>

		<br />
		<a class="rss" href="<?php bloginfo('rss2_url'); ?>" title="文章(RSS)">Entries (RSS)</a>
		and <a href="<?php bloginfo('comments_rss2_url'); ?>" title="評論(RSS)">Comments (RSS)</a> .
		<strong style="color:#57d">Optimized</strong> loading <?php echo get_num_queries(); ?> queries, <?php timer_stop(1); ?> seconds. 
<?php
if ( function_exists('wp_gzip') ) { ?><strong style="color:#94a">Gzipped</strong><?php } // 啟用 gzip 才出現
?>
　
<?php
wp_register('', '　');
$comment_author_email = isset($_COOKIE['comment_author_email_' . COOKIEHASH]) ? $_COOKIE['comment_author_email_' . COOKIEHASH] : '';
if ( $comment_author_email == get_bloginfo ('admin_email') ) { wp_loginout(); } // 只有博主才看得到 '登入'
?>

	</p>
</div>

<?php wp_footer(); ?>

</body>
</html>