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
            '#setCookie { float: right; padding: 5px 10px; text-decoration: none; background-color: ' + options.btnColor + ' !important; color: ' + options.btnTextColor + ' !important; margin-right: 10px; } ' +
            '#setCookie:hover { background-color: ' + options.btnHoverColor + ' !important; color: ' + options.btnHoverTextColor + ' !important; } ' +
            '#declineCookie { float: right; padding: 5px 10px; text-decoration: underline; ' + (options.declineBtnColor ? ' background-color: ' + options.declineBtnColor + ' !important; ' : '' ) +  'color: ' + options.declineBtnTextColor + ' !important; } ' +
            '#declineCookie:hover { ' + (options.declineBtnHoverColor ? 'background-color: ' + options.declineBtnHoverColor + ' !important; ' : '' ) + (options.declineBtnHoverTextColor ? 'color: ' + options.declineBtnHoverTextColor + ' !important; ' : '' ) + ' }' +
        '</style>');

        // create popup elements
        $('<div id="cookie_container">' +
            '<div class="cookie_inner">' +
            '   <a id="declineCookie" href="#">' + options.declineBtnText + '</a>' +
            '   <a id="setCookie" href="#">' + options.btnText + '</a>' +
                    options.text +
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
