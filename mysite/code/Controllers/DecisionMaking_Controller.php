<?php

class DecisionMaking_Controller extends Controller {
    public static $allowed_actions = array(
        'index' => true,
        'deleteDecision' => true,
        'decided' => true,
        'DecideForm' => true,
        'deciding' => true,
        'deleteSystemset' => true,
        'edit' => true,
        'factor' => true,   
        'mostdecisionactivity' => true,
        'optionsgroup' => true,
        'systemset' => true,
        'theory' => true,
        'undecided' => true,
        'versions'  => true,
        'whatsup' => true
    );

    static $extensions = array('Hierarchy');

    public static $_CurrentDecisionID = 0;
    public static $_CurrentSystemSetID = 0;

    public function init(){
        $GetDecisionID = $this->request->getVar('DecisionID');
        $PostDecisionID = $this->request->postVar('DecisionID');
        $RequestDecisionID = $this->request->Param('DecisionID');
        $GetSystemSetID = $this->request->getVar('SystemSetID');
        $PostSystemSetID = $this->request->postVar('SystemSetID');
        $RequestSystemSetID = $this->request->Param('SystemSetID');
        if(isset($GetDecisionID)){
            self::$_CurrentDecisionID = $GetDecisionID;
        }
        if(isset($PostDecisionID)){
            self::$_CurrentDecisionID = $PostDecisionID;
        }
        if(isset($RequestDecisionID)){
            self::$_CurrentDecisionID = $RequestDecisionID;
        }
        if(isset($GetSystemSetID)){
            self::$_CurrentDecisionID = $GetSystemSetID;
        }
        if(isset($PostSystemSetID)){
            self::$_CurrentDecisionID = $PostSystemSetID;
        }
        if(isset($RequestSystemSetID)){
            self::$_CurrentSystemSetID = $RequestSystemSetID;
        }
        parent::init();
    }

    /**
     * Returns a link to this controller.  Overload with your own Link rules if they exist.
     */
    public function Link() {
        return '';
    }

    public function index() {
        return $this->renderWith(array('HomePage', 'Page'));
    }

    public function decided(SS_HTTPRequest $request) {
        echo 'decided';
        print_r($arguments);
    }
    
    public function deciding() {
        $this->WritingDecision($this->request->postVars());
        return $this->renderWith(array('CurrentDecision', 'Page'));
    }

    public function systemset(){
        $this->WriteSystemSet($this->request->postVars());
        return $this->renderWith(array('SystemSet', 'Page'));
    }

    public function edit(){
        return $this->renderWith(array('EditDecision', 'Page'));
    }

    public function factor(){
        $this->writeFactor($this->request->postVars());
        return $this->renderWith(array('EditFactor', 'Page'));
    }                    
    
    public function mostdecisionactivity(){
        return $this->renderWith(array('MostDecisionActivity', 'Page'));
        
    }
    
    public function theory(){
        return $this->renderWith(array('Theory', 'Page'));
    }

    public function optionsgroup(){
        $this->writeOptionsGroup($this->request->postVars());
        return $this->renderWith(array('OptionsGroup', 'Page'));
    }
    
    public function whatsup(){
        $this->whatDoWeKnow($this->request->postVars());
        return $this->renderWith("Page","Page");
    }

    public function undecided() {
        return $this->renderWith("Page","Page");
    }

    public function versions() {
        return $this->renderWith(array('DecisionVersions', 'Page'));
    }

