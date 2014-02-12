<div class="row-fluid">
    <div class="span9">
        <?php echo $this->BootstrapForm->create('Album', array('class' => 'form-horizontal')); ?>
        <fieldset>
            <legend><?php echo __('Add %s', __('Album')); ?></legend>
            <?php
            echo $this->BootstrapForm->input('user_id', array(
                'type' => 'hidden',
                'value' => AuthComponent::user('id'),
                'required' => 'required',
                'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
            );
            echo $this->BootstrapForm->input('title', array(
                'required' => 'required',
                'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
            );
            ?>
            <?php echo $this->BootstrapForm->submit(__('Submit')); ?>
        </fieldset>
    </div>
 </div>