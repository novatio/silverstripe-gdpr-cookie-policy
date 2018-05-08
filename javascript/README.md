# AVG / GDPR SilverStripe Cookie Policy Module 
*A simple plugin to notify users you adhere to the EU's cookie policies*

Updated in May 2012, the ICO set out the changes to the cookies law and explains the steps you need to take to ensure you comply. The updated guidance provides additional information around the issue of implied consent:

- Implied consent is a valid form of consent and can be used in the context of compliance with the revised rules on cookies.
- If you are relying on implied consent you need to be satisfied that your users understand that their actions will result in cookies being set. Without this understanding you do not have their informed consent.
- You should not rely on the fact that users might have read a privacy policy that is perhaps hard to find or difficult to understand.
- In some circumstances, for example where you are collecting sensitive personal data such as health information, you might feel that explicit consent is more appropriate.

This small plugin ensure your website conforms to these guidelines. It works by placing a cookie on the users machine for a year to show they allow this action from your website.

*Only in the UK would you need to put a cookie on someones machine to show they allow cookies!*

## How to use

Just install the module and check out the added SiteConfig settings in your admin.

To

##Options

I have added a few options to aid in customizing the plugin.

```html
<script>
$('body').cookieNotify({
	text: '', // information text
	btnText: '', // agree button text
	btnDisagreeText: '', // disagree button text
	bgColor: '', // main info bar background colour, accepts HEX or RGBA
	textColor: '', // main info bar text colour, accepts HEX or RGBA
	btnColor: '', // button background colour, accepts HEX or RGBA
	btnTextColor: '', // button text colour, accepts HEX or RGBA
	position: '', // info bar position
	leftPadding: '', // info bar left spacing, accepts px or % values
	rightPadding: '', // info bar right spacing, accepts px or % values
	hideAnimation: '' // on click hide animation, options are fadeOut, slideUp
});
</script>
```

If you can think of anything else you'd like as an option, let me know and I'll see if I can add it in.

##Thanks & Donations

Thanks to <a href="https://github.com/carhartl/jquery-cookie" target="_blank">carhartl</a> for the jQuery Cookie plugin.

If you find this script so amazing you want to thank me, please feel free to make a small donation on my <a href="http://leejones.me.uk#contact" target="_blank">website</a>.


##Licence

Copyright (c) 2013 Lee Jones, License none.
