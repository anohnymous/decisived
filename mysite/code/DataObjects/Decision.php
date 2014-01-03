<?php
//A decision must expressed as be a yes or no statement

class Decision extends DataObject {
    static $db = array(
        'Content' => 'Text',
        'YesNo' => 'Varchar(4)',
        'YesHashtag' => 'Varchar(13)',
        'NoHashtag' => 'Varchar(13)',
        'UmHashtag' => 'Varchar(13)'        
    );

    static $has_one = array(
        'YesChild' => 'Descendent',
        'NoChild' => 'Descendent',
        'SystemSet' => 'SystemSet',
        'OptionsGroup' => 'OptionsGroup'
    );

    static $has_many = array(
        'Outcome' => 'Outcomes',
        'DecidingFactor' => 'DecidingFactors'
    );
    
    public function SetSortOrder(){
        //var_dump($this);
    }

}