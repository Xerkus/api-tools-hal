<?php

/**
 * @see       https://github.com/laminas-api-tools/api-tools-hal for the canonical source repository
 * @copyright https://github.com/laminas-api-tools/api-tools-hal/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas-api-tools/api-tools-hal/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\ApiTools\Hal\Factory;

use Laminas\ApiTools\Hal\Factory\LinkUrlBuilderFactory;
use Laminas\ApiTools\Hal\Link\LinkUrlBuilder;
use Laminas\ServiceManager\ServiceManager;
use Laminas\View\Helper;
use PHPUnit\Framework\TestCase;

class LinkUrlBuilderFactoryTest extends TestCase
{
    /**
     * @var Helper\ServerUrl
     */
    private $serverUrlHelper;

    /**
     * @var Helper\Url
     */
    private $urlHelper;

    public function testInstantiatesLinkUrlBuilder()
    {
        $serviceManager = $this->getServiceManager();

        $factory = new LinkUrlBuilderFactory();
        $builder = $factory($serviceManager);

        $this->assertInstanceOf(LinkUrlBuilder::class, $builder);
    }

    public function testOptionUseProxyIfPresentInConfig()
    {
        $options = [
            'options' => [
                'use_proxy' => true,
            ],
        ];
        $serviceManager = $this->getServiceManager($options);

        $this->serverUrlHelper
            ->setUseProxy($options['options']['use_proxy'])
            ->shouldBeCalled();

        $factory = new LinkUrlBuilderFactory();
        $factory($serviceManager);
    }

    private function getServiceManager($config = [])
    {
        $serviceManager = new ServiceManager();
        $serviceManager->setService('Laminas\ApiTools\Hal\HalConfig', $config);

        $viewHelperManager = new ServiceManager();
        $serviceManager->setService('ViewHelperManager', $viewHelperManager);

        $this->serverUrlHelper = $serverUrlHelper = $this->prophesize(Helper\ServerUrl::class);
        $viewHelperManager->setService('ServerUrl', $serverUrlHelper->reveal());

        $this->urlHelper = $urlHelper = $this->prophesize(Helper\Url::class);
        $viewHelperManager->setService('Url', $urlHelper->reveal());

        return $serviceManager;
    }
}
