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
	// CHANGE FACTOR
	// =========================================================
	jQuery('.factor').change(function(e){
		var count = jQuery(this).val();
		var price = jQuery(this).data('price');
		var block = jQuery(this).parent().parent().parent();
		
		block.find('span.count').text(count);
		block.find('span.sum').text('$' + (count*price));
		
		e.preventDefault();
	});
	
	// =========================================================
	// VIEW ON VEHICLE
	// =========================================================
	jQuery('.view-on-vehicle').click(function(e){
		window.open(jQuery(this).attr('href'), 'popUp', 'width=700, height=495, scrollbars=1, resizable=1');
		e.preventDefault();
	});

	// =========================================================
	// CLOSE MODAL
	// =========================================================
	jQuery('.close').click(function(e){
		jQuery(this).parent().parent().modal('hide');
		e.preventDefault();
	});

	// =========================================================
	// TIRES FILTER
	// =========================================================
	jQuery('#tires_filter input').change(function(e){		
		var sorry = jQuery('<tr><td><b>Sorry, no tires match your current "Filter By" settings.</b> <ul> <li>1)Try changing your "Filter By" settings on the left for better results.</li><small>- or -</small><li>2)Reset your "Filter By" settings to display all available tires.</li> <small>- or -</small> <li>3) Search for tires for a different vehicle.</li> </ul></td></tr>');
		jQuery.ajax({
			type: "POST",
			url: defaults.ajax_url + '?action=getTireLocations',
			dataType: 'xml',
			data: jQuery('#tires_filter').serialize(),						
			success: function(xml){    	
				jQuery('table.main-table tbody td').each(function(){
					jQuery(this).parent().addClass('hide');
				});

				if(jQuery(xml).find('response noResults').text() == 'true')
				{
					jQuery('table.main-table tbody').prepend(sorry);
				}
				else
				{
					jQuery(xml).find('tireLocation').each(function(){
						jQuery('#td-' + jQuery(this).text()).parent().removeClass('hide');
					});
				}
			}
		});
		e.preventDefault();
	});
	
	// =========================================================
	// VIEW ALL BUTTON
	// =========================================================
	jQuery('.view-all-btn').click(function(e){
		jQuery('.select-view').val(jQuery(this).data('count'));
		jQuery('.select-view').trigger('change');
		viewPerPage(jQuery(this).data('count'));
		e.preventDefault();
	});
	// =========================================================
	// VIEW PER PAGE SELECT
	// =========================================================
	jQuery('.select-view').change(function(){
		viewPerPage(jQuery(this).val());
		jQuery('ul.pagination-list').replaceWith(getPaginationHTML(1, jQuery(this).val(), jQuery(this).data('count')));
		initPagination();
	});
	initPagination();
	// =========================================================
	// PRICE RANGE
	// =========================================================
	jQuery( "#slider-range" ).slider({		
		min: 20,
		max: 400,
		values: [ 400 ],
		slide: function( event, ui ) {
			jQuery("#amount").text("$" + ui.values[0]);
			jQuery('#priceFilter').val(ui.values[0]);
			clearTimeout(window.tOut);
			window.tOut = setTimeout(function(){ jQuery('#priceFilter').trigger('change'); }, 600);
			
		}
	});
    jQuery("#amount").text( "$" + jQuery( "#slider-range" ).slider( "values", 0));
	
});

function initPagination()
{
	// =========================================================
	// CLICK TO PAGINATION
	// =========================================================
	jQuery('ul.pagination-list li a').click(function(){
		var val   = jQuery(this).data('val');
		var count = jQuery(this).data('count');

		pagination(val, count);
		jQuery('ul.pagination-list').replaceWith(getPaginationHTML(val, count, jQuery(this).data('countAll')));
		initPagination();
	});
}

/**
 * Generate pagination HTML code
 * @param  integer current --- current page
 * @param  integer count   --- items per page
 * @param  integer items   --- count all items
 * @return string          --- HTML code
 */
function getPaginationHTML(current, count, items)
{	
	var out   = '';
	var pages = Math.ceil(items/count);	
	if(pages <= 1) return '<ul class="pagination-list"></ul>';
	
	out = '<ul class="pagination-list">';
	if(current > 1) out += '<li><a data-count="'+count+'" data-val="'+(current-1)+'" data-count-all="'+items+'" href="#" class="activeprevious button"></a></li>';
	else out += '<li><a data-count="'+count+'" data-val="0" data-count-all="'+items+'" href="#" class="previous button"></a></li>';
	for (var i = 1; i <= pages; i++) 
	{
		if(i != current) out += '<li><a href="#" data-val="'+i+'" data-count-all="'+items+'" data-count="'+count+'">'+i+'</a></li>';
		else out += '<li>'+i+'</li>';
	}
	if(current < pages) out += '<li><a data-count="'+count+'" data-val="'+(current+1)+'" data-count-all="'+items+'" class="activenext button" href="#"></a></li>';
	else out += '<li><a data-count="'+count+'" data-val="'+pages+'" data-count-all="'+items+'" class="next button" href="#"></a></li>';
	out += '</ul>';

	return out;
}

