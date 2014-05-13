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
	// CHANGE #select_make
	// =========================================================
	jQuery('#select_make').change(function(e){
		var val = jQuery(this).val();
		jQuery.ajax({
			type: "POST",
			url: defaults.ajax_url + '?action=getYears',
			dataType: 'xml',
			data: {automake: val},						
			success: function(xml){    	
				jQuery('#year').html('');							
				jQuery(xml).find('years year').each(function(){
					jQuery('#year').append('<option value="' + jQuery(this).text() + '">' + jQuery(this).text() + '</option>');					
				});
			}
		});
		e.preventDefault();
	});
	// =========================================================
	// CHANGE #year
	// =========================================================
	jQuery('#year').change(function(e){
		var automake = jQuery('#select_make').val();
		var autoyear = jQuery(this).val();
		jQuery.ajax({
			type: "POST",
			url: defaults.ajax_url + '?action=getModels',
			dataType: 'xml',
			data: {
				automake: automake,
				autoyear: autoyear},						
			success: function(xml){    	
				jQuery('#model').html('');							
				jQuery(xml).find('models model').each(function(){
					jQuery('#model').append('<option value="' + jQuery(this).text() + '">' + jQuery(this).text() + '</option>');					
				});
			}
		});
		e.preventDefault();
	});
	// =========================================================
	// CHANGE #model
	// =========================================================
	jQuery('#model').change(function(e){
		var automake  = jQuery('#select_make').val();
		var autoyear  = jQuery('#year').val();
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
				jQuery('#additional').html('');							
				jQuery(xml).find('clarifiers clar').each(function(){
					jQuery('#additional').append('<option value="' + jQuery(this).text() + '">' + jQuery(this).text() + '</option>');					
				});
			}
		});
		e.preventDefault();
	});

	// =========================================================
	// SUBMIT SEARCH FORM
	// =========================================================
	jQuery('.controls-block').submit(function(e){
		var items = '';
		var item;
		jQuery.ajax({
			type: "POST",
			url: defaults.ajax_url + '?action=getResults',
			dataType: 'json',
			data: jQuery(this).serialize(),						
			success: function(res){    					
				for (var i = 0; i < res.length; i+=2) 
				{
					items += '<tr>';
					for (var x = 0; x < 2; x++) 
					{
						item   = res[i+x];
						items += wrapItem(item);
					}
					items += '</tr>';
				}
				jQuery('.main-table tbody').html(items);
			}
		});
		e.preventDefault();
	});
});

function wrapItem(json)
{
	return '<td>' +
			'<div class="left-side">' +
			'<div class="image">' +
			'<a href="#"><img src="' + json.wheel_img  + '" alt=""></a>' +
			'</div>' +
			'<ul class="links">' +
			'<li><a href="#">18" <br> 204</a></li>' +
			'<li><a href="#">20" <br> 249</a></li>' +
			'</ul> ' +
			'</div>' +
			'<div class="right-side">' +
			'<div class="image">' +
			'<a href="#"><img src="' + json.logo_img + '" alt=""></a>' +
			'</div>' +
			'<a href="#" class="link">' + json.description.value + '</a><br><br>' +
			'<span class="description">' +
			'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus, autem.' +
			'</span><br>' +
			'<a href="#" class="link"><b>View on Vehicle</b></a>' +
			'</div>' +
			'</td>';
}