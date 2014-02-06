    <div class="span12">
        <h1>Welcome</h1>
        <?php
        echo $this->Form->create('User', array('url' => '/users/login',
        ));
        echo $this->Form->input('email', array('label' => 'Email'));
        echo $this->Form->input('password', array('label' => 'Password'));
        $options = array(
            'label' => 'Login',
            'class' => 'btn btn-primary'
        );
        echo $this->Form->end($options);
        ?>
    </div>

