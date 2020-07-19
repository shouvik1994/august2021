<?php
namespace Netz\NetzMtm\Controller;
use TYPO3\CMS\Core\Utility\GeneralUtility;


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
 * YoutubeVideoController
 */
class YoutubeVideoController extends \Netz\NetzMtm\Controller\AbstractController 
{
    

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
       
        $videos = $this->youtubeRepository->findAll();
        $double_video=array();
        $first_video=$videos[0];
        $double_video[]=$videos[0];
        $double_video[]=$videos[1];
        foreach ($videos as $key => $value) {
            $video[]=$value;
        }
        if(is_array($video)){

        array_splice($video,10);
        }
       
        $this->view->assign('double_video', $double_video);
        $this->view->assign('first_video', $first_video);
        $this->view->assign('video', $video);


    }

     /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {
       $arrParams = array();
        $arrParams = $this->request->getArguments();
        $video = $this->youtubeRepository->findbyuid($arrParams['uid']);
        $this->view->assign('video', $video);
       }

         /**
     * action allvideo
     *
     * @return void
     */
    public function allvideoAction()
    {         
            $arrParams = array();
            $arrParams = $this->request->getArguments();
            if($arrParams!=''){
            $videodetails = $this->youtubeRepository->findbyuid($arrParams['uid']);
            }
            $this->view->assign('videodetails', $videodetails);  
            $video = $this->youtubeRepository->findAll();
            $this->view->assign('video', $video);


    }

}
