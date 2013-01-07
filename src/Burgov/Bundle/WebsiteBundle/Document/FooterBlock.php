<?php

namespace Burgov\Bundle\WebsiteBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;
use Symfony\Cmf\Bundle\BlockBundle\Document\BaseBlock;

/**
 * Block that contains hypertext and a title
 *
 * @PHPCRODM\Document(referenceable=true)
 */
class FooterBlock extends BaseBlock
{
    /** @PHPCRODM\String */
    protected $content;

    public function getType()
    {
        return 'burgov_website.block.footer';
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
}
