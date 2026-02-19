<?php
  function xcalendar($year, $month)
  {
	list($week,$term) = xmonth_info($year,$month);

	$eidx = 3;
	$refs = range(1,$term); // reference of days
	$fsat = 7 - $week; // first Saturday

	## make index array such as (Sun,Sat)
	##
	for($i=0; $i<=3; $i++)
	{
		$isat = $fsat + ($i*7); // index of Saturday
		$idxs[] = array($isat-6,$isat);
	}

	## check last Saturday and Sunday
	##
	if(($fsat+28) <= $term) $idxs[++$eidx] = array($fsat+22,$fsat+28);
	if(($term-$idxs[$eidx][1]) > 0)
	{
		$idxs[] = array($idxs[$eidx][0]+7,$idxs[$eidx][1]+7);
		$eidx++;
	}

	## rewrite days
	##
	for($i=0; $i<=$eidx; $i++)
	{
		for($j=$idxs[$i][0]; $j<=$idxs[$i][1]; $j++) $r[$i][] = &$refs[$j-1];
	}

	return $r; // array
  }

//-------- 변형함수 추가.
  function xsolar($utime=0, $GMT=FALSE)
  {
	return xtoday($utime,$GMT);
  }

  function xtoday($utime=0, $GMT=FALSE)
  {
	if($utime == '') $utime = time();
	if($GMT) $utime -= 32400;

	list($year,$moon,$moonday) = explode(' ',date('Y n nd',$utime));
	$tomorrow = date('nd',$utime+86400);

	$terms = xterms($year,$moon,0);
	$samboks = xsambok($year);
	$sambok1 = $samboks[$moonday];
	$sambok2 = $samboks[$tomorrow];

	if($term = $terms[$moonday])
	{
		if($sambok1) $term .= '/'.$sambok1;
		$str = '오늘은 <B>'.$term.'</B>입니다.';
	}
	else if($term = $terms[$tomorrow])
	{
		if($sambok2) $term .= '/'.$sambok2;
		$str = '내일은 <B>'.$term.'</B>입니다.';
	}
	else if($sambok1) $str = '오늘은 <B>'.$sambok1.'</B>입니다.';
	else if($sambok2) $str = '내일은 <B>'.$sambok2.'</B>입니다.';

	return $str;
  }
  function xsun($utime, $GMT=FALSE)
  {
	$L = $D = $JD = 0; $J = '';
	$deg2rad = array();

	/***
	if($utime<-2145947400 || $utime>2145884399)
	{
		echo "\nerror: invalid input $utime, 1902.01.01 00:00:00 <= utime <= 2037.12.31 23:59:59\n";
		return -1;
	}
	***/

	list($L,$atime) = xsunl($utime,$GMT,$D,$JD,$J,$deg2rad);

	## Sun's ecliptic, in degress
	##
	$e = sprintf('%.10f',23.439 - (0.00000036*$D)); // degress

	$cosg = cos($deg2rad['g']); // degress
	$cos2g = cos($deg2rad['2g']); // degress

	## R == AU (sun ~ earth)
	## The distance of the Sun from the Earth, R, in astronomical units (AU)
	##
	$R = sprintf('%.10f',1.00014 - (0.01671*$cosg) - (0.00014*$cos2g));

	## convert
	##
	$deg2rad['e'] = deg2rad($e); // radian
	$deg2rad['L'] = deg2rad($L); // radian

	$cose = cos($deg2rad['e']); // degress
	$sinL = sin($deg2rad['L']); // degress
	$cosL = cos($deg2rad['L']); // degress
	$sine = sin($deg2rad['e']); // degress

	## the Sun's right ascension(RA)
 	##
	//$tanRA = sprintf('%.10f',$cose * $sinL / $cosL); // degress
	//$RA = sprintf('%.10f',rad2deg(atan($tanRA)));
	//$RA = $cosL<0 ? $RA+180 : ($sinL<0 ? $RA+360 : $RA); // patch 2005.01.18
	$RA = sprintf('%.10f',rad2deg(atan2($cose*$sinL,$cosL)));
	$RA = xdeg2valid($RA);

	## the Sun's declination(d)
	##
	$sind = sprintf('%.10f',$sine * $sinL); // degress
	$d = sprintf('%.10f',rad2deg(asin($sind))); // Sun's declination, degress

	$solartime = xdeg2solartime($L);
	$daytime = xdeg2daytime($RA);

	//if(!($L1=round($L) % 15))
	//{
	//	$idx = $L1 / 15;
	//	list($hterms) = xgterms();
	//}

	## all base degress or decimal
	##
 	return array
	(
	'JD' => $JD,	/*** Julian Day ***/
	'J'  => 'J'.$J, // Jxxxx.xxxx format
	'L'  => $L,	/*** Sun's geocentric apparent ecliptic longitude ***/
	'e'  => $e,	/*** Sun's ecliptic ***/
	'R'  => $R,	/*** Sun from the Earth, astronomical units (AU) ***/
	'RA' => $RA,	/*** Sun's right ascension ***/
	'd'  => $d,	/*** Sun's declination ***/
	'stime'  => $solartime,		/*** solar time ***/
	'dtime'  => $daytime,		/*** day time ***/
	'atime'  => $atime,		/*** append time for integer degress **/
	'utime'  => $utime,		/*** unix timestamp ***/
	'date'   => x_date('D, d M Y H:i:s T',$utime),	/*** KST date ***/
	'gmdate' => x_date('D, d M Y H:i:s ',$utime-date('Z')).'GMT',	/*** GMT date ***/
	'_L'  => xdeg2angle($L),
	'_e'  => xdeg2angle($e,1),
	'_RA' => xdeg2angle($RA),
	'_d'  => xdeg2angle($d,1),
	'_stime' => xtime2stime($solartime,FALSE,TRUE),
	'_dtime' => xtime2stime($daytime),
	'_atime' => xtime2stime($atime,TRUE),
	);
  }
  function xsunl($utime, $GMT=FALSE, &$D=0, &$JD=0, &$J='', &$deg2rad=array())
  {
	if($GMT) $utime += 32400; // force GMT to static KST, see 946727936

	## D -- get the number of days from base JD
	## D = JD(Julian Day) - 2451545.0, base JD(J2000.0)
	##
	## base position (J2000.0), 2000-01-01 12:00:00, UT
	## as   mktime(12,0,0-64,1,1,2000) == 946695536 unix timestamp at KST
	## as gmmktime(12,0,0-64,1,1,2000) == 946727936 unix timestamp at GMT
	##
	$D = $utime - 946727936; // number of time
	$D = sprintf('%.10f',$D/86400); // float, number of days
	$JD = sprintf('%.10f',$D+2451545.0); // float, Julian Day
	$J = sprintf('%.4f',2000.0 + ($JD-2451545.0)/365.25); // Jxxxx.xxxx format

	$g = sprintf('%.10f',357.529 + (0.98560028 * $D));
	$q = sprintf('%.10f',280.459 + (0.98564736 * $D));

	## fixed
	##
	$g = xdeg2valid($g); // to valid degress
	$q = xdeg2valid($q); // to valid degress

	## convert
	##
	$deg2rad = array();
	$deg2rad['g'] = deg2rad($g); // radian
	$deg2rad['2g'] = deg2rad($g*2); // radian

	$sing = sin($deg2rad['g']); // degress
	$sin2g = sin($deg2rad['2g']); // degress

	## L is an approximation to the Sun's geocentric apparent ecliptic longitude
	##
	$L = sprintf('%.10f',$q + (1.915 * $sing) + (0.020*$sin2g)); 
	$L = xdeg2valid($L); // degress
	$atime = xdeg2solartime(round($L)-$L); // float

	return array($L,$atime); // array, float degress, float seconds
  }

  ## public, same as `date()' function, but base on JD by UT(delta T)
  ##
  ## valid JD: BC 4713-01-01 12:00 GMT ~ AD 9999
  ##
  function xdate($format, $JD=NULL)
  {
	static $_weeks = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	static $_months = array('January','February','March','April','May','June','July','August',
		'September','Octorber','November','December');
	static $_ordinals = array(1=>'st',21=>'st',31=>'st',2=>'nd',22=>'nd',3=>'rd',23=>'rd');

	if(func_num_args()<2 || $JD==NULL) $JD = xmkjd(); // current JD(UT)
	if(!$format || is_array($format)) return x_todate($JD); // array

	list($Y,$M,$D,$H,$I,$S) = x_todate($JD);

	## get DST(daylight saving time), patch san2@2010.05.19
	##
	if($Y>=1916 && $Y<2038)
	{
		list($_DST,$_Z,$_O,$_T) = explode(' ',date('I Z O T',mktime(12,0,0,$M,$D,$Y)));
	} else
	{
		$_DST = 0;
		list($_Z,$_O,$_T) = explode(' ',date('Z O T')); // $_O example +0900
	}

	## patch san2@2010.05.19
	##
	if($Y>1970 && $Y<2038) $_U = mktime($H,$I,$S,$M,$D,$Y);
	else $_U = x_jd2utime($JD);

	$_Y = sprintf('%04d',$Y);
	$_M = sprintf('%02d',$M);
	$_D = sprintf('%02d',$D);
	$_H = sprintf('%02d',$H);
	$_I = sprintf('%02d',$I);
	$_S = sprintf('%02d',$S);
	$_w = xjddayofweek($JD + ($_Z/86400)); // JD apply to local TimeZone
	$_W = xweeknumber($Y,$M,$D); // ISO-8601
	if( isset($_weeks[$_W]) ) $_R = substr($_weeks[$_W],0,3).", $_D ".substr($_months[$M-1],0,3)." $H:$I:$S $_O";
	else $_R = "---".", $_D ".substr($_months[$M-1],0,3)." $H:$I:$S $_O";
	$_P = substr($_O,0,3).':'.substr($_O,-2);
	$_C = "${_Y}-${_M}-${_D}T${_H}:${_I}:${_S}${_P}";
	$_N = ($_W == 0) ? 7 : $_W;
	$_o = ($M==12 && $_W==1) ? $Y+1 : (($M==1 && $_W>=52) ? $Y-1 : $Y);

	$r = '';
	$nextskip = FALSE;
	$l = strlen($format);
	for($i=0; $i<$l; $i++)
	{
		$char = $format[$i];
		if(!trim($char)) { $r .= $char; continue; }
		if($nextskip) { $r .= $char; $nextskip = FALSE; continue; } // patch san2@2010.05.19
		if($char == '\\') { $nextskip = TRUE; continue; } else $nextskip = FALSE;
		switch($char)
		{
			case 'a': $r .= ($H<12) ? 'am' : 'pm'; break;
			case 'A': $r .= ($H<12) ? 'AM' : 'PM'; break;
			case 'B': $r .= xitime($H,$I,$S); break;
			case 'c': $r .= $_C; break; // ISO 8601 date (added in PHP5)
			case 'd': $r .= $_D; break;
			case 'D': $r .= substr($_weeks[$_w],0,3); break;
			case 'F': $r .= $_months[$M-1]; break;
			case 'g': $r .= (($H-1) % 12) + 1; break;
			case 'G': $r .= $H; break;
			case 'h': $r .= sprintf('%02d',(($H-1)%12)+1); break;
			case 'H': $r .= $_H; break;
			case 'i': $r .= $_I; break;
			case 'I': $r .= $_DST; break;
			case 'j': $r .= $D; break;
			case 'J': $r .= $JD; break;
			case 'l': $r .= $_weeks[$_W]; break;
			case 'L': $r .= xisleap($Y); break;
			case 'm': $r .= $_M; break;
			case 'M': $r .= substr($_months[$M-1],0,3); break;
			case 'n': $r .= $M; break;
			case 'N': $r .= $_N; break; // ISO-8601, day of the week, 1(Monday) ~ 7(Sunday)
			case 'o': $r .= $_o; break; // ISO-8601 year number
			case 'O': $r .= $_O; break;
			case 'P': $r .= $_P; break;
			case 'r': $r .= $_R; break;
			case 's': $r .= $_S; break;
			case 'S': $r .= $_ordinals[$D] ? $_ordinals[$D] : 'th'; break;
			case 't': $r .= xdays_in_month($Y,$M); break;
			case 'T': $r .= $_T; break;
			case 'u': $r .= date('u'); break;
			case 'U': $r .= $_U; break;
			case 'w': $r .= $_w; break; // JD to local zone
			case 'W': $r .= sprintf('%02d',$_W); break; // ISO-8601
			case 'y': $r .= substr($_Y,-2); break;
			case 'Y': $r .= $Y; break;
			case 'z': $r .= xdayofyear($Y,$M,$D); break;
			case 'Z': $r .= $_Z; break; // KST zone +9H, in seconds

			default : $r .= $char; break;
		}
	}

	return $r; // string
  }
  ## private,  same as `date()' function, base on unix timestamp(support Microsoft Windows PHP4)
  ##
  ## valid date: 1902-01-01 00:00:00 ZONE <= date <= 2037-12-31 23:59:59 ZONE
  ##

  function x_date( $format, $utime=NULL)
  {
	if($utime === NULL) $utime = time();
	if($utime>=0 && $utime<2145884400) return date($format,$utime);
	$JD = x_utime2jd($utime);
	$str = xdate($format,$JD);
 	return $str;
  }

  function xdeg2daytime($deg)
  {
	return sprintf('%.4f',$deg*240); // seconds
  }

  ## 1 solar year == 365.242190 days == 31556925.216 seconds
  ## 1 degress == 31556925.216 seconds / 360 degress == 87658.1256 seconds
  ##
  function xdeg2solartime($deg)
  {
	return sprintf('%.4f',$deg*87658.1256); // seconds
  }

  function xdeg2angle($deg, $singed=FALSE)
  {
	list($d,$m,$s) = xdeg2dms($deg,$signed);

	return $d.chr(161).chr(198).$m.chr(161).chr(199).$s.chr(161).chr(200);
  }

  function xdeg2valid($deg)
  {
	//if($deg <= 360 && $deg >=0) return $deg;
	$deg = ($deg>=0) ? fmod($deg,360) : fmod($deg,360)+360.0;

	return (float)$deg; // float degress
  }

  function xmoon2valid($moon)
  {
	//$moon = max($moon,1);
	//$moon = min($moon,12);

	if($moon < 1) $moon = 1;
	else if($moon > 12) $moon = 12;

	return (int)$moon;
  }

  function xtime2stime($time, $singed=FALSE, $printday=FALSE)
  {
	if($singed) $singed = '+';
	if($time<0) { $singed = '-'; $time = abs($time); }
	$printday = $printday ? 'z ' : ''; // why? 0 is false

	return $singed.date($printday.'H i s',$time-date('Z')); // $time is small, _date() to date()
  }

  function xgterms()
  {
	static $hterms = array
	(
	'소한','대한','입춘','우수','경칩','춘분','청명','곡우',
	'입하','소만','망종','하지','소서','대서','입추','처서',
	'백로','추분','한로','상강','입동','소설','대설','동지'
	);

	static $tterms = array
	(
	-6418939, -5146737, -3871136, -2589569, -1299777,        0,
	 1310827,  2633103,  3966413,  5309605,  6660762,  8017383,
	 9376511, 10735018, 12089855, 13438199, 14777792, 16107008,
	17424841, 18731368, 20027093, 21313452, 22592403, 23866369
	);

	## mktime(7+9,36,19-64,3,20,2000), 2000-03-20 16:35:15(KST)
	##
	if(!defined('__SOLAR_START__'))
	{
	define('__SOLAR_START__',953537715); // start base unix timestamp
	define('__SOLAR_TYEAR__',31556940); // tropicalyear to seconds
	define('__SOLAR_BYEAR__',2000); // start base year
	}

	return array($hterms,$tterms);
  }

  function xtterms($year)
  {
	static $addstime = array
	(
	1902=> 1545, 1903=> 1734, 1904=> 1740, 1906=>  475, 1907=>  432,
	1908=>  480, 1909=>  462, 1915=> -370, 1916=> -332, 1918=> -335,
	1919=> -263, 1925=>  340, 1927=>  344, 1928=> 2133, 1929=> 2112,
	1930=> 2100, 1931=> 1858, 1936=> -400, 1937=> -400, 1938=> -342,
	1939=> -300, 1944=>  365, 1945=>  380, 1946=>  400, 1947=>  200,
	1948=>  244, 1953=> -266, 1954=> 2600, 1955=> 3168, 1956=> 3218,
	1957=> 3366, 1958=> 3300, 1959=> 3483, 1960=> 2386, 1961=> 3015,
	1962=> 2090, 1963=> 2090, 1964=> 2264, 1965=> 2370, 1966=> 2185,
	1967=> 2144, 1968=> 1526, 1971=> -393, 1972=> -430, 1973=> -445,
	1974=> -543, 1975=> -393, 1980=>  300, 1981=>  490, 1982=>  400,
	1983=>  445, 1984=>  393, 1987=>-1530, 1988=>-1600, 1990=> -362,
	1991=> -366, 1992=> -400, 1993=> -449, 1994=> -321, 1995=> -344,
	1999=>  356, 2000=>  480, 2001=>  483, 2002=>  504, 2003=>  294,
	2007=> -206, 2008=> -314, 2009=> -466, 2010=> -416, 2011=> -457,
	2012=> -313, 2018=>  347, 2020=>  257, 2021=>  351, 2022=>  159,
	2023=>  177, 2026=> -134, 2027=> -340, 2028=> -382, 2029=> -320,
	2030=> -470, 2031=> -370, 2032=> -373, 2036=>  349, 2037=>  523,
	);

	static $addttime = array
	(
	1919=> array(14=>-160), 1939=> array(10=> -508),
	1953=> array( 0=> 220), 1954=> array( 1=>-2973),
	1982=> array(18=> 241), 1988=> array(13=>-2455),
	2013=> array( 6=> 356), 2031=> array(20=>  411),
	2023=> array( 0=>  399, 11=>-571),
	);

	return array($addstime[$year],$addttime[$year]);
  }

  ## get the 24 solar terms, 1902 ~ 2037
  ##
  ## [usage]
  ##  - array xterms(int year [, int smoon [, int length [, array &sun]]] )
  ##
  function xterms($year=0, $smoon=1, $length=12, $sun=array())
  {
	$year  = (int)$year;
	$sun = array();
	$smoon = (int)$smoon;
	$length = (int)$length;
	$times = array();

	if(!$year) $year = date('Y');

	/***
	if($year<1902 || $year>2037)
	{
		echo "\nerror: invalid input $year, 1902 <= year <= 2037\n";
		return -1;
	}
	***/

	list($hterms,$tterms) = xgterms();
	list($addstime,$addttime) = xtterms($year);

	## mktime(7+9,36,19-64,3,20,2000), 2000-03-20 16:35:15(KST)
	##
	$start = __SOLAR_START__; // start base unix timestamp
	$tyear = __SOLAR_TYEAR__; // tropicalyear to seconds
	$byear = __SOLAR_BYEAR__; // start base year

	$start += ($year - $byear) * $tyear;

	if($length < -12) $length = -12;
	else if($length > 12) $length = 12;

	$smoon = xmoon2valid($smoon);
	$emoon = xmoon2valid($smoon+$length);

	$sidx =  (min($smoon,$emoon) - 1) * 2;
	$eidx = ((max($smoon,$emoon) - 1) * 2) + 1;

	for($i=$sidx; $i<=$eidx; $i++)
	{
		$time = $start + $tterms[$i];
		list(,$atime) = xsunl($time,FALSE);
		$time += $atime + $addstime + $addttime[$i]; // re-fixed
		$terms[x_date('nd',$time)] = &$hterms[$i];
		$times[] = $time; // fixed utime
	}

	## for detail information
	##
	if(func_num_args() > 3)
	{
		$i = $sidx;
		foreach($times AS $time)
		{
			$sun[$i] = xsun($time,FALSE);
			$sun[$i]['_avgdate'] = x_date('D, d M Y H:i:s ',$start+$tterms[$i]-date('Z')).'GMT';
			$sun[$i]['_name'] = &$hterms[$i];
			$i++;
		}
	}

	unset($times);

	return $terms; // array
  }
  //============================ good 
  
  
  function xsunrise_sunset($_y, $_m, $_d, $_location=0, $_zenith=0)
  {
	static $_locations = array
	(
	array(126.95,37.55) /* 서울 */, array(131.87,37.24) /* 독도 */,
	array(129.37,36.04) /* 포항 */, array(126.35,36.52) /* 안면 */,
	);

	static $_zeniths = array(90.8333, 96.0, 102.0, 108.0);

	//$_timezone = 9.0; // KST +9H
	$_timezone = date('Z') / 3600;

	## check arguments
	##
	if(!preg_match('/^[0-3]$/',$_location)) $_location = 0;
	if(!preg_match('/^[0-3]$/',$_zenith)) $_zenith = 0;

	## inital configurations
	##
	$location  = $_locations[$_location];
	$longitude = $location[0];
	$latitude  = deg2rad($location[1]);
	$zenith    = deg2rad($_zeniths[$_zenith]);

	## 1. first calculate the day of the year
	##
	$N = floor(275*$_m/9) - (floor(($_m+9)/12) * (1+floor(($_y-4*floor($_y/4)+2)/3))) + $_d - 30;

	## 2. convert the longitude to hour value and calculate an approximate time
	##
	$lhour = $longitude / 15;
	$t['r'] = sprintf('%.8f',$N+((6-$lhour)/24.0)); // sunrise
	$t['s'] = sprintf('%.8f',$N+((18-$lhour)/24.0)); // sunset

	## 3. calculate the Sun's mean anomaly
	##
	$M['r'] = (0.9856*$t['r']) - 3.289;
	$M['s'] = (0.9856*$t['s']) - 3.289;

	## 4. calculate the Sun's true longitude
	## to be adjusted into the range [0,360) by adding/subtracting 360
	##
	$L['r'] = $M['r'] + (1.916*sin(deg2rad($M['r']))) + (0.020*sin(deg2rad(2*$M['r']))) + 282.634;
	$L['s'] = $M['s'] + (1.916*sin(deg2rad($M['s']))) + (0.020*sin(deg2rad(2*$M['s']))) + 282.634;
	$L['r'] = ($L['r']>=0) ? fmod($L['r'],360) : fmod($L['r'],360)+360.0;
	$L['s'] = ($L['s']>=0) ? fmod($L['s'],360) : fmod($L['s'],360)+360.0;
	$l['r'] = deg2rad($L['r']);
	$l['s'] = deg2rad($L['s']);

	## 5a. calculate the Sun's right ascension
	## to be adjusted into the range [0,360) by adding/subtracting 360
	##
	$RA['r'] = rad2deg(atan(0.91764*tan($l['r'])));
	$RA['s'] = rad2deg(atan(0.91764*tan($l['s'])));
	$RA['r'] = ($RA['r']>=0) ? fmod($RA['r'],360) : fmod($RA['r'],360)+360.0;
	$RA['s'] = ($RA['s']>=0) ? fmod($RA['s'],360) : fmod($RA['s'],360)+360.0;

	## 5b. right ascension value needs to be in the same quadrant as L
	##
	$RA['r'] += (floor($L['r']/90.0)*90.0) - (floor($RA['r']/90.0)*90.0);
	$RA['s'] += (floor($L['s']/90.0)*90.0) - (floor($RA['s']/90.0)*90.0);

	## 5c. right ascension value needs to be converted into hours
	##
	$RA['r'] /= 15;
	$RA['s'] /= 15;

	## 6. calculate the Sun's declination
	##
	$sindec['r'] = 0.39782 * sin($l['r']);
	$sindec['s'] = 0.39782 * sin($l['s']);
	$cosdec['r'] = cos(asin($sindec['r']));
	$cosdec['s'] = cos(asin($sindec['s']));

	## 7a. calculate the Sun's local hour angle
	## (cosH> 1) the sun never rises on this location (on the specified date)
	## (cosH<-1) the sun never sets on this location (on the specified date)
	##
	$cosH['r'] = (cos($zenith) - ($sindec['r']*sin($latitude))) / ($cosdec['r']*cos($latitude));
	$cosH['s'] = (cos($zenith) - ($sindec['s']*sin($latitude))) / ($cosdec['s']*cos($latitude));

	## 7b. finish calculating H and convert into hours
	##
	$H['r'] = 360.0 - rad2deg(acos($cosH['r']));
	$H['s'] = rad2deg(acos($cosH['s']));
	$H['r'] /= 15;
	$H['s'] /= 15;

	## 8. calculate local mean time of rising/setting
	##
	$T['r'] = $H['r'] + $RA['r'] - (0.06571*$t['r']) - 6.622;
	$T['s'] = $H['s'] + $RA['s'] - (0.06571*$t['s']) - 6.622;

	## 9. adjust back to UTC
	## to be adjusted into the range [0,24) by adding/subtracting 24
	##
	$UT['r'] = $T['r'] - $lhour;
	$UT['s'] = $T['s'] - $lhour;
	$UT['r'] = ($UT['r']>=0) ? fmod($UT['r'],24.0) : fmod($UT['r'],24.0) + 24.0;
	$UT['s'] = ($UT['s']>=0) ? fmod($UT['s'],24.0) : fmod($UT['s'],24.0) + 24.0;

	## 10. convert UT value to local time zone of latitude/longitude
	##
	$localT['r'] = fmod($UT['r']+$_timezone,24.0);
	$localT['s'] = fmod($UT['s']+$_timezone,24.0);

	## last convert localT to human time
	##
	$sunrise['H'] = floor($localT['r']);
	$sunrise['m'] = (int)(($localT['r']-$sunrise['H'])*60);
	$sunset['H'] = floor($localT['s']);
	$sunset['m'] = (int)(($localT['s']-$sunset['H'])*60);

	// good idea, but slow
	//return array(date('H:i',$UT['r']*3600),date('H:i',$UT['s']*3600)); // date(UT) to local timezone

	return array
	(
	sprintf('%02d',$sunrise['H']).':'.sprintf('%02d',$sunrise['m']), // sunrise HH:MM
	sprintf('%02d',$sunset['H']).':'.sprintf('%02d',$sunset['m']), // sunset HH:MM
	);
  }

