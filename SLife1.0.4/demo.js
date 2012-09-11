var i = 0, got = -1, len = document.getElementsByTagName('script').length;
while ( i <= len && got == -1){
	var js_url = document.getElementsByTagName('script')[i].src,
			got = js_url.indexOf('/demo.js'); i++ ;
}
var edit_mode = '1', // 再編輯模式 ( '1'=開; '0'=不開 )
		ajax_php_url = js_url.replace('/demo.js','/comments-ajax.php'),
		wp_url = js_url.substr(0, js_url.indexOf('wp-content')),
		pic_sb = wp_url + 'wp-admin/images/wpspin_dark.gif', // 提交 icon
		pic_no = wp_url + 'wp-admin/images/no.png',          // 錯誤 icon
		pic_ys = wp_url + 'wp-admin/images/yes.png',         // 成功 icon
		txt1 = '<div id="loading"><img src="' + pic_sb + '" style="vertical-align:middle;" alt=""/> 正在提交, 请稍候...</div>',
		txt2 = '<div id="error">#</div>',
		txt3 = '"><img src="' + pic_ys + '" style="vertical-align:middle;" alt=""/> 提交成功',
		edt1 = ', 刷新页面之前可以<a rel="nofollow" href="#edit" onclick=\'return addComment.moveForm("',
		edt2 = ')\'>再编辑</a>',
		cancel_edit = '取消编辑',
		edit, num = 1, comm_array=[]; comm_array.push('');

