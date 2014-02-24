<div class="row-fluid">
    <ul class=breadcrumb pull-left">
		<li><a href="/albums/index">All albums</a> /</li>
        <li><a href="/albums/view/<?php echo $album['Album']['id']; ?>"><strong><?php echo h($album['Album']['title']); ?></strong></a></li>
    </ul>

    <h2 class="page-header">Upload files to "<?php echo $album['Album']['title']; ?>"</h2>

	<div class="span6">
		<blockquote>
			<p>You can also drag&amp;drop files here</p>
		</blockquote>

		<!-- The fileinput-button span is used to style the file input field as button -->
		<span class="btn btn-success btn-large fileinput-button">
			<i class="glyphicon glyphicon-plus"></i>
			<span>Add files...</span>
			<input id="fileupload" data-album-id="<?php echo $album['Album']['id']; ?>" type="file" name="files[]" multiple>
		</span>
		<a href="#" class="cancel hide">
			<i class="glyphicon glyphicon-ban-circle"></i>
			<span>Cancel upload</span>
		</a>

		<br><br>
		<div class="wait-message hide">
			<h3>Please wait for upload to complete, you will be redirected</h3>
		</div>

		<div id="progress" class="progress">
			<div class="bar bar-success"></div>
		</div>

		<div id="files">
			<!--  listing the files added for upload -->
		</div>
	</div>
</div>
