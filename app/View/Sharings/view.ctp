<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Sharing');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($sharing['Sharing']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Album'); ?></dt>
			<dd>
				<?php echo $this->Html->link($sharing['Album']['title'], array('controller' => 'albums', 'action' => 'view', $sharing['Album']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Manager'); ?></dt>
			<dd>
				<?php echo h($sharing['Sharing']['manager']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('AccessCode'); ?></dt>
			<dd>
				<?php echo h($sharing['Sharing']['accessCode']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Created'); ?></dt>
			<dd>
				<?php echo h($sharing['Sharing']['created']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Sharing')), array('action' => 'edit', $sharing['Sharing']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Sharing')), array('action' => 'delete', $sharing['Sharing']['id']), null, __('Are you sure you want to delete # %s?', $sharing['Sharing']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sharings')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sharing')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Albums')), array('controller' => 'albums', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Album')), array('controller' => 'albums', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

