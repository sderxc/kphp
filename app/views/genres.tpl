<a href="/items">Items</a> | <a href="/genres">Genres</a>
{if $Genres}
<h2>Genres list</h2>
<ul>
{foreach from=$Genres key=k item=i}
<li>{$i.name} <a href='/genres/delete/{$i.id}'>Delete</a> <a href='/genres/edit/{$i.id}'>Edit</a></li>
{/foreach}
</ul>
{/if}
{if $Form}
<h2>Editing a genre</h2>
<table>
<form action='/genres/add' method='POST'>
{$Form}
</table>
<input type='submit'>
{/if}