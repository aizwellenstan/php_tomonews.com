<?
include_once('configA.php');
include_once('api_settingA.php');
include_once('device.php');

$cate_title='NEWSFEED';//$_GET['cate_title'];
$page=isset($_GET['page']) ? (int)$_GET['page'] : '';
$debug_mode=isset($_GET['debug_mode']) ? $_GET['debug_mode'] : '';
if(!is_int($page)||$page==''||$page==0  ){
	$page=1; 
	$rightVideo = 2;
}
$cate_name = "NEWSFEED";
$thisURL=THIS_SITE.'newsfeed';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><? echo $cate_name; ?> | <? site_title() ?></title>
<meta name=viewport content="width=1200px">
	<meta name="apple-itunes-app" content="app-id=633875353">
	<meta name="google-play-app" content="app-id=com.nextmedia.gan">
	<meta name="description" content="TomoNews is your daily source for top animated news. We’ve combined animation and video footage with a snarky personality to bring you the biggest and best stories from around the world." />
	<meta name="keywords" content="news, news videos, funny news, animated news, funny videos, animation, next media animation" />
	<meta property="fb:pages" content="148740698487405" />
	<link rel="apple-touch-icon-precomposed" href=""/>
	<link rel="icon" href="<? echo THIS_SITE; ?>img/favicon.png?v=1" type="image/png" />
	<link rel="stylesheet" type="text/css" href="https://cloud.typography.com/7365156/7009372/css/fonts.css" />
	<link rel="stylesheet" href="<? echo THIS_SITE; ?>stylesheets/style.min.css">
	<link rel="stylesheet" href="<? echo THIS_SITE; ?>stylesheets/jquery-ui.min.css">

 <? include_once("head_scripts.php"); ?>
  <script src="<?echo THIS_SITE; ?>js/all.min.js"></script> 
  <script src="http://dev.imp.nextmedia.com/js/nxm_tr_v16_dev.js?t=1119" ></script>     
  <script src="<?echo THIS_SITE; ?>js/jquery-ui.min.js"></script>
  
 
<script type="application/ld+json"> 
    { 
      "@context": "http://schema.org", 
      "@type": "Webpage", 
      "headline": "<?echo $cate_name; ?>", 
      "url": "<? echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>", 
      "thumbnailUrl": "", 
      <?$cdate22=date("Y-m-d\TH:i:s") ;   $cdate22= $cdate22.'.000Z';?>
      "dateCreated": "<? echo $cdate22; ?>", 
      "articleSection": 'NEWSFEED', 
      "creator": "TOMONEWS", 
      "keywords": [<?
                 foreach($META_KW as $i => $value) 
                 {
                   if($i==0)
                   {echo '"'.$value.'"';}
                   else
                   {echo ' ,"'.$value.'"';} 
                 } 
                  ?>] 
    } 
</script>
<? include_once('ga.php'); ?>	
</head>

<style>
.ml3{width: auto;text-align:right;float:right;    padding-right: 5px;}
.ml2{ width: 100px;    float: right;    /*padding-right: 10px;*/}
.movlabel .ml1{float:left;}
.movlabel{/*width: 310px;*/width:100%;}

.mov{margin-top: 10px;}
.mov_list .mov{margin-left:0px;}

.minfo{padding:6px 0px ;font-size:16px;width: 100%;font-weight:500;}
.index.mov{height:300px;margin-top:10px;}

.index.mov > .minfo{height:85px;overflow:hidden;}
label {
    display: inline-block;
    cursor: pointer;
    position: relative;
   /* padding-left: 20px;*/
    margin-right: 15px;
    font-size: 13px;
    font-weight: bold;
    color:#333;
}/*li:nth-child(2)*/
.mce_inline_error:nth-child(2){

    position: absolute;
  top: -15px;
  font-size: 12px;
  color: #f00;
  width: 200px;
 /* left: -185px;*/
}
#fl_icon{top:75px;}
}
  .mov_list{position:relative;}
  #bk_title{   color: #292929;  font-size: 19px;  font-weight: 900;width: 100%;  height: auto;  margin: 0px 20px 15px 0px;}
#bk_title > div{padding: 2px 10px;  border-left: 3px #ff6600 solid;letter-spacing: 0px;font-size:18px;}

</style>
<script>

