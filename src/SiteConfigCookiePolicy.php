<?php

namespace Novatio\CookiePolicy;

use Exception;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use Colymba\ColorField\ColorField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\SiteConfig\SiteConfig;


class SiteConfigCookiePolicy extends DataExtension
{
    /**
     * @var array
     */
    private static $db = [
        'CookiePolicyIsActive' => 'Boolean',

        // Content options
        'CookiePolicyButtonTitle'        => 'Varchar(255)',
        'CookiePolicyDeclineButtonTitle' => 'Varchar(255)',
        'CookiePolicyDescription'        => 'HTMLText',

        // Styling options
        'CookiePolicyIncludeJquery'            => 'Boolean',
        'CookiePolicyPosition'                 => "Enum('top, bottom', 'bottom')",
        'CookiePolicyBgColor'                  => 'Color',
        'CookiePolicyTextColor'                => 'Color',
        'CookiePolicyBtnColor'                 => 'Color',
        'CookiePolicyBtnTextColor'             => 'Color',
        'CookiePolicyBtnHoverColor'            => 'Color',
        'CookiePolicyBtnHoverTextColor'        => 'Color',
        'CookiePolicyDeclineBtnColor'          => 'Color',
        'CookiePolicyDeclineBtnTextColor'      => 'Color',
        'CookiePolicyDeclineBtnHoverColor'     => 'Color',
        'CookiePolicyDeclineBtnHoverTextColor' => 'Color',
        'CookiePolicyLeftPadding'              => 'Varchar(10)',
        'CookiePolicyRightPadding'             => 'Varchar(10)',
        'CookiePolicyHideAnimation'            => 'Varchar(20)',

        // Optional GTM fields
        'CookiePolicyIncludeGTM'     => 'Boolean',
        'CookiePolicyGTMCode'        => 'Varchar(16)',
        'CookiePolicyGAFallbackCode' => 'Varchar(16)',
    ];

