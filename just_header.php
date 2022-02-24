<? include_once('configA.php'); ?>
 
 <style  type="text/css">

#logo img{ content:url("<? echo THIS_SITE; ?>img/logo.png"); width: 500px;}
#header.fix-search #logo img{ content:url("<? echo THIS_SITE; ?>img/logo2.png"); width: 50px;padding: 10px 5px 3px 0px;}
#icons #mico1{background:url("<? echo THIS_SITE; ?>img/icon_fb_.gif")}#icons #mico2{background:url("<? echo THIS_SITE; ?>img/icon_twitter_.gif")}#icons #mico1:hover{background:url("<? echo THIS_SITE; ?>img/icon_fb.gif")}#icons #mico2:hover{background:url("<? echo THIS_SITE; ?>img/icon_twitter.gif")}
#menus1{background:url("<? echo THIS_SITE; ?>img/menu1.png") no-repeat;}
#header.fix-search #suggest-title{ display:none; }
</style>

<script> 
	var thisSite = "<? ECHO THIS_SITE; ?>";
</script> 

<?
  include_once ('fb_component.php');
?>


<script>

var url = window.location.href;
var _404P = 'http://'+window.location.hostname+'/404.php';

UrlExists(url,_404P);
function UrlExists(url, _404P) {
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);
    http.send();
    if (http.status == 404 && url != _404P){
        window.location.replace(_404P);
    }
}
</script>

<script>
jQuery(window).on("scroll", function(e) {
  if ($(this).scrollTop() > 150) {

    document.getElementById("header").classList.add("fix-search");
  } else {
    document.getElementById("header").classList.remove("fix-search");
  }
  
});
</script>

<? 
function str_replaceF($tmv){
	$enTMV  = str_replace('?', '', $tmv[0]);
	$enTMV  = str_replace(' ', '-', $enTMV );
	$enTMV  = str_replace('  ', '-', $enTMV );
	$enTMV  = str_replace(';', '', $enTMV );
	$enTMV  = str_replace('?', '', $enTMV );
	$enTMV  = str_replace('.', '', $enTMV );
	$enTMV  = str_replace(',', '', $enTMV );
	$enTMV  = str_replace('#', '', $enTMV );
	$enTMV  = str_replace('$', '', $enTMV );
	$enTMV  = str_replace('(', '', $enTMV );
	$enTMV  = str_replace(')', '', $enTMV );
	$enTMV  = str_replace('&', '', $enTMV );
	$enTMV  = str_replace('%', '', $enTMV );
	$enTMV  = str_replace('@', '', $enTMV );
	$enTMV  = str_replace('=', '', $enTMV );
	$enTMV  = str_replace('|', '', $enTMV );
	$enTMV  = str_replace('/', '', $enTMV );
	$enTMV  = str_replace('"', '', $enTMV );
	$enTMV  = str_replace('!', '', $enTMV );
	$enTMV  = str_replace(':', '', $enTMV );
	$enTMV  = str_replace('’', '', $enTMV );
	$enTMV  = str_replace('‘', '', $enTMV );
	$enTMV  = str_replace('＆', '', $enTMV );
	$enTMV  = str_replace('　', '', $enTMV );
	$enTMV  = str_replace("'", '', $enTMV );
	$enTMV  = str_replace('--', '-', $enTMV );                       

	if(substr($enTMV , -1)=='-'){ $enTMV =	substr($enTMV , 0,-1); }
	if(substr($enTMV , 0 , 1)=='-'){ $enTMV =	substr($enTMV, 1); }
	return $enTMV;
}?>
<script src="<?echo THIS_SITE ?>js/searchdropdown.js"></script>


