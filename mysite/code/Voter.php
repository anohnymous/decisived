<?php

class Voter extends Member {

    static $db = array(

    );

    static $has_many = array(
        'Vote' => 'Votes'
    );

}