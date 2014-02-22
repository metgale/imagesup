
<table role="presentation" class="table table-condensed">
	<tbody class="uploaded-files">
	<?php foreach ($files as $file) { ?>
	<tr>
		<td>
		<a href="<?php echo $file['Upload']['path'] . $file['Upload']['name'];?>">
		<?php if (in_array($file['Upload']['type'], array('image/jpeg', 'image/png'))) { ?>
			<img src="<?=$file['Upload']['path'];?>thumb_<?=$file['Upload']['name'];?>">
		<?php } else { ?>
			<p>Download</p>
		<?php } ?>
		</a>
		</td>
		<td>
			<p>
				<a href="<?php echo $file['Upload']['path'] . $file['Upload']['name'];?>">
					<strong><?php echo h($file['Upload']['name']); ?></strong>
				</a>
			</p> 
			<p class="small">uploaded: <?php echo h($file['Upload']['created']); ?></p> 
			<p class="small">size: <?php echo $this->Number->toReadableSize($file['Upload']['size']); ?></p>
			<p class="small">folder: "<?php echo h($file['Upload']['folder']); ?>"</p>
			<p>
			<button class="btn btn-small cancel">
				<i class="glyphicon glyphicon-ban-circle"></i>
				<span>Delete</span>
			</button>
			</p> 
		</td>
	</tr>
	<?php } ?>
	</tbody>
</table>