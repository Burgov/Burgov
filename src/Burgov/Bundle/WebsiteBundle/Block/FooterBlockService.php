<?php

namespace Burgov\Bundle\WebsiteBundle\Block;

use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\Response;

class FooterBlockService extends BaseBlockService {

    public function buildEditForm(\Sonata\AdminBundle\Form\FormMapper $form, BlockInterface $block) {
        
    }

    public function execute(BlockInterface $block, Response $response = null) {
        return $this->renderResponse('BurgovWebsiteBundle:Block:footer.html.twig', array('block' => $block), $response);
    }

    public function validateBlock(\Sonata\AdminBundle\Validator\ErrorElement $errorElement, BlockInterface $block) {
        
    }
}