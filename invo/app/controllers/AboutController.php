<?php

class AboutController extends ControllerBase {

    public function initialize() {
        $this->view->setTemplateAfter('main');
        Phalcon\Tag::setTitle('Acerca de');
        parent::initialize();
    }

    public function indexAction() {
        
    }

}
