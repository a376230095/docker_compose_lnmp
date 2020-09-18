(function(e) {
	e.fn.hoverIntent = function(t, n, r) {
		var i = {
			interval: 100,
			sensitivity: 7,
			timeout: 0
		};
		if (typeof t === "object") {
			i = e.extend(i, t)
		} else if (e.isFunction(n)) {
			i = e.extend(i, {
				over: t,
				out: n,
				selector: r
			})
		} else {
			i = e.extend(i, {
				over: t,
				out: t,
				selector: n
			})
		}
		var s, o, u, a;
		var f = function(e) {
				s = e.pageX;
				o = e.pageY
			};
		var l = function(t, n) {
				n.hoverIntent_t = clearTimeout(n.hoverIntent_t);
				if (Math.abs(u - s) + Math.abs(a - o) < i.sensitivity) {
					e(n).off("mousemove.hoverIntent", f);
					n.hoverIntent_s = 1;
					return i.over.apply(n, [t])
				} else {
					u = s;
					a = o;
					n.hoverIntent_t = setTimeout(function() {
						l(t, n)
					}, i.interval)
				}
			};
		var c = function(e, t) {
				t.hoverIntent_t = clearTimeout(t.hoverIntent_t);
				t.hoverIntent_s = 0;
				return i.out.apply(t, [e])
			};
		var h = function(t) {
				var n = jQuery.extend({}, t);
				var r = this;
				if (r.hoverIntent_t) {
					r.hoverIntent_t = clearTimeout(r.hoverIntent_t)
				}
				if (t.type == "mouseenter") {
					u = n.pageX;
					a = n.pageY;
					e(r).on("mousemove.hoverIntent", f);
					if (r.hoverIntent_s != 1) {
						r.hoverIntent_t = setTimeout(function() {
							l(n, r)
						}, i.interval)
					}
				} else {
					e(r).off("mousemove.hoverIntent", f);
					if (r.hoverIntent_s == 1) {
						r.hoverIntent_t = setTimeout(function() {
							c(n, r)
						}, i.timeout)
					}
				}
			};
		return this.on({
			"mouseenter.hoverIntent": h,
			"mouseleave.hoverIntent": h
		}, i.selector)
	}
})(jQuery);
//imagesLoaded
(function() {
	function e() {}
	function t(e, t) {
		for (var n = e.length; n--;) if (e[n].listener === t) return n;
		return -1
	}
	function n(e) {
		return function() {
			return this[e].apply(this, arguments)
		}
	}
	var i = e.prototype,
		r = this,
		o = r.EventEmitter;
	i.getListeners = function(e) {
		var t, n, i = this._getEvents();
		if ("object" == typeof e) {
			t = {};
			for (n in i) i.hasOwnProperty(n) && e.test(n) && (t[n] = i[n])
		} else t = i[e] || (i[e] = []);
		return t
	}, i.flattenListeners = function(e) {
		var t, n = [];
		for (t = 0; e.length > t; t += 1) n.push(e[t].listener);
		return n
	}, i.getListenersAsObject = function(e) {
		var t, n = this.getListeners(e);
		return n instanceof Array && (t = {}, t[e] = n), t || n
	}, i.addListener = function(e, n) {
		var i, r = this.getListenersAsObject(e),
			o = "object" == typeof n;
		for (i in r) r.hasOwnProperty(i) && -1 === t(r[i], n) && r[i].push(o ? n : {
			listener: n,
			once: !1
		});
		return this
	}, i.on = n("addListener"), i.addOnceListener = function(e, t) {
		return this.addListener(e, {
			listener: t,
			once: !0
		})
	}, i.once = n("addOnceListener"), i.defineEvent = function(e) {
		return this.getListeners(e), this
	}, i.defineEvents = function(e) {
		for (var t = 0; e.length > t; t += 1) this.defineEvent(e[t]);
		return this
	}, i.removeListener = function(e, n) {
		var i, r, o = this.getListenersAsObject(e);
		for (r in o) o.hasOwnProperty(r) && (i = t(o[r], n), -1 !== i && o[r].splice(i, 1));
		return this
	}, i.off = n("removeListener"), i.addListeners = function(e, t) {
		return this.manipulateListeners(!1, e, t)
	}, i.removeListeners = function(e, t) {
		return this.manipulateListeners(!0, e, t)
	}, i.manipulateListeners = function(e, t, n) {
		var i, r, o = e ? this.removeListener : this.addListener,
			s = e ? this.removeListeners : this.addListeners;
		if ("object" != typeof t || t instanceof RegExp) for (i = n.length; i--;) o.call(this, t, n[i]);
		else for (i in t) t.hasOwnProperty(i) && (r = t[i]) && ("function" == typeof r ? o.call(this, i, r) : s.call(this, i, r));
		return this
	}, i.removeEvent = function(e) {
		var t, n = typeof e,
			i = this._getEvents();
		if ("string" === n) delete i[e];
		else if ("object" === n) for (t in i) i.hasOwnProperty(t) && e.test(t) && delete i[t];
		else delete this._events;
		return this
	}, i.removeAllListeners = n("removeEvent"), i.emitEvent = function(e, t) {
		var n, i, r, o, s = this.getListenersAsObject(e);
		for (r in s) if (s.hasOwnProperty(r)) for (i = s[r].length; i--;) n = s[r][i], n.once === !0 && this.removeListener(e, n.listener), o = n.listener.apply(this, t || []), o === this._getOnceReturnValue() && this.removeListener(e, n.listener);
		return this
	}, i.trigger = n("emitEvent"), i.emit = function(e) {
		var t = Array.prototype.slice.call(arguments, 1);
		return this.emitEvent(e, t)
	}, i.setOnceReturnValue = function(e) {
		return this._onceReturnValue = e, this
	}, i._getOnceReturnValue = function() {
		return this.hasOwnProperty("_onceReturnValue") ? this._onceReturnValue : !0
	}, i._getEvents = function() {
		return this._events || (this._events = {})
	}, e.noConflict = function() {
		return r.EventEmitter = o, e
	}, "function" == typeof define && define.amd ? define("eventEmitter/EventEmitter", [], function() {
		return e
	}) : "object" == typeof module && module.exports ? module.exports = e : this.EventEmitter = e
}).call(this), function(e) {
	function t(t) {
		var n = e.event;
		return n.target = n.target || n.srcElement || t, n
	}
	var n = document.documentElement,
		i = function() {};
	n.addEventListener ? i = function(e, t, n) {
		e.addEventListener(t, n, !1)
	} : n.attachEvent && (i = function(e, n, i) {
		e[n + i] = i.handleEvent ?
		function() {
			var n = t(e);
			i.handleEvent.call(i, n)
		} : function() {
			var n = t(e);
			i.call(e, n)
		}, e.attachEvent("on" + n, e[n + i])
	});
	var r = function() {};
	n.removeEventListener ? r = function(e, t, n) {
		e.removeEventListener(t, n, !1)
	} : n.detachEvent && (r = function(e, t, n) {
		e.detachEvent("on" + t, e[t + n]);
		try {
			delete e[t + n]
		} catch (i) {
			e[t + n] = void 0
		}
	});
	var o = {
		bind: i,
		unbind: r
	};
	"function" == typeof define && define.amd ? define("eventie/eventie", o) : e.eventie = o
}(this), function(e, t) {
	"function" == typeof define && define.amd ? define(["eventEmitter/EventEmitter", "eventie/eventie"], function(n, i) {
		return t(e, n, i)
	}) : "object" == typeof exports ? module.exports = t(e, require("wolfy87-eventemitter"), require("eventie")) : e.imagesLoaded = t(e, e.EventEmitter, e.eventie)
}(window, function(e, t, n) {
	function i(e, t) {
		for (var n in t) e[n] = t[n];
		return e
	}
	function r(e) {
		return "[object Array]" === d.call(e)
	}
	function o(e) {
		var t = [];
		if (r(e)) t = e;
		else if ("number" == typeof e.length) for (var n = 0, i = e.length; i > n; n++) t.push(e[n]);
		else t.push(e);
		return t
	}
	function s(e, t, n) {
		if (!(this instanceof s)) return new s(e, t);
		"string" == typeof e && (e = document.querySelectorAll(e)), this.elements = o(e), this.options = i({}, this.options), "function" == typeof t ? n = t : i(this.options, t), n && this.on("always", n), this.getImages(), a && (this.jqDeferred = new a.Deferred);
		var r = this;
		setTimeout(function() {
			r.check()
		})
	}
	function f(e) {
		this.img = e
	}
	function c(e) {
		this.src = e, v[e] = this
	}
	var a = e.jQuery,
		u = e.console,
		h = u !== void 0,
		d = Object.prototype.toString;
	s.prototype = new t, s.prototype.options = {}, s.prototype.getImages = function() {
		this.images = [];
		for (var e = 0, t = this.elements.length; t > e; e++) {
			var n = this.elements[e];
			"IMG" === n.nodeName && this.addImage(n);
			var i = n.nodeType;
			if (i && (1 === i || 9 === i || 11 === i)) for (var r = n.querySelectorAll("img"), o = 0, s = r.length; s > o; o++) {
				var f = r[o];
				this.addImage(f)
			}
		}
	}, s.prototype.addImage = function(e) {
		var t = new f(e);
		this.images.push(t)
	}, s.prototype.check = function() {
		function e(e, r) {
			return t.options.debug && h && u.log("confirm", e, r), t.progress(e), n++, n === i && t.complete(), !0
		}
		var t = this,
			n = 0,
			i = this.images.length;
		if (this.hasAnyBroken = !1, !i) return this.complete(), void 0;
		for (var r = 0; i > r; r++) {
			var o = this.images[r];
			o.on("confirm", e), o.check()
		}
	}, s.prototype.progress = function(e) {
		this.hasAnyBroken = this.hasAnyBroken || !e.isLoaded;
		var t = this;
		setTimeout(function() {
			t.emit("progress", t, e), t.jqDeferred && t.jqDeferred.notify && t.jqDeferred.notify(t, e)
		})
	}, s.prototype.complete = function() {
		var e = this.hasAnyBroken ? "fail" : "done";
		this.isComplete = !0;
		var t = this;
		setTimeout(function() {
			if (t.emit(e, t), t.emit("always", t), t.jqDeferred) {
				var n = t.hasAnyBroken ? "reject" : "resolve";
				t.jqDeferred[n](t)
			}
		})
	}, a && (a.fn.imagesLoaded = function(e, t) {
		var n = new s(this, e, t);
		return n.jqDeferred.promise(a(this))
	}), f.prototype = new t, f.prototype.check = function() {
		var e = v[this.img.src] || new c(this.img.src);
		if (e.isConfirmed) return this.confirm(e.isLoaded, "cached was confirmed"), void 0;
		if (this.img.complete && void 0 !== this.img.naturalWidth) return this.confirm(0 !== this.img.naturalWidth, "naturalWidth"), void 0;
		var t = this;
		e.on("confirm", function(e, n) {
			return t.confirm(e.isLoaded, n), !0
		}), e.check()
	}, f.prototype.confirm = function(e, t) {
		this.isLoaded = e, this.emit("confirm", this, t)
	};
	var v = {};
	return c.prototype = new t, c.prototype.check = function() {
		if (!this.isChecked) {
			var e = new Image;
			n.bind(e, "load", this), n.bind(e, "error", this), e.src = this.src, this.isChecked = !0
		}
	}, c.prototype.handleEvent = function(e) {
		var t = "on" + e.type;
		this[t] && this[t](e)
	}, c.prototype.onload = function(e) {
		this.confirm(!0, "onload"), this.unbindProxyEvents(e)
	}, c.prototype.onerror = function(e) {
		this.confirm(!1, "onerror"), this.unbindProxyEvents(e)
	}, c.prototype.confirm = function(e, t) {
		this.isConfirmed = !0, this.isLoaded = e, this.emit("confirm", this, t)
	}, c.prototype.unbindProxyEvents = function(e) {
		n.unbind(e.target, "load", this), n.unbind(e.target, "error", this)
	}, s
});