</script>
<body>
	<div class="wapper"> 
		<? 
		//$ad728x90=$ad_category_728x90;
		include_once('header.php'); 
		?>
	</div>
	<!--<div id="cate_lab" class="w<? echo '_newsfeed' ?>" align="center" style="text-transform:uppercase;background:#fa6604;">
			<? echo $cate_name ; ?>
	</div>-->
	<div id="vdo_wapper">
			<div id="vdo_content" style="display:table-cell;width:665px; ">
		<?
			$ad300x250_1=$ad_nf_300x250_1;
			$ad300x250_2=$ad_nf_300x250_2;
            $ad300x600_1=$ad_nf_300x600;
			$sdate='*';
			$edate=strtotime(date('Y-m-d h:i:sa'));
			$today = date('Y-m-d');
			// $getUrls=APPLICATION_FEED_URL.'KBJRKBD5PNUFPGRALF?start='.(($page - 1)* PAGE_LIMIT_NEWSFEED).'&count='.PAGE_LIMIT_NEWSFEED.'&filters[]=c_ts_publish_l:['.$sdate.'%20TO%20'.$edate.']&sort=c_ts_publish_l+desc';
			$getUrls = "https://cms.nextanimation.com.tw/api/getProgramVideos?program=TomoNews%20US&published_date=$today&counts=20&page=$page";

			$data = curl_info($getUrls, null);
			$dAry = json_decode( $data, true );
			$dAryn=$dAry['docs'];
    
        $i=0;
		$vids = array();
        foreach ($dAryn as $key => $value) {
            $cate_name='';
            $cate_id='';
			
			if($i==1){ echo '<div class="index mov" style="">'.$ad300x250_1.'</div>'; }
            if($i==6){ echo '<div class="index mov" style="">'.$ad300x250_2.'</div>'; }
			
			$NSFW_v = false;
				  $headline=$value ['c_title_s'];

					$thumbnail = $value['thumbnails'];
				 if( isset($value['u_NSFW_Tag_s']) && $value['u_NSFW_Tag_s']=='NSFW' ){  $NSFW_v = true; }
				 
				
						// $thumb = "";
				 $thumb = preg_replace('#^http?:#', '', $value['thumbnails']['url']);
						// foreach ($thumbnail as $key => $value1) {
							
						// 	if ( $value1['role']=='poster' ) {  
						// 		$thumb = $value1['url']; $thumb = preg_replace('#^http?:#', '', $thumb); break;
						// 	}elseif ( $value1['role']=='thumbnail' ){
						// 		$thumb = $value1['url']; $thumb = preg_replace('#^http?:#', '', $thumb); break;
						// 	}
						// }
						

					// $CatIndex=$value['c_category_smv'][0];
					// $cate_name=array_search( $CatIndex, $menuAry );
					//  if($cate_name=='NMA Originals')
					// 		  {
					// 			$cate_id=$menuAry['Tomo Originals'];
					// 			$cate_name='Tomo Originals';
					// 		  }
					// 		  else
					// $cate_id=$CatIndex;
             if($i==0 || $i==4 || $i==8|| $i==13 || $i==18)
             {
                $ind = $i /4;
                show_XlargeThumbnail($value['obj_id'],$cate_id,$cate_name,$headline,$value['u_Mobile_Description__Sub_head__s'],$value['c_ts_publish_l'],$thumb, $ind);
             }
             else
             {  show_SmallThumbnail_lazy($value['obj_id'],$cate_id,$cate_name,$headline,$value['c_ts_publish_l'],$thumb, $i); }
            
			array_push($vids,$value['obj_id']);
            
            $i++;
        }
		$totals=$dAry['numFound'];
         unset($dAryn);unset($i);unset($data);unset($getUrls);
		
        $thisPage=$page;
        $totalPage=ceil($totals/(20));


        if($page<=1){ $prePage=1;}else{ $prePage=$page-1; }
        if($page>=$totalPage){ $nexPage=1; }else{ $nexPage=$page+1; }

        $showLimit=3;
        $showMax=$totalPage-2;
        
        $showStart=$page-2;
        $showEnd=$page+2;
        if($page<=$showLimit){
        	$showStart=1;
        	$showEnd=5;
        }
        
        if($page>=$showMax){
        	$showEnd=$totalPage;
        	$showStart=$totalPage-4;
        	if($showStart<=1){$showStart=1;}
        }


		?>	

    <div class="pager" style="margin-bottom:50px;">
		  <div class="pager_cnt"><a href="<? echo $thisURL; ?>"><span>&lt;&lt;First</span></a></div>
		  <div class="pager_cnt"><a href="<? echo $thisURL; ?>/<? echo $prePage; ?>"><span>&lt;Previous</span></a></div>
		  <div class="pager_cnt">
			
			  <?
			  for($i=$showStart;$i<=$showEnd;$i++  ){
			  	?>
			  	<a href="<? echo $thisURL; ?>/<? echo $i; ?>"><span class="pgcount <? if($i==$page){ ?>current<? } ?> "><? echo $i; ?></span></a>
			  	<?
			  }
			  ?>
			
		  </div>
		  <div class="pager_cnt"><a href="<? echo $thisURL; ?>/<? echo $nexPage; ?>"><span>Next&gt;</span></a></div>
		  <div class="pager_cnt"><a href="<? echo $thisURL; ?>/<? echo $totalPage; ?>"><span>Last&gt;&gt;</span></a></div>
	  </div>
		
	</div>
	
	<div id="vdo_otherlist" >
		<!-- <div class="mov" style="width: 300px; height: 600px;display:block;background:#ccc;margin:0;margin-top:0px;"><? /*echo $ad300x600_1;*/?></div> -->
	   
			<?
				  ////Breaking News
			include_once('side_thumb_apiAO.php');
            $PAGE = 'Newsfeed';
            $thumaType = 'RR_topicthumbs_clk';
			
			insert_breakingNews(3);
                
                 $thumaType = 'RR_YMAL_clk';
                   $thumaTypejs= $thumaType;
                   $PAGEjs =  $PAGE;
                  	$sdate=strtotime('-60 day',time());//Uncomment when you get full data from anvato
					$paging = isset($rightVideo) ? 2 :  rand(1,3) ;
					$today = date('Y-m-d');
					$getUrls5 = APPLICATION_FEED_URL.'KBJRKBD5PNUFPGRALF?start='.$paging.'&count=100&filters[]=c_ts_publish_l:['.$sdate.'%20TO%20'.$edate.']';
					$getUrls5 = "https://cms.nextanimation.com.tw/api/getProgramVideos?program=TomoNews%20US&published_date=$today&counts=5&page=0";

					?><div class="mov" style="width: 300px; height: 600px;background:#ccc;margin:0;margin-top:5px;margin-bottom:5px;"><? echo $ad300x600_1;?></div><?
					echo '<div id="ymal_list" class="mov_list" >'; 
					echo '<div class="right-side-title">YOU MAY ALSO LIKE</div>';
                    echo '</div>';   
                ////JOIN DISCUSSION*/
                ?>
				
