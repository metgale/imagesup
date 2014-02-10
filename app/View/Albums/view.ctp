<div class="row-fluid">
	<div class="span9">
		<h2><?php  echo __('Album');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($album['Album']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('user_id'); ?></dt>
			<dd>
				<?php echo h($album['Album']['user_id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Title'); ?></dt>
			<dd>
				<?php echo h($album['Album']['title']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Created'); ?></dt>
			<dd>
				<?php echo h($album['Album']['created']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Edit %s', __('Album')), array('action' => 'edit', $album['Album']['id'])); ?> </li>
			<li><?php echo $this->Form->postLink(__('Delete %s', __('Album')), array('action' => 'delete', $album['Album']['id']), null, __('Are you sure you want to delete # %s?', $album['Album']['id'])); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Albums')), array('action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Album')), array('action' => 'add')); ?> </li>
			<li><?php echo $this->Html->link(__('List %s', __('Sharings')), array('controller' => 'sharings', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Sharing')), array('controller' => 'sharings', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span9">
		<h3><?php echo __('Related %s', __('Sharings')); ?></h3>
	<?php if (!empty($album['Sharing'])):?>
		<table class="table">
			<tr>
				<th><?php echo __('Id'); ?></th>
				<th><?php echo __('Album Id'); ?></th>
				<th><?php echo __('Manager'); ?></th>
				<th><?php echo __('AccessCode'); ?></th>
				<th><?php echo __('Created'); ?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($album['Sharing'] as $sharing): ?>
			<tr>
				<td><?php echo $sharing['id'];?></td>
				<td><?php echo $sharing['album_id'];?></td>
				<td><?php echo $sharing['manager'];?></td>
				<td><?php echo $sharing['accessCode'];?></td>
				<td><?php echo $sharing['created'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'sharings', 'action' => 'view', $sharing['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'sharings', 'action' => 'edit', $sharing['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sharings', 'action' => 'delete', $sharing['id']), null, __('Are you sure you want to delete # %s?', $sharing['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>

	</div>
	<div class="span3">
		<ul class="nav nav-list">
			<li><?php echo $this->Html->link(__('New %s', __('Sharing')), array('controller' => 'sharings', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
