<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:tx_netzmtm_domain_model_youtube',
        'label' => 'title',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'title,description,image,videoid,pdate',
        'iconfile' => 'EXT:netz_mtm/Resources/Public/Icons/tx_netzmtm_domain_model_youtube.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title,description,image,videoid,pdate',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title,description,image,videoid,pdate, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_netzmtm_domain_model_youtube',
                'foreign_table_where' => 'AND tx_netzmtm_domain_model_youtube.pid=###CURRENT_PID### AND tx_netzmtm_domain_model_youtube.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'behaviour' => [
                'allowLanguageSynchronization' => true
            ],
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 13,
                'eval' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
            ],
        ],

        'title' => [
            'exclude' => true,
            'label' => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:tx_netzmtm_domain_model_youtube.title',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],

        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:tx_netzmtm_domain_model_youtube.description',
           'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],
        ],
        'videoid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:tx_netzmtm_domain_model_youtube.videoid',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],

         'pdate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:tx_netzmtm_domain_model_youtube.pdate',
             'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 12,
                'eval' => 'date',
                'default' => null,
            ],
        ],
      
      
        'image' => [
            'exclude' => true,
            'label' => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:tx_netzmtm_domain_model_youtube.image',
            'config' => array(
                'type'          => 'group',
                'internal_type' => 'file',
                'allowed'       => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'max_size'      => '5000',
                'uploadfolder'  => 'uploads/netz_mtm/youtube/',
                'show_thumbs'   => '1',
                'size'          => '1',
                'maxitems'      => '1',
                'minitems'      => '0'
            ),
        ],
  

    
    ],
];
