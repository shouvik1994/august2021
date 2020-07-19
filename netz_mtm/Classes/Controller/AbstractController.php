<?php
namespace Netz\NetzMtm\Controller;
use TYPO3\CMS\Core\Utility\GeneralUtility;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Aftab Alam <aftab.alam@netzrezepte.de>, Netz
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * AbstractController
 */
class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{


    /**
     * partnerRepository
     *
     * @var \Netz\NetzMtm\Domain\Repository\PartnerRepository
     * @inject
     */
    protected $partnerRepository = null;

      /**
     * youtubeRepository
     *
     * @var \Netz\NetzMtm\Domain\Repository\YoutubeRepository
     * @inject
     */
    protected $youtubeRepository = null;

     /**
     * playerRepository
     *
     * @var \Netz\NetzMtm\Domain\Repository\PlayerRepository
     * @inject
     */
    protected $playerRepository = null;

    /**
     * competitionRepository
     *
     * @var \Netz\NetzMtm\Domain\Repository\CompetitionRepository
     * @inject
     */
    protected $competitionRepository = null;

    /**
     * seasonRepository
     *
     * @var \Netz\NetzMtm\Domain\Repository\SeasonRepository
     * @inject
     */
    protected $seasonRepository = null;

    /**
     * teamRepository
     *
     * @var \Netz\NetzMtm\Domain\Repository\TeamRepository
     * @inject
     */
    protected $teamRepository = null;

    /**
     * categoryRepository
     *
     * @var \Netz\NetzMtm\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository = null;
    /**
     * newsRepository
     *
     * @var \Netz\NetzMtm\Domain\Repository\NewsRepository
     * @inject
     */
    protected $newsRepository = null;

      /**
     * frontendUserRepository
     *
     * @var \Netz\NetzMtmShop\Domain\Repository\FrontendUserRepository

     * @inject
     */
    protected $frontendUserRepository = null;


            /**
         * userGroupRepository
         *
         * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
         * @inject
         */
        protected $userGroupRepository = null;

         /**
     * productRepository
     *
     * @var \Netz\NetzMtmShop\Domain\Repository\ProductRepository
     * @inject
     */
    protected $productRepository = null;


     /**
     * groupproductRepository
     *
     * @var \Netz\NetzMtmShop\Domain\Repository\GroupproductRepository
     * @inject
     */
    protected $groupproductRepository = null;


     
  
    /**
     * attributesRepository
     *
     * @var \Netz\NetzMtmShop\Domain\Repository\AttributesRepository

     * @inject
     */
    protected $attributesRepository = null;

    /**
     * bedruckungRepository
     *
     * @var \Netz\NetzMtmShop\Domain\Repository\BedruckungRepository

     * @inject
     */
    protected $bedruckungRepository = null;


/**
     * colorRepository
     *
     * @var \Netz\NetzMtmShop\Domain\Repository\ColorRepository

     * @inject
     */
    protected $colorRepository = null;

    /**
     * sizeRepository
     *
     * @var \Netz\NetzMtmShop\Domain\Repository\SizeRepository

     * @inject
     */
    protected $sizeRepository = null;


     /**
     * odiscountRepository
     *
     * @var \Netz\NetzMtmShop\Domain\Repository\OdiscountRepository

     * @inject
     */
    protected $odiscountRepository = null;

     /**
     * orderaddRepository
     *
     * @var \Netz\NetzMtmShop\Domain\Repository\OrderaddRepository

     * @inject
     */
    protected $orderaddRepository = null;

     /**
     * OrderitemRepository
     *
     * @var \Netz\NetzMtmShop\Domain\Repository\OrderitemRepository

     * @inject
     */
    protected $orderitemRepository = null;

     /**
     * sorderRepository
     *
     * @var \Netz\NetzMtmShop\Domain\Repository\SorderRepository

     * @inject
     */
    protected $sorderRepository = null;

   

    /**
     * discountRepository
     *
     * @var \Netz\NetzMtmShop\Domain\Repository\DiscountRepository

     * @inject
     */
    protected $discountRepository = null;




    protected $apiUrl = "https://api.sportradar.com/handball";     