jQuery(document).ready(function($) {
		$comments = $('#comments'); // 評論數的 ID
		$cancel = $('#cancel-comment-reply-link'); cancel_text = $cancel.text();
		$submit = $('#commentform #submit'); $submit.attr('disabled', false);
		$('#comment').after( txt1 + txt2 ); $('#loading').hide(); $('#error').hide();
		$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');

/** submit */
$('#commentform').submit(function() {
		$('#loading').show();
		$submit.attr('disabled', true).fadeTo('slow', 0.5);
		if ( edit ) $('#comment').after('<input type="text" name="edit_id" id="edit_id" value="' + edit + '" style="display:none;" />');

/** Ajax */
	$.ajax( {
		url: ajax_php_url,
		data: $(this).serialize(),
		type: $(this).attr('method'),

		error: function(request) {
			$('#loading').hide();
			$('#error').show().html('<img src="' + pic_no + '" style="vertical-align:middle;" alt=""/> ' + request.responseText);
			setTimeout(function() {$submit.attr('disabled', false).fadeTo('slow', 1); $('#error').slideUp();}, 3000);
			},

		success: function(data) {
			$('#loading').hide();
			comm_array.push($('#comment').val());
			$('textarea').each(function() {this.value = ''});
			var t = addComment, cancel = t.I('cancel-comment-reply-link'), temp = t.I('wp-temp-form-div'), respond = t.I(t.respondId), post = t.I('comment_post_ID').value, parent = t.I('comment_parent').value;

// comments
		if ( ! edit && $comments.length ) {
			n = parseInt($comments.text().match(/\d+/));
			$comments.text($comments.text().replace( n, n + 1 ));
		}

// show comment
		new_htm = '" id="new_comm_' + num + '"></';
		new_htm = ( parent == '0' ) ? ('\n<ol style="clear:both;" class="commentlist' + new_htm + 'ol>') : ('\n<ul class="children' + new_htm + 'ul>');

		ok_htm = '\n<span id="success_' + num + txt3;

		if ( edit_mode == '1' && data.indexOf('小牆判斷這是Spam!') == -1) {
			div_ = (document.body.innerHTML.indexOf('div-comment-') == -1) ? '' : 'div-';
			ok_htm = ok_htm.concat(edt1, div_, 'comment-', parent, '", "', parent, '", "respond", "', post, '", ', num, edt2);
		}
		ok_htm += '</span><span></span>\n';

		$('#respond').before(new_htm);
		$('#new_comm_' + num).hide().append(data);
		$('#new_comm_' + num + ' li').append(ok_htm);
		$('#new_comm_' + num).fadeIn(4000);

		$body.animate( { scrollTop: $('#new_comm_' + num).offset().top - 200}, 900);
		countdown(); num++ ; edit = ''; $('*').remove('#edit_id');
		cancel.style.display = 'none';
		cancel.onclick = null;
		t.I('comment_parent').value = '0';
		if ( temp && respond ) {
			temp.parentNode.insertBefore(respond, temp);
			temp.parentNode.removeChild(temp)
		}
		}
	}); // end Ajax
  return false;
}); // end submit

/** comment-reply.dev.js */
addComment = {
	moveForm : function(commId, parentId, respondId, postId, num) {
		var t = this, div, comm = t.I(commId), respond = t.I(respondId), cancel = t.I('cancel-comment-reply-link'), parent = t.I('comment_parent'), post = t.I('comment_post_ID');
		if ( edit ) exit_prev_edit();
		num ? (
			t.I('comment').value = comm_array[num],
			edit = t.I('new_comm_' + num).innerHTML.match(/(comment-)(\d+)/)[2],
			$new_sucs = $('#success_' + num ), $new_sucs.hide(),
			$new_comm = $('#new_comm_' + num ), $new_comm.hide(),
			$cancel.text(cancel_edit)
		) : $cancel.text(cancel_text);

		t.respondId = respondId;
		postId = postId || false;

		if ( !t.I('wp-temp-form-div') ) {
			div = document.createElement('div');
			div.id = 'wp-temp-form-div';
			div.style.display = 'none';
			respond.parentNode.insertBefore(div, respond)
		}

		 !comm ? ( 
			temp = t.I('wp-temp-form-div'),
			t.I('comment_parent').value = '0',
			temp.parentNode.insertBefore(respond, temp),
			temp.parentNode.removeChild(temp)
		) : comm.parentNode.insertBefore(respond, comm.nextSibling);

		$body.animate( { scrollTop: $('#respond').offset().top - 180 }, 400);

		if ( post && postId ) post.value = postId;
		parent.value = parentId;
		cancel.style.display = '';

		cancel.onclick = function() {
			if ( edit ) exit_prev_edit();
			var t = addComment, temp = t.I('wp-temp-form-div'), respond = t.I(t.respondId);

			t.I('comment_parent').value = '0';
			if ( temp && respond ) {
				temp.parentNode.insertBefore(respond, temp);
				temp.parentNode.removeChild(temp);
			}
			this.style.display = 'none';
			this.onclick = null;
			return false;
		};

		try { t.I('comment').focus(); }
		catch(e) {}

		return false;
	},

	I : function(e) {
		return document.getElementById(e);
	}
}; // end addComment

function exit_prev_edit() {
		$new_comm.show(); $new_sucs.show();
		$('textarea').each(function() {this.value = ''});
		edit = '';
}

var wait = 15, submit_val = $submit.val();
function countdown() {
	if ( wait > 0 ) {
		$submit.val(wait); wait--; setTimeout(countdown, 1000);
	} else {
		$submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
		wait = 15;
  }
}

// 消除鏈接虛線
$('a,input[type="submit"],button[type="button"],object').bind('focus',function(){if(this.blur){ this.blur();}});

$(".toggle").css("display","none");

/*首页文章伸缩新方式新代码*/
$('.post-title').click(function(){
		if($(this).next().is(':visible')){
			$('.post-entry').hide("slow");
		}else{
			$('.post-entry').hide("slow");
			$(this).next(".post-entry").show("slow");
		}
		return false;
	});


/* 图片震动效果 */
$(function(){

	$("p").mouseover(function(){
		if(!$(this).is(":animated")){
		$(this).siblings().eq(0).find("img").animate({top:-6},210).animate({top:0},150)
			.animate({top:-3},150).animate({top:0},100)
			.animate({top:-1},100).animate({top:0},50);
		}
	});

});

/*"关闭/显示侧边栏"完美终结版*/
$('#close-sidebar a').toggle(function(){
	$(this).text("显示侧边栏")
	$('#sidebar').hide().prev().animate({width: "895px"}, 1000);
	},function(){
	$(this).text("关闭侧边栏")
	$('#sidebar').delay(800).show(0).prev().animate({width: "630px"}, 800);
});

/*跳动的导航条*/
$("#menuholder .menu .page-navi li").hover(function(){
		$(this).stop().animate({marginTop:"+=4"}, 250);}
	,function(){
		$(this).stop().animate({marginTop:"0"}, 150);
});

/*返回顶部*/
$('.shang').click(function(){$('html,body').animate({scrollTop: '0px'}, 800);}); 
//点击id="shang"对象时，滑动至相对浏览器滚动条为0px（即顶部），时间为800毫秒
$('.comt').click(function(){$('html,body').animate({scrollTop:$('#comments').offset().top}, 800);});
//点击id="comt"对象时，滑动至id="comment"相对浏览器滚动条的距离，时间为800毫秒
$('.xia').click(function(){$('html,body').animate({scrollTop:$('#footer').offset().top}, 800);});
var s= $('.shangxia').offset().top; //取得id="shangxia"元素相对当前窗口的高度，并赋值给 s
$(window).scroll(function (){ //浏览器滚动条触发事件
	$(".shangxia").animate({top : $(window).scrollTop() + s + "px" },{queue:false,duration:500});
	//添加id="shangxia"元素自定义动画，使其滑动"滚动条距顶部高度+ s "距离，动画过程为500毫秒；
});

/*图片轮播特效*/
function scrollBox(){
	var first = $('#scrollbox ul li:first');
	var width = -(first.outerWidth(true)) + 'px';
	$('#scrollbox ul').animate({left:width},{
		duration:600,
		complete:function(){
			$('#scrollbox ul').append(first).css("left","0");
		}
	});
};
$(document).ready(function(){
	myScroll = setInterval(scrollBox,1500);
	$('#scrollbox').hover(function(){
		clearInterval(myScroll);
	},function(){
		myScroll = setInterval(scrollBox,1500);
	}
);
})

});

