<?php
namespace Elementor;

class Widget_MS_Social_Icons extends Widget_Base {
    
    private static $share_socials = [
        'twitter' => 'Twitter',
        'facebook' => 'Facebook',
        'linkedin' => 'LinkedIn',
        'email' => 'Email',
        'whatsapp' => 'WhatsApp',
        'telegram' => 'Telegram',
        'viber' => 'Viber',
        'pinterest' => 'Pinterest',
        'tumblr' => 'Tumblr',
        'hackernews' => 'Hackernews',
        'reddit' => 'Reddit',
        'vk' => 'VK',
        'buffer' => 'Buffer',
        'xing' => 'Xing',
        'line' => 'Line',
        'digg' => 'Digg',
        'stumbleupon' => 'Stumbleupon',
        'flipboard' => 'Flipboard',
        'weibo' => 'Weibo',
        'renren' => 'Renren',
        'myspace' => 'MySpace',
        'blogger' => 'Blogger',
        'okru' => 'Ok',
        'skype' => 'Skype',
        'trello' => 'Trello',
    ];

    private static $default_socials = [
        'facebook' => 'facebook',
        'twitter' => 'twitter',
        'x-twitter' => 'twitter, x',
        'instagram' => 'instagram',
        'tiktok' => 'tiktok',
        'linkedin' => 'linkedin',
        'github' => 'github',
        'discord' => 'discord',
        'youtube' => 'youtube',
        'wordpress' => 'wordpress',
        'slack' => 'slack',
        'figma' => 'figma',
        'apple' => 'apple',
        'google' => 'google',
        'stripe' => 'stripe',
        'algolia' => 'algolia',
        'docker' => 'docker',
        'windows' => 'windows',
        'paypal' => 'paypal',
        'stack-overflow' => 'stack-overflow',
        'kickstarter' => 'kickstarter',
        'dribbble' => 'dribbble',
        'dropbox' => 'dropbox',
        'squarespace' => 'squarespace',
        'android' => 'android',
        'shopify' => 'shopify',
        'medium' => 'medium',
        'codepen' => 'codepen',
        'cloudflare' => 'cloudflare',
        'airbnb' => 'airbnb',
        'vimeo' => 'vimeo',
        'whatsapp' => 'whatsapp',
        'intercom' => 'intercom',
        'usps' => 'usps',
        'wix' => 'wix',
        'line' => 'line',
        'behance' => 'behance',
        'openid' => 'openid',
        'product-hunt' => 'product-hunt',
        'internet-explorer' => 'internet-explorer',
        'pagelines' => 'pagelines',
        'teamspeak' => 'teamspeak',
        'html5' => 'html5',
        'telegram' => 'telegram',
        'pinterest' => 'pinterest',
        'dashcube' => 'dashcube',
        'ideal' => 'ideal',
        'salesforce' => 'salesforce',
        'readme' => 'readme',
        'free-code-camp' => 'free-code-camp',
        'soundcloud' => 'soundcloud',
        'square-twitter' => 'square-twitter',
        'accessible-icon' => 'accessible-icon',
        'cc-visa' => 'cc-visa',
        'goodreads-g' => 'goodreads-g',
        'google-play' => 'google-play',
        'react' => 'react',
        'wikipedia-w' => 'wikipedia-w',
        'square-js' => 'square-js',
        'java' => 'java',
        'square-pinterest' => 'square-pinterest',
        'python' => 'python',
        'skype' => 'skype',
        'linux' => 'linux',
        'node' => 'node',
        'rebel' => 'rebel',
        'etsy' => 'etsy',
        'discourse' => 'discourse',
        'amazon' => 'amazon',
        'glide-g' => 'glide-g',
        'gitlab' => 'gitlab',
        'spotify' => 'spotify',
        'think-peaks' => 'think-peaks',
        'microsoft' => 'microsoft',
        'elementor' => 'elementor',
        'pied-piper' => 'pied-piper',
        'square-youtube' => 'square-youtube',
        'cc-mastercard' => 'cc-mastercard',
        'facebook-messenger' => 'facebook-messenger',
        'atlassian' => 'atlassian',
        'playstation' => 'playstation',
        'fly' => 'fly',
        'meetup' => 'meetup',
        'twitch' => 'twitch',
        'waze' => 'waze',
        'zhihu' => 'zhihu',
        'yoast' => 'yoast',
        'yelp' => 'yelp',
        'yarn' => 'yarn',
        'yandex-international' => 'yandex-international',
        'yandex' => 'yandex',
        'yammer' => 'yammer',
        'yahoo' => 'yahoo',
        'y-combinator' => 'y-combinator',
        'xing' => 'xing',
        'xbox' => 'xbox',
        'wpressr' => 'wpressr',
        'wpforms' => 'wpforms',
        'wpexplorer' => 'wpexplorer',
        'wpbeginner' => 'wpbeginner',
        'wordpress-simple' => 'wordpress-simple',
        'wolf-pack-battalion' => 'wolf-pack-battalion',
        'wodu' => 'wodu',
        'wizards-of-the-coast' => 'wizards-of-the-coast',
        'wirsindhandwerk' => 'wirsindhandwerk',
        'whmcs' => 'whmcs',
        'weixin' => 'weixin',
        'weibo' => 'weibo',
        'weebly' => 'weebly',
        'watchman-monitoring' => 'watchman-monitoring',
        'vuejs' => 'vuejs',
        'vnv' => 'vnv',
        'vk' => 'vk',
        'vine' => 'vine',
        'vimeo-v' => 'vimeo-v',
        'viber' => 'viber',
        'viadeo' => 'viadeo',
        'viacoin' => 'viacoin',
        'vaadin' => 'vaadin',
        'ussunnah' => 'ussunnah',
        'usb' => 'usb',
        'ups' => 'ups',
        'untappd' => 'untappd',
        'unsplash' => 'unsplash',
        'unity' => 'unity',
        'uniregistry' => 'uniregistry',
        'uncharted' => 'uncharted',
        'umbraco' => 'umbraco',
        'uikit' => 'uikit',
        'ubuntu' => 'ubuntu',
        'uber' => 'uber',
        'typo3' => 'typo3',
        'tumblr' => 'tumblr',
        'trello' => 'trello',
        'trade-federation' => 'trade-federation',
        'themeisle' => 'themeisle',
        'themeco' => 'themeco',
        'the-red-yeti' => 'the-red-yeti',
        'tencent-weibo' => 'tencent-weibo',
        'symfony' => 'symfony',
        'swift' => 'swift',
        'suse' => 'suse',
        'supple' => 'supple',
        'superpowers' => 'superpowers',
        'stumbleupon-circle' => 'stumbleupon-circle',
        'stumbleupon' => 'stumbleupon',
        'studiovinari' => 'studiovinari',
        'stubber' => 'stubber',
        'stripe-s' => 'stripe-s',
        'strava' => 'strava',
        'sticker-mule' => 'sticker-mule',
        'steam-symbol' => 'steam-symbol',
        'steam' => 'steam',
        'staylinked' => 'staylinked',
        'stackpath' => 'stackpath',
        'stack-exchange' => 'stack-exchange',
        'square-xing' => 'square-xing',
        'square-whatsapp' => 'square-whatsapp',
        'square-vimeo' => 'square-vimeo',
        'square-viadeo' => 'square-viadeo',
        'square-tumblr' => 'square-tumblr',
        'square-steam' => 'square-steam',
        'square-snapchat' => 'square-snapchat',
        'square-reddit' => 'square-reddit',
        'square-pied-piper' => 'square-pied-piper',
        'square-odnoklassniki' => 'square-odnoklassniki',
        'square-lastfm' => 'square-lastfm',
        'square-instagram' => 'square-instagram',
        'square-hacker-news' => 'square-hacker-news',
        'square-google-plus' => 'square-google-plus',
        'square-gitlab' => 'square-gitlab',
        'square-github' => 'square-github',
        'square-git' => 'square-git',
        'square-font-awesome-stroke' => 'square-font-awesome-stroke',
        'square-font-awesome' => 'square-font-awesome',
        'square-facebook' => 'square-facebook',
        'square-dribbble' => 'square-dribbble',
        'square-behance' => 'square-behance',
        'speaker-deck' => 'speaker-deck',
        'speakap' => 'speakap',
        'space-awesome' => 'space-awesome',
        'sourcetree' => 'sourcetree',
        'snapchat' => 'snapchat',
        'slideshare' => 'slideshare',
        'skyatlas' => 'skyatlas',
        'sketch' => 'sketch',
        'sitrox' => 'sitrox',
        'sith' => 'sith',
        'sistrix' => 'sistrix',
        'simplybuilt' => 'simplybuilt',
        'shopware' => 'shopware',
        'shirtsinbulk' => 'shirtsinbulk',
        'servicestack' => 'servicestack',
        'sellsy' => 'sellsy',
        'sellcast' => 'sellcast',
        'searchengin' => 'searchengin',
        'scribd' => 'scribd',
        'screenpal' => 'screenpal',
        'schlix' => 'schlix',
        'sass' => 'sass',
        'safari' => 'safari',
        'rust' => 'rust',
        'rockrms' => 'rockrms',
        'rocketchat' => 'rocketchat',
        'rev' => 'rev',
        'resolving' => 'resolving',
        'researchgate' => 'researchgate',
        'replyd' => 'replyd',
        'renren' => 'renren',
        'redhat' => 'redhat',
        'reddit-alien' => 'reddit-alien',
        'reddit' => 'reddit',
        'red-river' => 'red-river',
        'reacteurope' => 'reacteurope',
        'ravelry' => 'ravelry',
        'raspberry-pi' => 'raspberry-pi',
        'r-project' => 'r-project',
        'quora' => 'quora',
        'quinscape' => 'quinscape',
        'qq' => 'qq',
        'pushed' => 'pushed',
        'pix' => 'pix',
        'pinterest-p' => 'pinterest-p',
        'pied-piper-pp' => 'pied-piper-pp',
        'pied-piper-hat' => 'pied-piper-hat',
        'pied-piper-alt' => 'pied-piper-alt',
        'php' => 'php',
        'phoenix-squadron' => 'phoenix-squadron',
        'phoenix-framework' => 'phoenix-framework',
        'phabricator' => 'phabricator',
        'periscope' => 'periscope',
        'perbyte' => 'perbyte',
        'patreon' => 'patreon',
        'palfed' => 'palfed',
        'page4' => 'page4',
        'padlet' => 'padlet',
        'osi' => 'osi',
        'orcid' => 'orcid',
        'optin-monster' => 'optin-monster',
        'opera' => 'opera',
        'opencart' => 'opencart',
        'old-republic' => 'old-republic',
        'odysee' => 'odysee',
        'odnoklassniki' => 'odnoklassniki',
        'octopus-deploy' => 'octopus-deploy',
        'nutritionix' => 'nutritionix',
        'ns8' => 'ns8',
        'npm' => 'npm',
        'node-js' => 'node-js',
        'nimblr' => 'nimblr',
        'nfc-symbol' => 'nfc-symbol',
        'nfc-directional' => 'nfc-directional',
        'neos' => 'neos',
        'napster' => 'napster',
        'monero' => 'monero',
        'modx' => 'modx',
        'mizuni' => 'mizuni',
        'mixer' => 'mixer',
        'mixcloud' => 'mixcloud',
        'mix' => 'mix',
        'microblog' => 'microblog',
        'meta' => 'meta',
        'mendeley' => 'mendeley',
        'megaport' => 'megaport',
        'medrt' => 'medrt',
        'medapps' => 'medapps',
        'mdb' => 'mdb',
        'maxcdn' => 'maxcdn',
        'mastodon' => 'mastodon',
        'markdown' => 'markdown',
        'mandalorian' => 'mandalorian',
        'mailchimp' => 'mailchimp',
        'magento' => 'magento',
        'lyft' => 'lyft',
        'linode' => 'linode',
        'linkedin-in' => 'linkedin-in',
        'less' => 'less',
        'leanpub' => 'leanpub',
        'lastfm' => 'lastfm',
        'laravel' => 'laravel',
        'korvue' => 'korvue',
        'kickstarter-k' => 'kickstarter-k',
        'keycdn' => 'keycdn',
        'keybase' => 'keybase',
        'kaggle' => 'kaggle',
        'jsfiddle' => 'jsfiddle',
        'js' => 'js',
        'joomla' => 'joomla',
        'joget' => 'joget',
        'jira' => 'jira',
        'jenkins' => 'jenkins',
        'jedi-order' => 'jedi-order',
        'itunes-note' => 'itunes-note',
        'itunes' => 'itunes',
        'itch-io' => 'itch-io',
        'ioxhost' => 'ioxhost',
        'invision' => 'invision',
        'instalod' => 'instalod',
        'imdb' => 'imdb',
        'hubspot' => 'hubspot',
        'houzz' => 'houzz',
        'hotjar' => 'hotjar',
        'hornbill' => 'hornbill',
        'hooli' => 'hooli',
        'hive' => 'hive',
        'hire-a-helper' => 'hire-a-helper',
        'hips' => 'hips',
        'hashnode' => 'hashnode',
        'hackerrank' => 'hackerrank',
        'hacker-news' => 'hacker-news',
        'gulp' => 'gulp',
        'guilded' => 'guilded',
        'grunt' => 'grunt',
        'gripfire' => 'gripfire',
        'grav' => 'grav',
        'gratipay' => 'gratipay',
        'google-wallet' => 'google-wallet',
        'google-plus-g' => 'google-plus-g',
        'google-plus' => 'google-plus',
        'google-pay' => 'google-pay',
        'google-drive' => 'google-drive',
        'goodreads' => 'goodreads',
        'golang' => 'golang',
        'gofore' => 'gofore',
        'glide' => 'glide',
        'gitter' => 'gitter',
        'gitkraken' => 'gitkraken',
        'github-alt' => 'github-alt',
        'git-alt' => 'git-alt',
        'git' => 'git',
        'gg-circle' => 'gg-circle',
        'gg' => 'gg',
        'get-pocket' => 'get-pocket',
        'galactic-senate' => 'galactic-senate',
        'galactic-republic' => 'galactic-republic',
        'fulcrum' => 'fulcrum',
        'freebsd' => 'freebsd',
        'foursquare' => 'foursquare',
        'forumbee' => 'forumbee',
        'fort-awesome-alt' => 'fort-awesome-alt',
        'fort-awesome' => 'fort-awesome',
        'fonticons-fi' => 'fonticons-fi',
        'fonticons' => 'fonticons',
        'font-awesome' => 'font-awesome',
        'flipboard' => 'flipboard',
        'flickr' => 'flickr',
        'firstdraft' => 'firstdraft',
        'first-order-alt' => 'first-order-alt',
        'first-order' => 'first-order',
        'firefox-browser' => 'firefox-browser',
        'firefox' => 'firefox',
        'fedora' => 'fedora',
        'fedex' => 'fedex',
        'fantasy-flight-games' => 'fantasy-flight-games',
        'facebook-f' => 'facebook-f',
        'expeditedssl' => 'expeditedssl',
        'evernote' => 'evernote',
        'ethereum' => 'ethereum',
        'erlang' => 'erlang',
        'envira' => 'envira',
        'empire' => 'empire',
        'sourcetree' => 'sourcetree',
        'snapchat' => 'snapchat',
        'slideshare' => 'slideshare',
        'skyatlas' => 'skyatlas',
        'sketch' => 'sketch',
        'sitrox' => 'sitrox',
        'sith' => 'sith',
        'sistrix' => 'sistrix',
        'simplybuilt' => 'simplybuilt',
        'shopware' => 'shopware',
        'shirtsinbulk' => 'shirtsinbulk',
        'servicestack' => 'servicestack',
        'sellsy' => 'sellsy',
        'sellcast' => 'sellcast',
        'searchengin' => 'searchengin',
        'scribd' => 'scribd',
        'screenpal' => 'screenpal',
        'schlix' => 'schlix',
        'sass' => 'sass',
        'safari' => 'safari',
        'rust' => 'rust',
        'rockrms' => 'rockrms',
        'rocketchat' => 'rocketchat',
        'rev' => 'rev',
        'resolving' => 'resolving',
        'researchgate' => 'researchgate',
        'replyd' => 'replyd',
        'renren' => 'renren',
        'redhat' => 'redhat',
        'reddit-alien' => 'reddit-alien',
        'reddit' => 'reddit',
        'red-river' => 'red-river',
        'reacteurope' => 'reacteurope',
        'ravelry' => 'ravelry',
        'raspberry-pi' => 'raspberry-pi',
        'r-project' => 'r-project',
        'quora' => 'quora',
        'quinscape' => 'quinscape',
        'qq' => 'qq',
        'pushed' => 'pushed',
        'pix' => 'pix',
        'pinterest-p' => 'pinterest-p',
        'pied-piper-pp' => 'pied-piper-pp',
        'pied-piper-hat' => 'pied-piper-hat',
        'pied-piper-alt' => 'pied-piper-alt',
        'php' => 'php',
        'phoenix-squadron' => 'phoenix-squadron',
        'phoenix-framework' => 'phoenix-framework',
        'phabricator' => 'phabricator',
        'periscope' => 'periscope',
        'perbyte' => 'perbyte',
        'patreon' => 'patreon',
        'palfed' => 'palfed',
        'page4' => 'page4',
        'padlet' => 'padlet',
        'osi' => 'osi',
        'orcid' => 'orcid',
        'optin-monster' => 'optin-monster',
        'opera' => 'opera',
        'opencart' => 'opencart',
        'old-republic' => 'old-republic',
        'odysee' => 'odysee',
        'odnoklassniki' => 'odnoklassniki',
        'octopus-deploy' => 'octopus-deploy',
        'nutritionix' => 'nutritionix',
        'ns8' => 'ns8',
        'npm' => 'npm',
        'node-js' => 'node-js',
        'nimblr' => 'nimblr',
        'nfc-symbol' => 'nfc-symbol',
        'nfc-directional' => 'nfc-directional',
        'neos' => 'neos',
        'napster' => 'napster',
        'monero' => 'monero',
        'modx' => 'modx',
        'mizuni' => 'mizuni',
        'mixer' => 'mixer',
        'mixcloud' => 'mixcloud',
        'mix' => 'mix',
        'microblog' => 'microblog',
        'meta' => 'meta',
        'mendeley' => 'mendeley',
        'megaport' => 'megaport',
        'medrt' => 'medrt',
        'medapps' => 'medapps',
        'mdb' => 'mdb',
        'maxcdn' => 'maxcdn',
        'mastodon' => 'mastodon',
        'markdown' => 'markdown',
        'mandalorian' => 'mandalorian',
        'mailchimp' => 'mailchimp',
        'magento' => 'magento',
        'lyft' => 'lyft',
        'linode' => 'linode',
        'linkedin-in' => 'linkedin-in',
        'less' => 'less',
        'leanpub' => 'leanpub',
        'lastfm' => 'lastfm',
        'laravel' => 'laravel',
        'korvue' => 'korvue',
        'kickstarter-k' => 'kickstarter-k',
        'keycdn' => 'keycdn',
        'keybase' => 'keybase',
        'kaggle' => 'kaggle',
        'jsfiddle' => 'jsfiddle',
        'js' => 'js',
        'joomla' => 'joomla',
        'joget' => 'joget',
        'jira' => 'jira',
        'jenkins' => 'jenkins',
        'jedi-order' => 'jedi-order',
        'itunes-note' => 'itunes-note',
        'itunes' => 'itunes',
        'itch-io' => 'itch-io',
        'ioxhost' => 'ioxhost',
        'invision' => 'invision',
        'instalod' => 'instalod',
        'imdb' => 'imdb',
        'hubspot' => 'hubspot',
        'houzz' => 'houzz',
        'hotjar' => 'hotjar',
        'hornbill' => 'hornbill',
        'hooli' => 'hooli',
        'hive' => 'hive',
        'hire-a-helper' => 'hire-a-helper',
        'hips' => 'hips',
        'hashnode' => 'hashnode',
        'hackerrank' => 'hackerrank',
        'hacker-news' => 'hacker-news',
        'gulp' => 'gulp',
        'guilded' => 'guilded',
        'grunt' => 'grunt',
        'gripfire' => 'gripfire',
        'grav' => 'grav',
        'gratipay' => 'gratipay',
        'google-wallet' => 'google-wallet',
        'google-plus-g' => 'google-plus-g',
        'google-plus' => 'google-plus',
        'google-pay' => 'google-pay',
        'google-drive' => 'google-drive',
        'goodreads' => 'goodreads',
        'golang' => 'golang',
        'gofore' => 'gofore',
        'glide' => 'glide',
        'gitter' => 'gitter',
        'gitkraken' => 'gitkraken',
        'github-alt' => 'github-alt',
        'git-alt' => 'git-alt',
        'git' => 'git',
        'gg-circle' => 'gg-circle',
        'gg' => 'gg',
        'get-pocket' => 'get-pocket',
        'galactic-senate' => 'galactic-senate',
        'galactic-republic' => 'galactic-republic',
        'fulcrum' => 'fulcrum',
        'freebsd' => 'freebsd',
        'foursquare' => 'foursquare',
        'forumbee' => 'forumbee',
        'fort-awesome-alt' => 'fort-awesome-alt',
        'fort-awesome' => 'fort-awesome',
        'fonticons-fi' => 'fonticons-fi',
        'fonticons' => 'fonticons',
        'font-awesome' => 'font-awesome',
        'flipboard' => 'flipboard',
        'flickr' => 'flickr',
        'firstdraft' => 'firstdraft',
        'first-order-alt' => 'first-order-alt',
        'first-order' => 'first-order',
        'firefox-browser' => 'firefox-browser',
        'firefox' => 'firefox',
        'fedora' => 'fedora',
        'fedex' => 'fedex',
        'fantasy-flight-games' => 'fantasy-flight-games',
        'facebook-f' => 'facebook-f',
        'expeditedssl' => 'expeditedssl',
        'evernote' => 'evernote',
        'ethereum' => 'ethereum',
        'erlang' => 'erlang',
        'envira' => 'envira',
        'empire' => 'empire',
        'ember' => 'ember',
        'ello' => 'ello',
        'edge-legacy' => 'edge-legacy',
        'edge' => 'edge',
        'ebay' => 'ebay',
        'earlybirds' => 'earlybirds',
        'dyalog' => 'dyalog',
        'drupal' => 'drupal',
        'draft2digital' => 'draft2digital',
        'dochub' => 'dochub',
        'digital-ocean' => 'digital-ocean',
        'digg' => 'digg',
        'diaspora' => 'diaspora',
        'dhl' => 'dhl',
        'deviantart' => 'deviantart',
        'dev' => 'dev',
        'deskpro' => 'deskpro',
        'deploydog' => 'deploydog',
        'delicious' => 'delicious',
        'deezer' => 'deezer',
        'dailymotion' => 'dailymotion',
        'd-and-d-beyond' => 'd-and-d-beyond',
        'd-and-d' => 'd-and-d',
        'cuttlefish' => 'cuttlefish',
        'css3-alt' => 'css3-alt',
        'css3' => 'css3',
        'critical-role' => 'critical-role',
        'creative-commons-zero' => 'creative-commons-zero',
        'creative-commons-share' => 'creative-commons-share',
        'creative-commons-sampling-plus' => 'creative-commons-sampling-plus',
        'creative-commons-sampling' => 'creative-commons-sampling',
        'creative-commons-sa' => 'creative-commons-sa',
        'creative-commons-remix' => 'creative-commons-remix',
        'creative-commons-pd-alt' => 'creative-commons-pd-alt',
        'creative-commons-pd' => 'creative-commons-pd',
        'creative-commons-nd' => 'creative-commons-nd',
        'creative-commons-nc-jp' => 'creative-commons-nc-jp',
        'creative-commons-nc-eu' => 'creative-commons-nc-eu',
        'creative-commons-nc' => 'creative-commons-nc',
        'creative-commons-by' => 'creative-commons-by',
        'creative-commons' => 'creative-commons',
        'cpanel' => 'cpanel',
        'cotton-bureau' => 'cotton-bureau',
        'contao' => 'contao',
        'connectdevelop' => 'connectdevelop',
        'confluence' => 'confluence',
        'codiepie' => 'codiepie',
        'cmplid' => 'cmplid',
        'cloudversify' => 'cloudversify',
        'cloudsmith' => 'cloudsmith',
        'cloudscale' => 'cloudscale',
        'chromecast' => 'chromecast',
        'chrome' => 'chrome',
        'centos' => 'centos',
        'centercode' => 'centercode',
        'cc-stripe' => 'cc-stripe',
        'cc-paypal' => 'cc-paypal',
        'cc-jcb' => 'cc-jcb',
        'cc-discover' => 'cc-discover',
        'cc-diners-club' => 'cc-diners-club',
        'cc-apple-pay' => 'cc-apple-pay',
        'cc-amex' => 'cc-amex',
        'cc-amazon-pay' => 'cc-amazon-pay',
        'canadian-maple-leaf' => 'canadian-maple-leaf',
        'buysellads' => 'buysellads',
        'buy-n-large' => 'buy-n-large',
        'buromobelexperte' => 'buromobelexperte',
        'buffer' => 'buffer',
        'btc' => 'btc',
        'bots' => 'bots',
        'bootstrap' => 'bootstrap',
        'bluetooth-b' => 'bluetooth-b',
        'bluetooth' => 'bluetooth',
        'blogger-b' => 'blogger-b',
        'blogger' => 'blogger',
        'blackberry' => 'blackberry',
        'black-tie' => 'black-tie',
        'bity' => 'bity',
        'bitcoin' => 'bitcoin',
        'bitbucket' => 'bitbucket',
        'bimobject' => 'bimobject',
        'bilibili' => 'bilibili',
        'battle-net' => 'battle-net',
        'bandcamp' => 'bandcamp',
        'aws' => 'aws',
        'aviato' => 'aviato',
        'avianex' => 'avianex',
        'autoprefixer' => 'autoprefixer',
        'audible' => 'audible',
        'asymmetrik' => 'asymmetrik',
        'artstation' => 'artstation',
        'apple-pay' => 'apple-pay',
        'apper' => 'apper',
        'app-store-ios' => 'app-store-ios',
        'app-store' => 'app-store',
        'angular' => 'angular',
        'angrycreative' => 'angrycreative',
        'angellist' => 'angellist',
        'amilia' => 'amilia',
        'amazon-pay' => 'amazon-pay',
        'alipay' => 'alipay',
        'affiliatetheme' => 'affiliatetheme',
        'adversal' => 'adversal',
        'adn' => 'adn',
        'accusoft' => 'accusoft',
        '500px' => '500px',
        '42-group' => '42-group',
    ];

