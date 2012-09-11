<?php
/*
Theme Name: A9
Version: 1.9.1
File Name: query-info.php
*/ 
?>
<?php /* If this is a category */ if (is_category()) { ?>
<h1 class="query-info">以下內容屬於 &#8216;<?php single_cat_title(); ?>&#8217; 分類：</h1>
<?php /* If this is a tag */ } elseif( is_tag() ) { ?>
<h1 class="query-info">以下內容屬於 &#8216;<?php single_tag_title(); ?>&#8217; 標籤：</h1>
<?php /* If this is a daily */ } elseif (is_day()) { ?>
<h1 class="query-info">以下內容是 <?php the_time('Y年 F j日'); ?> 的彙整：</h1>
<?php /* If this is a monthly */ } elseif (is_month()) { ?>
<h1 class="query-info">以下內容是 <?php the_time('Y年 F'); ?> 的彙整：</h1>
<?php /* If this is a yearly */ } elseif (is_year()) { ?>
<h1 class="query-info">以下內容是 <?php the_time('Y年'); ?> 的彙整：</h1>
<?php /* If this is a paged */ } elseif (isset($_GET['paged']) && !empty($_GET['paged']) && !is_search()) { ?>
<h4 class="query-info">您正在瀏覽的是以前的文章</h4>
<?php } ?>