<?php
//A


class SystemSet extends DataObject {
    static $db = array(
        'Name' => 'Text',
        'SystemType' => "Enum('Democracy,Oligarchy')"
    );

    static $has_many = array(
        'Decision' => 'Decisions',
        'Definition' => 'Definitions',
        'Operation' => 'Operations',
        'Outcome' => 'Outcomes'
    );

}