<?php

class Operation extends DataObject {
    static $db = array(
        'Name' => 'Text',
        'Procedure' => 'Text'
    );

    static $has_one = array(
        'SystemSet' => 'SystemSet'
    );

}