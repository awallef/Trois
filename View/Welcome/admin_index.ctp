<?php

		$links = Configure::read('Trois.backendMenu');
		
		$html = '<h2>Dashboard</h2>';
		
		$html .= '<div class="welcome-text" >Welcome on your admin dashborad. Here are all the section you can reach. Use links below, menu items or actions in the selectbox to performe any duty you like... Enjoy our new tool ! 0_o</div>';
		
		$html = $this->Html->tag('div', $html , array( 'class' => 'welcome' ) );
		
		echo $html;
		
		
		$html = '';
		if( $links )
		{
			foreach( $links as $linkName => $link )
			{
				$html .= $this->Html->tag('div', $this->Html->link( $linkName, $link ), array('class'=>'welcome-item') );
			}
		}
		
		$html = $this->Html->tag('div', $html , array( 'class' => 'welcome-container' ) );
		
		echo $html;

?>