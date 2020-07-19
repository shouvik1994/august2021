<?php
namespace Netz\NetzMtm\Domain\Model;

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
 * Competition
 */
class Competition extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * apikey
     *
     * @var string
     */
    protected $apikey = '';

    /**
     * season
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netz\NetzMtm\Domain\Model\Season>
     * @cascade remove
     */
    protected $season = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->season = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the apikey
     *
     * @return string $apikey
     */
    public function getApikey()
    {
        return $this->apikey;
    }

    /**
     * Sets the apikey
     *
     * @param string $apikey
     * @return void
     */
    public function setApikey($apikey)
    {
        $this->apikey = $apikey;
    }

    /**
     * Adds a Season
     *
     * @param \Netz\NetzMtm\Domain\Model\Season $season
     * @return void
     */
    public function addSeason(\Netz\NetzMtm\Domain\Model\Season $season)
    {
        $this->season->attach($season);
    }

    /**
     * Removes a Season
     *
     * @param \Netz\NetzMtm\Domain\Model\Season $seasonToRemove The Season to be removed
     * @return void
     */
    public function removeSeason(\Netz\NetzMtm\Domain\Model\Season $seasonToRemove)
    {
        $this->season->detach($seasonToRemove);
    }

    /**
     * Returns the season
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netz\NetzMtm\Domain\Model\Season> $season
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Sets the season
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Netz\NetzMtm\Domain\Model\Season> $season
     * @return void
     */
    public function setSeason(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $season)
    {
        $this->season = $season;
    }
}
