// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];
 
jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) { a=c; var s=p/4; }
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});


















jQuery(document).ready(function($){  //注意要用这个把jQuery代码都包裹起来，不然里面的可都是无效的

 //这是siderbar的
$("#sidebar ul li a").hover(function(){
		$(this).stop().animate({marginLeft:"22px"}, 250,"easeOutBounce");}
	,function(){
		$(this).stop().animate({marginLeft:"10px"}, 150,"easeOutBounce");
});

$("#sidebar ul li ul li.sidecom2 a").hover(function(){
		$(this).stop().animate({marginLeft:"12px"}, 250,"easeOutBounce");}
	,function(){
		$(this).stop().animate({marginLeft:"0px"}, 150,"easeOutBounce");
});

//nav开始
$("#home a").hover(function (){
	$(this).stop().animate({marginTop:"10px"}, 350,"easeOutBounce");
	}
	,function () {
    $(this).stop().animate({marginTop:"0px"}, 150,"easeOutBounce");
	});
	
$("#arc a").hover(function (){
	$(this).stop().animate({marginTop:"10px"}, 350,"easeOutBounce");
	}
	,function () {
    $(this).stop().animate({marginTop:"0px"}, 150,"easeOutBounce");
});

$("#tag a").hover(function (){
	$(this).stop().animate({marginTop:"10px"}, 350,"easeOutBounce");
	}
	,function () {
    $(this).stop().animate({marginTop:"0px"}, 150,"easeOutBounce");
});



$("#link a").hover(function (){
	$(this).stop().animate({marginTop:"10px"}, 350,"easeOutBounce");
	}
	,function () {
    $(this).stop().animate({marginTop:"0px"}, 150,"easeOutBounce");
});



$("#about a").hover(function (){
	$(this).stop().animate({marginTop:"10px"}, 350,"easeOutBounce");
	}
	,function () {
    $(this).stop().animate({marginTop:"0px"}, 150,"easeOutBounce");
});

  
	//nav结束
	
	//标题弹动
	$("#content h2").hover(function(){
		$(this).stop().animate({marginLeft:"22px"}, 250,"easeOutBounce");}
	,function(){
		$(this).stop().animate({marginLeft:"0px"}, 150,"easeOutBounce");
});
	
	//滑动控制
	$('#shang').click(function(){$('html,body').animate({scrollTop: '0px'}, 1800,"easeInOutCubic");}); 
	//点击id="shang"对象时，滑动至相对浏览器滚动条为0px（即顶部），时间为800毫秒
	$('#comt').click(function(){$('html,body').animate({scrollTop:$('#comments').offset().top}, 1800,"easeInOutCubic");});
	//点击id="comt"对象时，滑动至id="comment"相对浏览器滚动条的距离，时间为800毫秒
	$('#xia').click(function(){$('html,body').animate({scrollTop:$('#footer').offset().top}, 1800,"easeInOutCubic");});
			
			var s= $('#shangxia').offset().top; //取得id="shangxia"元素相对当前窗口的高度，并赋值给 s
$(window).scroll(function (){ //浏览器滚动条触发事件
	$("#shangxia").animate({top : $(window).scrollTop() + 200 + "px" },{queue:false,duration:500});
	//添加id="shangxia"元素自定义动画，使其滑动"滚动条距顶部高度+ s "距离，动画过程为500毫秒；
});
			
					
					
	//广告
					$("#adbg").hover(
					
					function() {	
				　　// 鼠标悬停时候被触发的函数
				   $(this).stop().animate({'left':'+=202px'},250,"easeInOutCubic");

				  }, 
				  function() {
				   // 鼠标移出时候被触发的函数 /*ijomyo*/
				   $(this).stop().animate({'left':'-202px'},250,"easeInOutCubic"); 
				  
				});
					
	

});	



jQuery(document).ready(function($) {

$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');// 这行是 Opera 的补丁, 少了它 Opera 是直接用跳的而且画面闪烁 by willin

$('#comments #top').click(function(){
	$body.animate({scrollTop: $('#header').offset().top}, 1800,"easeInOutCubic");
	return false;// 返回false可以避免在原链接后加上  /*ijomyo*/ #
});

});


