<?php
namespace Netz\NetzMtm\Controller;

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
 * PlayerController
 */
class NewsController extends \Netz\NetzMtm\Controller\AbstractController 
{
	  /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {   
        date_default_timezone_set('Europe/Berlin');
        $date_default  = new \DateTime();
        $date_default = $date_default->format('d.m.Y');
        $options = array(); 
        $arrParams = array();
        $arrParams = $this->request->getArguments();

        $category = $this->settings['category'];
        if($category!=''){
          $options['categoryid'] = $category; 
        }
        if(!empty($arrParams['@widget_0'])){
            $searchParams = $GLOBALS["TSFE"]->fe_user->getKey("ses","mtm_news_filer_value");
            if($searchParams['categoryid']!=''){
              $options['categoryid'] =  $searchParams['categoryid']; 
            }
            if($searchParams['title']!=''){
              $options['title'] =  $searchParams['title'];
            }
            if($searchParams['date']!=''){
              $options['date'] =  $searchParams['date'];
              $date_default =  $options['date'];
            }
        }
        elseif(count($arrParams)>0){
           if($arrParams['category']>0){
                $options['categoryid'] = $arrParams['category'];
           }
           if($arrParams['title']!=''){
                $options['title'] = $arrParams['title'];
           }
           if($arrParams['date']!=''){
                $options['date'] = $arrParams['date'];
                $date_default =  $options['date'];
           } 

           $GLOBALS['TSFE']->fe_user->setKey("ses","mtm_news_filer_value",$options); 
        }
        $categorys = $this->categoryRepository->findAll();
        $this->view->assign('categorys', $categorys);
       
        $news = $this->newsRepository->searchData($options);
        $this->view->assign('news', $news);

        $this->view->assign('date', $date_default);
    }
}
?>
