function CostCalculator()
{
	if(pagenow == 'cost_calculator')
	{
		jQuery( '#title' ).autocomplete({
	      source: cost_calculator
	    });
	    jQuery( '#title' ).focus(function(){
	    	jQuery( '#title' ).autocomplete( 'search', ' ' );
	    });
	    jQuery( '#post-preview' ).trigger('focus');	
	}
}

jQuery(document).ready(function(){
    var calculator = new CostCalculator();
});


