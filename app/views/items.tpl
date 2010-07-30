<a href="/items">Items</a> | <a href="/genres">Genres</a>
{if $Items}
<h2>Items list</h2>
<ul>
{foreach from=$Items key=k item=i}
<li><a href='/items/view/{$i.id}'>{$i.name}</a> <a href='/items/delete/{$i.id}'>Delete</a> <a href='/items/edit/{$i.id}'>Edit</a></li>
{/foreach}
</ul>
{/if}

{if $Item}
<h3>{$Item.name}</h3><em>({$Item.original_name}, {$Item.country})</em>, <br/>filmed {$Item.start_filming} to {$Item.end_filming}
<h3>Genres</h3>
<ul>
{foreach from=$Genres key=k item=i}
<li><a href='/genres/edit/{$i.id}'>{$i.name}</a></li>
{/foreach}
</ul>
<img src="{$Item.poster}.jpg" />
<strong>Directed by {$Item.director}</strong>
<p>Actors:</p><p>{$Item.actors}</p>
<h4>Description:</h4>
<p>{$Item.description}</p>
{/if}

{if $Form}
<h2>Editing an item</h2>
<table>
<form action='/items/add' method='POST' enctype='multipart/form-data'>
{$Form}
</table>
<input type='submit'>
{/if}