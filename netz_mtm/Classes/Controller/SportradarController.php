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
 * SportradarController
 */
class SportradarController extends \Netz\NetzMtm\Controller\AbstractController 
{

	  /**
     * action mtable
     *
     * @return void
     */
    public function mtableAction()
    {        date_default_timezone_set('Europe/Berlin');
            $competition = $this->settings['competition'];
            $competition = $this->competitionRepository->findByUid($competition);
            $session_api_key = "";
            
            foreach ($competition->getSeason() as $season) {
                $session_api_key = $season->getApikey();
            }
            $teams_data = $this->teamRepository->findAll();
            $teams = array();
            foreach ($teams_data as $value) {
               $teams[$value->getTeamapikey()]=$value;
            }


            
            $options = array('session_api_key'=>$session_api_key);
            $data_standings = $this->getSportradarData('standings',$options); 

            $sportradar_competitor_id= $this->settings['sportradar_competitor_id'];
            $options = array('competitor_id'=>$sportradar_competitor_id);
            $data_summaries = $this->getSportradarData('summaries',$options); 

            $ranking_table = $data_standings['standings'][0]['groups'][0]['standings'];
            foreach ($ranking_table as $key => $value) {
               if(array_key_exists($value['competitor']['id'], $teams)){
                    $ranking_table[$key]['logo'] = $teams[$value['competitor']['id']]->getLogo(); 
               }
               else{
                    $ranking_table[$key]['logo'] = "";
               }
            }

            foreach ($data_summaries['summaries'] as $key => $value) {
                  $arr[]=$value;   
            }

             usort($arr, function($a1, $a2) {
               $value1 = strtotime($a1['sport_event']['start_time']);
               $value2 = strtotime($a2['sport_event']['start_time']);
               return $value2 - $value1;
            });

             foreach ($arr as $key => $value) {
               foreach ($value['sport_event']['competitors'] as $key1 => $value1) {
                     if(array_key_exists($value1['id'], $teams)){
                        $arr[$key]['sport_event']['competitors'][$key1]['logo']=$teams[$value1['id']]->getLogo();
               }   
               else{
                     $arr[$key]['sport_event']['competitors'][$key1]['logo']='';
                 }
               }
                }
            foreach ($arr as $key => $value) {
               $arr[$key]['competitor1']=$value['sport_event']['competitors'][0];
               $arr[$key]['competitor2']=$value['sport_event']['competitors'][1];
            }
            $match_list=array_slice($arr, 0, 4); 
           // print_r($match_list);
            $this->view->assign('ranking_table', $ranking_table);
            $this->view->assign('match_list', $match_list);
            
    }

        /**
     * action nmatch
     *
     * @return void
     */

      public function nmatchAction()
    {       
            date_default_timezone_set('Europe/Berlin');
            $sportradar_competitor_id= $this->settings['sportradar_competitor_id'];
            $options = array('competitor_id'=>$sportradar_competitor_id);
            $data_summaries = $this->getSportradarData('summaries',$options); 
           // print_r($data_summaries);
            $teams_data = $this->teamRepository->findAll();
            $teams = array();
            foreach ($teams_data as $value) {
               $teams[$value->getTeamapikey()]=$value;
            }
           // var_dump($teams);
            foreach ($data_summaries['summaries'] as $key => $value) {
                  $arr[]=$value['sport_event'];   
            }
             $current = date("Y-m-d H:i:s");
             foreach ($arr as $key => $value) {
              $myDate =  date("Y-m-d H:i:s", strtotime($value['start_time']));
              if(strtotime($myDate) >strtotime($current)){
                $next_match=$value;
                 foreach ($value['competitors'] as $key1 => $value1) {
                     if(array_key_exists($value1['id'], $teams)){
                        $next_match['competitors'][$key1]['logo']=$teams[$value1['id']]->getLogo();
               }   
               else{
                     $next_match['competitors'][$key1]['logo']='';
                 }
               }
             }
            
              }
            $this->view->assign('next_match', $next_match);
     }




     /**
     * action tabe
     *
     * @return void
     */

