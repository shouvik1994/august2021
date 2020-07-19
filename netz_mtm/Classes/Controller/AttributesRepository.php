<?php
namespace Netz\NetzMtmShop\Domain\Repository;

/***
 *
 * This file is part of the "Kemper System" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018 saurav dalai <saurav.dalai@netzrezepte.de>
 *
 ***/

/**
 * The repository for Attributes
 */
class AttributesRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
	// Order by BE sorting
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );
    public function getAttribute($products=0,$size=0,$color=0,$bedruckung=0){
            $query = $this->createQuery();
            $constraints = array();
            $constraints[] =   $query->equals('hidden', 0);
            $constraints[] =   $query->equals('deleted', 0);
            if($products>0){
            	$constraints[] =   $query->equals('products', $products);
            }
            if($size>0){
            	$constraints[] =   $query->equals('size', $size);
            }
            if($color>0){
            	$constraints[] =   $query->equals('color', $color);
            }
            if($bedruckung>0){
            	$constraints[] =   $query->contains('bedruckung', $bedruckung);
            }
           // print_r($constraints);
            return $query->matching(
                $query->logicalAnd(
                    $constraints
                )
            )->execute();
    }
}
