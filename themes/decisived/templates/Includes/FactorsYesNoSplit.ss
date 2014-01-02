<% if getDecidingFactors %>
<br />
Deciding Factors<br />
<strong>Yes</strong>
<ul>
    <% loop getDecidingFactors('Yes') %>
    <li><span class="edit" id="DecidingFactorID-$ID">$Content</span> <a href="/decision/factor/$DecisionID/?factorid=$ID">full edit</a></li>
    <% end_loop %>
</ul>
<strong>No</strong>
<ul>
    <% loop getDecidingFactors('No') %>
    <li><span class="edit" id="DecidingFactorID-$ID">$Content</span> <a href="/decision/factor/$DecisionID/?factorid=$ID">full edit</a></li>
    <% end_loop %>
</ul>
<strong>Not sure if its yes or no</strong>
<ul>
    <% loop getDecidingFactors %>
    <li><span class="edit" id="DecidingFactorID-$ID">$Content</span> <a href="/decision/factor/$DecisionID/?factorid=$ID">full edit</a></li>
    <% end_loop %>
</ul>
<% end_if %>
