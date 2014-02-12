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
                'type' => 'hidden',
                'required' => 'required',
                'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
            );
            echo $this->BootstrapForm->hidden('id');
            ?>
            <?php echo $this->BootstrapForm->submit(__('Submit')); ?>
        </fieldset>
        <input id="fileupload" type="file" name="files[]" data-url="server/php/" multiple>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="js/vendor/jquery.ui.widget.js"></script>
        <script src="js/jquery.iframe-transport.js"></script>
        <script src="js/jquery.fileupload.js"></script>
        <script>
            $(function() {
                $('#fileupload').fileupload({
                    dataType: 'json',
                    done: function(e, data) {
                        $.each(data.result.files, function(index, file) {
                            $('<p/>').text(file.name).appendTo(document.body);
                        });
                    }
                });
            });
        </script>
        <?php echo $this->BootstrapForm->end(); ?>
    </div>
</div>