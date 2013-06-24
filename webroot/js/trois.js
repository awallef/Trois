/*! 
 * @preserve
 *    ________ ____  _____      __ 
 *    \_____  \\   \/  /  \    /  \
 *      _(__  < \     /\   \/\/   /
 *     /       \/     \ \        / 
 *    /______  /___/\  \ \__/\  /  
 *           \/      \_/      \/   
 * 
 *      Trois admin v 1.0.1
 * 
 *      Copyright 2012 3xw, GmbH
 *      Belmont - Switzerland
 *
 *
 */
 
 
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


/***
 *    ___________                           
 *    \_   _____/__________  _____   ______ 
 *     |    __)/  _ \_  __ \/     \ /  ___/ 
 *     |     \(  <_> )  | \/  Y Y  \\___ \  
 *     \___  / \____/|__|  |__|_|  /____  > 
 *         \/                    \/     \/  
 */
 
function makeForms()
{
	
	// Headers
	$('fieldset legend').each(function(){
		$(this).parent().prepend('<h2>'+$(this).css({display:'none'}).html()+'</h2>');
		
	});
	
	
	// Inputs
	$('.form input').each(function(){
		
		switch( $(this).attr('type') )
		{
			case 'submit':
				$(this).addClass('btn btn-large btn-primary');
				break;
				
			case 'number':
			case 'text':
			case 'password':
				$(this).addClass('input-block-level').attr({
					placeholder: $(this).parent().find('label').css({display:'none'}).html()
				}); 
				break;
		}
		
	});
	
	// textArea
	$('.form textarea').each(function(){
		
		$(this).addClass('input-block-level').attr({
			placeholder: $(this).parent().find('label').css({display:'none'}).html()
		}); 
				
		
	});
	
	// Select
	$('.form select').each(function(){
		
		$(this).addClass('input-block-level').attr({
			placeholder: $(this).parent().find('label').html()
		}); 
				
		
	});
}

/***
 *    ___________.__                .__     
 *    \_   _____/|  | _____    _____|  |__  
 *     |    __)  |  | \__  \  /  ___/  |  \ 
 *     |     \   |  |__/ __ \_\___ \|   Y  \
 *     \___  /   |____(____  /____  >___|  /
 *         \/              \/     \/     \/ 
 */

function makeFlash()
{
	$('#flashMessage').each(function(){
		$(this).html( '<div class="alert"><button type="button" class="close" data-dismiss="alert">×</button>' + $(this).html() + '</div>' )
	});
}

/***
 *    .___            .___                           
 *    |   | ____    __| _/____ ___  ___ ____   ______
 *    |   |/    \  / __ |/ __ \\  \/  // __ \ /  ___/
 *    |   |   |  \/ /_/ \  ___/ >    <\  ___/ \___ \ 
 *    |___|___|  /\____ |\___  >__/\_ \\___  >____  >
 *             \/      \/    \/      \/    \/     \/ 
 */

function makeIndex()
{
	$('.index table').each(function(){
		
		$(this).addClass('table table-striped table-bordered table-hover'); 
				
		
	});
	
	$('.index .paging').each(function(){
		
		if( !$(this).hasClass('pagination'))
		{
			$(this).addClass('pagination');
			$(this).find('span').each(function(){
				
				if( $(this).html().lastIndexOf('&lt; previous') != -1 )
				{
					$(this).html( $(this).html().replace('&lt; previous','«') );
				}
				if( $(this).html().lastIndexOf('next &gt;') != -1 ) $(this).html( $(this).html().replace('next &gt;','»') );
				
				if( $( $(this).html() ).find('a').length > 0 )
					$(this).replaceWith('<li class="'+$(this).attr('class')+'" ><span>'+$(this).html()+'</span></li>');
				else
					$(this).replaceWith('<li class="'+$(this).attr('class')+'" ><span><a href="#" >'+$(this).html()+'</a></span></li>');
				
			});
		}
	});
	
	if( $('.index .paging ul').length == 0 )
		$('.index .paging li').wrapAll('<ul />');
	
	createNiceIndex();
}

