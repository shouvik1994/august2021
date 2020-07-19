<?php
defined('TYPO3_MODE') || die('Access denied.');



\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'Plist',
    [
        'Partner' => 'list'
    ],
    // non-cacheable actions
    [
        'Partner' => 'list'
    ]
);

  \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'Yvideo',
    [
        'YoutubeVideo' => 'list,show,allvideo'
    ],
    // non-cacheable actions
    [
        'YoutubeVideo' => 'list,show,allvideo'
    ]
);

   \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'Allvideo',
    [
        'YoutubeVideo' => 'allvideo,show'
    ],
    // non-cacheable actions
    [
        'YoutubeVideo' => 'allvideo,show'
    ]
);

     \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'Playerlist',
    [
        'Player' => 'list'
    ],
    // non-cacheable actions
    [
        'Player' => 'list'
    ]


);

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'Mtable',
    [
        'Sportradar' => 'mtable'
    ],
    // non-cacheable actions
    [
        'Sportradar' => 'mtable'
    ]


);
     \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'Nmatch',
    [
        'Sportradar' => 'nmatch'
    ],
    // non-cacheable actions
    [
        'Sportradar' => 'nmatch'
    ]


);
     \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'Tabe',
    [
        'Sportradar' => 'tabe'
    ],
    // non-cacheable actions
    [
        'Sportradar' => 'tabe'
    ]
);
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'Spiel',
    [
        'Sportradar' => 'spiel'
    ],
    // non-cacheable actions
    [
        'Sportradar' => 'spiel'
    ]


);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'Statis',
    [
        'Sportradar' => 'statis'
    ],
    // non-cacheable actions
    [
        'Sportradar' => 'statis'
    ]


);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'News',
    [
        'News' => 'list'
    ],
    // non-cacheable actions
    [
        'News' => 'list'
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'Mtmapi',
    [
        'Api' => 'list'
    ],
    // non-cacheable actions
    [
        'Api' => 'list'
    ]
);

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'Nmatchapp',
    [
        'Api' => 'nmatchapp'
    ],
    // non-cacheable actions
    [
        'Api' => 'nmatchapp'
    ]
);
      \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Netz.NetzMtm',
    'Auser',
    [
        'Api' => 'activateuser'
    ],
    // non-cacheable actions
    [
        'Api' => 'activateuser'
    ]


);
    

      // REGISTER TASKS
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Netz\\NetzMtm\\Tasks\\YoutubeFeed'] = array(
        'extension'        => $_EXTKEY,
        'title'            => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:task.youtube.title',
        'description'      => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:task.youtube.description',
        'additionalFields' => 'Netz\\NetzMtm\\Tasks\\YoutubeFeedAdditionalFields'
    );

  // REGISTER TASKS
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Netz\\NetzMtm\\Tasks\\SportradarFeed'] = array(
        'extension'        => $_EXTKEY,
        'title'            => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:task.sportradar.title',
        'description'      => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:task.sportradar.description',
        'additionalFields' => 'Netz\\NetzMtm\\Tasks\\SportradarFeedAdditionalFields'
    );

		
$GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['customrte'] = 'fileadmin/templates/Website/TypoScript/RTE/custom.yaml';

$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['classes']['Domain/Model/Category'][] = 'netz_mtm';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['news']['classes']['Domain/Model/News'][] = 'netz_mtm';
