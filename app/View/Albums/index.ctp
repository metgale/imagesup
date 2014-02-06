<div class="row-fluid">
    <div class="span10">
        <h2><?php echo __('Your %s', __('Albums')); ?></h2>

        <hr>
        <p>
            <?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} albums out of {:count} total, starting on album {:start}, ending on {:end}'))); ?>
        </p>

        <table class="table">
            <tr>
                <th><?php echo $this->BootstrapPaginator->sort('title'); ?></th>
                <th><?php echo $this->BootstrapPaginator->sort('created'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($albums as $album): ?>
                <tr>
                    <td><?php echo h($album['Album']['title']); ?>&nbsp;</td>
                    <td><?php echo h($album['Album']['created']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('Share |'), array('action' => 'share', $album['Album']['id'])); ?>
                        <?php echo $this->Html->link(__('View |'), array('action' => 'view', $album['Album']['id'])); ?>
                        <?php echo $this->Html->link(__('Edit |'), array('action' => 'edit', $album['Album']['id'])); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $album['Album']['id']), null, __('Are you sure you want to delete # %s?', $album['Album']['id'])); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php echo $this->BootstrapPaginator->pagination(); ?>
        <a class="btn btn-primary" href="/albums/add">Add new album</a>

    </div>

</div>