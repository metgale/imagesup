<div class="row-fluid">

    <div class="span9">
        <?php echo $this->BootstrapForm->create('Sharing', array('class' => 'form-horizontal')); ?>
        <fieldset>
            <legend><?php echo __('You are about to share album: ' . $album['Album']['title']); ?></legend>
            <?php
            echo $this->BootstrapForm->input('album_id', array(
                'value' => $album['Album']['id'],
                'type' => 'hidden',
                'required' => 'required',
                'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
            );
            echo $this->BootstrapForm->input('manager', array(
                'label' => 'Share with doctor',
                'options' => $manager,
                'required' => 'required')
            );
            ?>
            <?php echo $this->BootstrapForm->submit(__('Submit'), array('class' => 'btn btn-primary')); ?>
        </fieldset>
        <?php echo $this->BootstrapForm->end(); ?>
    </div>
    <div class="span3">
        <div class="well" style="padding: 8px 0; margin-top:8px;">
            <ul class="nav nav-list">
                <li class="nav-header"><?php echo __('Actions'); ?></li>
                <li><?php echo $this->Html->link(__('List %s', __('Sharings')), array('action' => 'index')); ?></li>
                <li><?php echo $this->Html->link(__('List %s', __('Albums')), array('controller' => 'albums', 'action' => 'index')); ?></li>
                <li><?php echo $this->Html->link(__('New %s', __('Album')), array('controller' => 'albums', 'action' => 'add')); ?></li>
            </ul>
        </div>
    </div>
</div>