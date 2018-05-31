<?php
/*
pyupyu
*/

require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');

$channelAccessToken = 'gx/1pV2pOxZR+GoNz1N8RAzK34cYtC/lbjD3LHjlARXdHNWi/6GaRjs/FBcbe0/4ebjOGIzWilrxKrL9l0bElkCgzNEU2AuJ3yAbI3nhOcp42ncHxJbQc12R/tDIpkAw/C7JmLaRiLEQUYzowuyEygdB04t89/1O/w1cDnyilFU='; //sesuaikan 
$channelSecret = 'f9d9bf27fd37408c2e49a9d008e00030';//sesuaikan

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$groupId 	= $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp	= $client->parseEvents()[0]['timestamp'];
$type 		= $client->parseEvents()[0]['type'];

$message 	= $client->parseEvents()[0]['message'];
$messageid 	= $client->parseEvents()[0]['message']['id'];

$profil = $client->profil($userId);

$pesan_datang = explode(" ", $message['text']);
$msg_type = $message['type'];
$command = $pesan_datang[0];
$options = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $options .= '+';
        $options .= $pesan_datang[$i];
    }
}
#-------------------------[Function]-------------------------#
function quotes($keyword) {
    $uri = "http://quotes.rest/qod.json?category=" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "Result : ";
	$result .= $json['success']['total'];
	$result .= "\nQuotes : ";
	$result .= $json['contents']['quotes']['quote'];
	$result .= "\nAuthor : ";
	$result .= $json['contents']['quotes']['author'];
    return $result;
}
#-------------------------[Function]-------------------------#
function tren($keyword) {
    $uri = "http://api.secold.com/translate/en/" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "Type : English";
    $result .= "\nTranslate : ";
	$result .= $json['result'];
    return $result;
}
#-------------------------[Function]-------------------------#
function trid($keyword) {
    $uri = "http://api.secold.com/translate/id/" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "Type : Indonesian";
    $result .= "\nTranslate : ";
	$result .= $json['result'];
    return $result;
}
#-------------------------[Function]-------------------------#
function trja($keyword) {
    $uri = "http://api.secold.com/translate/ja/" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "Type : Japanese";
    $result .= "\nTranslate : ";
	$result .= $json['result'];
    return $result;
}
#-------------------------[Function]-------------------------#
function trar($keyword) {
    $uri = "http://api.secold.com/translate/ar/" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "Type : Arabic";
    $result .= "\nTranslate : ";
	$result .= $json['result'];
    return $result;
}
#-------------------------[Function]-------------------------#
function film_syn($keyword) {
    $uri = "http://www.omdbapi.com/?t=" . $keyword . '&plot=full&apikey=d5010ffe';

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "Judul : \n";
	$result .= $json['Title'];
	$result .= "\n\nSinopsis : \n";
	$result .= $json['Plot'];
    return $result;
}
#-------------------------[Function]-------------------------#
function film($keyword) {
    $uri = "http://www.omdbapi.com/?t=" . $keyword . '&plot=full&apikey=d5010ffe';

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "Judul : ";
	$result .= $json['Title'];
	$result .= "\nRilis : ";
	$result .= $json['Released'];
	$result .= "\nTipe : ";
	$result .= $json['Genre'];
	$result .= "\nActors : ";
	$result .= $json['Actors'];
	$result .= "\nBahasa : ";
	$result .= $json['Language'];
	$result .= "\nNegara : ";
	$result .= $json['Country'];
    return $result;
}
#-------------------------[Function]-------------------------#
function ytdownload($keyword) {
    $uri = "http://wahidganteng.ga/process/api/0470be5f700802ef5bc1db694e61d720/youtube-downloader?url=" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "Judul : \n";
	$result .= $json['title'];
	$result .= "\nType : ";
	$result .= $json['data']['type'];
	$result .= "\nUkuran : ";
	$result .= $json['data']['size'];
	$result .= "\nLink : ";
	$result .= $json['data']['link'];
    return $result;
}
#-------------------------[Function]-------------------------#
function anime($keyword) {

    $fullurl = 'https://myanimelist.net/api/anime/search.xml?q=' . $keyword;
    $username = 'jamal3213';
    $password = 'FZQYeZ6CE9is';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_URL, $fullurl);

    $returned = curl_exec($ch);
    $xml = new SimpleXMLElement($returned);
    $parsed = array();

    $parsed['id'] = (string) $xml->entry[0]->id;
    $parsed['image'] = (string) $xml->entry[0]->image;
    $parsed['title'] = (string) $xml->entry[0]->title;
    $parsed['desc'] = "Episode : ";
    $parsed['desc'] .= $xml->entry[0]->episodes;
    $parsed['desc'] .= "\nNilai : ";
    $parsed['desc'] .= $xml->entry[0]->score;
    $parsed['desc'] .= "\nTipe : ";
    $parsed['desc'] .= $xml->entry[0]->type;
    $parsed['synopsis'] = str_replace("<br />", "\n", html_entity_decode((string) $xml->entry[0]->synopsis, ENT_QUOTES | ENT_XHTML, 'UTF-8'));
    return $parsed;
}
#-------------------------[Function]-------------------------#
function manga($keyword) {

    $fullurl = 'https://myanimelist.net/api/manga/search.xml?q=' . $keyword;
    $username = 'jamal3213';
    $password = 'FZQYeZ6CE9is';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_URL, $fullurl);

    $returned = curl_exec($ch);
    $xml = new SimpleXMLElement($returned);
    $parsed = array();

    $parsed['id'] = (string) $xml->entry[0]->id;
    $parsed['image'] = (string) $xml->entry[0]->image;
    $parsed['title'] = (string) $xml->entry[0]->title;
    $parsed['desc'] = "Episode : ";
    $parsed['desc'] .= $xml->entry[0]->episodes;
    $parsed['desc'] .= "\nNilai : ";
    $parsed['desc'] .= $xml->entry[0]->score;
    $parsed['desc'] .= "\nTipe : ";
    $parsed['desc'] .= $xml->entry[0]->type;
    $parsed['synopsis'] = str_replace("<br />", "\n", html_entity_decode((string) $xml->entry[0]->synopsis, ENT_QUOTES | ENT_XHTML, 'UTF-8'));
    return $parsed;
}
#-------------------------[Function]-------------------------#
function ps($keyword) { 
    $uri = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20171227T171852Z.fda4bd604c7bf41f.f939237fb5f802608e9fdae4c11d9dbdda94a0b5&text=" . $keyword . "&lang=id-id"; 
 
    $response = Unirest\Request::get("$uri"); 
 
    $json = json_decode($response->raw_body, true); 
    $result .= "Name : ";
    $result .= $json['text']['0'];
    $result .= "\nLink: ";
    $result .= "https://play.google.com/store/search?q=" . $keyword . "";
    $result .= "\n\nPencarian : PlayStore";
    return $result; 
}
#-------------------------[Function]-------------------------#
function anime_syn($title) {
    $parsed = anime($title);
    $result = "Judul : " . $parsed['title'];
    $result .= "\n\nSynopsis :\n" . $parsed['synopsis'];
    return $result;
}
#-------------------------[Function]-------------------------#
function manga_syn($title) {
    $parsed = manga($title);
    $result = "Judul : " . $parsed['title'];
    $result .= "\n\nSynopsis :\n" . $parsed['synopsis'];
    return $result;
}
#-------------------------[Function]-------------------------#
function say($keyword) { 
    $uri = "https://script.google.com/macros/exec?service=AKfycbw7gKzP-WYV2F5mc9RaR7yE3Ve1yN91Tjs91hp_jHSE02dSv9w&nama=" . $keyword . "&tanggal=10-05-2003"; 
 
    $response = Unirest\Request::get("$uri"); 
 
    $json = json_decode($response->raw_body, true); 
 $result .= $json['data']['nama']; 
    return $result; 
}
#-------------------------[Function]-------------------------#
function lirik($keyword) { 
    $uri = "http://ide.fdlrcn.com/workspace/yumi-apis/joox?songname=" . $keyword . ""; 
 
    $response = Unirest\Request::get("$uri"); 
 
    $json = json_decode($response->raw_body, true); 
    $result = "====[Lyrics]====";
    $result .= "\nJudul : ";
    $result .= $json['0']['0'];
    $result .= "\nLyrics :\n";
    $result .= $json['0']['5'];
    $result .= "\n\nPencarian : Google";
    $result .= "\n====[Lyrics]====";
    return $result; 
}
#-------------------------[Function]-------------------------#
function music($keyword) { 
    $uri = "http://ide.fdlrcn.com/workspace/yumi-apis/joox?songname=" . $keyword . ""; 
 
    $response = Unirest\Request::get("$uri"); 
 
    $json = json_decode($response->raw_body, true); 
    $result = "====[Music]====";
    $result .= "\nJudul : ";
    $result .= $json['0']['0'];
    $result .= "\nDurasi : ";
    $result .= $json['0']['1'];
    $result .= "\nLink : ";
    $result .= $json['0']['4'];
    $result .= "\n\nPencarian : Google";
    $result .= "\n====[Music]====";
    return $result; 
}
#-------------------------[Function]-------------------------#
function githubrepo($keyword) { 
    $uri = "https://api.github.com/search/repositories?q=" . $keyword; 
 
    $response = Unirest\Request::get("$uri"); 
 
    $json = json_decode($response->raw_body, true); 
    $result = "====[GithubRepo]====";
    $result .= "\n====[1]====";
    $result .= "\nResult : ";
    $result .= $json['total_count'];
    $result .= "\nNama Repository : ";
    $result .= $json['items']['data']['name'];
    $result .= "\nNama Github : ";
    $result .= $json['items']['full_name'];
    $result .= "\nLanguage : ";
    $result .= $json['items']['language'];
    $result .= "\nUrl Github : ";
    $result .= $json['items']['owner']['html_url'];
    $result .= "\nUrl Repository : ";
    $result .= $json['items']['html_url'];
    $result .= "\nPrivate : ";
    $result .= $json['items']['private'];
    $result .= "\n====[2]====";
    $result .= "\nResult : ";
    $result .= $json['total_count'];
    $result .= "\nNama Repository : ";
    $result .= $json['items'][['name']];
    $result .= "\nNama Github : ";
    $result .= $json['items']['full_name'];
    $result .= "\nLanguage : ";
    $result .= $json['items']['language'];
    $result .= "\nUrl Github : ";
    $result .= $json['items']['owner']['html_url'];
    $result .= "\nUrl Repository : ";
    $result .= $json['items']['html_url'];
    $result .= "\nPrivate : ";
    $result .= $json['items']['private'];
    $result .= "\n====[3]====";
    $result .= "\nResult : ";
    $result .= $json['total_count'];
    $result .= "\nNama Repository : ";
    $result .= $json['items']['name'];
    $result .= "\nNama Github : ";
    $result .= $json['items']['full_name'];
    $result .= "\nLanguage : ";
    $result .= $json['items']['language'];
    $result .= "\nUrl Github : ";
    $result .= $json['items']['owner']['html_url'];
    $result .= "\nUrl Repository : ";
    $result .= $json['items']['html_url'];
    $result .= "\nPrivate : ";
    $result .= $json['items']['private'];
    $result .= "\n====[GithubRepo]====\n";
    $result .= "\n\nPencarian : Google";
    $result .= "\n====[GithubRepo]====";
    return $result; 
}
#-------------------------[Function]-------------------------#
function img_search($keyword) {
    $uri = 'https://www.google.co.id/search?q=' . $keyword . '&safe=off&source=lnms&tbm=isch';

    $response = Unirest\Request::get("$uri");

    $hasil = str_replace(">", "&gt;", $response->raw_body);
    $arrays = explode("<", $hasil);
    return explode('"', $arrays[291])[3];
}
#-------------------------[Function]-------------------------#
function shalat($keyword) {
    $uri = "https://time.siswadi.com/pray/" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "====[JadwalShalat]====";
    $result .= "\nLokasi : ";
	$result .= $json['location']['address'];
	$result .= "\nTanggal : ";
	$result .= $json['time']['date'];
	$result .= "\n\nShubuh : ";
	$result .= $json['data']['Fajr'];
	$result .= "\nDzuhur : ";
	$result .= $json['data']['Dhuhr'];
	$result .= "\nAshar : ";
	$result .= $json['data']['Asr'];
	$result .= "\nMaghrib : ";
	$result .= $json['data']['Maghrib'];
	$result .= "\nIsya : ";
	$result .= $json['data']['Isha'];
	$result .= "\n\nPencarian : Google";
	$result .= "\n====[JadwalShalat]====";
    return $result;
}
#-------------------------[Function]-------------------------#
#-------------------------[Function]-------------------------#
function kalender($keyword) {
    $uri = "https://time.siswadi.com/pray/" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "====[Kalender]====";
    $result .= "\nLokasi : ";
	$result .= $json['location']['address'];
	$result .= "\nTanggal : ";
	$result .= $json['time']['date'];
	$result .= "\n\nPencarian : Google";
	$result .= "\n====[Kalender]====";
    return $result;
}
#-------------------------[Function]-------------------------#
function waktu($keyword) {
    $uri = "https://time.siswadi.com/pray/" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "====[Time]====";
    $result .= "\nLokasi : ";
	$result .= $json['location']['address'];
	$result .= "\nJam : ";
	$result .= $json['time']['time'];
	$result .= "\nSunrise : ";
	$result .= $json['debug']['sunrise'];
	$result .= "\nSunset : ";
	$result .= $json['debug']['sunset'];
	$result .= "\n\nPencarian : Google";
	$result .= "\n====[Time]====";
    return $result;
}
#-------------------------[Function]-------------------------#
function saveitoffline($keyword) {
    $uri = "https://www.saveitoffline.com/process/?url=" . $keyword . '&type=json';

    $response = Unirest\Request::get("$uri");


    $json = json_decode($response->raw_body, true);
	$result = "====[SaveOffline]====\n";
	$result .= "Judul : \n";
	$result .= $json['title'];
	$result .= "\n\nUkuran : \n";
	$result .= $json['urls'][0]['label'];
	$result .= "\n\nURL Download : \n";
	$result .= $json['urls'][0]['id'];
	$result .= "\n\nUkuran : \n";
	$result .= $json['urls'][1]['label'];
	$result .= "\n\nURL Download : \n";
	$result .= $json['urls'][1]['id'];
	$result .= "\n\nUkuran : \n";
	$result .= $json['urls'][2]['label'];	
	$result .= "\n\nURL Download : \n";
	$result .= $json['urls'][2]['id'];
	$result .= "\n\nUkuran : \n";
	$result .= $json['urls'][3]['label'];	
	$result .= "\n\nURL Download : \n";
	$result .= $json['urls'][3]['id'];	
	$result .= "\n\nPencarian : Google\n";
	$result .= "====[SaveOffline]====";
    return $result;
}
#-------------------------[Function]-------------------------#
function qibla($keyword) { 
    $uri = "https://time.siswadi.com/qibla/" . $keyword; 
 
    $response = Unirest\Request::get("$uri"); 
 
    $json = json_decode($response->raw_body, true); 
 $result .= $json['data']['image'];
    return $result; 
}
// ----- LOCATION BY FIDHO -----
function lokasi($keyword) { 
    $uri = "https://time.siswadi.com/pray/" . $keyword; 
 
    $response = Unirest\Request::get("$uri"); 
 
    $json = json_decode($response->raw_body, true); 
 $result['address'] .= $json['location']['address'];
 $result['latitude'] .= $json['location']['latitude'];
 $result['longitude'] .= $json['location']['longitude'];
    return $result; 
}

