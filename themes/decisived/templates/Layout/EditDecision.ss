<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<div class="content">
		The goal of normalizing decision statements is to create a yes or no statement.<br /><br /><br /><br />
		</div>
		$DecideForm
	</article>
	    <div>
	    <br />
	    $DecisionContent
	    <%-- include ParseDecision !--%>
	    <% if getDecidingFactors %>
  	    <% loop getDecidingFactors %>
  	    Deciding Factors
  	    <br />
  	        $Content
  	    <% end_loop %>
	    <% end_if %>
	    <% loop getOutcomes %>
	        $Content
	    <% end_loop %>
	    </div>
        $PageComments
</div>