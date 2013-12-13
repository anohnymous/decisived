<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		    <ul>Previous versions of this statement
		    <% loop DecisionVersions %>
                <li>Version $Version : $Content</li>
		    <% end_loop %>
		$DecideForm
</div>