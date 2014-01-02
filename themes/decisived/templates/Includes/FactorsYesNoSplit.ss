<% if getDecidingFactors %>
<br />
Deciding Factors<br />
<strong>Yes</strong>
<ul>
    <% loop getDecidingFactors('Yes') %>
    <li><div id="FactorID$ID">$Content</div> <a href="/decision/factor/$DecisionID/?factorid=$ID" onClick="EditFactor('FactorID$ID')">edit</a></li>
    <% end_loop %>
</ul>
<strong>No</strong>
<ul>
    <% loop getDecidingFactors('No') %>
    <li>$Content <a href="/decision/factor/$DecisionID/?factorid=$ID">edit</a></li>
    <% end_loop %>
</ul>
<strong>Not sure if its yes or no</strong>
<ul>
    <% loop getDecidingFactors %>
    <li>$Content <a href="/decision/factor/$DecisionID/?factorid=$ID">edit</a></li>
    <% end_loop %>
</ul>
<% end_if %>
