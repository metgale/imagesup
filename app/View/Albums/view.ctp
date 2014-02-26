<ul class=breadcrumb pull-left">
    <li><a href="/albums/index">All albums</a> /</li>
    <li><strong><?php echo $album['Album']['title'] ?> / </strong></li>
</ul>


<div class="row-fluid">
    <h2><?php echo h($album['Album']['title']); ?> / <?php if (!empty($album['Upload'][0]['folder'])): ?>
        <span style='color:#0aaaf1'><?php echo $album['Upload'][0]['folder_title']; ?></span>
        <?php endif; ?>
    </h2>

    <div class="span3">
        <div class="span6">
            <div class="folders">
                <h4>Subfolders</h4>
                <ul>
                    <?php foreach ($folders as $title => $folder): ?>
                        <li><?php echo $this->Html->link($folder, array('action' => 'view', $id, $title)); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php if (!empty($album['Upload'][0])): ?>
            <div class="span6">
                <h4 id="imgname">Gallery</h4>
                <div class="gallery">
                    <?php foreach ($album['Upload'] as $img): ?>
                        <a id="img-<?= $img['id']; ?>" class="galleryimg" href="<?= $this->Html->url(array('action' => 'view', $album['Album']['id'], $img['folder'], '?' => array('imgid' => $img['id']), '#' => 'img-' . $img['id'])); ?>">
                            <img class="thumb" width="165" src="<?= $img['path']; ?>thumb_<?= $img['name']; ?>">
                        </a>
                    <?php endforeach; ?>
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
            <div class="span2 white">
                <div class="imgcontrols">
                    <h4>Controls</h4>
                    <li>Magnify glass <input type="checkbox" id="enable"></li>

                    <ul class="image-controls">
                        <a id="clear" class="btn btn-primary">Clear</a>
                        <li>Brightness: <div id="slider-brightness"></div></li>
                        <li>Contrast: <div id="slider-contrast"></div></li>
                        <li>Invert: <div id="slider-invert"></div></li>
                        <li>Saturation: <div id="slider-saturation"></div></li><br>
                    </ul>
                </div>


            </div>
        </div>
    <?php endif; ?>
</div>
