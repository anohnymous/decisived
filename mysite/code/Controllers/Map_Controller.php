<?php

class Map_Controller extends Controller {

    private static $allowed_actions = array(
        'index'
    );

    public function index(){
        return $this->renderWith(array('Map', 'Page'));
    }

    public function Link(){
        return 'districtmap/';
    }
}
