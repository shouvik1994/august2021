<?php
namespace Netz\NetzMtm\Domain\Model;

/***
 *
 * This file is part of the "Tourismus" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 saurav dalai <saurav@fortress6.com>
 *
 ***/

/**
 * Category
 */
class Category extends \GeorgRinger\News\Domain\Model\Category
{
   /**
     * @var string
     */
    protected $color;


    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }
}