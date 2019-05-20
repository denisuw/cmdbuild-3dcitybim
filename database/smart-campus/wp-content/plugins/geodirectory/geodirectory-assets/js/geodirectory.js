// get url paramiters
var gdUrlParam = function gdUrlParam(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


/* GD lazy load images */
jQuery.fn.gdunveil = function(threshold, callback,extra1) {

    var $w = jQuery(window),
        th = threshold || 0,
        retina = window.devicePixelRatio > 1,
        attrib = retina? "data-src-retina" : "data-src",
        images = this,
        loaded;

    if(extra1){
        var $e1 = jQuery(extra1),
            th = threshold || 0,
            retina = window.devicePixelRatio > 1,
            attrib = retina? "data-src-retina" : "data-src",
            images = this,
            loaded;
    }

    this.one("gdunveil", function() {
        var source = this.getAttribute(attrib);
        source = source || this.getAttribute("data-src");
        if (source) {
            //this.setAttribute("src", source);
            // $(this).removeClass('geodir_lazy_load_thumbnail');
            jQuery(this).css('background-image', 'url("' + source + '")');
            if (typeof callback === "function") callback.call(this);
        }
    });

    function gdunveil() {
        var inview = images.filter(function() {
            var $e = jQuery(this);
            if ($e.is(":hidden")) return;

            var wt = $w.scrollTop(),
                wb = wt + $w.height(),
                et = $e.offset().top,
                eb = et + $e.height();

            return eb >= wt - th && et <= wb + th;
        });

        loaded = inview.trigger("gdunveil");
        images = images.not(loaded);
    }

    $w.on("scroll.gdunveil resize.gdunveil lookup.gdunveil", gdunveil);
    if(extra1){
        $e1.on("scroll.gdunveil resize.gdunveil lookup.gdunveil", gdunveil);
    }

    gdunveil();

    return this;

};


function geodir_init_lazy_load(){
    // load for GD images
    jQuery(".geodir_thumbnail").gdunveil(100,function() {this.style.opacity = 1;},'#geodir_content');

    // fire when the image tab is clicked on details page
    jQuery('#gd-tabs').click(function() {
        setTimeout(function(){jQuery(window).trigger("lookup"); }, 100);
    });

    // fire after document load, just incase
    jQuery(document).ready(function() {
        setTimeout(function(){jQuery(window).trigger("lookup"); }, 100);
    });
}


jQuery(function() {
    // start lazy load if it's turned on
    if(geodir_var.geodir_lazy_load==1){
        geodir_init_lazy_load();
    }
});



/* Placeholders.js v3.0.2  fixes placeholder support for older browsers */
(function (t) {
    "use strict";
    function e(t, e, r) {
        return t.addEventListener ? t.addEventListener(e, r, !1) : t.attachEvent ? t.attachEvent("on" + e, r) : void 0
    }

    function r(t, e) {
        var r, n;
        for (r = 0, n = t.length; n > r; r++)if (t[r] === e)return !0;
        return !1
    }

    function n(t, e) {
        var r;
        t.createTextRange ? (r = t.createTextRange(), r.move("character", e), r.select()) : t.selectionStart && (t.focus(), t.setSelectionRange(e, e))
    }

    function a(t, e) {
        try {
            return t.type = e, !0
        } catch (r) {
            return !1
        }
    }

    t.Placeholders = {Utils: {addEventListener: e, inArray: r, moveCaret: n, changeType: a}}
})(this), function (t) {
    "use strict";
    function e() {
    }

    function r() {
        try {
            return document.activeElement
        } catch (t) {
        }
    }

    function n(t, e) {
        var r, n, a = !!e && t.value !== e, u = t.value === t.getAttribute(V);
        return (a || u) && "true" === t.getAttribute(D) ? (t.removeAttribute(D), t.value = t.value.replace(t.getAttribute(V), ""), t.className = t.className.replace(R, ""), n = t.getAttribute(F), parseInt(n, 10) >= 0 && (t.setAttribute("maxLength", n), t.removeAttribute(F)), r = t.getAttribute(P), r && (t.type = r), !0) : !1
    }

    function a(t) {
        var e, r, n = t.getAttribute(V);
        return "" === t.value && n ? (t.setAttribute(D, "true"), t.value = n, t.className += " " + I, r = t.getAttribute(F), r || (t.setAttribute(F, t.maxLength), t.removeAttribute("maxLength")), e = t.getAttribute(P), e ? t.type = "text" : "password" === t.type && M.changeType(t, "text") && t.setAttribute(P, "password"), !0) : !1
    }

    function u(t, e) {
        var r, n, a, u, i, l, o;
        if (t && t.getAttribute(V))e(t); else for (a = t ? t.getElementsByTagName("input") : b, u = t ? t.getElementsByTagName("textarea") : f, r = a ? a.length : 0, n = u ? u.length : 0, o = 0, l = r + n; l > o; o++)i = r > o ? a[o] : u[o - r], e(i)
    }

    function i(t) {
        u(t, n)
    }

    function l(t) {
        u(t, a)
    }

    function o(t) {
        return function () {
            m && t.value === t.getAttribute(V) && "true" === t.getAttribute(D) ? M.moveCaret(t, 0) : n(t)
        }
    }

    function c(t) {
        return function () {
            a(t)
        }
    }

    function s(t) {
        return function (e) {
            return A = t.value, "true" === t.getAttribute(D) && A === t.getAttribute(V) && M.inArray(C, e.keyCode) ? (e.preventDefault && e.preventDefault(), !1) : void 0
        }
    }

    function d(t) {
        return function () {
            n(t, A), "" === t.value && (t.blur(), M.moveCaret(t, 0))
        }
    }

    function g(t) {
        return function () {
            t === r() && t.value === t.getAttribute(V) && "true" === t.getAttribute(D) && M.moveCaret(t, 0)
        }
    }

    function v(t) {
        return function () {
            i(t)
        }
    }

    function p(t) {
        t.form && (T = t.form, "string" == typeof T && (T = document.getElementById(T)), T.getAttribute(U) || (M.addEventListener(T, "submit", v(T)), T.setAttribute(U, "true"))), M.addEventListener(t, "focus", o(t)), M.addEventListener(t, "blur", c(t)), m && (M.addEventListener(t, "keydown", s(t)), M.addEventListener(t, "keyup", d(t)), M.addEventListener(t, "click", g(t))), t.setAttribute(j, "true"), t.setAttribute(V, x), (m || t !== r()) && a(t)
    }

    var b, f, m, h, A, y, E, x, L, T, N, S, w, B = ["text", "search", "url", "tel", "email", "password", "number", "textarea"], C = [27, 33, 34, 35, 36, 37, 38, 39, 40, 8, 46], k = "#ccc", I = "placeholdersjs", R = RegExp("(?:^|\\s)" + I + "(?!\\S)"), V = "data-placeholder-value", D = "data-placeholder-active", P = "data-placeholder-type", U = "data-placeholder-submit", j = "data-placeholder-bound", q = "data-placeholder-focus", z = "data-placeholder-live", F = "data-placeholder-maxlength", G = document.createElement("input"), H = document.getElementsByTagName("head")[0], J = document.documentElement, K = t.Placeholders, M = K.Utils;
    if (K.nativeSupport = void 0 !== G.placeholder, !K.nativeSupport) {
        for (b = document.getElementsByTagName("input"), f = document.getElementsByTagName("textarea"), m = "false" === J.getAttribute(q), h = "false" !== J.getAttribute(z), y = document.createElement("style"), y.type = "text/css", E = document.createTextNode("." + I + " { color:" + k + "; }"), y.styleSheet ? y.styleSheet.cssText = E.nodeValue : y.appendChild(E), H.insertBefore(y, H.firstChild), w = 0, S = b.length + f.length; S > w; w++)N = b.length > w ? b[w] : f[w - b.length], x = N.attributes.placeholder, x && (x = x.nodeValue, x && M.inArray(B, N.type) && p(N));
        L = setInterval(function () {
            for (w = 0, S = b.length + f.length; S > w; w++)N = b.length > w ? b[w] : f[w - b.length], x = N.attributes.placeholder, x ? (x = x.nodeValue, x && M.inArray(B, N.type) && (N.getAttribute(j) || p(N), (x !== N.getAttribute(V) || "password" === N.type && !N.getAttribute(P)) && ("password" === N.type && !N.getAttribute(P) && M.changeType(N, "text") && N.setAttribute(P, "password"), N.value === N.getAttribute(V) && (N.value = x), N.setAttribute(V, x)))) : N.getAttribute(D) && (n(N), N.removeAttribute(V));
            h || clearInterval(L)
        }, 100)
    }
    M.addEventListener(t, "beforeunload", function () {
        K.disable()
    }), K.disable = K.nativeSupport ? e : i, K.enable = K.nativeSupport ? e : l
}(this);

jQuery(document).ready(function($) {
    //toggle detail page tabs mobile menu
    jQuery('#geodir-tab-mobile-menu').click(function() {
        jQuery('#gd-tabs .geodir-tab-head').toggle();
    });
    
    gd_infowindow = (typeof google !== 'undefined' && typeof google.maps !== 'undefined') ? new google.maps.InfoWindow() : null;
    
    // Chosen selects
    if (jQuery("select.chosen_select").length > 0) {
        jQuery("select.chosen_select").chosen({
            no_results_text: "Sorry, nothing found!"
        });
        jQuery("select.chosen_select_nostd").chosen({
            allow_single_deselect: 'true'
        });
    }
    
    jQuery('.gd-cats-display-checkbox input[type="checkbox"]').click(function() {
        var isChecked = jQuery(this).is(':checked');
        if (!isChecked) {
            var chkVal = jQuery(this).val();
            jQuery(this).closest('.gd-parent-cats-list').find('.gd-cat-row-' + chkVal + ' input[type="checkbox"]').prop("checked", isChecked);
        }
    });

    jQuery('.geodir-delete').click(function() {
        var message = geodir_all_js_msg.my_place_listing_del;
        
        if (jQuery(this).closest('.geodir-gridview').hasClass('gdp-franchise-m') || jQuery(this).closest('.geodir-listview').hasClass('gdp-franchise-m')) {
            message = geodir_all_js_msg.my_main_listing_del;
        }
        
        if (confirm(message)) {
            return true;
        } else {
            return false;
        }
    });
    
    jQuery('.gd-category-dd').hover(function() {
        jQuery('.gd-category-dd ul').show();
    });
    
    jQuery('.gd-category-dd ul li a').click(function(ele) {
        jQuery('.gd-category-dd').find('input').val(jQuery(this).attr('data-slug'));
        jQuery('.gd-category-dd > a').html(jQuery(this).attr('data-name'));
        jQuery('.gd-category-dd ul').hide();
    });



    // setup search forms
    geodir_setup_search_form();



});


jQuery(window).load(function() {
    /*-----------------------------------------------------------------------------------*/
    /* Tabs
    /*-----------------------------------------------------------------------------------*/
    jQuery('.geodir-tabs-content').show(); // set the tabs to show once js loaded to avoid double scroll bar in chrome
    tabNoRun = false;

    function activateTab(tab) {
        if ( !jQuery( ".geodir-tab-head" ).length ) {
            return;
        }
        // change name for mobile tabs menu
        tabName = urlHash = tab.find('a').html();
        
        if (tabName && jQuery('.geodir-mobile-active-tab').length) {
            jQuery('.geodir-mobile-active-tab').html(tabName);
        }
        
        if (tabNoRun) {
            tabNoRun = false;
            return;
        }
        var activeTab = tab.closest('dl').find('dd.geodir-tab-active'), contentLocation = tab.find('a').attr("data-tab") + 'Tab';
        urlHash = tab.find('a').attr("data-tab");
        
        if (jQuery(tab).hasClass("geodir-tab-active")) {} else {
            if (typeof urlHash === 'undefined') {
                if (window.location.hash.substring(0, 8) == '#comment') {
                    tab = jQuery('*[data-tab="#reviews"]').parent();
                    tabNoRun = true;
                }
            } else {
                if (history.pushState) {
                    //history.pushState(null, null, urlHash);
                    history.replaceState(null, null, urlHash); // wont make the browser back button go back to prev has value
                } else {
                    window.location.hash = urlHash;
                }
            }
        }
        
        //Make Tab Active
        activeTab.removeClass('geodir-tab-active');
        tab.addClass('geodir-tab-active');
        
        //Show Tab Content
        jQuery(contentLocation).closest('.geodir-tabs-content').children('li').hide();
        jQuery(contentLocation).fadeIn();
        jQuery(contentLocation).css({
            'display': 'inline-block'
        });
        
        if (urlHash == '#post_map' && window.gdMaps) {
            window.setTimeout(function() {
                jQuery("#detail_page_map_canvas").goMap();
                var center = jQuery.goMap.map.getCenter();
                if (window.gdMaps == 'osm') {
                    jQuery.goMap.map.invalidateSize();
                    jQuery.goMap.map._onResize();
                    jQuery.goMap.map.panTo(center);
                } else {
                    google.maps.event.trigger(jQuery.goMap.map, 'resize');
                    jQuery.goMap.map.setCenter(center);
                }
            }, 100);
        }
        
        if (history.pushState && window.location.hash && jQuery('#publish_listing').length === 0) {
            if (jQuery(window).width() < 1060) {
                jQuery('#gd-tabs .geodir-tab-head').toggle();
                jQuery('html, body').animate({
                    scrollTop: jQuery('#geodir-tab-mobile-menu').offset().top
                }, 500);
            }
        }
    } // end activateTab()
    
    jQuery('dl.geodir-tab-head').each(function() {
        //Get all tabs
        var tabs = jQuery(this).children('dd');
        tabs.click(function(e) {
            if (jQuery(this).find('a').attr('data-status') == 'enable') {
                activateTab(jQuery(this));
            }
        });
    });
    
    if (window.location.hash) {
        activateTab(jQuery('a[data-tab="' + window.location.hash + '"]').parent());
    }

    jQuery('.gd-tabs .gd-tab-next').click(function(ele) {
        var is_validate = true;

        if (is_validate) {
            var tab = jQuery('dl.geodir-tab-head').find('dd.geodir-tab-active').next();
            if (tab.find('a').attr('data-status') == 'enable') {
                activateTab(tab);
            }
            if (!jQuery('dl.geodir-tab-head').find('dd.geodir-tab-active').next().is('dd')) {
                jQuery(this).hide();
                jQuery('#gd-add-listing-submit').show();
            }
        }
    });
    
    jQuery('#gd-login-options input').change(function() {
        jQuery('.gd-login_submit').toggle();
    });
    
    jQuery('ul.geodir-tabs-content').css({
        'z-index': '0',
        'position': 'relative'
    });
    
    jQuery('dl.geodir-tab-head dd.geodir-tab-active').trigger('click');
});


/*-----------------------------------------------------------------------------------*/
/* Auto Fill
/*-----------------------------------------------------------------------------------*/
function autofill_click(ele) {
    var fill_value = jQuery(ele).html();
    jQuery(ele).closest('div.gd-autofill-dl').closest('div.gd-autofill').find('input[type=text]').val(fill_value);
    jQuery(ele).closest('.gd-autofill-dl').remove();
};

jQuery(document).ready(function() {
    jQuery('input[type=text]').keyup(function() {
        var input_field = jQuery(this);
        if (input_field.attr('data-type') == 'autofill' && input_field.attr('data-fill') != '') {
            var data_fill = input_field.attr('data-fill');
            var fill_value = jQuery(this).val();
            jQuery.get(geodir_var.geodir_ajax_url, {
                autofill: data_fill,
                fill_str: fill_value
            }, function(data) {
                if (data != '') {
                    if (input_field.closest('div.gd-autofill').length == 0) input_field.wrap('<div class="gd-autofill"></div>');
                    input_field.closest('div.gd-autofill').find('.gd-autofill-dl').remove();
                    input_field.after('<div class="gd-autofill-dl"></div>');
                    input_field.next('.gd-autofill-dl').html(data);
                    input_field.focus();
                }
            });
        }
    });
    
    jQuery('input[type=text]').parent().mouseleave(function() {
        jQuery(this).find('.gd-autofill-dl').remove();
    });
    
    jQuery(".gd-trigger").click(function() {
        jQuery(this).toggleClass("active").next().slideToggle("slow");
        var aD = jQuery(this).toggleClass("active").next().hasClass('map_category') ? true : false;
        if (jQuery(".gd-trigger").hasClass("gd-triggeroff")) {
            jQuery(".gd-trigger").removeClass('gd-triggeroff');
            jQuery(".gd-trigger").addClass('gd-triggeron');
            if (aD) {
                gd_compress_animate(this, 0);
            }
        } else {
            jQuery(".gd-trigger").removeClass('gd-triggeron');
            jQuery(".gd-trigger").addClass('gd-triggeroff');
            if (aD) {
                gd_compress_animate(this, parseFloat(jQuery(this).toggleClass("active").next().outerWidth()));
            }
        }
    });
    
    jQuery(".gd-trigger").each(function() {
        if (jQuery(this).hasClass('gd-triggeroff') && jQuery(this).next().hasClass('map_category')) {
            gd_compress_animate(this, parseFloat(jQuery(this).next().outerWidth()));
        }
    });
    
    jQuery(".trigger_sticky").click(function() {
        var effect = 'slide';
        var options = {
            direction: 'right'
        };
        var duration = 500;
        var tigger_sticky = jQuery(this);
        tigger_sticky.hide();
        jQuery('div.stickymap').toggle(effect, options, duration, function() {
            tigger_sticky.show();
        });
        if (tigger_sticky.hasClass("triggeroff_sticky")) {
            tigger_sticky.removeClass('triggeroff_sticky');
            tigger_sticky.addClass('triggeron_sticky');
            setCookie('geodir_stickystatus', 'shide', 1);
        } else {
            tigger_sticky.removeClass('triggeron_sticky');
            tigger_sticky.addClass('triggeroff_sticky');
            setCookie('geodir_stickystatus', 'sshow', 1);
        }
    });

    function gd_compress_animate(e, r) {
        jQuery(e).animate({
            "margin-right": r + "px"
        }, "fast");
    }
    
    var gd_modal = "undefined" != typeof geodir_var.geodir_gd_modal && 1 == parseInt(geodir_var.geodir_gd_modal) ? false : true;
    
    if (gd_modal) {
        jQuery(".geodir-custom-post-gallery").each(function() {
            jQuery("a", this).lightBox({
                overlayOpacity: .5,
                imageLoading: geodir_var.geodir_plugin_url + "/geodirectory-assets/images/lightbox-ico-loading.gif",
                imageBtnNext: geodir_var.geodir_plugin_url + "/geodirectory-assets/images/lightbox-btn-next.gif",
                imageBtnPrev: geodir_var.geodir_plugin_url + "/geodirectory-assets/images/lightbox-btn-prev.gif",
                imageBtnClose: geodir_var.geodir_plugin_url + "/geodirectory-assets/images/lightbox-btn-close.gif",
                imageBlank: geodir_var.geodir_plugin_url + "/geodirectory-assets/images/lightbox-blank.gif"
            })
        });
    }

    /* Show Hide Rating for reply */
    jQuery('.gd_comment_replaylink a').bind('click', function() {
        jQuery('#commentform #err_no_rating').remove();
        jQuery('#commentform .gd_rating').hide();
        jQuery('#commentform .br-wrapper.br-theme-fontawesome-stars').hide();
        jQuery('#commentform #geodir_overallrating').val('0');
        jQuery('#respond .form-submit input#submit').val(geodir_all_js_msg.gd_cmt_btn_post_reply);
        jQuery('#respond .comment-form-comment label').html(geodir_all_js_msg.gd_cmt_btn_reply_text);
    });
    
    jQuery('.gd-cancel-replaylink a').bind('click', function() {
        jQuery('#commentform #err_no_rating').remove();
        jQuery('#commentform .gd_rating').show();
        jQuery('#commentform .br-wrapper.br-theme-fontawesome-stars').show();
        jQuery('#commentform #geodir_overallrating').val('0');
        jQuery('#respond .form-submit input#submit').val(geodir_all_js_msg.gd_cmt_btn_post_review);
        jQuery('#respond .comment-form-comment label').html(geodir_all_js_msg.gd_cmt_btn_review_text);
    });
    
    jQuery('#commentform .gd_rating, #commentform .gd-fa-rating').each(function() {
        var rat_obj = this;
        var $frm_obj = jQuery(rat_obj).closest('#commentform');
        
        if (parseInt($frm_obj.find('#comment_parent').val()) > 0) {
            jQuery('#commentform #err_no_rating').remove();
            jQuery('#commentform .gd_rating').hide();
            jQuery('#respond .form-submit input#submit').val(geodir_all_js_msg.gd_cmt_btn_post_reply);
            jQuery('#respond .comment-form-comment label').html(geodir_all_js_msg.gd_cmt_btn_reply_text);
        }

        if (!geodir_all_js_msg.multirating) {
            $frm_obj.find('input[name="submit"]').click(function(e) {
                var $comment = jQuery('textarea[name="comment"]', $frm_obj);
                jQuery('#err_no_comment', $frm_obj).remove();
                $frm_obj.find('#err_no_rating').remove();
                
                var is_review = parseInt($frm_obj.find('#comment_parent').val());
                is_review = is_review == 0 ? true : false;
                var commentField = typeof tinyMCE != 'undefined' && typeof tinyMCE.editors != 'undefined' && typeof tinyMCE.editors['comment'] == 'object' ? tinyMCE.editors['comment'] : null;
                if (commentField) {
                    commentField.editorManager.triggerSave();
                }
                var commentTxt = jQuery.trim($comment.val());
                if (!commentTxt) {
                    var $err = is_review ? geodir_all_js_msg.err_empty_review : geodir_all_js_msg.err_empty_review;
                    $comment.before('<div id="err_no_comment" class="err-no-rating">' + $err + '</div>');
                    $comment.focus();
                    return false;
                }
                
                // skip rating stars validation if rating stars disabled
                if (typeof geodir_all_js_msg.gd_cmt_disable_rating != 'undefined' && geodir_all_js_msg.gd_cmt_disable_rating) {
                    return true;
                }
                //
                
                if (is_review) {
                    var btn_obj = this;
                    var invalid = 0;
                    
                    $frm_obj.find('input[name^=geodir_overallrating]').each(function() {
                        var star_obj = this;
                        var star = parseInt(jQuery(star_obj).val());
                        if (!star > 0) {
                            invalid++;
                        }
                    });
                    
                    if (invalid > 0) {
                        jQuery(rat_obj).after('<div id="err_no_rating" class="err-no-rating">' + geodir_all_js_msg.gd_cmt_err_no_rating + '</div>');
                        return false;
                    }
                    return true;
                }
            });
        }
    });
});

/* Show Hide Filters End */
/* Hide Pinpoint If Listing MAP Not On Page */
jQuery(window).load(function () {
    if (jQuery(".map_background").length == 0) {
        jQuery('.geodir-pinpoint').hide();
    } else {
        jQuery('.geodir-pinpoint').show();
    }
});

//-------count post according to term--
function geodir_get_post_term(el) {
    limit = jQuery(el).data('limit');
    term = jQuery(el).val();//data('term');
    var parent_only = parseInt(jQuery(el).data('parent')) > 0 ? 1 : 0;
    jQuery(el).parent().parent().find('.geodir-popular-cat-list').html('<i class="fa fa-cog fa-spin"></i>');
    jQuery(el).parent().parent().parent().find('.geodir-cat-list-more').hide();
    jQuery.post(geodir_all_js_msg.geodir_admin_ajax_url + '?action=geodir_ajax_action', {
        ajax_action: "geodir_get_term_list",
        term: term,
        limit: limit,
        parent_only: parent_only
    }).done(function (data) {
        if (jQuery.trim(data) != '') {
            jQuery(el).parent().parent().find('.geodir-popular-cat-list').hide().html(data).fadeIn('slow');
            if (jQuery(el).parent().parent().find('.geodir-popular-cat-list li').length > limit) {
                jQuery(el).parent().parent().parent().find('.geodir-cat-list-more').fadeIn('slow');
            }
        }
    });
}

/* we recalc the stars because some browsers can't do subpixle percents, we should be able to remove this in a few years. */
jQuery(window).load(function() {
    geodir_resize_rating_stars();
    
    jQuery(document).on('click', '.geodir-rating,.gd-star-rating', function(e) {
        if (reviewLink = jQuery(this).closest('.geodir-category-listing').find('a.geodir-pcomments').attr('href')) {
            window.location = reviewLink;
        } else if (reviewLink = jQuery(this).closest('.gd-bubble').find('a.geodir-pcomments').attr('href')) {
            window.location = reviewLink;
        }
    });
    jQuery('.geodir-details-sidebar-rating').on('click', '.geodir-rating,.gd-star-rating', function(e) {
        jQuery('#gd-tabs [data-tab="#reviews"]').trigger('click');
        jQuery('html, body').animate({
            scrollTop: jQuery('#reviews-wrap').offset().top
        }, 500);
    });
});

jQuery(window).resize(function() {
    geodir_resize_rating_stars(true);
});

/* Adjust/resize rating stars width. */
function geodir_resize_rating_stars(re) {
    jQuery('.geodir-rating').each(function() {
        var $this = jQuery(this);
        var parent_width = $this.width();
        if (!parent_width) {
            return true;
        }
        var star_width = $this.find(".geodir_Star img").width();
        var star_count = $this.find(".geodir_Star img").length;
        var width_calc = star_width * star_count;
        width_calc = typeof re != 'undefined' && re ? 'auto' : width_calc;
        $this.width(width_calc);
    });
}

function geodir_load_search_form(stype, el) {
    var $adv_show = jQuery(el).closest('.geodir_advance_search_widget').attr('data-show-adv');

    jQuery.ajax({
        url: geodir_all_js_msg.geodir_admin_ajax_url,
        type: 'POST',
        dataType: 'html',
        data: {
            action: 'geodir_search_form',
            stype: stype,
            adv: $adv_show
        },
        beforeSend: function() {
            geodir_search_wait(1);
        },
        success: function(data, textStatus, xhr) {
            // replace whole form
            jQuery(el).closest('.geodir_advance_search_widget').html(data);

            geodir_setup_search_form();
            // trigger a custom event wen setting up the search form so we can hook to it from addons
            jQuery("body").trigger("geodir_setup_search_form");

            geodir_search_wait(0);
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log(textStatus);geodir_search_wait(0);
        }
    });
}

function geodir_setup_search_form(){
    //  new seach form change
    if (jQuery('.search_by_post').val()) {
        gd_s_post_type = jQuery('.search_by_post').val();
    } else {
        gd_s_post_type = "gd_place";
    }


    setTimeout(function(){
        jQuery('.search_by_post').change(function() {
            gd_s_post_type = jQuery(this).val();

            geodir_load_search_form(gd_s_post_type, this);

        });
    }, 100);
}

gdSearchDoing = 0;
var gdNearChanged = 0;
gd_search_icon ='';
function geodir_search_wait(on){
    waitTime = 300;

    if(on){
        if(gdSearchDoing){return;}
        gdSearchDoing = 1;
        jQuery('.geodir_submit_search').addClass('gd-wait-btnsearch').prop('disabled', true);
        jQuery('.showFilters').prop('disabled', true);
        searchPos = 1;
        gd_search_icon = jQuery('.geodir_submit_search').html();
        function geodir_search_wait_animate() {
            if(!searchPos){return;}
            if(searchPos==1){jQuery('input[type="button"].geodir_submit_search').val('  ');searchPos=2;window.setTimeout(geodir_search_wait_animate, waitTime );return;}
            if(searchPos==2){jQuery('input[type="button"].geodir_submit_search').val('  ');searchPos=3;window.setTimeout(geodir_search_wait_animate, waitTime );return;}
            if(searchPos==3){jQuery('input[type="button"].geodir_submit_search').val('  ');searchPos=1;window.setTimeout(geodir_search_wait_animate, waitTime );return;}



        }
        geodir_search_wait_animate();
        jQuery('button.geodir_submit_search').html('<i class="fa fa-hourglass fa-spin" aria-hidden="true"></i>');
    } else {
        searchPos = 0;
        gdSearchDoing = 0;
        jQuery('.geodir_submit_search').removeClass('gd-wait-btnsearch').prop('disabled', false);
        jQuery('.showFilters').prop('disabled', false);
        jQuery('input[type="button"].geodir_submit_search').val(gdsText);

        jQuery('button.geodir_submit_search').html(gd_search_icon);
    }

}