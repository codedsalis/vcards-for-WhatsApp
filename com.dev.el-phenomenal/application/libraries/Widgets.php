<?php
    /**
     * Widgets by Talitu Kadiri
     */
defined('BASEPATH') OR exit('No direct script Access');

class Widgets {

public function cleanInput($str)
{
if(function_exists('iconv')) {
$str = iconv("UTF-8", "UTF-8", $str);
$str = iconv("UTF-8", "UTF-8", $str);
}

//Filter the invisible characters
$str = preg_replace('/[^\P{C}\n]+/u', '', $str);

return trim($str);
}

//------------------------------------------------------------------------------------

public function cleanOutput($str)
{
$str = htmlentities(trim($str), ENT_QUOTES, 'UTF-8');
$str = $this->clean_input($str);
$str = nl2br($str);

return $str;
}

//------------------------------------------------------------------------------------

public function breadcrumbs($labels=array())
    {   
        $out = '<ol class="breadcrumb">'.
                    '<li><a href="' . site_url() . '"><span class="glyphicon glyphicon-home"></span> Home</a></li>';
        foreach ($labels as $label)
        {
            if(isset($label['url']))
                $out .= '<li><a href="' . site_url((substr($label['url'],0,1) == '/' ? '' : '') . $label['url']) . '">' . $label['label'] . '</a></li>';
            else
                $out .= '<li class="active">' . $label['label'] . '</li>';
        }
        $out .= '</ol>';
        return $out;
    }

//---------------------------------------------------------------
/*
Timeago function that prints in real time ago
*/
public function ago($i){
$m = time()-$i; 
$o='Just now';
$t = array(
'day' => 86400, 'hour' => 3600, 'minute' => 60, 'second' => 1
);
foreach($t as $u => $s){
if($s <= $m) {
$v = floor($m/$s); 
$o = "$v $u".($v==1?'':'s').' ago';
break;
}
}
return $o;
}

//---------------------------------------------------------------

/*
parseDate Function
Formats date in readable syntax
*/
public function parseDate($time){
if($time >= strtotime("today")) {
$d = date("h:ia", $time);
return self::ago($time);
}
elseif($time >= strtotime("yesterday")) {
$d = date("h:ia", $time);
return "Yesterday, at $d";
}
elseif($time > strtotime("yesterday") || $time <= strtotime("+3 days") && date("Y", $time) == date("Y", time()))
{
return date("d M, \\a\\t\ h:ia", $time);
}
elseif(date("Y", $time) !== date("Y", time())) {
return date("d M, Y \\a\\t\ h:ia", $time);
}
}

//------------------------------------------------------------------------

//BBCode Formatting function
public function bbcode($var) {
$search = array('#\[b](.+?)\[/b]#is', '#\[i](.+?)\[/i]#is', '#\[u](.+?)\[/u]#is', '#\[s](.+?)\[/s]#is', '#\[small](.+?)\[/small]#is', '#\[big](.+?)\[/big]#is', '#\[img](.+?)\[/img]#is', '!\[color=(#[0-9a-f]{3}|#[0-9a-f]{6}|[a-z\-]+)](.+?)\[/color]!is', '!\[url=(.*?)\](.*?)\[/url\]!is', '!\[bg=(#[0-9a-f]{3}|#[0-9a-f]{6}|[a-z\-]+)](.+?)\[/bg]!is', '#\[(quote|c)](.+?)\[/(quote|c)]#is', '#\[br]#is');


$replace = array('<span style="font-weight: bold;">$1</span>', '<span style="font-style:italic;">$1</span>', '<span style="text-decoration:underline;">$1</span>', '<span style="text-decoration:line-through;">$1</span>', '<span style="font-size:x-small;">$1</span>', '<span style="font-size:large;">$1</span>', '<img src="$1"/>', '<span style="color:$1;">$2</span>', '<a href="$1">$2</a>', '<span style="background-color:$1;">$2</span>', ' <div class="alert alert-success" style="border-left: 4px solid #009900; border-radius: 0px;">$2</div>', '<br/>');

return preg_replace($search, $replace, $var);
}

//------------------------------------------------------------------------

//Strip the formatted BBCodes

public function nobbcode($var = '')
    {
        $var = preg_replace('#\[color=(.+?)\](.+?)\[/color]#si', '$2', $var);
$var = preg_replace('!\[bg=(#[0-9a-f]{3}|#[0-9a-f]{6}|[a-z\-]+)](.+?)\[/bg]!is', '$2', $var);

$replace = array(
'[small]' => '',
'[/small]' => '',
'[big]' => '',
'[/big]' => '',
'[br]' => '',
'[h1]' => '',
'[/h1]' => '',
'[url]' => '',
'[/url]' => '',
'[img]' => '',
'[/img]' => '',
'[b]' => '',
'[/b]' => '',
'[i]' => '',
'[/i]' => '',
'[u]' => '',
'[/u]' => '',
'[s]' => '',
'[/s]' => '',
'[quote]' => '',
'[/quote]' => '',
'[c]' => '',
'[/c]' => '',
);
return strtr($var, $replace);
}

//------------------------------------------------------------------------

public function pagination($rows, $limit, $current_url, $page) {
	$total = ceil($rows/$limit);
	
echo'<ul class="pagination">';
if($page > 1) {
			echo'<li><a href="' . $current_url . '&page=' . ($page - 1) . '">&laquo;Prev</a></li>';
		}
if($total > 1) {
	for($i=1; $i<=$total; $i++) {
						echo(($page == $i) ? '<li class="active"><a href="#">' . $i . '</a></li>' : '<li><a href="' . $current_url . '&page=' . $i . '">' . $i . '</a></li>');
						}
		}
if(($page !== $total) && ($page < $total)) {
			echo'<li><a href="' . $current_url . '&page=' . ($page + 1) . '">Next&raquo;</a></li>';
}
echo'</ul>';
}


//------------------------------------------------------------------------


public function imgUploaderOld($dir) {
$fileName = $_FILES['file']['tmp_name'];
$fileTmp = $_FILES['file']['tmp_name'];
$fileSize = $_FILES['file']['size'];
$fileError = $_FILES['file']['error'];

if(exif_imagetype($fileName) == IMAGETYPE_JPEG) {
$fileExt = 'jpg';
}
elseif(exif_imagetype($fileName) == IMAGETYPE_GIF) {
$fileExt = 'gif';
}
elseif(exif_imagetype($fileName) == IMAGETYPE_PNG) {
$fileExt = 'png';
}
else {
$fileExt = 'unsupported';
}
$fileName = time() . '_' . rand() . '' . rand() . '_n.' . $fileExt;

//Error handling
if($fileExt == 'unsupported') {
$error = 'Unsupported image format, please upload a valid image';
}
elseif(!$fileTmp) {
$error = 'Please browse for a file before clicking the upload buton';
}
elseif($fileSize > 1024) {
$error = 'The selected photo is too large, choose a different photo';
unlink($fileTmp);
exit();
}
elseif($fileError == 1) {
$error = 'An unknown error occured while processing the photo, please try again or try uploading a new photo';
}
if(!$error) {
$moveFile = move_uploaded_file($fileTmp, $dir . $fileName);
if($moveFile){
return $fileName;
}
}
else {
echo'An unknown error occured!';
}
}


//------------------------------------------------------------------------

public function myAlert($title,$message,$actionUrl=NULL,$actionTitle=NULL) {
	return'<div id="promptme" style="position:absolute;left:10px;right:10px;background:#fff;color:#000;border:1px solid #ccc;box-shadow:0 0 10px #000;display:none;z-index:999;" class="alert alert-default">
<strong>' . $title . '</strong> <hr style="margin:4px;"><br/>
' . $message . '
<a name="prompt"></a><br/><br/>
<nav class="pull-right"><a href="#" class="btn btn-default" data-dismiss="alert">Cancel</a>' . (($actionUrl == NULL) ? '' : '&#160;&#160;&#160;&#160;<a href="' . site_url($actionUrl) . '" class="btn btn-success">' . $actionTitle . '</a>') . '</nav></div>';
}



//------------------------------------------------------------------------


