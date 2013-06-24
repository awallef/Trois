<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	
	<?php /* ================ MOBILE =================== */ ?>
	<script type="text/javascript">
        (function(document,navigator,standalone) {
            // prevents links from apps from oppening in mobile safari
            // this javascript must be the first script in your <head>
            if ((standalone in navigator) && navigator[standalone]) {
                var curnode, location=document.location, stop=/^(a|html)$/i;
                document.addEventListener('click', function(e) {
                    curnode=e.target;
                    while (!(stop).test(curnode.nodeName)) {
                        curnode=curnode.parentNode;
                    }
                    // Condidions to do this only on links to your own app
                    // if you want all links, use if('href' in curnode) instead.
                    if('href' in curnode && ( curnode.href.indexOf('http') || ~curnode.href.indexOf(location.host) ) ) {
                        e.preventDefault();
                        location.href = curnode.href;
                    }
                },false);
            }
        })(document,window.navigator,'standalone');
    </script>
	
	<meta name="viewport" content = "width = device-width, initial-scale = 1, minimum-scale = 1, user-scalable = no" /> 
	<link rel="apple-touch-icon" href="<?php echo $this->Html->url( Configure::read('Trois.applicationIconSrc') ); ?>"/>
	<link rel="apple-touch-startup-image" href="<?php echo $this->Html->url( Configure::read('Trois.applicationSplachIphoneSrc') ); ?>" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	
	<title><?php echo Configure::read('Trois.applicationName'); ?></title>
	<?php
		
		$nocache = mktime(date('H'), 0,0, date('d'),date('m'), date('y'));
		
		echo $this->Html->meta('icon');
		
		// css
		echo $this->Html->css('/trois/css/3xw.reset');
		
		echo $this->Html->tag('link','',array(
			'rel'=>'stylesheet',
			'type'=>'text/css',
			'href'=>$this->Html->url('/trois/css/3xw.utils'.'.css?nocache='.$nocache)
		));
		
		echo $this->Html->tag('link','',array(
			'rel'=>'stylesheet',
			'type'=>'text/css',
			'href'=>$this->Html->url('/trois/css/3xw.transitions'.'.css?nocache='.$nocache)
		));
		
		echo $this->Html->tag('link','',array(
			'rel'=>'stylesheet',
			'type'=>'text/css',
			'href'=>$this->Html->url('/trois/css/3xw.generic'.'.css?nocache='.$nocache)
		));
		echo $this->Html->tag('link','',array(
			'rel'=>'stylesheet',
			'type'=>'text/css',
			'href'=>$this->Html->url('/trois/css/3xw.specials'.'.css?nocache='.$nocache)
		));
		echo $this->Html->tag('link','',array(
			'rel'=>'stylesheet',
			'type'=>'text/css',
			'href'=>$this->Html->url('/trois/css/3xw.overlayer'.'.css?nocache='.$nocache)
		));
		
		echo $this->Html->tag('link','',array(
			'rel'=>'stylesheet',
			'type'=>'text/css',
			'href'=>$this->Html->url('/trois/css/3xw.mobile'.'.css?nocache='.$nocache)
		));
		
		echo $this->Html->tag('link','',array(
			'rel'=>'stylesheet',
			'type'=>'text/css',
			'href'=>$this->Html->url('/trois/css/3xw.responsive'.'.css?nocache='.$nocache)
		));
		

		
		// js
		echo $this->Html->tag('script',' ',array('src'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'));
		
		echo $this->Html->tag('script',' ',array(
			'type'=>'text/javascript',
			'src'=>$this->Html->url('/trois/js/3xw.utils'.'.js?nocache='.$nocache)
		));
		echo $this->Html->tag('script',' ',array(
			'type'=>'text/javascript',
			'src'=>$this->Html->url('/trois/js/3xw.responsive'.'.js?nocache='.$nocache)
		));
		
	
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	
</head>
<body>
	<div id="container">
		<div id="header">
			<?php
				if( $loggedIn ) {
					echo $this->Actions->create();
					echo $this->Backend->menu();
				}
			?>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
	<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>