jQuery.noConflict();
(function($) { 
	$(document).ready(function(){
		
		//This is for the media upload functionality in the "Downloads" MetaBox
		function nb_add_media_selector(){
			
			var download_val = $('.nb_mat_downloads_val');
			var formfield = '';
			
			download_val.click(function( ) {
				
				formfield = $(this).attr('id');
				tb_show( '', 'media-upload.php?TB_iframe=true' ); //REMOVED type=image&amp; from query string to not limit to images only. 
				return false;
			});

			window.send_to_editor = function( html ) {
				
				console.log(html);
				console.log( "The value of formfield is: "+formfield);
				var hrefLink = $(html).attr('href');
				var textTitle = $(html).text();
				console.log( 'The value of hrefLink is: '+ hrefLink );
				console.log( 'the textTitle value is: '+ textTitle );
				$( formfield ).val( hrefLink );
				$( formfield ).prev('.nb_mat_downloads_name').val(textTitle);
				tb_remove();
			}
			
		}
		
		
		
		$('a.nb_mat_add_field').click( function( e ){
			e.preventDefault();
			var field = $(this).parents('.postbox').attr('id');
			field = field.substring( field.lastIndexOf("_") + 1 ); //returning only the string after the last underscore. 
			
			//console.log( field );
			
			var neighbor = $(this).prev();
			
			var inputID = neighbor.find('li:last-child input').attr('id');
			
			//console.log( inputID );
			if( typeof inum === 'undefined'){
				var inum = inputID.replace( /^\D+/g, ''); //Return only numbers from the string. 
			}
			inum++;
			
			var placeholder = [];
			//console.log( "The value of the field is: " + field );
			switch(field){
				case 'downloads':
					placeholder = ['File Name','Relative URL Only'];
					break;
				case 'attributes':
				default: 
					placeholder = ['Title','Value'];
					break;
			}
			
			neighbor.append(`
			<li><input type='text' class='nb_mat_${field}_name' name='nb_mat_${field}_name${inum}' id='nb_mat_${field}_name${inum}' placeholder='${placeholder[0]}'  />
				<input type='text' class='nb_mat_${field}_val' name='nb_mat_${field}_val${inum}' id='nb_mat_${field}_val${inum}' placeholder='${placeholder[1]}'  /></li>
			`);
			
			//nb_add_media_selector();
		});
		
		$('a.nb_mat_drop_field').click( function( e ){
			e.preventDefault();
			$(this).siblings('ol').find('li:last-child').remove();
			//Maybe store values if not empty? No. 
			
		});
		
		
		//nb_add_media_selector();
		
		
		//GALLERY META BOX FUNCTIONALITY
		
		 var file_frame;

		$(document).on('click', '#_nb_cbl_gallery a.gallery-add', function(e) {

			e.preventDefault();

			if (file_frame) file_frame.close();

			file_frame = wp.media.frames.file_frame = wp.media({
			  title: $(this).data('uploader-title'),
			  button: {
				text: $(this).data('uploader-button-text'),
			  },
			  multiple: true
			});

			file_frame.on('select', function() {
			  var listIndex = $('#gallery-metabox-list li').index($('#gallery-metabox-list li:last')),
				  selection = file_frame.state().get('selection');

			  selection.map(function(attachment, i) {
				attachment = attachment.toJSON(),
				index      = listIndex + (i + 1);

				$('#gallery-metabox-list').append('<li><input type="hidden" name="_nb_cbl_gallery[' + index + ']" value="' + attachment.id + '"><img class="image-preview" src="' + attachment.sizes.thumbnail.url + '"><a class="change-image button button-small" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image">Change image</a><br><small><a class="remove-image" href="#">Remove image</a></small></li>');
			  });
			});

			makeSortable();

			file_frame.open();

		});

		$(document).on('click', '#_nb_cbl_gallery a.change-image', function(e) {

			e.preventDefault();

			var that = $(this);

			if (file_frame) file_frame.close();

			file_frame = wp.media.frames.file_frame = wp.media({
			  title: $(this).data('uploader-title'),
			  button: {
				text: $(this).data('uploader-button-text'),
			  },
			  multiple: false
			});

			file_frame.on( 'select', function() {
			  attachment = file_frame.state().get('selection').first().toJSON();

			  that.parent().find('input:hidden').attr('value', attachment.id);
			  that.parent().find('img.image-preview').attr('src', attachment.sizes.thumbnail.url);
			});

			file_frame.open();

		});

		function resetIndex() {
			$('#gallery-metabox-list li').each(function(i) {
			  $(this).find('input:hidden').attr('name', '_nb_cbl_gallery[' + i + ']');
			});
		}

		function makeSortable() {
			$('#gallery-metabox-list').sortable({
			  opacity: 0.6,
			  stop: function() {
				resetIndex();
			  }
			});
		}

		$(document).on('click', '#_nb_cbl_gallery a.remove-image', function(e) {
			e.preventDefault();

			$(this).parents('li').animate({ opacity: 0 }, 200, function() {
			  $(this).remove();
			  resetIndex();
			});
		});

		makeSortable();
		
		
		
		
		
		
		
		
	});
})(jQuery);