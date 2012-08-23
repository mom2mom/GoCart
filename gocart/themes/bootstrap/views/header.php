<!DOCTYPE html>
<?php echo html_helper_mom2mom_meta_pt1();?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php echo html_helper_mom2mom_meta_pt2();?>

<title><?php echo (isset($seo_title))?$seo_title:$this->config->item('company_name'); ?></title>

<?php if(isset($meta)):?>
<?php echo html_helper_mom2mom_meta_pt3($meta);?>
<?php else:?>
<meta name="Keywords" content="Shopping Cart, eCommerce, Mom To Mom">
<meta name="Description" content="Mom To Mom is the clothing discount store for all children 0 to 12 years">
<?php endif;?>
						
<?php echo theme_css('bootstrap.min.css', true);?><?php echo "\n\r";?>
<?php echo theme_css('bootstrap-responsive.min.css', true);?><?php echo "\n\r";?>
<?php echo theme_css('colorbox/colorbox.css', true);?><?php echo "\n\r";?>
<?php echo html_helper_mom2mom_css_pt1();?>
<?php echo theme_css('styles.css', true);?><?php echo "\n\r";?>

<?php echo theme_js('jquery-1.7.2.min.js', true);?><?php echo "\n\r";?>
<?php echo theme_js('jquery-ui-1.8.19.custom.min.js', true);?><?php echo "\n\r";?>
<?php echo theme_js('bootstrap.min.js', true);?><?php echo "\n\r";?>
<?php echo theme_js('squard.js', true);?><?php echo "\n\r";?>
<?php echo theme_js('equal_heights.js', true);?><?php echo "\n\r";?>
<?php echo theme_js('ga_tracking.js', true);?><?php echo "\n\r";?>
<?php echo theme_js('ga_social_tracking.js', true);?><?php echo "\n\r";?>

<?php load_jquery('smoothness');?>

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
	<?php echo html_helper_fb_javascript(); ?>
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
							
							<?php foreach($this->pages as $menu_page):?>

								<li>
								<?php if(empty($menu_page->content)):?>
									<a href="<?php echo $menu_page->url;?>" <?php if($menu_page->new_window ==1){echo 'target="_blank"';} ?>><?php echo $menu_page->menu_title;?></a>
								<?php else:?>
									<a href="<?php echo site_url($menu_page->slug);?>"><?php echo $menu_page->menu_title;?></a>
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
						<input type="text" name="term" class="search-query span2" placeholder="Search"/>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<?php echo html_helper_mom2mom_header_menu($header_urls);?>
	
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