<?php
    /**
     * Widgets by Talitu Kadiri
     */
defined('BASEPATH') OR exit('No direct script Access');

class Library {

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
    function getRandomNumbers($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }


}