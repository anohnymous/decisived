<?php
//A decision must expressed as be a yes or no statement

class Decision extends DataObject {
    static $db = array(
        'Content' => 'Text',
        'YesNo' => 'Varchar(4)',
        'YesHashtag' => 'Varchar(13)',
        'NoHashtag' => 'Varchar(13)',
        'UmHashtag' => 'Varchar(13)',
        'YesAction' => 'Varchar(64)',
        'NoAction' => 'Varchar(64)' 
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
    
    public function canView($member = null) {
        return true;
    }
    
    public function canEdit($member = null) {
        return true;
    }
    
    public function canDelete($member = null) {
        return true;
    }
    
    public function canCreate($member = null) {
        return true;
    }
    
    public function SetSortOrder(){
        if($systemSetID = 1){
            //$SortOrder = DataObject::get('SystemDecisionSort')->filter(array('SystemSetID'=>$systemSetID,'DecisionID'=>$this->ID));
            //return $SortOrder;
        } else {
            return 0;
        }
    }

}