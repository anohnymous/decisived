<?php

class Vendor extends Voter {

    static $db = array(

    );

    static $has_many = array(
        'Vote' => 'Votes'
    );

}