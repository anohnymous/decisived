<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		<div class="content">
		Remember you want to phrase your decision so yes or no responses make the most sense.<br />
        	$DecideForm
	        If you aren't sure yet what form your decision might take, just start by seeing if you can find factors to consider on both the yes/no sides.<br /><br /><br />
                $FactorForm
		</div>
<pre>
<div id="result"></div>
</pre>
	</article>
	    <div>
	    <br />
	    $DecisionContent
	    <%-- include ParseDecision !--%>
	    <% include FactorsYesNoSplit %>
            </div>
        $PageComments
</div>