    public function getSportradarData($api_type,$options){
            $data = array();
            $url = '';
            $sportradar_access =  $this->settings['sportradar_access'];
            $sportradar_access_type = 'trial';
            if($sportradar_access){
                $sportradar_access_type = 'production';
            }
            
            $sportradar_access_key= $this->settings['sportradar_access_key'];
            $sportradar_competitor_id= $this->settings['sportradar_competitor_id'];    
            switch ($api_type) {
                case 'standings':
                    $url = $this->apiUrl."/".$sportradar_access_type."/v2/de/seasons/".$options['session_api_key']."/standings.json?api_key=".$sportradar_access_key;
                                    //echo $url;

                    break;
                case 'summaries':
                    $url = $this->apiUrl."/".$sportradar_access_type."/v2/de/competitors/".$options['competitor_id']."/summaries.json?api_key=".$sportradar_access_key;
                    break;
                 case 'playersummaries':
                    $url = $this->apiUrl."/".$sportradar_access_type."/v2/de/players/".$options['player_api_id']."/summaries.json?api_key=".$sportradar_access_key;
                    break;

                default:
                    # code...
                    break;
            }
           
            if($url!=''){
                $cache_path = PATH_site . 'uploads/netz_mtm/';
                $filename = $cache_path.md5($url);
                if( file_exists($filename) && ( time() - 108000 < filemtime($filename) ) )
                {
                    $data = json_decode(file_get_contents($filename), true);
                }
                else
                {
                    sleep(4);
                    $json_data = file_get_contents($url);
                    file_put_contents($filename, $json_data);
                    if(!is_null($data) || is_array($data)){
                        $data = json_decode($json_data, true);
                    }
                }
            }
            return $data;
    }



       /**
     * 
     *
     * @param string $pathAndName
     * @return string
     */
    protected function getimageuid($value,$value1,$uid)
    {
        $queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Database\ConnectionPool')->getQueryBuilderForTable('sys_file');
       $data= $queryBuilder
        ->select('identifier')
        ->from('sys_file')
        ->join(
              'sys_file',
              'sys_file_reference',
              'sfr',
              $queryBuilder->expr()->eq('sys_file.uid', 'sfr.uid_local')
           )
        ->where(
        $queryBuilder->expr()->eq('sfr.uid_foreign', $uid),
        $queryBuilder->expr()->eq('sfr.deleted', 0),
        $queryBuilder->expr()->like('sfr.tablenames', $queryBuilder->createNamedParameter($value)),
        $queryBuilder->expr()->like('sfr.fieldname', $queryBuilder->createNamedParameter($value1))


        )
        ->execute()
        ->fetch();


        return $data;
    }

      /**
     * 
     *
     * @param string $pathAndName
     * @return string
     */
    protected function getmutilpleimageuid($value,$value1,$uid)
    {
        $queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Database\ConnectionPool')->getQueryBuilderForTable('sys_file');
       $data= $queryBuilder
        ->select('identifier')
        ->from('sys_file')
        ->join(
              'sys_file',
              'sys_file_reference',
              'sfr',
              $queryBuilder->expr()->eq('sys_file.uid', 'sfr.uid_local')
           )
        ->where(
        $queryBuilder->expr()->eq('sfr.uid_foreign', $uid),
        $queryBuilder->expr()->eq('sfr.deleted', 0),
        $queryBuilder->expr()->like('sfr.tablenames', $queryBuilder->createNamedParameter($value)),
        $queryBuilder->expr()->like('sfr.fieldname', $queryBuilder->createNamedParameter($value1))


        )
        ->execute()
        ->fetchAll();


        return $data;
    }

     public function calculateTime($times) {
        $i = 0;
        foreach ($times as $time) {
            sscanf($time, '%d:%d', $hour, $min);
            $i += $hour * 60 + $min;
        }

        if($h = floor($i / 60)) {
            $i %= 60;
        }

        return sprintf('%02d:%02d', $h, $i);
    }


