<div id="footer-bg">
<div id="footer">
<div id="wordpress"> </div>
<div id="footerinfo">
 <p>
  <a href="<?php echo get_option('home');?>/"><?php bloginfo('name');?></a>  |  <a href="http://creativecommons.org/licenses/by-nc-sa/2.5/cn/">Creative Commons</a>
 </p>
 <p>
  Powered by <a href="http://wordpress.org/">WordPress <?php bloginfo('version');?></a>  |  Designed by <a href="http://Ongakuer.com/">Ongakuer</a> 
 </p>
 </div><!-- end #footerinfo /*ijomyo*/ -->
  <div id="viperlogo"> </div><!-- end #viperlogo -->
 </div><!-- end #footer -->
</div><!-- end #footer-bg -->
</div><!-- end #container -->
</div><!-- end #warp -->

<div id="adbg"> 
<div id="ad"> 
<script type="text/javascript"><!--
google_ad_client = "pub-7545005193343146";
/* 180x150, 创建于 10-8-13 */
google_ad_slot = "4627068335";
google_ad_width = 180;
google_ad_height = 150;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
</div>


<?php if (is_home()) { ?>
<div id="shangxia"><div id="shang"></div><div id="xia"></div></div>
<?php } else { ?>
<div id="shangxia"><div id="shang"></div><div id="comt"></div><div id="xia"></div></div>
<?php } ?>


<?php wp_footer(); ?>
</body></html>