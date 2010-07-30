<?php /* Smarty version 2.6.26, created on 2010-07-14 05:44:44
         compiled from Items.tpl */ ?>
<a href="/items">Items</a> | <a href="/genres">Genres</a>
<?php if ($this->_tpl_vars['Items']): ?>
<h2>Items list</h2>
<ul>
<?php $_from = $this->_tpl_vars['Items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
<li><a href='/items/view/<?php echo $this->_tpl_vars['i']['id']; ?>
'><?php echo $this->_tpl_vars['i']['name']; ?>
</a> <a href='/items/delete/<?php echo $this->_tpl_vars['i']['id']; ?>
'>Delete</a> <a href='/items/edit/<?php echo $this->_tpl_vars['i']['id']; ?>
'>Edit</a></li>
<?php endforeach; endif; unset($_from); ?>
</ul>
<?php endif; ?>

<?php if ($this->_tpl_vars['Item']): ?>
<h3><?php echo $this->_tpl_vars['Item']['name']; ?>
</h3><em>(<?php echo $this->_tpl_vars['Item']['original_name']; ?>
, <?php echo $this->_tpl_vars['Item']['country']; ?>
)</em>, <br/>filmed <?php echo $this->_tpl_vars['Item']['start_filming']; ?>
 to <?php echo $this->_tpl_vars['Item']['end_filming']; ?>

<h3>Genres</h3>
<ul>
<?php $_from = $this->_tpl_vars['Genres']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['i']):
?>
<li><a href='/genres/edit/<?php echo $this->_tpl_vars['i']['id']; ?>
'><?php echo $this->_tpl_vars['i']['name']; ?>
</a></li>
<?php endforeach; endif; unset($_from); ?>
</ul>
<img src="<?php echo $this->_tpl_vars['Item']['poster']; ?>
.jpg" />
<strong>Directed by <?php echo $this->_tpl_vars['Item']['director']; ?>
</strong>
<p>Actors:</p><p><?php echo $this->_tpl_vars['Item']['actors']; ?>
</p>
<h4>Description:</h4>
<p><?php echo $this->_tpl_vars['Item']['description']; ?>
</p>
<?php endif; ?>

<?php if ($this->_tpl_vars['Form']): ?>
<h2>Editing an item</h2>
<table>
<form action='/items/add' method='POST' enctype='multipart/form-data'>
<?php echo $this->_tpl_vars['Form']; ?>

</table>
<input type='submit'>
<?php endif; ?>