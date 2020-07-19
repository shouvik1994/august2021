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
 * Team
 */
class Team extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

	 /**
     * title
     *
     * @var string
     */
    protected $title = '';

      /**
     * logo
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $logo = '';


    /**
     * teamapikey
     *
     * @var string
     */
    protected $teamapikey = '';

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
     * Returns the logo
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Sets the logo
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
     * @return void
     */
    public function setLogo(\TYPO3\CMS\Extbase\Domain\Model\FileReference $logo)
    {
        $this->logo = $logo;
    }



     /**
     * Returns the teamapikey
     *
     * @return string $teamapikey
     */
    public function getTeamapikey()
    {
        return $this->teamapikey;
    }

    /**
     * Sets the teamapikey
     *
     * @param string $teamapikey
     * @return void
     */
    public function setTeamapikey($teamapikey)
    {
        $this->teamapikey = $teamapikey;
    }


}