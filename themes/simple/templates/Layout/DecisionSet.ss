<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		$DecisionSetForm
	</article>
	    <div>
        <% if DecisionSetTree %>
        <ul>
        <% loop DecisionSetTree %>
        <li>$Content $Pos</li>
        <% end_loop%>
        <ul>
        <% end_if %>
	    </div>
</div>