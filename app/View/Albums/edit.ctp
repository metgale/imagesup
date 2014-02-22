<div class="row-fluid">
    <div class="span9">
		<?php echo $this->BootstrapForm->create('Album', array('class' => 'form-horizontal')); ?>
        <fieldset>
            <legend><?php echo $album['Album']['title']; ?></legend>
			<?php
			echo $this->BootstrapForm->input('user_id', array(
				'type' => 'hidden',
				'value' => AuthComponent::user('id'),
				'required' => 'required',
				'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
			);
			echo $this->BootstrapForm->input('title', array(
				'required' => 'required',
				'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
			);
			echo $this->BootstrapForm->hidden('id');
			?>
			<?php echo $this->BootstrapForm->submit(__('Save')); ?>
        </fieldset>
		<?php echo $this->BootstrapForm->end(); ?>
    </div>
</div>

<div class="row-fluid">
	<form class="span9" id="fileupload" data-album-id="<?php echo $album['Album']['id']; ?>" action="/albums/upload" method="POST" enctype="multipart/form-data">
		<?php echo $this->Form->hidden('Album.id'); ?>
		<div class="fileupload-buttonbar">
			<blockquote>
				<p>Click "Add files" to upload or drag&amp;drop files here</p>
			</blockquote>
			<div class="span2">
				<!-- The fileinput-button span is used to style the file input field as button -->
				<span class="btn btn-success fileinput-button">
					<i class="glyphicon glyphicon-plus"></i>
					<span>Add files...</span>
					<input type="file" name="files[]" multiple directory  mozdirectory>
				</span>
				<button type="reset" class="btn btn-small cancel hidden">
					<i class="glyphicon glyphicon-ban-circle"></i>
					<span>Cancel upload</span>
				</button>
			</div>
			<div class="span9 pull-right">
				<!-- The global file processing state -->
				<span class="fileupload-process"></span>
				<!-- The global progress state -->
				<div class="span6 fileupload-progress fade">
					<!-- The global progress bar -->
					<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
						<div class="progress-bar progress-bar-success" style="width:0%;"></div>
					</div>
					<!-- The extended global progress state -->
					<div class="progress-extended">&nbsp;</div>
				</div>
			</div>
		</div>
		<!-- The table listing the files available for upload/download -->
		<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
	</form>
</div>

<div class="row-fluid">
	<div class="span9" id="upload_list">
	<?php echo $this->element('files'); ?>
	</div>
</div>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
