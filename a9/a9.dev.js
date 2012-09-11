jQuery.noConflict();

var i = 0, got = -1, len = document.getElementsByTagName('script').length;
while ( i <= len && got == -1){
	var js_url = document.getElementsByTagName('script')[i].src,
			got = js_url.indexOf('/a9.js'); i++ ;
}
var edit_mode = '1', // 再編輯模式 ( '1'=開; '0'=不開 )
		ajax_php_url = js_url.replace('/a9.js','/comments-ajax.php'),
		wp_url = js_url.substr(0, js_url.indexOf('wp-content')),
		pic_sb = wp_url + 'wp-admin/images/wpspin_dark.gif', // 提交 icon
		pic_no = wp_url + 'wp-admin/images/no.png',          // 錯誤 icon
		pic_ys = wp_url + 'wp-admin/images/yes.png',         // 成功 icon
		txt1 = '<div id="loading"><img src="' + pic_sb + '" style="vertical-align:middle;" alt=""/> 正在提交, 請稍候...</div>',
		txt2 = '<div id="error">#</div>',
		txt3 = '"><img src="' + pic_ys + '" style="vertical-align:middle;" alt=""/> 提交成功',
		edt1 = ', 刷新頁面之前可以<a rel="nofollow" href="#edit" onclick=\'return addComment.moveForm("',
		edt2 = ')\'>再編輯</a>',
		cancel_edit = '取消編輯',
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

/* 變化 css*/
$('#cssChanger a').click(function(){
rel = $(this).attr("rel");
var date = new Date(); date.setTime(date.getTime()+(365*24*60*60*1000));
document.cookie = "sidebar"+"="+rel+";expires="+date.toGMTString()+";path=/"; //設 cookie
changeCss(rel);
});
function changeCss(rel) {
if (rel == 'sidebar-right'){
$('#sidebar').css({'width':'20%','float':'right','height':'auto'});
$('.widget').css({'float':'none','max-width':'none'});
$('.widget h3').css({'margin':'0 10px','text-align':'left'});
$('.slide-area').css({'display':'block','position':'static'});
$('#content').css({'width':'79%','float':'left','padding':'0 0.4% 0 0'});
$('.recentcomments li').css({'width':'auto'});
} else if (rel == 'sidebar-center') {
$('#sidebar').css({'clear':'both','width':'auto','float':'none','height':'43px'});
$('.widget').css({'float':'left','max-width':'200px'});
$('.widget h3').css({'margin':'0 35px','text-align':'center'});
$('.slide-area').css({'display':'none', 'position':'absolute'});
$('#content').css({'width':'auto','float':'none','padding':'0'});
$('.recentcomments li').css({'width':'190px'});
} else {
$('#sidebar').css({'width':'20%','float':'left','height':'auto'});
$('.widget').css({'float':'none','max-width':'none'});
$('.widget h3').css({'margin':'0 10px','text-align':'left'});
$('.slide-area').css({'display':'block', 'position':'static'});
$('#content').css({'width':'79%','float':'right','padding':'0 0 0 0.4%'});
$('.recentcomments li').css({'width':'auto'});
}
}

/* 鼠標懸停顯示下拉欄位*/
rel = getCookie('sidebar');
$(".widget").hover(function(){
if (rel == 'sidebar-center' && !$(this).children('.slide-area').is(':animated')){	$(this).children('.slide-area').fadeIn();}},
	function(){if (rel == 'sidebar-center'){$(this).children('.slide-area').fadeOut();
	}}
);

function getCookie(Name) {
	if ( document.cookie.length > 0 ) {
		Start = document.cookie.indexOf(Name + '=');
		if ( Start != -1 ){
			Start = Start + Name.length + 1; End = document.cookie.indexOf(';', Start);
			if ( End == -1 ) End = document.cookie.length;
			return unescape(document.cookie.substring(Start, End));
			}
		}
	return '';
}

});// end jQ



/* 起始 css */
css_string = '.toggle{display:none;}';

/* CSS3 */
// 文字黑陰影
css_string += 'h3, .entry h5, button, #submit, #searchsubmit, .query-info, .nofind, .page-numbers, .sticky';
css_string += '{text-shadow: 1px 2px 4px #000;}';
// 文字白陰影
css_string += '.entry h1, .entry h2, .line-numbers';
css_string += '{text-shadow: 1px 1px 2px #eee;}';
// 小圓邊
css_string += '.widget, .slide-area, .commentlist .depth-1, .page-numbers, #content .wp-caption';
css_string += '{-moz-border-radius: 5px; -khtml-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;}';
// 大圓邊
css_string += '#header, #sidebar, #respond, .query-info, .entry, .nofind, .postmetadata, textarea, input, button, .xoxo, #center, legend, blockquote';
css_string += '{-moz-border-radius: 9px; -khtml-border-radius: 9px; -webkit-border-radius: 9px; border-radius: 9px;}';
// 低陰影
css_string += '.avatar, #content .geshi, pre, #content .wp-caption';
css_string += '{-moz-box-shadow: rgba(50,50,50,1) 1px 4px 7px; -webkit-box-shadow: rgba(50,50,50,1) 1px 4px 7px; -khtml-box-shadow: rgba(50,50,50,1) 1px 4px 7px; box-shadow: rgba(50,50,50,1) 1px 4px 7px;}';
// 中陰影
css_string += '#sidebar, .entry, .query-info, .nofind, .entry p img, button, #submit, .xoxo, #respond';
css_string += '{-moz-box-shadow: rgba(0,0,0,.8) 1px 7px 12px; -webkit-box-shadow: rgba(0,0,0,.8) 1px 7px 12px; -khtml-box-shadow: rgba(0,0,0,.8) 1px 7px 12px; box-shadow: rgba(0,0,0,.8) 1px 7px 12px;}';
// 高陰影
css_string += '.page-numbers, #s, #searchsubmit, .widget, .slide-area';
css_string += '{-moz-box-shadow: rgba(0,0,0,.5) 1px 22px 22px; -webkit-box-shadow: rgba(0,0,0,.5) 1px 22px 22px; -khtml-box-shadow: rgba(0,0,0,.5) 1px 22px 22px; box-shadow: rgba(0,0,0,.5) 1px 22px 22px;}';

