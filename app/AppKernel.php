<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // enable symfony-standard bundles
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),

            new Doctrine\Bundle\PHPCRBundle\DoctrinePHPCRBundle(),
            new Liip\DoctrineCacheBundle\LiipDoctrineCacheBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),

            // enable cmf bundles
            new Symfony\Cmf\Bundle\RoutingExtraBundle\SymfonyCmfRoutingExtraBundle(),
            new Symfony\Cmf\Bundle\CoreBundle\SymfonyCmfCoreBundle(),
            new Symfony\Cmf\Bundle\MenuBundle\SymfonyCmfMenuBundle(),
            new Symfony\Cmf\Bundle\ContentBundle\SymfonyCmfContentBundle(),
            new Symfony\Cmf\Bundle\SimpleCmsBundle\SymfonyCmfSimpleCmsBundle(),
            new Symfony\Cmf\Bundle\CreateBundle\SymfonyCmfCreateBundle(),
        new Sonata\BlockBundle\SonataBlockBundle(),
        new Symfony\Cmf\Bundle\BlockBundle\SymfonyCmfBlockBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),

            // and the sandbox bundle
//            new Acme\MainBundle\AcmeMainBundle(),
            new Burgov\Bundle\WebsiteBundle\BurgovWebsiteBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
