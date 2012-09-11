<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="zh">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<title><?php wp_title(' - ', true, 'right'); bloginfo('name'); if (is_home ()) echo " - ", bloginfo('description'); if ($paged > 1) echo ' - Page ', $paged; ?></title>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<?php $sidebar = isset($_COOKIE['sidebar']) ? $_COOKIE['sidebar'] : '';
 if ($sidebar == 'sidebar-center' || $sidebar == 'sidebar-right') { ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/<?php echo $sidebar; ?>.css" media="screen" />
<?php } ?>
<link rel="shorcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.ico" type="image/x-ico" />

<?php wp_head(); ?>

</head>
<body>
<div id="top"></div>
<div id="wrapper">

<div id="header"<?php if (is_single() || is_category()) { ?> style="background:url(<?php bloginfo('stylesheet_directory'); ?>/img/c<?php $cat = get_the_category(); echo $cat[0]->cat_ID; ?>.jpg) no-repeat right #000;"<?php } ?>>
	<div id="cssChanger">
		<a rel="style" title="<?php _e('Left Sidebar') ?>"> ◄ </a>
		<a rel="sidebar-center" title="<?php _e('Show as dropdown') ?>">sidebar</a>
		<a rel="sidebar-right" title="<?php _e('Right Sidebar') ?>"> ► </a>
	</div>
	<div class="bloginfo">
		<div id="logo"></div>
	<?php $hhead = is_home() ? 'h1' : 'div'; ?>
		<<?php echo $hhead; ?> id="site-title"><a rel="bloghome" href="<?php echo get_option('home'); ?>/" title="Home"><?php bloginfo('name') ?></a></<?php echo $hhead; ?>>
		<div class="description"><?php bloginfo('description') ?></div>
	</div>
<div style="clear:both;"></div>
<?php get_search_form(); ?>

		<!-- 以下可放 Banner -->
		<a id="hosting" style="margin-left:40px;" rel="hosting" href="http://atbhost.net/" title="Free web hosting never looked so good.">
			<img src="<?php bloginfo('stylesheet_directory'); ?>/img/atbhostlogo.gif" width="180" height="54" alt=""/></a>

		<noscript class="toggle"><div style="display:inline;color:#f37">This page requires Javascript but it seems to be disabled.</div></noscript>
</div>