// end jQ


/* 起始 css */
css_string = 'ol.commentlist li p{word-wrap: break-word; /*解决留言不换行的问题*/}';//第一句没有+号

css_string += '.post .post-entry p';

css_string += '{word-wrap: break-word;}';

css_string += '.entry p';

css_string += '{word-wrap: break-word;}';

css_string += '.wp-caption';

css_string += '{-moz-border-radius: 3px;-khtml-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;}';

css_string += '.avatar';

css_string += '{-moz-box-shadow: rgba(0,0,0,.8) 1px 5px 7px; -webkit-box-shadow: rgba(0,0,0,.8) 1px 5px 7px; -khtml-box-shadow: rgba(0,0,0,.8) 1px 5px 7px; box-shadow: rgba(0,0,0,.8) 1px 5px 7px;}';

css_string += '#scrollbox img';

css_string += '{padding:1px;border-right:1px solid #CCC;border-bottom: 1px solid #CCC;box-shadow:#666 0px 0px 1px;-webkit-box-shadow: #666 0px 0px 1px;-moz-box-shadow:#666 0px 0px 1px;}';

document.write('<style type="text\/css">' + css_string + '<\/style>');

// end css

// 表情伸縮
function embedSmiley() {jQuery('#smiley').slideToggle();}

 function grin(tag) { // 表情
  tag = ' ' + tag + ' '; myField = document.getElementById('comment');
  document.selection ? (myField.focus(), sel = document.selection.createRange(), sel.text = tag, myField.focus()) : insertTag(tag);
 }

 function embedImage() { // 貼圖
  URL = prompt('请输入图片的 URL 位址:', 'http://'); if (URL) {tag = '[img]' + URL + '[/img]'; insertTag(tag);}
 }

 function insertTag(tag) { // 插入表情或貼圖
  myField = document.getElementById('comment');
  myField.selectionStart || myField.selectionStart == '0' ? (
   startPos = myField.selectionStart,
   endPos = myField.selectionEnd,
   cursorPos = startPos,
   myField.value = myField.value.substring(0, startPos)
                 + tag
                 + myField.value.substring(endPos, myField.value.length),
   cursorPos += tag.length,
   myField.focus(),
   myField.selectionStart = cursorPos,
   myField.selectionEnd = cursorPos
  ) : (
   myField.value += tag,
   myField.focus()
  );
			
 }//js 結束
 
/*头部滚动*/
var scrollSpeed = 70;
var step = 1;
var current = 0;
var imageWidth = 2247;
var headerWidth = 900;		
var restartPosition = -(imageWidth - headerWidth);
function scrollBg(){
	current -= step;
	if (current == restartPosition){
		current = 0;
	}
	$('#header').css("background-position",current+"px 0");
}
var init = setInterval("scrollBg()", scrollSpeed);