<?php

class DecidingFactor extends DataObject {
    static $db = array(
        'Content' => 'Text',
        'ArgumentSide' => "Enum('Yes,No')"
    );

    static $has_one = array(
        'Decision' => 'Decision'
    );

    public function Form() {
        return new FieldList(
            new TextField('Content')
        );
    }

}