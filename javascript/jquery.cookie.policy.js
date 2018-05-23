/*
 *	 UK COOKIE POLICY NOTICE
 *   Written by Lee Jones (mail@leejones.me.uk)
 *   Project Home Page: https://github.com/prolificjones82/uk_cookie_policy_notice
 *   Released under GNU Lesser General Public License (http://www.gnu.org/copyleft/lgpl.html)
 *
 * 	 Please submit all problems or questions to the Issues page on the projects GitHub page:
 *   https://github.com/prolificjones82/uk_cookie_policy_notice
 *
 *
 *   jQuery Cookie Plugin v1.3.1
 *   https://github.com/carhartl/jquery-cookie
 *
 * 	 Copyright 2013 Klaus Hartl
 *   Released under the MIT license
 */
(function($) {
    var pluses = /\+/g;

    function decode(s) {
        if (config.raw) {
            return s;
        }
        return decodeURIComponent(s.replace(pluses, ' '));
    }

    function decodeAndParse(s) {
        if (s.indexOf('"') === 0) {
            // This is a quoted cookie as according to RFC2068, unescape...
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }
        s = decode(s);
        try {
            return config.json ? JSON.parse(s) : s;
        } catch (e) {}
    }
    var config = $.cookie = function(key, value, options) {
        // Write
        if (value !== undefined) {
            options = $.extend({}, config.defaults, options);
            if (typeof options.expires === 'number') {
                var days = options.expires,
                    t = options.expires = new Date();
                t.setDate(t.getDate() + days);
            }
            value = config.json ? JSON.stringify(value) : String(value);
            return (document.cookie = [
                config.raw ? key : encodeURIComponent(key), '=',
                config.raw ? value : encodeURIComponent(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path ? '; path=' + options.path : '',
                options.domain ? '; domain=' + options.domain : '',
                options.secure ? '; secure' : ''
            ].join(''));
        }
        // Read
        var cookies = document.cookie.split('; ');
        var result = key ? undefined : {};
        for (var i = 0, l = cookies.length; i < l; i++) {
            var parts = cookies[i].split('=');
            var name = decode(parts.shift());
            var cookie = parts.join('=');
            if (key && key === name) {
                result = decodeAndParse(cookie);
                break;
            }
            if (!key) {
                result[name] = decodeAndParse(cookie);
            }
        }
        return result;
    };
    config.defaults = {};
    $.removeCookie = function(key, options) {
        if ($.cookie(key) !== undefined) {
            // Must not alter options, thus extending a fresh object...
            $.cookie(key, '', $.extend({}, options, {
                expires: -1
            }));
            return true;
        }
        return false;
    };
}(jQuery));
/* END OF COOKIE PLUGIN */
/* START OF COOKIE POLICY */
(function($) {
    $.fn.cookieNotify = function(options) {
        // plugin options
        var options = $.extend({
            text: 'We use cookies on this website.', // information text
            btnText: 'I Agree', // agree button text
            bgColor: '#CCC', // main info bar background colour, accepts HEX or RGBA
            textColor: '#000', // main info bar text colour, accepts HEX or RGBA
            btnColor: '#000', // button background colour, accepts HEX or RGBA
            btnTextColor: '#FFF', // button text colour, accepts HEX or RGBA
            btnHoverColor: '#AAA', // button background colour, accepts false, HEX or RGBA
            btnHoverTextColor: '#000', // button text colour, accepts HEX or RGBA
            declineBtnText: 'I Disagree', // disgaree button text
            declineBtnColor: false, // button background colour, accepts false, HEX or RGBA
            declineBtnTextColor: '#000', // button text colour, accepts HEX or RGBA
            declineBtnHoverColor: false, // button background colour, accepts false, HEX or RGBA
            declineBtnHoverTextColor: false, // button text colour, false, accepts HEX or RGBA
            position: 'top', // info bar position
            leftPadding: '0', // info bar left spacing, accepts px or % values
            rightPadding: '0', // info bar right spacing, accepts px or % values
            hideAnimation: 'fadeOut' // on click hide animation, options are fadeOut, slideUp
        }, options);

        // create stylesheet
        $('head').append('<style>' +
            '#cookie_container { display: none; position: fixed; ' + options.position + ': 0; left: ' + options.leftPadding + '; right: ' + options.rightPadding + '; z-index: 9999; padding: 10px; background-color:' + options.bgColor + ' !important; color:' + options.textColor + ' !important; }' +
            '#cookie_container p { color:' + options.textColor + ' !important; }' +
            '#cookie_container p a { color:' + options.textColor + ' !important; text-decoration: underline !important; }' +
            '.cookie_inner { width: 90%; margin: 0 auto; } .cookie_inner p { margin: 0; padding-top: 4px; } ' +
            '.cookie_inner .inner_content { float: left}' +
            '.cookie_inner .inner_buttons { float: right; }' +
            '#setCookie { padding: 5px 10px; text-decoration: none; background-color: ' + options.btnColor + ' !important; color: ' + options.btnTextColor + ' !important; margin-right: 10px; } ' +
            '#setCookie:hover { background-color: ' + options.btnHoverColor + ' !important; color: ' + options.btnHoverTextColor + ' !important; } ' +
            '#declineCookie { padding: 5px 10px; text-decoration: underline; ' + (options.declineBtnColor ? ' background-color: ' + options.declineBtnColor + ' !important; ' : '' ) +  'color: ' + options.declineBtnTextColor + ' !important; } ' +
            '#declineCookie:hover { ' + (options.declineBtnHoverColor ? 'background-color: ' + options.declineBtnHoverColor + ' !important; ' : '' ) + (options.declineBtnHoverTextColor ? 'color: ' + options.declineBtnHoverTextColor + ' !important; ' : '' ) + ' }' +
            '@media screen and (max-width: 767px) {' +
            '  .cookie_inner .inner_content, .cookie_inner .inner_buttons { float: none; text-align: center; }' +
            '  .cookie_inner .inner_content { margin-bottom: 10px; }' +
            '}' +
        '</style>');

        // create popup elements
        $('<div id="cookie_container">' +
            '<div class="cookie_inner">' +
            '   <div class="inner_content">' + options.text + '</div>' +
            '   <div class="inner_buttons">' +
            '       <a id="setCookie" href="#">' + options.btnText + '</a>' +
            '       <a id="declineCookie" href="#">' + options.declineBtnText + '</a>' +
            '   </div>' +
            '</div>' +
        '</div>').appendTo(this);

        // set cookie function
        $(document.body).on('click', '#setCookie', function(e) {
            e.preventDefault();
            $.cookie('cookie_policy', 'true', {
                expires: 365,
                path: '/'
            });
            if (options.hideAnimation === 'fadeOut') {
                $('#cookie_container').fadeOut();
            } else if (options.hideAnimation === 'slideUp') {
                $('#cookie_container').slideUp();
            }
        });
        // decline cookie function
        $(document.body).on('click', '#declineCookie', function(e) {
            e.preventDefault();
            $.cookie('cookie_policy', 'false', {
                expires: 365,
                path: '/'
            });
            if (options.hideAnimation === 'fadeOut') {
                $('#cookie_container').fadeOut();
            } else if (options.hideAnimation === 'slideUp') {
                $('#cookie_container').slideUp();
            }
        });
        // detect cookie
        $(this).ready(function() {
            var cookie = $.cookie('cookie_policy'); // => "true";
            if (!cookie) {
                $('#cookie_container').show();
            }
        });
    }
}(jQuery));
