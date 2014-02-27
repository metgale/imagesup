<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>

<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            Healthy Share
        </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css(array(
            'bootstrap.min',
            'bootstrap-responsive.min',
            'jquery.fileupload',
            'jquery-ui-1.10.4.custom.min',
            'custom',
        ));
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>
    </head>
    <body>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <!-- Be sure to leave the brand out there if you want it shown -->
                    <a class="brand" href="/albums/index">Image uploader</a>
                    <!-- Everything you want hidden at 940px or less, place within here -->
                    <div class="nav-collapse collapse">
                        <!-- .nav, .navbar-search, .navbar-form, etc -->
                        <ul class="nav">
                            <li ><a href="/albums/index">Home</a></li>
                            <li><a href="/pages/aboutus">About Us</a></li>
                            <li><a href="/pages/howitworks">How it works</a></li>
                        </ul>
                        <?php if (!AuthComponent::user()): ?>
                            <ul class="nav pull-right">
                                <li><a href="/users/login">Login</a></li>
                                <li><a href="/users/add">Register</a></li>
                            </ul>
                        <?php else: ?>
                            <ul class="nav pull-right">
                                <li><a href='/albums/index'>Hello <?php echo AuthComponent::user('firstname') ?></a></li>
                                <li><a href="/users/logout">Logout</a></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $this->Session->flash(); ?>
        <div id="container">
            <?php echo $this->fetch('content'); ?>
        </div>

        <script src="/js/jquery.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="/js/scripts.js"></script>
        <script type="text/javascript" src="/js/jquery.collapse.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <script src="/js/jquery.imageLens.js"></script>
        <!-- uploader -->
        <script src="/js/jquery.iframe-transport.js"></script>
        <script src="/js/jquery.fileupload.js"></script>
        <script src="/js/jquery.fileupload-process.js"></script>
        <script src="/js/jquery.fileupload-validate.js"></script>
        <script src="/js/main.js"></script>
        <?php         echo $this->element('sql_dump');

        if (!$this instanceof DebugView) {
            echo $this->element('sql_dump');
        }
        ?>
    </body>
</html>
