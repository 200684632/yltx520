
/* ==== slider nameSpace手风琴效果 ==== */
var slider = function() {
	/* ==== private methods ==== */
	function getElementsByClass(object, tag, className) {
		var o = object.getElementsByTagName(tag);
		for ( var i = 0, n = o.length, ret = []; i < n; i++) {
			if (o[i].className == className) ret.push(o[i]);
		}
		if (ret.length == 1) ret = ret[0];
		return ret;
	}
	function setOpacity (obj,o) {
		if (obj.filters) obj.filters.alpha.opacity = Math.round(o);
		else obj.style.opacity = o / 100;
	}
	/* ==== Slider Constructor ==== */
	function Slider(oCont, speed, iW, iH, oP) {
		this.slides = [];
		this.over   = false;
		this.S      = this.S0 = speed;
		this.iW     = iW;
		this.iH     = iH;
		this.oP     = oP;
		this.oc     = document.getElementById(oCont);
		this.frm    = getElementsByClass(this.oc, 'div', 'slide');
		this.NF     = this.frm.length;
		this.resize();
		for (var i = 0; i < this.NF; i++) {
			this.slides[i] = new Slide(this, i);
		}
		this.oc.parent = this;
		this.view      = this.slides[0];
		this.Z         = this.mx;
		/* ==== on mouse out event ==== */
		this.oc.onmouseout = function () {
			this.parent.mouseout();
			return false;
		}
	}
	Slider.prototype = {
		/* ==== animation loop ==== */
		run : function () {
			this.Z += this.over ? (this.mn - this.Z) * .5 : (this.mx - this.Z) * .5;
			this.view.calc();
			var i = this.NF;
			while (i--) this.slides[i].move();
		},
		/* ==== resize  ==== */
		resize : function () {
			this.wh = this.oc.clientWidth;
			this.ht = this.oc.clientHeight;
			this.wr = this.wh * this.iW;
			this.r  = this.ht / this.wr;
			this.mx = this.wh / this.NF;
			this.mn = (this.wh * (1 - this.iW)) / (this.NF - 1);
		},
		/* ==== rest  ==== */
		mouseout : function () {
			this.over      = false;
			setOpacity(this.view.img, this.oP);
		}
	}
	/* ==== Slide Constructor ==== */
	Slide = function (parent, N) {
		this.parent = parent;
		this.N      = N;
		this.x0     = this.x1 = N * parent.mx;
		this.v      = 0;
		this.loaded = false;
		this.cpt    = 0;
		this.start  = new Date();
		this.obj    = parent.frm[N];
		this.txt    = getElementsByClass(this.obj, 'div', 'text');
		this.img    = getElementsByClass(this.obj, 'img', 'diapo');
		this.bkg    = document.createElement('div');
		this.bkg.className = 'backgroundText';
		this.obj.insertBefore(this.bkg, this.txt);
		if (N == 0) this.obj.style.borderLeft = 'none';
		this.obj.style.left = Math.floor(this.x0) + 'px';
		setOpacity(this.img, parent.oP);
		/* ==== mouse events ==== */
		this.obj.parent = this;
		this.obj.onmouseover = function() {
			this.parent.over();
			return false;
		}
	}
	Slide.prototype = {
		/* ==== target positions ==== */
		calc : function() {
			var that = this.parent;
			// left slides
			for (var i = 0; i <= this.N; i++) {
				that.slides[i].x1 = i * that.Z;
			}
			// right slides
			for (var i = this.N + 1; i < that.NF; i++) {
				that.slides[i].x1 = that.wh - (that.NF - i) * that.Z;
			}
		},
		/* ==== HTML animation : move slides ==== */
		move : function() {
			var that = this.parent;
			var s = (this.x1 - this.x0) / that.S;
			/* ==== lateral slide ==== */
			if (this.N && Math.abs(s) > .5) {
				this.obj.style.left = Math.floor(this.x0 += s) + 'px';
			}
			/* ==== vertical text ==== */
			var v = (this.N < that.NF - 1) ? that.slides[this.N + 1].x0 - this.x0 : that.wh - this.x0;
			if (Math.abs(v - this.v) > .5) {
				this.bkg.style.top = this.txt.style.top = Math.floor(2 + that.ht - (v - that.Z) * that.iH * that.r) + 'px';
				this.v = v;
				this.cpt++;
			} else {
				if (!this.pro) {
					/* ==== adjust speed ==== */
					this.pro = true;
					var tps = new Date() - this.start;
					if(this.cpt > 1) {
						that.S = Math.max(2, (28 / (tps / this.cpt)) * that.S0);
					}
				}
			}
			if (!this.loaded) {
				if (this.img.complete) {
					this.img.style.visibility = 'visible';
					this.loaded = true;
				}
			}
		},
		/* ==== light ==== */
		over : function () {
			this.parent.resize();
			this.parent.over = true;
			setOpacity(this.parent.view.img, this.parent.oP);
			this.parent.view = this;
			this.start = new Date();
			this.cpt = 0;
			this.pro = false;
			this.calc();
			setOpacity(this.img, 100);
		}
	}
	/* ==== public method - script initialization ==== */
	return {
		init : function() {
			// create instances of sliders here
			// parameters : HTMLcontainer name, speed (2 fast - 20 slow), Horizontal ratio, vertical text ratio, opacity
			this.s1 = new Slider("slider", 12, 1.84/3, 1/3.2, 70);
			setInterval("slider.s1.run();", 16);
		}
	}
}();