    public function get_name() {
        return 'ms-social-icons';
    }
    
    public function get_title() {
        return esc_html__( 'Social Icons', 'madsparrow' );
    }
    
    public function get_icon() {
        return 'eicon-social-icons ms-badge';
    }
    
    public function get_categories() {
        return [ 'ms-elements' ];
    }
    
    public function get_keywords() {
        return [ 'social', 'icon', 'link' ];
    }

    protected function register_controls() {

        $first_level = 0;

        $this->start_controls_section(
            'content_section', [
                'label' => __( 'Social Icons', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        asort( self::$share_socials );
        asort( self::$default_socials );

        $repeater = new Repeater();

        $repeater->add_control(
            'icons_socials', [
                'label' => esc_html__( 'Social Network', 'madsparrow' ),
                'type' => Controls_Manager::SELECT2,
                'options' => self::$default_socials,
            ]
        );

        $repeater->add_control(
            'link', [
                'label' => esc_html__( 'Link', 'madsparrow' ),
                'type' => Controls_Manager::URL,
                'placeholder' => 'https://your-link.com',
            ]
        );

        $this->add_control(
            'socials', [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'icons_socials' => 'facebook',
                        'link' => [ 'url' => '#' ],
                    ],
                    [
                        'icons_socials' => 'instagram',
                        'link' => [ 'url' => '#' ],
                    ],
                    [
                        'icons_socials' => 'pinterest',
                        'link' => [ 'url' => '#' ],
                    ],
                ],
                'title_field' => '{{icons_socials}}',
            ]
        );

        $this->end_controls_section();

        // TAB CONTENT
        $this->start_controls_section(
            'section_' . $first_level++, [
                'label' => esc_html__( 'Social Icons', 'madsparrow' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'soc_align', [
                'label' => __( 'Alignment', 'madsparrow' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __( 'Left', 'madsparrow' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'madsparrow' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => __( 'Right', 'madsparrow' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .ms-s-w' => 'justify-content: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'socials_style', [
                'label' => __( 'Style', 'plugin-name' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    's-icon' => __( 'Icon', 'madsparrow' ),
                    's-text' => __( 'Text', 'madsparrow' ),
                    's-it' => __( 'Icon with text', 'madsparrow' ),
                ],
                'default' => 's-icon',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .ms-s-i.s-it span',
                'condition' => [
                    'socials_style!' => 's-icon',
                ],
            ]
        );

		$this->add_control(
			'text_indent',
			[
				'label' => esc_html__( 'Text Indent', 'madsparrow' ),
				'type' => Controls_Manager::SLIDER,
                'default' => [
					'unit' => 'pt',
					'size' => 4,
				],
				'range' => [
					'pt' => [
						'max' => 32,
						'min' => 0,
						'step' => 1,
					],
				],
                'condition' => [
                    'socials_style!' => 's-icon',
                ],
				'selectors' => [
					'{{WRAPPER}} .ms-s-i.s-it span' => 'margin-left: {{SIZE}}pt;',
				],
			]
		);

        $this->add_responsive_control(
            'socials_size', [
                'label' => __( 'Icon Size', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ms-s-i i' => 'font-size: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'socials_size_box', [
                'label' => __( 'Box Size', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ms-s-i i' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'socials_style' => 's-icon',
                ],
            ]
        );

        $this->add_responsive_control(
            'socials_gap', [
                'label' => __( 'Gap', 'madsparrow' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'vh', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ms-s-w' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'color_options', [
                'label' => __( 'Color', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs( 'hover_effects' );

		$this->start_controls_tab( 'normal',
			[
				'label' => esc_html__( 'Normal', 'madsparrow' ),
			]
		);

        $this->add_control(
            'icon_secondary_color', [
                'label' => __( 'Color', 'madpsarrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-s-i i' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => esc_html__( 'Hover', 'madsparrow' ),
			]
		);

        $this->add_control(
            'icon_secondary_color_hover', [
                'label' => __( 'Color', 'madpsarrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-s-i:hover i' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'bg_color', [
                'label' => __( 'Background On Hover', 'madsparrow' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ms-s-w .ms-s-i i::after' => 'background-color: {{VALUE}}'
                ],
            ]
        );

        $this->end_controls_tab();

		$this->end_controls_tabs();

        $this->add_control(
            'space_options', [
                'label' => __( 'Indentation', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'padding', [
                'label' => esc_html__( 'Padding', 'madsparrow' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem', '%', 'pt', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .ms-s-w .ms-s-i i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bordert_options', [
                'label' => __( 'Border', 'madsparrow' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name' => 'border',
                'label' => __( 'Border', 'madsparrow' ),
                'selector' => '{{WRAPPER}} .ms-s-w .ms-s-i i',
            ]
        );

        $this->add_control(
            'border_radius', [
                'label' => __( 'Radius', 'madsparrow' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .ms-s-w .ms-s-i i::after' => 'border-top-left-radius: {{TOP}}{{UNIT}} {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}} {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{BOTTOM}}{{UNIT}} {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}} {{LEFT}}{{UNIT}};', 
                ],
            ]
        );

        $this->end_controls_section();
    }
            
    protected function render() {

        $settings = $this->get_settings_for_display();

        $i_class = 'ms-s-i';
        $i_class .= $settings['icon_color'] == 'mono' ? ' mono' : '';
        $i_class .= ' ' . $settings['socials_style'];
        ?>
        <div class="ms-s-w">
        <?php foreach ( $settings[ 'socials' ] as $index => $item ) :

        $link_key = 'link_' . $index;
        $i_text = $item['icons_socials'];
        $this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

        if ( $item['link']['is_external'] ) {
            $this->add_render_attribute( $link_key, 'target', '_blank' );
        }

        if ( $item['link']['nofollow'] ) {
            $this->add_render_attribute( $link_key, 'rel', 'nofollow' );
        }

        if ( $settings['socials_style'] == 's-icon') : ?>
            <a class="<?php echo $i_class; ?>" <?php echo $this->get_render_attribute_string( $link_key ); ?>><i class="fa-brands fa-<?php echo $item['icons_socials']; ?>"></i></a>
        <?php else: ?>
            <a class="<?php echo $i_class; ?>" <?php echo $this->get_render_attribute_string( $link_key ); ?>>
                <i class="fa-brands fa-<?php echo $item['icons_socials']; ?>"></i>
                <span><?php echo $i_text; ?></span>
            </a>
        <?php endif;

        endforeach; ?>
        </div>
    <?php }

}