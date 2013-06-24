<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title><?php echo Configure::read('Trois.applicationName'); ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="apple-touch-icon" href="<?php echo $this->Html->url(Configure::read('Trois.applicationIconSrc')); ?>"/>
        <link rel="apple-touch-startup-image" href="<?php echo $this->Html->url(Configure::read('Trois.applicationSplachIphoneSrc')); ?>" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />

        <meta name="description" content="">
        <meta name="author" content="3xw GmbH Switzerland">

        <!-- Styles -->
        <?php
        // css
        echo $this->Html->css('/trois/css/3xw.screen');
        
        // js	
        echo $this->Html->script('/trois/js/jquery-1.8.2.min');
        echo $this->Html->script('/trois/js/bootstrap.min');
        
        echo $this->Html->script('/trois/js/trois');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>


        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->



    </head>

    <body>

        <!-- Header -->
        <?php echo $this->element('header', array(), array('plugin' => 'Trois')); ?>

        <div class="container content">

            <?php echo $this->Session->flash(); ?>

            <?php echo $this->fetch('content'); ?>
        </div>
        <?php echo $this->element('sql_dump'); ?>
        <?php echo $this->Js->writeBuffer(); ?>
    </body>
</html>
