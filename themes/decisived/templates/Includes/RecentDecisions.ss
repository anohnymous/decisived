<div class="">
<% if MostRecentDecisions %>
<h2>Decisiones Individuales en discusion ahorita</h2>
<p>Individual Decisions Currently in Discussion</p>
<ul>
<% loop MostRecentDecisions %>
    <li><a href="/decision/deciding/$ID">$Content</a> <br />Votes Yes: $yesPercent% <br />Votes No: $noPercent% <br />Status: $Status <br />Total Votes Cast: $Total</li>
<% end_loop %>
</ul>
<% end_if %>
