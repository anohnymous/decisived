<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<%-- <h1>Decisions, Decisions</h1> --%>
		<div class="content">
		    <p>Un decisión en forma normal es cuando la respuesta es sola si o no. A normalized form for a decision statement is yes or no.</p>
		    <!--
		    <p>Decisions can have Deciding Factors which are like talking points to track conversation.</p>
		    <p>A Decision can have Outcomes.  Outcomes can be voted on.  Outcomes don't require normalized statement form, and can be thought of as approved or disproved.</p>
		    -->
		    <p><b><a href="/decision/edit">Start Deciding</a></b></p>
		</div>
	</article>
<div class="float50percent">
	    <% if MostRecentSystemSets %>
	    <h2>System Sets</h2>
	    <p>Familias de los decisiónes.</p>
	    <ul>
	    <% loop MostRecentSystemSets %>
	        <li><a href="/decision/systemset/0/$ID">$Name</a></li>
	    <% end_loop %>
	    </ul>
	    <% end_if %>
</div>
<div class="float50percent">
	    <% if MostRecentDecisions %>
	    <h2>Decisiones en discusion ahora</h2>
	    <p>Decisions Currently in Discussion</p>
	    <ul>
	    <% loop MostRecentDecisions %>
	        <li><a href="/decision/deciding/$ID">$Content</a> <br />Votes Yes: $yesPercent% <br />Votes No: $noPercent% <br />Status: $Status <br />Total Votes Cast: $Total</li>
	    <% end_loop %>
	    </ul>
	    <% end_if %>
</div>