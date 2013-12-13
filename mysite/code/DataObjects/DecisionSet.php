<?php
//A DecisionSet

class DecisionSet extends DataObject {
    static $db = array(
        'Name' => 'Text'
    );

    static $has_many = array(
        'Decision' => 'Decisions'
    );

}