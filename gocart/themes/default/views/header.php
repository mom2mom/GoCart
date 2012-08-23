<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo (isset($seo_title))?$seo_title:$this->config->item('company_name'); ?></title>


<?php if(isset($meta)):?>
	<?php echo $meta;?>
<?php else:?>
<meta name="Keywords" content="Shopping Cart, eCommerce, Code Igniter">
<meta name="Description" content="Go Cart is an open source shopping cart built on the Code Igniter framework">
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

<link href="<?php echo base_url($this->config->item('assets_folder').'themes/'.$this->config->item('theme').'/css/styles.css');?>" type="text/css" rel="stylesheet"/>

<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Fonts/MyFontsWebfontsOrderM3527085_unhinted.css" type="text/css"/>
<!--<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/skeleton/base.css" type="text/css"/>  -->
<!--<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/skeleton/layout.css" type="text/css"/>  -->
<!--<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/skeleton/skeleton.css" type="text/css"/>  -->
<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/mom2mom_header.css" type="text/css"/>
<link rel="stylesheet" href="http://mom2mom.fr/Content/Assets/Stylesheets/mom2mom_polaroid.css" type="text/css"/> 

<link type="text/css" href="<?php echo base_url($this->config->item('assets_folder').'js/jquery/theme/smoothness/jquery-ui-1.8.16.custom.css');?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url($this->config->item('assets_folder').'js/jquery/jquery-1.7.1.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url($this->config->item('assets_folder').'js/jquery/jquery-ui-1.8.16.custom.min.js');?>"></script>