    public function DecideForm() {
        $fields = new FieldList();

        //$fields->push(new CheckboxField('HasActor','Does your statement have an Actor? A noun like I, we, Mary Jane, the US.'));
        //$fields->push(new CheckboxField('HasClock','Is there an element of time you need to account for?  Did you say tomorrow, tonight, next week?'));
        //$fields->push(new CheckboxField('Action','Is there something that to be done? Do you have an active verb like buy or bomb?'));
        //$fields->push(new CheckboxField('Goal','Does your statement list its goal? A clue is words like to, for, because.'));
        //$fields->push(new CheckboxField('Choice','Did you say or? Do you need to make a choice?.'));

        $fields->push(new TextareaField('DecisionStatement','Decision Statement'));
        //$fields->push(new TextField('Actor','Actor'));
        if(self::$_CurrentDecisionID){
            $Decision = Decision::get_by_id('Decision',self::$_CurrentDecisionID);
            $fields->push(new TextareaField('DecisionStatement','Decision Statement',$Decision->Content));
            $fields->push(new TextField('YesHashtag','Yes Hashtag Labeling (without #)',$Decision->YesHashtag));
            $fields->push(new TextField('NoHashtag','No Hashtag Labeling (without #)',$Decision->NoHashtag));
            $fields->push(new TextField('UmHashtag','Ummmm.... Undecided Hashtag Labeling (without #)',$Decision->UmfHashtag));
            $SystemSetField = new DropdownField(
                'SystemSetID',
                '',
                $this->getSystemSetOptions(),
                $Decision->SystemSetID
            );
            $ParentField = new DropdownField(
                'ParentID',
                '',
                $this->getDecisionOptions(),
                $Decision->ParentID
            );
        } else {
            $fields->push(new TextareaField('DecisionStatement','Decision Statement'));
            $fields->push(new TextField('YesHashtag','Yes Hashtag Labeling (without #)'));
            $fields->push(new TextField('NoHashtag','No Hashtag Labeling (without #)'));
            $fields->push(new TextField('UmHashtag','Undecided Hashtag Labeling (without #)'));
            $SystemSetField = new DropdownField(
                'SystemSetID',
                '',
                $this->getSystemSetOptions()
            );
            $ParentField = new DropdownField(
                'ParentID',
                '',
                $this->getDecisionOptions()
            );
        }
        $SystemSetField->setEmptyString('Group in Set?');
        $fields->push($SystemSetField);
        $ParentField->setEmptyString('Choose Parent Decision');
        $fields->push($ParentField);

        if(self::$_CurrentDecisionID != 0){
            $fields->push(new HiddenField('DecisionID','', self::$_CurrentDecisionID));
            $ActionText = 'Still deciding...';
        } else {
            $ActionText = 'Write Decision Statement.';
        }

        $actions = new FieldList(
            FormAction::create("/decision/deciding")->setTitle($ActionText)
        );
        $form = new Form($this, '/decision/deciding', $fields, $actions);
        // Load the form with previously sent data
        $form->loadDataFrom($this->request->postVars());
        return $form;
    }


    public function SystemSetForm() {
        if(self::$_CurrentSystemSetID != 0){
            $SystemSet = SystemSet::get_by_id('SystemSet',self::$_CurrentSystemSetID);
        }

        $fields = new FieldList();

        if(self::$_CurrentSystemSetID != 0){
            $fields->push(new TextField('Name','System Set Name',$SystemSet->Name));
            $fields->push(new HiddenField('SystemSetID','', self::$_CurrentSystemSetID));
            $ActionText = 'Rename System Set';
        } else {
            $fields->push(new TextField('Name','System Set Name'));
            $ActionText = 'Name System Set.';
        }
        //$fields->push(new DropdownField('SystemType', 'System Type', singleton('SystemSet')->dbObject('SystemType')->enumValues()));

        $actions = new FieldList(
            FormAction::create("/decision/systemset")->setTitle($ActionText)
        );
        $form = new Form($this, '/decision/systemset', $fields, $actions);
        // Load the form with previously sent data
        $form->loadDataFrom($this->request->postVars());
        return $form;

    }