      public function tabeAction()
    {     
                $teams_data = $this->teamRepository->findAll();
                $teams = array();
                foreach ($teams_data as $value) {
                   $teams[$value->getTeamapikey()]=$value;
                }


                $competition_id = $this->settings['tabcompetitions'];
                $competition_arr=explode(",",$competition_id);
                foreach ($competition_arr as $key => $value) {
                  $competition = $this->competitionRepository->findByUid($value);
                      foreach ($competition->getSeason() as $season) {
                         $session_api_key = $season->getApikey();
                      }

                $options = array('session_api_key'=>$session_api_key);
                $data_standings = $this->getSportradarData('standings',$options); 

                $ranking_table = $data_standings['standings'][0]['groups'][0]['standings'];
                if(is_array($ranking_table)){
                foreach ($ranking_table as $key => $value) {
                   if(array_key_exists($value['competitor']['id'], $teams)){
                        $ranking_table[$key]['logo'] = $teams[$value['competitor']['id']]->getLogo(); 
                   }
                   else{
                        $ranking_table[$key]['logo'] = "";
                   }
                }
                $last['last_ranks']=array_slice($ranking_table,-2,2,true);
                  foreach ($ranking_table as $key => $value) {
                                if(array_key_exists($key, $last['last_ranks'])){
                                    $ranking_table[$key]['lastwo']=1;
                                }
                            
                    }

                  //print_r($ranking_table);
                 $competition_data[]=array('competitiondata'=>$competition,'pointtable'=>$ranking_table);
                }
              }

                $this->view->assign('competition_data', $competition_data);


    }



     /**
     * action spiel
     *
     * @return void
     */

      public function spielAction()
    {       
              date_default_timezone_set('Europe/Berlin');
              $teams_data = $this->teamRepository->findAll();
                $teams = array();
                foreach ($teams_data as $value) {
                   $teams[$value->getTeamapikey()]=$value;
                }

            $sportradar_competitor_id= $this->settings['sportradar_competitor_id'];
            $options = array('competitor_id'=>$sportradar_competitor_id);
            $data_summaries = $this->getSportradarData('summaries',$options);
             foreach ($data_summaries['summaries'] as $key => $value) {
                  $arr[]=$value;   
            }
             usort($arr, function($a1, $a2) {
               $value1 = strtotime($a1['sport_event']['start_time']);
               $value2 = strtotime($a2['sport_event']['start_time']);
               return $value1 - $value2;
            });

             foreach ($arr as $key => $value) {
               foreach ($value['sport_event']['competitors'] as $key1 => $value1) {
                     if(array_key_exists($value1['id'], $teams)){
                        $arr[$key]['sport_event']['competitors'][$key1]['logo']=$teams[$value1['id']]->getLogo();
               }   
               else{
                     $arr[$key]['sport_event']['competitors'][$key1]['logo']='';
                 }
               }
                }
              foreach ($arr as $key => $value) {
               $arr[$key]['sport_event']['competitor1']=$value['sport_event']['competitors'][0];
               $arr[$key]['sport_event']['competitor2']=$value['sport_event']['competitors'][1];
            }
            $competition_id = $this->settings['spielcompetitions'];
            $competition_arr=explode(",",$competition_id); 
            foreach ($competition_arr as $key => $value) {
              $competition = $this->competitionRepository->findByUid($value);
              $match_list[$competition->getApikey()]=array('competition'=>$competition);
              foreach ($arr as $key1 => $value1) {
                if($competition->getApikey()==$value1['sport_event']['sport_event_context']['competition']['id']){
                  $match_list[$competition->getApikey()]['data'][]=$value1;

                }
              }
            }


            $this->view->assign('match_list', $match_list);

    }


    /**
     * action statis
     *
     * @return void
     */

