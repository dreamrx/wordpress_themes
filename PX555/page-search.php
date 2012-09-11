<?php get_header(); ?>
<div id="content">
	<div id="essay-single">
		<div class="single-all">
			<div id="cse" style="width: 100%;"><p style="padding:2%;">正在从Google 加载搜索结果......</p></div>
<script src="http://www.google.com/jsapi" type="text/javascript"></script>
<script type="text/javascript">
	google.load('search', '1', {language : 'zh-CN'});
	google.setOnLoadCallback(function(){
        var customSearchControl = new google.search.CustomSearchControl('<?php echo get_option('mytheme_gsearch'); ?>');
        customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
        customSearchControl.draw('cse');
        var match = location.search.match(/g=([^&]*)(&|$)/);
        if(match && match[1]){
            var search = decodeURIComponent(match[1]);
            customSearchControl.execute(search);
        }
    });
</script>
<link rel="stylesheet" href="http://www.google.com/cse/style/look/greensky.css" type="text/css" />
<style type="text/css">.cse .gsc-control-cse, .gsc-control-cse{background-color:#FFF;border:0 none;}.cse input.gsc-input, input.gsc-input{color:#000;border-color: #eee;}.cse input.gsc-search-button, input.gsc-search-button{border-color: #eee;background-color: #eee;}</style>
		</div>
	</div>
<?php get_footer(); ?>