#-------------------------[Function]-------------------------#
function cuaca($keyword) {
    $uri = "http://api.openweathermap.org/data/2.5/weather?q=" . $keyword . ",ID&units=metric&appid=e172c2f3a3c620591582ab5242e0e6c4";
    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "====[InfoCuaca]====";
    $result .= "\nKota : ";
	$result .= $json['name'];
	$result .= "\nCuaca : ";
	$result .= $json['weather']['0']['main'];
	$result .= "\nDeskripsi : ";
	$result .= $json['weather']['0']['description'];
	$result .= "\n\nPencariaan : Google";
	$result .= "\n====[InfoCuaca]====";
    return $result;
}
#-------------------------[Function]-------------------------#
function urb_dict($keyword) {
    $uri = "http://api.urbandictionary.com/v0/define?term=" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = $json['list'][0]['definition'];
    $result .= "\n\nExamples : \n";
    $result .= $json['list'][0]['example'];
    return $result;
}
#-------------------------[Function]-------------------------#
function qrcode($keyword) {
    $uri = "http://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=" . $keyword;

    return $uri;
}
#-------------------------[Function]-------------------------#
function adfly($url, $key, $uid, $domain = 'adf.ly', $advert_type = 'int')
{
  // base api url
  $api = 'http://api.adf.ly/api.php?';

  // api queries
  $query = array(
    '7970aaad57427df04129cfe2cfcd0584' => $key,
    '16519547' => $uid,
    'advert_type' => $advert_type,
    'domain' => $domain,
    'url' => $url
  );

  // full api url with query string
  $api = $api . http_build_query($query);
  // get data
  if ($data = file_get_contents($api))
    return $data;
}
#----------------#
function send($input, $rt){
    $send = array(
        'replyToken' => $rt,
        'messages' => array(
            array(
                'type' => 'text',					
                'text' => $input
            )
        )
    );
    return($send);
}

