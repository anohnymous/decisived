<?php

class Vote extends DataObject {
    static $db = array(
        'PassFailVote' => 'Varchar(4)'
    );

    static $has_one = array(
        'Voter' => 'Voter',
        'Decision' => 'Decision'
    );

}