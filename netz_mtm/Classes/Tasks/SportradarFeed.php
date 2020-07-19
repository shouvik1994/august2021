<?php
namespace Netz\NetzMtm\Tasks;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Cornel Widmer <cornel@webstobe.ch>, Webstobe GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

class SportradarFeed extends \TYPO3\CMS\Scheduler\Task\AbstractTask {


	/**
	 * Tries to get the feed from the facebook app and saves it to a json-file.
	 *
	 * @return boolean
	 */
	public function execute() {
			
		$extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['netz_mtm']);
		$settings=array();
		$settings['api_pid'] = $extConfig['apiStorageId'];
		$settings['team_pid'] = $extConfig['teamStorageId'];
		$settings['player_pid'] = $extConfig['playerStorageId'];
		
		$mtmUtil = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Netz\NetzMtm\Util\MtmUtil');
		
		return $mtmUtil->sportradarImport($this->accessLevel,$this->sportradarKey,$this->competitorId,$settings);
	}


}