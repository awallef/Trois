/***
 *    .____                     .___.__                
 *    |    |    _________     __| _/|__| ____    ____  
 *    |    |   /  _ \__  \   / __ | |  |/    \  / ___\ 
 *    |    |__(  <_> ) __ \_/ /_/ | |  |   |  \/ /_/  >
 *    |_______ \____(____  /\____ | |__|___|  /\___  / 
 *            \/         \/      \/         \//_____/  
 */

var lastBrowsedUrl = '';
var sortMode = false;
var init = true;
var currentData = false;

function MediaBrowseQuery( url )
{
    MediaBrowseQueryProgress();
    
    lastBrowsedUrl = url;
    
    $.ajax({
        url:url,
        async:true,
        dataType:"html",
        evalScripts:true,
        success:MediaBrowseUpdateBrowsePannel
    });
}

function MediaCRUDQuery( url, data, successFCT )
{
   
   
    var xhr = new XMLHttpRequest(),
       upload = xhr.upload,
       multipart ="";
        
    
    xhr.onreadystatechange = function(e) {
	  if (this.readyState == 4 && this.status == 200) {
	    
	    var response = eval("("+xhr.responseText+")");
	    if( typeof response.status !== "undefined" )
	    {
		    if( response.status == 1 )
		    {
			    successFCT( response );
			     
		    }else{
			    alert('An error occured');
			    console.log(response);
		    }
	    }else{
		    alert('An error occured');
		    console.log(xhr.responseText);
	    }
	  }
	};
    
    upload.addEventListener("error", function (ev) {alert('An error occured'); console.log(ev);}, false);
    
    xhr.open( "POST", url  , true );
    
    var formData = new FormData();
    for( var i in data )
    {
	   for( var itm in data[i] )
	   {
		   for( var property in data[i][itm] )
		   {
		   		console.log('data['+i+']'+property +' => '+ data[i][itm][property] );
		   		formData.append( 'data['+i+']'+property, data[i][itm][property] );
		   } 
	   }
    }
	
	xhr.send(formData);
}

function MediaBrowseQueryProgress( )
{
    var baseUrl = $('#media-search-base-url').val();
    var w = $('#media-browse-pannel').width();
    var h = Math.max( $('#media-browse-pannel').height() , 300 );
    var posx = ( w - 50 ) / 2;
    var posy= ( h - 50 ) / 2;
    
    var html = '<div class="" style="width:'+w+'px;height:'+h+'px;position:relative;" >';
    html += '<img style="position:absolute;left:'+posx+'px;top:'+posy+'px;" src="'+baseUrl+'trois/assets/icons/loading.gif" />';
    html += '</div>';
    $('#media-browse-pannel').html(html);
}

function MediaBrowseUpdateBrowsePannel( data, textStatus )
{
    $('#media-browse-pannel').html(data);
    $('#media-edit-pannel').html('nothing to edit...');
    if( sortMode && init )
    {
    	init = false;
    	$('#media-tab-sort').tab('show');	
    }else{
	    $('#media-tab-browse').tab('show');
    }
    
    
    
    MediaBrowseUpdateBrowsePagination();
    MediaBrowseUpdateThumbsEvents();
}

function MediaEditUpdatePannel( data, textStatus )
{
    $('#media-edit-pannel').html(data);
    $('#media-tab-edit').tab('show');
    
    $('#media-edit-pannel .submit > input').click( MediaEditProcess );
    
    MediaEditUpdateForm();
}

