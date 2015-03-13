<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Migration\Step;

use Migration\Step\Eav\InitialData;

/**
 * Class LogTest
 */
class EavTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InitialData|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $initialData;

    /**
     * @var Integrity\Eav|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $integrity;

    /**
     * @var Run\Eav|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $run;

    /**
     * @var Volume\Eav|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $volume;

    /**
     * @var Eav
     */
    protected $step;

    public function setUp()
    {
        $this->initialData = $this->getMockBuilder('Migration\Step\Eav\InitialData')->disableOriginalConstructor()
            ->setMethods(['init'])
            ->getMock();
        $this->integrity = $this->getMock('Migration\Step\Integrity\Eav', ['perform'], [], '', false);
        $this->run = $this->getMock('Migration\Step\Run\Eav', ['perform', 'rollback', 'deleteBackups'], [], '', false);
        $this->volume = $this->getMock('Migration\Step\Volume\Eav', ['perform'], [], '', false);
        $this->step = new Eav(
            $this->initialData,
            $this->integrity,
            $this->run,
            $this->volume
        );
    }

    public function testIntegrity()
    {
        $this->integrity->expects($this->once())->method('perform');
        $this->step->integrity();
    }

    public function testRun()
    {
        $this->initialData->expects($this->once())->method('init');
        $this->run->expects($this->once())->method('perform');
        $this->step->run();
    }

    public function testVolume()
    {
        $this->volume->expects($this->once())->method('perform')->willReturn(true);
        $this->run->expects($this->once())->method('deleteBackups');
        $this->step->volumeCheck();
    }

    public function testGetTitle()
    {
        $this->assertEquals('EAV Step', $this->step->getTitle());
    }

    public function testRollback()
    {
        $this->run->expects($this->once())->method('rollback');
        $this->step->rollback();
    }
}