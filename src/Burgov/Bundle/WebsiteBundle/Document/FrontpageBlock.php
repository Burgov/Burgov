<?php

namespace Burgov\Bundle\WebsiteBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;
use Symfony\Cmf\Bundle\BlockBundle\Document\BaseBlock;

/**
 * Block that contains hypertext and a title
 *
 * @PHPCRODM\Document(referenceable=true)
 */
class FrontpageBlock extends BaseBlock
{
    /** @PHPCRODM\String */
    protected $title;

    /** @PHPCRODM\String */
    protected $content;
    
    /** @PHPCRODM\String */
    protected $image;

    public function getType()
    {
        return 'burgov_website.block.frontpage';
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }
    
    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }


}