    public function getcounty(){
        $countrylist=array(
           'AND' => 'Andorra',
        'ARE' => 'الإمارات العربيّة المتّحدة',
        'AFG' => 'افغانستان',
        'ATG' => 'Antigua and Barbuda',
        'AIA' => 'Anguilla',
        'ALB' => 'Shqipëria',
        'ARM' => 'Հայաստան',
        'ANT' => 'Nederlandse Antillen',
        'AGO' => 'Angola',
        'ATA' => 'Antarctica',
        'ARG' => 'Argentina',
        'ASM' => 'Amerika Samoa',
        'AUT' => 'Österreich',
        'AUS' => 'Australia',
        'ABW' => 'Aruba',
        'AZE' => 'Azərbaycan',
        'BIH' => 'BiH/БиХ',
        'BRB' => 'Barbados',
        'BGD' => 'বাংলাদেশ',
        'BEL' => 'Belgique',
        'BFA' => 'Burkina',
        'BGR' => 'България (Bulgaria)',
        'BHR' => 'البحري',
        'BDI' => 'Burundi',
        'BEN' => 'Bénin',
        'BMU' => 'Bermuda',
        'BRN' => 'دارالسلام',
        'BOL' => 'Bolivia',
        'BRA' => 'Brasil',
        'BHS' => 'The Bahamas',
        'BTN' => 'Druk-Yul',
        'BVT' => 'Bouvet Island',
        'BWA' => 'Botswana',
        'BLR' => 'Беларусь',
        'BLZ' => 'Belize',
        'CAN' => 'Canada',
        'CCK' => 'Cocos (Keeling) Islands',
        'COD' => 'Congo',
        'CAF' => 'Centrafrique',
        'COG' => 'Congo-Brazzaville',
        'CHE' => 'Schweiz',
        'CIV' => 'Côte d’Ivoire',
        'COK' => 'Cook Islands',
        'CHL' => 'Chile',
        'CMR' => 'Cameroun',
        'CHN' => '中华',
        'COL' => 'Colombia',
        'CRI' => 'Costa Rica',
        'CUB' => 'Cuba',
        'CPV' => 'Cabo Verde',
        'CXR' => 'Christmas Island',
        'CYP' => 'Κύπρος / Kıbrıs',
        'CZE' => 'Česko',
        'DEU' => 'Deutschland',
        'DJI' => 'Djibouti',
        'DNK' => 'Danmark',
        'DMA' => 'Dominica',
        'DOM' => 'Quisqueya',
        'DZA' => 'الجزائ',
        'ECU' => 'Ecuador',
        'EST' => 'Eesti',
        'EGY' => 'مصر',
        'ESH' => 'الصحراء الغربي',
        'ERI' => 'ኤርትራ',
        'ESP' => 'España',
        'ETH' => 'ኢትዮጵያ',
        'FIN' => 'Suomi',
        'FJI' => 'Fiji / Viti',
        'FLK' => 'Falkland Islands',
        'FSM' => 'Micronesia',
        'FRO' => 'Føroyar / Færøerne',
        'FRA' => 'France',
        'GAB' => 'Gabon',
        'GBR' => 'United Kingdom',
        'GRD' => 'Grenada',
        'GEO' => 'საქართველო',
        'GUF' => 'Guyane française',
        'GHA' => 'Ghana',
        'GIB' => 'Gibraltar',
        'GRL' => 'Grønland',
        'GMB' => 'Gambia',
        'GIN' => 'Guinée',
        'GLP' => 'Guadeloupe',
        'GNQ' => 'Guinea Ecuatorial',
        'GRC' => 'Ελλάδα',
        'SGS' => 'South Georgia and the South Sandwich Islands',
        'GTM' => 'Guatemala',
        'GUM' => 'Guåhån',
        'GNB' => 'Guiné-Bissau',
        'GUY' => 'Guyana',
        'HKG' => '香港',
        'HND' => 'Honduras',
        'HRV' => 'Hrvatska',
        'HTI' => 'Ayiti',
        'HUN' => 'Magyarország',
        'IDN' => 'Indonesia',
        'IRL' => 'Éire',
        'ISR' => 'ישראל',
        'IND' => 'India',
        'IOT' => 'British Indian Ocean Territory',
        'IRQ' => 'العراق / عيَراق',
        'IRN' => 'ايران',
        'ISL' => 'Ísland',
        'ITA' => 'Italia',
        'JAM' => 'Jamaica',
        'JOR' => 'أردنّ',
        'JPN' => '日本',
        'KEN' => 'Kenya',
        'KGZ' => 'Кыргызстан',
        'KHM' => 'Kâmpŭchea',
        'KIR' => 'Kiribati',
        'COM' => 'اتحاد القمر',
        'KNA' => 'Saint Kitts and Nevis',
        'PRK' => '북조선',
        'KOR' => '한국',
        'KWT' => 'الكويت',
        'CYM' => 'Cayman Islands',
        'KAZ' => 'Қазақстан /Казахстан',
        'LAO' => 'ເມືອງລາວ',
        'LBN' => 'لبنان',
        'LCA' => 'Saint Lucia',
        'LIE' => 'Liechtenstein',
        'LKA' => 'ශ්‍රී ලංකා / இலங்கை',
        'LBR' => 'Liberia',
        'LSO' => 'Lesotho',
        'LTU' => 'Lietuva',
        'LUX' => 'Luxemburg',
        'LVA' => 'Latvija',
        'LBY' => 'ليبيا',
        'MAR' => 'المغربية',
        'MCO' => 'Monaco',
        'MDA' => 'Moldova',
        'MDG' => 'Madagascar',
        'MHL' => 'Marshall Islands',
        'MKD' => 'Македонија',
        'MLI' => 'Mali',
        'MMR' => 'Myanmar',
        'MNG' => 'Монгол Улс',
        'MAC' => '澳門 / Macau',
        'MNP' => 'Northern Marianas',
        'MTQ' => 'Martinique',
        'MRT' => 'الموريتانية',
        'MSR' => 'Montserrat',
        'MLT' => 'Malta',
        'MUS' => 'Mauritius',
        'MDV' => 'ޖުމުހޫރިއްޔ',
        'MWI' => 'Malawi',
        'MEX' => 'México',
        'MYS' => 'مليسيا',
        'MOZ' => 'Moçambique',
        'NAM' => 'Namibia',
        'NCL' => 'Nouvelle-Calédonie',
        'NER' => 'Niger',
        'NFK' => 'Norfolk Island',
        'NGA' => 'Nigeria',
        'NIC' => 'Nicaragua',
        'NLD' => 'Nederland',
        'NOR' => 'Norge',
        'NPL' => 'नेपाल',
        'NRU' => 'Naoero',
        'NIU' => 'Niue',
        'NZL' => 'New Zealand / Aotearoa',
        'OMN' => 'عُمان',
        'PAN' => 'Panamá',
        'PER' => 'Perú',
        'PYF' => 'Polynésie française',
        'PNG' => 'Papua New Guinea  / Papua Niugini',
        'PHL' => 'Philippines',
        'PAK' => 'پاکستان',
        'POL' => 'Polska',
        'SPM' => 'Saint-Pierre-et-Miquelon',
        'PCN' => 'Pitcairn Islands',
        'PRI' => 'Puerto Rico',
        'PRT' => 'Portugal',
        'PLW' => 'Belau / Palau',
        'PRY' => 'Paraguay',
        'QAT' => 'قطر',
        'REU' => 'Réunion',
        'ROU' => 'România',
        'RUS' => 'Россия',
        'RWA' => 'Rwanda',
        'SAU' => 'السعودية',
        'SLB' => 'Solomon Islands',
        'SYC' => 'Seychelles',
        'SDN' => 'Sénégal',
        'SWE' => 'Sverige',
        'SGP' => 'Singapore',
        'SHN' => 'Saint Helena, Ascension and Tristan da Cunha',
        'SVN' => 'Slovenija',
        'SJM' => 'Svalbard',
        'SVK' => 'Slovensko',
        'SLE' => 'Sierra Leone',
        'SMR' => 'San Marino',
        'SEN' => 'Sénégal',
        'SOM' => 'Soomaaliya',
        'SUR' => 'Suriname',
        'STP' => 'São Tomé e Príncipe',
        'SLV' => 'El Salvador',
        'SYR' => 'سوري',
        'SWZ' => 'weSwatini',
        'TCA' => 'Turks and Caicos Islands',
        'TCD' => 'Tchad',
        'ATF' => 'Terres australes fran‡aises',
        'TGO' => 'Togo',
        'THA' => 'ไทย',
        'TJK' => 'Тоҷикистон',
        'TKL' => 'Tokelau',
        'TKM' => 'Türkmenistan',
        'TUN' => 'التونسية',
        'TON' => 'Tonga',
        'TLS' => 'Timor Lorosa\'e',
        'TUR' => 'Türkiye',
        'TTO' => 'Trinidad and Tobago',
        'TUV' => 'Tuvalu',
        'TWN' => '中華',
        'TZA' => 'Tanzania',
        'UKR' => 'Україна',
        'UGA' => 'Uganda',
        'UMI' => 'United States Minor Outlying Islands',
        'USA' => 'United States',
        'URY' => 'Uruguay',
        'UZB' => 'O‘zbekiston',
        'VAT' => 'Vaticano',
        'VCT' => 'Saint Vincent and the Grenadines',
        'VEN' => 'Venezuela',
        'VGB' => 'British Virgin Islands',
        'VIR' => 'US Virgin Islands',
        'VNM' => 'Việt Nam',
        'VUT' => 'Vanuatu',
        'WLF' => 'Wallis and Futuna',
        'WSM' => 'Samoa',
        'YEM' => 'اليمنية',
        'MYT' => 'Mayotte',
        'ZAF' => 'Afrika-Borwa',
        'ZMB' => 'Zambia',
        'ZWE' => 'Zimbabwe',
        'PSE' => 'فلسطين',
        'CSG' => 'Србија и Црна Гора',
        'ALA' => 'Åland',
        'HMD' => 'Heard Island and McDonald Islands',
        'MNE' => 'Crna Gora',
        'SRB' => 'Srbija',
        'JEY' => 'Jersey',
        'GGY' => 'Guernsey',
        'IMN' => 'Mann / Mannin',
        'MAF' => 'Saint-Martin',
        'BLM' => 'Saint-Barthélemy',
        'BES' => 'Bonaire, Sint Eustatius en Saba',
        'CUW' => 'Curaçao',
        'SXM' => 'Sint Maarten',
        'SSD' => 'South Sudan'
    );
    return $countrylist;
    }



