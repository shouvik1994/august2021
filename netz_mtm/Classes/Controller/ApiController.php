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
 * ApiController
 */
class ApiController extends \Netz\NetzMtm\Controller\AbstractController 
{




      protected $base_url='http://p551477.webspaceconfig.de';   

    

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {     

            
            $api = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('api');
            if($api=='mtm'){

                header('Content-Type: application/json');
                $result = array();

                $action = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('action');

                switch ($action) {
                    case 'competitions':
                     $teams_data = $this->teamRepository->findAll();
                        $teams = array();
                        foreach ($teams_data as $value) {
                           $teams[$value->getTeamapikey()]=$value;
                        }
                    $competition = $this->competitionRepository->findAll();
                    foreach ($competition as $cn) {
                        $data = array();
                        $data['uid'] = $cn->getUid();
                        $data['title'] = $cn->getTitle();
                        $data['apikey'] = $cn->getApikey();
                        foreach ($cn->getSeason() as $season) {
                         $session_api_key[] = $season->getApikey();
                      }

                      foreach ($session_api_key as $key => $session_api_value) {
                            $options = array('session_api_key'=>$session_api_value);

                            $data_standings = $this->getSportradarData('standings',$options); 
                            $data['ranking_table'] = $data_standings['standings'][0]['groups'][0]['standings'];
                           if($data['ranking_table']){
                               foreach ($data['ranking_table'] as $key => $value) {
                                   if(array_key_exists($value['competitor']['id'], $teams)){
                                            $image_path=$this->getimageuid('tx_netzmtm_domain_model_team','image',$teams[$value['competitor']['id']]->getUid()); 
                                           
                                                $data['ranking_table'][$key]['logo'] = $this->base_url.'/fileadmin/'.$image_path['identifier']; 
                                           }
                                           else{
                                                $data['ranking_table'][$key]['logo'] = "";
                                           }
                                }
                             }
                             if(is_array($data['ranking_table'])){
                            $data['last_ranks']=array_slice($data['ranking_table'],-2,2,true);
                            foreach ($data['ranking_table'] as $key => $value) {
                                if(array_key_exists($key, $data['last_ranks'])){
                                    $data['ranking_table'][$key]['lastwo']=1;
                                }
                            
                            }
                          }
                    }
                                $result[]= $data;


                                $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
                                $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
                                $templatePathAndFilename = $partialRootPath . 'Api/Tabllen.html';
                                $this->view->setTemplatePathAndFilename($templatePathAndFilename);
                                
                                $this->view->assign('tabllen_data', $result);
                                $output = $this->view->render();  
                          
                    }

                    break;

                        case 'spielplaene':

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
                            $date= date("Y-m-d", strtotime($value['sport_event']['start_time']));
                            $dayOfWeek = date("D", strtotime($date));

                            $match[$key]['city']=$value['sport_event']['venue']['city_name'];
                            $match[$key]['venue']=$value['sport_event']['venue']['name'];
                            $match[$key]['dayOfWeek']=$dayOfWeek;
                            $match[$key]['date']=$value['sport_event']['start_time'];
                            $match[$key]['competitors']=$value['sport_event']['competitors'];
                            $match[$key]['competitorsid']=$value['sport_event']['sport_event_context']['competition']['id'];
                            $match[$key]['sport_event_status']=$value['sport_event_status'];

                               foreach ($value['sport_event']['competitors'] as $key1 => $value1) {
                                     if(array_key_exists($value1['id'], $teams)){
                                      $image_path=$this->getimageuid('tx_netzmtm_domain_model_team','image',$teams[$value1['id']]->getUid()); 
                                      $match[$key]['competitors'][$key1]['logo']=$this->base_url.'/fileadmin/'.$image_path['identifier'];
                                    }   
                                    else{
                                     $match[$key]['competitors'][$key1]['logo']='';
                                    }
                                }
                            }

                            foreach ($match as $key => $matchvalue) {
                                $match[$key]['competitors1']=$matchvalue['competitors'][0];
                                $match[$key]['competitors2']=$matchvalue['competitors'][1];
                              
                            }
                           
                            $competition_arr=$this->competitionRepository->findAll();
                            foreach ($competition_arr as $key => $competition) {
                              $data[$competition->getApikey()]=array('competition_title'=>$competition->getTitle(),'competition_uid'=>$competition->getUid());
                                     foreach ($match as $key1 => $value1) {
                                           if($competition->getApikey()==$value1['competitorsid']){
                                             $data[$competition->getApikey()]['data'][]=$value1;

                                            }
                                    }
                            }


                            $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
                            $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
                            $templatePathAndFilename = $partialRootPath . 'Api/Spielplaene.html';
                            $this->view->setTemplatePathAndFilename($templatePathAndFilename);
                            
                            $this->view->assign('Spielplaene_data', $data);
                            $output = $this->view->render();  
                          

                    break;

                              case 'statistiken':


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
                                                $image_path=$this->getimageuid('tx_netzmtm_domain_model_team','image',$teams[$competitors['id']]->getUid()); 
                                                      $all_match[$key]['logo'] = $this->base_url.'/fileadmin/'.$image_path['identifier'];
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
                                         
                                        $data=array('players_others'=>$players_others,'players_g'=>$players_g,'all_match'=>$all_match);

                         

                                        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
                                        $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
                                        $templatePathAndFilename = $partialRootPath . 'Api/Statistiken.html';
                                        $this->view->setTemplatePathAndFilename($templatePathAndFilename);
                                        
                                        $this->view->assign('statistiken_data', $data);
                                        $output = $this->view->render();  
                                     

                    break;


                              case 'kader':
                                  $teams_data = $this->teamRepository->findAll();
                                  $teams = array();
                                  foreach ($teams_data as $value) {
                                     $teams[$value->getTeamapikey()]=$value;
                                  }
                                  $sportradar_competitor_id= $this->settings['sportradar_competitor_id'];
                                  $player = $this->playerRepository->findAll();
                                  foreach ($player as $key => $playervalue) {
                                    $playerdetails[$key]['uid']=$playervalue->getUid();
                                    $playerdetails[$key]['firstname']=$playervalue->getFirstname();
                                    $playerdetails[$key]['lastname']=$playervalue->getLastname();
                                    $playerdetails[$key]['playernumber']=$playervalue->getPlayernumber();
                                    $playerdetails[$key]['position']=$playervalue->getPosition();
                                    $pimage_path=$this->getimageuid('tx_netzmtm_domain_model_player','pimage',$playervalue->getUid()); 
                                    if($pimage_path){
                                    $playerdetails[$key]['pimage']=$this->base_url.'/fileadmin/'.$pimage_path['identifier'];
                                     }
                                     else{
                                      $playerdetails[$key]['pimage']='';
                                     }

                                    $limage_path=$this->getimageuid('tx_netzmtm_domain_model_player','listimages',$playervalue->getUid()); 
                                    if($limage_path){
                                    $playerdetails[$key]['listimages']=$this->base_url.'/fileadmin/'.$limage_path['identifier'];
                                     }
                                     else{
                                      $playerdetails[$key]['listimages']='';

                                     }

                                    $simage_path=$this->getimageuid('tx_netzmtm_domain_model_player','signimage',$playervalue->getUid()); 
                                    if($simage_path){
                                    $playerdetails[$key]['signimage']=$this->base_url.'/fileadmin/'.$simage_path['identifier'];
                                    }
                                    else{
                                      $playerdetails[$key]['signimage']='';

                                    }

                                    $sponserimage_path=$this->getimageuid('tx_netzmtm_domain_model_player','sponsor',$playervalue->getUid()); 
                                    if($sponserimage_path){
                                    $playerdetails[$key]['sponsor']=$this->base_url.'/fileadmin/'.$sponserimage_path['identifier'];
                                     }
                                     else{
                                       $playerdetails[$key]['sponsor']='';
                                     }

                                    $playerdetails[$key]['nationlity']=$playervalue->getNationlity();
                                    $playerdetails[$key]['dob']=$playervalue->getDob();
                                    $playerdetails[$key]['joiningdate']=$playervalue->getJoiningdate();
                                    $playerdetails[$key]['weight']=$playervalue->getWeight();
                                    $playerdetails[$key]['size']=$playervalue->getSize();
                                    $playerdetails[$key]['previousclub']=$playervalue->getPreviousclub();
                                    $playerdetails[$key]['inslink']=$playervalue->getInslink();
                                    $playerdetails[$key]['fblink']=$playervalue->getFblink();

                                     $player_api_id=$playervalue->getPlayerapikey();
                                     $options = array('player_api_id'=>$player_api_id);
                                     $data= $this->getSportradarData('playersummaries',$options); 
                                     
                                     foreach ($data['summaries'] as $key1 => $value1) {
                                          $playerdetails[$key]['tabledata'][$key1]['start_time'] = $value1['sport_event']['start_time'];

                                          foreach($value1['statistics']['totals']['competitors'] as $competitors){
                                                if($competitors['id']==$sportradar_competitor_id){  
                                                 foreach ($competitors['players'] as   $players) {
                                                                if($players['id']==$playervalue->getPlayerapikey()){
                                                                $playerdetails[$key]['tabledata'][$key1]['statistic']=$players['statistics'];
                                                               }
                                                }                 
                                                   
                                          }
                                          else{
                                                     if(array_key_exists($competitors['id'], $teams)){
                                                        $image_path=$this->getimageuid('tx_netzmtm_domain_model_team','image',$teams[$competitors['id']]->getUid()); 
                                                        $playerdetails[$key]['tabledata'][$key1]['logo'] = $this->base_url.'/fileadmin/'.$image_path['identifier'];
                                                     }  
                                                     else{
                                                        $playerdetails[$key]['tabledata'][$key1]['logo'] ="";
                                                     }
                                                     $playerdetails[$key]['tabledata'][$key1]['competitorsname'] =$competitors['name'];
                                                }
                                          
                                          }
                                  }



                              }

                                    
                           
                                     $playerArray = array_chunk($playerdetails,2);

                                       //$data=array('playerdetails'=>$playerArray);
                                       //print_r($playerArray);die();

                                       $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
                                        $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
                                        $templatePathAndFilename = $partialRootPath . 'Api/Kader.html';
                                        $this->view->setTemplatePathAndFilename($templatePathAndFilename);
                                        
                                        $this->view->assign('kader_data', $playerArray);
                                        $output = $this->view->render();  



                    break;

                                case 'registartion':

                              ///  print_r($this->exituser('typo3testing02@gmail.com'));die();

                                        $countrylist=$this->getcounty();
                                        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
                                        $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
                                        $templatePathAndFilename = $partialRootPath . 'Api/Country.html';
                                        $this->view->setTemplatePathAndFilename($templatePathAndFilename);
                                        
                                        $this->view->assign('countrylist', $countrylist);
                                        $output = $this->view->render();
                                

                      
                                        $register = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('register');

                                        if($register){
                                        $email = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('email');
                                        $password = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('password');
                                        $gration = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('gration');
                                        $fname = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('fname');
                                        $lastname = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('lastname');
                                        $firma = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('firma');
                                        $strabe = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('strabe');
                                        $houseno = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('houseno');
                                        $additive = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('additive');
                                        $plz = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('plz');
                                        $ort = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('ort');
                                        $land = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('land');
                                        $tel = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tel');
                                        $loremvalue = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('lorem1');
                                        if($loremvalue!=''){
                                          $lorem=1;
                                        }
                                        else{
                                          $lorem=0;
                                        }

                                        $sgration = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('sgration');
                                        $sfname = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('sfname');
                                        $slname = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('slname');
                                        $sfirma = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('sfirma');
                                        $sstrabe = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('sstrabe');
                                        $shouseno = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('shouseno');
                                        $sadditive = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('sadditive');
                                        $splz = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('splz');

                                        $sort = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('sort');
                                        $sland = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('sland');
                                        ///$time=time();
                                       $checkemail= $this->exituser($email);
                                        if($checkemail==0){
                                        $data= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Netz\NetzMtmShop\Domain\Model\FrontendUser');
                                        $data->setGender($gration);
                                        $data->setUsername($email);
                                        $enpass=password_hash(utf8_encode($password),PASSWORD_ARGON2I);
                                        $data->setPassword($enpass);

                                        $userGroup = $this->userGroupRepository->findByUid(1);;
                                        $data->addUsergroup($userGroup);

                                        $data->setFirstname($fname);
                                        $data->setLastname($lastname);
                                        $data->setCompany($firma);
                                        $data->setAddress($strabe);
                                        $data->setZip($plz);
                                        $data->setCity($ort);
                                        $data->setCountry($land);
                                        $data->setTelephone($tel);
                                        $data->setHousenumber($houseno);
                                        $data->setAdditive($additive);
                                        $data->setDiffadd($lorem);

                                          $data->setSgender($sgration);
                                          $data->setSfirstname($sfname);
                                          $data->setSlastname($slname);
                                          $data->setScompany($sfirma);
                                          $data->setSaddress($sstrabe);
                                          $data->setShousenumber($shouseno);
                                          $data->setSadditive($sadditive);
                                          $data->setSzip($splz);
                                          $data->setScity($sort);
                                          $data->setScountry($sland);
                                          $data->setAppuser(1);
                                          $data->setDisable(1);
                                          $data->setPid($this->settings['appuser_pid']);


                                         $this->frontendUserRepository->add($data);
                                           $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
                                           $persistenceManager->persistAll();
                                         $sender= $this->settings['sender_email'];
                                         $attch['email']=$email;
                                         $subject='MTM APP';
                                         $templateName='Api/Emailconfirm.html';
                                         $recipient=$email;

                                         $this->sendTemplateEmail($recipient,$subject,$templateName,$sender,$attch); 
                                          $output=1;

                                         }
                                         else{
                                          $output=0;
                                         }
                                         }




                              
                    break;
                                  case 'youtubelist':
                                            $video = $this->youtubeRepository->findAll();
                                            foreach ($video as $key => $value) {
                                              $videolist[$key]['uid']=$value->getUid();
                                              $videolist[$key]['title']=$value->getTitle();
                                              $videolist[$key]['des']=$value->getDescription();
                                              $videolist[$key]['videoid']=$value->getVideoid();
                                              $videolist[$key]['image']=$this->base_url.'/uploads/netz_mtm/youtube/'.$value->getImage();
                                              $videolist[$key]['pdate']=$value->getPdate();
                                             
                                            }
                                        $slider_part= array_splice($videolist,2);
                                        array_splice($slider_part,10);
                                        $data=array('slider_part'=>$slider_part,'videolist'=>$videolist);

                                        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
                                        $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
                                        $templatePathAndFilename = $partialRootPath . 'Api/Youtubelist.html';
                                        $this->view->setTemplatePathAndFilename($templatePathAndFilename);
                                        $this->view->assign('videos', $data);
                                        $output = $this->view->render();  

                                           //print_r($videolist);die();


                    break;         
                    case 'youtubedetails':


                                     
                                      $videoid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('listid');

                                      if($videoid!=''){
                                          $detailvideo=$this->youtubeRepository->findByUid($videoid);
                                          $detailvideolist['uid']=$detailvideo->getUid();
                                          $detailvideolist['title']=$detailvideo->getTitle();
                                          $detailvideolist['des']=$detailvideo->getDescription();
                                          $detailvideolist['videoid']=$detailvideo->getVideoid();
                                          $detailvideolist['image']=$this->base_url.'/uploads/netz_mtm/youtube/'.$detailvideo->getImage();
                                          $detailvideolist['pdate']=$detailvideo->getPdate();

                                                
                                         }


                                        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
                                        $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
                                        $templatePathAndFilename = $partialRootPath . 'Api/Youtubedetails.html';
                                        $this->view->setTemplatePathAndFilename($templatePathAndFilename);
                                        $this->view->assign('detailvideolist', $detailvideolist);
                                     
                                        $output = $this->view->render();
                                          

                    break;
                    case'allvideo':



                                              $video = $this->youtubeRepository->findAll();
                                                foreach ($video as $key => $value) {
                                                  $allvideolist[$key]['uid']=$value->getUid();
                                                  $allvideolist[$key]['title']=$value->getTitle();
                                                  $allvideolist[$key]['des']=$value->getDescription();
                                                  $allvideolist[$key]['videoid']=$value->getVideoid();
                                                  $allvideolist[$key]['image']=$this->base_url.'/uploads/netz_mtm/youtube/'.$value->getImage();
                                                  $allvideolist[$key]['pdate']=$value->getPdate();       
                                                }
                                                $videocount=count($video);
                                      $data=array('allvideolist'=>$allvideolist,'videocount'=>$videocount);
                                       $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
                                       $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
                                        $templatePathAndFilename = $partialRootPath . 'Api/Allvideo.html';
                                        $this->view->setTemplatePathAndFilename($templatePathAndFilename);
                                        $this->view->assign('videolist', $data);
                                     
                                        $output = $this->view->render();
                                          

                    break;
                    case'kalender':
                      include("news.php");
                    break;
                    case'news':
                       
                            $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
                            $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
                            $templatePathAndFilename = $partialRootPath . 'Api/News.html';
                            $this->view->setTemplatePathAndFilename($templatePathAndFilename);
                            $categorys = $this->categoryRepository->findAll();
                            $categories = array();
                            foreach ($categorys as $key => $value) {
                            $categories[] = array("uid"=>$value->getUid(),"title"=>$value->getTitle(),"color"=>$value->getColor());
                            }

                            date_default_timezone_set('Europe/Berlin');
                            $options = array(); 
                            $title = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('title');
                            $options['title'] = $title;
                            $date = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('date');
                            $options['date'] = $date;
                            $categoryid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('categoryid');
                            $options['categoryid'] = $categoryid;

                            $newsData = $this->newsRepository->searchData($options);
                            $num_record = count($newsData);

                            $limit = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('limit');
                            $offset = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('offset');
                            $start_from = 0;
                            $total_pages = 0;
                            $show_more = 0;
                            if($limit!='' && $offset!=''){
                            $options['limit'] = $limit;
                            $start_from = ($offset-1) * $limit;  
                            $options['offset'] = $start_from;
                            $total_pages = ceil($num_record / $limit); 
                            if($num_record>=($start_from+$limit)){
                            $show_more = 1;
                            }
                            }


                            $newsData = $this->newsRepository->searchData($options);
                            $news = array();
                            foreach ($newsData as $value) {
                            $data = array();
                            $data['uid']=$value->getUid();
                            $data['datetime']=$value->getDatetime();
                            $data['title']=$value->getTitle();
                            foreach ($value->getFalMedia() as $media) {
                            $image_path = $this->getimageuid('tx_news_domain_model_news','fal_media',$value->getUid());
                            $data['image'] = $this->base_url.'/fileadmin/'.$image_path['identifier'];
                            break;
                            }
                            $news[]=$data;
                            }
                            $this->view->assign('news', $news);
                            $html = $this->view->render();
                            $output = array("html"=>$html,"category"=>$categories,"num_record" => $num_record,"offset"=>$start_from,"total_pages"=>$total_pages,"show_more"=>$show_more);

                    break;


                    case 'productlist':
                                          $product = $this->productRepository->findAll();
                                          foreach ($product as $key => $value) {
                                           $productlists[$key]['uid']=$value->getUid();
                                           $productlists[$key]['title']=$value->getTitle();
                                           $productlists[$key]['price']=$value->getPrice();
                                           $productlists[$key]['dprice']=$value->getDprice();
                                           $productimage_path=$this->getimageuid('tx_netzmtmshop_domain_model_product','image',$value->getUid()); 
                                            if($productimage_path){
                                               $productlists[$key]['image']=$this->base_url.'/fileadmin/'.$productimage_path['identifier'];
                                             }
                                             else{
                                               $productlists[$key]['image']=$this->base_url.'/fileadmin/templates/Website/Images/noimage.png';
                                             }
                                           $productlists[$key]['popularproduct']=$value->getPopularproduct();
                                           $productlists[$key]['discountcheckbox']=$value->getDiscountcheckbox();
                                           $productlists[$key]['newproduct']=$value->getNewproduct();
                                           

                                          }
                                          //print_r($productlists);die()

                                        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
                                        $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
                                        $templatePathAndFilename = $partialRootPath . 'Api/Productlist.html';
                                        $this->view->setTemplatePathAndFilename($templatePathAndFilename);
                                        $this->view->assign('Productlist', $productlists);
                                     
                                        $output = $this->view->render();

                                        //  print_r($productlists);die();

                    break;


                        case 'productdetails':

                                     $productid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('productid');
                                  //  $productid =1;

                                      if($productid!=''){

                                              $productdetail = $this->productRepository->findbyuid($productid);
                                              $productdetails['title']=$productdetail->getTitle();
                                              $productdetails['uid']=$productdetail->getUid();
                                              $productdetails['subtitle']=$productdetail->getSubtitle();
                                              $productdetails['sdesc']=$productdetail->getShoretdesc();
                                              $productdetails['price']=$productdetail->getPrice();
                                              $productdetails['dprice']=$productdetail->getDprice();
                                              $productdetails['discountcheckbox']=$productdetail->getDiscountcheckbox();
                                              $productimage_path=$this->getmutilpleimageuid('tx_netzmtmshop_domain_model_product','image',$productdetail->getUid()); 
                                              if($productimage_path){
                                                foreach ($productimage_path as $key => $value) {
                                                   $productdetails['image'][]=$this->base_url.'/fileadmin/'.$value['identifier'];
                                                  }
                                              }
                                              else{
                                               $productdetails['image']='';
                                              }
                                               $productdetails['show_color'] = false;
                                               $productdetails['show_size'] = false;
                                               $productdetails['show_bedruckung'] = false;



                                              foreach ($productdetail->getAttributes() as $attr) {
                                                   if(!is_null($attr->getSize())){
                                                      $productdetails['size'][$attr->getSize()->getUid()] = array('title'=>$attr->getSize()->getTitle(),'sort'=>$attr->getSize()->getSorting(),'uid'=>$attr->getSize()->getUid());
                                                   }
                                                   if(!is_null($attr->getColor())){
                                                      $productdetails['color'][$attr->getColor()->getUid()] = array('title'=>$attr->getColor()->getTitle(),'sort'=>$attr->getColor()->getSorting(),'uid'=>$attr->getColor()->getUid());
                                                   }
                                              }
                                                 $this->array_sort_by_column($productdetails['size'],'sort');
                                                 $this->array_sort_by_column($productdetails['color'],'sort');
          

                                               if(count($productdetails['size'])>0){
                                                  $attr_data =  $this->attributesRepository->getAttribute($productid,$productdetails['size'][0]['uid'],0);
                                                  foreach ($attr_data as $adata) {
                                                    $attr = $adata;
                                                    break;
                                                  }
                                               } 
                                               elseif(count($productdetails['color'])>0){
                                                   $attr_data =  $this->attributesRepository->getAttribute($productid,0,$productdetails['color'][0]['uid']);
                                                    foreach ($attr_data as $adata) {
                                                      $attr = $adata;
                                                      break;
                                                    }
                                               }
                                              // print_r($attr->getBedruckung());

                                                if(!is_null($attr)){
                                                    if(!is_null($attr->getSize())){
                                                        $productdetails['show_size'] = true;
                                                       $productdetails['sel_size'] = $attr->getSize()->getUid();
                                                    }
                                                    if(!is_null($attr->getColor())){
                                                      $productdetails['show_color'] = true;
                                                      $productdetails['sel_color'] = $attr->getColor()->getUid();
                                                    }
                                                    if(!is_null($attr->getBedruckung())){
                                                      foreach ($attr->getBedruckung() as $bedru) {
                                                         $productdetails['bedruckung'][$bedru->getUid()] = array('title'=>$bedru->getTitle(),'sort'=>$bedru->getSorting(),'uid'=>$bedru->getUid());
                                                         $productdetails['show_bedruckung'] = true;
                                                      }
                                                     $this->array_sort_by_column($productdetails['bedruckung'],'sort');
                                                    }
                                                    $productdetails['attr_id'] = $attr->getUid();
                                                    $productdetails['price'] = $attr->getPrice();
                                                    $productdetails['dprice'] = $attr->getDprice();

                                                 }
                                           


                                      }
                                
                                    //print_r($productdetails);die();
                                       $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
                                        $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
                                        $templatePathAndFilename = $partialRootPath . 'Api/Productdetails.html';
                                        $this->view->setTemplatePathAndFilename($templatePathAndFilename);
                                        $this->view->assign('productdetails', $productdetails);
                                     
                                        $output = $this->view->render();

                        break;


                          case 'productype':
                                      $colorid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('color');
                                      $sizeid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('size');
                                      $productid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('productid');
                                      $method = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('method');
                                      $productdetail = $this->productRepository->findbyuid($productid);
                                      $bedruid =\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('bedru');
                                       $show_size = false;
                                       $show_color = false;
                                       $show_bedruckung = false;

                                      foreach ($productdetail->getAttributes() as $attr) {
                                             if(!is_null($attr->getSize())){
                                               $size[$attr->getSize()->getUid()] = array('title'=>$attr->getSize()->getTitle(),'sort'=>$attr->getSize()->getSorting(),'uid'=>$attr->getSize()->getUid());
                                             }
                                             if(!is_null($attr->getColor())){
                                               $color[$attr->getColor()->getUid()] = array('title'=>$attr->getColor()->getTitle(),'sort'=>$attr->getColor()->getSorting(),'uid'=>$attr->getColor()->getUid());
                                             }
                                          }
                                           $this->array_sort_by_column($size,'sort');
                                           $this->array_sort_by_column($color,'sort');
                                              if($sizeid>0 && $method=='size'){
                                                  $attr_data =  $this->attributesRepository->getAttribute($productid,$sizeid);
                                                  foreach ($attr_data as $adata) {
                                                    $attr = $adata;
                                                    break;
                                                  }
                                              }
                                              if($colorid>0 && $method=='color'){
                                                  $attr_data =  $this->attributesRepository->getAttribute($productid,0,$colorid);
                                                  foreach ($attr_data as $adata) {
                                                    $attr = $adata;
                                                    break;
                                                  }
                                              }

                                              if(!is_null($attr)){
                                                    if(!is_null($attr->getSize())){
                                                        $show_size = true;
                                                        $sel_size = $attr->getSize()->getUid();

                                                    }
                                                    if(!is_null($attr->getColor())){
                                                       $show_color = true;
                                                       $sel_color = $attr->getColor()->getUid();

                                                    }
                                                    if(!is_null($attr->getBedruckung())){
                                                      foreach ($attr->getBedruckung() as $bedru) {
                                                         $bedruckung[$bedru->getUid()] = array('title'=>$bedru->getTitle(),'sort'=>$bedru->getSorting(),'uid'=>$bedru->getUid());
                                                         $show_bedruckung = true;
                                                      }
                                                      $this->array_sort_by_column($bedruckung,'sort');
                                                    }
                                                    $price = number_format($attr->getPrice(),2,",",".").'€';
                                                    $attr_id = $attr->getUid();
                                                    $dprice =number_format($attr->getDprice(),2,",",".").'€';

                                            }
                                        if($bedruid==0){
                                          $bedruselected='selected';
                                        }
                                       
                                        foreach ($bedruckung as $key => $bedruckungvalue) {
                                         $bedrudata1 ='<option value="'.$bedruckungvalue['uid'].'"';

                                         if($bedruckungvalue['uid']==$bedruid){
                                          $bedrudata2='selected';
                                          }
                                          else{
                                            $bedrudata2='';
                                          }

                                         $bedrudata3=' >'.$bedruckungvalue['title'].'</option>';
                                         $bedrudata[]=$bedrudata1.$bedrudata2.$bedrudata3;
                                          }
                                          $bedrudata[]='<option value="0"'. $bedruselected.'>Individuelle Beflockung</option>';

                                        foreach ($color as $key => $colorvalue) {
                                         $colordata1='<option value="'.$colorvalue['uid'].'"';
                                          if($colorvalue['uid']==$sel_color){
                                          $colordata2='selected';
                                          }
                                          else{
                                            $colordata2='';
                                          }

                                          $colordata3= '>'.$colorvalue['title'].'</option>';
                                         $colordata[]=$colordata1.$colordata2.$colordata3;
                                         
                                          }

                                      foreach ($size as $key => $sizevalue) {
                                         $sizedata1='<option value="'.$sizevalue['uid'].'"';
                                          if($sizevalue['uid']==$sel_color){
                                          $sizedata2='selected';
                                          }
                                          else{
                                            $sizedata2='';
                                          }

                                          $sizedata3= '>'.$sizevalue['title'].'</option>';
                                         $sizedata[]=$sizedata1.$sizedata2.$sizedata3;
                                         
                                          }
                                            
                                        $data=array('bedrudata'=>$bedrudata,'colordata'=>$colordata,'sizedata'=>$sizedata,'dprice'=>$dprice,'price'=>$price,'attr_id'=>$attr_id,'show_bedruckung'=>$show_bedruckung,'show_size'=>$show_size,'show_color'=>$show_color);

                                        $output=$data;
                                        




                          break;





                }
                echo json_encode($output);
                die();
            }

       
       }


    /**
     * action nmatchapp
     *
     * @return void
     */
    public function nmatchappAction()
    {
           date_default_timezone_set('Europe/Berlin');
            $sportradar_competitor_id= $this->settings['sportradar_competitor_id'];
            $options = array('competitor_id'=>$sportradar_competitor_id);
            $data_summaries = $this->getSportradarData('summaries',$options); 

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
                        $date= date("Y-m-d", strtotime($value['start_time']));
                        $dayOfWeek = date("D", strtotime($date));

                        $next_match['city']=$value['venue']['city_name'];
                        $next_match['venue']=$value['venue']['name'];
                        $next_match['dayOfWeek']=$dayOfWeek;

                        $next_match['date']=$value['start_time'];
                        $next_match['competitors']=$value['competitors'];
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
     * action activateuser
     *
     * @return void
     */
      public function activateuserAction()
    {
                  $user = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('user');
                  if($user!=''){
                   // echo $user;die();
                    $this->userenable($user);
                    $this->view->assign('data', $data);

                    //echo $user; die();

                  }

    }

     protected function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
            $sort_col = array();
            foreach ($arr as $key=> $row) {
                $sort_col[$key] = $row[$col];
            }
            array_multisort($sort_col, $dir, $arr);
    }  

     




}