<script type="text/javascript">
  window._taboola = window._taboola || [];
  _taboola.push({
    mode: 'alternating-thumbnails-c',
    container: 'taboola-right-rail-category-thumbnails',
    placement: 'Right Rail Newsfeed Thumbnails',
    target_type: 'mix'
  });
</script>

        </div>	
</div>
<div id="dialog" title="">
  <p></p>
</div>
	<? include_once('footer.php'); ?>
    <script src="<? echo THIS_SITE; ?>js/ymalO.js?nochche=1022" defer></script>
    <script src="<? echo THIS_SITE; ?>js/index.min.js?nochche=1022"></script>  
<script type='text/javascript'>
 var _GLOBAL={};
 _GLOBAL.base ='<? echo THIS_SITE; ?>';
 _GLOBAL.NSFW  =0;
 _GLOBAL.page = "NEWSFEED"

var cnf_YMAL={};
cnf_YMAL.getUrls5 = <?echo json_encode($getUrls5); ?>;
cnf_YMAL.vids = <?echo json_encode($vids); ?>;
cnf_YMAL.PAGE = '<?echo $PAGEjs;?>';
cnf_YMAL.thumaType = '<?echo $thumaTypejs;?>';
cnf_YMAL.PAGING = '12';

function _cb2(){
  
  //console.log("cb");
  if( $('.videoCube').children().length == 0 )
  {setTimeout(_cb2 , 1000);}
  else  update_css2();
}
function update_css2(){
  $('.videoCube').css("margin-bottom" , 17)
}
</script>


</body>
</html>