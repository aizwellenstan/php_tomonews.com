<?
	//API key & alias
// define('APPLICATION_ALIAS','NMTomoUS-universal-flash');
define('APPLICATION_URL','http://nextmedia-mcp.anvato.net/api?');
define('APPLICATION_FEED_URL','http://api.nm.anvato.net/v2/feed/');
define('APPLICATION_MEDIA_URL','http://api.nm.anvato.net');
define('APPLICATION_PRIVATE','3B80540E925B4BB6B5AE7A363AA551C8');
define('APPLICATION_PUBLIC','8353B77A240044B1BA565E0393C18E88');
	//movideo token will expire after 3600 sec .
	//so we make our session keep 40 mins (40m*60s=2400s) . 
define('SESSION_LIFETIME',2400); 
define('THIS_SITE','http://us.tomonews.com/'); 
define('VIDEO_PATH','http://video-pdu.us.tomonews.net/encoded-586/media/');


/// start 	
	$freq = 'daily';
	$priority = 0.8;
	$edate=strtotime(date('Y-m-d'));
	$sdate=strtotime(date('Y-m-d', strtotime('-1 days')));
	$fileName = 'sitemap_'.date('Y').date('m').'.xml';
	$news_file =  'sitemap_video.xml';
	$save_path = 'videoSitemaps/';
	echo "Fetching stories from $edate";
	
    //$d='&creationDateOperator=range&creationDate='.$sdate.'T00:00:00,'.$edate.'T23:50:59';
    //$getUrls2=APPLICATION_URL.'media/search?omitFields=creationDate,lastModifiedDate,copyright,isAdvertisement,ratio,creator,tagProfileId,imageFilename,mediaFileExists,syndicated,mediaSchedules,displayStatus,syndicatedPartners,length,filename,status,defaultImage,mediaType,description,cuePointsExist,payWalls,externalAuthentication,tagProfileId,client,imagePath,mediaPlays,additionalImages&tags='.'["keyword:name=*"]'.$d.'&paged=false&page=0&pageSize='.$totals.'&orderDesc=true&orderBy=creationdate&output=json&token='.$_SESSION['token'].' ';
    $getUrls2 = APPLICATION_FEED_URL.'KBJRKBD5PNUFPGRALF?filters[]=c_ts_publish_l:['.$sdate.'%20TO%20'.$edate.']&media_filters[]=video/mp4'; 
	$ww=curl_info($getUrls2, null);
    $dAry22=json_decode($ww, true);
    $dAryn2=$dAry22['docs'];
	
	if(file_exists($save_path.$fileName)){
		
		generate_xml($dAryn2, $save_path, $fileName);
		
	}else{
		
		generate_new_xml($dAryn2, $save_path, $fileName, $news_file);
		//file_put_contents($save_path.$fileName, $ww);
	}
	
	echo " Done!!!";

