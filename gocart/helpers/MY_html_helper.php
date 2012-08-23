<?php

function load_jquery($front = false)
{
	$CI =& get_instance();
	$assets_location = $CI->config->item('assets_folder');
	
	//jquery & jquery ui files & path
	//$path			= 'js/jquery';
	$path			= $assets_location.'js/jquery';
	
	/*
	$jquery			= 'jquery-1.5.1.min.js';
	$jquery_ui		= 'jquery-ui-1.8.11.custom.min.js';
	$jquery_ui_css	= 'jquery-ui-1.8.11.custom.css';
	*/
	
	$jquery			= 'jquery-1.7.2.min.js';
	$jquery_ui		= 'jquery-ui-1.8.19.custom.min.js';
	$jquery_ui_css	= 'jquery-ui-1.8.16.custom.css';
	
	//load jquery ui css
	
	if($front)
	{
		echo link_tag($path.'/theme/'.$front.'/'.$jquery_ui_css);
	}
	else
	{
		echo link_tag($path.'/theme/gocart/'.$jquery_ui_css);
	}
	echo "\n\r";
	
	//load scripts
	/*
	echo load_script($path.'/'.$jquery);
	echo "\n\r";
	echo load_script($path.'/'.$jquery_ui);
	echo "\n\r";
	*/
	
	//colorbox
	$path			= $path.'/colorbox';
	$colorbox		= 'jquery.colorbox-min.js';
	$colorbox_css	= 'colorbox.css';
	
	echo link_tag($path.'/'.$colorbox_css);
	echo "\n\r";
	echo load_script($path.'/'.$colorbox);
	echo "\n\r";
}

function load_script($path)
{
	return '<script type="text/javascript" src="/'.$path.'"></script>';
}


function html_helper_mom2mom_meta_pt1()
{
	$CI =& get_instance();
	
	if($CI->config->item('language') == 'french')
	{
		echo '<!--[if lt IE 7 ]><html xmlns="http://www.w3.org/1999/xhtml" class="ie ie6" lang="fr"> <![endif]-->' . "\n\r";
		echo '<!--[if IE 7 ]><html xmlns="http://www.w3.org/1999/xhtml" class="ie ie7" lang="fr"> <![endif]-->' . "\n\r";
		echo '<!--[if IE 8 ]><html xmlns="http://www.w3.org/1999/xhtml" class="ie ie8" lang="fr"> <![endif]-->' . "\n\r";
		echo '<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="fr"> <!--<![endif]-->' . "\n\r";
	}
	elseif($CI->config->item('language') == 'english')
	{			
		echo '<!--[if lt IE 7 ]><html xmlns="http://www.w3.org/1999/xhtml" class="ie ie6" lang="en"> <![endif]-->' . "\n\r";
		echo '<!--[if IE 7 ]><html xmlns="http://www.w3.org/1999/xhtml" class="ie ie7" lang="en"> <![endif]-->' . "\n\r";
		echo '<!--[if IE 8 ]><html xmlns="http://www.w3.org/1999/xhtml" class="ie ie8" lang="en"> <![endif]-->' . "\n\r";
		echo '<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="en"> <!--<![endif]-->' . "\n\r";
	}
}			

function html_helper_mom2mom_meta_pt2()
{
	echo '<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />' . "\n\r";
	echo '<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />' . "\n\r";
}


