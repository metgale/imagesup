<?php

if (!AuthComponent::user('userType')) {
    echo $this->Element('basicuser');
}else{
    echo $this->Element('adminuser');
}
?>