function jawabs(){
    $list_jwb = array(
		'Ya',
		'Tidak',
		'Coba ajukan pertanyaan lain',	    
		);
    $jaws = array_rand($list_jwb);
    $jawab = $list_jwb[$jaws];
    return($jawab);
}

function kapan(){
    $list_jwb = array(
		'Besok',
		'1 Hari Lagi',
		'1 Bulan Lagi',
		'1 Tahun Lagi',
		'1 Abad Lagi',
		'Coba ajukan pertanyaan lain',	    
		);
    $jaws = array_rand($list_jwb);
    $jawab = $list_jwb[$jaws];
    return($jawab);
}

function bisa(){
    $list_jwb = array(
		'Bisa',
		'Tidak Bisa',
		'Bisa Jadi',
		'Mungkin Tidak Bisa',
		'Coba ajukan pertanyaan lain',	    
		);
    $jaws = array_rand($list_jwb);
    $jawab = $list_jwb[$jaws];
    return($jawab);
}

function dosa(){
    $list_jwb = array(
		'10%',
		'20%',
		'30%',
		'40%',
		'50%',
		'60%',
		'70%',
		'80%',
		'90%',
		'100%'	
		);
    $jaws = array_rand($list_jwb);
    $jawab = $list_jwb[$jaws];
    return($jawab);
}

