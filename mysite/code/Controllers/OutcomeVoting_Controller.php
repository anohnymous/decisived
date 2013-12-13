<?php

class OutcomeVoting_Controller extends Controller {

    private static $allowed_actions = array(
        'index',
        'RegisterVoter',
        'VoterLogin',
        'CastVote'
    );

    public static $url_handlers = array(
        'voter/CastVote/$DecisionID/$VoterID' => 'CastVote',
        'voter/RegisterVoter' => 'RegisterVoter'
    );

    public function index(){
        echo 'index';
        return $this->renderWith(array('CastVote', 'Page'));
    }

    public function Link(){
        return 'voter/';
    }

    function RegisterVoter(){
        $Email = $this->request->postVar('Email');
        if(isset($Email)){
            $member = Voter::get()->filter(array('Email'=>$this->request->postVar('Email')))->first();
            if(isset($member)){
                $member->logIn();
            }
            $Password = $this->request->postVar('Password');
            $Voter = new Voter();
            $Voter->Email = Convert::raw2sql($Email);
            $Voter->Password = Convert::raw2sql($Password['_Password']);
            $Voter->write();
        }

        $fields = new FieldList();
        $fields->push(new EmailField('Email','Please set your email address:'));
        $fields->push(new ConfirmedPasswordField('Password','Choose a wise password.'));

        $actions = new FieldList(FormAction::create("RegisterVoter")->setTitle('Register Voter'));

        $form = new Form($this, 'RegisterVoter', $fields, $actions);
        // Load the form with previously sent data
        $form->loadDataFrom($this->request->postVars());
        return $form;
    }

    public function CastVote(){
        echo 'function cast vote';
        return $this->renderWith(array('CastVote', 'Page'));
    }

    public function CastVoteForm(){
        $POSTDecisionID = $this->request->postVar('DecisionID');
        $POSTVoterID = $this->request->postVar('VoterID');
        //The IDs posted from the form take precedence over the url
        //If IDs from url, DecisionID is expected in ID and VoterID is expected to be Name in the SS /$action/$name/$id tradition
        $DecisionID = isset($POSTDecisionID) ? $POSTDecisionID : $this->request->Param('ID');
        $VoterID = isset($POSTVoterID) ? $POSTVoterID : $this->request->Param('Name');
        var_dump($this->request->postVar('YesNo'));
        $returnedVote = $this->WriteVote($this->request->postVar('YesNo'),$DecisionID,$VoterID);
        //var_dump($returnedVote);


        if(isset($DecisionID) && isset($VoterID)){
            $Decision = Decision::get_by_id('Decision',$DecisionID);
            $fields = new FieldList();
            $fields->push(new LabelField('DecisionContent',$Decision->Content));
            $fields->push(new HiddenField('DecisionID','', $DecisionID));
            $fields->push(new HiddenField('VoterID','', $VoterID));
            $fields->push(new OptionsetField('YesNo','Vote Yes or No',array("1"=>"Yes","0"=>"No")));
            $actions = new FieldList(
                FormAction::create("CastVote")->setTitle("Vote")
            );
            $form = new Form($this, 'CastVote', $fields, $actions);
            return $form;
        }
        return false;
    }

    /*
     * $YesNo is true or false
     * $DecisionID wouldn't be set if it is the voters first vote
     */
    function WriteVote($YesNo = null,$DecisionID = null, $VoterID = null){
        $YesNo = intval($YesNo);
        $DecisionID = intval($DecisionID);
        $VoterID = intval($VoterID);
        if($YesNo != 1 && $YesNo != 0){
            return false;
        }
        if(Member::currentUserID() != $VoterID){
            return false;
        }

        $VotersDecision = Vote::get()->filter(array('DecisionID'=>$DecisionID,'VoterID'=>$VoterID))->first();
        if(!isset($VotersDecision)){
            $VotersDecision = new Vote();
            $VotersDecision->DecisionID = $DecisionID;
            $VotersDecision->VoterID = $VoterID;
        }
        $VotersDecision->YesNoVote = $YesNo;
        $VotersDecision->write();

        return $VotersDecision;
    }
}
