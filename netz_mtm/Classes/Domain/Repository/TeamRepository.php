<?php
namespace Netz\NetzMtm\Domain\Repository;

/***
 *
 * This file is part of the "MTM" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020
 *
 ***/

/**
 * The repository for Partners
 */
class TeamRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
	public function initializeObject() {
        $querySettings = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings');
        $querySettings->setRespectStoragePage(FALSE);
        $querySettings->setRespectSysLanguage(FALSE);
        $querySettings->setLanguageUid(0);
        $this->setDefaultQuerySettings($querySettings);
    }
}
