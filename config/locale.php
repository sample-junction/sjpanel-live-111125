<?php

return [

    'default_country' => 'US',
    'default_language' => 'EN',

    /*
     * Whether or not to show the language picker, or just default to the default
     * locale specified in the app config file
     *
     * @var bool
     */
    'status' => true,

    /*
     * Available languages
     *
     * Add your language code to this array.
     * The code must have the same name as the language folder.
     * Be sure to add the new language in an alphabetical order.
     *
     * The language picker will not be available if there is only one language option
     * Commenting out languages will make them unavailable to the user
     *
     * @var array
     */
    'languages' => [
        /*
         * Key is the Laravel locale code
         * Index 0 of sub-array is the Carbon locale code
         * Index 1 of sub-array is the PHP locale code for setlocale()
         * Index 2 of sub-array is whether or not to use RTL (right-to-left) html direction for this language
         */

        /*United States*/

        'en_US'    => ['en_US', 'en_US', false],//English US
        'es_US'    => ['es_US', 'es_US', false],//Spanish US

        /*United Kingdom*/
        'en_UK'    => ['en_UK', 'en_UK', false],//English UK

        /*Spain*/
        'es_ES'    => ['es_US', 'es_US', false],//Spanish Spain
        'en_ES'    => ['en_ES', 'en_ES', false],//English Spain

        /*Germany*/
        'en_DE'    => ['en_DE', 'en_DE', false],//English Germany
        'de_DE'    => ['de_DE', 'de_DE', false],//German Germany

        /*Italy*/
        'en_IT'    => ['en_IT', 'en_IT', false],//English Italy
        'it_IT'    => ['it_IT', 'it_IT', false],//Italian Italy

        /*Canada*/
        'en_CA'    => ['en_CA', 'en_CA', false],//English Canada
        'fr_CA'    => ['fr_CA', 'fr_CA', false],//French Canada

        /*France*/
        'en_FR'    => ['en_FR', 'en_FR', false],//English France
        'fr_FR'    => ['fr_FR', 'fr_FR', false],//French France

        /*India*/
        'en_IN'    => ['en_IN', 'en_IN', false],//English India
        'hi_IN'    => ['hi_IN', 'hi_IN', false],//Hindi India

        /*Australia*/
        'en_AU'    => ['en_AU', 'en_AU', false],//English Australia

        /*China*/
        'en_CN'    => ['en_CN', 'en_CN', false],//English China
        'zh_CN'    => ['zh_CN', 'zh_CN', false],//English China
    ],
];
