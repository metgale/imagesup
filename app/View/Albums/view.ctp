<?php if ($count != 0): ?>
    <ul class=breadcrumb pull-left">
        <li><a href="/albums/index">All Image Studies</a> /</li>
        <li><strong><?php echo $album['Album']['title'] ?> / </strong></li>
    </ul>

    <?php
    if (AuthComponent::user('userType') == 1) {
        echo '<h4>Patient: ' . $album['User']['lastname'] . ' ' . $album['User']['firstname'] . ', email: ' . $album['User']['email'] . '</h4>';
    } else {
        echo $this->Html->link(__('Share image study'), array('controller' => 'sharings', 'action' => 'add', $album['Album']['id']), array('class' => 'btn btn-primary'));
    }
    ?>


    <div class="row-fluid">
        <h2><?php echo h($album['Album']['title']); ?> / <?php if (!empty($album['Upload'][0]['folder'])): ?>
                <span style='color:#0aaaf1'><?php echo $album['Upload'][0]['folder_title']; ?></span>
            <?php endif; ?>
        </h2>

        <div class="span3">
            <div class="span6">
                <div class="folders text-left">
                    <h4>Subfolders</h4>
                    <ul>
                        <?php foreach ($folders as $title => $folder): ?>
                            <li><?php echo $this->Html->link($folder, array('action' => 'view', $id, $title), array('class' => 'subfolders')); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="span6">
                <h4 id="imgname">Gallery</h4>
                <div class="gallery">
                    <div class="thumbimage">
                        <?php if (($this->request->query('imgid'))): ?>
                            <?php foreach ($album['Upload'] as $img): ?>              
                                <?php if ($this->request->query('imgid') == $img['id']): ?>
                                    <a id="img-<?= $img['id']; ?>" class="galleryimg" href="<?= $this->Html->url(array('action' => 'view', $album['Album']['id'], $img['folder'], '?' => array('imgid' => $img['id']), '#' => 'img-' . $img['id'])); ?>">
                                        <img class="highlightthumb" width="165" src="<?= $img['path']; ?>thumb_<?= $img['name']; ?>">
                                    </a>
                                <?php else: ?>
                                    <a id="img-<?= $img['id']; ?>" class="galleryimg" href="<?= $this->Html->url(array('action' => 'view', $album['Album']['id'], $img['folder'], '?' => array('imgid' => $img['id']), '#' => 'img-' . $img['id'])); ?>">
                                        <img class="thumb"  src="<?= $img['path']; ?>thumb_<?= $img['name']; ?>">
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <a id="img-<?= $album['Upload'][0]['id']; ?>" class="galleryimg" href="<?= $this->Html->url(array('action' => 'view', $album['Album']['id'], $album['Upload'][0]['folder'], '?' => array('imgid' => $album['Upload'][0]['id']), '#' => 'img-' . $album['Upload'][0]['id'])); ?>">
                                <img class="highlightthumb" src="<?= $album['Upload'][0]['path']; ?>thumb_<?= $album['Upload'][0]['name']; ?>">
                            </a>
                            <?php foreach ($album['Upload'] as $img): ?> 
                                <?php if ($album['Upload'][0]['id'] != $img['id']): ?>
                                    <a id="img-<?= $img['id']; ?>" class="galleryimg" href="<?= $this->Html->url(array('action' => 'view', $album['Album']['id'], $img['folder'], '?' => array('imgid' => $img['id']), '#' => 'img-' . $img['id'])); ?>">
                                        <img class="thumb"  src="<?= $img['path']; ?>thumb_<?= $img['name']; ?>">
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="span8">
            <div class="span8">
                <h4 id="imgname"><?php echo $image['Upload']['name']; ?></h4>
                <div class="imageview">
                    <?php if (!empty($image)) { ?>
                        <br>
                        <p><img id="myimg" src="<?= $image['Upload']['path'] . $image['Upload']['name']; ?>"></p>
                    </div>
                    <div class="span4">
                        <a href="#imagedetails" id="toggleview">Show image details</a>
                        <p id="imagedetails">
                            <?php echo nl2br(h($image['Upload']['description'])); ?>
                        </p>
                    </div>
                <?php } ?>
                <div class="span6">
                    <?php if (!empty($neighbors['prev'])): ?>
                        <?php echo $this->Html->link('Prev', array('action' => 'view', $neighbors['prev']['Upload']['album_id'], $neighbors['prev']['Upload']['folder'], '?' => array('imgid' => $neighbors['prev']['Upload']['id'], '#' => 'img-' . $neighbors['prev']['Upload']['id'])), array('class' => 'btn btn-primary neigh')); ?>
                    <?php else: ?>
                        <div class="neigh btn btn-primary disabled">Prev</div>
                    <?php endif; ?>
                    <?php if (!empty($neighbors['next'])): ?>
                        <?php echo $this->Html->link('Next', array('action' => 'view', $neighbors['next']['Upload']['album_id'], $neighbors['next']['Upload']['folder'], '?' => array('imgid' => $neighbors['next']['Upload']['id'], '#' => 'img-' . $neighbors['next']['Upload']['id'])), array('class' => 'btn btn-primary neigh')); ?>
                    <?php else: ?>
                        <div class="neigh btn btn-primary disabled">Next</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="span4 white">
                <div class="imgcontrols">
                    <h4>Controls</h4>
                    <li class="enable" name="enable" value="Magnify Glass"><input type="checkbox" id="enable">Magnify glass</li>
                    <ul class="image-controls">
                        <li>Brightness: <div id="slider-brightness"></div></li>
                        <li>Contrast: <div id="slider-contrast"></div></li>
                        <li>Invert: <div id="slider-invert"></div></li>
                        <!-- <li>Saturation: --> <div style="display: none;" id="slider-saturation"></div>  <!-- </li> -->   
                        <a id="clear" class="btn btn-primary">Clear</a>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <ul class=breadcrumb pull-left">
        <li><a href="/albums/index">All Image Studies</a> /</li>
    </ul>
    <h2>No images in this album.</h2>
<?php endif; ?>
