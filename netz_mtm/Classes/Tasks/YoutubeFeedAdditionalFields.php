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

use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Messaging\FlashMessage;

class YoutubeFeedAdditionalFields implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface {

    /**
     * This method is used to define new fields for adding or editing a task
     * In this case, it adds an email field
     *
     * @param    array $taskInfo : reference to the array containing the info used in the add/edit form
     * @param    object $task : when editing, reference to the current task object. Null when adding.
     * @param    \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject : reference to the calling object (Scheduler's BE module)
     * @return    array                    Array containg all the information pertaining to the additional fields
     *                                    The array is multidimensional, keyed to the task class name and each field's id
     *                                    For each field it provides an associative sub-array with the following:
     *                                        ['code']        => The HTML code for the field
     *                                        ['label']        => The label of the field (possibly localized)
     *                                        ['cshKey']        => The CSH key for the field
     *                                        ['cshLabel']    => The code of the CSH label
     */
    public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject) {

        $additionalFields = array();

        // clientId
        $fieldID = 'youtubeKey';
        $fieldHtml = '<input type="text" name="tx_scheduler[' . $fieldID . ']" id="' . $fieldID . '" size="50" maxlength="255" value="' . $task->youtubeKey . '">';
        $additionalFields[$fieldID] = array(
            'code' => $fieldHtml,
            'label' => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:task.youtube.youtubeKey',
            'cshKey' => '',
            'cshLabel' => $fieldID
        );

        // clientSecret
        $fieldID = 'youtubeChannelId';
        $fieldHtml = '<input type="text" name="tx_scheduler[' . $fieldID . ']" id="' . $fieldID . '" size="50" maxlength="255" value="' . $task->youtubeChannelId . '">';
        $additionalFields[$fieldID] = array(
            'code' => $fieldHtml,
            'label' => 'LLL:EXT:netz_mtm/Resources/Private/Language/locallang_db.xlf:task.youtube.youtubeChannelId',
            'cshKey' => '',
            'cshLabel' => $fieldID
        );

        return $additionalFields;

    }

    /**
     * This method checks any additional data that is relevant to the specific task
     * If the task class is not relevant, the method is expected to return true
     *
     * @param    array $submittedData : reference to the array containing the data submitted by the user
     * @param    \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject : reference to the calling object (Scheduler's BE module)
     * @return    boolean                    True if validation was ok (or selected class is not relevant), false otherwise
     */
    public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $parentObject) {
        $result = TRUE;

        if (strlen(trim($submittedData['youtubeKey'])) === 0) {
            $parentObject->addMessage('No Youtube Key is entered.', FlashMessage::ERROR);
            $result = FALSE;
        }

        if (strlen(trim($submittedData['youtubeChannelId'])) === 0) {
            $parentObject->addMessage('No youtube Channel ID is entered.', FlashMessage::ERROR);
            $result = FALSE;
        }
        return $result;
    }

    /**
     * This method is used to save any additional input into the current task object
     * if the task class matches
     *
     * @param    array $submittedData : array containing the data submitted by the user
     * @param    \TYPO3\CMS\Scheduler\Task\AbstractTask $task : reference to the current task object
     * @return    void
     */
    public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task) {
        $task->youtubeKey = $submittedData['youtubeKey'];
        $task->youtubeChannelId = $submittedData['youtubeChannelId'];
    }

}