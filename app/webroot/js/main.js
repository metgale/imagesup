$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
		autoUpload: true,
        url: '/albums/upload/',
		maxFileSize: 50000000, //50MB
		previewMaxWidth: 70,
        previewMaxHeight: 70,
        previewCrop: true,
		disableImageResize: false,
		sequentialUploads: true,
		limitConcurrentUploads: 1,
		maxChunkSize: 0,
		acceptFileTypes: /(\.|\/)(gif|jpe?g|png|zip)$/i
    });

	if ($('files').length) {
		$('button.cancel').show();
	}
});