// 每周推荐轮播效果
(function($) {
	$.fn.slide = function(options) {
		$.fn.slide.deflunt = {
			effect: "fade", //效果 || fade：渐显； || top：上滚动；|| left：左滚动；|| topLoop：上循环滚动；|| leftLoop：左循环滚动；|| topMarquee：上无缝循环滚动；|| leftMarquee：左无缝循环滚动；
			autoPlay: false, //自动运行
			delayTime: 1000, //效果持续时间
			interTime: 2500, //自动运行间隔。当effect为无缝滚动的时候，相当于运行速度。
			defaultIndex: 0, //默认的当前位置索引。0是第一个
			titCell: ".hd li", //导航元素
			mainCell: ".bd", //内容元素的父层对象
			trigger: "mouseover", //触发方式 || mouseover：鼠标移过触发；|| click：鼠标点击触发；
			scroll: 1, //每次滚动个数。
			vis: 1, //visible，可视范围个数，当内容个数少于可视个数的时候，不执行效果。
			titOnClassName: "on", //当前位置自动增加的class名称
			autoPage: false, //系统自动分页，当为true时，titCell则为导航元素父层对象，同时系统会在titCell里面自动插入分页li元素(1.2版本新增)
			prevCell: ".prev", //前一个按钮元素。
			nextCell: ".next" //后一个按钮元素。
		};
		return this.each(function() {
			var opts = $.extend({}, $.fn.slide.deflunt, options);
			var index = opts.defaultIndex;
			var prevBtn = $(opts.prevCell, $(this));
			var nextBtn = $(opts.nextCell, $(this));
			var navObj = $(opts.titCell, $(this)); //导航子元素结合
			var navObjSize = navObj.size();
			var conBox = $(opts.mainCell, $(this)); //内容元素父层对象
			var conBoxSize = conBox.children().size();
			var slideH = 0;
			var slideW = 0;
			var selfW = 0;
			var selfH = 0;
			var autoPlay = opts.autoPlay;
			var inter = null; //setInterval名称 
			var oldIndex = index;
			if (conBoxSize < opts.vis) return; //当内容个数少于可视个数，不执行效果。
			//处理分页
			if (navObjSize == 0) navObjSize = conBoxSize;
			if (opts.autoPage) {
				var tempS = conBoxSize - opts.vis;
				navObjSize = 1 + parseInt(tempS % opts.scroll != 0 ? (tempS / opts.scroll + 1) : (tempS / opts.scroll));
				navObj.html("");
				for (var i = 0; i < navObjSize; i++) {
					navObj.append("<li>" + (i + 1) + "</li>")
				}
				var navObj = $("li", navObj); //重置导航子元素对象
			}

			conBox.children().each(function() { //取最大值
				if ($(this).width() > selfW) {
					selfW = $(this).width();
					slideW = $(this).outerWidth(true);
				}
				if ($(this).height() > selfH) {
					selfH = $(this).height();
					slideH = $(this).outerHeight(true);
				}
			});

			switch (opts.effect) {
				case "top":
					conBox.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; height:' + opts.vis * slideH + 'px"></div>').css({
						"position": "relative",
						"padding": "0",
						"margin": "0"
					}).children().css({
						"height": selfH
					});
					break;
				case "left":
					conBox.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; width:' + opts.vis * slideW + 'px"></div>').css({
						"width": conBoxSize * slideW,
						"position": "relative",
						"overflow": "hidden",
						"padding": "0",
						"margin": "0"
					}).children().css({
						"float": "left",
						"width": selfW
					});
					break;
				case "leftLoop":
				case "leftMarquee":
					conBox.children().clone().appendTo(conBox).clone().prependTo(conBox);
					conBox.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; width:' + opts.vis * slideW + 'px"></div>').css({
						"width": conBoxSize * slideW * 3,
						"position": "relative",
						"overflow": "hidden",
						"padding": "0",
						"margin": "0",
						"left": -conBoxSize * slideW
					}).children().css({
						"float": "left",
						"width": selfW
					});
					break;
				case "topLoop":
				case "topMarquee":
					conBox.children().clone().appendTo(conBox).clone().prependTo(conBox);
					conBox.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; height:' + opts.vis * slideH + 'px"></div>').css({
						"height": conBoxSize * slideH * 3,
						"position": "relative",
						"padding": "0",
						"margin": "0",
						"top": -conBoxSize * slideH
					}).children().css({
						"height": selfH
					});
					break;
			}
			//效果函数
			var doPlay = function() {
				switch (opts.effect) {
					case "fade":
					case "top":
					case "left":
						if (index >= navObjSize) {
							index = 0;
						} else if (index < 0) {
							index = navObjSize - 1;
						}
						break;
					case "leftMarquee":
					case "topMarquee":
						if (index >= 2) {
							index = 1;
						} else if (index < 0) {
							index = 0;
						}
						break;
					case "leftLoop":
					case "topLoop":
						var tempNum = index - oldIndex;
						if (navObjSize > 2 && tempNum == -(navObjSize - 1)) tempNum = 1;
						if (navObjSize > 2 && tempNum == (navObjSize - 1)) tempNum = -1;
						var scrollNum = Math.abs(tempNum * opts.scroll);
						if (index >= navObjSize) {
							index = 0;
						} else if (index < 0) {
							index = navObjSize - 1;
						}
						break;
				}
				switch (opts.effect) {
					case "fade":
						conBox.children().stop(true, true).eq(index).fadeIn(opts.delayTime).siblings().hide();
						break;
					case "top":
						conBox.stop(true, true).animate({
							"top": -index * opts.scroll * slideH
						}, opts.delayTime);
						break;
					case "left":
						conBox.stop(true, true).animate({
							"left": -index * opts.scroll * slideW
						}, opts.delayTime);
						break;
					case "leftLoop":
						if (tempNum < 0) {
							conBox.stop(true, true).animate({
								"left": -(conBoxSize - scrollNum) * slideW
							}, opts.delayTime, function() {
								for (var i = 0; i < scrollNum; i++) {
									conBox.children().last().prependTo(conBox);
								}
								conBox.css("left", -conBoxSize * slideW);
							});
						} else {
							conBox.stop(true, true).animate({
								"left": -(conBoxSize + scrollNum) * slideW
							}, opts.delayTime, function() {
								for (var i = 0; i < scrollNum; i++) {
									conBox.children().first().appendTo(conBox);
								}
								conBox.css("left", -conBoxSize * slideW);
							});
						}
						break; // leftLoop end
					case "topLoop":
						if (tempNum < 0) {
							conBox.stop(true, true).animate({
								"top": -(conBoxSize - scrollNum) * slideH
							}, opts.delayTime, function() {
								for (var i = 0; i < scrollNum; i++) {
									conBox.children().last().prependTo(conBox);
								}
								conBox.css("top", -conBoxSize * slideH);
							});
						} else {
							conBox.stop(true, true).animate({
								"top": -(conBoxSize + scrollNum) * slideH
							}, opts.delayTime, function() {
								for (var i = 0; i < scrollNum; i++) {
									conBox.children().first().appendTo(conBox);
								}
								conBox.css("top", -conBoxSize * slideH);
							});
						}
						break; //topLoop end
					case "leftMarquee":
						var tempLeft = conBox.css("left").replace("px", "");

						if (index == 0) {
							conBox.animate({
								"left": ++tempLeft
							}, 0, function() {
								if (conBox.css("left").replace("px", "") >= 0) {
									for (var i = 0; i < conBoxSize; i++) {
										conBox.children().last().prependTo(conBox);
									}
									conBox.css("left", -conBoxSize * slideW);
								}
							});
						} else {
							conBox.animate({
								"left": --tempLeft
							}, 0, function() {
								if (conBox.css("left").replace("px", "") <= -conBoxSize * slideW * 2) {
									for (var i = 0; i < conBoxSize; i++) {
										conBox.children().first().appendTo(conBox);
									}
									conBox.css("left", -conBoxSize * slideW);
								}
							});
						}
						break; // leftMarquee end
					case "topMarquee":
						var tempTop = conBox.css("top").replace("px", "");
						if (index == 0) {
							conBox.animate({
								"top": ++tempTop
							}, 0, function() {
								if (conBox.css("top").replace("px", "") >= 0) {
									for (var i = 0; i < conBoxSize; i++) {
										conBox.children().last().prependTo(conBox);
									}
									conBox.css("top", -conBoxSize * slideH);
								}
							});
						} else {
							conBox.animate({
								"top": --tempTop
							}, 0, function() {
								if (conBox.css("top").replace("px", "") <= -conBoxSize * slideH * 2) {
									for (var i = 0; i < conBoxSize; i++) {
										conBox.children().first().appendTo(conBox);
									}
									conBox.css("top", -conBoxSize * slideH);
								}
							});
						}
						break; // topMarquee end
				} //switch end
				navObj.removeClass(opts.titOnClassName).eq(index).addClass(opts.titOnClassName);
				oldIndex = index;
			};
			//初始化执行
			doPlay();

			//自动播放
			if (autoPlay) {
				if (opts.effect == "leftMarquee" || opts.effect == "topMarquee") {
					index++;
					inter = setInterval(doPlay, opts.interTime);
					conBox.hover(function() {
						if (autoPlay) {
							clearInterval(inter);
						}
					}, function() {
						if (autoPlay) {
							clearInterval(inter);
							inter = setInterval(doPlay, opts.interTime);
						}
					});
				} else {
					inter = setInterval(function() {
						index++;
						doPlay()
					}, opts.interTime);
					$(this).hover(function() {
						if (autoPlay) {
							clearInterval(inter);
						}
					}, function() {
						if (autoPlay) {
							clearInterval(inter);
							inter = setInterval(function() {
								index++;
								doPlay()
							}, opts.interTime);
						}
					});
				}
			}

			//鼠标事件
			var mst;
			if (opts.trigger == "mouseover") {
				navObj.hover(function() {
					clearTimeout(mst);
					index = navObj.index(this);
					mst = window.setTimeout(doPlay, 200);
				}, function() {
					if (!mst) clearTimeout(mst);
				});
			} else {
				navObj.click(function() {
					index = navObj.index(this);
					doPlay();
				})
			}
			nextBtn.click(function() {
				index++;
				doPlay();
			});
			prevBtn.click(function() {
				index--;
				doPlay();
			});

		}); //each End

	}; //slide End

})(jQuery);


