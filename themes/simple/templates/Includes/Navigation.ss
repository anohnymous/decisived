<nav class="primary">
	<ul>
	    <li><a href="/">Decisions</a></li>
	    <li><a href="/decision/systemset">System Sets</li>
      <li><a href="/districtmap">Maps</li>
	    <% if CurrentMember %>
      <li><a href="/voter/logout">Logout</a></li>
      <li><a href="/voter/index">My Current Votes</a></li>
	    <% else %>
	    <li><a href="/voter/register">Login or Register</a></li>
	    <% end_if %>
	</ul>
</nav>
