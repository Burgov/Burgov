<?php

namespace Burgov\Bundle\WebsiteBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;
use Symfony\Cmf\Bundle\MenuBundle\Document\MenuItem;

/**
 * @PHPCRODM\Document
 */
class SocialMenuItem extends MenuItem {

    /** @PHPCRODM\String */
    protected $image = '';

    /** @PHPCRODM\String */
    protected $alt = '';

    /** @PHPCRODM\String */
    protected $title = '';

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getAlt() {
        return $this->alt;
    }

    public function setAlt($alt) {
        $this->alt = $alt;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getOptions() {
        $options = parent::getOptions();
        $options['extras']['image'] = $this->getImage();
        $options['extras']['alt'] = $this->getAlt();
        $options['extras']['title'] = $this->getTitle();
        return $options;
    }

}