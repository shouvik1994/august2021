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
class Youtube extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

	/**
     * title
     *
     * @var string
     */
    protected $title = '';

     /**
     * description
     *
     * @var string
     */
    protected $description = '';


    /**
     * videoid
     *
     * @var string
     */
    protected $videoid = '';



     /**
     * image
     *
     * @var string
     */
    protected $image = '';

     /**
     * pdate
     *
     * @var \DateTime
     */
    protected $pdate = null;


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
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }



      /**
     * Returns the videoid
     *
     * @return string $videoid
     */
    public function getVideoid()
    {
        return $this->videoid;
    }

    /**
     * Sets the videoid
     *
     * @param string $videoid
     * @return void
     */
    public function setVideoid($videoid)
    {
        $this->videoid = $videoid;
    }




     /**
     * Returns the image
     *
     * @return string $image
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Sets the image
     *
     * @param string $image
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Returns the pdate
     *
     * @return \DateTime $pdate
     */
    public function getPdate()
    {
        return $this->pdate;
    }
    
    /**
     * Sets the pdate
     *
     * @param \DateTime $pdate
     * @return void
     */
    public function setPdate(\DateTime $pdate)
    {
        $this->pdate = $pdate;
    }


}
?>