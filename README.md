# SilverStripe GDPR Cookie Policy Module
*Fully configurable SilverStripe plugin to notify users about (GDRP) cookie policies.*


## Requirements
* SilverStripe 3


## Installation instructions

* Install via composer: ```composer require novatio/gdpr-cookiepolicy```.
* Visit ```yoursite.com```/dev/build?flush=1 to rebuild the database.
* Visit ```yoursite.com```/admin/settings/, navigate to the ```Cookie Policy```-tab and customize the look and feel of 
the Cookie Policy to your liking.


## Usage instructions

You can choose to let the module do all the work for you (by placing all [tracker]scripts that you need in Google Tag
Manager) and conditionally loading GTM ***and / or*** use available functions to load or bypass scripts in models, controllers
and/or templates.

To conditionally load scripts in templates:
```silverstripe
    <% if $CookiePolicyAccepted %>
    	<%-- some templating. --%>
    <% end_if %>
```

To conditionally load scripts in code:
```php
    if (CookiePolicy::accepted()) {
        // some code.
    }
```

## Known Issues

[GitHub Issue Tracker](https://github.com/novatio/silverstripe-gdpr-cookie-policy/issues)


## Thanks

This module is based on [fractaslabs/silverstripe-cookie-policy-notification](https://github.com/fractaslabs/silverstripe-cookie-policy-notification)
and adapted to be more customisable and to be more compliant with the strict new [GDRP](https://en.wikipedia.org/wiki/General_Data_Protection_Regulation)
rules.
Thanks to Milan Jelicanin & Petar Simic.

Thanks to <a href="https://github.com/carhartl/jquery-cookie" target="_blank">carhartl</a> for the jQuery Cookie plugin.

Thanks to <a href="https://github.com/prolificjones82/uk_cookie_policy_notice" target="_blank">prolificjones82</a> for 
the jQuery UK Cookie Policy Notice: A simple plugin to notify users you adhere to the UK's cookie policies.


## Licence
See [licence](https://github.com/novatio/silverstripe-gdpr-cookie-policy/blob/master/LICENSE)