function createNiceIndex()
{
	var paging = $('.pagination').clone();
	
	var tr = 0;
	var td = 0;
	
	var titles = [];
	var data = [];
	var row = [];
	var actions = [];
	
	var isAction = false;
	
	$('.index table tr').each(function(){
		
		if( tr == 0 )
		{
			$(this).find('th').each(function(){
				if( $(this).find('a').length > 0 ) titles.push( $(this).find('a').html() );
				else titles.push( $(this).html() );
			});
			
		}else{
		
			td = 0;
			row = [];
			$(this).find('td').each(function(){
				isAction = ( $(this).attr('class') == 'actions' )? true : false;
				if( !isAction )
				{
					row.push($(this).html());
				}else{
					taction = ' ';
					$(this).find('a').each(function(){
						onc = ( $(this).attr('onclick') )? 'onclick="'+$(this).attr('onclick')+'"' : '';
						taction += '<a href="'+$(this).attr('href')+'"  '+onc+'>'+$(this).html()+'</a> ';
					});
					actions.push(taction);
				}
				td++;
			});
			data.push( row );
		}
		tr++;
	});
	
	$('<div class="accordion" id="mobile-accordion" style="display:none;"></div>').insertAfter('.index table');
	
	
	for( i in data )
	{
		var str = data[i][1];
		if( str ) if(  str.length > 39 ) str = str.substr(0,37) + '...';
		
		var sumup = $('<div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-'+i+'">'+str+'</a></div>');
		var item = $('<div class="accordion-group"></div>');
		$(item).append(sumup);
		
		details = $('<div id="collapse-'+i+'" class="accordion-body collapse">');
		
		$(details).append(actions[i]);
		
		for( j = 0; j < data[i].length; j++ )
		{
			$(details).append('<div >'+titles[j]+':</div>');
			$(details).append('<div >'+data[i][j]+'</div>');	
			
		}
		
		$(item).append(details);
		
		$('#mobile-accordion').append(item);
	}
}

function indexResize()
{
	$('.index').each(function(){
		var innerWidth = $(this).innerWidth(); 
		$(this).find('table').css({ display: 'table' });
		var tableWidth = $(this).find('table').width() + 20;
		if( innerWidth < tableWidth )
		{
			$(this).find('table').css({ display: 'none' });
			$('#mobile-accordion').css({ display: 'block' });
		}else{
			$(this).find('table').css({ display: 'table' });
			$('#mobile-accordion').css({ display: 'none' });
		}
		
	});
}

/***
 *    ____   ____.__                     
 *    \   \ /   /|__| ______  _  ________
 *     \   Y   / |  |/ __ \ \/ \/ /  ___/
 *      \     /  |  \  ___/\     /\___ \ 
 *       \___/   |__|\___  >\/\_//____  >
 *                       \/           \/ 
 */

function makeViews()
{
   $('<div class="clear"></div>').insertAfter('.view dl');
}

/***
 *       _____          __  .__                      
 *      /  _  \   _____/  |_|__| ____   ____   ______
 *     /  /_\  \_/ ___\   __\  |/  _ \ /    \ /  ___/
 *    /    |    \  \___|  | |  (  <_> )   |  \\___ \ 
 *    \____|__  /\___  >__| |__|\____/|___|  /____  >
 *            \/     \/                    \/     \/ 
 */

function makeActions()
{
   var actions = $('div > .actions').addClass('nav-collapse collapse');
   actions.remove();
   $('.content').prepend($(actions));
   $('div > .actions h3').remove();
   
   $('div > .actions').wrap('<div class="navbar" />');
   $('div > .actions').wrap('<div class="navbar-inner " id="customActionBar"/>');
   
   $('#customActionBar').prepend( $('<a class="btn btn-navbar" data-toggle="collapse" data-target="div > .actions"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a>') );
   
   $('#customActionBar').prepend( $('<div class="brand">Actions</div>') );
   
   $('div > .actions ul').addClass('nav');
   
}

/***
 *    __________                   .___       
 *    \______   \ ____ _____     __| _/__.__. 
 *     |       _// __ \\__  \   / __ <   |  | 
 *     |    |   \  ___/ / __ \_/ /_/ |\___  | 
 *     |____|_  /\___  >____  /\____ |/ ____| 
 *            \/     \/     \/      \/\/      
 */
$(document).ready(function(){
	
	if( $('.form').length > 0 ) makeForms();
	if( $('#flashMessage').length > 0 ) makeFlash();
	if( $('.index table').length > 0 )
	{
		makeIndex();
		indexResize();
		$(window).bind('resize', indexResize );
	}
        
        if( $('.view').length > 0 ) makeViews();
        if( $('div > .actions').length > 0 ) makeActions();
});
