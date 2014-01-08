<% if getDecidingFactors %>
<br />
Deciding Factors<br />
<div class="floatFullWidth">
<strong>Not sure if its yes or no</strong>
<ul id="sortunsure" class="connectedSortable">
    <% loop getDecidingFactors %>
    <li><span class="edit" id="DecidingFactorID-$ID">$Content</span> <a href="/decision/factor/$DecisionID/?factorid=$ID">full edit</a></li>
    <% end_loop %>
</ul>
</div>
<div class="floatHalfWidth">
<strong>Yes</strong>
<ul id="sortyes" class="connectedSortable">
    <% loop getDecidingFactors('Yes') %>
    <li><span class="edit" id="DecidingFactorID-$ID">$Content</span> <a href="/decision/factor/$DecisionID/?factorid=$ID">full edit</a></li>
    <% end_loop %>
</ul>
</div>
<div class="floatHalfWidth">
<strong>No</strong>
<ul id="sortno" class="connectedSortable">
    <% loop getDecidingFactors('No') %>
    <li><span class="edit" id="DecidingFactorID-$ID">$Content</span> <a href="/decision/factor/$DecisionID/?factorid=$ID">full edit</a></li>
    <% end_loop %>
</ul>
</div>
<% end_if %>