function generate_new_xml($dAryn2, $save_path, $fileName, $news_file){
	$xml_doc = new DOMDocument();
		$xml_doc->formatOutput = true;
		$urlset = $xml_doc->createElement('urlset');
		$urlsetA = $xml_doc->createAttribute('xmlns');
		$urlsetA -> value = 'http://www.sitemaps.org/schemas/sitemap/0.9';
		$urlset->appendChild($urlsetA);
		$urlset = $xml_doc->appendChild($urlset);
		$urlsetA = $xml_doc->createAttribute('xmlns:video');
		$urlsetA -> value = 'http://www.google.com/schemas/sitemap-video/1.1';
		$urlset->appendChild($urlsetA);
		$urlset = $xml_doc->appendChild($urlset);
	
		foreach ($dAryn2 as $key => $value) {
			
			$Keywords_kwarr = array();
			$Keywords_txt = '';
			
			$duration = $value['info']['duration'];
			$urlN = THIS_SITE.urlencode(str_replace(' ', '-', remove_punc($value['c_title_s']))).'-'.$value['obj_id']; 

			$Keywords_kwarr[] =$value['c_tag_smv'];
			
			$mobDes= $value['c_description_s'];
			
			$url = $xml_doc->createElement('url');
			$url = $urlset->appendChild($url);
			
			$loc = $xml_doc->createElement('loc');
			$loc = $url->appendChild($loc);
			$locCont = $xml_doc->createTextNode($urlN);
			$locCont = $loc->appendChild($locCont);
			
			$video = $xml_doc->createElement('video:video');
			$video = $url->appendChild($video);
			
			$videoTitle = $xml_doc->createElement('video:title');
			$videoTitle = $video->appendChild($videoTitle);
			$videoTitleCont = $xml_doc->createCDATASection($value['c_title_s'].' '.$value['obj_id']);
			$videoTitleCont = $videoTitle->appendChild($videoTitleCont);
			
			$videoDesc = $xml_doc->createElement('video:description');
			$videoDesc = $video->appendChild($videoDesc);
			$videoDescCont = $xml_doc->createCDATASection(str_replace('"','',strip_tags($mobDes)).' '.$value['obj_id']);
			$videoDescCont = $videoDesc->appendChild($videoDescCont);
			
			$videoloc = $xml_doc->createElement('video:content_loc');
			$videoloc = $video->appendChild($videoloc);
			$videoLocCont = $xml_doc->createTextNode(APPLICATION_MEDIA_URL.$value['media_url'].'?fmt=mp4');
			$videoLocCont = $videoloc->appendChild($videoLocCont);
			
			$thumbnail = $value['thumbnails'];		
				 
			foreach ($thumbnail as $key => $value1) {
				if ( $value1['role']=='poster' ) {  $thumb = $value1['url']; }
			}
						
			$videoThumb = $xml_doc->createElement('video:thumbnail_loc');
			$videoThumb = $video->appendChild($videoThumb);
			$videoThumbCont = $xml_doc->createTextNode($thumb);
			$videoThumbCont = $videoThumb->appendChild($videoThumbCont);
			
			/*$_date = $dAry['docs'][0]['c_ts_publish_l'];
$cdate=date('Y/m/d',$_date);
$cdate22=date("Y-m-d\TH:i:s",$_date) ;*/
			
			$videoPubDate = $xml_doc->createElement('video:publication_date');
			$videoPubDate = $video->appendChild($videoPubDate);
			$videoPubDateCont = $xml_doc->createTextNode(date('c',$value['c_ts_publish_l']));
			$videoPubDateCont = $videoPubDate->appendChild($videoPubDateCont);
			
			$videoDuration = $xml_doc->createElement('video:duration');
			$videoDuration = $video->appendChild($videoDuration);
			$videoDurCont = $xml_doc->createTextNode($duration);
			$videoDurCont = $videoDuration->appendChild($videoDurCont);

			foreach ($Keywords_kwarr[0] as $key1 => $kw) {
				$videoKw = $xml_doc->createElement('video:tag');
				$videoKw = $video->appendChild($videoKw);
				$videoKwCont = $xml_doc->createCDATASection($kw);
				$videoKwCont = $videoKw->appendChild($videoKwCont);
			}
			
		}
		$xml_doc->save($save_path.$fileName);
		
		//add new month to main sitemap
		$xml_root = new DOMDocument();
		$xml_root -> load($save_path.$news_file);
		$f = $xml_root->createDocumentFragment();
		$f -> appendXML("\n    <sitemap>\n      <loc>".THIS_SITE."$save_path$fileName</loc>\n    </sitemap>\n");
		$xml_root->documentElement->appendChild($f);
		$xml_root->save($save_path.$news_file);

}
	
