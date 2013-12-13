<?php

class Voting_Controller extends Controller {

    private static $allowed_actions = array(
        'index',
        'activity',
        'logout',
        'register',
        'voteondecision',
        'RegisterVoter',
        'CastVote'
    );

    public static $_CurrentDecisionID = 0;
    public static $_CurrentVoterID = 0;

    public function init(){
        $GetDecisionID = $this->request->getVar('DecisionID');
        $PostDecisionID = $this->request->postVar('DecisionID');
        $RequestDecisionID = $this->request->Param('DecisionID');
        if(isset($GetDecisionID)){
            self::$_CurrentDecisionID = $GetDecisionID;
        }
        if(isset($PostDecisionID)){
            self::$_CurrentDecisionID = $PostDecisionID;
        }
        if(isset($RequestDecisionID)){
            self::$_CurrentDecisionID = $RequestDecisionID;
        }
        $GetVoterID = $this->request->getVar('VoterID');
        $PostVoterID = $this->request->postVar('VoterID');
        $RequestVoterID = $this->request->Param('VoterID');
        if(isset($GetVoterID)){
            self::$_CurrentVoterID = $GetVoterID;
        }
        if(isset($PostVoterID)){
            self::$_CurrentVoterID = $PostVoterID;
        }
        if(isset($RequestDecisionID)){
            self::$_CurrentVoterID = $RequestVoterID;
        }
        parent::init();
    }

    public function index(){
        return $this->renderWith(array('Voter', 'Page'));
    }

    public function logout(){
        $member = Member::currentUser();
        if($member) $member->logOut();

        return $this->renderWith(array('Logout', 'Page'));
    }

    public function register(){
        return $this->renderWith(array('Login', 'Page'));
    }

    public function voteondecision(){
        if(self::$_CurrentVoterID != 0 && self::$_CurrentDecisionID != 0){
            return $this->renderWith(array('CastVote', 'Page'));
        }
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
                $this->redirect("index");
                return;
            }
            $Password = $this->request->postVar('Password');
            $Voter = new Voter();
            $Voter->Email = Convert::raw2sql($Email);
            $Voter->Password = Convert::raw2sql($Password['_Password']);
            $Voter->write();
        }

        $fields = new FieldList();
        $fields->push(new EmailField('Email'));
        //$fields->push(new PasswordField('Password'));

        $actions = new FieldList(FormAction::create("RegisterVoter")->setTitle('Register Voter'));

        $form = new Form($this, 'RegisterVoter', $fields, $actions);
        // Load the form with previously sent data
        $form->loadDataFrom($this->request->postVars());
        return $form;
    }

    public function CastVote(){
        return $this->renderWith(array('CastVote', 'Page'));
    }

    public function CastVoteForm(){
        $returnedVote = $this->WriteVote($this->request->postVar('YesNo'),self::$_CurrentDecisionID,self::$_CurrentVoterID);

        if(self::$_CurrentDecisionID && self::$_CurrentVoterID){
            $Decision = Decision::get_by_id('Decision',self::$_CurrentDecisionID);
            $fields = new FieldList();
            $fields->push(new LabelField('DecisionContent',$Decision->Content));
            $fields->push(new LabelField('CurrentVote','Your current vote is: '.$this->CurrentVoterVote()));
            $fields->push(new HiddenField('DecisionID','', self::$_CurrentDecisionID));
            $fields->push(new HiddenField('VoterID','', self::$_CurrentVoterID));
            $fields->push(new OptionsetField('YesNo','Vote Yes or No',array("yes"=>"Yes","no"=>"No")));
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
        if($YesNo != 'yes' && $YesNo != 'no'){
            return false;
        }
        if(Member::currentUserID() != $VoterID){
            return false;
        }

        $VotersDecision = Vote::get()->filter(array('DecisionID'=>self::$_CurrentDecisionID,'VoterID'=>self::$_CurrentVoterID))->first();
        if(!isset($VotersDecision)){
            $VotersDecision = new Vote();
            $VotersDecision->DecisionID = $DecisionID;
            $VotersDecision->VoterID = $VoterID;
        }
        $VotersDecision->PassFailVote = $YesNo;
        $VotersDecision->write();

        return $VotersDecision;
    }

    public function CurrentVoterVote(){
        if(self::$_CurrentDecisionID != 0){
            $Vote = Vote::get()->filter(array('DecisionID'=>self::$_CurrentDecisionID,'VoterID'=>self::$_CurrentVoterID))->first();
            if(isset($Vote)){
                return $Vote->PassFailVote;
            }
        }
        return false;
    }

    public function CurrentDecisionVote(){
        if(self::$_CurrentDecisionID != 0){
            $Decision = Decision::get_by_id('Decision',self::$_CurrentDecisionID);
            $yes = Vote::get()->filter(array('DecisionID'=>self::$_CurrentDecisionID,'PassFailVote'=>'yes'))->count();
            $no = Vote::get()->filter(array('DecisionID'=>self::$_CurrentDecisionID,'PassFailVote'=>'no'))->count();
            $total = Vote::get()->filter(array('DecisionID'=>self::$_CurrentDecisionID))->count();
            $Decision->yesPercent = ($yes/$total)*100;
            $Decision->noPercent = ($no/$total)*100;
            if($Decision->yesPercent > 66.66){
                $Decision->Status = 'yes';
            } elseif($Decision->noPercent > 66.66){
                $Decision->Status = 'no';
            } else {
                $Decision->Status = 'undetermined';
            }
            return $Decision;
        }
        return false;
    }

    public function DecisionVotes(){
        $Votes = DataObject::get('Vote')->filter(array('VoterID'=>Member::currentUserID()))->leftJoin('Decision','Vote.DecisionID = Decision.ID');
        return $Votes;
    }
}
