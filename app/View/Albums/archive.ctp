<div class="row-fluid archive">
    <div class="span7">
        <h2 class="red">Archive</h2>
        <a style="padding-left: 5px;" href="/albums/index">Back to albums</a>

        <table class="table">
            <tr>
                <th><?php echo $this->BootstrapPaginator->sort('title'); ?></th>
                <th><?php echo $this->BootstrapPaginator->sort('patient'); ?></th>
                <th><?php echo $this->BootstrapPaginator->sort('shared'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($inactivesharings as $inactivesharing): ?>
                <tr>
                    <td><?php echo h($inactivesharing['Album']['title']); ?>&nbsp;</td>
                    <td><?php echo h($inactivesharing['Album']['User']['firstname']); ?> <?php echo h($inactivesharing['Album']['User']['lastname']); ?>&nbsp;</td>
                    <td><?php echo h($inactivesharing['Sharing']['created']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $inactivesharing['Album']['id'], '?' => array('sharing_id' => $inactivesharing['Sharing']['id']))); ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
        <?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} albums out of {:count} total, starting on album {:start}, ending on {:end}'))); ?>
        <?php echo $this->BootstrapPaginator->pagination(); ?>
    </div>
</div>