//---------- calendar add x--- 로 변형함.  

  ## private, get date(gregorian) from JD -- same as jdtogregorian()
  ##
  ## JD to `YYYY MM DD HH II SS', JD is UT
  ##
  function x_todate($JD)
  {
	// JD >= 2299160.5 gregorian
	$JD += date('Z')/86400; // JD to local zone(JD)
	$JD -= 64/86400; // is J2000.0 delta 'T', patch san2@2007.07.28

	$Z = $JD + 0.5; // float
	$W = (int)(($Z-1867216.25) / 36524.25);
	$X = (int)($W / 4);
	$A = (int)($Z + 1 + $W - $X);
	$B = (int)($A + 1524);
	$C = (int)(($B-122.1) / 365.25);
	$D = (int)(365.25 * $C); // is not $D = ($B - 122.1)
	$E = (int)(($B-$D) / 30.6001);
	$F = (int)(30.6001 * $E); // is not $F = ($B -$D)

	$_d = $B - $D - $F;
	$_m = $E - 1;
	$_y = $C - 4716;

	$JD -= 0.5; // UT to GMT -12.0H
	$JD = ($JD - (int)$JD) * 24.0;
	$_h = (int)$JD;
	$JD = ($JD - $_h) * 60.0;
	$_i = (int)$JD;
	$JD = ($JD - $_i) * 60.0;
	$_s = round($JD);

	if($_s > 59) { $_s -= 60; $_i++; }
	else if($_s < 0) { $_s += 60; $_i--; }	

	if($_i > 59) { $_i -= 60; $_h++; }
	else if($_i < 0) { $_i += 60; $_h--; }

	if($_h > 23) { $_h -= 24; $_d++; }
	else if($_h < 0) { $_h +=24; $_d--; }

	if($_m > 12) { $_m -= 12; $_y++; }
	else if($_m < 0) { $_m +=12; $_y--; }

	return array($_y,$_m,$_d,$_h,$_i,$_s);
  }

  ## private, get JD(julian day) from unix timestamp -- same as unixtojd()
  ##
  ## D -- get the number of days from base JD
  ## D = JD(Julian Day) - 2451545.0, base JD(J2000.0)
  ##
  ## base position (J2000.0), 2000-01-01 12:00:00 GMT
  ## as   mktime(12,0,0-64,1,1,2000) == 946695536 unix timestamp at KST, -64 is delta 'T'
  ## as gmmktime(12,0,0-64,1,1,2000) == 946727936 unix timestamp at GMT, -64 is delta 'T'
  ##
  ## valid JD: 1902-01-01 00:00:00 ZONE <= JD <= 2037-12-31 23:59:59 ZONE
  ##
  function x_utime2jd($utime)
  {
	$D = $utime - 946727936; // number of time
	$D = sprintf('%.13f',$D/86400); // float, number of days
	$JD= sprintf('%.13f',$D+2451545.0); // float, Julian Day
	//$J = sprintf('%.4f',2000.0+($D/365.25)); // Jxxxx.xxxx format
	//$T = sprintf('%.13f',$D/36525.0); // Julian century

	return $JD; // float
  }

  ## private, get unix timestamp from JD -- same as jdtounix()
  ##
  ## 1970-01-01 12:00:00 GMT = 2440587.6257407409139 JD = J1970.0
  ## valid JD: 1902-01-01 00:00:00 ZONE <= JD <= 2037-12-31 23:59:59 ZONE
  ##
  function x_jd2utime($JD)
  {
	$JD -= 2440587.6257407409139; // convert to base JD(J1970.0), J2000.0 delta 'T', but it's not need

	$seconds = round($JD*86400); // convert to time seconds base on 1970-01-01 00:00:00
	$seconds += 43200; // to GMT -12H(43200 seconds)
	$seconds -= date('Z'); // to local time zone

 	return $seconds;
  }

  ## private, check datetime that it's null or not null
  ##
  function x__check_datetime($argc, &$Y, &$M, &$D, &$H, &$I, &$S)
  {
	if($argc >= 6) return TRUE;

	list($Y,$_M,$_D,$_H,$_I,$_S) = explode(' ',date('Y n j G i s',time()));
	if($argc < 5) $D = $_D;
	if($argc < 4) $M = $_M;
	if($argc < 3) $S = $_S;
	if($argc < 2) $I = $_I;
	if($argc < 1) $H = $_H;
  }

  ## public, make JD -- match to mktime()
  ##
  ## Julian date
  ## J0.0 = BC 4713-01-01 12:00 GMT = BC 4713-01-01 21:00 KST ~ AD 9999
  ##
  function xmkjd($H=21, $I=0, $S=0, $M=1, $D=1, $Y=NULL)
  {
	x__check_datetime(func_num_args(),$Y,$M,$D,$H,$I,$S);

	list($JD) = x_getjd($Y,$M,$D,$H,(int)$I,(int)$S);

	return $JD; // folat, JD is UT base
  }

  ## private, get unix timestamp from date -- same as mktime()
  ##
  ## valid date: 1902-01-01 00:00:00 ZONE <= date <= 2037-12-31 23:59:59 ZONE
  ##
  function x_mktime($H=9, $I=0, $S=0, $M=1, $D=1, $Y=NULL)
  {
	if($Y>1970 && $Y<2038) return mktime($H,$I,$S,$M,$D,$Y);

	x__check_datetime(func_num_args(),$Y,$M,$D,$H,$I,$S);

	$JD = xmkjd($H,$I,$S,$M,$D,$Y);
	$utime = x_jd2utime($JD);

 	return $utime;
  }



  ## public, get leap year
  ##
  ## #define isleap(y) ((((y) % 4) == 0 && ((y) % 100) != 0) || ((y) % 400) == 0)
  ##
  ## +-- 4*Y ! // normal
  ## `-- 4*Y
  ##      |-- 100*Y ! // leap
  ##      `-- 100*Y
  ##           |-- 400*Y ! // normal
  ##           `-- 400*Y   // leap
  ##
  ## but, 4000*Y is not normal year, is leap year
  ## http://user.chollian.net/~kimdbin/re/leap_year.html
  ##
  function xisleap($year)
  {
	if($year%4) return FALSE;
	else if($year%100) return TRUE;
	else if($year%400) return FALSE;

	return TRUE; // else 400*Y
  }

  ## public, get week idx
  ##
  ## 0(sun), 1(mon), 2(tue), 3(wed), 4(thu), 5(fri), 6(sat)
  ##
  function xjddayofweek($JD)
  {
	return floor($JD+1.5)%7; // integer
  }

  function xdayofyear($Y, $M, $D)
  {
	list($JDE) = x_getjd($Y,$M,$D);
	list($JDS) = x_getjd($Y,1,1);

	return (int)($JDE - $JDS);
  }

  ## ISO-8601, start on Monday
  ##
  function xweeknumber_f($Y, $M, $D)
  {
	list($JD) = x_getjd($Y,1,1);

	$widx = xjddayofweek($JD);
	$days = xdayofyear($Y,$M,$D);

	//$midx = ($widx<0) ? 6 : $widx;
	//$days = ($midx<1) ? ($days+$midx) : ($days+$midx-7);
	$midx = ($widx==0) ? 7 : $widx; // to ISO-8601
	$days += ($midx>1) ? ($midx-7-1) : 0;
	$n = ceil($days/7);

	if($n >= 52) // last week
	{
		list($JD) = x_getjd($Y,12,31);
		$lidx = xjddayofweek($JD);
		if($widx>0 && $lidx>0) $n = 1;
	}
	else if($n <= 1) // first week
	{
		list($JD) = x_getjd($Y-1,1,1);
		$widx = xjddayofweek($JD);
		$n = ($widx>1) ? 52 : 53;
	}

	return $n; // integer
  }

  ## ISO-8601, start on Thursday
  ## patch san2@2010.05.20
  ##
  function xweeknumber($Y, $M, $D)
  {
	list($JD) = x_getjd($Y,1,1);

	$widx = xjddayofweek($JD) - 1;
	$days = xdayofyear($Y,$M,$D);

	$midx = ($widx<0) ? 6 : $widx;
	$days = ($midx<4) ? ($days+$midx) : ($days+$midx-7);
	$n = floor($days/7) + 1;

	if($n == 0) // ok, first week or last of preious year
	{
		list($JD) = x_getjd($Y-1,1,1);
		$widx = xjddayofweek($JD);
		$n = ($widx>4) ? 52 : 53;
	}
	else if($n > 52) // last week or first week of next year
	{
		list($JD) = x_getjd($Y,12,31);
		$widx = xjddayofweek($JD);
		if($widx>0 && $widx<4) $n = 1; // Monday ~ Wednesday
	}

	return $n; // integer
  }

  ## public, get swatch internet time, base BMT = GMT + 1
  ## same as date('B')
  ##
  function xitime($H, $I, $S)
  {
	$B = ($H-(date('Z')/3600)+1)*41.666 + $I*0.6944 + $S*0.01157;
	$B = ($B>0) ? $B : $B+1000.0;

	return sprintf('%03d',$B);
  }

  /***
  function xdays_in_month($year, $month, $JDS=0)
  {
	list($JDS) = x_getjd($year,$month,1);
	list($JDE) = x_getjd($year,$month+1,1);

	$term = (int)($JDE - $JDS);

	return $term; // integer
  }
  ***/

  ## public
  ##
  function xdays_in_month($year, $month)
  {
	static $months = array(31,0,31,30,31,30,31,31,30,31,30,31);

	$n = $months[$month-1];
	$n = $n ? $n : (xisleap($year) ? 29 : 28);

	return $n; // integer
  }

  ## public
  ##
  function xmonth_info($year, $month)
  {
	if($year<1902 || $year>2037)
	{
		list($JD) = x_getjd($year,$month,1);
		$term = xdays_in_month($year,$month);
		$week = xjddayofweek($JD); // week idx
		$minfo = array($week,$term);
	} else
	{
		$utime = mktime(23,59,59,$month,1,$year);
		$minfo = explode(' ',date('w t',$utime));
	}

	return $minfo; // array($week,$term)
  }  

  ## utils
  ##
  ## - deg2hms(deg) <-> hms2deg(hms)
  ## - deg2dms(deg) <-> dms2deg(dms)
  ## - deg2h(deg)   <-> h2deg(h)
  ## - hms2dms(hms) <-> dms2hms(dms)
  ## - hms2h(hms)   <-> h2hms(h)
  ## - dms2h(dms)   <-> h2dms(h)

  ## public
  ##
  function xdeg2dms($deg, $singed=FALSE)
  {
	if($singed) $singed = '+';
	if($deg <0) { $singed = '-'; $deg = abs($deg); }

	$d = floor($deg);
	$m = floor(fmod($deg*60,60));
	$s = sprintf('%.4f',fmod($deg*3600,60));

	return array($singed.$d,$m,$s);
  }


  //-------------------lunar lib

  /***
  ## ftp://ssd.jpl.nasa.gov/pub/eph/export/C-versions/hoffman/
  ##
  function x__getjd($Y, $M=0, $D=0, $H=0, $I=0, $S=0)
  {
	$H -= 9; // KST to UT
	if(func_num_args() < 6)
	{ list($Y,$M,$D,$H,$I,$S) = explode(' ',gmdate('Y n j G i s',$Y)); }

	if($M < 3) { $M += 12; $Y--; }

	$D += ($H/24.0) + ($I/1440.0) + ($S/86400.0);
	$A = floor($Y/100.0);
	$B = 2.0 - $A + floor($A/4.0);

	$JD= sprintf('%.13f',floor(365.25*($Y+4716.0))+floor(30.6001*($M+1.0))+$D+$B-1524.5);
	$D = sprintf('%.13f',$JD-2451545.0); // float, number of days
	$J = sprintf('%.4f',2000.0+($D/365.25)); // // Jxxxx.xxxx format
	$T = sprintf('%.13f',$D/36525.0); // // Julian century

	return array($JD,$J,$D,$T);
  }

  ## priate, get D
  ## base 2000-01-00.00 TDT == 1999-12-31 TDT == J2000.0 + 1.5
  ## http://www.stjarnhimlen.se/comp/ppcomp.html
  ##
  function x_getjdd($Y, $M=0, $D=0, $H=0, $I=0, $S=0)
  {
	if(func_num_args() < 6) list($JD) = x_getjd($Y);
	else list($JD) = x__getjd($Y,$M,$D,$H,$I,$S); // is KST

	return sprintf('%.13f',$JD-2451543.5); // another $D, $D + 1.5
  }
  ***/

  ## private, degress to valid
  ##
  function x_deg2valid($deg)
  {
	//if($deg<=360 && $deg>=0) return $deg;
	$deg = ($deg>=0) ? fmod($deg,360) : fmod($deg,360)+360.0;

	return (float)$deg; // float degress
  }

  ## private
  ##
  function x_moon2valid($moon)
  {
	if($moon < 1) $moon = 1;
	else if($moon > 12) $moon = 12;

	return (int)$moon;
  }

  ## private, degress to time(seconds)
  ##
  function x_deg2daytime($deg)
  {
	return sprintf('%.4f',$deg*240); // seconds
  }

  ## private, degress to angle
  ##
  function x_deg2angle($deg, $singed=FALSE)
  {
	if($singed) $singed = '+';
	if($deg <0) { $singed = '-'; $deg = abs($deg); }

	$time = sprintf('%.4f',$deg*3600);
	$degr = (int)$deg.chr(161).chr(198); //sprintf('%d',$deg);
	$time = sprintf('%.4f',$time-($degr*3600)); // fmod
	$mins = sprintf('%02d',$time/60).chr(161).chr(199);
	$secs = sprintf('%.4f',$time-($mins*60)).chr(161).chr(200); // fmod

	return $singed.$degr.$mins.$secs;
  }

  ## private, degress to solar time
  ##
  ## 1 solar year == 365.242190 days == 31556925.216 seconds
  ## 1 degress == 31556925.216 seconds / 360 degress == 87658.1256 seconds
  ##
  function x_deg2solartime($deg)
  {
	return sprintf('%.4f',$deg*87658.1256); // seconds
  }

  ## private, get sun's approximation to the Sun's geocentric apparent ecliptic longitude
  ##

  ## private, get solar 24 terms
  ##
  function x_terms($year=0, $smoon=1, $length=12)
  {
	## mktime(7+9,36,19-64,3,20,2000), 2000-03-20 16:35:15(KST)
	##
	static $start = 953537715; // start base unix timestamp
	static $tyear = 31556940; // tropicalyear to seconds
	static $byear = 2000; // start base year

	static $tterms = array
	(
	-6418939, -5146737, -3871136, -2589569, -1299777,        0,
	 1310827,  2633103,  3966413,  5309605,  6660762,  8017383,
	 9376511, 10735018, 12089855, 13438199, 14777792, 16107008,
	17424841, 18731368, 20027093, 21313452, 22592403, 23866369
	);

	static $ffd = array // patch day, {YYYY}{idx}
	(
	190311 => 1440, 191914 => -480, 192223 => -240, 192912 => 1920,
	193116 => 1920, 193910 => -780, 19547  => 3600, 195422 => 3480,
	195513 => 2880, 195523 => 3420, 19565  => 2880, 195812 => 3240,
	195815 => 3120, 19603  => 3240, 196111 => 3480, 196215 => 2160,
	196519 => 2520, 196520 => 2400, 196810 => 1860, 198218 =>  660,
	19879  =>-3840, 198813 =>-3840, 199122 => -480, 20136  =>  360,
	20230  =>  600, 202311 => -400, 20303  => -420
	);

	$stime = $start + ($year - $byear) * $tyear;

	if($length < -12) $length = -12;
	else if($length > 12) $length = 12;

	$smoon = x_moon2valid($smoon);
	$emoon = x_moon2valid($smoon+$length);

	$sidx =  (min($smoon,$emoon) - 1) * 2;
	$eidx = ((max($smoon,$emoon) - 1) * 2) + 1;

	for($i=$sidx; $i<=$eidx; $i++)
	{
		$utime = $stime + $tterms[$i];
		list(,,$D) = x_getjd($utime);
		list(,$atime) = x_sunl($D); // ($utime-946727936)/86400;
		if( isset($ffd["$year$i"]) ) $utime += $atime + $ffd["$year$i"]; // re-fixed
		$terms[] = x_date('nd',$utime);
	}

	return $terms; // array
  }

  ## private, get a Constellation of zodiac
  ##
  function x_constellation($y, $m, $d)
  {
	static $ffd = array // patch day
	(
	19030622 => -24, 19221222 =>   4, 19540420 => -61, 19550723 => -48,
	19551222 => -57, 19560320 => -48, 19580823 => -52, 19600219 => -55,
	19610221 => -59, 19620823 => -37, 19651023 => -42, 19870525 =>  64,
	19880722 =>  61, 20230621 =>   4, 20300218 =>   7
	);

	$horoscope = array // do not set `static' variable
	(
	array(chr(187).chr(234).chr(190).chr(231),'Aries'),
	array(chr(200).chr(178).chr(188).chr(210),'Taurus'),
	array(chr(189).chr(214).chr(181).chr(213).chr(192).chr(204),'Gemini'),
	array(chr(176).chr(212),'Cancer'),
	array(chr(187).chr(231).chr(192).chr(218),'Leo'),
	array(chr(195).chr(179).chr(179).chr(224),'Virgo'),
	array(chr(195).chr(181).chr(196).chr(170),'Libra'),
	array(chr(192).chr(252).chr(176).chr(165),'Scorpius'),
	array(chr(177).chr(195).chr(188).chr(246),'Sagittarius'),
	array(chr(191).chr(176).chr(188).chr(210),'Capricon'),
	array(chr(185).chr(176).chr(186).chr(180),'Aquarius'),
	array(chr(185).chr(176).chr(176).chr(237).chr(177).chr(226),'Pisces')
	);

	//list(,$nd) = x_terms($y,$m,0);
	//$idx = ($m.$d<$nd) ? $m-2 : $m-1;
	//if($idx < 0) $idx += 12;

	$fk = sprintf('%d%02d%d',$y,$m,$d);
	//list(,,$D) = x_getjd(mktime(23,59+(int)$ffd[$fk],59,$m,$d,$y));
	//list(,,$D) = x_getjd(x_mktime(23,59+(int)$ffd[$fk],59,$m,$d,$y));
	list(,,$D) = x_getjd($y,$m,$d,23,59+(int)$ffd[$fk],59);
	list($L) = x_sunl($D);

	return $horoscope[floor($L/30)];
  }