<div id="top-menu">
	<div class="top-menu-content" style="">
		
		<div id="menus1" onclick="menus1_over();"></div>
		<div  id="menu_mask" onclick= 'menus2_out();'></div>
		<div  style="" id="menus2" >
			<img src="<? echo THIS_SITE; ?>img/menu3_v2.png" width="598">
			
			<div id="m21">
				<ul>
				<li><div class="NF_BTN">Categories</div></li>
				<a href="<? echo THIS_SITE; ?>newsfeed" onclick="track_menu('NEWSFEED' ,'<? echo THIS_SITE; ?>newsfeed');return false;"><li class="mu_def">Newsfeed</li></a>
				<?
				foreach( $topmenu as $tmv ){
					$enTMV = str_replaceF($tmv);
					?>
					<a href="<? echo THIS_SITE; ?>category/<? echo strtolower($enTMV); ?>" onclick="track_menu('<? echo $tmv[0]; ?>' ,'<? echo THIS_SITE; ?>category/<? echo strtolower($enTMV); ?>');return false;"><li class="mu_def"><? echo $tmv[0]; ?></li></a><?
				} ?>
				</ul>
						
			</div>
			
			<div id="m22">
				<div class="NF_BTN">Themes</div>
				<ul>
			<?
			foreach( $toptheme as $thk=>$thv ){
				$enTMV = str_replaceF($thv);
			?>
				<a href="<? echo THIS_SITE; ?>theme/<? echo strtolower( $enTMV ); ?>"  onclick="track_menu('<? echo $thv[0]; ?>' ,'<? echo THIS_SITE; ?>theme/<? echo strtolower( $enTMV ); ?>');return false;"><li class="mu_def"><? echo $thv[0]; ?></li></a>
			<? } ?>
				</ul>		
			</div>
			
			<div id="mDivider"><img src="<? echo THIS_SITE; ?>img/menu-divider.png"></div>
			
			<div id="m23">
				<div class="NF_BTN">Services / Events</div><br>
				<p><a href="<? echo THIS_SITE; ?><? echo ABOUT_PAGE_LINK ?>" onclick="track_menu('ABOUT' ,'<? echo THIS_SITE; ?><? echo ABOUT_PAGE_LINK ?>');return false;">About Us</a></p>
				<p><a href="<? echo THIS_SITE; ?><? echo MOBILE_PAGE_LINK ?>" onclick="track_menu('MOBILE' ,'<? echo THIS_SITE; ?><? echo MOBILE_PAGE_LINK ?>');return false;">Mobile</a></p> 
			</div>
			
			<div id="m24">
				<div class="NF_BTN">Editions</div><br>
				<p><a href="<? echo US_WEBSITE; ?>" target="_blank"><img src="<? echo THIS_SITE; ?>img/flag_us.png"><span>English (US)</span></a></p>
				<p><a href="<? echo JP_WEBSITE; ?>" target="_blank"><img src="<? echo THIS_SITE; ?>img/flag_jp.png"><span>日本語 (JP)</span></a></p>
			</div>
			
			<div id="m25">
				<div class="NF_BTN">Social Media</div><br><br>
				<a href="<? echo FB_LINKS ?>" target="_blank"><img src="<? echo THIS_SITE; ?>img/icon_fb.png" width="28" height ="28"></a>
				<a href="<? echo TWITTER_LINKS ?>" target="_blank"><img src="<? echo THIS_SITE; ?>img/icon_twitter.png"width="28" height ="28"></a>
				<a href="<? echo GPLUS_LINKS ?>" target="_blank"><img src="<? echo THIS_SITE; ?>img/icon_gplus.png"width="28" height ="28"></a>
				<a href="<? echo YOUTUBE_LINKS ?>" target="_blank"><img src="<? echo THIS_SITE; ?>img/icon_youtube.png"width="28" height ="28"></a>
				<a href="<? echo INSTAGRAM_LINKS ?>" target="_blank"><img src="<? echo THIS_SITE; ?>img/icon_ins.png"width="28" height ="28"></a>
			</div>
			
		</div>
		
		<div class="header-search-wrap">
			<div class="dropdown header-search">
				<div class="td-drop-down-search" aria-labelledby="td-header-search-button">
					<form class="td-search-form" role="search" id="search_box_form1">
						<div class="td-head-form-search-wrap">
							<input id="search_text" type="text" required value="<? echo urldecode($kw);?>" name="s" autocomplete="off">
							<input class="wpb_button wpb_btn-inverse btn" type="submit" id="td-header-search-top" value="Search">
						</div>
					</form>
					<div id="td-aj-search"></div>
				</div>
			</div>
		</div>	
		<div class="td-search-wrapper">
			<div id="td-top-search">
				<!-- Search -->
				<div class="header-search-wrap">
					<div class="dropdown header-search">
						<a id="td-header-search-button" href="#" role="button" class="dropdown-toggle " data-toggle="dropdown">
							<img class="td-icon-search" src="<? echo THIS_SITE; ?>img/magnifying glass.png">
						</a>
					</div>
				</div>
			</div>
		</div>
		<div id="suggest-icon">
			<a href="http://suggest.tomonews.com" <!--onclick="GT('Header' , 'clk' , 'SuggestPage_PC_clk')">-->
				<img class="lightbulb" src="<? echo THIS_SITE; ?>img/TomoSuggest.png"></a>
		</div>
		<div id="tomoplay-icon" >
				<a href="<?echo THIS_SITE;?>tomoplay" title="Stream Endless Videos" onclick="track_menu('tomoplay' ,'<? echo THIS_SITE; ?>tomoplay');return false;"><div class="passive_icon"><img class="lightbulb" src="<? echo THIS_SITE; ?>img/tv_off.png?nocache=1"></div></a>
		</div>
	</div>	
</div>

			
<div id="header">
				
	<div id="logo" >
		<a href="<? echo THIS_SITE; ?>" onclick="track_menu('MAIN' ,'<? echo THIS_SITE; ?>');return false;"><img></a>
	</div>

	<div id="main_menu">
		<a href="<? echo THIS_SITE; ?>newsfeed" onclick="track_menu('NEWSFEED' ,'<? echo THIS_SITE; ?>newsfeed');return false;"><div class='btn_main_menu <? if (isset($cate_name) && (strtolower($cate_name) == 'newsfeed')){ echo 'cate_newsfeed'; } ?>' id="nf">Newsfeed</div></a>
		<? foreach( $topmenu as $tmv ){
			$enTMV = str_replaceF($tmv);?>
			<a href="<? echo THIS_SITE; ?>category/<? echo strtolower( $enTMV ); ?>"  onclick="track_menu('<? echo $tmv[0]; ?>'' ,'<? echo THIS_SITE; ?>category/<? echo strtolower( $enTMV ); ?>');return false;"><div class='btn_main_menu' <? if (isset($cate_title) && ($cate_title== strtolower( $enTMV ))){ ?> style="border-bottom: 5px solid <? echo $tmv[2];  } ?>"><? echo $tmv[0]; ?></div></a>
		<? } ?>	
	</div>
	
	<div id="suggest-title" style="float: left; margin-top: 80px;" >
				<a href="http://suggest.tomonews.com">
					<img src="<? echo THIS_SITE; ?>img/Suggest a Story header icon.png">
				</a>				
			</div>
			<script>
			$('#suggest-title').click(function() {
				document.title = "Suggest a Story";
			});
			</script>
</div>

  <div class="top">
    <div class="hero"></div>
  </div>

