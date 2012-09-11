</div>
<div class="clear"></div>
<div id="footer">
&copy;2011
</div>

</div>

<?php wp_footer(); ?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/includes/all.js"></script>
<?php if (is_home()&& $paged<2) { ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/includes/index.js"></script>
<?php } elseif (is_singular()){ ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/includes/comments-ajax.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/includes/slimbox2.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/includes/single.js"></script>
<?php }?>
<?php if (get_option('mytheme_analytics')!="") {?>
<div id="analytics"><?php echo stripslashes(get_option('mytheme_analytics')); ?></div>
<?php }?>
</body>
</html>