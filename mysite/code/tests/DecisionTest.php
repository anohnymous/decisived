<?php

class DecisionTest extends SapphireTest {
    static $fixture_file = 'mysite/code/tests/Decision.yml';

    function testDecidingFactorDecisionID(){
        $Decision = $this->objFromFixture('Decision', 'Pizza');
        $DecidingFactor = $this->objFromFixture('DecidingFactor', 'Ethics');
        $DecidingFactor->DecisionID = $Decision->ID;
        $this->assertEquals($DecidingFactor->DecisionID, 29);
    }
}