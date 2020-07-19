<?php
namespace Netz\NetzMtm\Util;
class MtmUtil {
      public function youtubeImport($youtubeKey,$youtubeChannelId,$pid){
       
      $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');
      $youtubeRepository= $objectManager->get('Netz\NetzMtm\Domain\Repository\YoutubeRepository');
      

      $maxResults = 50;
      $baseUrl = 'https://www.googleapis.com/youtube/v3/';
      $params = [
        'id'=> $youtubeChannelId,
        'part'=> 'contentDetails',
        'key'=> $youtubeKey
      ];
      $url = $baseUrl . 'channels?' . http_build_query($params);
      $json = json_decode(file_get_contents($url), true);

    $playlist = $json['items'][0]['contentDetails']['relatedPlaylists']['uploads'];

    $params = [
        'part'=> 'snippet',
        'playlistId' => $playlist,
        'maxResults'=> $maxResults,
        'key'=> $youtubeKey
    ];
    $url = $baseUrl . 'playlistItems?' . http_build_query($params);
    $json = json_decode(file_get_contents($url), true);

    $items = [];
    foreach($json['items'] as $video){
          $data = array();
          $data['pdate'] = $video['snippet']['publishedAt'];
          $data['id'] = $video['snippet']['resourceId']['videoId'];
          $data['title'] = $video['snippet']['title'];
          $data['description'] = $video['snippet']['description'];
          if($video['snippet']['thumbnails']['standard']['url']==''){
              $data['image'] =  $video['snippet']['thumbnails']['high']['url'];
          }
          else{
             $data['image'] = $video['snippet']['thumbnails']['standard']['url'];
          }
          $items[] = $data;
    }
        

    while(isset($json['nextPageToken'])){
          $nextUrl = $url . '&pageToken=' . $json['nextPageToken'];
          $json = json_decode(file_get_contents($nextUrl), true);
          foreach($json['items'] as $video){
            $data = array();
            $data['pdate'] = $video['snippet']['publishedAt'];
            $data['id'] = $video['snippet']['resourceId']['videoId'];
            $data['title'] = $video['snippet']['title'];
            $data['description'] = $video['snippet']['description'];
            if($video['snippet']['thumbnails']['standard']['url']==''){
                $data['image'] =  $video['snippet']['thumbnails']['high']['url'];
            }
            else{
               $data['image'] = $video['snippet']['thumbnails']['standard']['url'];
            }
            $items[] = $data;
        }
    }
    // print_r($items);
    // die();
          foreach ($items as $value) {
                $pdate = new \DateTime($value['pdate']);
                $pro = $youtubeRepository->findByVideoid($value['id'])->getFirst();
                if(!is_object($pro)){
                      $data= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Netz\NetzMtm\Domain\Model\Youtube'); 
                       $data->setTitle($value['title']);
                       $data->setDescription($value['description']);
                       $data->setVideoid($value['id']);
                       $data->setPid($pid);
                       $data->setPdate($pdate);
                        $imageName = $value['id'].'.jpg';
                        $image = file_get_contents($value['image']);
                        if(!empty($image)){
                            $imagePath =  PATH_site . 'uploads/netz_mtm/youtube/'. $imageName;
                            $objfile = fopen($imagePath, "w") or die("Unable to open file!");
                            fwrite($objfile, $image);
                            fclose($objfile);
                            $data->setImage($imageName);
                        }
                       $youtubeRepository->add($data);  
                       $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
                       $persistenceManager->persistAll();  
                  }
         }
           return true;
      }


