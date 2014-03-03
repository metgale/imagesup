<?php
$currentId = $image['Upload']['id'];
if ($this->request->query('imgid')) {
    $currentId = $this->request->query('imgid');
}
if (isset($albums['Upload']['0'])) {
    $currentId = $albums['Upload']['0']['id'];
}

$next = null;
$prev = null;
$imageIds =Hash::extract($album['Upload'], '{n}.id');
foreach($imageIds as $key => $imageId) {
    if ($imageId != $currentId) {
        continue;
    }
    if (isset($imageIds[$key+1])) {
        $next = $imageIds[$key+1];
    }
    if (isset($imageIds[$key-1])) {
        $prev = $imageIds[$key-1];
    }
}
// uncomment to debug vars
// debug(array('$imageIds'=>$imageIds, '$currentId'=>$currentId, '$next'=>$next, '$prev'=>$prev));
?>

<?php if (count($album['Upload']) === 0): ?>
 <ul class=breadcrumb pull-left">
    <li><a href="/albums/index">All Image Studies</a> /</li>
</ul>
<h2>No images in this album.</h2>
<?php return; endif; ?>

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

<div class="row-fluid albumview">
    <h2><?php echo h($album['Album']['title']); ?> / <?php if (!empty($album['Upload'][0]['folder'])): ?>
            <span style='color:#0aaaf1'><?php echo $album['Upload'][0]['folder_title']; ?></span>
        <?php endif; ?>
    </h2>

    <div class="span4">
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
                        <?php foreach ($album['Upload'] as $img): ?>              
                        <a id="img-<?= $img['id']; ?>" class="galleryimg" href="<?= $this->Html->url(array('action' => 'view', $album['Album']['id'], $img['folder'], '?' => array('imgid' => $img['id']), '#' => 'img-' . $img['id'])); ?>">
                            <img class="<?php echo ($img['id'] == $currentId) ? 'highlightthumb' : 'thumb'; ?>" width="165" src="<?= $img['path']; ?>thumb_<?= $img['name']; ?>">
                        </a>
                        <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="span7">
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
                <?php if (!empty($prev)): ?>
                    <?php echo $this->Html->link('Prev', array('action' => 'view', $image['Upload']['album_id'], $image['Upload']['folder'], '?' => array('imgid' => $prev), '#' => 'img-' . $prev), array('class' => 'btn btn-primary neigh')); ?>
                <?php else: ?>
                    <div class="neigh btn btn-primary disabled">Prev</div>
                <?php endif; ?>
                <?php if (!empty($next)): ?>
                    <?php echo $this->Html->link('Next', array('action' => 'view',  $image['Upload']['album_id'], $image['Upload']['folder'], '?' => array('imgid' => $next), '#' => 'img-' . $next), array('class' => 'btn btn-primary neigh')); ?>
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

