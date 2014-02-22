<div class="row-fluid">
    <div class="span12">
        <div class="folders" style="padding-top:30px; padding-bottom:30px">
            <a   href="/albums/view/<?php echo $id; ?>">Root</a> |
            <?php foreach ($folders as $key => $value): ?>
                <?php echo $this->Html->link('Folder' . $value, array('action' => 'view', $id, $value)); ?> |
            <?php endforeach; ?>
        </div>
        <?php ?>
        <h2>Album: <?php echo h($album['Album']['title']);  ?> / <?php if ($album['Upload'][0]['folder'] == null): ?>
            <span style='color:#0aaaf1'>Root</span>
            <?php else: ?>
            <span style='color:#0aaaf1'>Folder <?php echo $album['Upload'][0]['folder']; ?></span>
            <?php endif; ?>

        </h2>

    </div>
    <div class="row-fluid">
        <div class="span2 gallery">
            <?php foreach ($album['Upload'] as $img): ?>
                <a id="img-<?= $img['id']; ?>" class="galleryimg" href="<?= $this->Html->url(array('action' => 'view', $album['Album']['id'], $img['folder'], '?' => array('imgid' => $img['id']))); ?>">
                    <img width="165" src="<?= $img['path']; ?>thumb_<?= $img['name']; ?>">
                </a>
            <?php endforeach; ?>
        </div>

        <div class="span9">
            <div class="imageview">
                <?php if (!empty($image)) { ?>
                    <div class="image-controls well">
                        <div class="span2">Brightness: <div id="slider-brightness"></div></div>
                        <div class="span2">Contrast: <div id="slider6"></div></div>
                        <div class="span2">Invert: <div id="slider5"></div></div>
                        <div class="span2">Grayscale: <div id="slider3"></div></div>
                    </div>
                    <br>
                    <p><img id="myimg" src="<?= $image['Upload']['path'] . $image['Upload']['name']; ?>"></p>
                    <p><strong><?php echo h($image['Upload']['name']); ?></strong></p>
                    <p><?php echo nl2br(h($image['Upload']['description'])); ?></p>
                <?php } ?>
            </div>
            <div class="span9">
                <?php if (!empty($neighbors['prev'])): ?>
                    <?php echo $this->Html->link('Previous', array('action' => 'view', $neighbors['prev']['Upload']['album_id'], $neighbors['prev']['Upload']['folder'], '?' => array('imgid' => $neighbors['prev']['Upload']['id'])), array('class' => 'btn btn-primary')); ?>
                <?php else: ?>
                    <div class="btn btn-primary disabled">Previous</div>
                <?php endif; ?>
                <?php if (!empty($neighbors['next'])): ?>
                    <?php echo $this->Html->link('Next', array('action' => 'view', $neighbors['next']['Upload']['album_id'], $neighbors['next']['Upload']['folder'], '?' => array('imgid' => $neighbors['next']['Upload']['id'])), array('class' => 'btn btn-primary')); ?>
                <?php else: ?>
                    <div class="btn btn-primary disabled">Next</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