    public function FactorForm() {
        $fields = new FieldList();
        
        $postVars = $this->request->postVars();
        $factoridGet = $this->request->getVar('factorid');
        
        $factoridPost = isset($postVars['DecidingFactorID']) ? $postVars['DecidingFactorID'] : null;
          
        $factorid = isset($factoridGet) ? $factoridGet : $factoridPost;
        if(self::$_CurrentDecisionID){                 
            $Decision = Decision::get_by_id('Decision',self::$_CurrentDecisionID);
        }
        if($factorid){
            $Factor = DecidingFactor::get_by_id('DecidingFactor',Convert::raw2sql($factorid)); 
            $FactorContent = $Factor->Content; 
            $fields->push(new HiddenField('DecidingFactorID','',$Factor->ID));
        }

        //$fields->push(new CheckboxField('YesOrNo','A Decision Statement must be Yes or No.  Is your statement in that form?<br />Are you ready to put to vote?',0));
        //$fields->push(new CheckboxField('AddFactor','Do you want to <a href="decision/?DecidingFactorView=1' . $getVars .'">evaluate Deciding Factors</a>?'));
        //$fields->push(new CheckboxField('Outcome','Do you want to <a href="decision/?OutcomeView=1' . $getVars .'">posit Outcomes</a>?'));
        //$fields->push(new CheckboxField('LinkBack','<a href="/decision?' . $getVars . '">Just make a decision.</a>'));

        $Factor = isset($FactorContent) ? $FactorContent : '';
        $fields->push(new TextField('DecidingFactorContent','', $Factor));
        if(!empty($Factor->ArgumentSide)){
          $fields->push(new LiteralField('ArgumentSideCurrent','Your argument is currently factored into the '.$Factor->ArgumentSide.' side.'));
        }
        
        $fields->push(new OptionsetField('ArgumentSide','Is your argument a factor for the Yes or No Side?',array("yes"=>"Yes","no"=>"No")));
        $ActionText = 'Write this Deciding Factor.';

        if (isset($Factor->DecisionID) || self::$_CurrentDecisionID != 0){
            $FactorDecisionID = isset($Factor->DecisionID) ? isset($Factor->DecisionID) : self::$_CurrentDecisionID;
        } 
        if(!isset($FactorDecisionID)){
            $FactorDecisionID = 0;          
        }
        $fields->push(new HiddenField('DecisionID','', $FactorDecisionID));

        $actions = new FieldList(
            FormAction::create("/decision/factor")->setTitle($ActionText)
        );
        $form = new Form($this, '/decision/factor', $fields, $actions);
        // Load the form with previously sent data
        $form->loadDataFrom($this->request->postVars());
        return $form;
    }                         
    
    public function OptionsGroupForm(){
        $fields = new FieldList();

        $fields->push(new TextField('Name',''));
        
        $actions = new FieldList(
            FormAction::create("/decision/optionsgroup")->setTitle('Names Option Group')
        );
        $form = new Form($this, '/decision/optionsgroup', $fields, $actions);
        // Load the form with previously sent data
        $form->loadDataFrom($this->request->postVars());
        return $form;
    }

    public function ParseDecision(){
        if(self::$_CurrentDecisionID == 0){
            return false;
        }

        $DecisionStatement = Decision::get_by_id('Decision',self::$_CurrentDecisionID)->Content;
        if(!$DecisionStatement){
            return false;
        }
        return array();
//nothing for this function gets executed beyond this return above
        $returnMessage = new ArrayList();
        $wordMap = array(
            'should'=>'Can you remove should from your sentence? Try to rewrite it with will.',
            'tonight'=>'Does the timeframe matter? If you put it off, will it still be possible to accomplish? Then remove the time element.',
            'to'=>'Are you stating your decision and your goal together?  Lets break them up.',
            'try'=>'Can you remove try from your sentence? Is this part of your sentence describing your goal or objective?',
            'we'=>'"We" is an Actor.',
            'I'=>'"I" am an Actor.',
            'do'=>'Do indicates an action, so this is an Outcome.'
        );
        $suffix = array(
            'ing',
            'ed'
        );

        foreach($wordMap as $word => $message){
            if (strpos($DecisionStatement,$word) !== false) {
                $returnMessage->push(array('Content'=>$message));
            }
        }

        foreach($suffix as $ending => $message){
            if (strpos($DecisionStatement,$ending) !== false) {
                $returnMessage->push(array('Content'=>$message));
            }
        }

        return $returnMessage;
    }


