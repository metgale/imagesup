<div class="row-fluid">
    <div class="folders span12">
        <a href="/albums/view/<?php echo $id; ?>">Root</a><br>
        <?php foreach ($folders as $key => $value): ?>
            <?php echo $this->Html->link('Folder' . $value, array('action' => 'view', $id, $value)); ?><br>
        <?php endforeach; ?>
    </div>
</div>