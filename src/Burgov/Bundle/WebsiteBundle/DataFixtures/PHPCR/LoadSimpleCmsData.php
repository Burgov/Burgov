<?php

namespace Burgov\Bundle\WebsiteBundle\DataFixtures\PHPCR;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPCR\Util\NodeHelper;
use Symfony\Cmf\Bundle\BlockBundle\Document\SimpleBlock;
use Symfony\Cmf\Bundle\ContentBundle\Document\StaticContent;
use Symfony\Cmf\Bundle\MenuBundle\Document\MultilangMenuItem;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Document\MultilangPage;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Document\MultilangRedirectRoute;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Document\MultilangRoute;
use Symfony\Cmf\Bundle\SimpleCmsBundle\Document\Page;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadSimpleCmsData extends ContainerAware implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Get the base path name to use from the configuration
        $session = $manager->getPhpcrSession();
        $basepath = $this->container->getParameter('symfony_cmf_content.static_basepath');

        // Create the path in the repository
        NodeHelper::createPath($session, $basepath);

        // Create a new document using StaticContent from the CMF ContentBundle
        $homeDocument = new StaticContent();
        $homeDocument->setPath($basepath . '/home');
        $manager->persist($homeDocument);

        // Create a new SimpleBlock (see http://symfony.com/doc/master/cmf/bundles/block.html#block-types)
        $frontpageContainerBlock = new \Symfony\Cmf\Bundle\BlockBundle\Document\ContainerBlock();
        $frontpageContainerBlock->setParentDocument($homeDocument);
        $frontpageContainerBlock->setName('main');
        $manager->persist($frontpageContainerBlock);
        
        $frontpageBlock1 = new \Burgov\Bundle\WebsiteBundle\Document\FrontpageBlock;
        $frontpageBlock1->setName('fpBlock1');
        $frontpageBlock1->setTitle('Symfony Development');
        $frontpageBlock1->setContent("With a passionate developer community, great documentation, and thousands of successful web applications under its belt, Symfony is the premier open-source PHP framework. Though we are comfortable developing across many of the available frameworks out there, Symfony is our go-to when it comes to building complex web apps that demand scalability, extensibility, and ease of maintenance. Our team's expertise with Symfony is unmatched in the industry.");
        $frontpageBlock1->setImage("tmp.png");
        $frontpageBlock1->setParent($frontpageContainerBlock);
        $manager->persist($frontpageBlock1);
        $frontpageBlock2 = new \Burgov\Bundle\WebsiteBundle\Document\FrontpageBlock;
        $frontpageBlock2->setName('fpBlock2');
        $frontpageBlock2->setParent($frontpageContainerBlock);
        $frontpageBlock2->setTitle('Symfony Development');
        $frontpageBlock2->setContent("With a passionate developer community, great documentation, and thousands of successful web applications under its belt, Symfony is the premier open-source PHP framework. Though we are comfortable developing across many of the available frameworks out there, Symfony is our go-to when it comes to building complex web apps that demand scalability, extensibility, and ease of maintenance. Our team's expertise with Symfony is unmatched in the industry.");
        $frontpageBlock2->setImage("tmp.png");
        $manager->persist($frontpageBlock2);
        
        $routeBasepath = $this->container->getParameter('symfony_cmf_routing_extra.routing_repositoryroot');
        $routeBasepathParts = explode('/', $routeBasepath);

        // Create the path in the repository
        NodeHelper::createPath($session, '/'.$routeBasepathParts[1]);
        $homeRoute = new \Symfony\Cmf\Bundle\RoutingExtraBundle\Document\Route;
        $homeRoute->setName($routeBasepathParts[2]);
        $homeRoute->setParent($manager->find(null, '/'.$routeBasepathParts[1]));
        $homeRoute->setRouteContent($homeDocument);
        $homeRoute->setDefault(\Symfony\Cmf\Component\Routing\RouteObjectInterface::TEMPLATE_NAME, 'BurgovWebsiteBundle:Website:page.html.twig');
        $manager->persist($homeRoute);
        
        $contactRoute = new \Symfony\Cmf\Bundle\RoutingExtraBundle\Document\Route;
        $contactRoute->setName('contact');
        $contactRoute->setParent($homeRoute);
        $contactRoute->setDefault('_controller', 'BurgovWebsiteBundle:Contact:contact');
        $manager->persist($contactRoute);
        
        $contactThanksRoute = new \Symfony\Cmf\Bundle\RoutingExtraBundle\Document\Route;
        $contactThanksRoute->setName('thanks');
        $contactThanksRoute->setParent($contactRoute);
        $contactThanksRoute->setDefault('_controller', 'BurgovWebsiteBundle:Contact:thanks');
        $manager->persist($contactThanksRoute);
        
        $menuBasepath = $this->container->getParameter('symfony_cmf_menu.menu_basepath');

        // Create the path in the repository
        NodeHelper::createPath($session, $menuBasepath);

        $mainMenu = new \Symfony\Cmf\Bundle\MenuBundle\Document\MenuItem();
        $mainMenu->setPosition($manager->find(null, $menuBasepath), 'main');
        $manager->persist($mainMenu);
        
        $homeNode = $this->createMainMenuItem($mainMenu, 'home', 'Home', $homeDocument);
        $homeNode->setSubtext("Wij helpen ondernemingen en instellingen om de interactie met klanten te verbeteren. Dit doen we door de inzet van oplossingen op maat met behulp van innovatieve technologie. In de visie van E-ID kunnen onze klanten alleen succesvol zijn wanneer ze hun bedrijfsprocessen zo eenvoudig en transparant mogelijk ontsluiten naar hun afnemers.");
        $manager->persist($homeNode);
        $contactNode = $this->createMainMenuItem($mainMenu, 'contact', 'Contact');
        $contactNode->setRoute($routeBasepath.'/contact');
        $manager->persist($contactNode);

        $socialMenu = new \Symfony\Cmf\Bundle\MenuBundle\Document\MenuItem;
        $socialMenu->setPosition($manager->find(null, $menuBasepath), 'social');
        $manager->persist($socialMenu);
        $this->createSocialMenu($manager, $socialMenu);
        
        $footerBlock = new \Burgov\Bundle\WebsiteBundle\Document\FooterBlock;
        //$footerBlock->setPosition($manager->find(null, '/cms/blocks'), 'footer');
        $footerBlock->setParentDocument($homeDocument);
        $footerBlock->setName('footer');
        $footerBlock->setContent('&copy; 2012 <a href="/contact">Burgov Webdevelopment</a>, unless otherwise noted');
        $manager->persist($footerBlock);
        
        // Commit $document and m$block to the database
        $manager->flush();
    }
    
    private function createSocialMenu($manager, $parent) {
        foreach(array(
            'github' => array('GitHub', 'github.png', 'http://github.com/Burgov'),
            'sensio-connect' => array('Sensio Connect', 'sensio-connect.png', 'http://connect.sensiolabs.com/profile/burgov'),
            'facebook' => array('Facebook', 'facebook.png', 'http://www.facebook.com/BartBurgov'),
            'linkedin' => array('LinkedIN', 'linkedin.png', 'http://www.linkedin.com/in/bartvandenburg'),
            'twitter' => array('Twitter', 'twitter.png', 'http://www.twitter.com/BartBurgov'),
        ) as $id => $data) {
            $node = new \Burgov\Bundle\WebsiteBundle\Document\SocialMenuItem();
            $node->setPosition($parent, $id);
            $node->setAlt($data[0]);
            $node->setTitle($data[0]);
            $node->setImage($data[1]);
            $node->setLabel($id);
            $node->setUri($data[2]);
            $manager->persist($node);
        }
    }

    private function createMainMenuItem($parent, $name, $label, $document = null) {
        
        $node = new \Burgov\Bundle\WebsiteBundle\Document\MainMenuItem();
        $node->setName($name);
        $node->setLabel($label);
        $node->setParent($parent);
        if (null !== $document) {
            $node->setContent($document);
        }
        return $node;
    }
}