<?php
//Outcomes might be actions or intentions

class OutcomeVotes extends DataObject {
    static $db = array(
        'PassFail' => 'Boolean'
    );

    static $has_one = array(
        'Voter' => 'Voter',
        'Outcome' => 'Outcome'
    );

}