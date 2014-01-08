<% include SideBar %>
<div class="content-container unit size3of4 lastUnit">
	<article>
		$SystemSetForm
	</article>           
	<a href="/decision/deleteSystemset/0/$getSystemSetID">Delete System Set</a>
<div class="clearFix">&nbsp;</div>
<div class="floatHalfWidth">
    <% if OptionsGroupBySet %>
    OptionGroups occuring in this Set
    <ul>
    <% loop OptionsGroupBySet %>
    <li>$Name</li>
    <% end_loop%>
    <ul>
    <% end_if %>
</div>	
<div class="floatHalfWidth">
  <% if DecisionsInSet %>
  <ul>
  <% loop DecisionsInSet %>
  <li><a href="/decision/deciding/$ID">$Content</a></li>
  <% end_loop%>
  <ul>
  <% end_if %>
</div>
</div>