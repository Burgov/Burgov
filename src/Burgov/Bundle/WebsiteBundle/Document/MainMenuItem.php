<?php

namespace Burgov\Bundle\WebsiteBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;
use Symfony\Cmf\Bundle\MenuBundle\Document\MenuItem;

/**
 * @PHPCRODM\Document
 */
class MainMenuItem extends MenuItem
{

    /** @PHPCRODM\String */
    protected $subtext = '';

    public function getSubtext() {
        return $this->subtext;
    }

    public function setSubtext($subtext) {
        $this->subtext = $subtext;
    }
    
    public function getOptions() {
        $options = parent::getOptions();
        $options['extras']['subtext'] = $this->getSubtext();
        return $options;
    }


}