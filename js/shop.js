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
	
});

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
		{ column : 'tirewidth', title : '' },
		{ column : 'tireratio', title : '' },
		{ column : 'tirediameter', title : '' },
		{ column : 'weight', title : 'Weight' },
		{ column : 'material', title : 'Material' }];
	var out = {};
	var str = '<table class="info-block"><tbody>%s</tbody></table>';
	var tr  = '';

	for (var i = 0; i < count; i++) 
	{		
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
	
	return sprintf(str, tr);
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