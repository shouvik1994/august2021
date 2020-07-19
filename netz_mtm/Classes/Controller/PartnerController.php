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
 * PartnerController
 */
class PartnerController extends \Netz\NetzMtm\Controller\AbstractController 
{
    

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $partners = $this->partnerRepository->findAll();
        $this->view->assign('partners', $partners);
    }

}
