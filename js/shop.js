jQuery(document).ready(function(){
	// =========================================================
	// Click to accordion item title
	// =========================================================
	jQuery('.accordion-toggle').click(function(e){
		var id = jQuery(this).attr('href');
		jQuery(id).toggleClass('in');

		
		if(jQuery(id).hasClass('in'))
		{
			jQuery(this).find('b').removeClass('right-caret');
			jQuery(this).find('b').addClass('down-caret');
		}
		else
		{
			jQuery(this).find('b').removeClass('down-caret');
			jQuery(this).find('b').addClass('right-caret');
		}

		e.preventDefault();
	});

	// =========================================================
	// CHANGE #autoMake
	// =========================================================
	jQuery('#autoMake').change(function(e){
		var val = jQuery(this).val();
		jQuery.ajax({
			type: "POST",
			url: defaults.ajax_url + '?action=getYears',
			dataType: 'xml',
			data: {automake: val},						
			success: function(xml){    	
				jQuery('#autoYear').html('');							
				jQuery(xml).find('years year').each(function(){
					jQuery('#autoYear').append('<option value="' + jQuery(this).text() + '">' + jQuery(this).text() + '</option>');					
				});
			}
		});
		e.preventDefault();
	});
	// =========================================================
	// CHANGE #autoYear
	// =========================================================
	jQuery('#autoYear').change(function(e){
		var automake = jQuery('#autoMake').val();
		var autoyear = jQuery(this).val();
		jQuery.ajax({
			type: "POST",
			url: defaults.ajax_url + '?action=getModels',
			dataType: 'xml',
			data: {
				automake: automake,
				autoyear: autoyear},						
			success: function(xml){    	
				jQuery('#autoModel').html('');							
				jQuery(xml).find('models model').each(function(){
					jQuery('#autoModel').append('<option value="' + jQuery(this).text() + '">' + jQuery(this).text() + '</option>');					
				});
			}
		});
		e.preventDefault();
	});
	// =========================================================
	// CHANGE #autoModel
	// =========================================================
	jQuery('#autoModel').change(function(e){
		var automake  = jQuery('#autoMake').val();
		var autoyear  = jQuery('#autoYear').val();
		var automodel = jQuery(this).val();

		jQuery.ajax({
			type: "POST",
			url: defaults.ajax_url + '?action=getAdditionalInfo',
			dataType: 'xml',
			data: {
				automake:  automake,
				autoyear:  autoyear,
				automodel: automodel},						
			success: function(xml){    	
				jQuery('#autoModClar').html('');							
				jQuery(xml).find('clarifiers clar').each(function(){
					jQuery('#autoModClar').append('<option value="' + jQuery(this).text() + '">' + jQuery(this).text() + '</option>');					
				});
			}
		});
		e.preventDefault();
	});

	// =========================================================
	// SUBMIT SEARCH FORM
	// =========================================================
	// jQuery('.controls-block').submit(function(e){
	// 	var items = '';
	// 	var item;
	// 	jQuery.ajax({
	// 		type: "POST",
	// 		url: defaults.ajax_url + '?action=getResults',
	// 		dataType: 'json',
	// 		data: jQuery(this).serialize(),						
	// 		success: function(res){    	
	// 			console.log(res);				
	// 			for (var i = 0; i < res.length; i+=2) 
	// 			{
	// 				items += '<tr>';
	// 				for (var x = 0; x < 2; x++) 
	// 				{
	// 					item   = res[i+x];
	// 					items += wrapItem(item);
	// 				}
	// 				items += '</tr>';
	// 			}
	// 			jQuery('.main-table tbody').html(items);
	// 			initAfterLoad();
	// 		}
	// 	});
	// 	e.preventDefault();
	// });
	// =========================================================
	// VIEW ON VEHICLE
	// =========================================================
	jQuery('.view-on-vehicle').click(function(e){
		window.open(jQuery(this).attr('href'), 'popUp', 'width=700, height=495, scrollbars=1, resizable=1');
		e.preventDefault();
	});
	
});

function initAfterLoad()
{
	// =========================================================
	// ADDITIONAL INFO OPEN MODAL
	// =========================================================
	jQuery('.bock-open').click(function(e){		
		jQuery(jQuery(this).attr('href')).modal();
		e.preventDefault();
	});
}

/**
 * Wrap one result item
 * @param  JSON json --- one result items
 * @return string    --- HTML code
 */
function wrapItem(json)
{
	return '<td>' +
			'<div class="left-side">' +
			'<div class="image">' +
			'<img src="' + json.wheel_img  + '" alt="">' +
			'</div>' +
			'<ul class="links">' +
			'<li><a href="#block-' + json.index + '" class="bock-open">18" <br> 204</a></li>' +
			'<li><a href="#block-' + json.index + '" class="bock-open">20" <br> 249</a></li>' +
			'</ul> ' +
			'</div>' +
			'<div class="right-side">' +
			'<div class="image">' +
			'<a href="#"><img src="' + json.logo_img + '" alt=""></a>' +
			'</div>' +
			json.description.value + '<br><br>' +
			'<span class="description">' +
			json.text +
			'</span><br>' +
			'<a href="' + json.view_on_vehicle + '" class="link view-on-vehicle" onclick="popUp(this); return false;" target="_blank"><b>View on Vehicle</b></a>' +
			'</div>' + wrapItemInfo(json.index, json.wheel_info_html) +			
			'</td>';
}

function wrapItemInfo(id, text)
{
	return '<div style="display: none" class="modal" id="block-' + id +'">' +
			    '<div class="header">' +
			    	'<h1 style="float: left">Description</h1>' +
			        '<a class="close" onclick="hideDialog(\'#block-' + id + '\')" data-dismiss="modal">×</a>' +
			    '</div>' +
			    '<div class="body text-center">' +			        
			        text +
			    '</div>' +
			    '<div class="footer">' +
			    	'<a href="#" data-dismiss="modal" onclick="hideDialog(\'#block-' + id + '\')" class="btn btn-shop btn-success right">Hide description</a>' +
			    '</div>' +
			'</div>';
}

/**
 * Open new popup
 * @param  object obj --- dom object
 */
function popUp(obj)
{
	window.open(jQuery(obj).attr('href'), 'popUp', 'width=700, height=495, scrollbars=1, resizable=1');	
}

function hideDialog(id)
{
	jQuery(id).modal('hide');
}