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
class PlayerController extends \Netz\NetzMtm\Controller\AbstractController 
{
	  /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {    
          $teams_data = $this->teamRepository->findAll();
            $teams = array();
            foreach ($teams_data as $value) {
               $teams[$value->getTeamapikey()]=$value;
            }
        $sportradar_competitor_id= $this->settings['sportradar_competitor_id'];
        $player = $this->playerRepository->findAll();
        $playerArray = array();
        foreach ($player as $key => $value) {
           $playerArray[] = $value;


        }
        foreach ($playerArray as $key => $value) {
         $playerdata[$key]['data']=$value;
           $player_api_id=$value->getPlayerapikey();
           $options = array('player_api_id'=>$player_api_id);
           $data= $this->getSportradarData('playersummaries',$options); 
            foreach ($data['summaries'] as $key1 => $value1) {
                $playerdata[$key]['tabledata'][$key1]['start_time'] = $value1['sport_event']['start_time'];

            foreach($value1['statistics']['totals']['competitors'] as $competitors){
                  if($competitors['id']==$sportradar_competitor_id){  
                   foreach ($competitors['players'] as   $players) {
                                  if($players['id']==$value->getPlayerapikey()){
                                  $playerdata[$key]['tabledata'][$key1]['statistic']=$players['statistics'];
                                 }
                  }                 
                     
            }
            else{
                       if(array_key_exists($competitors['id'], $teams)){
                          $playerdata[$key]['tabledata'][$key1]['logo'] = $teams[$competitors['id']]->getLogo();
                       }  
                       else{
                          $playerdata[$key]['tabledata'][$key1]['logo'] ="";
                       }
                       $playerdata[$key]['tabledata'][$key1]['competitorsname'] =$competitors['name'];
                  }
            
            }
        }
    }

       
        $playerArray = array_chunk($playerdata,3);
        $this->view->assign('players', $player);
        $this->view->assign('playerdata', $playerdata);
        $this->view->assign('playerArray', $playerArray);
    	
    }

    


    
}
?>