var _$_7106 = ["height", "length", "li.w_pc.on", ".web_show iframe", "marginLeft", "css", ".news_item", "margin-top", "margin-bottom", "marginRight", ".box", "html", "nav", "style", "removeAttr", "*", "find", "append", ".m_nav", "text", ".m_nav li.on>a", ".nav_icon span", "slideToggle", "click", ".nav_icon", "backgroundImage", "footer", "abcmoban", "indexOf", ".templates_list", "href", "attr", "a.qq", "header_home", "addClass", "header", "<div class='ad'><img src='images/ad.png'><p>轻松设计自动适配于桌面及移动端的响应式网站</p><p>配套便捷的HTML5管理后台，轻松实现批量上传，拖放排序等功能</p><p>采用标准的HTML5及CSS3规范便于维护</p></div><a class='apply' href='#'>管理后台操作体验</a><div class='bg_video'></div>", "target", "_blank", "http://freedemo.abcmoban.com/panel/login", "a.apply", "data-parallax-background-inertia", "0.3", ".bg_video", ".nav_about", "header_about", "<div class='about_ad'></div><div class='bg_video' data-parallax-background-inertia='0.3'></div>", ".nav_client", "header_client", "<div class='ad'><img src='images/ad.png'><p>竭诚为用户提供优质的答疑与帮助</p><p>多年开发经验,保证用户的需求得到专业的解决</p><p>与新老用户建立长久的合作关系，不做一锤子买卖</p></div><a class='apply' href='#'>管理后台操作体验</a><div class='bg_video'></div>", "width", "0", "animate", "span", "-20px", "delay", "div>img", "-88px", "hover", ".templates_list .box", "MSIE 8.0", "userAgent", "cover", ".templates_list .box a,.other_box a", ".filter", "top", "offset", "scrollTop", "filter_fix", "list_fix", "removeClass", "scroll", ".case_list", "blank", ".case_box a", "img.no_img", "thumb_no", ".thumb", "each", "#news_list", "querySelector", "progress", "isLoaded", "loaded", "broken", "fadeIn", "closest", "img", "layout", "on", ".ctrl_btn li", ".w_pad,.w_pc,.w_phone", "100%", ".w_pc", "1024px", "640px", "30px", ".w_pad", "414px", "736px", ".w_phone", "fadeToggle", "#output", ".qr_code,#output p", "移除该栏", "prepend", ".close a", "cssText", "position:absolute!important", ".box,.detail_img,nav li", "display:table!important", "body", "ready", "resize"];

