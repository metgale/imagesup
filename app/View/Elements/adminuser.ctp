<div class="row-fluid admin">
    <div class="span12">
        <h2 class="green">Unseen shared albums</h2>
        <table class="table">
            <tr>
                <th><?php echo $this->BootstrapPaginator->sort('title'); ?></th>
                <th><?php echo $this->BootstrapPaginator->sort('created'); ?></th>
                <th><?php echo $this->BootstrapPaginator->sort('shared'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($sharings as $sharing): ?>
                <tr>
                    <td><?php echo h($sharing['Album']['title']); ?>&nbsp;</td>
                    <td><?php echo h($sharing['Album']['created']); ?>&nbsp;</td>
                    <td><?php echo h($sharing['Sharing']['created']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $sharing['Album']['id'])); ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
        <?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} albums out of {:count} total, starting on album {:start}, ending on {:end}'))); ?>
        <?php echo $this->BootstrapPaginator->pagination(); ?>
    </div>
     <div class="span12" style="margin-left: 0px; padding-top:50px;">
        <h2 class="red">Seen albums</h2>
        <table class="table">
            <tr>
                <th><?php echo $this->BootstrapPaginator->sort('title'); ?></th>
                <th><?php echo $this->BootstrapPaginator->sort('created'); ?></th>
                <th><?php echo $this->BootstrapPaginator->sort('shared'); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($inactivesharings as $inactivesharings): ?>
                <tr>
                    <td><?php echo h($inactivesharings['Album']['title']); ?>&nbsp;</td>
                    <td><?php echo h($inactivesharings['Album']['created']); ?>&nbsp;</td>
                    <td><?php echo h($inactivesharings['Sharing']['created']); ?>&nbsp;</td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $inactivesharings['Album']['id'])); ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
        <?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} albums out of {:count} total, starting on album {:start}, ending on {:end}'))); ?>
        <?php echo $this->BootstrapPaginator->pagination(); ?>
    </div>
</div>