function generate_xml($dAryn2, $save_path, $fileName){
	$xml_doc = new DOMDocument();
	$xml_doc->preserveWhiteSpace = false;
	$xml_doc -> formatOutput = true;
	$xml_doc -> load($save_path.$fileName);
	$urlset =  $xml_doc -> getElementsByTagName("urlset")->item(0); 
	
	foreach ($dAryn2 as $key => $value) {
			
			$Keywords_kwarr = array();
			$Keywords_txt = '';
			
			$duration = $value['info']['duration'];
			$urlN = THIS_SITE.urlencode(str_replace(' ', '-', remove_punc($value['c_title_s']))).'-'.$value['obj_id']; 
			
			$Keywords_kwarr[] =$value['c_tag_smv'];
			
			$mobDes= $value['c_description_s'];
			
			$url = $xml_doc->createElement('url');
			$url = $urlset->appendChild($url);
			
			$loc = $xml_doc->createElement('loc');
			$loc = $url->appendChild($loc);
			$locCont = $xml_doc->createTextNode($urlN);
			$locCont = $loc->appendChild($locCont);
			
			$video = $xml_doc->createElement('video:video');
			$video = $url->appendChild($video);
			
			$videoTitle = $xml_doc->createElement('video:title');
			$videoTitle = $video->appendChild($videoTitle);
			$videoTitleCont = $xml_doc->createCDATASection($value['c_title_s'].' '.$value['obj_id']);
			$videoTitleCont = $videoTitle->appendChild($videoTitleCont);
			
			$videoDesc = $xml_doc->createElement('video:description');
			$videoDesc = $video->appendChild($videoDesc);
			$videoDescCont = $xml_doc->createCDATASection(str_replace('"','',strip_tags($mobDes)).' '.$value['obj_id']);
			$videoDescCont = $videoDesc->appendChild($videoDescCont);
			
			$videoloc = $xml_doc->createElement('video:content_loc');
			$videoloc = $video->appendChild($videoloc);
			$videoLocCont = $xml_doc->createTextNode(APPLICATION_MEDIA_URL.$value['media_url'].'?fmt=mp4');
			$videoLocCont = $videoloc->appendChild($videoLocCont);
			
			$thumbnail = $value['thumbnails'];		
				 
			foreach ($thumbnail as $key => $value1) {
				if ( $value1['role']=='poster' ) {  $thumb = $value1['url']; }
			}
			
			$videoThumb = $xml_doc->createElement('video:thumbnail_loc');
			$videoThumb = $video->appendChild($videoThumb);
			$videoThumbCont = $xml_doc->createTextNode($thumb);
			$videoThumbCont = $videoThumb->appendChild($videoThumbCont);
			
			/*$player_loc= PLAYER_LOC.$value['id'];
			$videoPlayer = $xml_doc->createElement('video:player_loc');
			$videoPlayer = $video->appendChild($videoPlayer);
			$videoPlayerCont = $xml_doc->createCDATASection($player_loc);
			$videoPlayerCont = $videoPlayer->appendChild($videoPlayerCont);*/
			
			$videoPubDate = $xml_doc->createElement('video:publication_date');
			$videoPubDate = $video->appendChild($videoPubDate);
			$videoPubDateCont = $xml_doc->createTextNode(date('c',time()));
			$videoPubDateCont = $videoPubDate->appendChild($videoPubDateCont);
			
			$videoDuration = $xml_doc->createElement('video:duration');
			$videoDuration = $video->appendChild($videoDuration);
			$videoDurCont = $xml_doc->createTextNode(round($duration));
			$videoDurCont = $videoDuration->appendChild($videoDurCont);

			foreach ($Keywords_kwarr[0] as $key1 => $kw) {
				$videoKw = $xml_doc->createElement('video:tag');
				$videoKw = $video->appendChild($videoKw);
				$videoKwCont = $xml_doc->createCDATASection($kw);
				$videoKwCont = $videoKw->appendChild($videoKwCont);
			}
			
		}
		$xml_doc->save($save_path.$fileName);
}

function curl_info($url, $req) { //anvato
    $ch = curl_init($url);
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	
	if ($req != ''){
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, array ( "Content-Type: application/xml" ) );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $req );
	}

	$data = curl_exec($ch);
	curl_close($ch);
    unset($ch);unset($url);
	
    return $data;
}

function remove_punc($x){
	$x=str_replace('-', '-', $x);
	$x=str_replace(' ', '-', $x);
	$x=str_replace(';', '-', $x);
	$x=str_replace('?', '-', $x);
	$x=str_replace('.', '-', $x);
	$x=str_replace(',', '-', $x);
	$x=str_replace('#', '-', $x);
	$x=str_replace('$', '-', $x);
	$x=str_replace('(', '-', $x);
	$x=str_replace(')', '-', $x);
	$x=str_replace('&', '-', $x);
	$x=str_replace('%', '-', $x);
	$x=str_replace('#', '-', $x);
	$x=str_replace('@', '-', $x);	
	$x=str_replace('=', '-', $x);
	$x=str_replace('|', '-', $x);
	$x=str_replace('/', '-', $x);
	$x=str_replace('"', '-', $x);
	$x=str_replace('|', '-', $x);
	$x=str_replace('!', '-', $x);
	$x=str_replace(':', '-', $x);
	$x=str_replace('’', '-', $x);
	$x=str_replace('‘', '-', $x);
	$x=str_replace("'", '-', $x);
	$x=str_replace('--', '-', $x);
	$x=strtolower($x);
	return $x;
}



?>