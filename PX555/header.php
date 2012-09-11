<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php include('includes/seo.php'); ?>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css" type="text/css" media="screen" />
<?php include('includes/ico.php'); ?>
<link title="RSS 2.0" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" rel="alternate" />
<?php wp_head(); ?>
</head>
<body>
<div id="wrapper">
<div id="header">
	<div id="logo">
		<a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
	</div>
	<div id="search">
		<?php if(get_option('mytheme_gsearch')!=""){ ?>
			<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/search">
			<input type="text" value="Google Search" name="g" id="s" size="15" onfocus="this.value = this.value == this.defaultValue ? '' : this.value" onblur="this.value = this.value == '' ? this.defaultValue : this.value"/>
			</form>
		<?php }else{?>
			<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
			<input type="text" value="搜索看看..." name="s" id="s" size="15" onfocus="this.value = this.value == this.defaultValue ? '' : this.value" onblur="this.value = this.value == '' ? this.defaultValue : this.value"/>
			</form>
		<?php }?>
	</div>
</div>
	<?php wp_nav_menu(array( 'theme_location'=>'primary','container_id' => 'menu')); ?>