	    <% if ParseDecision %>
	        <ul>
            <% loop ParseDecision %>
            <li>$Content</li>
            <% end_loop %>
            </ul>
	    <% end_if %>