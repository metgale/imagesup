<div class="span12">
    <h1>Login</h1>
    <p>New users - <a href="/users/add">register here</a></p>
    <hr>
    <?php
    echo $this->Form->create('User', array('class' => 'form-horizontal'));
    echo $this->Form->input('email', array(
        'required' => 'required'
    ));
    echo $this->Form->input('password', array(
        'required' => 'required'
    ));
    echo $this->Form->submit(__('Login'), array('class' => 'btn btn-primary'));
    echo $this->Form->end();
    ?>
</div>
