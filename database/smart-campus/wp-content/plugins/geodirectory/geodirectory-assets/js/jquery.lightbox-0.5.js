/**
 * CHANGED BY STIOFAN FOR RESPONSIVE ON MOBILE - 20/01/2015
 * CHANGED BY KIRAN FOR RESIZE POPUP IMAGE - 22/09/2015
 * jQuery lightBox plugin
 * This jQuery plugin was inspired and based on Lightbox 2 by Lokesh Dhakar (http://www.huddletogether.com/projects/lightbox2/)
 * and adapted to me for use like a plugin from jQuery.
 * @name jquery-lightbox-0.5.js
 * @author Leandro Vieira Pinho - http://leandrovieira.com
 * @version 0.6
 * @date April 11, 2008
 * @category jQuery plugin
 * @copyright (c) 2008 Leandro Vieira Pinho (leandrovieira.com)
 * @license CCAttribution-ShareAlike 2.5 Brazil - http://creativecommons.org/licenses/by-sa/2.5/br/deed.en_US
 * @example Visit http://leandrovieira.com/projects/jquery/lightbox/ for more informations about this jQuery plugin
 */

! function(e) {
    e.fn.lightBox = function(t) {
        function i() {
            return a(this, y), !1
        }

        function a(i, a) {
            if (e("embed, object, select").css({
                    visibility: "hidden"
                }), n(), t.imageArray.length = 0, t.activeImage = 0, 1 == a.length) t.imageArray.push(new Array(i.getAttribute("href"), i.getAttribute("title")));
            else
                for (var r = 0; r < a.length; r++) t.imageArray.push(new Array(a[r].getAttribute("href"), a[r].getAttribute("title")));
            for (; t.imageArray[t.activeImage][0] != i.getAttribute("href");) t.activeImage++;
            o()
        }

        function n() {
            e("body").append('<div id="jquery-overlay"></div><div id="jquery-lightbox"><div id="lightbox-container-image-box"><div id="lightbox-container-image"><img id="lightbox-image"><div style="" id="lightbox-nav"><a href="#" id="lightbox-nav-btnPrev"></a><a href="#" id="lightbox-nav-btnNext"></a></div><div id="lightbox-loading"><a href="#" id="lightbox-loading-link"><img src="' + t.imageLoading + '"></a></div></div></div><div id="lightbox-container-image-data-box"><div id="lightbox-container-image-data"><div id="lightbox-image-details"><span id="lightbox-image-details-caption"></span><span id="lightbox-image-details-currentNumber"></span></div><div id="lightbox-secNav"><a href="#" id="lightbox-secNav-btnClose"><img src="' + t.imageBtnClose + '"></a></div></div></div></div>');
            var i = s();
            e("#jquery-overlay").css({
                backgroundColor: t.overlayBgColor,
                opacity: t.overlayOpacity,
                width: "100%",
                height: i[1]
            }).fadeIn();
            var a = v();
            e("#jquery-lightbox").css({
                top: e(window).scrollTop() + 50,
                left: e(window).scrollLeft()
            }).show(), e("#jquery-overlay,#jquery-lightbox").click(function() {
                u()
            }), e("#lightbox-loading-link,#lightbox-secNav-btnClose").click(function() {
                return u(), !1
            }), e(window).resize(function() {
                var t = s();
                e("#jquery-overlay").css({
                    width: "100%",
                    height: t[1]
                });
                var i = v();
                e("#jquery-lightbox").css({
                    top: e(window).scrollTop() + 50,
					left: e(window).scrollLeft()
                })
            })
        }

        function o() {
            e("#lightbox-loading").show(), t.fixedNavigation ? e("#lightbox-image,#lightbox-container-image-data-box,#lightbox-image-details-currentNumber").hide() : e("#lightbox-image,#lightbox-nav,#lightbox-nav-btnPrev,#lightbox-nav-btnNext,#lightbox-container-image-data-box,#lightbox-image-details-currentNumber").hide();
            var i = new Image;
            i.onload = function() {
				// resize popup image
				var imageHeight;
				var imageWidth;
				var maxWidth;
				var maxHeight;
				var $container = e('#lightbox-container-image');
				
				var $image = e('#lightbox-image', $container);
				$image.attr('src', t.imageArray[t.activeImage][0]);
				$image.width(i.width);
				$image.height(i.height);
				
				var containerTopPadding = parseInt($container.css('padding-top'), 10);
				var containerRightPadding = parseInt($container.css('padding-right'), 10);
				var containerBottomPadding = parseInt($container.css('padding-bottom'), 10);
				var containerLeftPadding = parseInt($container.css('padding-left'), 10);
				var heightBtn = parseInt(e("#lightbox-container-image-data-box", '#jquery-lightbox').height(), 10);
				
				var windowWidth = e(window).width();
				var windowHeight = e(window).height();
				var maxImageWidth = windowWidth - containerLeftPadding - containerRightPadding - 20;
				var maxImageHeight = windowHeight - containerTopPadding - containerBottomPadding - 120;
				
				if (maxWidth && maxWidth < maxImageWidth) {
					maxImageWidth = maxWidth;
				}
				
				if (maxHeight && maxHeight < maxImageWidth) {
					maxImageHeight = maxHeight;
				}
				
				if ((i.width > maxImageWidth) || (i.height > maxImageHeight)) {
					if ((i.width / maxImageWidth) > (i.height / maxImageHeight)) {
						imageWidth = maxImageWidth;
						imageHeight = parseInt(i.height / (i.width / imageWidth), 10);
						$image.width(imageWidth);
						$image.height(imageHeight);
					} else {
						imageHeight = maxImageHeight;
						imageWidth = parseInt(i.width / (i.height / imageHeight), 10);
						$image.width(imageWidth);
						$image.height(imageHeight);
					}
				}
				i.width = $image.width();
				i.height = $image.height();
				// resize popup image
				
				e("#lightbox-image").attr("src", t.imageArray[t.activeImage][0]), r(i.width, i.height), i.onload = function() {}
            }, i.src = t.imageArray[t.activeImage][0]
        }

        function r(i, a) {
            var n = e("#lightbox-container-image-box").width(),
                o = e("#lightbox-container-image-box").height(),
                r = i + 2 * t.containerBorderSize,
                c = a + 2 * t.containerBorderSize;
            intImageWidthDataBox = i, intImageHeightBTN = a + 2 * t.containerBorderSize;
            var l = s();
            r > l[0] && (r = "100%", c = "auto", intImageWidthDataBox = "100%", intImageHeightBTN = c - 2 * t.containerBorderSize);
            var d = n - r,
                m = o - c;
            e("#lightbox-container-image-box").animate({
                width: r,
                height: c
            }, t.containerResizeSpeed, function() {
                g()
            }), 0 == d && 0 == m && x(e.browser.msie ? 250 : 100), e("#lightbox-container-image-data-box").css({
                width: intImageWidthDataBox
            }), e("#lightbox-nav-btnPrev,#lightbox-nav-btnNext").css({
                height: intImageHeightBTN
            })
        }

        function g() {
            e("#lightbox-loading").hide(), e("#lightbox-image").fadeIn(function() {
                c(), l()
            }), b()
        }

        function c() {
            e("#lightbox-container-image-data-box").slideDown("fast"), e("#lightbox-image-details-caption").hide(), t.imageArray[t.activeImage][1] && e("#lightbox-image-details-caption").html(t.imageArray[t.activeImage][1]).show(), t.imageArray.length > 1 && e("#lightbox-image-details-currentNumber").html(t.txtImage + " " + (t.activeImage + 1) + " " + t.txtOf + " " + t.imageArray.length).show()
        }

        function l() {
            e("#lightbox-nav").show(), e("#lightbox-nav-btnPrev,#lightbox-nav-btnNext").css({
                background: "transparent url(" + t.imageBlank + ") no-repeat"
            }), 0 != t.activeImage && (t.fixedNavigation ? e("#lightbox-nav-btnPrev").css({
                background: "url(" + t.imageBtnPrev + ") left 15% no-repeat"
            }).unbind().bind("click", function() {
                return t.activeImage = t.activeImage - 1, o(), !1
            }) : e("#lightbox-nav-btnPrev").unbind().hover(function() {
                e(this).css({
                    background: "url(" + t.imageBtnPrev + ") left 15% no-repeat"
                })
            }, function() {
                e(this).css({
                    background: "transparent url(" + t.imageBlank + ") no-repeat"
                })
            }).show().bind("click", function() {
                return t.activeImage = t.activeImage - 1, o(), !1
            })), t.activeImage != t.imageArray.length - 1 && (t.fixedNavigation ? e("#lightbox-nav-btnNext").css({
                background: "url(" + t.imageBtnNext + ") right 15% no-repeat"
            }).unbind().bind("click", function() {
                return t.activeImage = t.activeImage + 1, o(), !1
            }) : e("#lightbox-nav-btnNext").unbind().hover(function() {
                e(this).css({
                    background: "url(" + t.imageBtnNext + ") right 15% no-repeat"
                })
            }, function() {
                e(this).css({
                    background: "transparent url(" + t.imageBlank + ") no-repeat"
                })
            }).show().bind("click", function() {
                return t.activeImage = t.activeImage + 1, o(), !1
            })), d()
        }

        function d() {
            e(document).keydown(function(e) {
                h(e)
            })
        }

        function m() {
            e(document).unbind()
        }

        function h(e) {
            null == e ? (keycode = event.keyCode, escapeKey = 27) : (keycode = e.keyCode, escapeKey = e.DOM_VK_ESCAPE), key = String.fromCharCode(keycode).toLowerCase(), (key == t.keyToClose || "x" == key || keycode == escapeKey) && u(), (key == t.keyToPrev || 37 == keycode) && 0 != t.activeImage && (t.activeImage = t.activeImage - 1, o(), m()), (key == t.keyToNext || 39 == keycode) && t.activeImage != t.imageArray.length - 1 && (t.activeImage = t.activeImage + 1, o(), m())
        }

        function b() {
            t.imageArray.length - 1 > t.activeImage && (objNext = new Image, objNext.src = t.imageArray[t.activeImage + 1][0]), t.activeImage > 0 && (objPrev = new Image, objPrev.src = t.imageArray[t.activeImage - 1][0])
        }

        function u() {
            e("#jquery-lightbox").remove(), e("#jquery-overlay").fadeOut(function() {
                e("#jquery-overlay").remove()
            }), e("embed, object, select").css({
                visibility: "visible"
            })
        }

        function s() {
            var e, t;
            window.innerHeight && window.scrollMaxY ? (e = window.innerWidth + window.scrollMaxX, t = window.innerHeight + window.scrollMaxY) : document.body.scrollHeight > document.body.offsetHeight ? (e = document.body.scrollWidth, t = document.body.scrollHeight) : (e = document.body.offsetWidth, t = document.body.offsetHeight);
            var i, a;
            return self.innerHeight ? (i = document.documentElement.clientWidth ? document.documentElement.clientWidth : self.innerWidth, a = self.innerHeight) : document.documentElement && document.documentElement.clientHeight ? (i = document.documentElement.clientWidth, a = document.documentElement.clientHeight) : document.body && (i = document.body.clientWidth, a = document.body.clientHeight), pageHeight = a > t ? a : t, pageWidth = i > e ? e : i, arrayPageSize = new Array(pageWidth, pageHeight, i, a), arrayPageSize
        }

        function v() {
            var e, t;
            return self.pageYOffset ? (t = self.pageYOffset, e = self.pageXOffset) : document.documentElement && document.documentElement.scrollTop ? (t = document.documentElement.scrollTop, e = document.documentElement.scrollLeft) : document.body && (t = document.body.scrollTop, e = document.body.scrollLeft), arrayPageScroll = new Array(e, t), arrayPageScroll
        }

        function x(e) {
            var t = new Date;
            i = null;
            do var i = new Date; while (e > i - t)
        }
        t = jQuery.extend({
            overlayBgColor: "#000",
            overlayOpacity: .8,
            fixedNavigation: !1,
            imageLoading: "images/lightbox-ico-loading.gif",
            imageBtnPrev: "images/lightbox-btn-prev.gif",
            imageBtnNext: "images/lightbox-btn-next.gif",
            imageBtnClose: "images/lightbox-btn-close.gif",
            imageBlank: "images/lightbox-blank.gif",
            containerBorderSize: 10,
            containerResizeSpeed: 400,
            txtImage: "Image",
            txtOf: "of",
            keyToClose: "c",
            keyToPrev: "p",
            keyToNext: "n",
            imageArray: [],
            activeImage: 0
        }, t);
        var y = this;
        return this.unbind("click").click(i)
    }
}(jQuery);