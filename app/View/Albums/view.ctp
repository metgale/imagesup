<div class="row-fluid">
    <div class="span12">
        <h1><?php echo $album['Album']['title']; ?></h1>
        <?php if (AuthComponent::user('userType') == 1 && $sharing['Sharing']['active'] != 0): ?>
            <div class="span9">
                <?php echo $this->BootstrapForm->create('Sharing', array('class' => 'form-horizontal')); ?>
                <fieldset>
                    <legend>Mark album as read</legend>
                    <?php
                    echo $this->BootstrapForm->input('id', array(
                        'required' => 'required',
                        'type' => 'hidden',
                        'value' =>  $sharing['Sharing']['id']
                    ));
                    echo $this->BootstrapForm->input('active', array(
                        'required' => 'required',
                        'type' => 'hidden',
                        'value' => 0
                    ));
                    echo $this->BootstrapForm->input('album_id', array(
                        'required' => 'required',
                        'type' => 'hidden',
                        'value' => $album['Album']['id']
                    ));
                    echo $this->BootstrapForm->input('manager', array(
                        'type' => 'hidden',
                        'value' => AuthComponent::user('id'),
                        'required' => 'required',
                    ));
                    ?>
                    <?php echo $this->BootstrapForm->submit(__('Mark read and archive this album'), array('class' => 'btn btn-primary')); ?>
                </fieldset>
                <?php echo $this->BootstrapForm->end(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