document.write('<style type="text\/css">' + css_string + '<\/style>');


// 表情伸縮
function embedSmiley() {jQuery('#smiley').slideToggle();}

 function grin(tag) { // 表情
  tag = ' ' + tag + ' '; myField = document.getElementById('comment');
  document.selection ? (myField.focus(), sel = document.selection.createRange(), sel.text = tag, myField.focus()) : insertTag(tag);
 }

 function embedImage() { // 貼圖
  URL = prompt('請輸入圖片的 URL 位址:', 'http://'); if (URL) {tag = '[img]' + URL + '[/img]'; insertTag(tag);}
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
 }


/*
Tiny Scrolling - a smooth navigation between internal links and their destinations
by Marco Rosella - http://lab.centralscrutinizer.it/the-tiny-scrollings/
based on the works by Travis Beckham and Brian McAllister.
v0.3 - March 27, 2006
*/

window.onload = function() {
	tinyScrolling.init();
	};

var tinyScrolling = {
	speed : 20,    //set here the scroll speed: when this value increase, the speed decrease. 
	maxStep: 300,  //set here the "uniform motion" step for long distances
	brakeK: 6,     //set here the coefficient of slowing down
	hash:null,		
	currentBlock:null,
	requestedY:0,
	init: function() {
			var lnks = document.getElementsByTagName('a');   
			for(var i = 0, lnk; lnk = lnks[i]; i++) {   
				if ((lnk.href && lnk.href.indexOf('#') != -1)&&( (lnk.pathname == location.pathname)||('/'+lnk.pathname == location.pathname))&&(lnk.search == location.search)){lnk.onclick = tinyScrolling.initScroll;
				}   
			}
	},
	getElementYpos: function(el){
			var y = 0;
			while(el.offsetParent){y += el.offsetTop;el = el.offsetParent;}	return y;
	},		
	getScrollTop: function(){
			if(document.all) {return (document.documentElement.scrollTop) ? document.documentElement.scrollTop : document.body.scrollTop}
			else {return window.pageYOffset}   
	},	
	getWindowHeight: function(){
			if (window.innerHeight)	{return window.innerHeight};
			if(document.documentElement && document.documentElement.clientHeight){return document.documentElement.clientHeight}
	},
	getDocumentHeight: function(){
			if (document.height) {return document.height};
			if(document.body.offsetHeight) {return document.body.offsetHeight}
	},
	initScroll: function(e){
			var targ;  
			if (!e) var e = window.event;
			if (e.target) targ = e.target;
			else if (e.srcElement) targ = e.srcElement;   
			tinyScrolling.hash = targ.href.substr(targ.href.indexOf('#')+1,targ.href.length); 
			tinyScrolling.currentBlock = document.getElementById(tinyScrolling.hash);   
			if(!tinyScrolling.currentBlock) return;
			tinyScrolling.requestedY = tinyScrolling.getElementYpos(tinyScrolling.currentBlock); 
			tinyScrolling.scroll();  
			return false;
	},
	scroll: function(){
			var top  = tinyScrolling.getScrollTop();
			if(tinyScrolling.requestedY > top) {  
				var endDistance = Math.round((tinyScrolling.getDocumentHeight() - (top + tinyScrolling.getWindowHeight())) / tinyScrolling.brakeK);
				endDistance = Math.min(Math.round((tinyScrolling.requestedY-top)/ tinyScrolling.brakeK), endDistance);
				var offset = Math.max(2, Math.min(endDistance, tinyScrolling.maxStep));
			} else { var offset = - Math.min(Math.abs(Math.round((tinyScrolling.requestedY-top)/ tinyScrolling.brakeK)), tinyScrolling.maxStep);
			} window.scrollTo(0, top + offset);  
			if(Math.abs(top-tinyScrolling.requestedY) <= 1 || tinyScrolling.getScrollTop() == top) {window.scrollTo(0, tinyScrolling.requestedY);
				if(!document.all || window.opera) location.hash = tinyScrolling.hash;
				tinyScrolling.hash = null;
			} else 	setTimeout(tinyScrolling.scroll,tinyScrolling.speed);
	}		
};


//js 結束