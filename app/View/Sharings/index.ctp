<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Sharings'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('album_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('manager');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('accessCode');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('created');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($sharings as $sharing): ?>
			<tr>
				<td><?php echo h($sharing['Sharing']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($sharing['Album']['title'], array('controller' => 'albums', 'action' => 'view', $sharing['Album']['id'])); ?>
				</td>
				<td><?php echo h($sharing['Sharing']['manager']); ?>&nbsp;</td>
				<td><?php echo h($sharing['Sharing']['accessCode']); ?>&nbsp;</td>
				<td><?php echo h($sharing['Sharing']['created']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $sharing['Sharing']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $sharing['Sharing']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $sharing['Sharing']['id']), null, __('Are you sure you want to delete # %s?', $sharing['Sharing']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Sharing')), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Albums')), array('controller' => 'albums', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Album')), array('controller' => 'albums', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>