    public function WritingDecision($data){
        if(!empty($data['DecisionID'])){
            $DecisionID = (self::$_CurrentDecisionID != 0) ? self::$_CurrentDecisionID : $data['DecisionID'];
            $Decision = Decision::get_by_id('Decision',$DecisionID);
        } elseif(isset($data['DecidingFactorContent']) || isset($data['OutcomeContent']) || isset($data['DecisionStatement'])) {
            $Decision = new Decision();
        }
        if(isset($Decision) && (isset($data['DecisionStatement']) || isset($data['YesNo']))){
            $Decision->SystemSetID = isset($data['SystemSetID']) ? Convert::raw2sql($data['SystemSetID']) : $Decision->SystemSetID;
            $Decision->ParentID = isset($data['ParentID']) ? Convert::raw2sql($data['ParentID']) : $Decision->ParentID;
            $Decision->Content = isset($data['DecisionStatement']) ? Convert::raw2sql($data['DecisionStatement']) : $Decision->Content;
            $Decision->Content = isset($data['DecisionStatement']) ? Convert::raw2sql($data['DecisionStatement']) : $Decision->Content;
            $Decision->YesHashtag = isset($data['YesHashtag']) ? Convert::raw2sql($data['YesHashtag']) : $Decision->YesHashtag;
            $Decision->NoHashtag = isset($data['NoHashtag']) ? Convert::raw2sql($data['NoHashtag']) : $Decision->NoHashtag;
            $Decision->UmHashtag = isset($data['UmHashtag']) ? Convert::raw2sql($data['UmHashtag']) : $Decision->UmHashtag;
            $Decision->write();
            self::$_CurrentDecisionID = $Decision->ID;
            $this->redirect("decision/deciding/".$Decision->ID);
        }
        if(isset($data['Actor']) && !is_null($data['Actor'])){
            $Outcome = new Outcome();
            $Outcome->ID = isset($data['DecisionID']) ? intval($data['DecisionID']) : intval($Decision->ID);
            $Outcome->Actor = Convert::raw2sql($data['Actor']);
            $Outcome->DecisionID = isset($data['DecisionID']) ? intval($data['DecisionID']) : intval($Decision->ID);
            //var_dump($Outcome);
            //die();
            $Outcome->write();
            return true;
        }
        return false;
    }

    public function WriteSystemSet($data){
        if(!empty($data['SystemSetID'])){
            $SystemSetID = intval($data['SystemSetID']);
            $SystemSet = SystemSet::get_by_id('SystemSet',$SystemSetID);
        } elseif(isset($data['Name'])) {
            $SystemSet = new SystemSet();
        }
        if(!empty($data['Name'])){
            $SystemSet->Name = Convert::raw2sql($data['Name']);
            $SystemSet->write();
            self::$_CurrentSystemSetID = $SystemSet->ID;
        }
    }
    
    public function deleteDecision(){
           $Decision = Decision::get_by_id('Decision',self::$_CurrentDecisionID);
           $Decision->delete();
           return $this->renderWith(array('DeleteDecision', 'Page'));
    }

    public function writeFactor($data){           
        if(isset($data['DecidingFactorContent'])){
            if(isset($data['DecidingFactorID'])) {
              $DecidingFactor = DecidingFactor::get_by_id('DecidingFactor',Convert::raw2sql($data['DecidingFactorID']));
            } else {
              $DecidingFactor = new DecidingFactor();
            }
            $DecidingFactor->Content = isset($data['DecidingFactorContent']) ? Convert::raw2sql($data['DecidingFactorContent']) : $DecidingFactor->Content;
            $DecidingFactor->DecisionID = intval($data['DecisionID']);
            $DecidingFactor->ArgumentSide = isset($data['ArgumentSide']) ? Convert::raw2sql($data['ArgumentSide']) : $DecidingFactor->ArgumentSide;
            $DecidingFactor->write();
        }
    }                          

