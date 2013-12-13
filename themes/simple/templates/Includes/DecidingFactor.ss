Que piensas? Escribe aqui para anadir 'Deciding Factors'. Do you have thoughts on this topic?  Add 'Deciding Factors':
$FactorForm
<div style="padding-top:50px">
<% if getDecidingFactors %>
    <h4>Deciding Factors</h4>
    <hr />
  	<ul>
  	<% loop getDecidingFactors %>
          <li>Argument Side: <b>$ArgumentSide</b>   $Content <a href="/decision/factor/$DecisionID/?factorid=$ID">edit</a></li>
      <% end_loop %>
      </ul>
  <% end_if %>