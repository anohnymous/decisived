<?php

class Definition extends DataObject {
    static $db = array(
        'Content' => 'Text',
        'Rating' => 'Int'
    );

    static $has_many = array(
        'SystemSet' => 'SystemSets'
    );

}