function dosa2(){
    $list_jwb = array(
		'Dosanya Sebesar ',
		);
    $jaws = array_rand($list_jwb);
    $jawab = $list_jwb[$jaws];
    return($jawab);
}
function dosa3(){
    $list_jwb = array(
		' Cepat cepat tobat bos',
		);
    $jaws = array_rand($list_jwb);
    $jawab = $list_jwb[$jaws];
    return($jawab);
}
#-------------------------[Function]-------------------------#

function zodiak($keyword) {
    $uri = "https://script.google.com/macros/exec?service=AKfycbw7gKzP-WYV2F5mc9RaR7yE3Ve1yN91Tjs91hp_jHSE02dSv9w&nama=ervan&tanggal=" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "====[Zodiak]====";
    $result .= "\nLahir : ";
	$result .= $json['data']['lahir'];
	$result .= "\nUsia : ";
	$result .= $json['data']['usia'];
	$result .= "\nUltah : ";
	$result .= $json['data']['ultah'];
	$result .= "\nZodiak : ";
	$result .= $json['data']['zodiak'];
	$result .= "\n\nPencarian : Google";
	$result .= "\n====[Zodiak]====";
    return $result;
}
#-------------------------[Function]-------------------------#
//show menu, saat join dan command,menu
if ($type == 'join' || $command == 'Help') {
    $text .= "==[EVENT ASSIST-keywords]==";
    $text .= "> \n";
    $text .= "> welcome\n"; 
    $text .= "> FIS\n";
    $text .= "> Judges\n";
    $text .= "> ID JUDGES\n";
    $text .= "> Crew1\n";
    $text .= "> Crew2\n";
    $text .= "> S1,S2,S3,S4 ->info sesi\n";
    $text .= "> /convert [link yt] ->download lagu\n";
    $text .= "> /myinfo\n";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}
#-------------------------[Function]-------------------------#
//show menu, saat join dan command,menu
if ($type == 'join' || $command == 'Wc') {
    $text .= "====[HALLO WELCOME]====";
    $text .= " \n";
    $text .= "     Selamat datang diROOM\n";
    $text .= "=======================\n";	
    $text .= "                    >2ᴺᴰ<\n";	
    $text .= "    ⓐⓝⓝⓘⓥⓔⓡⓢⓐⓡⓨ\n";	
    $text .= "F͛A͛M͛I͛L͛Y͛ I͛N͛D͛O͛N͛E͛S͛I͛A͛N͛ S͛M͛U͛L͛E͛\n";
    $text .= "=======================\n";	
    $text .= "  Jangan Lupa Cek Note ya\n";
    $text .= "[Salken dari Saya]->$profil->displayName\n";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}
