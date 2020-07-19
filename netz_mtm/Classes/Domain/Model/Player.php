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
 * Player
 */
class Player extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
     * firstname
     *
     * @var string
     */
    protected $firstname = '';

    /**
     * lastname
     *
     * @var string
     */
    protected $lastname = '';


    /**
     * playerapikey
     *
     * @var string
     */
    protected $playerapikey = '';

	/**
     * nationlity
     *
     * @var string
     */
    protected $nationlity = '';

    	/**
     * previousclub
     *
     * @var string
     */
    protected $previousclub = '';


      /**
     * size
     *
     * @var int
     */
    protected $size = 0;

      /**
     * weight
     *
     * @var int
     */
    protected $weight = 0;

    	/**
     * fblink
     *
     * @var string
     */
    protected $fblink = '';


    	/**
     * inslink
     *
     * @var string
     */
    protected $inslink = '';

        /**
     * playernumber
     *
     * @var int
     */
    protected $playernumber = 0;

      /**
     * position
     *
     * @var string
     */
    protected $position;



      /**
     * listimages
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $listimages = null;

     /**
     * sponsor
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $sponsor = null;

      /**
     * pimage
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $pimage = null;
      /**
     * signimage
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @cascade remove
     */
    protected $signimage = null;

     /**
     * dob
     *
     * @var \DateTime
     */
    protected $dob = null;

       /**
     * joiningdate
     *
     * @var \DateTime
     */
    protected $joiningdate = null;




     /**
     * Returns the firstname
     *
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Sets the firstname
     *
     * @param string $firstname
     * @return void
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

     /**
     * Returns the lastname
     *
     * @return string $lastname
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Sets the lastname
     *
     * @param string $lastname
     * @return void
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

     /**
     * Returns the playerapikey
     *
     * @return string $playerapikey
     */
    public function getPlayerapikey()
    {
        return $this->playerapikey;
    }

    /**
     * Sets the playerapikey
     *
     * @param string $playerapikey
     * @return void
     */
    public function setPlayerapikey($playerapikey)
    {
        $this->playerapikey = $playerapikey;
    }

      /**
     * Returns the nationlity
     *
     * @return string $nationlity
     */
    public function getNationlity()
    {
        return $this->nationlity;
    }

    /**
     * Sets the nationlity
     *
     * @param string $nationlity
     * @return void
     */
    public function setNationlity($nationlity)
    {
        $this->nationlity = $nationlity;
    }

     /**
     * Returns the previousclub
     *
     * @return string $previousclub
     */
    public function getPreviousclub()
    {
        return $this->previousclub;
    }

    /**
     * Sets the previousclub
     *
     * @param string $previousclub
     * @return void
     */
    public function setPreviousclub($previousclub)
    {
        $this->previousclub = $previousclub;
    }

     /**
     * Returns the fblink
     *
     * @return string $fblink
     */
    public function getFblink()
    {
        return $this->fblink;
    }

    /**
     * Sets the fblink
     *
     * @param string $fblink
     * @return void
     */
    public function setFblink($fblink)
    {
        $this->fblink = $fblink;
    }

    /**
     * Returns the inslink
     *
     * @return string $inslink
     */
    public function getInslink()
    {
        return $this->inslink;
    }

    /**
     * Sets the inslink
     *
     * @param string $inslink
     * @return void
     */
    public function setInslink($inslink)
    {
        $this->inslink = $inslink;
    }

     /**
     * Returns the listimages
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $listimages
     */
    public function getListimages()
    {
        return $this->listimages;               
    }
    
    /**
     * Sets the listimages
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $listimages
     * @return void
     */
    public function setListimages(\TYPO3\CMS\Extbase\Domain\Model\FileReference $listimages)
    {
        $this->listimages = $listimages;
    }

      /**
     * Returns the pimage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $pimage
     */
    public function getPimage()
    {
        return $this->pimage;               
    }
    
    /**
     * Sets the pimage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $pimage
     * @return void
     */
    public function setPimage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $pimage)
    {
        $this->pimage = $pimage;
    }


     /**
     * Returns the signimage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $signimage
     */
    public function getSignimage()
    {
        return $this->signimage;               
    }
    
    /**
     * Sets the signimage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $signimage
     * @return void
     */
    public function setSignimage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $signimage)
    {
        $this->signimage = $signimage;
    }
    
      /**
     * Sets the playernumber
     *
     * @param int $playernumber
     * @return void
     */
    public function setPlayernumber($playernumber)
    {
        $this->playernumber = $playernumber;
    }
    
     /**
     * Returns the playernumber
     *
     * @return string $playernumber
     */
    public function getPlayernumber()
    {
        return $this->playernumber;
    } 


      /**
     * Sets the weight
     *
     * @param int $weight
     * @return void
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
    
     /**
     * Returns the weight
     *
     * @return string $weight
     */
    public function getWeight()
    {
        return $this->weight;
    } 

     /**
     * Sets the size
     *
     * @param int $size
     * @return void
     */
    public function setSize($size)
    {
        $this->size = $size;
    }
    
     /**
     * Returns the size
     *
     * @return string $size
     */
    public function getSize()
    {
        return $this->size;
    } 
       

     /**
     * Returns the dob
     *
     * @return \DateTime $dob
     */
    public function getDob()
    {
        return $this->dob;
    }
    
    /**
     * Sets the dob
     *
     * @param \DateTime $dob
     * @return void
     */
    public function setDob(\DateTime $dob)
    {
        $this->dob = $dob;
    }

      /**
     * Returns the joiningdate
     *
     * @return \DateTime $joiningdate
     */
    public function getJoiningdate()
    {
        return $this->joiningdate;
    }
    
    /**
     * Sets the joiningdate
     *
     * @param \DateTime $joiningdate
     * @return void
     */
    public function setJoiningdate(\DateTime $joiningdate)
    {
        $this->joiningdate = $joiningdate;
    }
    

     /**
     * Sets the position
     *
     * @param string $position
     * @return void
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
    
     /**
     * Returns the position
     *
     * @return string $position
     */
    public function getPosition()
    {
        return $this->position;
    } 

      /**
     * Returns the sponsor
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $sponsor
     */
    public function getSponsor()
    {
        return $this->sponsor;               
    }
    
    /**
     * Sets the sponsor
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $sponsor
     * @return void
     */
    public function setSponsor(\TYPO3\CMS\Extbase\Domain\Model\FileReference $sponsor)
    {
        $this->sponsor = $sponsor;
    }
}