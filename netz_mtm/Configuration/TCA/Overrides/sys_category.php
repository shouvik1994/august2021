<?php
defined('TYPO3_MODE') or die();
/**
 * Add extra fields to the sys_category record
 */
$newSysCategoryColumns = [
    'color' =>[
            'exclude' => true,
            'label' => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:color',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Red', 'danger-tag'],
                    ['Pink', 'pretty-tag'],
                    ['Brown', 'copper-tag'],
                    ['Blue', 'success-tag'],
                    ['Light Blue', 'Lightsuccess-tag'],
                    ['Grey', 'grey-tag'],

                ],
            ],
        ],
];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('sys_category', $newSysCategoryColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('sys_category', 'color', '',
    'after:items');