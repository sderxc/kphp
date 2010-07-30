<?php /* Smarty version 2.6.26, created on 2010-07-14 04:23:04
         compiled from Genres.tpl */ ?>
<a href="/items">Items</a> | <a href="/genres">Genres</a>
<?php if ($this->_tpl_vars['Genres']): ?>
<h2>Genres list</h2>
<ul>
<?php $_from = $this->_tpl_vars['Genres']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
<li><?php echo $this->_tpl_vars['i']['name']; ?>
 <a href='/genres/delete/<?php echo $this->_tpl_vars['i']['id']; ?>
'>Delete</a> <a href='/genres/edit/<?php echo $this->_tpl_vars['i']['id']; ?>
'>Edit</a></li>
<?php endforeach; endif; unset($_from); ?>
</ul>
<?php endif; ?>
<?php if ($this->_tpl_vars['Form']): ?>
<h2>Editing a genre</h2>
<table>
<form action='/genres/add' method='POST'>
<?php echo $this->_tpl_vars['Form']; ?>

</table>
<input type='submit'>
<?php endif; ?>