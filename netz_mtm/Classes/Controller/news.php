<?php
      
      $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
      $partialRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);

      echo"s";
      $templatePathAndFilename = $partialRootPath . 'Api/News.html';
      $this->view->setTemplatePathAndFilename($templatePathAndFilename);
      $categorys = $this->categoryRepository->findAll();
      $this->view->assign('categorys', $categorys);
      date_default_timezone_set('Europe/Berlin');
      $options = array(); 
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
          break;;
        }
        $news[]=$data;
      }
      $this->view->assign('news', $news);
      $output = $this->view->render();
?>