    public function writeOptionsGroup($data){
        if(isset($data['Name'])){
            $OptionsGroup = new OptionsGroup();
            $OptionsGroup->Name = isset($data['Name']) ? Convert::raw2sql($data['Name']) : $OptionsGroup->Name;
            $OptionsGroup->write();
        }
    }
    
    public function OptionsGroupBySet(){
        return DataObject::get('OptionsGroup')->filter('SystemSetID',self::$_CurrentSystemSetID);
    }

    public function getDecisionOptions()
    {
        $Decisions = DataObject::get('Decision');
        if($Decisions)
        {
            $map = $Decisions->map('ID', 'Content', 'Please Select');
            return $map;
        }
        else
        {
            return array('No Decisions found');
        }
    }

    public function getSystemSetOptions()
    {
        if($SystemSets = DataObject::get('SystemSet'))
        {
            return $SystemSets->map('ID', 'Name', 'Please Select');
        }
        else
        {
            return array('No Decision Sets found');
        }
    }

    public function getCurrentDecisionID(){
        return self::$_CurrentDecisionID;
    }

    public function getCurrentVoterID(){
        if(Member::currentUserID() != 0){
            return Member::currentUserID();
        }
        return false;
    }

    public function DecisionContent(){
        if(self::$_CurrentDecisionID != 0){
            $Decision = DataObject::get_by_id('Decision',self::$_CurrentDecisionID);
            if(isset($Decision)){
                return $Decision->Content;
            }
        }
        return false;
    }                              
    
    public function FactorIntoYes(){
    }                              
    
    public function FactorIntoNo(){
    }
    
    public function FactorDecisionContent(){
        if(self::$_CurrentDecisionID != 0){
            $Decision = DataObject::get_by_id('Decision',self::$_CurrentDecisionID);
            if(isset($Decision)){
                return $Decision->Content;
            }
        }
        return false;
    }

    public function YesHashtagContent(){
        if(self::$_CurrentDecisionID != 0){
            $Decision = DataObject::get_by_id('Decision',self::$_CurrentDecisionID);
            if(isset($Decision)){
                return $DecisionF->YesHashtag;
            }
        }
        return false;
    }                                        

    public function NoHashtagContent(){
        if(self::$_CurrentDecisionID != 0){
            $Decision = DataObject::get_by_id('Decision',self::$_CurrentDecisionID);
            if(isset($Decision)){
                return $Decision->NoHashtag;
            }
        }
        return false;
    }                                        

    public function UmHashtagContent(){
        if(self::$_CurrentDecisionID != 0){
            $Decision = DataObject::get_by_id('Decision',self::$_CurrentDecisionID);
            if(isset($Decision)){
                return $Decision->UmHashtag;
            }
        }
        return false;
    }

    public function DecisionStatus(){
        if(self::$_CurrentDecisionID != 0){
            $YesVotes = DataObject::get_by_id('Decision',self::$_CurrentDecisionID);

        }                                   
        return false;
    }

    public function getDecidingFactors(){
        $decidingFactors = DataObject::get('DecidingFactor')->filter('DecisionID',self::$_CurrentDecisionID);
        if($decidingFactors){
          return $decidingFactors;
        }
        return false;
    }

    public function getOutcomes(){
        if(self::$_CurrentDecisionID){
            //return DataObject::get('Outcome')->filter('DecisionID',self::$_CurrentDecisionID);
        }
        return false;
    }

    public function MostRecentDecisions($limit = 60){
        $RecentDecisions = new ArrayList();
        $Decisions = Decision::get()->sort('Created Desc')->limit($limit);
        foreach($Decisions as $Decision){
            $total = Vote::get()->filter(array('DecisionID'=>$Decision->ID))->count();
            if($total != 0){
                $Decision->Total = $total;
                $yes = Vote::get()->filter(array('DecisionID'=>$Decision->ID,'PassFailVote'=>'yes'))->count();
                $no = Vote::get()->filter(array('DecisionID'=>$Decision->ID,'PassFailVote'=>'no'))->count();
                $Decision->yesPercent = ($yes != 0) ? ($yes/$total)*100 : 0;
                $Decision->noPercent = ($no != 0) ? ($no/$total)*100 : 0;
                if($Decision->yesPercent > 66.66){
                    $Decision->Status = 'yes';
                } elseif($Decision->noPercent > 66.66){
                    $Decision->Status = 'no';
                } else {
                    $Decision->Status = 'undetermined';
                }
            } else {
                $Decision->Status = 'undetermined';
                $Decision->yesPercent = '0';
                $Decision->noPrecent = '0';
            }
            $RecentDecisions->push($Decision);
        }
        return $RecentDecisions;
    }

