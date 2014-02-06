<div class="row-fluid">
	<div class="span9">
		<?php echo $this->BootstrapForm->create('Sharing', array('class' => 'form-horizontal'));?>
			<fieldset>
				<legend><?php echo __('Add %s', __('Sharing')); ?></legend>
				<?php
				echo $this->BootstrapForm->input('album_id', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('manager', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('accessCode', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				?>
				<?php echo $this->BootstrapForm->submit(__('Submit'));?>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Sharings')), array('action' => 'index'));?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Albums')), array('controller' => 'albums', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Album')), array('controller' => 'albums', 'action' => 'add')); ?></li>
		</ul>
		</div>
	</div>
</div>