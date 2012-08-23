<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
<link rel="schema.DCTERMS" href="http://purl.org/dc/terms/" />

<title><?php echo (isset($seo_title))?$seo_title:$this->config->item('company_name'); ?></title>

<?php
function convertHTMLChars($input)
{
    $patterns_htmlChars = array('/&eacute;/', '/&egrave;/', '/&ecirc;/', '/&euml;/', '/&Eacute;/', '/&Egrave;/', '/&Ecirc;/', '/&Euml;/', '/&iuml;/', '/&icirc;/', '/&Iuml;/', '/&Icirc;/', '/&agrave;/', '/&acirc;/', '/&Agrave;/', '/&Acirc;/', '/&ocirc;/', '/&ouml;/', '/&Ocirc;/', '/&Ouml;/', '/&ugrave;/', '/&uuml;/', '/&ucirc;/', '/&Ugrave;/', '/&Uuml;/', '/&Ucirc;/', '/&ccedil;/', '/&Ccedil;/');
	$replacements_htmlChars = array('é', 'è', 'ê', 'ë', 'É', 'È', 'Ê', 'Ë', 'ï', 'î', 'Ï', 'Î', 'à', 'â', 'À', 'Â', 'ô', 'ö', 'Ô', 'Ö', 'ù', 'ü', 'û', 'Ù', 'Ü', 'Û', 'ç', 'Ç');
	return preg_replace($patterns_htmlChars, $replacements_htmlChars, $input);
}
?>

<?php if(isset($meta)):?>
<?php echo convertHTMLChars(utf8_encode(html_entity_decode($meta)));?>
<?php else:?>
<meta name="Keywords" content="Shopping Cart, eCommerce, Mom To Mom">
<meta name="Description" content="Le d&eacute;p&ocirc;t-vente des petits et des grands de 0 &agrave; 12 ans">
<?php endif;?>

<meta name="publisher" content="Mom To Mom">
<meta name="copyright" content="Mom To Mom">
<meta name="robots" content="index, follow">
<meta name="revisit-after" content="2 days">
<meta property="og:type" content="company" />
<meta property="og:url" content="http://mom2mom.fr" />
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
<meta name="designer" content="flexiness">
						
<?php echo theme_css('bootstrap.min.css', true);?><?php echo "\n\r";?>
<?php echo theme_css('bootstrap-responsive.min.css', true);?><?php echo "\n\r";?>

<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Fonts/MyFontsWebfontsOrderM3527085_unhinted.css" type="text/css"/>
<!--<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/skeleton/base.css" type="text/css"/>  -->
<!--<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/skeleton/layout.css" type="text/css"/>  -->
<!--<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/skeleton/skeleton.css" type="text/css"/>  -->
<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/mom2mom_header.css" type="text/css"/>
<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/mom2mom_polaroid.css" type="text/css"/>

<?php echo theme_css('styles.css', true);?><?php echo "\n\r";?>


<?php echo theme_js('jquery-1.7.2.min.js', true);?><?php echo "\n\r";?>
<?php echo theme_js('jquery-ui-1.8.19.custom.min.js', true);?><?php echo "\n\r";?>
<?php echo theme_js('bootstrap.min.js', true);?><?php echo "\n\r";?>
<?php echo theme_js('squard.js', true);?><?php echo "\n\r";?>
<?php echo theme_js('equal_heights.js', true);?><?php echo "\n\r";?>
<?php echo theme_js('ga_tracking.js', true);?><?php echo "\n\r";?>
<?php echo theme_js('ga_social_tracking.js', true);?><?php echo "\n\r";?>

<?php
//with this I can put header data in the header instead of in the body.
if(isset($additional_header_info))
{
	echo $additional_header_info;
}
?>

<base href="<?php echo base_url(); ?>" />
</head>

