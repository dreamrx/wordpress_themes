<?php
 if ( function_exists('register_sidebar') )
 register_sidebar();
 /**
 * 广告代码添加到<div class="single_ads">后面
 */
function bl_insert_ad_code_filter( $content ) {
	global $id;
	if ( !is_single() ) {
		return $content;
	}
	$html = '<div class="single_ads">
	
	<a href=" http://my.laoxuehost.com/aff.php?aff=187" target=_blank><img src=" http://laoxuehost.com/wp-content/uploads/2010/05/468.gif" border=0></a>

	</div>';
		return preg_replace("#\<(a|span) id\=\"more-$id\"\>\</\\1\>#", $html."$0", $content, 1);
	return $content;
}
 
add_filter('the_content', 'bl_insert_ad_code_filter', 50);



// no more jumping for read more link

function remove_more_jump_link($link) {return preg_replace('/#more-\d+/i','',$link);}
add_filter('the_content_more_link', 'remove_more_jump_link');

?>