<link type="text/css" href="<?php echo base_url($this->config->item('assets_folder').'js/jquery/colorbox/colorbox.css');?>" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url($this->config->item('assets_folder').'js/jquery/colorbox/jquery.colorbox-min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url($this->config->item('assets_folder').'js/jquery/equal_heights.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url($this->config->item('assets_folder').'js/tiny_mce_init.js');?>"></script>

<script type="text/javascript"> 
 
    $(document).ready(function(){ 	
		$('input:submit, input:button, button, .btn').button();
		$('input:text, input:password').addClass('input');
    }); 
 
</script>


<script type="text/javascript"> 
var $buoop = {} 
$buoop.ol = window.onload; 
window.onload=function(){ 
 try {if ($buoop.ol) $buoop.ol();}catch (e) {} 
 var e = document.createElement("script"); 
 e.setAttribute("type", "text/javascript"); 
 e.setAttribute("src", "https://browser-update.org/update.js"); 
 document.body.appendChild(e); 
} 
</script> 


<?php
//with this I can put header data in the header instead of in the body.
if(isset($additional_header_info))
{
	echo $additional_header_info;
}

?>
</head>
<body>
<div id="top_menu_container" class="full_wrap">
	<div class="wide_wrap">
		<ul id="top_menu" class="right">	
		<?php
		function page_loop($pages, $layer, $first=false)
		{
			if($first)
			{
				echo '<ul'.$first.'>';
			}
			

			foreach($pages as $page):?>

				<li>
				<?php if(empty($page->content)):?>
					<a href="<?php echo $page->url;?>" <?php if($page->new_window ==1){echo 'target="_blank"';} ?>><?php echo $page->menu_title;?></a>
				<?php else:?>
					<a href="<?php echo site_url($page->slug);?>"><?php echo $page->menu_title;?></a>
				<?php endif;
				if($layer == 1)
				{
					$next = $layer+1;
					if(!empty($page->children))
					{
						page_loop($page->children, $next, ' class="first"');
					}
				}
				else
				{
					$next = $layer+1;
					if(!empty($page->children))
					{
						page_loop($page->children, $next, ' class="nav"');
					}
				}?>
				</li>
			<?php	
			endforeach;
			if($first)
			{
				echo '</ul>';
			}
			
		}
		page_loop($this->pages, 1);
		
		?>
		
		<?php if($this->Customer_model->is_logged_in(false, false)):?>
			<li class="bold begin_user_menu"><a href="<?php echo site_url('secure/logout');?>"><?php echo lang('logout');?></a></li>
			<li class="bold"><a href="<?php echo  site_url('secure/my_account');?>"><?php echo lang('my_account')?></a></li>
			<li class="bold"><a href="<?php echo  site_url('secure/my_downloads');?>"><?php echo lang('my_downloads')?></a></li>
		<?php else: ?>
			<li class="bold begin_user_menu"><a href="<?php echo site_url('secure/login');?>"><?php echo lang('login');?></a></li>
		<?php endif; ?>
		<li class="bold">
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
	</div>
	
	<div class="clear"></div>
</div>

<div class="full_wrap">
	<div id="header" class="wide_wrap">

		<div id="search_form" class="right">
			<?php echo form_open('cart/search');?>
				<input type="text" name="term"/>
				<button type="submit"><?php echo lang('form_search');?></button>
			</form>
		</div>
		
		<!--
		<a href="<?php echo base_url();?>">
			<img src="<?php echo base_url($this->config->item('assets_folder').'images/logo.png');?>" alt="<?php echo $this->config->item('company_name'); ?>">
		</a>
		-->
		
		<div class="header_banner">
			<div style="">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-top:0px;padding-bottom:10px">
					<tr>
					<td class="header_logo" align="right" valign="top" style="vertical-align: top;">
						<a href="http://www.mom2mom.fr/html" target="_blank" rel="home">
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
			<!-- 
			<div>
				<div class="header_lang_bar">
					<h6 class="lang_nav_links Populaire" title="Site in English"><a href="<?php echo preg_replace('/(?:\/|\.)html/i', '/en/html', current_url()) ?>">English Version</a></h6>
				</div>
			</div>
			-->
			<div>
				<div class="header_nav_bar" style="">
					
					<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Bébé'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | BEBE">BÉBÉ</a></div>
		
					<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Fille'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | FILLE">FILLE</a></div>
					
					<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Garçon'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | GARCON">GARÇON</a></div>
					
					<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Chaussures'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | CHAUSSURES">CHAUSSURES</a></div>
					
					<div class="header_nav_links Populaire"><a href="<?php foreach($header_urls as $header):if($header->name == 'Bric à brac'){echo site_url($header->slug);}endforeach;?>" title="Mom To Mom | Boutique eCommerce | BRIC A BRAC">BRIC A BRAC</a></div>
		
				</div>
			</div>
		</div>
		<br>
		
	</div>
</div>

<div class="wide_wrap">
	
	<img src="<?php echo base_url($this->config->item('assets_folder').'images/menu_left_wrap.gif');?>" alt="left" class="main_menu_left_wrap"/>
	<img src="<?php echo base_url($this->config->item('assets_folder').'images/menu_right_wrap.gif');?>" alt="right" class="main_menu_right_wrap"/>
	
	<div id="main_menu">
		<ul id="nav">
		<?php
		function display_categories($cats, $layer, $first='')
		{
			if($first)
			{
				echo '<ul'.$first.'>';
			}
			
			foreach ($cats as $cat)
			{
				if($cat['category']->id < 6 || $cat['category']->id > 10)
				{
					echo '<li><a href="'.site_url($cat['category']->slug).'">'.$cat['category']->name.'</a>'."\n";
					if (sizeof($cat['children']) > 0)
					{
						if($layer == 1)
						{
							$next = $layer+1;
							display_categories($cat['children'], $next, ' class="first"');
						}
						else
						{
							$next = $layer+1;
							display_categories($cat['children'], $next, ' class="nav"');
						}
					}
					echo '</li>';
				}
			}
			if($first)
			{
				echo '</ul>';
			}	
		}
			
		display_categories($this->categories, 1);
		
		if($gift_cards_enabled):?>
			<li><a href="<?php echo site_url('cart/giftcard');?>"><?php echo lang('giftcard');?></a></li>
		<?php endif;?>
		</ul>
		
		<br class="clear" />
	</div>
</div>

<div class="wide_wrap">
	<div class="content_wrap">
		<?php if (!empty($page_title)):?><h1><?php echo $page_title; ?></h1><?php endif;?>
	
		<?php
		if ($this->session->flashdata('message'))
		{
			echo '<div class="gmessage">'.$this->session->flashdata('message').'</div>';
		}
		if ($this->session->flashdata('error'))
		{
			echo '<div class="error">'.$this->session->flashdata('error').'</div>';
		}
		if (!empty($error))
		{
			echo '<div class="error">'.$error.'</div>';
		}
		

/*
End header.php file
*/