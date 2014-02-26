<div class="row-fluid">
    <div class="span7">

        <h2><?php echo __('Your %s', __('Image Studies')); ?></h2>

        <table class="table">
            <tr>
                <th><?php echo $this->BootstrapPaginator->sort('title'); ?></th>
                <th><?php echo $this->BootstrapPaginator->sort('created'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>

            <?php foreach ($albums as $album): ?>
                <tr>
                    <td><?php echo $this->Html->link($album['Album']['title'], array('action' => 'view', $album['Album']['id'])); ?></td>
                    <td><?php echo h($album['Album']['created']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Share |'), array('controller' => 'sharings', 'action' => 'add', $album['Album']['id'])); ?>
                        <?php echo $this->Html->link(__('Edit |'), array('action' => 'edit', $album['Album']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $album['Album']['id']), null, __('Are you sure you want to delete album: ' . $album['Album']['title'] . '?', $album['Album']['id'])); ?>
                    </td>
                <?php endforeach; ?>

            </tr>
        </table>
        <?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} albums out of {:count} total, starting on album {:start}, ending on {:end}'))); ?>


        <?php echo $this->BootstrapPaginator->pagination(); ?>
        <p><a class="btn btn-primary" style="margin-top:40px; margin-bottom:20px;" href="/albums/add">Add new image study</a></p>  

    </div>




</div>