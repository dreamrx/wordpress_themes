<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php global $page, $paged;wp_title( '|', true, 'right' );bloginfo( 'name' );$site_description = get_bloginfo( 'description', 'display' );if ( $site_description && ( is_home() || is_front_page() ) ) echo " | $site_description";if ( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( '第 %s 页'), max( $paged, $page ) );?></title>
<?php if (is_home()){ 
    $description = "描述";
    $keywords = "关键词";
} elseif (is_single()){    
    $description =  substr(strip_tags($post->post_content),0,220);
    $keywords = "";        
    $tags = wp_get_post_tags($post->ID);
    foreach ($tags as $tag ) {
        $keywords = $keywords . $tag->name . ", ";
    }
}
?>
<meta name="description" content="<?=$description?>" />
<meta name="keywords" content="<?=$keywords?>" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="Feedsky RSS 2.0" href="<?php bloginfo('rss2_url'); ?>"/>

<?php wp_head(); ?>
</head>

<body>
<div id="container">
	<div id="header">
			<h1><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a></h1>
			<div id="nav">
				<?php wp_nav_menu( array('menu' => 'header-menu', 'menu_class' => 'menu' )); ?>
			</div>
	</div>
	<div id="content">