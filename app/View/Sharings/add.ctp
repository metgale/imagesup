<ul class=breadcrumb pull-left">
    <li><a href="/albums/index">All albums</a> /</li>
    <li><strong>Share album / </strong></li>
</ul>
    <div class="row-fluid">
        <div class="span9">
            <?php echo $this->BootstrapForm->create('Sharing', array('class' => 'form-horizontal')); ?>
            <fieldset>
                <legend><?php echo __('You are about to share album: ' . $album['Album']['title']); ?></legend>
                <?php
                echo $this->BootstrapForm->input('album_id', array(
                    'value' => $album['Album']['id'],
                    'type' => 'hidden'
                ));
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
        <legend>Number of images in album: <?php echo $total; ?></legend>
    </div>