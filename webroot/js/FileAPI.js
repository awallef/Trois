function FileAPI (t, d, f, i, c, u, r, m) {

    var fileList = t,
    fileField = f,
    dropZone = d,
    iconsFolder = i,
    configUrl = c,
    uploadUrl = u,
    redirection = r,
    mediaLink = m,
    fileQueue = new Array(),
    preview = null,
    config = null,
    checkedFiles = Array();


    this.init = function () {
        
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(e) {
            if (this.readyState == 4 && this.status == 200) {
                config = eval("("+xhr.responseText+")");
                addEventListeners();
            }
        };
            
        xhr.open( "GET", configUrl , true );
        xhr.send(); 
        
    }
    
    var addEventListeners = function() {
        
        fileField.onchange = addFiles;
        dropZone.addEventListener("dragenter",  stopProp, false);
        dropZone.addEventListener("dragleave",  dragExit, false);
        dropZone.addEventListener("dragover",  dragOver, false);
        dropZone.addEventListener("drop",  showDroppedFiles, false);
    }

    var addFiles = function () {
        addFileListItems(this.files);
    }

    var showDroppedFiles = function (ev) {
        ev.stopPropagation();
        ev.preventDefault();
        var files = ev.dataTransfer.files;
        addFileListItems(files);
        
        dropZone.style["backgroundColor"] = "#FEFEFE";
        dropZone.style["borderColor"] = "#CCC";
        dropZone.style["color"] = "#CCC"
    }

    this.clearList = function (ev) {
        ev.preventDefault();
        while (fileList.childNodes.length > 0) {
            fileList.removeChild(
                fileList.childNodes[fileList.childNodes.length - 1]
                );
        }
    }

    var dragOver = function (ev) {
        ev.stopPropagation();
        ev.preventDefault();
        this.style["backgroundColor"] = "#F0FCF0";
        this.style["borderColor"] = "#3DD13F";
        this.style["color"] = "#3DD13F"
    }

    var dragExit = function (ev) {
        ev.stopPropagation();
        ev.preventDefault();
        dropZone.style["backgroundColor"] = "#FEFEFE";
        dropZone.style["borderColor"] = "#CCC";
        dropZone.style["color"] = "#CCC"
    }

    var stopProp = function (ev) {
        ev.stopPropagation();
        ev.preventDefault();
    }
	
	
    this.startUpload = function ( ev ) {
        ev.preventDefault();
        if( fileQueue.length > 0 ) loopQueue();
        else alert('There is no file to upload, please select some...');
    }
	
    var loopQueue = function () {
		
        if( fileQueue.length == 0 ){
           window.location = redirection;
           //alert('done');
        }else{
            //console.log('fileQueue.length' + fileQueue.length);
            uploadQueue( );
        }
    }
	
    var uploadQueue = function () {
        
        var item = fileQueue.shift();
        var elem = item.item;
        $(elem).find('.progress').addClass('active');
        uploadFile(item.file, item.item);
    }

    var addFileListItems = function (files) {
        for (var i = ( files.length - 1 ); i >= 0; i--) {
            displayFile( files[i], i );
        }
        notifyUser();
    }
    
    var notifyUser = function () {
        if(checkedFiles.length < files.length){
            alert( 'The file(s) in red won\'t be uploaded due to transgretions, details on items' );
            files = checkedFiles;
        }
    }
    
    var testFile = function ( file, i ) {
        
        var result = ( in_array( file.type, config.types ) && file.size < config.maxsize );
        var message = 'OK';
        if(!result)
        {
            message = (!in_array( file.type, config.types ))? '- This type is forbbiden -': '';
            message += (!file.size < config.maxsize)? 'The file is too large -': '';
            //badFiles.push(i);
        }else{
            checkedFiles.push(file);
        }
        return [result, message ];
    }
    
    var in_array = function  (needle, haystack, argStrict) {
        var key = '',
        strict = !! argStrict;

        if (strict) {
            for (key in haystack) {
                if (haystack[key] === needle) {
                    return true;
                }
            }
        } else {
            for (key in haystack) {
                if (haystack[key] == needle) {
                    return true;
                }
            }
        }

        return false;
    }    

    
    var displayFile = function ( file, i ) {
    	
        if (file) {
            var test = testFile(file, i);
            var itemStyle = ( test[0] === true )? 'upload-item' : 'bad-upload-item';
            
            var item = $('<div class="'+itemStyle+'"><table>'
                +'<tr>'
                +'<td width="12%"><div><img src="'+makeNiceIcons( file )+'" width="100%" /></div></td>'
                +'<td width="86%">'
                +'<p class="upload-item-name">'+file.name+' - '+test[1]+'</p>'
                +'<p>File type: ('+ file.type +') - ' +Math.round(file.size / 1024) + 'KB</p>'
                +'<div class="progress progress-striped">'
                +'<div class="bar" style="width:0px;"></div>'
                +'</div>'
                +'</td>'
                +'</tr>'
                +'</table></div>');
            $(fileList).append(item);
            fileQueue.push({
                file : file,
                item : item
            });
        }
    	
    }

    var uploadFile = function (file, item) {
        if (item && file) {
            
            
            var xhr = new XMLHttpRequest(),
            upload = xhr.upload,
            multipart ="";
                
            upload.addEventListener("progress", function (ev) {
                if (ev.lengthComputable) {
                    $( item ).find('.bar').width( (ev.loaded / ev.total) * 100 + "%" );
                }
            }, false);
            upload.addEventListener("load", function (ev) {
                $( item ).find('.bar').width('100%').addClass('bar-success');
                $(item ).find('.progress').removeClass('active');
            }, false);
            
            xhr.onreadystatechange = function(e) {
                
                if (this.readyState == 4 && this.status == 200) {
                    var response = eval("("+xhr.responseText+")");
                    if( typeof response.status !== "undefined" )
                    {
                        if( response.status == 1 )
                        {
                            $( item ).remove();
                            loopQueue();
                        }else{
                            $(item).find('.progress').removeClass('active');
                            $(item).find('.bar').removeClass('bar-success').addClass('bar-danger').width('100%');
                            $(item).find('.upload-item-name').addClass('text-error').html(response.message);
                        }
                    }else{
                        $(item).find('.progress').removeClass('active');
                        $(item).find('.bar').removeClass('bar-success').addClass('bar-danger').width('100%');
                        $(item).find('.upload-item-name').addClass('text-error').html('Unable to load this file!');
                    }
                    
                }
                
                if (this.readyState == 4 && this.status == 500) {
                    var response = eval("("+xhr.responseText+")");
                    $(item).find('.progress').removeClass('active');
                    $(item).find('.bar').removeClass('bar-success').addClass('bar-danger').width('100%');
                    $(item).find('.upload-item-name').addClass('text-error').html(response.name +" "+response.message );
                }
            };
            
            upload.addEventListener("error", function (ev) {
                alert(ev);
            }, false);
            
            xhr.open( "POST", uploadUrl , true );
            var formData = new FormData();
            formData.append('data[Mediafile][src]', file);
            formData.append('data[Mediafile][description]', $('#description').val());
            if( mediaLink )
            {
                //alert( mediaLink.foreign_model );
                formData.append('data[MediaLink][foreign_model]',mediaLink.foreign_model);
                formData.append('data[MediaLink][foreign_field]',mediaLink.foreign_field);
                formData.append('data[MediaLink][foreign_key]',mediaLink.foreign_key);		
            }
            //console.log( xhr ),
            xhr.send(formData);  // multipart/form-data
		    
        }
    }
    
    var makeNiceIcons = function ( file ) {
    	
        var name = file.name;
        var extention = name.substr(name.lastIndexOf('.') + 1, 8);
        var ico = 'file_default.png';
        
        switch( extention ){
        	
            case 'wav':
            case 'mp3':
                ico = 'audio.png';
                break;
        		
            case 'pdf':
                ico = 'file_pdf.png';
                break;
        		
            case 'rar':
                ico = 'file_rar.png';
                break;
        	
            case 'zip':
                ico = 'file_zip.png';
                break;
        		
            case 'bmp':
                ico = 'image_bmp.png';
                break;
        		
            case 'jpg':
            case 'jpeg':
                ico = 'image_jpeg.png';
                break;
        		
            case 'gif':
                ico = 'image_gif.png';
                break;
        		
            case 'png':
                ico = 'image_png.png';
                break;
        		
            case 'tiff':
                ico = 'image_tiff.png';
                break;
        	
            case 'wmv':
            case 'ogg':
            case 'ogv':
            case 'avi':
            case 'mpg':
            case 'mp4':
                ico = 'video.png';
                break;
        }
    	
        return iconsFolder + ico;
    
    }
    
}