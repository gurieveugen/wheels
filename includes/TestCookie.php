<?php

class TestCookie{
	public function __construct()
	{
		$url = 'http://www.tirerack.com/tires/TireSearchControlServlet?ajax=true&action=filterTires&startIndex=0&viewPerPage=10&brands=Hankook,BFGoodrich,Hoosier,Bridgestone,Kumho,Classic,Michelin,Continental,Pirelli,Dick Cepek,Power King,Dunlop,Sumitomo,Firestone,Toyo,Fuzion,Uniroyal,General,Yokohama,Goodyear&perfCats=EP,MP,UHP,HP,GT,UHPAS,HPAS,PAS,GTAS,ST,AS,PPW,PSIS,PSW,TEMP,DRY,WET,STRT,DRAG,SSTAS,SST,HR,CSTAS,HAS,ORAT,ORCT,ORMT,LTPW,LTSIS,LTSW,TS&speedRatings=H%2CV%2CZ%2CW%2CY%2C(Y)&loadRatings=S,RF,XL,C,D,E,F,G&RunFlat=All&LRR=All&priceFilter=400';
		$ch = curl_init();    
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_VERBOSE, 2);
	    curl_setopt($ch, CURLOPT_ENCODING, 0);
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
	    // curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
	    // curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	    curl_setopt ($ch, CURLOPT_COOKIE, "WWW.TIRERACK.COM-172.16.1.16-443-COOKIE=R2212127248; JSESSIONID=DA893A4BF4B72F7CFDAEB77BC87BC7D5");

	    echo curl_exec($ch); 
	}
}
// ==============================================================
// Launch
// ==============================================================
$test = new TestCookie();