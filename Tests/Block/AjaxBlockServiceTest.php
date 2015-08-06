<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\DashboardBundle\Tests\Block;

use Sonata\BlockBundle\Block\BlockContext;
use Sonata\BlockBundle\Model\Block;
use Sonata\BlockBundle\Tests\Block\Service\FakeTemplating;
use Sonata\DashboardBundle\Block\AjaxBlockService;

/**
 * Test Container Block service.
 */
class AjaxBlockServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test the block execute() method.
     */
    public function testExecute()
    {
        $templating = new FakeTemplating();
        $service    = new AjaxBlockService('sonata.dashboard.block.ajax', $templating);

        $block = new Block();
        $block->setName('block.name');
        $block->setType('sonata.dashboard.block.ajax');
        $block->setSettings(array(
            'code' => 'block.code',
        ));

        $blockContext = new BlockContext($block, array('template' => 'SonataDashboardBundle:Block:ajax.html.twig'));

        $service->execute($blockContext);

        $this->assertEquals('SonataDashboardBundle:Block:ajax.html.twig', $templating->view);
        $this->assertEquals('block.code', $templating->parameters['block']->getSetting('code'));
        $this->assertEquals('block.name', $templating->parameters['block']->getName());
        $this->assertInstanceOf('Sonata\BlockBundle\Model\Block', $templating->parameters['block']);
    }

    /**
     * test the block's form builders.
     */
    public function testFormBuilder()
    {
        $templating = new FakeTemplating();
        $service    = new AjaxBlockService('sonata.dashboard.block.ajax', $templating);

        $block = new Block();
        $block->setName('block.name');
        $block->setType('sonata.dashboard.block.ajax');
        $block->setSettings(array(
            'name' => 'block.code',
        ));

        $formMapper = $this->getMock('Sonata\\AdminBundle\\Form\\FormMapper', array(), array(), '', false);
        $formMapper->expects($this->exactly(2))->method('add');

        $service->buildCreateForm($formMapper, $block);
        $service->buildEditForm($formMapper, $block);
    }
}
