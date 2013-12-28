<% if MostRecentDecisions %>
<h2>Decisiones en discusion ahorita</h2>
<p>Decisions Currently in Discussion</p>
<ul>
<% loop MostRecentDecisions %>
    <li><a href="/decision/deciding/$ID">$Content</a> <br />Votes Yes: $yesPercent% <br />Votes No: $noPercent% <br />Status: $Status <br />Total Votes Cast: $Total</li>
<% end_loop %>
</ul>
<% end_if %>