    /**
     * @param FieldList $fields
     *
     * @throws Exception
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab("Root", new Tab('CookiePolicy'));

        $fields->addFieldsToTab('Root.CookiePolicy', [
            CheckboxField::create("CookiePolicyIsActive")
                ->setTitle(_t('CookiePolicy.ISACTIVE', "Is Active")),
            CheckboxField::create("CookiePolicyIncludeJquery")
                ->setTitle(_t('CookiePolicy.INCLUDEJQUER?Y', "Include jQuery Library on load?")),
            CheckboxField::create("CookiePolicyIncludeGTM")
                ->setTitle(_t('CookiePolicy.INCLUDEGTM', "Include Google Tag Manager when agreed?")),
            TextField::create("CookiePolicyGTMCode")
                ->setTitle(_t('CookiePolicy.GTMCODE', "Google Tag Manager Code"))
                ->displayIf('CookiePolicyIncludeGTM')->isChecked()->end(),
            TextField::create("CookiePolicyGAFallbackCode")
                ->setTitle(_t('CookiePolicy.GAFALLBACKCODE', "GA Anonymized IP Fallback"))
                ->setDescription(_t('CookiePolicy.GAFALLBACKDESCR', "Used when visitor has not accepted cookies."))
                ->displayIf('CookiePolicyIncludeGTM')->isChecked()->end(),
            DropdownField::create("CookiePolicyPosition")
                ->setSource(singleton(SiteConfig::class)->dbObject('CookiePolicyPosition')->enumValues())
                ->setTitle(_t('CookiePolicy.POSITION', "Position"))
                ->setDescription('Default: top'),
            HtmlEditorField::create("CookiePolicyDescription")
                ->setTitle(_t('CookiePolicy.DESCRIPTION', "Description"))
                ->setDescription('Default: We use cookies on this website.')
                ->setRows(10),
            ColorField::create("CookiePolicyBgColor")
                ->setTitle(_t('CookiePolicy.BGCOLOR', "Background Color"))
                ->setDescription('Default: #CCC'),
            ColorField::create("CookiePolicyTextColor")
                ->setTitle(_t('CookiePolicy.TEXTCOLOR', "Text Color"))
                ->setDescription('Default: #000'),
            TextField::create("CookiePolicyLeftPadding")
                ->setTitle(_t('CookiePolicy.LEFTPADDING', "Left Padding"))
                ->setDescription('Default: 0'),
            TextField::create("CookiePolicyRightPadding")
                ->setTitle(_t('CookiePolicy.RIGHTPADDING', "Right Padding"))
                ->setDescription('Default: 0'),
            TextField::create("CookiePolicyHideAnimation")
                ->setTitle(_t('CookiePolicy.HIDEANIMATION', "Hide Animation"))
                ->setDescription('Default: fadeOut'),

            // Accept button
            HeaderField::create('CookiePolicyAcceptButton', _t('CookiePolicy.BUTTON', "Accept Button")),
            TextField::create("CookiePolicyButtonTitle")
                ->setTitle(_t('CookiePolicy.BUTTONTITLE', "Accept Button Title"))
                ->setAttribute('placeholder', 'Default: I Agree')
                ->setAttribute('style', 'width: 512px;'),
            LiteralField::create('decline-separator', '<hr style="width: calc(100vw - 512px);border: none;margin: 0;">'),
            ColorField::create("CookiePolicyBtnColor")
                ->setTitle(_t('CookiePolicy.BUTTONCOLOR', "Accept Button Color"))
                ->setAttribute('placeholder', 'Default: #000'),
            ColorField::create("CookiePolicyBtnTextColor")
                ->setTitle(_t('CookiePolicy.BUTTONTEXTCOLOR', "Accept Button Text Color"))
                ->setAttribute('placeholder', 'Default: #FFF'),
            ColorField::create("CookiePolicyBtnHoverColor")
                ->setTitle(_t('CookiePolicy.BUTTONHOVERCOLOR', "Accept Button Hover Color"))
                ->setAttribute('placeholder', 'Default: #AAA'),
            ColorField::create("CookiePolicyBtnHoverTextColor")
                ->setTitle(_t('CookiePolicy.BUTTONHOVERTEXTCOLOR', "Accept Button Hover Text Color"))
                ->setAttribute('placeholder', 'Default: #000'),

            // Decline link/button
            HeaderField::create('CookiePolicyDeclineButton', _t('CookiePolicy.DECLINEBUTTON', "Decline Button")),
            TextField::create("CookiePolicyDeclineButtonTitle")
                ->setTitle(_t('CookiePolicy.DECLINEBUTTONTITLE', "Decline Button Title"))
                ->setAttribute('placeholder', 'Default: I Disagree')
                ->setAttribute('style', 'width: 512px;'),
            LiteralField::create('decline-separator', '<hr style="width: calc(100vw - 512px);border: none;margin: 0;">'),
            ColorField::create("CookiePolicyDeclineBtnColor")
                ->setTitle(_t('CookiePolicy.DECLINEBUTTONCOLOR', "Decline Button Color"))
                ->setAttribute('placeholder', 'Default: #000'),
            ColorField::create("CookiePolicyDeclineBtnTextColor")
                ->setTitle(_t('CookiePolicy.DECLINEBUTTONTEXTCOLOR', "Decline Button Text Color"))
                ->setAttribute('placeholder', 'Default: #FFF'),
            ColorField::create("CookiePolicyDeclineBtnHoverColor")
                ->setTitle(_t('CookiePolicy.DECLINEBUTTONHOVERCOLOR', "Decline Button Hover Color"))
                ->setAttribute('placeholder', 'Default: -'),
            ColorField::create("CookiePolicyDeclineBtnHoverTextColor")
                ->setTitle(_t('CookiePolicy.DECLINEBUTTONHOVERTEXTCOLOR', "Decline Button Hover Text Color"))
                ->setAttribute('placeholder', 'Default: -'),
        ]);
    }
}
