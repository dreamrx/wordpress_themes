<?php
add_action('admin_menu', 'mytheme_page');
function mytheme_page (){
	if ( count($_POST) > 0 && isset($_POST['mytheme_settings']) ){
		$options = array ('computer','google','music','software','ubuntu','wordpress','doc','firefox','life','mac','media','qq','keywords','description','analytics','gsearch');
		foreach ( $options as $opt ){
			delete_option ( 'mytheme_'.$opt, $_POST[$opt] );
			add_option ( 'mytheme_'.$opt, $_POST[$opt] );	
		}
	}
	add_theme_page(__('PX555 主题选项'), __('PX555 主题选项'), 'edit_themes', basename(__FILE__), 'mytheme_settings');
}
function mytheme_settings(){?>
<style type="text/css">
.wrap,em{font-family:'Century Gothic','Microsoft YaHei',Verdana;}
fieldset{border:1px solid #ddd;padding-bottom:20px;margin-top:20px;}
legend{margin-left:5px;padding:0 5px;color:#2481C6;text-transform:uppercase;}
.cat-item{margin: 10px 0 5px 15px;display:inline-block;}
.px-ico tr th{width:30px;}
.px-ico tr th label{height:35px;display:block;overflow:hidden;}
</style>
<div class="wrap">
<h2>PX555 主题选项</h2>
<form method="post" action="">
	<fieldset>
	<legend><strong>分类图标设置</strong></legend>
		<?php wp_list_categories('title_li='); ?>
		<br /><em style="margin-left:15px;">获取以上分类链接的缩略名填入对应的图标。如链接为http://.../category/wordpress，填入wordpress到对于图标。</em>
		<table class="form-table px-ico">
		<tr>
			<th scope="row"><label for="computer"><img src="<?php bloginfo('template_url'); ?>/images/computer.png"  /></label></th><td><input name="computer" type="text" id="computer" value="<?php echo get_option('mytheme_computer'); ?>" /></td>
			<th scope="row"><label for="google"><img src="<?php bloginfo('template_url'); ?>/images/google.png"  /></label></th><td><input name="google" type="text" id="google" value="<?php echo get_option('mytheme_google'); ?>" /></td>
			<th scope="row"><label for="music"><img src="<?php bloginfo('template_url'); ?>/images/music.png"  /></label></th><td><input name="music" type="text" id="music" value="<?php echo get_option('mytheme_music'); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="software"><img src="<?php bloginfo('template_url'); ?>/images/software.png"  /></label></th><td><input name="software" type="text" id="software" value="<?php echo get_option('mytheme_software'); ?>" /></td>
			<th scope="row"><label for="ubuntu"><img src="<?php bloginfo('template_url'); ?>/images/ubuntu.png"  /></label></th><td><input name="ubuntu" type="text" id="ubuntu" value="<?php echo get_option('mytheme_ubuntu'); ?>" /></td>
			<th scope="row"><label for="wordpress"><img src="<?php bloginfo('template_url'); ?>/images/wordpress.png"  /></label></th><td><input name="wordpress" type="text" id="wordpress" value="<?php echo get_option('mytheme_wordpress'); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="doc"><img src="<?php bloginfo('template_url'); ?>/images/doc.png"  /></label></th><td><input name="doc" type="text" id="doc" value="<?php echo get_option('mytheme_doc'); ?>" /></td>
			<th scope="row"><label for="firefox"><img src="<?php bloginfo('template_url'); ?>/images/firefox.png"  /></label></th><td><input name="firefox" type="text" id="firefox" value="<?php echo get_option('mytheme_firefox'); ?>" /></td>
			<th scope="row"><label for="life"><img src="<?php bloginfo('template_url'); ?>/images/life.png"  /></label></th><td><input name="life" type="text" id="life" value="<?php echo get_option('mytheme_life'); ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><label for="mac"><img src="<?php bloginfo('template_url'); ?>/images/mac.png"  /></label></th><td><input name="mac" type="text" id="mac" value="<?php echo get_option('mytheme_mac'); ?>" /></td>
			<th scope="row"><label for="media"><img src="<?php bloginfo('template_url'); ?>/images/media.png"  /></label></th><td><input name="media" type="text" id="media" value="<?php echo get_option('mytheme_media'); ?>" /></td>
			<th scope="row"><label for="qq"><img src="<?php bloginfo('template_url'); ?>/images/qq.png"  /></label></th><td><input name="qq" type="text" id="qq" value="<?php echo get_option('mytheme_qq'); ?>" /></td>
		</tr>
		</table>
	</fieldset>
	<fieldset>
	<legend><strong>SEO 设置</strong></legend>
		<table class="form-table">
			<tr><td>
				<textarea name="keywords" id="keywords" rows="1" cols="70" style="font-size:11px;width:100%;"><?php echo get_option('mytheme_keywords'); ?></textarea><br />
				<em>网站关键词（Meta Keywords），中间用半角逗号隔开。如： 折腾WordPress,生活记录,独立博客,林木木</em>
			</td></tr>
			<tr><td>
				<textarea name="description" id="description" rows="3" cols="70" style="font-size:11px;width:100%;"><?php echo get_option('mytheme_description'); ?></textarea>
				<em>网站描述（Meta Description），针对搜索引擎设置的网页描述。如： 这儿是林木木童鞋记录分享交流的私人领地</em>
			</td></tr>
		</table>
	</fieldset>
	<fieldset>
	<legend><strong>统计代码添加</strong></legend>
		<table class="form-table">
			<tr><td>
				<textarea name="analytics" id="analytics" rows="5" cols="70" style="font-size:11px;width:100%;"><?php echo stripslashes(get_option('mytheme_analytics')); ?></textarea>
			</td></tr>
		</table>
	</fieldset>
	<fieldset>
	<legend><strong>Google 自定义搜索设置</strong></legend>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="gsearch"><strong>输入自定义搜索唯一ID：</strong></label></th>
				<td>
					<input name="gsearch" type="text" id="gsearch" value="<?php echo get_option('mytheme_gsearch'); ?>" class="regular-text" /><em>（请先创建一个页面，缩略名改为“search”，不填则使用 WordPress 默认搜索）</em>
					<br /><em>访问 <a href="http://www.google.com/coop/cse/" target="_blank">http://www.google.com/cse/</a>获取，如：009851593943294046466:jfiqb-zkda4</em>
				</td>
			</tr>
		</table>
	</fieldset>
	<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="保存设置" />
		<input type="hidden" name="mytheme_settings" value="save" style="display:none;" />
	</p>
</form>
</div>
<?php
}
?>