<?php
namespace Netz\NetzMtm\Tests\Unit\Domain\Model;

/**
 * Test case.
 */
class PartnerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Netz\NetzMtm\Domain\Model\Partner
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new \Netz\NetzMtm\Domain\Model\Partner();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'title',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPositionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPosition()
        );
    }

    /**
     * @test
     */
    public function setPositionForStringSetsPosition()
    {
        $this->subject->setPosition('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'position',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getTelephoneReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTelephone()
        );
    }

    /**
     * @test
     */
    public function setTelephoneForStringSetsTelephone()
    {
        $this->subject->setTelephone('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'telephone',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getEmailReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail()
    {
        $this->subject->setEmail('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'email',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getImageReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getImage()
        );
    }

    /**
     * @test
     */
    public function setImageForFileReferenceSetsImage()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setImage($fileReferenceFixture);

        self::assertAttributeEquals(
            $fileReferenceFixture,
            'image',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getInfoReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getInfo()
        );
    }

    /**
     * @test
     */
    public function setInfoForStringSetsInfo()
    {
        $this->subject->setInfo('Conceived at T3CON10');

        self::assertAttributeEquals(
            'Conceived at T3CON10',
            'info',
            $this->subject
        );
    }
}