<body itemscope itemtype="http://schema.org/WebPage">
	<div id="fb-root"></div>
	
	<script>
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
          js.src = "//connect.facebook.net/fr_FR/all.js";
          ref.parentNode.insertBefore(js, ref);
        }(document));
       
    </script>
	    
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">

				<!-- btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
			
				<a class="brand" href="<?php echo site_url();?>"><?php echo $this->config->item('company_name');?></a>
				
				<div class="nav-collapse">
					<ul class="nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo lang('title_catalog') ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<?php foreach($this->categories as $cat_menu):?>
								<?php if($this->config->item('language') == 'french'):?>
									<?php if($cat_menu['category']->name == 'Type' || $cat_menu['category']->name == 'Marque' || $cat_menu['category']->name == 'Taille' || $cat_menu['category']->name == 'Gamme de prix' || $cat_menu['category']->name == 'Couleur') : ?>
									<li><a href="<?php echo site_url($cat_menu['category']->slug);?>"><?php echo $cat_menu['category']->name;?></a></li>
									<?php endif; ?>
								<?php elseif($this->config->item('language') == 'english'):?>
									<?php if($cat_menu['category']->name == 'Type' || $cat_menu['category']->name == 'Brand' || $cat_menu['category']->name == 'Size' || $cat_menu['category']->name == 'Price Range' || $cat_menu['category']->name == 'Colour') : ?>
									<li><a href="<?php echo site_url($cat_menu['category']->slug);?>"><?php echo $cat_menu['category']->name;?></a></li>
									<?php endif; ?>
								<?php endif;?>
								<?php endforeach;?>
							</ul>
							
							<?php foreach($this->pages as $page):?>

								<li>
								<?php if(empty($page->content)):?>
									<a href="<?php echo $page->url;?>" <?php if($page->new_window ==1){echo 'target="_blank"';} ?>><?php echo $page->menu_title;?></a>
								<?php else:?>
									<a href="<?php echo site_url($page->slug);?>"><?php echo $page->menu_title;?></a>
								<?php endif;?>
								</li>
								
							<?php endforeach;?>
					</ul>
					
					<ul class="nav pull-right">
						
						<?php if($this->Customer_model->is_logged_in(false, false)):?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo  site_url('secure/my_account');?>"><?php echo lang('my_account')?></a></li>
									<li><a href="<?php echo  site_url('secure/my_downloads');?>"><?php echo lang('my_downloads')?></a></li>
									<li class="divider"></li>
									<li><a href="<?php echo site_url('secure/logout');?>"><?php echo lang('logout');?></a></li>
								</ul>
							</li>
						<?php else: ?>
							<li><a href="<?php echo site_url('secure/login');?>"><?php echo lang('login');?></a></li>
						<?php endif; ?>
							<li>
								<a href="<?php echo site_url('cart/view_cart');?>">
								<?php
								if ($this->go_cart->total_items()==0)
								{
									echo lang('empty_cart');
								}
								else
								{
									if($this->go_cart->total_items() > 1)
									{
										echo sprintf (lang('multiple_items'), $this->go_cart->total_items());
									}
									else
									{
										echo sprintf (lang('single_item'), $this->go_cart->total_items());
									}
								}
								?>
								</a>
							</li>
					</ul>
					
					<?php echo form_open('cart/search', 'class="navbar-search pull-right"');?>
						<input type="text" name="term" class="search-query span2" placeholder="Recherche"/>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="header_banner">
		<div style="">
			<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-top:0px;padding-bottom:10px">
				<tr>
				<td class="header_logo" align="right" valign="top" style="vertical-align: top;">
					<a href="<?php echo base_url('html');?>" target="_self" rel="home">
					<img src="http://www.mom2mom.fr/Content/Assets/Logos/mom_txt_gray_dark.png" alt="MOM" class="logo1" style="" />
					<img src="http://www.mom2mom.fr/Content/Assets/Logos/tomom_txt_gray_dark.png" alt="TO MOM" class="logo1" style="" />
					<img src="http://www.mom2mom.fr/Content/Assets/Logos/line_gray_dark.png" alt="" class="logo2" style="" />
					<img src="http://www.mom2mom.fr/Content/Assets/Logos/small_txt_fr_gray_dark.png" alt="Le dépôt-vente des petits et des grands de 0 à 12 ans" class="logo3" style="" />
					</a>
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
			<div class="header_nav_bar" style="">
			
			<?php if($this->config->item('language') == 'french'):?>
				
				<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Bébé'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | BEBE">BÉBÉ</a></div>
	
				<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Fille'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | FILLE">FILLE</a></div>
				
				<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Garçon'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | GARCON">GARÇON</a></div>
				
				<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Chaussures'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | CHAUSSURES">CHAUSSURES</a></div>
				
				<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Bric à brac'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | BRIC A BRAC">BRIC A BRAC</a></div>
			
			<?php elseif($this->config->item('language') == 'english') : ?>
			
				<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Baby'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | BEBE">BABY</a></div>
	
				<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Girl'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | FILLE">GIRL</a></div>
				
				<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Boy'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | GARCON">BOY</a></div>
				
				<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Shoes'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | CHAUSSURES">SHOES</a></div>
				
				<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Bric à brac'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | BRIC A BRAC">BRIC A BRAC</a></div>
				
			<?php endif;?>
			
			</div>
		</div>
	</div>
	<br>
	<br>
	
	<div class="container">
		<?php if(!empty($base_url_slugs_to_names) && is_array($base_url_slugs_to_names)):?>
			<div class="row">
				<div class="span12">
					<ul class="breadcrumb">
						<?php
						$url_path	= '';
						$count	 	= 1;
						foreach($base_url_slugs_to_names as $bc):
							$url_path .= '/'.$bc->slug;
							if($count == count($base_url_slugs_to_names)):?>
								<li class="active"><?php echo $bc->name;?></li>
							<?php else:?>
								<li><a href="<?php echo site_url($url_path);?>"><?php echo $bc->name;?></a></li> <span class="divider">/</span>
							<?php endif;
							$count++;
						endforeach;
						?>
 					</ul>
				</div>
			</div>
		<?php endif;?>
		
		<?php if ($this->session->flashdata('message')):?>
			<div class="alert alert-info">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $this->session->flashdata('message');?>
			</div>
		<?php endif;?>
		
		<?php if ($this->session->flashdata('error')):?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $this->session->flashdata('error');?>
			</div>
		<?php endif;?>
		
		<?php if (!empty($error)):?>
			<div class="alert alert-error">
				<a class="close" data-dismiss="alert">×</a>
				<?php echo $error;?>
			</div>
		<?php endif;?>
		
		

<?php
/*
End header.php file
*/