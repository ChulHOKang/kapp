<?php
function Shorten_String($String, $MaxLen, $ShortenStr)  { 
	$StringLen = strlen($String);  
	for ($i = 0, $count = 0, $tag = 0; $i <= $StringLen && $count < $MaxLen; $i++ ) { 
             $LastStr = substr($String, $i, 1); 
		if ($LastStr == '<') $tag = 1; 
		if ($tag && $LastStr == '>') { $tag = 0; continue; } 
		if ($tag) continue; 
		if ( ord($LastStr) > 127 ) { $count++; $i++; } 
		$count++; 
	        
	} 
	$gubun=substr($String,0,2);
	$RetStr = substr($String, 0, $i); 
			 
	if ($count<$MaxLen) return $RetStr; 
	else return $RetStr .= $ShortenStr; 
          
} 
?>