/**
 * Pagination items
 * @param  integer val   --- current
 * @param  integer count --- items per page
 */
function pagination(val, count)
{
	var offset = 0;
	if(val > 1) offset = (count*(val-1));	
	jQuery('table.main-table tbody td').each(function(index){
		if(index < offset) jQuery(this).parent().addClass('hide');
		else
		{
			if((offset + count) > index)
			{
				if(jQuery(this).parent().hasClass('hide')) jQuery(this).parent().removeClass('hide');
			}
		}
	});
}

/**
 * Show page count
 * @param  integer val --- items counter
 */
function viewPerPage(val)
{
	jQuery('table.main-table tbody tr').each(function(index){
		if(index < val) jQuery(this).removeClass('hide');
	});
}

/**
 * Function from www.tirerack.com
 * @param  integer i             
 * @param  integer tabIndex      
 * @param  string selectedFront 
 * @param  string suffix        
 * @param  object myEvent       
 */
function toggleInfo(i, tabIndex, selectedFront, suffix, myEvent) 
{
	var items   = Array();
	var url     = "/wheels/WheelGridControlServlet?action=openInfo&ajax=true&wheel=" + i + "&tab=" + tabIndex + "&initialPartNumber=" + selectedFront + '&' + defaults.encodedVehicle;
	var columns = ['size', 'price', 'offset', 'backspacing', 'tirewidth', 'tireratio', 'tirediameter', 'weight', 'material'];
	var item    = {};
	jQuery.ajax({
		type: "GET",
		url: defaults.ajax_url + '?action=getInfo',
		dataType: 'xml',
		data: { url : url },							
		success: function(xml){    	
			jQuery(xml).find('wheel').each(function(){
				for (var i = 0; i < columns.length; i++) 
				{
					item[columns[i]] = jQuery(this).find(columns[i]).text();					
				}	
				items.push(item);
				item = {};			
			});
			console.log(items);
			jQuery('#product-modal .modal-body').html(wrapInfoBlock(jQuery(xml).find('wheel').length, items));		
			jQuery('#product-modal').modal();	
		}
	});
}

function wrapInfoBlock(count, items)
{
	var columns = [		
		{ column : 'size', title : 'Size' },
		{ column : 'price', title : 'Price' },
		{ column : 'offset', title : 'Offset' },
		{ column : 'backspacing', title : 'Backspacing' },
		{ column : 'width_ratio_diameter', title : 'Rec. Tire Size' },		
		{ column : 'weight', title : 'Weight' },
		{ column : 'material', title : 'Material' }];
	var out = {};
	var str = '<table class="info-block"><tbody>%s</tbody></table>';
	var tr  = '';

	for (var i = 0; i < count; i++) 
	{	
		out['width_ratio_diameter'] = sprintf('<td>%s</td>', items[i]['tirewidth']	+ '/' + items[i]['tireratio']	+ '-' + items[i]['tirediameter']);
		for (var x = 0; x < columns.length; x++) 
		{
			if(out[columns[x].column] === undefined) out[columns[x].column] = sprintf('<td>%s</td>', items[i][columns[x].column]);
			else out[columns[x].column] += sprintf('<td>%s</td>', items[i][columns[x].column]);
		}		
	}

	for (var i = 0; i < columns.length; i++) 
	{		
		tr += sprintf('<tr><td><b>%s:</b></td>%s</tr>', columns[i].title, out[columns[i].column]);
	}
	
	return sprintf(str, tr.replace('//', '/').replace('undefined', ''));
}

/**
 * Open new popup
 * @param  object obj --- dom object
 */
function popUp(obj)
{
	window.open(jQuery(obj).attr('href'), 'popUp', 'width=700, height=495, scrollbars=1, resizable=1');	
}

