<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">$Content</div>
	</article>
	    <div>
	    <br />
	    $DecisionContent
	    <% loop $getDecidingFactors %>
	        $Content
	    <% end_loop %>
	    <% loop $getOutcomes %>
	        $Content
	    <% end_loop %>
	    </div>
	    $Form
		$DecideForm
        $PageComments
</div>