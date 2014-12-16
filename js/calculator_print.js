function CalculatorPrint(){
	//                                       __  _          
	//     ____  _________  ____  ___  _____/ /_(_)__  _____
	//    / __ \/ ___/ __ \/ __ \/ _ \/ ___/ __/ / _ \/ ___/
	//   / /_/ / /  / /_/ / /_/ /  __/ /  / /_/ /  __(__  ) 
	//  / .___/_/   \____/ .___/\___/_/   \__/_/\___/____/  
	// /_/              /_/                                 
	var $this = this;
	$this.out = [];
	//                    __  __              __    
	//    ____ ___  ___  / /_/ /_  ____  ____/ /____
	//   / __ `__ \/ _ \/ __/ __ \/ __ \/ __  / ___/
	//  / / / / / /  __/ /_/ / / / /_/ / /_/ (__  ) 
	// /_/ /_/ /_/\___/\__/_/ /_/\____/\__,_/____/  
	$this.add = function(el){
		if(el.sum > 0)
		{
			$this.out.push( el );
		}
	};	                                             

	/**
	 * Display out array
	 */
	$this.display = function(){
		var sum    = $this.sum($this.out);
		var result = jQuery('#result');
		result.html('');

		for(var i = 0; i < $this.out.length; i++)
		{
			result.append(
				String.Format(
					'<div class="result-row"><b>{0}: </b><span>{1}</span></div>',
					$this.out[i].title,
					$this.out[i].sum.toFixed(2)
				)
			);
		}
		result.prepend(
			String.Format(
				'<div class="result-row"><h2>Sum: <span>{0}</span> </h2></div>',
				sum.toFixed(2)
			)
		);
		result.append('<br>');
	};

	/**
	 * Som all print sections
	 * @param  array print --- array to print
	 * @return float --- sum 
	 */
	$this.sum = function(print){
		var sum = 0;

		for(var i = 0; i < print.length; i++)
		{
			sum += parseFloat( print[i].sum );
		}
		return sum;
	};
}