function html_helper_mom2mom_meta_pt3($meta_info)
{
	echo convertHTMLChars(utf8_encode(html_entity_decode($meta_info)));
	
	$CI =& get_instance();
	
	if($CI->config->item('language') == 'french')
	{
		echo 	'<meta name="publisher" content="Mom To Mom">
<meta name="copyright" content="Mom To Mom">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="2 days">
<meta property="og:type" content="company" />
<meta property="og:url" content="http://mom2mom.fr/html" />
<meta property="og:image" content="http://mom2mom.fr/Content/Assets/Logos/logo_lg.png" />
<meta property="og:site_name" content="Mom To Mom" />
<meta property="fb:admins" content="707122929" />
<link rel="alternate" type="application/rss+xml" href="http://mom2mom.fr/articles_mom2mom_fr.php" title="RSS pour Mom To Mom" />
<link rel="glossary" type="application/xml" href="http://mom2mom.fr/Content/Assets/Navigation_menu_xml/navigation_menu2.xml" title="XML navigation menu pour Mom To Mom" />
<link rel="alternate" type="application/vnd.google-earth.kml+xml" href="http://mom2mom.fr/MomToMom.kml" />
<link rel="alternate" type="application/rdf+xml" title="Geo" href="http://mom2mom.fr/Geo.rdf" />
<link rel="shortcut icon" href="http://www.mom2mom.fr/Content/Assets/Logos/favicon.ico" type="image/x-icon" />
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=480" />
<meta name="geo.position" content="48.862700;2.365418">
<meta name="geo.country" content="FR">
<meta name="geo.region" content="FR-75">
<meta name="dcterms.language" content="fr">
<meta name="dcterms.type" content="Service">
<meta name="dcterms.format" content="text/html">
<meta name="dcterms.audience" content="all">
<meta name="dcterms.rights" content="Mom To Mom">
<meta name="dcterms.publisher" content="Mom To Mom">
<meta name="designer" content="flexiness">' . "\n\r";
	}
	elseif ($CI->config->item('language') == 'english')
	{
		echo 	'<meta name="publisher" content="Mom To Mom">
<meta name="copyright" content="Mom To Mom">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="2 days">
<meta property="og:type" content="company" />
<meta property="og:url" content="http://mom2mom.fr/en/html" />
<meta property="og:image" content="http://mom2mom.fr/Content/Assets/Logos/logo_lg.png" />
<meta property="og:site_name" content="Mom To Mom" />
<meta property="fb:admins" content="707122929" />
<link rel="alternate" type="application/rss+xml" href="http://mom2mom.fr/articles_mom2mom_fr.php" title="RSS pour Mom To Mom" />
<link rel="glossary" type="application/xml" href="http://mom2mom.fr/Content/Assets/Navigation_menu_xml/navigation_menu2.xml" title="XML navigation menu pour Mom To Mom" />
<link rel="alternate" type="application/vnd.google-earth.kml+xml" href="http://mom2mom.fr/MomToMom.kml" />
<link rel="alternate" type="application/rdf+xml" title="Geo" href="http://mom2mom.fr/Geo.rdf" />
<link rel="shortcut icon" href="http://www.mom2mom.fr/Content/Assets/Logos/favicon.ico" type="image/x-icon" />
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=480" />
<meta name="geo.position" content="48.862700;2.365418">
<meta name="geo.country" content="FR">
<meta name="geo.region" content="FR-75">
<meta name="dcterms.language" content="fr">
<meta name="dcterms.type" content="Service">
<meta name="dcterms.format" content="text/html">
<meta name="dcterms.audience" content="all">
<meta name="dcterms.rights" content="Mom To Mom">
<meta name="dcterms.publisher" content="Mom To Mom">
<meta name="designer" content="flexiness">' . "\n\r";
	}
}

function html_helper_mom2mom_css_pt1()
{
	echo '<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Fonts/MyFontsWebfontsOrderM3527085_unhinted.css" type="text/css"/>' . "\n\r";
	echo '<!--<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/skeleton/base.css" type="text/css"/>  -->' . "\n\r";
	echo '<!--<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/skeleton/layout.css" type="text/css"/>  -->' . "\n\r";
	echo '<!--<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/skeleton/skeleton.css" type="text/css"/>  -->' . "\n\r";
	echo '<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/mom2mom_header.css" type="text/css"/>' . "\n\r";
	echo '<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/mom2mom_polaroid.css" type="text/css"/>' . "\n\r";
}


