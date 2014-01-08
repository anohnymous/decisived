<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>Decisions, Decisions</h1>
		<div class="content">


<h4>Systems and Decisions: three assumptions:</h4>

<p>
!! but first, definitions</br>
<b>Operations</b> A series of decisions executed in order(s).</br>
<b>Definitions</b> : Everything.</p>

<p>
<b>assumptions</b><br />
"Everything is a Decision."<br />
"A fully normalized decision statement must be expressed in a yes or 
no format."<br />
"A system can be expressed as a totality of its Decisions, 
Operations, and Definitions."<br />
</p>            

<p>Building a tool that could be used to model these and determine if 
these assumptions are valid or provide insight into systems is a useful 
undertaking.</p>

<p>According to Donella Meadows, the best thing to do when processing 
systems is dance, and the first place to start is observation.  
The first step in this process could be working on phrasing decision 
statements clearly in binary ways.<p>

		    <!--
		    <p>Un decisión en forma normal es cuando la respuesta es sola si o no. A normalized form for a decision statement is yes or no.</p>
		    <p>Decisions can have Deciding Factors which are like talking points to track conversation.</p>
		    <p>A Decision can have Outcomes.  Outcomes can be voted on.  Outcomes don't require normalized statement form, and can be thought of as approved or disproved.</p>
		    -->
		    <p><b><a href="/decision/edit">Start Deciding</a></b></p>
		</div>
	</article>
<div class="floatHalfWidth">
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
<div class="floatHalfWidth">
	    <% if MostRecentDecisions %>
	    <h2>Decisiones en discusion ahorita</h2>
	    <p>Decisions Currently in Discussion</p>
	    <ul>
	    <% loop MostRecentDecisions %>
	        <li><a href="/decision/deciding/$ID">$Content</a> <br />Votes Yes: $yesPercent% <br />Votes No: $noPercent% <br />Status: $Status <br />Total Votes Cast: $Total</li>
	    <% end_loop %>
	    </ul>
	    <% end_if %>
</div>
