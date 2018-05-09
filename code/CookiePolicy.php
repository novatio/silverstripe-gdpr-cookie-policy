<?php

class CookiePolicy extends Extension implements TemplateGlobalProvider
{
    /**
     * @var bool
     */
    protected $includeCookiePolicyNotification = true;

    /**
     * @var null
     */
    protected $siteConfig = null;

    /**
     * On Before init, get & config data.
     */
    public function onBeforeInit()
    {
        $this->siteConfig = SiteConfig::current_site_config();
        $this->includeCookiePolicyNotification = $this->siteConfig->CookiePolicyIsActive;
    }

    /**
     * On After init, based on config, include CookiePolicy items.
     */
    public function onAfterInit()
    {
        if ($this->includeCookiePolicyNotification) {
            $cookiepolicyjssnippet = new ArrayData([
                'CookiePolicyButtonTitle'        => $this->siteConfig->CookiePolicyButtonTitle,
                'CookiePolicyDeclineButtonTitle' => $this->siteConfig->CookiePolicyDeclineButtonTitle,
                'CookiePolicyDescription'        => $this->siteConfig->CookiePolicyDescription,
                'CookiePolicyPosition'           => $this->siteConfig->CookiePolicyPosition,
            ]);

            if ($this->siteConfig->CookiePolicyIncludeJquery) {
                Requirements::javascript(THIRDPARTY_DIR.'/jquery/jquery.js');
            }

            // Cannot use javascriptTemplate(), as RAW2JS breaks json data...
            Requirements::customScript($cookiepolicyjssnippet->renderWith('CookiePolicyJSSnippet', [
                'config' => $this->getSnippetConfigudationValues()
            ]));

            // inject GTM when enabled.
            $this->includeGTM();
        }
    }

    /**
     * @return bool
     */
    public static function accepted()
    {
        // must check for string values, using filter_var.
        return filter_var(Cookie::get('cookie_policy'), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return array
     */
    public static function get_template_global_variables()
    {
        return [
            'CookiePolicyAccepted' => 'accepted',
        ];
    }

    /**
     * @return string
     */
    protected function getSnippetConfigudationValues()
    {
        $attributes = [
            'text'                     => 'CookiePolicyDescription',
            'position'                 => 'CookiePolicyPosition',
            'leftPadding'              => 'CookiePolicyLeftPadding',
            'rightPadding'             => 'CookiePolicyRightPadding',
            'hideAnimation'            => 'CookiePolicyHideAnimation',
            'btnText'                  => 'CookiePolicyButtonTitle',
            'declineBtnText'           => 'CookiePolicyDeclineButtonTitle',
        ];

        $colors = [
            'bgColor'                  => 'CookiePolicyBgColor',
            'textColor'                => 'CookiePolicyTextColor',
            'btnColor'                 => 'CookiePolicyBtnColor',
            'btnTextColor'             => 'CookiePolicyBtnTextColor',
            'btnHoverColor'            => 'CookiePolicyBtnHoverColor',
            'btnHoverTextColor'        => 'CookiePolicyBtnHoverTextColor',
            'declineBtnColor'          => 'CookiePolicyDeclineBtnColor',
            'declineBtnTextColor'      => 'CookiePolicyDeclineBtnTextColor',
            'declineBtnHoverColor'     => 'CookiePolicyDeclineBtnHoverColor',
            'declineBtnHoverTextColor' => 'CookiePolicyDeclineBtnHoverTextColor',
        ];

        $config = [];

        // add regular attributes
        $this->pushAttributesToConfig($config, $attributes);

        // add colors (with # in front)
        $this->pushAttributesToConfig($config, $colors, '#');


        //var_dump(json_encode($config, JSON_UNESCAPED_SLASHES));
        //die();
        //return Strin
        //    $textObj = new Text('Test');
			//$textObj->setValue(json_encode($config));
        //return $textObj;

        return json_encode($config);
    }

    /**
     * GTM inject function (conditionally)
     */
    protected function includeGTM()
    {
        if ($this->siteConfig->CookiePolicyIncludeGTM && $this->siteConfig->CookiePolicyGTMCode) {
            // Inject GTM script
            Requirements::insertHeadTags("
                <!-- Google Tag Manager -->
                <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','".$this->siteConfig->CookiePolicyGTMCode."');</script>
                <!-- End Google Tag Manager -->
            ", 'GTMScript');

            // Inject GTM no-script fallback
            // Not using customScript, it will wrap in in script tags.
            // We are simply assuming HTML5 is used nowaday so <noscript> is allowed in the head tag as well.
            Requirements::insertHeadTags('
                <!-- Google Tag Manager (noscript) -->
                <noscript><iframe src="https://www.googletagmanager.com/ns.html?id='.$this->siteConfig->CookiePolicyGTMCode.'"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                <!-- End Google Tag Manager (noscript) -->
            ', "GTMNoScript");
        }
    }

    /**
     * @param        $config
     * @param        $attributes
     * @param string $pre
     * @param string $post
     */
    protected function pushAttributesToConfig(&$config, $attributes, $pre = '', $post = '')
    {
        // add colors (with # in front)
        foreach ($attributes as $key => $value)
        {
            if ($this->siteConfig->$value) {
                $config[$key] = "{$pre}{$this->siteConfig->$value}{$post}";
            }
        }
    }

}