function sprintf( ) {	// Return a formatted string
	// 
	// +   original by: Ash Searle (http://hexmen.com/blog/)
	// + namespaced by: Michael White (http://crestidg.com)

	var regex = /%%|%(\d+\$)?([-+#0 ]*)(\*\d+\$|\*|\d+)?(\.(\*\d+\$|\*|\d+))?([scboxXuidfegEG])/g;
	var a = arguments, i = 0, format = a[i++];

	// pad()
	var pad = function(str, len, chr, leftJustify) {
		var padding = (str.length >= len) ? '' : Array(1 + len - str.length >>> 0).join(chr);
		return leftJustify ? str + padding : padding + str;
	};

	// justify()
	var justify = function(value, prefix, leftJustify, minWidth, zeroPad) {
		var diff = minWidth - value.length;
		if (diff > 0) {
			if (leftJustify || !zeroPad) {
			value = pad(value, minWidth, ' ', leftJustify);
			} else {
			value = value.slice(0, prefix.length) + pad('', diff, '0', true) + value.slice(prefix.length);
			}
		}
		return value;
	};

	// formatBaseX()
	var formatBaseX = function(value, base, prefix, leftJustify, minWidth, precision, zeroPad) {
		// Note: casts negative numbers to positive ones
		var number = value >>> 0;
		prefix = prefix && number && {'2': '0b', '8': '0', '16': '0x'}[base] || '';
		value = prefix + pad(number.toString(base), precision || 0, '0', false);
		return justify(value, prefix, leftJustify, minWidth, zeroPad);
	};

	// formatString()
	var formatString = function(value, leftJustify, minWidth, precision, zeroPad) {
		if (precision != null) {
			value = value.slice(0, precision);
		}
		return justify(value, '', leftJustify, minWidth, zeroPad);
	};

	// finalFormat()
	var doFormat = function(substring, valueIndex, flags, minWidth, _, precision, type) {
		if (substring == '%%') return '%';

		// parse flags
		var leftJustify = false, positivePrefix = '', zeroPad = false, prefixBaseX = false;
		for (var j = 0; flags && j < flags.length; j++) switch (flags.charAt(j)) {
			case ' ': positivePrefix = ' '; break;
			case '+': positivePrefix = '+'; break;
			case '-': leftJustify = true; break;
			case '0': zeroPad = true; break;
			case '#': prefixBaseX = true; break;
		}

		// parameters may be null, undefined, empty-string or real valued
		// we want to ignore null, undefined and empty-string values
		if (!minWidth) {
			minWidth = 0;
		} else if (minWidth == '*') {
			minWidth = +a[i++];
		} else if (minWidth.charAt(0) == '*') {
			minWidth = +a[minWidth.slice(1, -1)];
		} else {
			minWidth = +minWidth;
		}

		// Note: undocumented perl feature:
		if (minWidth < 0) {
			minWidth = -minWidth;
			leftJustify = true;
		}

		if (!isFinite(minWidth)) {
			throw new Error('sprintf: (minimum-)width must be finite');
		}

		if (!precision) {
			precision = 'fFeE'.indexOf(type) > -1 ? 6 : (type == 'd') ? 0 : void(0);
		} else if (precision == '*') {
			precision = +a[i++];
		} else if (precision.charAt(0) == '*') {
			precision = +a[precision.slice(1, -1)];
		} else {
			precision = +precision;
		}

		// grab value using valueIndex if required?
		var value = valueIndex ? a[valueIndex.slice(0, -1)] : a[i++];

		switch (type) {
			case 's': return formatString(String(value), leftJustify, minWidth, precision, zeroPad);
			case 'c': return formatString(String.fromCharCode(+value), leftJustify, minWidth, precision, zeroPad);
			case 'b': return formatBaseX(value, 2, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'o': return formatBaseX(value, 8, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'x': return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'X': return formatBaseX(value, 16, prefixBaseX, leftJustify, minWidth, precision, zeroPad).toUpperCase();
			case 'u': return formatBaseX(value, 10, prefixBaseX, leftJustify, minWidth, precision, zeroPad);
			case 'i':
			case 'd': {
						var number = parseInt(+value);
						var prefix = number < 0 ? '-' : positivePrefix;
						value = prefix + pad(String(Math.abs(number)), precision, '0', false);
						return justify(value, prefix, leftJustify, minWidth, zeroPad);
					}
			case 'e':
			case 'E':
			case 'f':
			case 'F':
			case 'g':
			case 'G':
						{
						var number = +value;
						var prefix = number < 0 ? '-' : positivePrefix;
						var method = ['toExponential', 'toFixed', 'toPrecision']['efg'.indexOf(type.toLowerCase())];
						var textTransform = ['toString', 'toUpperCase']['eEfFgG'.indexOf(type) % 2];
						value = prefix + Math.abs(number)[method](precision);
						return justify(value, prefix, leftJustify, minWidth, zeroPad)[textTransform]();
					}
			default: return substring;
		}
	};

	return format.replace(regex, doFormat);
}