      public function sportradarImport($accessLevel,$sportradarKey,$competitorId,$settings){

          $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

      $competitionRepository = $objectManager->get('Netz\NetzMtm\Domain\Repository\CompetitionRepository');
      $seasonRepository = $objectManager->get('Netz\NetzMtm\Domain\Repository\SeasonRepository');
      $playerRepository = $objectManager->get('Netz\NetzMtm\Domain\Repository\PlayerRepository');
      $teamRepository = $objectManager->get('Netz\NetzMtm\Domain\Repository\TeamRepository');

        $url = "https://api.sportradar.com/handball/".$accessLevel."/v2/de/competitors/".$competitorId."/summaries.json?api_key=".$sportradarKey;
        $items = json_decode(file_get_contents($url), true);
        $competitions = array();
        $seasons = array();
        $competitors = array();
        foreach ($items['summaries'] as  $value) {
          $competitions[$value['sport_event']['sport_event_context']['competition']['id']]=$value['sport_event']['sport_event_context']['competition'];
          $seasons[$value['sport_event']['sport_event_context']['season']['id']]=$value['sport_event']['sport_event_context']['season'];
          $competitors[$value['sport_event']['competitors'][0]['id']]=$value['sport_event']['competitors'][0];
          $competitors[$value['sport_event']['competitors'][1]['id']]=$value['sport_event']['competitors'][1];
        }

        foreach ($competitions as $value) {
          
            $pro = $competitionRepository->findByApikey($value['id'])->getFirst();
            if(!is_object($pro)){
                  $data= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Netz\NetzMtm\Domain\Model\Competition'); 
                   $data->setTitle($value['name']);
                   $data->setApikey($value['id']);
                   $data->setPid($settings['api_pid']);
                   $competitionRepository->add($data);  
                   $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
                   $persistenceManager->persistAll();  
              }
              else{
                
                $pro->setTitle($value['name']);
                $competitionRepository->update($pro);
                $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
                $persistenceManager->persistAll();
              }

        }
        foreach ($competitors as $value) {
          
            $pro = $teamRepository->findByTeamapikey($value['id'])->getFirst();
            if(!is_object($pro)){
                  $data= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Netz\NetzMtm\Domain\Model\Team'); 
                   $data->setTitle($value['name']);
                   $data->setTeamapikey($value['id']);
                   $data->setPid($settings['team_pid']);
                   $teamRepository->add($data);  
                   $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
                   $persistenceManager->persistAll();  
              }
               else{
                
                $pro->setTitle($value['name']);
                $teamRepository->update($pro);
                $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
                $persistenceManager->persistAll();
              }
          
        }
        foreach ($seasons as $value) {
            $pro = $seasonRepository->findByApikey($value['id'])->getFirst();
              if(!is_object($pro)){
                    $data= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Netz\NetzMtm\Domain\Model\Season'); 
                     $data->setTitle($value['name']);
                     $data->setApikey($value['id']);
                     $data->setYear($value['year']);
                     $data->setPid($settings['api_pid']);
                     $start_date = new \DateTime($value['start_date']);
                     $end_date = new \DateTime($value['end_date']);
                     $data->setSdate($start_date);
                     $data->setEdate($end_date);
                     $seasonRepository->add($data);
                    
                     $competition = $competitionRepository->findByApikey($value['competition_id'])->getFirst();
                     $competition->addSeason($data);
                     $competitionRepository->update($competition);  
                     $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
                     $persistenceManager->persistAll();  
                }
                else{
                
                $pro->setTitle($value['name']);
                $seasonRepository->update($pro);
                $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
                $persistenceManager->persistAll();
              }

        }
        sleep(4);
        $url = "https://api.sportradar.com/handball/".$accessLevel."/v2/de/competitors/".$competitorId."/profile.json?api_key=".$sportradarKey;
        $items = json_decode(file_get_contents($url), true);
        foreach ($items['players'] as $value) {
          
          $pro = $playerRepository->findByPlayerapikey($value['id'])->getFirst();
          if(!is_object($pro)){
                $data= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Netz\NetzMtm\Domain\Model\Player'); 
                   $name  = explode(", ", $value['name']);
                   $data->setFirstname($name[1]);
                   $data->setLastname($name[0]);
                   $data->setPlayerapikey($value['id']);
                   $data->setPid($settings['player_pid']);
                   $data->setNationlity($value['nationality']);
                   $data->setSize($value['height']);
                   $data->setWeight($value['weight']);
                   $data->setPlayernumber($value['jersey_number']);
                   $data->setPosition($value['type']);
                   $date_of_birth = new \DateTime($value['date_of_birth']);
                   $data->setDob($date_of_birth);
                   $playerRepository->add($data);  
                   $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
                   $persistenceManager->persistAll();  
            }
            else{
                $name  = explode(", ", $value['name']);
                $pro->setFirstname($name[1]);
                $pro->setLastname($name[0]);
                $pro->setSize($value['height']);
                $pro->setWeight($value['weight']);
                $pro->setPlayernumber($value['jersey_number']);
                $pro->setPosition($value['type']);
                $playerRepository->update($pro);
                $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
                $persistenceManager->persistAll();
          }
        
        }


           return true;
      }
}
?>