function html_helper_fb_javascript()
{
	echo '<div id="fb-root"></div>' . "\n\r";
	
	$CI =& get_instance();
	
	if($CI->config->item('language') == 'french')
	{
		echo "		<script>
      	window.fbAsyncInit = function() {
          FB.init({
        	  appId      : '214377121972595',
	          status     : true, 
	          cookie     : true,
	          xfbml      : true,
	          oauth      : true
          });

          _ga.trackFacebook(); //Google Analytics tracking

        };

        // Load the Facebook SDK Asynchronously
        (function(d){
          var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
          if (d.getElementById(id)) {return;}
          js = d.createElement('script'); js.id = id; js.async = true;
          js.src = '//connect.facebook.net/fr_FR/all.js';
          ref.parentNode.insertBefore(js, ref);
        }(document));   
		</script>" . "\n\r";
	}
	elseif($CI->config->item('language') == 'english')
	{			
		echo "		<script>
      	window.fbAsyncInit = function() {
          FB.init({
        	  appId      : '214377121972595',
	          status     : true, 
	          cookie     : true,
	          xfbml      : true,
	          oauth      : true
          });

          _ga.trackFacebook(); //Google Analytics tracking

        };

        // Load the Facebook SDK Asynchronously
        (function(d){
          var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
          if (d.getElementById(id)) {return;}
          js = d.createElement('script'); js.id = id; js.async = true;
          js.src = '//connect.facebook.net/en_US/all.js';
          ref.parentNode.insertBefore(js, ref);
        }(document));   
		</script>" . "\n\r";
	}
}

