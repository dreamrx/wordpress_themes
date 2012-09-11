<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
 

 <!--调用 jQ-->
<script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/jquery.js"></script> <!--结尾-->


 <!--调用header-->
<script type="text/javascript"  src="<?php bloginfo('template_url');?>/scripts/header.js"></script> <!--结尾-->




<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
 
<title><?php if(is_single()){	single_post_title();echo ' - ';bloginfo('name');}elseif(is_home()||is_front_page()){bloginfo('name');}elseif(is_page()){single_post_title(''); echo ' - ';bloginfo('name');}elseif(is_search()){printf( __('Search results for "%s"'),esc_html($s));echo ' - '; bloginfo('name');}elseif(is_404()){_e('Error 404 - Not Found');echo ' - ';bloginfo('name');}else{wp_title('');echo ' - ';bloginfo('name');}?></title>

<meta name="generator" content="WordPress" /> <!-- leave this for stats (or remove for potential security reasons) -->
<meta name="description" content="<?php if(is_single()){echo $description;}else{bloginfo('description');}?>" />
<meta name="keywords" content="<?php if($SearchKey)echo $SearchKey;if(is_single())echo ', '.$keywords;?>" />
<style type="text/css" media="screen">@import url(<?php bloginfo('stylesheet_url');?>);</style>
 
 <link rel="Shortcut Icon" href="<?php bloginfo('template_directory');?>/images/favicon.ico" type="image/x-icon" />
 <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
 <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
 <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />



 <?php wp_head(); ?>	
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="warp">
<div id="container">
 <div id="header-bg">
  <div id="header">
 <div id="twitter-bg">
 <div class="login"> <?php if( is_user_logged_in() ) {
										global $current_user;
										get_currentuserinfo();
										echo ''.sprintf(__(' <a href="%1$s" title="Wordpress后台">登录</a>', 'default'), get_template_directory_uri()."/../../../wp-admin", $current_user->user_login ).'';
									}
								?></div>
 
 <div id="twitter">
e</div>



 <div id="twitter-ico"><img src="<?php bloginfo('template_directory');?>/images/twitter.png" alt="twitter" /></div>
 </div><!-- end #twitter-bg -->
 
  <div id="logo">
   <a title="<?php bloginfo('name'); ?>" href="<?php bloginfo('siteurl'); ?>"><?php  bloginfo('name'); ?></a>
  </div><!-- end #logo -->
  
  
<div id="about"><a href="http://imjoyo.com/?page_id=1747">About</a></div><!-- end #about -->
<div id="link"><a href="http://ongakuer.com/links/">Links</a></div><!-- end #link -->
<div id="tag"><a href="http://ongakuer.com/tags/">Tags</a></div><!-- end #tag -->
<div id="arc"><a href="http://ongakuer.com/archives/">Archives</a></div><!-- end #acr -->
<div id="home"><a href="<?php bloginfo('url');?>">Home</a></div><!-- end #home -->
  
 
  
  
 
  </div><!-- end #header-->
 </div><!-- end #header-bg -->