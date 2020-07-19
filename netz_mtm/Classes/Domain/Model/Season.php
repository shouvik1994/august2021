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
 * Season
 */
class Season extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * sdate
     *
     * @var \DateTime
     */
    protected $sdate = null;

    /**
     * edate
     *
     * @var \DateTime
     */
    protected $edate = null;

    /**
     * year
     *
     * @var string
     */
    protected $year = '';

    /**
     * apikey
     *
     * @var string
     */
    protected $apikey = '';

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
     * Returns the sdate
     *
     * @return \DateTime $sdate
     */
    public function getSdate()
    {
        return $this->sdate;
    }

    /**
     * Sets the sdate
     *
     * @param \DateTime $sdate
     * @return void
     */
    public function setSdate(\DateTime $sdate)
    {
        $this->sdate = $sdate;
    }

    /**
     * Returns the edate
     *
     * @return \DateTime $edate
     */
    public function getEdate()
    {
        return $this->edate;
    }

    /**
     * Sets the edate
     *
     * @param \DateTime $edate
     * @return void
     */
    public function setEdate(\DateTime $edate)
    {
        $this->edate = $edate;
    }

    /**
     * Returns the year
     *
     * @return string $year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Sets the year
     *
     * @param string $year
     * @return void
     */
    public function setYear($year)
    {
        $this->year = $year;
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
}
