<?php
/**
 * @package WordPress
 * @subpackage SLife_Theme
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(' - ', true, 'right'); bloginfo('name'); if (is_home ()) echo " - ", bloginfo('description'); if ($paged > 1) echo ' - Page ', $paged; ?></title>
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<?php date_default_timezone_set('Asia/Shanghai'); $hc = date("H");if ($hc >= 7 && $hc < 18) { ?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style.css" type="text/css" media="screen" />
<?php } else { ?>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/night.css" type="text/css" media="screen" />
<?php } ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_head(); ?>
</head>
<body>
<?php if (is_home() || is_archive() || is_search()) { ?>
<div class="shangxia"><div class="shang" title="滚到顶部"></div><div class="xia" title="滚到底部"></div></div>
<?php } else { ?>
<div class="shangxia"><div class="shang" title="滚到顶部"></div><div class="comt" title="滚到评论"></div><div class="xia" title="滚到底部"></div></div>
<?php } ?>
<div id="container">
<div id="header">
<h1><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>
<h2><?php bloginfo('description'); ?></h2>
</div>
<div id="menuholder">
<div class="menu">
<div class="page-navi">
<ul><li class="page_item"><a href="http://demo.xianyunyehe.net" title="首页">首页</a></li><li class="page_item"><a href="http://demo.xianyunyehe.net/?page_id=2" title="关于">关于</a></li><li class="page_item"><a href="http://photo.xianyunyehe.net/" title="相册">相册</a></li><li class="page_item"><a href="http://feed.xianyunyehe.net/" title="feedsky">订阅</a></li><li id="close-sidebar" class="page_item" style="cursor:e-resize; float:right;"><a>关闭侧边栏</a></li></ul>
</div> 
</div>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>
</div>