        public function formatSize($bytes)
        {
            if ($bytes >= 1073741824)
            {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            }
            elseif ($bytes >= 1048576)
            {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            }
            elseif ($bytes >= 1024)
            {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            }
            elseif ($bytes > 1)
            {
                $bytes = $bytes . ' bytes';
            }
            elseif ($bytes == 1)
            {
                $bytes = $bytes . ' byte';
            }
            else
            {
                $bytes = '0 bytes';
            }
            
            return $bytes;
    }
        


//------------------------------------------------------------------------


  /**
     * Generate a random string, using a cryptographically secure 
     * pseudorandom number generator (random_int)
     * 
     * For PHP 7, random_int is a PHP core function
     * For PHP 5.x, depends on https://github.com/paragonie/random_compat
     * 
     * @param int $length      How many characters do we want?
     * @param string $keyspace A string of all possible characters to select from
     * @return string
     */
    function randomize($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }



//.................................................................................................
/*
Converts naira to United States dollar at the rate of 350/dollar
*/
public function toUsd($naira) {
	$rate = 360;
	$naira = (double)$naira;
	
			$compute = $naira/$rate;
			return number_format($compute, 2);
}




//.................................................................................................
/*
Converts naira to United States dollar and United states dollar to Naira at the rate of 350/dollar
@string $currency
@boolean $symbol
@double $amount
@string $amountCurrency

This method is an alias of the toUsd method
*/
public function toCurrency($currency, $amount, $amountCurrency, $symbol = NULL) {
	$rate = 360;
	$amount = (double)$amount;
	
	//If the currency is USD(default even if there is no value supplied)
	if(!$currency || $currency == 'USD') {
		//If we want the amount converted to USD
		if($amountCurrency == 'USD') {
			//Convert to USD using the standard rate value
			$compute = $amount;
		}
		else {
			//Otherwise, leave as is
			$compute = $amount/$rate;
		}
		
		//If the symbol of the USD is requested for, send it; Otherwise, leave as is without a currency symbol
		return ((!$symbol || $symbol == NULL) ? number_format($compute, 2) : '$' . number_format($compute, 2));
	}
	elseif($currency === 'NGN') {
		//But if the currency is Naira
		if($amountCurrency === 'NGN') {
			//Convert to NGN using the standard rate value
			$compute = $amount;
		}
		else {
			//Otherwise, leave as is
			$compute = $amount*$rate;
		}
		
		//If the symbol of the NGN is requested for, send it; Otherwise, leave as is without a currency symbol
		return ((!$symbol || $symbol == NULL) ? number_format($compute, 2) : '&#8358;' . number_format($compute, 2));
	}
	else {
		return 0;
	}
	
}



//.................................................................................................
/*
Converts United States dollar to Naira at the rate of 350/dollar
*/
public function toNaira($usd) {
	$rate = 350;
	$usd = (double)$usd;
	
			$compute = $usd*$rate;
			return $compute;
}


public function toCurrencyNoSign($naira, $country) {
	$naira = (double)$naira;
	$oneDollar = 360;

	
	
	if($country == 'Nigeria') {
			return $naira;
	}
	else {
		$naira = $naira + 140;
			$compute = $naira/$oneDollar;
			return round($compute, 2);
	}
}


public function toSign($country) {
	if($country == 'Nigeria') {
		return '₦';
	}
	else {
		return '$';
	}
}


//------------------------------------------------------------------------
public function imgUploader($dir, $scnddir, $max_width, $max_height, $resizeOrig = NULL) {
$fileName = $_FILES['file']['tmp_name'];
$fileTmp = $_FILES['file']['tmp_name'];
$fileSize = $_FILES['file']['size'];
$fileError = $_FILES['file']['error'];

if(exif_imagetype($fileName) == IMAGETYPE_JPEG) {
$fileExt = 'jpg';
}
elseif(exif_imagetype($fileName) == IMAGETYPE_GIF) {
$fileExt = 'gif';
}
elseif(exif_imagetype($fileName) == IMAGETYPE_PNG) {
$fileExt = 'png';
}
else {
$fileExt = 'unsupported';
}
$fileName = time() . '_' . rand() . '' . rand() . '_n.' . $fileExt;

//Error handling
if($fileExt == 'unsupported') {
	$error = 'Unsupported image format, please upload a valid image';
	}
elseif(!$fileTmp) {
	$error = 'Please browse for a file before clicking the upload buton';
	}
elseif($fileSize > 5242880) {
	$error = 'The selected photo is too large, choose a different photo';
	unlink($fileTmp);
	exit();
	}
elseif($fileError == 1) {
	$error = 'An unknown error occured while processing the photo, please try again or try uploading a new photo';
	}
	
	
if(!$error) {
	//get original file's height & width
	list($width, $height) = getimagesize($fileTmp);

if($resizeOrig) {
$origHeight = 200;
$origWidth = 200;
}

if($fileExt == 'jpg') {
	$source = imagecreatefromjpeg($fileTmp);
	}
elseif($fileExt == 'gif') {
	$source = imagecreatefromgif($fileTmp);
	}
elseif($fileExt == 'png') {
	$source = imagecreatefrompng($fileTmp);
	}

$x_ratio = ($max_width / $width);
$y_ratio = ($max_height / $height);
 
if(($width <= $max_width) && ($height <= $max_height)) {
	$tn_width = $width;
	$tn_height = $height;
	}
elseif(($x_ratio * $height) < ($max_height)) {
	$tn_height = ceil($x_ratio * $height);
	$tn_width = $max_width;
}
else {
	$tn_width = ceil($y_ratio * $width);
	$tn_height = $max_height;
}

if($resizeOrig) {
	$imageR = imagecreatetruecolor($origWidth, $origHeight);
	}

$image = imagecreatetruecolor($tn_width, $tn_height);

if($fileExt == 'png' || $fileExt == 'gif') {
	$color = imagecolorallocatealpha($image, 0, 0, 0, 127);
	imagefill($image, 0, 0, $color);
	imagesavealpha($image, true);

if($resizeOrig){
	$color = imagecolorallocatealpha($imageR, 0, 0, 0, 127);
	imagefill($imageR, 0, 0, $color);
	imagesavealpha($imageR, true);
	}
}

imagecopyresampled($image, $source, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);

if($resizeOrig) {
imagecopyresampled($imageR, $source, 0, 0, 0, 0, $origWidth, $origHeight, $width, $height);
}

$moveFile = move_uploaded_file($fileTmp, $dir . $fileName);
if($moveFile){
if($fileExt == 'jpg') {
imagejpeg($image, $scnddir . $fileName, 75);
}
elseif($fileExt == 'png') {
imagepng($image, $scnddir . $fileName, 0);
}
elseif($fileExt == 'gif') {
imagegif($image, $scnddir . $fileName);
imagedestroy($image);
}

if($resizeOrig) {
if($fileExt == 'jpg') {
imagejpeg($imageR, $dir . $fileName, 75);
}
elseif($fileExt == 'png') {
imagepng($imageR, $dir . $fileName, 0);
}
elseif($fileExt == 'gif') {
imagegif($imageR, $dir . $fileName);
imagedestroy($imageR);
}
}
return $fileName;
}
}
else {
return 'An unknown error occured!';
}
}




}