function html_helper_mom2mom_header_menu($header_urls)
{
	$CI =& get_instance();
	
	echo '<div class="header_banner">
		<div style="">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-top:0px;padding-bottom:10px">
				<tr>
				<td class="header_logo" align="right" valign="top" style="vertical-align: top;">' . "\n";
	if($CI->config->item('language') == 'french')
	{	
		echo '				<a href="' . base_url('html') . '" target="_self" rel="home">' . "\n";
	}
	elseif($CI->config->item('language') == 'english')
	{
		echo '				<a href="' . base_url('en/html') . '" target="_self" rel="home">' . "\n";
	}
	echo '					<img src="http://www.mom2mom.fr/Content/Assets/Logos/mom_txt_gray_dark.png" alt="MOM" class="logo1" style="" />
					<img src="http://www.mom2mom.fr/Content/Assets/Logos/tomom_txt_gray_dark.png" alt="TO MOM" class="logo1" style="" />
					<img src="http://www.mom2mom.fr/Content/Assets/Logos/line_gray_dark.png" alt="" class="logo2" style="" />' . "\n";
	if($CI->config->item('language') == 'french')
	{	
		echo '					<img src="http://www.mom2mom.fr/Content/Assets/Logos/small_txt_fr_gray_dark.png" alt="Le dépôt-vente des petits et des grands de 0 à 12 ans" class="logo3" style="" />' . "\n\r";
	}
	elseif($CI->config->item('language') == 'english')
	{
		echo '					<img src="http://www.mom2mom.fr/Content/Assets/Logos/small_txt_en_gray_dark.png" alt="The clothing discount store for all children 0 to 12 years" class="logo3" style="" />' . "\n\r";
	}
	echo '				</a>
				</td>
				<td align="left" valign="top" style="vertical-align: top;">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr>
					<td align="center" valign="top" style="margin-left:auto;margin-right:auto;">
					<img src="http://www.mom2mom.fr/Content/Assets/GraphicElements/banner.png" alt="" class="header_clothes_line" />
					</td>
					</tr>
					</table>
				</td>
				</tr>
			</table>
		</div>
		<div>
			<div class="header_nav_bar" style="">' . "\n\r";
	if($CI->config->item('language') == 'french')
	{	
		foreach($header_urls as $header) 
		{
			echo ($header->name == 'Bébé') ? '				<div class="header_nav_links Populaire"><a href="' . site_url($header->slug) . '" title="Mom To Mom | Boutique eCommerce | BEBE">BÉBÉ</a></div>' . "\n\r" : '';
			echo ($header->name == 'Fille') ? '				<div class="header_nav_links Populaire"><a href="' . site_url($header->slug) . '" title="Mom To Mom | Boutique eCommerce | FILLE">FILLE</a></div>' . "\n\r" : '';
			echo ($header->name == 'Garçon') ? '				<div class="header_nav_links Populaire"><a href="' . site_url($header->slug) . '" title="Mom To Mom | Boutique eCommerce | GARCON">GARÇON</a></div>' . "\n\r" : '';
			echo ($header->name == 'Chaussures') ? '				<div class="header_nav_links Populaire"><a href="' . site_url($header->slug) . '" title="Mom To Mom | Boutique eCommerce | CHAUSSURES">CHAUSSURES</a></div>' . "\n\r" : '';
			echo ($header->name == 'Bric à brac') ? '				<div class="header_nav_links Populaire"><a href="' . site_url($header->slug) . '" title="Mom To Mom | Boutique eCommerce | BRIC A BRAC">BRIC A BRAC</a></div>' . "\n\r" : '';
		}
	}
	elseif($CI->config->item('language') == 'english')
	{
		foreach($header_urls as $header) 
		{
			echo ($header->name == 'Baby') ? '				<div class="header_nav_links Populaire"><a href="' . site_url($header->slug) . '" title="Mom To Mom | Boutique eCommerce | BABY">BABY</a></div>' . "\n\r" : '';
			echo ($header->name == 'Girl') ? '				<div class="header_nav_links Populaire"><a href="' . site_url($header->slug) . '" title="Mom To Mom | Boutique eCommerce | GIRL">GIRL</a></div>' . "\n\r" : '';
			echo ($header->name == 'Boy') ? '				<div class="header_nav_links Populaire"><a href="' . site_url($header->slug) . '" title="Mom To Mom | Boutique eCommerce | BOY">BOY</a></div>' . "\n\r" : '';
			echo ($header->name == 'Shoes') ? '				<div class="header_nav_links Populaire"><a href="' . site_url($header->slug) . '" title="Mom To Mom | Boutique eCommerce | SHOES">SHOES</a></div>' . "\n\r" : '';
			echo ($header->name == 'Bric à brac') ? '				<div class="header_nav_links Populaire"><a href="' . site_url($header->slug) . '" title="Mom To Mom | Boutique eCommerce | BRIC A BRAC">BRIC A BRAC</a></div>' . "\n\r" : '';
		}
	}		
	echo '			</div>
		</div>
	</div>
	<br>
	<br>' . "\n\r";
}

function convertHTMLChars($input)
{
    $patterns_htmlChars = array('/&eacute;/', '/&egrave;/', '/&ecirc;/', '/&euml;/', '/&Eacute;/', '/&Egrave;/', '/&Ecirc;/', '/&Euml;/', '/&iuml;/', '/&icirc;/', '/&Iuml;/', '/&Icirc;/', '/&agrave;/', '/&acirc;/', '/&Agrave;/', '/&Acirc;/', '/&ocirc;/', '/&ouml;/', '/&Ocirc;/', '/&Ouml;/', '/&ugrave;/', '/&uuml;/', '/&ucirc;/', '/&Ugrave;/', '/&Uuml;/', '/&Ucirc;/', '/&ccedil;/', '/&Ccedil;/');
	$replacements_htmlChars = array('é', 'è', 'ê', 'ë', 'É', 'È', 'Ê', 'Ë', 'ï', 'î', 'Ï', 'Î', 'à', 'â', 'À', 'Â', 'ô', 'ö', 'Ô', 'Ö', 'ù', 'ü', 'û', 'Ù', 'Ü', 'Û', 'ç', 'Ç');
	return preg_replace($patterns_htmlChars, $replacements_htmlChars, $input);
}