function base() {
	var l = $(window)[_$_7106[0]]();
	if ($(_$_7106[2])[_$_7106[1]] > 0) {
		$(_$_7106[3])[_$_7106[0]](l - 36)
	};
	var k = $(_$_7106[6])[_$_7106[5]](_$_7106[4]);
	$(_$_7106[6])[_$_7106[5]](_$_7106[7], k);
	$(_$_7106[6])[_$_7106[5]](_$_7106[8], k);
	var j = $(_$_7106[10])[_$_7106[5]](_$_7106[9]);
	$(_$_7106[10])[_$_7106[5]](_$_7106[8], j);
}
function my_nav() {
	var m = $(_$_7106[12])[_$_7106[11]]();
	$(_$_7106[18])[_$_7106[17]](m)[_$_7106[16]](_$_7106[15])[_$_7106[14]](_$_7106[13]);
	var n = $(_$_7106[20])[_$_7106[19]]();
	$(_$_7106[21])[_$_7106[19]](n);
	$(_$_7106[24])[_$_7106[23]](function() {
		$(_$_7106[18])[_$_7106[22]](200)
	});
}
$(document)[_$_7106[112]](function() {
	var e = $(_$_7106[26])[_$_7106[5]](_$_7106[25]);
	if (e[_$_7106[28]](_$_7106[27]) >= 0) {
		if ($(_$_7106[29])[_$_7106[1]] > 0) {
			var d = $(_$_7106[32])[_$_7106[31]](_$_7106[30]);
			$(_$_7106[35])[_$_7106[34]](_$_7106[33]);
			$(_$_7106[35])[_$_7106[17]](_$_7106[36]);
			$(_$_7106[40])[_$_7106[31]](_$_7106[30], _$_7106[39])[_$_7106[31]](_$_7106[37], _$_7106[38]);
			$(_$_7106[43])[_$_7106[31]](_$_7106[41], _$_7106[42]);
		};
		if ($(_$_7106[44])[_$_7106[1]] > 0) {
			$(_$_7106[35])[_$_7106[34]](_$_7106[45]);
			$(_$_7106[35])[_$_7106[17]](_$_7106[46]);
		};
		if ($(_$_7106[47])[_$_7106[1]] > 0) {
			$(_$_7106[35])[_$_7106[34]](_$_7106[48]);
			$(_$_7106[35])[_$_7106[17]](_$_7106[49]);
			$(_$_7106[40])[_$_7106[31]](_$_7106[30], _$_7106[39])[_$_7106[31]](_$_7106[37], _$_7106[38]);
		};
		$(_$_7106[59])[_$_7106[58]](function() {
			if ($(window)[_$_7106[50]]() > 959) {
				$(_$_7106[53], this)[_$_7106[52]]({
					bottom: _$_7106[51]
				}, 400);
				$(_$_7106[56], this)[_$_7106[55]](100)[_$_7106[52]]({
					top: _$_7106[54]
				}, 400);
			}
		}, function() {
			$(_$_7106[53], this)[_$_7106[52]]({
				bottom: _$_7106[57]
			}, 200);
			$(_$_7106[56], this)[_$_7106[52]]({
				top: _$_7106[51]
			}, 300);
		});
		if (navigator[_$_7106[61]][_$_7106[28]](_$_7106[60]) > 0) {
			$(_$_7106[63])[_$_7106[62]]()
		};
		if ($(_$_7106[64])[_$_7106[1]] > 0) {
			var f = $(_$_7106[64])[_$_7106[66]]()[_$_7106[65]];
			$(window)[_$_7106[71]](function() {
				if ($(window)[_$_7106[50]]() <= 959) {
					return false
				};
				if ($(window)[_$_7106[67]]() > f) {
					$(_$_7106[64])[_$_7106[34]](_$_7106[68]);
					$(_$_7106[29])[_$_7106[34]](_$_7106[69]);
				} else {
					$(_$_7106[64])[_$_7106[70]](_$_7106[68]);
					$(_$_7106[29])[_$_7106[70]](_$_7106[69]);
				};
			});
		};
		if ($(_$_7106[72])[_$_7106[1]] > 0) {
			$(_$_7106[74])[_$_7106[31]](_$_7106[37], _$_7106[73])
		};
		$(_$_7106[6])[_$_7106[78]](function() {
			if ($(_$_7106[75], this)[_$_7106[1]] > 0) {
				$(_$_7106[77], this)[_$_7106[34]](_$_7106[76])
			}
		});
		if ($(_$_7106[79])[_$_7106[1]] > 0) {
			var a = document[_$_7106[80]](_$_7106[79]);
			var c = new Masonry(a);
			var b = imagesLoaded($(_$_7106[6]));
			b[_$_7106[89]](_$_7106[81], function(h, g) {
				var i = g[_$_7106[82]] ? _$_7106[83] : _$_7106[84];
				$(g[_$_7106[87]])[_$_7106[86]](_$_7106[6])[_$_7106[85]](100);
				c[_$_7106[88]]();
			});
		};
		my_nav();
		base();
		$(_$_7106[91])[_$_7106[23]](function() {
			$(_$_7106[90])[_$_7106[78]](function() {
				$(this)[_$_7106[70]](_$_7106[89])
			});
			$(this)[_$_7106[34]](_$_7106[89]);
		});
		$(_$_7106[93])[_$_7106[23]](function() {
			$(_$_7106[3])[_$_7106[5]]({
				"width": _$_7106[92],
				"height": $(window)[_$_7106[0]]() - 36,
				"margin-top": _$_7106[51]
			})
		});
		$(_$_7106[97])[_$_7106[23]](function() {
			$(_$_7106[3])[_$_7106[5]]({
				"width": _$_7106[94],
				"height": _$_7106[95],
				"margin-top": _$_7106[96]
			})
		});
		$(_$_7106[100])[_$_7106[23]](function() {
			$(_$_7106[3])[_$_7106[5]]({
				"width": _$_7106[98],
				"height": _$_7106[99],
				"margin-top": _$_7106[96]
			})
		});
		$(_$_7106[103])[_$_7106[23]](function() {
			$(_$_7106[102])[_$_7106[101]](300)
		});
		$(_$_7106[106])[_$_7106[105]](_$_7106[104]);
	} else {
		$(_$_7106[109])[_$_7106[5]](_$_7106[107], _$_7106[108]);
		$(_$_7106[111])[_$_7106[5]](_$_7106[107], _$_7106[110]);
	};
});
$(window)[_$_7106[113]](function() {
	base()
});


$(document).ready(function() {
	
	function other_out() {
		$('.other_site').fadeOut(300);
	};

	function other_in() {
		$('.other_site').fadeIn(300);
	};

	$('#preview_group').hoverIntent({
		sensitivity: 3,
		//滑鼠滑動的敏感度,最少要設定為1
		interval: 50,
		//滑鼠滑過後要延遲的秒數
		over: other_in,
		//滑鼠滑過要執行的函式
		timeout: 20,
		//滑鼠滑出前要延遲的秒數
		out: other_out //滑鼠滑出要執行的函式
	});
	//demo
});