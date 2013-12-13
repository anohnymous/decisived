<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>My Voting Record</h1>
		<div class="content">$Content</div>
	</article>
	<% if DecisionVotes %>
	<ul>
	<% loop DecisionVotes %>
	<li><a href="/decision/deciding/$Decision.ID">$Decision.Content</a> <br /><a href="/voter/CastVote/$Decision.ID/$VoterID">I voted $PassFailVote. (click to change)</a></li>
	<% end_loop %>
	</ul>
	<% end_if %>
</div>