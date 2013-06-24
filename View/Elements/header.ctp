<?php if( $loggedIn ){ ?>
	
	<div class="navbar navbar-inverse navbar-fixed-top">
	  <div class="navbar-inner">
	    <div class="container">
	      <a class="btn btn-navbar" data-toggle="collapse" data-target="#headerNavCollapse">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </a>
	      <?php echo $this->Html->link( Configure::read('Trois.applicationName'), '/', array('class' => 'brand') ); ?>
	      <div id="headerNavCollapse" class="nav-collapse collapse">
	        <ul class="nav">
	          <?php
	          
	          	echo $this->Html->tag('li', $this->Html->link( __('Dashboard'), array('controller'=>'Welcome', 'action' => 'index', 'admin' => true, 'plugin' => 'trois' ) ) );
	          	
	          	$links = Configure::read('Trois.backendMenu');
				if( $links )
				{
					foreach( $links as $linkName => $link )
					{
						//echo $this->Html->tag('li', $this->Html->link( $linkName, $link ) );
						if( is_array( $link ) )
						{
							if( array_key_exists('dropdown', $link) )
							{
								$d = '';
								foreach( $link['dropdown'] as $dropName => $dropLink )
								{
									$d .= $this->Html->tag('li', $this->Html->link( $dropName, $dropLink ) );
								}
								$html = '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$linkName.' <b class="caret"></b></a>';
								$html .= $this->Html->tag('ul', $d, array( 'class' => 'dropdown-menu' ));
								echo $this->Html->tag('li', $html, array('class' => 'dropdown' ));
								
							}else{
								echo $this->Html->tag('li', $this->Html->link( $linkName, $link ) );
							}
						}else{
							echo $this->Html->tag('li', $this->Html->link( $linkName, $link ) );	
						}
					}
				}
				
				echo $this->Html->tag('li', $this->Html->link( __('Sign out'), array('controller'=>'Users', 'action' => 'logout', 'admin' => true, 'plugin' => 'trois' ) ) );
				
	          ?>
	        </ul>
	      </div>
	    </div>
	  </div>
	</div>
<?php } ?>