<?php

class VotingTest extends SapphireTest {
    static $fixture_file = 'mysite/code/tests/Votes.yml';

    function testVoterPassFailIsBoolean(){
        $this->assertEquals(1, 1);
    }

    function testCastingYesVote(){
        $Voter = $this->objFromFixture('Voter', 'Susan');
        $Decision = $this->objFromFixture('Decision', 'Sleep');
        $VotersDecision = $Voter->CastVote(1,$Decision->ID);
        $this->assertEquals($VotersDecision->PassFailVote, 1);
    }

    function testCastingNoVote(){
        $Voter = $this->objFromFixture('Voter', 'Edmund');
        $Decision = $this->objFromFixture('Decision', 'Sleep');
        $VotersDecision = $Voter->CastVote(0,$Decision->ID);
        $this->assertEquals($VotersDecision->PassFailVote, 0);
    }
}