       /**
     * 
     *
     * @param string $pathAndName
     * @return string
     */
    protected function exituser($email)
    {
        $queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Database\ConnectionPool')->getQueryBuilderForTable('fe_users');
       $data= $queryBuilder
        ->count('uid')
        ->from('fe_users')
        ->where(
        $queryBuilder->expr()->like('username', $queryBuilder->createNamedParameter($email))
        )
        ->execute()
       ->fetchColumn(0);


        return $data;
    }

         /**
     * 
     *
     * @param string $pathAndName
     * @return string
     */
    protected function userenable($email)
    {
       $queryBuilder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Database\ConnectionPool')->getQueryBuilderForTable('fe_users');       
       $queryBuilder
       ->update('fe_users')
       ->where(
          $queryBuilder->expr()->like('username', $queryBuilder->createNamedParameter($email))
        )
       ->set('disable', 0)
       ->execute();
    }

      /**
     * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
     * @param string $subject subject of the email
     * @param string $templateName template name (UpperCamelCase)
     * @param array $sender sender of the email in the format array('email@domain.com' => 'Sender Name')
     * @param array $variables variables to be passed to the Fluid view
     * @param string $emailType email type html/text
     * @param array $attachments
     * @return boolean TRUE on success, otherwise false
     */
    public function sendTemplateEmail( $recipient, $subject, $templateName,  $sender, array $variables = array(), $emailType='html', $attachments=array()) {
        
        $emailView = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
    
        // Template path
        $templateRootPath = GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths'][0]);
        $templatePathAndFilename = $templateRootPath . $templateName;
        
       
        $emailView->setTemplatePathAndFilename($templatePathAndFilename);
        $emailView->assignMultiple($variables);
        $emailBody = $emailView->render();
        

        // Message
        $message = $this->objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        $message->setTo($recipient)
        ->setFrom($sender)
        ->setSubject($subject);
    
        // Possible attachments here
        if(count($attachments) > 0){
            foreach ($attachments as $attachment) {
                $message->attach($attachment);
            }
        }
    
        // HTML/Plain Email
        if($emailType=='html'){
            $message->setBody($emailBody, 'text/html');
        } else {
            $message->setBody($emailBody, 'text/plain');
        }
    
        $message->send();
        return $message->isSent();
        
    }
    
 
    
  }