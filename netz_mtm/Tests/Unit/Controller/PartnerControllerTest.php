<?php
namespace Netz\NetzMtm\Tests\Unit\Controller;

/**
 * Test case.
 */
class PartnerControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Netz\NetzMtm\Controller\PartnerController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Netz\NetzMtm\Controller\PartnerController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllPartnersFromRepositoryAndAssignsThemToView()
    {

        $allPartners = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $partnerRepository = $this->getMockBuilder(\Netz\NetzMtm\Domain\Repository\PartnerRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $partnerRepository->expects(self::once())->method('findAll')->will(self::returnValue($allPartners));
        $this->inject($this->subject, 'partnerRepository', $partnerRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('partners', $allPartners);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }

    /**
     * @test
     */
    public function showActionAssignsTheGivenPartnerToView()
    {
        $partner = new \Netz\NetzMtm\Domain\Model\Partner();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('partner', $partner);

        $this->subject->showAction($partner);
    }

    /**
     * @test
     */
    public function createActionAddsTheGivenPartnerToPartnerRepository()
    {
        $partner = new \Netz\NetzMtm\Domain\Model\Partner();

        $partnerRepository = $this->getMockBuilder(\Netz\NetzMtm\Domain\Repository\PartnerRepository::class)
            ->setMethods(['add'])
            ->disableOriginalConstructor()
            ->getMock();

        $partnerRepository->expects(self::once())->method('add')->with($partner);
        $this->inject($this->subject, 'partnerRepository', $partnerRepository);

        $this->subject->createAction($partner);
    }

    /**
     * @test
     */
    public function editActionAssignsTheGivenPartnerToView()
    {
        $partner = new \Netz\NetzMtm\Domain\Model\Partner();

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects(self::once())->method('assign')->with('partner', $partner);

        $this->subject->editAction($partner);
    }

    /**
     * @test
     */
    public function updateActionUpdatesTheGivenPartnerInPartnerRepository()
    {
        $partner = new \Netz\NetzMtm\Domain\Model\Partner();

        $partnerRepository = $this->getMockBuilder(\Netz\NetzMtm\Domain\Repository\PartnerRepository::class)
            ->setMethods(['update'])
            ->disableOriginalConstructor()
            ->getMock();

        $partnerRepository->expects(self::once())->method('update')->with($partner);
        $this->inject($this->subject, 'partnerRepository', $partnerRepository);

        $this->subject->updateAction($partner);
    }

    /**
     * @test
     */
    public function deleteActionRemovesTheGivenPartnerFromPartnerRepository()
    {
        $partner = new \Netz\NetzMtm\Domain\Model\Partner();

        $partnerRepository = $this->getMockBuilder(\Netz\NetzMtm\Domain\Repository\PartnerRepository::class)
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $partnerRepository->expects(self::once())->method('remove')->with($partner);
        $this->inject($this->subject, 'partnerRepository', $partnerRepository);

        $this->subject->deleteAction($partner);
    }
}