if($message['type']=='text') {
	    if ($command == '/qiblat') {
        $hasil = qibla($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'image',
                    'originalContentUrl' => $hasil,
                    'previewImageUrl' => $hasil
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/myinfo') {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(

										'type' => 'text',					
										'text' => '====[InfoProfile]====
Nama: '.$profil->displayName.'

Status: '.$profil->statusMessage.'

Picture: '.$profil->pictureUrl.'

====[InfoProfile]===='
									)
							)
						);
				
	}
}
//pesan bergambar
if ($message['type'] == 'text') {
    if ($command == '/def') {


        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Definition : ' . urb_dict($options)
                )
            )
        );
    }
}
if($msg_type == 'text'){
    $pesan_datang = strtolower($message['text']);
    $filter = explode(' ', $pesan_datang);
    if($filter[0] == 'apakah') {
        $balas = send(jawabs(), $replyToken);
    } else {}
} if($msg_type == 'text'){
    $pesan_datang = strtolower($message['text']);
    $filter = explode(' ', $pesan_datang);
    if($filter[0] == 'bisakah') {
        $balas = send(bisa(), $replyToken);
    } else {}
} if($msg_type == 'text'){
    $pesan_datang = strtolower($message['text']);
    $filter = explode(' ', $pesan_datang);
    if($filter[0] == 'kapankah') {
        $balas = send(kapan(), $replyToken);
    } else {}
} if($msg_type == 'text'){
    $pesan_datang = strtolower($message['text']);
    $filter = explode(' ', $pesan_datang);
    if($filter[0] == 'rate') {
        $balas = send(dosa(), $replyToken);
    } else {}
} if($msg_type == 'text'){
    $pesan_datang = strtolower($message['text']);
    $filter = explode(' ', $pesan_datang);
    if($filter[0] == 'dosanya') {
		$balas = send(dosa2(), $replyToken);
		$balas = send(dosa(), $replyToken);
		$balas = send(dosa3(), $replyToken);
    } else {}
} else {}
//translate//
if($message['type']=='text') {
	    if ($command == '/tr-ar') {

        $result = trar($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/tr-ja') {

        $result = trja($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/tr-id') {

        $result = trid($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/tr-en') {

        $result = tren($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/say') {

        $result = say($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/yt-get') {

        $result = yt-download($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => yt-download($options)
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/github-repo') {

        $result = githubrepo($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/qiblat') {
        $hasil = qibla($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'image',
                    'originalContentUrl' => $hasil,
                    'previewImageUrl' => $hasil
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/cuaca') {

        $result = cuaca($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/qr') {

        $result = qrcode($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'image',
                    'originalContentUrl' => $qrcode($options),
                    'previewImageUrl' => qrcode($options)
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/playstore') {

        $result = ps($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text'  => 'Searching...'
                ),
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }

}
if($message['type']=='text') {
	    if ($command == '/quotes') {

        $result = quotes($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text'  => $result
                )
            )
        );
    }

}                
//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/convert') {
        $result = saveitoffline($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => saveitoffline($options)
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/shorten') {
        $result = adfly($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $data
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/qiblat') {
        $hasil = qibla($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'image',
                    'originalContentUrl' => $hasil,
                    'previewImageUrl' => $hasil
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/yt') {
        $keyword = '';
        $image = 'https://img.youtube.com/vi/' . $keyword . '/2.jpg';
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'image',
                    'originalContentUrl' => $image,
                    'previewImageUrl' => $image
                ), array(
                    'type' => 'video',
                    'originalContentUrl' => vid_search($keyword),
                    'previewImageUrl' => $image
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/anime') {
        $result = anime($options);
        $altText = "Title : " . $result['title'];
        $altText .= "\n\n" . $result['desc'];
        $altText .= "\nMAL Page : https://myanimelist.net/anime/" . $result['id'];
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'template',
                    'altText' => $altText,
                    'template' => array(
                        'type' => 'buttons',
                        'title' => $result['title'],
                        'thumbnailImageUrl' => $result['image'],
                        'text' => $result['desc'],
                        'actions' => array(
                            array(
                                'type' => 'postback',
                                'label' => 'Baca Sinopsis-nya',
                                'data' => 'action=add&itemid=123',
                                'text' => '/anime-syn ' . $options
                            ),
                            array(
                                'type' => 'uri',
                                'label' => 'Website MAL',
                                'uri' => 'https://myanimelist.net/anime/' . $result['id']
                            )
                        )
                    )
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/manga') {
        $result = manga($options);
        $altText = "Title : " . $result['title'];
        $altText .= "\n\n" . $result['desc'];
        $altText .= "\nMAL Page : https://myanimelist.net/manga/" . $result['id'];
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'template',
                    'altText' => $altText,
                    'template' => array(
                        'type' => 'buttons',
                        'title' => $result['title'],
                        'thumbnailImageUrl' => $result['image'],
                        'text' => $result['desc'],
                        'actions' => array(
                            array(
                                'type' => 'postback',
                                'label' => 'Baca Sinopsis-nya',
                                'data' => 'action=add&itemid=123',
                                'text' => '/manga-syn' . $options
                            ),
                            array(
                                'type' => 'uri',
                                'label' => 'Website MAL',
                                'uri' => 'https://myanimelist.net/manga/' . $result['id']
                            )
                        )
                    )
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/anime-syn') {

        $result = anime_syn($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/film') {

        $result = film($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ($command == '/manga-syn') {

        $result = manga_syn($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/lirik') {

        $result = lirik($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
        if ($command == '/film-syn') {
        $result = film_syn($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array( 
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
//pesan bergambar
// ----- LOKASI BY FIDHO -----
if($message['type']=='text') {
	    if ($command == '/lokasi' || $command == '/Lokasi') {

        $result = lokasi($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'location',
                    'title' => 'Lokasi',
                    'address' => $result['address'],
                    'latitude' => $result['latitude'],
                    'longitude' => $result['longitude']
                ),
            )
        );
    }

}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/kalender') {

        $result = kalender($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
if($message['type']=='text') {
	    if ('Apakah' == $command) {
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $acak
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/time') {

        $result = waktu($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/music') {

        $result = music($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/zodiak') {

        $result = zodiak($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Bot' || $command == 'bot' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => ' kenapa manggil manggil??'.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Creator' || $command == 'creator' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'template',
  'altText' => 'CREATOR',
  'template' => 
  array (
    'type' => 'buttons',
    'thumbnailImageUrl' => 'https://image.ibb.co/d0tiLy/BANNER.jpg',
    'imageAspectRatio' => 'rectangle',
    'imageSize' => 'cover',
    'imageBackgroundColor' => '#FFFFFF',
    'title' => 'ALS CREATIVE',
    'text' => 'READY--> SIRI-CHAN LINE -BOT OA -COVER/FLYER -LOGO -VIDEO EDITING',
    'defaultAction' => 
    array (
      'type' => 'uri',
      'label' => 'CHAT',
      'uri' => 'http://line.me/ti/p/8jX6OIm-AS',
    ),
    'actions' => 
    array (
      0 => 
      array (
        'type' => 'uri',
        'label' => 'CHAT',
        'uri' => 'http://line.me/ti/p/8jX6OIm-AS',
      ),
      1 => 
      array (
        'type' => 'postback',
        'label' => 'Add to cart',
        'data' => 'action=add&itemid=123',
      ),
      2 => 
      array (
        'type' => 'uri',
        'label' => 'View detail',
        'uri' => 'http://example.com/page/123',
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Bot' || $command == 'bot' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Ada apa sebut saya??'.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Pagi' || $command == 'pagi' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Pagi juga, Senyum ya! '.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Siang' || $command == 'siang' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Siang juga, Jangan lupa makan siang ya '.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Assalamualaikum' || $command == 'assalamualaikum' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'waalaikumsalam wr.wb '.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Waalaikumsalam' || $command == 'Waalaikumsalam wr.wb' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Makasih dah jawab salamnya kk '.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Sore' || $command == 'sore' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Ngopi dulu '.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Malam' || $command == 'Night' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Malam juga, '.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'baik' || $command == 'Baik' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Tetap Semangat Ya! '.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Halo' || $command == 'Hallo' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'HALLO apa kabar'.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Hai' || $command == 'hai' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Hai juga '.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Udh' || $command == 'udh' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'pinter kamu '.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Udah' || $command == 'udah' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'pinter kamu '.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Ok' || $command == 'ok' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'pinter kamu '.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'gila' || $command == 'peak' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => 'Kok gitu ngomongnya ;( '.$profil->displayName
                )
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text')
	if ($command == 'admin' || $command == 'Admin' )
	{
		
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
array (
  'type' => 'template',
  'altText' => 'FIS MANAGEMENT',
  'template' => 
  array (
    'type' => 'carousel',
    'columns' => 
    array (
      0 => 
      array (
        'thumbnailImageUrl' => 'https://preview.ibb.co/gDpnMb/20180108_110257.jpg',
        'imageBackgroundColor' => '#FFFFFF',
        'title' => 'FOUNDER',
        'text' => 'Group Owner -- Name : FahreziLee   Location : Malaysia',
        'actions' => 
        array (
          0 => 
          array (
            'type' => 'uri',
            'label' => 'CHAT',
            'uri' => 'http://tiny.cc/FIS_Lee',
          ),
          1 => 
          array (
            'type' => 'uri',
            'label' => 'SMULE',
            'uri' => 'https://www.smule.com/FIS_FahreziLee',
          ),		  
          2 => 
          array (
            'type' => 'message',
            'label' => 'view detail',
            'text' => 'FIS_LEE',
          ),
        ),
      ),
      1 => 
      array (
        'thumbnailImageUrl' => 'https://preview.ibb.co/gUFu1b/20180108_110910.jpg',
        'imageBackgroundColor' => '#FFFFFF',
        'title' => 'SECRETARY',
        'text' => 'Admin -- Name : DeeAna       Location : Borneo',
        'actions' => 
        array (
          0 => 
          array (
            'type' => 'uri',
            'label' => 'CHAT',
            'uri' => 'http://tiny.cc/FIS_DEE',
          ),
          1 => 
          array (
            'type' => 'uri',
            'label' => 'SMULE',
            'uri' => 'https://www.smule.com/FIS_Dee',
          ),		  
          2 => 
          array (
            'type' => 'message',
            'label' => 'view detail',
            'text' => 'FIS_Dee',
          ),
        ),
      ),
      2 => 
      array (
        'thumbnailImageUrl' => 'https://preview.ibb.co/njD3uw/20180108_111546.jpg',
        'imageBackgroundColor' => '#FFFFFF',
        'title' => 'CREATIVE',
        'text' => 'Admin -- Name : ALS                 Location : West Java',
        'actions' => 
        array (
          0 => 
          array (
            'type' => 'uri',
            'label' => 'CHAT',
            'uri' => 'http://tiny.cc/FIS_ALS',
          ),
          1 => 
          array (
            'type' => 'uri',
            'label' => 'SMULE',
            'uri' => 'https://www.smule.com/FIS_ALS',
          ),		  
          2 => 
          array (
            'type' => 'message',
            'label' => 'view detail',
            'text' => 'FIS_ALS',
          ),
        ),
      ),
      3 => 
      array (
        'thumbnailImageUrl' => 'https://preview.ibb.co/nxZySG/20180108_111027.jpg',
        'imageBackgroundColor' => '#FFFFFF',
        'title' => 'RESOURCE',
        'text' => 'Admin -- Name : Lala              Location : Hongkong',
        'actions' => 
        array (
          0 => 
          array (
            'type' => 'uri',
            'label' => 'CHAT',
            'uri' => 'http://tiny.cc/FIS_LALA',
          ),
          1 => 
          array (
            'type' => 'uri',
            'label' => 'SMULE',
            'uri' => 'https://www.smule.com/FIS_LALA',
          ),		  
          2 => 
          array (
            'type' => 'message',
            'label' => 'view detail',
            'text' => 'FIS_LALA',
          ),
        ),
      ),
      4 => 
      array (
        'thumbnailImageUrl' => 'https://preview.ibb.co/gRYKZw/20180108_111446.jpg',
        'imageBackgroundColor' => '#FFFFFF',
        'title' => 'HOME AS.',
        'text' => 'Admin -- Name : Alfariz              Location : Jakarta',
        'actions' => 
        array (
          0 => 
          array (
            'type' => 'uri',
            'label' => 'CHAT',
            'uri' => 'http://tiny.cc/FIS_ALFARIZ',
          ),
          1 => 
          array (
            'type' => 'uri',
            'label' => 'SMULE',
            'uri' => 'https://www.smule.com/FIS_Alfariz',
          ),		  
          2 => 
          array (
            'type' => 'message',
            'label' => 'view detail',
            'text' => 'FIS_Alfariz',
          ),
        ),
      ),
      5 => 
      array (
        'thumbnailImageUrl' => 'https://preview.ibb.co/npK41b/20180108_111333.jpg',
        'imageBackgroundColor' => '#FFFFFF',
        'title' => 'HOME AS.',
        'text' => 'Admin -- Name : Juna Hermanza   Location : West Java',
        'actions' => 
        array (
          0 => 
          array (
            'type' => 'uri',
            'label' => 'CHAT',
            'uri' => 'http://tiny.cc/FIS_JUNA',
          ),
          1 => 
          array (
            'type' => 'uri',
            'label' => 'SMULE',
            'uri' => 'https://www.smule.com/FIS_Juna',
          ),		  
          2 => 
          array (
            'type' => 'message',
            'label' => 'view detail',
            'text' => 'FIS_Juna',
          ),
        ),
      ),
      6 => 
      array (
        'thumbnailImageUrl' => 'https://preview.ibb.co/edtxMb/20180108_111247.jpg',
        'imageBackgroundColor' => '#FFFFFF',
        'title' => 'HOME AS.',
        'text' => 'Admin -- Name : Anissa              Location : West Java',
        'actions' => 
        array (
          0 => 
          array (
            'type' => 'uri',
            'label' => 'CHAT',
            'uri' => 'http://tiny.cc/FIS_NISA',
          ),
          1 => 
          array (
            'type' => 'uri',
            'label' => 'SMULE',
            'uri' => 'https://www.smule.com/FIS_Nisa',
          ),		  
          2 => 
          array (
            'type' => 'message',
            'label' => 'view detail',
            'text' => 'FIS_Nisa',
          ),
        ),
      ),
    ),
    'imageAspectRatio' => 'rectangle',
    'imageSize' => 'cover',
  ),
)
							)
						);
				
	}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Welcome' || $command == 'wc' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525177232/line/EVENT/wc',
  'altText' => 'WELCOME PESERTA EVENT FIS',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'uri',
      'linkUri' => 'https://www.smule.com/FIS_OFFICIAL',
      'area' => 
      array (
        'x' => 0,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
    1 => 
    array (
      'type' => 'message',
      'text' => 'Crews',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Anniv' || $command == 'bday' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525533625/line/ULTAH',
  'altText' => 'HAPPY 2ᴺᴰ ANNIVERSARY FIS',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'uri',
      'linkUri' => 'https://www.smule.com/FIS_OFFICIAL',
      'area' => 
      array (
        'x' => 0,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
    1 => 
    array (
      'type' => 'message',
      'text' => 'anniv',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'S21' || $command == 's21' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1526051773/line/EVENT/S2',
  'altText' => 'INFO SESSION 2',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'uri',
      'linkUri' => 'https://www.smule.com/FIS_OFFICIAL',
      'area' => 
      array (
        'x' => 0,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
    1 => 
    array (
      'type' => 'message',
      'text' => 'ID JUDGES',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'S22' || $command == 's22' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1526052096/line/EVENT/S2-1',
  'altText' => 'INFO SESSION 2',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'uri',
      'linkUri' => 'https://www.smule.com/FIS_OFFICIAL',
      'area' => 
      array (
        'x' => 0,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
    1 => 
    array (
      'type' => 'message',
      'text' => 'ID JUDGES',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'S31' || $command == 's31' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1527201454/line/EVENT/SEMI1',
  'altText' => 'INFO SEMIFINAL',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'uri',
      'linkUri' => 'https://www.smule.com/FIS_OFFICIAL',
      'area' => 
      array (
        'x' => 0,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
    1 => 
    array (
      'type' => 'message',
      'text' => 'ID JUDGES',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'S32' || $command == 's32' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1527201539/line/EVENT/SEMI2',
  'altText' => 'INFO SEMIFINAL',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'uri',
      'linkUri' => 'https://www.smule.com/FIS_OFFICIAL',
      'area' => 
      array (
        'x' => 0,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
    1 => 
    array (
      'type' => 'message',
      'text' => 'ID JUDGES',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Final' || $command == 'final' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1526286335/line/EVENT/NOTAVAILABLE',
  'altText' => 'INFO FINAL',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'uri',
      'linkUri' => 'https://www.smule.com/FIS_OFFICIAL',
      'area' => 
      array (
        'x' => 0,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
    1 => 
    array (
      'type' => 'message',
      'text' => 'ID JUDGES',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Puasa' || $command == 'puasa' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1526133379/line/Bot/Puasa',
  'altText' => 'SELAMAT BERPUASA FIS FAMILY',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'message',
      'text' => 'Puasa',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Buka' || $command == 'buka puasa' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1526285679/line/buka',
  'altText' => 'SELAMAT BERBUKA PUASA',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'message',
      'text' => 'Buka',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Sahur' || $command == 'sahur' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1526285827/line/sahur',
  'altText' => 'SELAMAT SANTAP SAHUR',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'message',
      'text' => 'Sahur',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Goda1' || $command == 'goda1' ) {
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1526287910/line/goda1',
  'altText' => 'Kamu kuat kan puasanya ?',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'message',
      'text' => 'Goda1',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Fis' || $command == 'fis' ) {
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524724017/line/Bot/visi',
  'altText' => 'visi misi',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'message',
      'text' => 'flag',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'flag' || $command == 'Flag' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'video',
  'originalContentUrl' => 'https://res.cloudinary.com/tes5566/video/upload/v1524724365/line/Bot/video/2018_04_26_13_09_51.mp4',
  'previewImageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524725537/line/Bot/video/20180426_130843.jpg',
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Judges' || $command == 'judges' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'template',
  'altText' => 'JUDGES EVENT FIS',
  'template' => 
  array (
    'type' => 'image_carousel',
    'columns' => 
    array (
      0 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525180249/line/EVENT/crew/lee.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_FahreziLee',
        ),
      ),
      1 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525180266/line/EVENT/crew/chika.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_ChikaLee',
        ),
      ),
      2 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525180286/line/EVENT/crew/dewa.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_DewaBF5_HIVO',
        ),
      ),
      3 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525180245/line/EVENT/crew/uni.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/HYT_FIS_FOrTe__',
        ),
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Crews' || $command == 'crews' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'template',
  'altText' => 'CREWS EVENT FIS',
  'template' => 
  array (
    'type' => 'image_carousel',
    'columns' => 
    array (
      0 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525180273/line/EVENT/crew/als.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_ALS',
        ),
      ),
      1 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747424/line/EVENT/crew/dee.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_Dee',
        ),
      ),
      2 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747429/line/EVENT/crew/sha.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_Lala',
        ),
      ),
      3 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525423640/line/EVENT/crew/Untitled214.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_Juna',
        ),
      ),
      4 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747500/line/EVENT/crew/nisa.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_Nisa',
        ),
      ),
      5 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747488/line/EVENT/crew/Ratu.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_RATPARSI_AVI',
        ),
      ),
      6 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747424/line/EVENT/crew/dinar.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_IPSI_DINAR',
        ),
      ),
      7 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747429/line/EVENT/crew/gus.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS__GUSSUR',
        ),
      ),
      8 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747429/line/EVENT/crew/alvan.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_MS_ALVAN07',
        ),
      ),
      9 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747500/line/EVENT/crew/radith.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/BFC_FIS_MrRadith',
        ),
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Crew1' || $command == 'crew1' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'template',
  'altText' => 'CREWS EVENT FIS',
  'template' => 
  array (
    'type' => 'image_carousel',
    'columns' => 
    array (
      0 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525180273/line/EVENT/crew/als.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_ALS',
        ),
      ),
      1 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747424/line/EVENT/crew/dee.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_Dee',
        ),
      ),
      2 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747429/line/EVENT/crew/sha.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_Lala',
        ),
      ),
      3 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525423640/line/EVENT/crew/Untitled214.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_Juna',
        ),
      ),
      4 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747500/line/EVENT/crew/nisa.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_Nisa',
        ),
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Crew2' || $command == 'crew2' ) {

        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'template',
  'altText' => 'CREWS EVENT FIS',
  'template' => 
  array (
    'type' => 'image_carousel',
    'columns' => 
    array (
      0 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747488/line/EVENT/crew/Ratu.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_RATPARSI_AVI',
        ),
      ),
      1 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747424/line/EVENT/crew/dinar.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_IPSI_DINAR',
        ),
      ),
      2 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747429/line/EVENT/crew/gus.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS__GUSSUR',
        ),
      ),
      3 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747429/line/EVENT/crew/alvan.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/FIS_MS_ALVAN07',
        ),
      ),
      4 => 
      array (
        'imageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1524747500/line/EVENT/crew/radith.jpg',
        'action' => 
        array (
          'type' => 'uri',
          'label' => 'SMULE',
          'uri' => 'http://smule.com/BFC_FIS_MrRadith',
        ),
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == 'Minum' || $command == 'haus' ) {
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array (
  'type' => 'imagemap',
  'baseUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1526287217/line/goda',
  'altText' => 'Yang haus yang haus ?',
  'baseSize' => 
  array (
    'height' => 1040,
    'width' => 1040,
  ),
  'actions' => 
  array (
    0 => 
    array (
      'type' => 'message',
      'text' => 'Minum',
      'area' => 
      array (
        'x' => 520,
        'y' => 0,
        'width' => 520,
        'height' => 1040,
      ),
    ),
  ),
)
            )
        );
    }
}
//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/shalat') {

        $result = shalat($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    } else if ($command == '/') {

	        $balas = array(
							'replyToken' => $replyToken,
							'messages' => array(
								array (
										  'type' => 'template',
										  'altText' => 'Silahkan Pilih Keyword Yang Anda Inginkan',
										  'template' => 
										  array (
										    'type' => 'carousel',
										    'columns' => 
										    array (
										      0 => 
										      array (
										        'thumbnailImageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525181805/line/EVENT/crew/Untitled-1.jpg',
										        'title' => 'Keyword 1',
										        'text' => 'Silahkan Dipilih',
										        'actions' => 
										        array (
										          0 => 
										          array (
										            'type' => 'postback',
										            'label' => 'JUDGES',
										            'data' => 'action=add&itemid=111',
													'text' => 'Ketik Judges'
										          ),
										          1 => 
										          array (
										            'type' => 'postback',
										            'label' => 'Cari Sinopsis Anime',
										            'data' => 'action=add&itemid=111',
													'text' => 'Ketik /anime-syn [Judul Anime]'
												  ),
										          2 => 
										          array (
										            'type' => 'postback',
										            'label' => 'Cari Manga',
										            'data' => 'action=add&itemid=111',
													'text' => 'Ketik /manga [Judul Manga]'
										          ),
										        ),
										      ),
										      1 => 
										      array (
										        'thumbnailImageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525181805/line/EVENT/crew/Untitled-1.jpg',
										        'title' => 'Keyword 2',
										        'text' => 'Silahkan Dipilih',
										        'actions' => 
										        array (
										          0 => 
										          array (
										            'type' => 'postback',
										            'label' => 'Cari Sinopsis Manga',
										            'data' => 'action=add&itemid=111',
													'text' => 'Ketik /manga-syn [Judul Manga]'
										          ),
										          1 => 
										          array (
													'type' => 'postback',
													'label' => 'Cari Film',
													'data' => 'action=add&itemid=111',
													'text' => 'Ketik /film [Judul Film]'
										          ),
										          2 => 
										          array (
													'type' => 'postback',
													'label' => 'Cari Sinopsis Film',
													'data' => 'action=add&itemid=111',
													'text' => 'Ketik /film-syn [Judul Film]'
										          ),
										        ),
										      ),
										      2 => 
										      array (
										        'thumbnailImageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525181805/line/EVENT/crew/Untitled-1.jpg',
										        'title' => 'Keyword 3',
										        'text' => 'Silahkan Dipilih',
										        'actions' => 
										        array (
										          0 => 
										          array (
										            'type' => 'postback',
										            'label' => 'Cari Aplikasi',
										            'data' => 'action=add&itemid=111',
													'text' => 'Ketik /playstore [Nama Aplikasi]'
										          ),
										          1 => 
										          array (
													'type' => 'postback',
													'label' => 'Cari Informasi',
													'data' => 'action=add&itemid=111',
													'text' => 'Ketik /myinfo'
										          ),
										          2 => 
										          array (
													'type' => 'postback',
													'label' => 'Cari Zodiak',
													'data' => 'action=add&itemid=111',
													'text' => 'Ketik /zodiak [Tanggal Lahir]'
										          ),
										        ),
										      ),
										      3 => 
										      array (
										        'thumbnailImageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525181805/line/EVENT/crew/Untitled-1.jpg',
										        'title' => 'Keyword 4',
										        'text' => 'Silahkan Dipilih',
										        'actions' => 
										        array (
										          0 => 
										          array (
										            'type' => 'postback',
										            'label' => 'Cari Music',
										            'data' => 'action=add&itemid=111',
													'text' => 'Ketik /music [Judul Lagu]'
										          ),
										          1 => 
										          array (
													'type' => 'postback',
													'label' => 'Cari Lirik',
													'data' => 'action=add&itemid=111',
													'text' => 'Ketik /lirik [Judul Lagu]'
										          ),
										          2 => 
										          array (
													'type' => 'postback',
													'label' => 'Cari Waktu',
													'data' => 'action=add&itemid=111',
													'text' => 'Ketik /time [Nama Kota]'
										          ),
										        ),
										      ),
										      4 => 
										      array (
										        'thumbnailImageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525181805/line/EVENT/crew/Untitled-1.jpg',
										        'title' => 'Keyword 5',
										        'text' => 'Silahkan Dipilih',
										        'actions' => 
										        array (
										          0 => 
										          array (
										            'type' => 'postback',
										            'label' => 'Cari Lokasi',
										            'data' => 'action=add&itemid=111',
													'text' => 'Ketik /lokasi [Nama Kota]'
										          ),
										          1 => 
										          array (
													'type' => 'postback',
													'label' => 'Cari Kalender',
													'data' => 'action=add&itemid=111',
													'text' => 'Ketik /kalender [Nama Kota]'
										          ),
										          2 => 
										          array (
													'type' => 'postback',
													'label' => 'Cari KosaKata',
													'data' => 'action=add&itemid=111',
													'text' => 'Ketik /def [Kata]'
										          ),
										        ),
										      ),
										      5 => 
										      array (
										        'thumbnailImageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525181805/line/EVENT/crew/Untitled-1.jpg',
										        'title' => 'Keyword 6',
										        'text' => 'Silahkan Dipilih',
										        'actions' => 
										        array (
										          0 => 
										          array (
										            'type' => 'postback',
										            'label' => 'Cari Qiblat',
										            'data' => 'action=add&itemid=111',
													'text' => 'Ketik /qiblat [Nama Kota]'
										          ),
										          1 => 
										          array (
													'type' => 'postback',
													'label' => 'Cari Jadwal Shalat',
													'data' => 'action=add&itemid=111',
													'text' => 'Ketik /shalat [Nama Kota]'
										          ),
										          2 => 
										          array (
													'type' => 'postback',
													'label' => 'Cari Cuaca',
													'data' => 'action=add&itemid=111',
													'text' => 'Ketik /cuaca [Nama Kota]'
										          ),
										        ),
										      ),
										      6 => 
										      array (
										        'thumbnailImageUrl' => 'https://res.cloudinary.com/tes5566/image/upload/v1525181805/line/EVENT/crew/Untitled-1.jpg',
										        'title' => 'Keyword 7',
										        'text' => 'Silahkan Dipilih',
										        'actions' => 
										        array (
										          0 => 
										          array (
										            'type' => 'postback',
										            'label' => 'Convert',
										            'data' => 'action=add&itemid=111',
													'text' => 'Ketik /convert [Link]'
										          ),
										          1 => 
										          array (
													'type' => 'postback',
													'label' => 'About',
													'data' => 'action=add&itemid=111',
													'text' => 'Ketik /about'
										          ),
										          2 => 
										          array (
													'type' => 'postback',
													'label' => 'Creator',
													'data' => 'action=add&itemid=111',
													'text' => 'Ketik /translate'
										          ),
										        ),
										      ),											  
										    ),
										  ),
										)					
			 
        )
    );
	}
	
}
if (isset($balas)) {
    $result = json_encode($balas);
//$result = ob_get_clean();

    file_put_contents('./balasan.json', $result);


    $client->replyMessage($balas);
}
?>
