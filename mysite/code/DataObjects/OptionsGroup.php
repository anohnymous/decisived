<?php

class OptionsGroup extends DataObject {
    static $db = array(
        'Name' => 'Text',
        'Source' => 'Text',
        'OfficialIds' => 'Varchar(13)'
    );

    static $has_many = array(
        'Decision' => 'Decisions'
    );
    
    static $has_one = array(
        'SystemSet' => 'SystemSet'
    );

}