$(function () {
	/**
	 * 大图广告轮播
	 */
	//初始化宽度
	var adWidth = $(window).width() > 1920 ? 1920 : $(window).width();
	$('.flex-container').width(adWidth);

	//选择按钮定位
	var adSelObj = $('.flex-container .flex-control-nav');
	var adSelLeft = $(window).width() / 2 - adSelObj.width() / 2;
	adSelObj.find('li').hover(function () {
		$(this).addClass('hover');
	}, function () {
		$(this).removeClass('hover');
	}).click(function () {
		$(this).addClass('active').siblings().removeClass('active');
	}).eq(0).addClass('active');

	//轮播图
	var adObj = $('.flex-container .flexslider .slides li');
	var adNum = adObj.length;
	var index = 0;
	var t = setInterval(adMove, 3000);
	adObj.eq(index).show();
	
	//按钮点击
	$('li', adSelObj).click(function () {
		clearInterval(t);
		index = $(this).index();
		adObj.eq(index).fadeIn(1000).siblings().fadeOut(1000);
		$(this).addClass('active').siblings().removeClass('active');
	}).mouseout(function () {
		t = setInterval(adMove, 3000);
	}).mouseover(function () {
		clearInterval(t);
	});

	//左右按钮定位
	$('.prev').click(function () {
		index = index == 0 ? adNum : --index;
		adObj.eq(index).fadeIn(1000).siblings().fadeOut(1000);
		$('li', adSelObj).eq(index).addClass('active').siblings().removeClass('active');
	}).mouseout(function () {
		t = setInterval(adMove, 3000);
	}).mouseover(function () {
		clearInterval(t);
	});
	$('.next').click(function () {
		index = index < (adNum - 1) ? ++index : 0;
		adObj.eq(index).fadeIn(1000).siblings().fadeOut(1000);
		$('li', adSelObj).eq(index).addClass('active').siblings().removeClass('active');
	}).mouseout(function () {
		t = setInterval(adMove, 3000);
	}).mouseover(function () {
		clearInterval(t);
	});

	//定时器
	function adMove () {
		index = index < (adNum - 1) ? ++index : 0;
		adObj.eq(index).fadeIn(1000).siblings().fadeOut(1000);

		//按键同步
		$('li', adSelObj).eq(index).addClass('active').siblings().removeClass('active');
	}
});

