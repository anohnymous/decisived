<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
	  <div class="decisionWrap">
		<h1>$DecisionContent</h1>
		<a href="/decision//edit/$getCurrentDecisionID">Edit</a><br />
		<% if CurrentMember %>
		<a href="/voter/CastVote/$getCurrentDecisionID/$getCurrentVoterID">Vote</a><br />
		<a href="/decision/deleteDecision/$getCurrentDecisionID">Delete Decision</a>
		<% else %>
        <a href="/voter/register">Register to Vote</a>
		<% end_if %>
		<br />
		<a href="/decision/factor/$getCurrentDecisionID">Add Deciding Factors</a>
		<div class="content">$DecisionStatus</div>
		<!--
		<br />   
		Yes Hashtag: $YesHashtagContent<br />            
		No Hashtag: $NoHashtagContent<br />              
		Undecided Hashtag: $UmHashtagContent<br />
		-->
		</div>
	</article>
	<div>
	    <% include FactorsYesNoSplit %>
		<% if 0 %>
		    <ul>Previous versions of this statement
		    <% loop DecisionVersions %>
                <li>Version $Version : $Content</li>
		    <% end_loop %>
		    </ul>
		<% end_if %>

        <% if ParentDecision %>
        <ul> Parent
        <% loop ParentDecision %>
            <li>$Content</li>
        <% end_loop %>
        </ul>
        <% end_if %>

        <% if ChildDecisions %>
        <ul> Children
        <% loop ChildDecisions %>
            <li>$Content</li>
        <% end_loop %>
        </ul>
        <% end_if %>  
	    <% include Expenditures %>
	    <% include ParseDecision %>
	    <% if getOutcomes %>
	        Outcomes
	        <ul>
            <% loop $getOutcomes %>
                <li>$Content</li>
            <% end_loop %>
            </ul>
	    <% end_if %>
	    <br /><br />
	    <div id="CurrentDecisionsFactors">
	    <%-- include DecidingFactor !--%>
	    </div>
	</div>
    </div>
</div>