//-------lunar 2   ----------------------------======================
  function x_time2mtime($time, $singed=FALSE)
  {
	if($singed) $singed = '+';
	if($time<0) { $singed = '-'; $time = abs($time); }

	return $singed.x_date('H i s',$time-date('Z'));
  }

  ## private, get moon's approximation to the Moon's geocentric apparent
  ## ecliptic longitude
  ##
  function x_moonl($T)
  {
	$lambda = 218.32 + (481267.883*$T)
	+ 6.29 * sin(deg2rad(134.9 + 477198.85*$T))
	- 1.27 * sin(deg2rad(259.2 - 413335.38*$T))
	+ 0.66 * sin(deg2rad(235.7 + 890534.23*$T))
	+ 0.21 * sin(deg2rad(269.9 + 954397.7*$T))
	- 0.19 * sin(deg2rad(357.5 + 35999.05*$T))
	- 0.11 * sin(deg2rad(186.6 + 966404.05*$T));

	return array(x_deg2valid($lambda),$lambda);
  }

  ## private, get Moon's ecliptic
  ##
  function x_moone($T)
  {
	$beta = 5.13 * sin(deg2rad(93.3 + 483202.03*$T))
	+ 0.28 * sin(deg2rad(228.2 + 960400.87*$T))
	- 0.28 * sin(deg2rad(318.3 + 6003.18*$T))
	- 0.17 * sin(deg2rad(217.6 - 407332.2*$T));

	return $beta; // float
  }

  ## public, get moon positon
  ##
  ## http://user.chollian.net/~kimdbin/re/moonpos.html
  ##
  function xmoon($utime=0)
  {
	//static $D, $J, $JD, $T, $L, $RA, $e, $d, $lambda;
	//static $y, $b, $l, $m, $n;

	/***
	if($utime<-2142664200 || $utime>2146229999)
	{
		echo "\nerror: invalid input $utime, 1902.02.08 00:00:00 <= utime <= 2038.01.04 23:59:59\n";
		return -1;
	}
	***/

	if($utime == '') $utime = time();

	list($JD,$J,$D,$T) = x_getjd($utime);
	list($L,$lambda) = x_moonl($T);
	$e = x_moone($T); // is beta, Moon's ecliptic

	$y = deg2rad($lambda);
	$b = deg2rad($e);

	$l = cos($b) * cos($y);
	$m = 0.9175 * cos($b) * sin($y) - (0.3978 * sin($b));
	$n = 0.3978 * cos($b) * sin($y) + (0.9175 * sin($b));

	$RA = rad2deg(atan2($m,$l));
	$RA = x_deg2valid($RA); // Moon's right ascension
	$d = rad2deg(asin($n)); // Moon's declination

	$mtime = x_deg2daytime($L); // seconds
	$dtime = x_deg2daytime($RA); // seconds

	return array
	(
	'JD'=> sprintf('%.10f',$JD),	/*** Julian Date ***/
	'J' => 'J'.$J,		/*** Julian Date Jxxxx.xxxx format ***/
	'L' => $L,		/*** Moon's geocentric apparent ecliptic longitude ***/
	'e' => $e,		/*** Moon's ecliptic ***/
	'RA'=> $RA,		/*** Moon's right ascension  ***/
	'd' => $d,		/*** Moon's declination ***/
	'mtime' => $mtime,	/*** seconds ***/
	'dtime' => $dtime,	/*** seconds ***/
	'utime' => $utime,
	'date'  => x_date('D, d M Y H:i:s T',$utime),	/*** KST date ***/
	'gmdate'=> x_date('D, d M Y H:i:s ',$utime-date('Z')).'GMT', /*** GMT date ***/
	'_L'    => x_deg2angle($L),		/*** angle ***/
	'_e'    => x_deg2angle($e,1),		/*** angle ***/
	'_RA'   => x_deg2angle($RA),		/*** angle ***/
	'_d'    => x_deg2angle($d,1),
	'_mtime'=> x_time2mtime($mtime),
	'_dtime'=> x_time2mtime($dtime)
	);
  }

  ## private, get moon's degress - sun's degress
  ##
  function x_gettd($utime)
  {
	list(,,$D,$T) = x_getjd($utime);
	list($s) = x_sunl($D);
	list($l) = x_moonl($T);

	return x_deg2valid($l-$s); // float
  }

  ## private, get unix timestamp of conjunction, new moon day(xxxx-xx-01)
  ##
  ## - http://www.kao.re.kr/html/study/faq/index.html?f=3&idx=79
  ## - http://www.kao.re.kr/html/study/faq/index.html?f=3&idx=43
  ##
  ## 1 solar year == 365.242190 days == 31556925.216 seconds
  ## 1 degress == 31556925.216 seconds / 360 degress == 87658.1256 seconds
  ##
  ## 1 (new moon) moon == 29.53059 dayes = 2551442.976 seconds
  ## 1 degress == 2551442.976 seconds / 360 degress = 7087.3416 seconds
  ##
  ## sun : moon == 1 : 12.3682659235728 == 0.0808520779048 : 1
  ##
  ## move to 1 degress = 7710.7736596978271 seconds (sun and moon => same line)
  ##     7087.3416 +
  ##      573.0262951811299 +
  ##       46.3303666594836 +
  ##        3.7459064145105 +
  ##        0.3028643172501 +
  ##        0.0244872093729 +
  ##        0.0019798417599 +
  ##        0.0001600743202
  ##
  ## move to 86400 seconds :
  ##     avg(13.2433041906) std(1.16287866011) max(15.2504690629) min(11.8423079447)
  ## move to 1 degress :
  ##     mix(7295.8751286879124083279675026639 seconds)
  ##     avg(6524.0516080062621468182286547561 seconds)
  ##     max(5665.3995128704809432711052144198 seconds)
  ##
  function x_newmoon($_y, $_m=0, $_d=0, &$ctime=0)
  {
	static $unit = 5665; // see above comments
	static $ffx = array
	(
	19310517=>2640, 19321030=>-840, 19341008=> 840, 19530612=>-600,
	19550222=>4020, 19580218=>2700, 19860311=>-540, 19950727=>1140,
	20120619=> 780, 20150815=>-540, /*20170226=> 480,*/ 20350109=> 540,
	);

	$utime = $ctime = (func_num_args()<2) ? $_y : x_mktime(23,59,59,$_m,$_d,$_y);
	$td = x_gettd($utime);

	//echo $td."\n";
	if($td > 359.5)
	{
		//echo $td."\n";
		$utime += 86400;
		$td = x_gettd($utime);
	}

	while($td > 0.000177) // 1/$unit
	{
		//echo $td."\n";
		$utime -= $td * $unit;
		$otd = $td;
		$td = x_gettd($utime);
		if($td > $otd) break;
	}
	if( isset($ffx[x_date('Ymd',$utime)]) ) $utime += (int)$ffx[x_date('Ymd',$utime)];
	if($ctime < $utime) $utime -= 2592000; // 86400 * 30;

	return (int)$utime;
  }

  ## private, get tdm
  ##
  function x_gettm($utime)
  {
	list(,,$D,$T) = x_getjd($utime);
	list($s) = x_sunl($D);
	list($l) = x_moonl($T);

	$tm = x_deg2valid($s-180) - $l; // float

	//echo "$s $l => $tm\n"; // debug
	if($tm > 180.0) $tm -= 360.0; // patch 2005.02.25

	return $tm;
  }

  function x_sunl($D)
  {
	$g = sprintf('%.10f',357.529 + (0.98560028 * $D)); // default 357.529, fixed 357.550
	$q = sprintf('%.10f',280.459 + (0.98564736 * $D));

	## fixed
	##
	$g = x_deg2valid($g); // to valid degress
	$q = x_deg2valid($q); // to valid degress

	## convert
	##
	$deg2rad = array();
	$deg2rad['g'] = deg2rad($g); // radian
	$deg2rad['2g'] = deg2rad($g*2); // radian

	$sing = sin($deg2rad['g']); // degress
	$sin2g = sin($deg2rad['2g']); // degress

	## L is an approximation to the Sun's geocentric apparent ecliptic longitude
	##
	$L = sprintf('%.10f',$q + (1.915 * $sing) + (0.020 * $sin2g));
	$L = x_deg2valid($L); // degress
	$atime = x_deg2solartime(round($L)-$L); // float

	return array($L,$atime); // array, float degress, float seconds
  }

  ## private, get unix timestamp of full moon day(xxxx-xx-15)
  ##
  function x_fullmoon($_y, $_m=0, $_d=0)
  {
	static $unit = 5665; // see above comments
	static $ffx = array
	(
	19031006=>2000, 19131213=>  120, 19280801=>2100, 19360506=> 400,
	19380712=> 300, 19450625=>  600, 19500828=>-700, 19550308=>2700,
	19560524=>1900, 19581027=> 3000, 19810617=> 500, 19990501=>-900,
	20211021=>-300, 20261125=>-1100, 20280210=> 700, 20320425=> 600,
	);

	$utime = (func_num_args()<2) ? $_y : x_mktime(23,59,59,$_m,$_d,$_y);

	$td = x_gettm($utime);
	$ta = abs($td);

	while($ta > 0.000177) // 1/$unit
	{
		//echo $td.' '.date('Y-m-d H:i:s',$utime)."\n"; // debug
		$ota = $ta;
		$ptime = $utime + ($td * $unit); // pre-test time
		$td = x_gettm($ptime);
		$ta = abs($td);

		if($ta > $ota) break;
		$utime = $ptime;
	}
	if( isset($ffx[x_date('Ymd',$utime)]) ) $utime += (int)$ffx[x_date('Ymd',$utime)];
	return (int)$utime;
  }

  ## private, get solar eclipse idx name
  ##
  ## Solar Eclipses: T(Total), A(Annular), H(Hybrid(Annular/Total)), P(Partial)
  ## A 104 0.010582273616323 1.06751983653440(1.067743)
  ## T  91 0.014674627401046 1.04166992331860
  ## H   6 0.210833791736160 0.96121766199154(0.964180)
  ## P 106 0.829402137331320 1.59530999819400
  ##
  function x_solareclipse($utime)
  {
	list(,,,$T) = x_getjd($utime);
	$e = x_moone($T); // is beta, Moon's ecliptic
	$e = abs($e);

	if($e < 0.014674) $r = 'A';
	else if($e < 0.210833) $r = 'AT';
	else if($e < 0.829402) $r = 'ATH';
	else if($e < 0.964180) $r = 'PATH';
	else if($e < 1.041670) $r = 'PAT';
	else if($e < 1.067743) $r = 'PA';
	else if($e < 1.595310) $r = 'P';
	else $r = 'N';

	return $r;
  }

  ## public, get solar eclipse exists at new moon
  ##
  function xsolareclipse($y, $m, $d)
  {
	list($ymd0,$y,$m,$d) = explode(' ',x_date('Ymd Y n j',x_mktime(12,0,0,$m,$d,$y))); // refixed

	$utime = x_newmoon($y,$m,$d);
	$ymd1 = x_date('Ymd',$utime);

	if($ymd0 == $ymd1) $r = x_solareclipse($utime);
	else $r = 'N';

	return $r;
  }

  ## private, get lunar eclipse idx name
  ##
  ## Lunar Eclipses: t(Total), p(Umbral(Partial)), n(Penumbral)
  ## t 114 0.010630181434784 0.52538271749109(0.527908)
  ## p  85 0.294681791935650 1.14183526374750
  ## n 111 0.832900661071600 1.57436507046800(1.578244)
  ##
  function x_lunareclipse($utime)
  {
	list(,,,$T) = x_getjd($utime);
	$e = x_moone($T); // is beta, Moon's ecliptic
	$e = abs($e);

	if($e < 0.294681) $r = 't';
	else if($e < 0.527908) $r = 'tp';
	else if($e < 0.832900) $r = 'p';
	else if($e < 1.141836) $r = 'np';
	else if($e < 1.578244) $r = 'n';
	else $r = 'N';

	return $r;
  }

  ## public, get lunar eclipse exists at full moon
  ##
  function xlunareclipse($y, $m, $d)
  {
	//list($ymd0,$y,$m,$d) = explode(' ',x_date('Ymd Y n j',x_mktime(12,0,0,$m,$d,$y))); // refixed
	list($ymd0,$y,$m,$d) = explode(' ',xdate('Ymd Y n j',xmkjd(12,0,0,$m,$d,$y))); // refixed

	$utime = x_fullmoon($y,$m,$d);
	$ymd1 = x_date('Ymd',$utime);

	if($ymd0 == $ymd1) $r = x_lunareclipse($utime);
	else $r = 'N';

	return $r;
  }

  ## public, from solar date to lunar date
  ##
  function xtolunar($_y, $_m, $_d, $_timezone=NULL)
  {
	static $notminus = array(19651024=>1,2033923=>1,20331023=>1,20331122=>1); // do not minus,  // patch san2@2011.04.11
	static $notleap = array(1965925=>1,1985121=>1,1985220=>1,2033825=>1,2034219=>1); // patch san2@2011.04.11
	static $dominus = array(1985121=>1,1985220=>1,2034219=>1); // patch san2@2011.04.11

	$_y = (int)$_y; // refixed
	$_m = (int)$_m; // refixed
	$_d = (int)$_d; // refixed

//	if($_timezone === NULL) $_timezone = __TIMEZONE__; // add san2@2013.08.22

	/***
	if($_y<1902 || $_y>2038)
	{
		echo "\nerror: tolunar() invalid input solar arguments, 1902-01-10 <= solar date <= 2038-01-18\n";
		return -1;
	}
	***/

	## check lunar or solar eclipse of current date
	##
	$eclipse['c'] = xlunareclipse($_y,$_m,$_d);
	if($eclipse['c'] == 'N') $eclipse['c'] = xsolareclipse($_y,$_m,$_d);

	## get current new moon
	##
	$utime = x_newmoon($_y,$_m,$_d,$ctime);
	list($y,$m,$j,$z,$t,$nd,$ymd0,$his0) = explode(' ',x_date('Y n j z t nd Y-m-d H:i:s',$utime));
	$eclipse['u'] = x_solareclipse($utime);

	## get lunar days
	##
	$tmp = $ctime - $utime;
	$age = sprintf('%.2f',($tmp-43200+($_timezone*3600))/86400); // age of Moon at UTC 12:00:00
	$d = ceil($tmp/86400);
	$leap = 0; // leap month

	## get current full moon
	##
	$ftime = x_fullmoon($utime+1382400); // 1382400 = 86400 * 16, patch san2@2007.09.27
	list($ymd1,$his1) = explode(' ',x_date('Y-m-d H:i:s Y n j',$ftime));
	$eclipse['f'] = x_lunareclipse($ftime);

	## get next new moon
	##
	$ntime = x_newmoon($_y,$_m,$_d+31-$d); // 86400*31
	list($y2,$m2,$z2,$nd2,$ymd2,$his2) = explode(' ',x_date('Y n z nd Y-m-d H:i:s',$ntime));
	$eclipse['n'] = x_solareclipse($ntime);

	## get solar term(tt) and day term(dt)
	##
	if($y < $y2) // defference year
	{
		$tt = array_merge(x_terms($y,$m,0),x_terms($y2,$m2,0));
		$dt = $t - $j + $z2 + 1; // day term
	} else // same year
	{
		$tt = x_terms($y,$m,$m2-$m);
		$dt = $z2 - $z;
	}
	$k = sizeof($tt);//k:4
	//echo "<br>k:$k, tt0:$tt[0], tt1:$tt[1],tt2:$tt[2],tt3:$tt[3], nd2:$nd2";//k:4, tt0:105, tt1:120,tt2:204,tt3:219, nd2:217
	//echo "<br>k:$k, nd:$nd, tt1:$tt[1], nd2:$nd2"; //, $tt[5] "; // debug
	//nd:119, tt1:120, nd2:217
	//nd:217, tt1:219, nd2:319
	//if( isset($tt[1]) && $nd<=$tt[1] && isset($notminus[$y.$nd]) && !$notminus[$y.$nd]) $m--;
	//if($k==4) $m--; // 2026-02-19 line add
	if( isset($tt[1]) && $nd <= $tt[1]) {
		if( isset($notminus[$y.$nd]) &&  !$notminus[$y.$nd]) $m--;
		else if($k==4) $m--; // 2026-02-19 line add
	}
	else {  // patch san2@2011.04.11
		$k = sizeof($tt) - 1; // 1 or 3 or 5 but this case 3 or 5
		if( isset($tt[$k]) && isset($notleap[$y.$nd]) && $nd2-1<$tt[$k] && $k==3 && !$notleap[$y.$nd])
		{ $leap = 1; $m--; }
		else if( isset($dominus[$y.$nd]) && $dominus[$y.$nd]) $m--;
		# else do not minus
	} 

	if($m < 1) { $m += 12; $y--; } //date('Y',$utime-3456000)

	return array
	(
	sprintf('%d-%02d-%02d',$y,$m,$d),		// YYYY-MM-DD
	array($y,$m,$d,$leap,$dt,$age,$eclipse['c']),	// YYYY,M,D,leap,term,age,eclipse
	array($ymd0,$his0,$utime,$eclipse['u']),	// current new moon
	array($ymd1,$his1,$ftime,$eclipse['f']),	// current full moon
	array($ymd2,$his2,$ntime,$eclipse['n']),	// next new moon
	);
  }

  ## private, get new moon informations, use at tosolar()
  ##
  function x_newmooninfo($_y, $_o, $_m, $_leap, $_stop=0, $_d=15)
  {
	//static $_d = 15; // good idea, patch san2@2010.05.17 disabled

	if($_m > 12) { $_m -= 12; $_y++; }
	else if($_m < 1) { $_m += 12; $_y--; }

	$_l = (int)(boolean)$_leap;
	$_p = $_stop ? $_m : $_m + 1 + $_l; // pre test month

	if($_p > 12) { $_p -= 12; $_y++; }
	list(,list($y,$m,,$leap,$t),$newmoon,,$nextmoon) = xtolunar($_y,$_p,$_d);

	if($leap==$_l && $m==$_o) $newmoon[] = $t; // add term
	else if(!$_stop)
	{
		$output = $y.sprintf('%02d',$m);
		$input = $_y.sprintf('%02d',$_y,$_m);
		if($output < $input) { $ymd = $nextmoon[0]; $j = 1; } // patch san2@2010.05.17
		else { $ymd = $newmoon[0]; $j = -2; }

		list($_y,$_m,$_d) = explode('-',$ymd);
		$_d += $j; // change static $_d
		$newmoon = x_newmooninfo($_y,$_o,$_m,$_leap,1,$_d);
	}

	return $newmoon; // array
  }

  ## public, from lunar date to solar date
  ##
  function xtosolar($_y, $_m, $_d, $_leap=0)
  {
	$_y = (int)$_y; // refixed
	$_m = (int)$_m; // refixed
	$_d = (int)$_d; // refixed

	/***
	if($_y<1901 || $_y>2037)
	{
		echo "\nerror: tosolar() invalid input lunar arguments, 1901-12-01 <= lunar date <= 2037-12-14\n";
		return -1;
	}
	***/

	if(!$newmoon = x_newmooninfo($_y,$_m,$_m,$_leap)) return; // false

	list(,,$utime,,$term) = $newmoon;

	## check input day
	##
	if($_d > 29)
	{
		if($term)
		{
			if($_d > $term) $ck = 0; // is false
			else $ck = 1; // ture valid input day
		} else
		{
			//$_g = getdate($utime);
			//$_t = xtolunar($_g['year'],$_g['mon'],$_g['mday']);
			list($_gy,$_gn,$_gd) = explode(' ',x_date('Y n d',$utime));
			$_t = xtolunar($_gy,$_gn,$_gd);
			if($_d > $_t[1][2]) $ck = 0; // is false
			else $ck = 1; // true
		}
	} else $ck = 1;

	$utime += 86400 * ($_d-1);
	list($ymd,$y,$n,$j,$w) = explode(' ',x_date('Y-m-d Y n j w',$utime));

	return array
	(
	$ymd,		// string YYYY-MM-DD
	$ck,		// check input day is valid ?
	$y,$n,$j,	// YYYY,M,D
	$w,		// weekday idx,0(Sunday) through 6(Saturday)
	$newmoon,	// new moon infomation
	);
  }

  ## public, get a Constellation of zodiac
  ##
  function xxzodiac($y, $m, $d, $lunar=0, $leap=0)
  {
	if($lunar) list(,,$y,$m,$d) = xtosolar($y,$m,$d,$leap);

	return x_constellation($y,$m,$d);
  }

  ## public, get easter day
  ##
  function xeaster($y, $debug=array())
  {
	$p = x_terms($y,3,0);
	$m = substr($p[1],0,1);
	$d = substr($p[1],-2);

	list(,,,$f,$n) = xtolunar($y,$m,$d); // lunar
	$full = str_replace('-','',$f[0]);
	$curr = sprintf('%d%02d%02d',$y,$m,$d);

	if($curr >= $full)
	{
		list($ty,$tm,$td) = explode('-',$n[0]);
		list(,,,$f) = xtolunar($ty,(int)$tm,$td); // lunar
	}

	list($ty,$tm,$td) = explode('-',$f[0]);
	$jd = xmkjd(21,0,0,(int)$tm,$td,$ty);
	$w = 7 - xdate('w',$jd);
	$r = xdate('m/d',$jd+$w);

	if(func_num_args() > 1)
	{
		list(,$fm,$fd) = explode('-',$f[0]);
		$debug[0] = "$m/$d";
		$debug[1] = "$fm/$fd";
	}

	return $r;
  }
  function xzodiac($y, $m, $d)
  {
	static $ffd = array // patch day
	(
	19030622 => -24, 19221222 =>   4, 19540420 => -61, 19550723 => -48,
	19551222 => -57, 19560320 => -48, 19580823 => -52, 19600219 => -55,
	19610221 => -59, 19620823 => -37, 19651023 => -42, 19870525 =>  64,
	19880722 =>  61, 20230621 =>   4, 20300218 =>   7
	);

	$horoscope = array
	(
	array(chr(187).chr(234).chr(190).chr(231),'Aries'),
	array(chr(200).chr(178).chr(188).chr(210),'Taurus'),
	array(chr(189).chr(214).chr(181).chr(213).chr(192).chr(204),'Gemini'),
	array(chr(176).chr(212),'Cancer'),
	array(chr(187).chr(231).chr(192).chr(218),'Leo'),
	array(chr(195).chr(179).chr(179).chr(224),'Virgo'),
	array(chr(195).chr(181).chr(196).chr(170),'Libra'),
	array(chr(192).chr(252).chr(176).chr(165),'Scorpius'),
	array(chr(177).chr(195).chr(188).chr(246),'Sagittarius'),
	array(chr(191).chr(176).chr(188).chr(210),'Capricon'),
	array(chr(185).chr(176).chr(186).chr(180),'Aquarius'),
	array(chr(185).chr(176).chr(176).chr(237).chr(177).chr(226),'Pisces')
	);

	//list(,$nd) = x_terms($y,$m,0);
	//$idx = ($m.$d<$nd) ? $m-2 : $m-1;
	//if($idx < 0) $idx += 12;

	$fk = sprintf('%d%02d%d',$y,$m,$d);
	list($L) = xsunl(x_mktime(23,59+(int)$ffd[$fk],59,$m,$d,$y));

	return $horoscope[floor($L/30)];
  }
  function _get_basejd_of_sambok($_y, $_m, $_d)
  {
	static $basejd = 2451546; // 2451546.6257407409139 2000.01.03 12:00:00, base of kanji, idx 0

	list($bjd) = x_getjd($_y,$_m,$_d,12,0,0);
	$addterm = (floor($bjd)-$basejd) % 10;

	if($addterm > 0) $addterm = 10 - $addterm;
	else if($addterm < 0) $addterm = abs($addterm);

	return $bjd + $addterm; // JD
  }

  ## add san2@2010.07.29
  ##
  function sambok($_y = NULL)
  {
	if(!func_num_args()) $_y = date('Y');

	$terms = xterms($_y,6,2); // solar 24's terms of Jun ~ Oct
	$terms = array_keys($terms);
	$h[0] = substr($terms[1],0,1);
	$h[1] = substr($terms[1],-2);
	$l[0] = substr($terms[4],0,1);
	$l[1] = substr($terms[4],-2);

	## JD
	##
	$chobok = x_get_basejd_of_sambok($_y,$h[0],$h[1]) + 20;
	$malbok = x_get_basejd_of_sambok($_y,$l[0],$l[1]);
	$jungbok = $chobok + 10;

	## JD to date
	##
	$c = x_todate($chobok);
	$j = x_todate($jungbok);
	$m = x_todate($malbok);

	$c = $c[1].sprintf('%02d',$c[2]);
	$j = $j[1].sprintf('%02d',$j[2]);
	$m = $m[1].sprintf('%02d',$m[2]);

	## add korean name
	##
	$kname['c'] = chr(195).chr(202).chr(186).chr(185);
	$kname['j'] = chr(193).chr(223).chr(186).chr(185);
	$kname['m'] = chr(184).chr(187).chr(186).chr(185);

	return array($c => $kname['c'],$j => $kname['j'],$m => $kname['m']);
  }



  function x_getjd($Y, $M=1, $D=1, $H=21, $I=0, $S=0, $tojulian=FALSE)
  {
	$H -= date('Z')/3600; // local zone to GMT

	if(func_num_args() < 3) // Y is unix_timestamp
	{ list($Y,$M,$D,$H,$I,$S) = explode(' ',x_date('Y n j G i s',$Y-date('Z'))); }

	if($M < 3) { $M += 12; $Y--; }

	$S += 64; // is J2000.0 delta 'T', patch san2@2007.07.28
	$D += ($H/24.0) + ($I/1440.0) + ($S/86400.0);
	$A = floor($Y/100.0);
	$B = $tojulian ? 0 : (2.0 - $A + floor($A/4.0));  // juliantojd() $B = 0
	
	$JD= sprintf('%.13f',floor(365.25*($Y+4716.0))+floor(30.6001*($M+1.0))+$D+$B-1524.5);
	$D = sprintf('%.13f',$JD-2451545.0); // float, number of days
	$J = sprintf('%.4f',2000.0+($D/365.25)); // // Jxxxx.xxxx format
	$T = sprintf('%.13f',$D/36525.0); // // Julian century

	return array($JD,$J,$D,$T);
  }
/*
  function x_getjd($utime)
  {
	$D = $utime - 946727936; // number of time
	$D = sprintf('%.13f',$D/86400); // float, number of days
	$JD= sprintf('%.13f',$D+2451545.0); // float, Julian Day
	$J = sprintf('%.4f',2000.0+($D/365.25)); // Jxxxx.xxxx format
	$T = sprintf('%.13f',$D/36525.0); // Julian century

	return array($JD,$J,$D,$T);
  }
*/
?>