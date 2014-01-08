<?php

class SystemDecisionSort extends DataObject {
    static $db = array(
        'SortOrder' => 'Int'
    );

    static $has_one = array(
        'Decision' => 'Decision',
        'SystemSet' => 'SystemSet'
    );
    
}