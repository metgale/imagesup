<div class="row-fluid admin">
    <div class="span7">
        <h2 class="green">Active albums shared with you</h2>
        <a href="/albums/archive">Click here to see archive</a>
        <table class="table">
            <tr>
                <th><?php echo $this->BootstrapPaginator->sort('title'); ?></th>
                <th><?php echo $this->BootstrapPaginator->sort('patient'); ?></th>
                <th><?php echo $this->BootstrapPaginator->sort('shared'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($sharings as $sharing): ?>
                <tr>
                    <td><?php echo h($sharing['Album']['title']); ?>&nbsp;</td>
                    <td><?php echo h($sharing['Album']['User']['firstname']); ?>  <?php echo h($sharing['Album']['User']['lastname']); ?>&nbsp;</td>
                    <td><?php echo h($sharing['Sharing']['created']); ?>&nbsp;</td>

                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $sharing['Album']['id'], '?' => array('sharing_id' => $sharing['Sharing']['id']))); ?>
                       | <?php echo $this->Form->postLink(__('Archive'), array('controller' => 'sharings', 'action' => 'archive', $sharing['Sharing']['id']), null, __('Are you sure you want to archive this album?', $sharing['Sharing']['id'])); ?>

                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
        <?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} albums out of {:count} total, starting on album {:start}, ending on {:end}'))); ?>
        <?php echo $this->BootstrapPaginator->pagination(); ?>
    </div>
</div>