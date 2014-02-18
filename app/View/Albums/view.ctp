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
                        'value' => $sharing['Sharing']['id']
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
    <div class="span12">

        <div class="span2 gallery">
            <h2>Album</h2>
            <?php foreach ($album['Upload'] as $img): ?>         
                <?php echo $this->Html->Image('/img/' . $img['album_id'] . '/' . $img['name'], array('action' => 'view', $album['Album']['id'] . '/page'), array('class' => 'galleryimg')); ?>
            <?php endforeach; ?>
        </div>
        <div class="span10">
            <div class="span5 imageview">
                <h1>Image</h1>
                <?php echo $this->Html->Image('/img/' . $images[0]['Upload']['album_id'] . '/' . $images[0]['Upload']['name'], array('id' => 'myimg')); ?>
            </div>

            <div class="image-controls span7">
                <div class="span3">
                    <p>Brightness:</p> <div id="slider-brightness"></div>
                    <br>
                    <p>Saturation:</p> <div id="slider-saturation"></div>
                    <br>
                    <p>Contrast:</p> <div id="slider6"></div>
                    <br>
                </div>
                <div class="span3">
                    <p>Sepia:</p> <div id="slider4"></div>
                    <br>
                    <p>Invert:</p> <div id="slider5"></div>
                    <br>
                    <p>Grayscale:</p> <div id="slider3"></div>
                </div>
            </div>
        </div>
        <div class="prevnext text-center span4">
            <?php
            echo $this->Paginator->prev('<');
            echo $this->Paginator->next('>');
            ?>
        </div>
    </div>


</div>
