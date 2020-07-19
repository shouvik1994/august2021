<?php
defined('TYPO3_MODE') || die('Access denied.');



        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'Plist',
            'Partner'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'Yvideo',
            'Youtube Video'
        );

         \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'Allvideo',
            'All Video'
        );

          \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'Playerlist',
            'Player List'
        );

         \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'Mtable',
            'Mini Table'
        );


         \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'Nmatch',
            'Next Match'
        );

          \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'Tabe',
            'Tabellen'
        );

          \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'Spiel',
            'Spielpläne'
        );

         \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'Statis',
            'Statistiken'
        );
         \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'News',
            'MTM News'
        );

          \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'Mtmapi',
            'MTM Api'
        );

         \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'Nmatchapp',
            'Next Match App'
        );

           \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Netz.NetzMtm',
            'Auser',
            'Activate User'
        );



        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('netz_mtm', 'Configuration/TypoScript', 'MTM');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_netzmtm_domain_model_partner', 'EXT:netz_mtm/Resources/Private/Language/locallang_csh_tx_netzmtm_domain_model_partner.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_netzmtm_domain_model_partner');

         \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_netzmtm_domain_model_player', 'EXT:netz_mtm/Resources/Private/Language/locallang_csh_tx_netzmtm_domain_model_partner.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_netzmtm_domain_model_player');


         \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_netzmtm_domain_model_team', 'EXT:netz_mtm/Resources/Private/Language/locallang_csh_tx_netzmtm_domain_model_team.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_netzmtm_domain_model_team');

         \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_netzmtm_domain_model_youtube', 'EXT:netz_mtm/Resources/Private/Language/locallang_csh_tx_netzmtm_domain_model_youtube.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_netzmtm_domain_model_youtube');



         \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_netzmtm_domain_model_competition', 'EXT:netz_mtm/Resources/Private/Language/locallang_csh_tx_netzmtm_domain_model_competition.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_netzmtm_domain_model_competition');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_netzmtm_domain_model_season', 'EXT:netz_mtm/Resources/Private/Language/locallang_csh_tx_netzmtm_domain_model_season.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_netzmtm_domain_model_season');
        


         $pluginSignature = 'netzmtm_yvideo'; 
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:netz_mtm/Configuration/Flexform/YoutubeFlexform.xml');

         $pluginSignature = 'netzmtm_mtable'; 
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:netz_mtm/Configuration/Flexform/MtableFlexform.xml');

           $pluginSignature = 'netzmtm_tabe'; 
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:netz_mtm/Configuration/Flexform/TabeFlexform.xml');

          $pluginSignature = 'netzmtm_spiel'; 
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:netz_mtm/Configuration/Flexform/SpielFlexform.xml');

        $pluginSignature = 'netzmtm_news'; 
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:netz_mtm/Configuration/Flexform/NewsFlexform.xml');

