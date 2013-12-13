<?php

class HomePage_Controller extends Controller {

    private static $allowed_actions = array(
        'index'
    );

    public function index(){
        return $this->renderWith(array('Page', 'Page'));
    }

}