      public function statisAction()
    {       
            date_default_timezone_set('Europe/Berlin');


            $teams_data = $this->teamRepository->findAll();
            $teams = array();
            foreach ($teams_data as $value) {
               $teams[$value->getTeamapikey()]=$value;
            }

            $player_data = $this->playerRepository->findAll();
            $player = array();
            foreach ($player_data as $value) {
               $player[$value->getPlayerapikey()] = $value;
            }

            $sportradar_competitor_id= $this->settings['sportradar_competitor_id'];
            $options = array('competitor_id'=>$sportradar_competitor_id);
            $data_summaries = $this->getSportradarData('summaries',$options);

            $arr = array();
            foreach ($data_summaries['summaries'] as $key => $value) {
              if($value['sport_event_status']['match_status']=='ended'){
                  $arr[]=$value;   
              }
            }
            usort($arr, function($a1, $a2) {
               $value1 = strtotime($a1['sport_event']['start_time']);
               $value2 = strtotime($a2['sport_event']['start_time']);
               return $value1 - $value2;
            });
            
            $all_match=array();
            foreach ($arr as $key => $value) {
                $all_match[$key]['start_time'] = $value['sport_event']['start_time'];
                foreach($value['statistics']['totals']['competitors'] as $competitors){
                  if($competitors['id']==$sportradar_competitor_id){
                      $all_match[$key]['statistics'] = $competitors['statistics'];
                  }
                  else{
                       if(array_key_exists($competitors['id'], $teams)){
                          $all_match[$key]['logo'] = $teams[$competitors['id']]->getLogo();
                       }  
                       else{
                          $all_match[$key]['logo'] ="";
                       }
                       $all_match[$key]['name'] =$competitors['name'];
                  }
                }
            }
           //print_r($arr);
           $play_keys = array("yellow_cards"=>0,"red_cards"=>0,"suspensions"=>0,"shots"=>0,"goals_scored"=>0,"seven_m_goals"=>0,"field_goals"=>0,"assists"=>0,"technical_fouls"=>0,"steals"=>0,"blocks"=>0,"shots_off_goal"=>0,"saves"=>0,"shots_on_goal"=>0,"shot_accuracy"=>0,"shots_against"=>0,"goalkeeper_minutes_played"=>array(),"goals_conceded"=>0,"save_accuracy"=>0); 

           $all_players = array();
           foreach ($arr as $key => $value) {
               foreach($value['statistics']['totals']['competitors'] as $competitors){
                    foreach ($competitors['players'] as $key => $playersvalue) {
                        if(array_key_exists($playersvalue['id'], $player)){
                          $all_players[$playersvalue['id']]['id']= $playersvalue['id'];
                          $all_players[$playersvalue['id']]['name']= $playersvalue['name'];
                          $all_players[$playersvalue['id']]['position']= $player[$playersvalue['id']]->getPosition();
                          $all_players[$playersvalue['id']]['data'][]= $playersvalue['statistics'];
                          $all_players[$playersvalue['id']]['match_played']= count($all_players[$playersvalue['id']]['data']);
                          foreach ($play_keys as $pk => $pv) {
                            $all_players[$playersvalue['id']][$pk] = $pv;
                          }

                        }   
                    }
                }
            }
            $players_g = array();
            $players_others = array();
            foreach ($all_players as $player_key => $player_value) {
              foreach ($player_value['data'] as $key => $playdata) {
                  foreach ($playdata as $key => $value) {
                      if($key == 'goalkeeper_minutes_played'){
                         $all_players[$player_key][$key][] = $value;
                      }
                      else{
                        $all_players[$player_key][$key] += $value; 
                      }
                  }
              }
              
              $all_players[$player_key]['shot_accuracy'] = round(($all_players[$player_key]['goals_scored'] / $all_players[$player_key]['shots'] )*100);

              if($all_players[$player_key]['shots'] == 0){
                $all_players[$player_key]['shot_accuracy'] = 0;
              }
              
              $all_players[$player_key]['save_accuracy'] = round((($all_players[$player_key]['shots_against']-$all_players[$player_key]['goals_conceded'])/$all_players[$player_key]['shots_against'])*100);
              if($all_players[$player_key]['shots_against'] == 0){
                $all_players[$player_key]['save_accuracy'] = 0;
              }

              if(count($all_players[$player_key]['goalkeeper_minutes_played'])>0){
                  $all_players[$player_key]['goalkeeper_minutes_played'] = $this->calculateTime($all_players[$player_key]['goalkeeper_minutes_played']);
              }
              else{
                  $all_players[$player_key]['goalkeeper_minutes_played'] = "00:00";
              }

              if($all_players[$player_key]['position']=='G'){
                $players_g[$player_key] = $all_players[$player_key];
              }
              $players_others[$player_key] = $all_players[$player_key];
            }
             //print_r($all_players);
             //print_r($players_others);
             //print_r($players_g);
            $this->view->assign('all_match', $all_match);
            $this->view->assign('players_g', $players_g);
            $this->view->assign('players_others', $players_others);


    }
   
}
?>
