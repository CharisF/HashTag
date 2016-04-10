<?php
include 'htmlParser.php';
echo "<HTML> <HEAD></HEAD><BODY>";

if(isset($_GET["name"])) {
	$url = $_GET["name"];
}

$url = 'http://www.sigmalive.com/';
$parse = parse_url($url);
$host=$parse['host'];



/*$UrlCategory = file_get_html("https://sitereview.bluecoat.com/sitereview.jsp#/?search=".$host);
foreach($UrlCategory->find('span') as $urlCat) {
	echo $urlCat . "HERE!!";
}*/

$tagsArray=array();

$UrlCategory = file_get_html("https://www.google.com.cy/search?q=".$host);
//echo $UrlCategory;
foreach($UrlCategory->find('div[class=_o0d]') as $ginfo) {
	$pTag=trim($ginfo->plaintext);
	$pTag=str_replace(" ","_",$pTag);
	$tagsArray[] = $pTag;
}


$html = file_get_html($url);

//we parse the html and identify areas that can contain info to generate hashtags!
foreach($html->find('title,meta[name=keywords],h1,li,div[class*=tag]') as $htagsinfo) {

	//we store the plaintext value to process it
	$pTag=$htagsinfo->plaintext;
	if( substr_count($pTag," ")>4 && strlen($pTag)>20) {

		//you can further proceed with processing such results
	}
	else if(strlen($pTag)<3) {
		
		//you can also further proceed with processing such results
	}
	else {
		//echo $pTag."<br>";
		$pTag=str_replace("","",$pTag);
		$pTag=str_replace($host,"",$pTag);
		$pTag=str_replace("","",$pTag);
		$pTag=str_replace("","",$pTag);
		$pTag=trim($pTag);
		$pTag=str_replace(" ","_",$pTag);
		$tagsArray[] = $pTag;
	}

	$tagsArrayUnique=array_unique($tagsArray);
	$clean_tagsArrayUnique= preg_grep("/\bhelp\b/i", $tagsArrayUnique, PREG_GREP_INVERT);
	$clean_tagsArrayUnique= preg_grep("/\bslide\b/i", $clean_tagsArrayUnique, PREG_GREP_INVERT);
	$clean_tagsArrayUnique= preg_grep("/\bcontact\b/i", $clean_tagsArrayUnique, PREG_GREP_INVERT);
	$clean_tagsArrayUnique= preg_grep("/\bslide\b/i", $clean_tagsArrayUnique, PREG_GREP_INVERT);
	$clean_tagsArrayUnique= preg_grep("/\bHome\b/i", $clean_tagsArrayUnique, PREG_GREP_INVERT);
	$clean_tagsArrayUnique= preg_grep("/\bαρχικη\b/i", $clean_tagsArrayUnique, PREG_GREP_INVERT);
	$clean_tagsArrayUnique= preg_grep("/\bΚεντρικη\b/i", $clean_tagsArrayUnique, PREG_GREP_INVERT);
	$clean_tagsArrayUnique= preg_grep("/\babout\b/i", $clean_tagsArrayUnique, PREG_GREP_INVERT);
	$clean_tagsArrayUnique= preg_grep("/\bmore\b/i", $clean_tagsArrayUnique, PREG_GREP_INVERT);
}
foreach($clean_tagsArrayUnique as $tagItem) echo $tagItem . "<br>";
	
$regData = file_get_html('http://www.whois.com/whois/twitter.com');		

foreach($regData->find('#registryData') as $recData) {
			echo getWhoisValue("Registrar",$recData);
			echo "<br>";
			echo getWhoisValue("Status",$recData);
			echo "<br>";
			echo getWhoisValue("Creation Date",$recData);
			echo "<br>";
			echo getWhoisValue("Expiration Date",$recData);
			echo "<br>";
			echo getWhoisValue("Updated Date",$recData);
			echo "<br>";
		}
		
echo "</BODY></HTML>";


function getWhoisValue($lookForThis,$recData) {
	$RecPos=strpos($recData, $lookForThis);
	$Rec=substr($recData,$RecPos);
	$RecPosEnd=strpos($Rec, "<br>");
	$Rec=substr($Rec,0,$RecPosEnd);
	return $Rec;
}

function insertIntoArray($data) {
	$RecPos=strpos($recData, $lookForThis);
	$Rec=substr($recData,$RecPos);
	$RecPosEnd=strpos($Rec, "<br>");
	$Rec=substr($Rec,0,$RecPosEnd);
	return $Rec;
}

?>