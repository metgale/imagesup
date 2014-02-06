    <div class="span12">
        <h1>Register</h1>
        <hr>
        <?php echo $this->Form->create('User', array('class' => 'form-horizontal')); ?>
            <?php
            echo $this->Form->input('email', array(
                'required' => 'required'
            ));
            echo $this->Form->input('firstname', array(
                'required' => 'required'
            ));
            echo $this->Form->input('lastname', array(
                'required' => 'required'
            ));
             echo $this->Form->input('password', array(
                'required' => 'required'
            ));
            ?>
            <?php echo $this->Form->submit(__('Register'), array('class' => 'btn btn-primary')); ?>
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="span3">
        <div class="well" style="padding: 8px 0; margin-top:8px;">
            <ul class="nav nav-list">
                <li class="nav-header"><?php echo __('Actions'); ?></li>
                <li><?php echo $this->Html->link(__('List %s', __('Users')), array('action' => 'index')); ?></li>
            </ul>
        </div>
    </div>
</div>