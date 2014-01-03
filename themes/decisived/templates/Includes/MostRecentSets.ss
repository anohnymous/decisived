<% if MostRecentSystemSets %>
<h2>System Sets</h2>
<p>Familias de los decisiónes.</p>
<ul>
<% loop MostRecentSystemSets %>
    <li><a href="/decision/systemset/0/$ID">$Name</a></li>
<% end_loop %>
</ul>
<% end_if %>
