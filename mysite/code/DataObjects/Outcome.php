<?php
//Outcomes have actors, parties responsible for their execution.

class Outcome extends Decision {
    static $db = array(
        'Actor' => 'Text'
    );

    static $has_one = array(
        'Decision' => 'Decision'
    );

    static $has_many = array(
        'SystemSet' => 'SystemSets'
    );

}