    public function MostRecentSystemSets($limit = 60){
        $RecentSets = new ArrayList();
        $SystemSets = SystemSet::get()->sort('Created Desc')->limit($limit);
        foreach($SystemSets as $Set){
            $RecentSets->push($Set);
        }
        return $RecentSets;
    }

    public function DecisionsInSet(){
        if(self::$_CurrentSystemSetID != 0){
            $DecisionsInSet = Decision::get()->filter('SystemSetID',self::$_CurrentSystemSetID);
            return $DecisionsInSet;
        }
        return false;
    }

    /*
    public function SystemSetTree(){
        $SystemSetTree = new ArrayList();
        $DecisionsInSet = $this->DecisionsInSet();

        $Decision = Decision::get_by_id('Decision','1');

        $eval = '"<li>';
        $nodeCountCallback = null;

        $html = $Decision->getChildrenAsUL(
            null,
            $eval,
            null,
            true,
            $this->ChildDecisions(),
            'numChildren',
            true, // root call
            null,
            $nodeCountCallback
        );
        var_dump($html);
        return $html;
    }
    */

    public function ChildDecisions(){
        $ChildDecisions = Decision::get('Decision')->filter(array('ParentID'=>self::$_CurrentDecisionID));
        if($ChildDecisions){
            return $ChildDecisions;
        }
        return false;
    }

    public function ParentDecision(){
        $Decision = Decision::get_by_id('Decision',self::$_CurrentDecisionID);
        if(isset($Decision->ParentID)){
            $ParentDecision = Decision::get('Decision')->filter(array('ID'=>$Decision->ParentID));
        }
        if(isset($ParentDecision)){
            return $ParentDecision;
        }
        return false;
    }

    public function DecisionVersions(){
        $Decision = Decision::get_by_id('Decision',self::$_CurrentDecisionID);
        $versions = $Decision->allVersions();
        if($versions){
            return $versions;
        }
        return false;
    }

    public function getTwitterYes(){
        $TwitterController = new Twitter_Controller();
        $yesHash = $this->YesHashtagContent();
        $yesTweets = $TwitterController->queryTwitter($yesHash);
        return $yesTweets;
    }

    public function getTwitterNo(){
        $TwitterController = new Twitter_Controller();
        $noHash = $this->NoHashtagContent();
        $noTweets = $TwitterController->queryTwitter($noHash);
        return $noTweets;
    }

    public function getTwitterUm(){
        $TwitterController = new Twitter_Controller();
        $umHash = $this->UmHashtagContent();
        $umTweets = $TwitterController->queryTwitter($umHash);
        return $umTweets;
    }
    
    public function whatDoWeKnow($data = null){
        if($data['DoYouWannaDecide'] == 'no'){
            $this->redirect("decision/mostdecisionactivity/");    
        } elseif($data['DoYouWannaDecide'] == 'yes'){
            $this->redirect("decision/edit/");    
        } 
        $fields = new FieldList();

        $fields->push(new OptionsetField('DoYouWannaDecide','Is there something you need to decide?',array("yes"=>"Yes","no"=>"No, but I could view others decisions.")));
        $ActionText = 'Go';
        $ActionPostPath = '/decision/whatsup';
        
        $actions = new FieldList(
            FormAction::create($ActionPostPath)->setTitle($ActionText)
        );
        
        $form = new Form($this, $ActionPostPath, $fields, $actions);
        // Load the form with previously sent data
        $form->loadDataFrom($this->request->postVars());
        return $form;
        
    }

}