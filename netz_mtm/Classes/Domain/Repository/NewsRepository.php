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
 * The repository for News
 */
class NewsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

	protected $defaultOrderings = array(
        'datetime' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );
	public function searchData($options) {
        $query = $this->createQuery();
        $categorys = array();
        $constraints = array();

        if($options['title']!=''){
           $titles = explode(" ", $options['title']);
           $constraints_and = array();
           $lists = array('title','teaser','bodytext','author','author_email','type','keywords','description','categories.title');
           foreach ($lists as $list) {
                $constraints_title  = array();       
                foreach ($titles as $value) {
                    if(trim($value)!=''){
                         $constraints_title[] =  $query->like($list, "%".$value."%");
                    }
                }
                if(count($constraints_title)>0){
                     $constraints_and[] = $query->logicalAnd(
                         $constraints_title
                     );
                }    
           }
           if(count($constraints_and)>0){
                $constraints[] = $query->logicalOr(
                         $constraints_and
                );
           }
        }
        if($options['date']!=''){
			$format = 'd.m.Y';
			$start_date = \DateTime::createFromFormat($format, $options['date']);
			$start_date->setTime(0, 0, 0);
			//print_r($start_date);
			$constraints[] = $query->greaterThanOrEqual('datetime', $start_date);
			$end_date = \DateTime::createFromFormat($format, $options['date']);
			$end_date->setTime(23, 59, 0);
			//print_r($end_date);
			$constraints[] = $query->lessThanOrEqual('datetime', $end_date);
        }
        
        $constraints[] =  $query->equals('hidden', 0);
        $constraints[] =  $query->equals('deleted', 0);
        
        if($options['categoryid']>0){
            $categorys[] = $options['categoryid'];
        }
        if(count($categorys)>0){
            $sub_suids = array();
            foreach ($categorys as $category) {
                $sub_suids[] =  $query->contains('categories', $category);
            }
            $constraints[] = $query->logicalOr(
                    $sub_suids
            );
        }
        return $query->matching(
            $query->logicalAnd(
                $query->logicalAnd(
                    $constraints
                )
            )
        )->execute();
    }
}