function MediaEditUpdateForm()
{
	// Inputs
	$('#media-edit-pannel input').each(function(){
		
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
	$('#media-edit-pannel textarea').each(function(){
		
		$(this).addClass('input-block-level').attr({
			placeholder: $(this).parent().find('label').css({display:'none'}).html()
		}); 
				
		
	});
	
	// Select
	$('#media-edit-pannel select').each(function(){
		
		$(this).addClass('input-block-level').attr({
			placeholder: $(this).parent().find('label').html()
		}); 
				
		
	});
}

function MediaBrowseUpdateBrowsePagination()
{
    $('#media-browse-pannel .current').html('<a>'+$('#media-browse-pannel .current').html()+'</a>');
    $('#media-browse-pannel .current').addClass('active');
}

function MediaBrowseUpdateThumbsEvents()
{
	$("#media-browse-pannel .thumb-edit").each(function(){
	    $(this).click( MediaEditShow );
    });
    
    $("#media-browse-pannel .thumb-delete").each(function(){
	    $(this).click( MediaDeleteSingle );
    });
    
    $('#MediaActionCheckAll').each(function(){
	    $(this).click(MediaActionCheckAll);
    });
    
    $('#MediaActionUncheckAll').each(function(){
	    $(this).click(MediaActionUncheckAll);
    });
    
    $("#media-action-btn").each(function(){
    	$(this).click( MediaActionProcess );
    });
}

/***
 *    ___________________ ____ ___________   
 *    \_   ___ \______   \    |   \______ \  
 *    /    \  \/|       _/    |   /|    |  \ 
 *    \     \___|    |   \    |  / |    `   \
 *     \______  /____|_  /______/ /_______  /
 *            \/       \/                 \/ 
 */
 
function MediaDeleteProcess(data)
{
	if(confirm('Are you sure ?'))
	{
		url = $('#media-delete-many-query').val();
		MediaCRUDQuery(url, data, MediaClassicComplete );	
	}
}

function MediaRemoveFromSelectionProcess( data )
{
	if(confirm('Are you sure ?'))
	{
		url = $('#media-remove-many-query').val();
		MediaCRUDQuery(url, data, MediaRemoveComplete );	
	}
}

function MediaRemoveComplete( data )
{
	for( var i in currentData )
	{
		for( var j in currentData[i] ) for( var porperty in currentData[i][j] ) if( porperty == '[Mediafile][id]' ) $('#media-sort-pannel  #'+ currentData[i][j][porperty] ).remove();
	}
}

function MediaAddToSelectionProcess( data )
{
		
	var newData = [];
	for( var i in data )
	{
		var metas = data[i];
		
		var foreign_model = {};
		foreign_model['[MediaLink][foreign_model]'] = $('#media-foreign_model').val();
		metas.push(foreign_model);
		
		var foreign_field = {};
		foreign_field['[MediaLink][foreign_field]'] = $('#media-foreign_field').val();
		metas.push(foreign_field);
		
		var foreign_key = {};
		foreign_key['[MediaLink][foreign_key]'] = $('#media-foreign_key').val();
		metas.push(foreign_key);
		
		newData[i] = metas;
	}
	data = newData;
	
	url = $('#media-add-many-query').val();
	MediaCRUDQuery(url, data, MediaClassicComplete );
	
}

function MediaEditProcess( e )
{   
    e.preventDefault();
    
    var data = [];
    var metas = [];
    $('#MediafileAdminEditForm input').each(function(){
	    
	    if( $(this).attr('type') != 'submit' )
	    {
		    var property = $(this).attr('name');
		    property = property.substr(4);
		    var meta = {};
		    meta[property] = $(this).val();
		    metas.push( meta );
		}
    });
    
    $('#MediafileAdminEditForm textarea').each(function(){
	    
	    var property = $(this).attr('name');
	    property = property.substr(4);
	    var meta = {};
	    meta[property] = $(this).val();
	    metas.push( meta );
    });
    
    data.push( metas );
    
    var url = $('#media-edit-many-query').val();
    MediaCRUDQuery(url, data, MediaClassicComplete );
}

function MediaClassicComplete( data )
{
	if( !sortMode ){
		MediaBrowseQuery( lastBrowsedUrl );
	}else{
		window.location = $('#media-request-here').val();
	}
}

/***
 *      ________                               _____          __  .__                      
 *     /  _____/______  ____  __ ________     /  _  \   _____/  |_|__| ____   ____   ______
 *    /   \  __\_  __ \/  _ \|  |  \____ \   /  /_\  \_/ ___\   __\  |/  _ \ /    \ /  ___/
 *    \    \_\  \  | \(  <_> )  |  /  |_> > /    |    \  \___|  | |  (  <_> )   |  \\___ \ 
 *     \______  /__|   \____/|____/|   __/  \____|__  /\___  >__| |__|\____/|___|  /____  >
 *            \/                   |__|             \/     \/                    \/     \/ 
 */
function MediaActionCheckAll( e )
{
   
    var pannelId = getEventPannelId(e);

    if( $('#'+pannelId+' .media-thumb').length > 0 )
    {
        $('#'+pannelId+' .thumb-select').each(function(){
            $(this).prop('checked', true);
        });
    }
}

function MediaActionUncheckAll( e )
{
    var pannelId = getEventPannelId(e);
    
    if( $('#'+pannelId+' .media-thumb').length > 0 )
    {
        $('#'+pannelId+' .thumb-select').each(function(){
            $(this).prop('checked', false);
        });
    }
}

function MediaActionProcess( e )
{
    var pannelId = getEventPannelId(e);
    
    var data = [];
    if( $('#'+pannelId+' .media-thumb').length > 0 )
    {
        var i = 0;
        
        $('#'+pannelId+' .media-thumb').each(function(){
	        
                var metas = [];
	        
	        if( $(this).find('.thumb-select').attr( 'checked' ) == 'checked' )
	        {
		       $(this).find('.media-data').find('input').each(function(){
			       var meta = {};
			       meta[$(this).attr('name')] = $(this).val();
			       metas.push( meta );
		       });
		       
		       data.push( metas );
	        }
	        
	        
        });
    }
    
    currentData = data;
    
    
    
    var action = pannelId +' ' + $('#'+ pannelId +' #media-action').val();
        
    if( data.length > 0 ) MediaActionExec( action, data );
    else alert('Please check some items to preform selected action');
}

function MediaActionExec( action, data )
{
	switch( action )
	{
		case 'media-sort-pannel no action':
		case 'media-browse-pannel no action':
			alert( 'please select an action to perform' );
			break;
			
		case 'media-browse-pannel delete':
			MediaDeleteProcess(data);
			break;
			
		case 'media-sort-pannel delete':
			MediaRemoveFromSelectionProcess(data);
			break;
			
		case 'media-browse-pannel add':
			MediaAddToSelectionProcess( data );
			break;
	}
}

/***
 *     ____ ___   __  .__.__          
 *    |    |   \_/  |_|__|  |   ______
 *    |    |   /\   __\  |  |  /  ___/
 *    |    |  /  |  | |  |  |__\___ \ 
 *    |______/   |__| |__|____/____  >
 *                                 \/ 
 */
function MediaCollectThumbData(e)
{
	var thumb = $(e.target).parent().parent();
	var data = [];
	var metas = [];
    $(thumb).find('.media-data').find('input').each(function(){
		var meta = {};
		meta[$(this).attr('name')] = $(this).val();
		metas.push( meta );
    });
    data.push(metas);
    currentData = data;
    return data;	 
}

function getEventPannelId(e)
{
	return $(e.target).parent().parent().parent().parent().attr('id');	 
}
 
/***
 *    ___________                    __      ___ ___                    .___.__                       
 *    \_   _____/__  __ ____   _____/  |_   /   |   \_____    ____    __| _/|  |   ___________  ______
 *     |    __)_\  \/ // __ \ /    \   __\ /    ~    \__  \  /    \  / __ | |  | _/ __ \_  __ \/  ___/
 *     |        \\   /\  ___/|   |  \  |   \    Y    // __ \|   |  \/ /_/ | |  |_\  ___/|  | \/\___ \ 
 *    /_______  / \_/  \___  >___|  /__|    \___|_  /(____  /___|  /\____ | |____/\___  >__|  /____  >
 *            \/           \/     \/              \/      \/     \/      \/           \/           \/ 
 */
function MediaDeleteSingle(e)
{
	MediaDeleteProcess( MediaCollectThumbData(e) );
}

function MediaEditShow(e)
{
	$.ajax({
        url:$('#media-edit-query').val() +'/'+ $(e.target).parent().parent().attr('id'),
        async:true,
        dataType:"html",
        evalScripts:true,
        success:MediaEditUpdatePannel
    });
}

function MediaRemoveSingleFromSelection( e )
{
    MediaRemoveFromSelectionProcess( MediaCollectThumbData(e) );
}

function MediaBrowseTagChangeEventHandler( e )
{
    MediaBrowseQuery( $(e.currentTarget).val() );
}

function MediaBrowseLimitChangeEventHandler( e )
{
	var newUrl = '';
	var lastIndex =  lastBrowsedUrl.lastIndexOf('limit:');
	if( lastIndex != -1 )
	{
		subUrl = lastBrowsedUrl.substr( lastIndex );
		lastIndex2 = subUrl.indexOf('/');
		if( lastIndex2 != -1 )
		{
			newUrl = lastBrowsedUrl.substr(0, lastIndex -1) + '/limit:' + $(e.currentTarget).val() + subUrl.substr( lastIndex2 );
		}else{
			newUrl = lastBrowsedUrl.substr(0, lastIndex -1) + '/limit:' + $(e.currentTarget).val();
		}
		
	}else{
		newUrl = lastBrowsedUrl + '/limit:' + $(e.currentTarget).val();
	}
	
	MediaBrowseQuery( newUrl  );
}

function MediaBrowseClickEventHandler( e )
{
    var url = $('#media-search-by-name-form').attr('action') + '/param:';
    MediaBrowseQuery( url + $('#media-search-by-name-form-param').val() );
}

/***
 *    __________                   .___      
 *    \______   \ ____ _____     __| _/__.__.
 *     |       _// __ \\__  \   / __ <   |  |
 *     |    |   \  ___/ / __ \_/ /_/ |\___  |
 *     |____|_  /\___  >____  /\____ |/ ____|
 *            \/     \/     \/      \/\/     
 */

$(document).ready(function()
{
    
    // define sortMode
    sortMode = $('#media-sort-mode').val();
    
    // catch all ajaxa success!!! + mother fucking cake browse requests!
    $(document).ajaxSuccess(function(){
       if( sortMode )
        {
                var pannelId = 'media-browse-pannel';
                $('#'+ pannelId +' #media-action').append('<option value="add">Add to Selection</option>');
        }
    });
    
    $(function() {
        $.ajaxSetup({
            complete: function(xhr, textStatus) {
                MediaBrowseUpdateBrowsePagination();
                MediaBrowseUpdateThumbsEvents();
            }
        });
    });
    
    $('#media-search-by-tag-select-box').change(MediaBrowseTagChangeEventHandler);
    
    $('#media-search-limit-select-box').change(MediaBrowseLimitChangeEventHandler);
    
    $('#media-search-by-name-form-btn').click(MediaBrowseClickEventHandler);
    
    if( sortMode )
    {
    	$('#media-tab-sort').tab('show');	
    	
    	$("#media-sort-pannel .thumb-edit").each(function(){
		    $(this).click( MediaEditShow );
	    });
	    
	    $("#media-sort-pannel .thumb-delete").each(function(){
		    $(this).click( MediaRemoveSingleFromSelection );
	    });
	    
	    $('#media-sort-pannel #MediaActionCheckAll').each(function(){
		    $(this).click(MediaActionCheckAll);
	    });
	    
	    $('#media-sort-pannel #MediaActionUncheckAll').each(function(){
		    $(this).click(MediaActionUncheckAll);
	    });
	    
	    $("#media-sort-pannel #media-action-btn").each(function(){
	    	$(this).click( MediaActionProcess );
	    });
	    
	    $( "#media-sort-pannel #sortable" ).sortable();
	    $( "#media-sort-pannel #sortable" ).disableSelection();
	    
	    $('#MediaSortForm').submit(function() {
	 	
		 	var input = $("<input>").attr("type", "hidden").attr("name", "data[MediaLink][foreign_model]").val( $('#media-foreign_model').val() );
		 	$('#MediaSortForm').append($(input));
		 	
		 	var input = $("<input>").attr("type", "hidden").attr("name", "data[MediaLink][foreign_field]").val( $('#media-foreign_field').val() );
		 	$('#MediaSortForm').append($(input));
		 	
		 	var input = $("<input>").attr("type", "hidden").attr("name", "data[MediaLink][foreign_key]").val( $('#media-foreign_key').val() );
		 	$('#MediaSortForm').append($(input));
		 	
			$.each( $('#media-sort-pannel #sortable .media-thumb'), function(i,elem) {
			
				var input = $("<input>").attr("type", "hidden").attr("name", "data[Mediafile]["+$(elem).find('.media-data').find('.data-MediaLink-id').val()+"]").val( ( $('#media-sort-pannel #sortable .media-thumb').length - 1 ) - i );
				$('#MediaSortForm').append($(input));
				i++;
			});
		  	return true;
		});
    }
    
    MediaBrowseQuery( $('#media-search-first-query').val() );
    
});