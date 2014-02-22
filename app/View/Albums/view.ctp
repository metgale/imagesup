<div class="row-fluid">
    <div class="span12">
        <h2>Album: <?php echo h($album['Album']['title']); ?></h2>
		
    </div>
    <div class="row-fluid">
        <div class="span2 gallery">
			<?php foreach ($album['Upload'] as $img): ?>
				<a id="img-<?=$img['id']; ?>" class="galleryimg" href="<?=$this->Html->url(array('action' => 'view', $album['Album']['id'], $img['folder'], '?' => array('imgid' => $img['id']))); ?>">
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
					<p><img id="myimg" src="<?=$image['Upload']['path'] . $image['Upload']['name']; ?>"></p>
					<p><strong><?php echo h($image['Upload']['name']); ?></strong></p>
					<p><?php echo nl2br(h($image['Upload']['description'])); ?></p>
				<?php } ?>
            </div>
        </div>
    </div>
</div>
