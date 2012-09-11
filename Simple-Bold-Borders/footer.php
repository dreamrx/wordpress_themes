</div>
<div id="footer" class="clear">
	<div class="credits">
		Power by <a href="http://wordpress.org/" target="_blank">WordPress</a>
	</div>
	
	<form method="get" id="searchform" class="searchform" action="<?php bloginfo('home'); ?>/">
		<div id="search"><input type="text" value="Search..." name="s" id="s" size="15" onfocus="this.value = this.value == this.defaultValue ? '' : this.value" onblur="this.value = this.value == '' ? this.defaultValue : this.value"/></div>
	</form>
	
	</div>
</div>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
	if($('.postContent a[rel!=link]:has(img)').length > 0){
		$.getScript("<?php bloginfo('template_url'); ?>/slimbox2.js");
	};
});
</script>

<?php if( is_singular() ){ ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/comments-ajax.js"></script>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#comments .comment-body').dblclick(function(){
		var crl=$('#cancel-comment-reply-link');
		if($(this).next('#respond').length > 0) {crl.click()
		}else{$(this).find('.comment-reply-link').click();crl.text("取消 @"+$(this).find('.name').text());
		}
		return false
	});
	$('#comments .live').live('dblclick',function(){$(this).next().children('a').click()});
});
</script>
<?php } ?>

<?php wp_footer(); ?>
</div>
</body>
</html>