/**
 * TAB切换
 */
(function($){
    $.fn.hoverDelay = function(options){
        var defaults = {
            hoverDuring: 200,
            outDuring: 200,
            hoverEvent: function(){
                $.noop();
            },
            outEvent: function(){
                $.noop();    
            }
        };
        var sets = $.extend(defaults,options || {});
        var hoverTimer, outTimer, that = this;
        return $(this).each(function(){
            $(this).hover(function(){
                clearTimeout(outTimer);
                hoverTimer = setTimeout(function(){sets.hoverEvent.apply(that)}, sets.hoverDuring);
            },function(){
                clearTimeout(hoverTimer);
                outTimer = setTimeout(function(){sets.outEvent.apply(that)}, sets.outDuring);
            });    
        });
    }      
})(jQuery);

/**
 * 列表页全部分类下拉菜单
 */
$(function () {
	
	// 全部分类
	var categoryParentIdKey = parseInt('8');
	var menuH3 =$("div.category_tree>h3");
	var menuH3span2 =$("div.category_tree>h3>span.treeright");
	var menuUl = $("div.category_tree>ul");
	menuUl.hide();
	menuH3.each(function(i){
		menuH3.eq(categoryParentIdKey).trigger("click");
		var h3Obj = $(this);
		h3Obj.click(function(){
			menuUl.hide();
			menuH3span2.html('+');
			var hideOrShow = h3Obj.find(">span.treeright").html();
			if(hideOrShow == '+'){
				h3Obj.find(">span.treeright").html('-');
				menuUl.eq(i).show();
			}else{
				h3Obj.find(">span.treeright").html('+');
				menuUl.eq(i).hide();
			}
		});
	});
	// 全部分类结束

	// 列表切换
	$('.gallery .hd ul li').mousemove(function () {
		var a = $(this).index();
		$(this).addClass('on').siblings().removeClass('on');
		$(this).parent().find('.product ul li').eq(a).show().siblings().hide();
	})
	// 列表切换结束
	$('.search_text').focus(function () {
		$(this).val('');
	});
})
