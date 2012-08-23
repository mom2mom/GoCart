<?php include('header.php'); ?>


	<div class="page-header">
		<h1><?php echo $page_title; ?></h1>
	</div>
	
	<?php if(!empty($category->description)): ?>
	<div class="row">
		<div class="span12"><?php echo $category->description; ?></div>
	</div>
	<?php endif; ?>
	
	
	<?php if((!isset($subcategories) || count($subcategories)==0) && (count($products) == 0)):?>
		<div class="alert alert-info">
			<a class="close" data-dismiss="alert">×</a>
			<?php echo lang('no_products');?>
		</div>
	<?php endif;?>
	

	<div class="row">
		<?php if(isset($subcategories) && count($subcategories) > 0): ?>
		<div class="span3">
			<ul class="nav nav-list well">
				<li class="nav-header">
				Subcategories
				</li>
				
				<?php foreach($subcategories as $subcategory):?>
					<li><a href="<?php echo site_url(implode('/', $base_url).'/'.$subcategory->slug); ?>"><?php echo $subcategory->name;?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
		
		<div class="span9">
		
		<?php else:?>
			<div class="span12">
		<?php endif;?>
			
			<?php if(count($products) > 0):?>
				
				<div class="pull-right" style="margin-top:20px;">
					<select id="sort_products" onchange="window.location='<?php echo site_url(uri_string());?>?'+$(this).val();">
						<option value=''><?php echo lang('default');?></option>
						<option<?php echo(!empty($_GET['by']) && $_GET['by']=='name/asc')?' selected="selected"':'';?> value="by=name/asc"><?php echo lang('sort_by_name_asc');?></option>
						<option<?php echo(!empty($_GET['by']) && $_GET['by']=='name/desc')?' selected="selected"':'';?>  value="by=name/desc"><?php echo lang('sort_by_name_desc');?></option>
						<option<?php echo(!empty($_GET['by']) && $_GET['by']=='price/asc')?' selected="selected"':'';?>  value="by=price/asc"><?php echo lang('sort_by_price_asc');?></option>
						<option<?php echo(!empty($_GET['by']) && $_GET['by']=='price/desc')?' selected="selected"':'';?>  value="by=price/desc"><?php echo lang('sort_by_price_desc');?></option>
					</select>
				</div>
				<div style="float:left;"><?php echo $this->pagination->create_links();?></div>
				<br style="clear:both;"/>
				<!-- <ul class="thumbnails category_container"> -->
				<div class="polaroid_container">
					<ul class="polaroid thumbnails category_container">
					<?php foreach($products as $product):?>
						<?php $prod_categories = simplexml_load_string($product->category_xml_navigation); ?>
						<li class="span3 product hproduct">
							<div class='holder' itemscope itemtype="http://data-vocabulary.org/Product">
								<div class="polaroid_top">
									<h3 class="polaroid_marque">
										<span class="brand" itemprop="brand"><?php echo $prod_categories->marque[0]; ?></span>
									</h3>
								</div>
								<div class="polaroid_middle">
									<?php
									$photo	= '<img src="'.base_url(ASSETS_FOLDER.'images/nopicture.png').'" alt="'.lang('no_image_available').'"/>';
									$product->images	= array_values($product->images);
							
									if(!empty($product->images[0]))
									{
										$primary	= $product->images[0];
										foreach($product->images as $photo)
										{
											if(isset($photo->primary))
											{
												$primary	= $photo;
											}
										}
			
										$photo	= '<img src="'.base_url(IMG_UPLOAD_FOLDER.'uploads/images/thumbnails/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
									}
									?>
									<div class="polaroid_photo">
									<a class="thumbnail" href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>" title="">
										<?php echo $photo; ?>
									</a>
									</div>
								</div>
								<div class="polaroid_bottom" >
								
									<?php if($status_solde['enum_solde'] == 0):?>
										<h5 style="margin-top:5px;" itemprop="name" class="pull-left fn"><a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $product->name;?></a></h5><br>
									<?php elseif ($status_solde['enum_solde'] != 0): ?>
										<?php if($product->saleprice == 0):?>
											<h5 style="margin-top:5px;" itemprop="name" class="pull-left fn"><a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $product->name;?></a></h5><br>
										<?php endif;?>
									<?php endif;?>
									<h4 class="polaroid_taille">
										<span itemprop="category" class="pull-left category"><?php echo $prod_categories->taille[0]; ?></span><br>
									</h4>
									
									<!--
									<?php if($status_solde['enum_solde'] == 0):?>
										<h5 style="margin-top:5px;" itemprop="name" class="pull-left fn"><a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $product->name;?></a></h5>
										<br>
										<h4 class="polaroid_taille">
											<span itemprop="category" class="pull-left category"><?php echo $prod_categories->taille[0]; ?></span>
										</h4>
										<br>
									<?php elseif ($status_solde['enum_solde'] != 0): ?>
										<?php if($product->saleprice == 0):?>
										<h5 style="margin-top:5px;" itemprop="name" class="pull-left fn"><a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $product->name;?></a></h5>
										<br>
										<h4 class="polaroid_taille">
											<span itemprop="category" class="pull-left category"><?php echo $prod_categories->taille[0]; ?></span>
										</h4>
										<br>
										<?php else: ?>
										<h5 style="margin-top:5px;" itemprop="name" class="pull-left fn"><a href="<?php echo site_url(implode('/', $base_url).'/'.$product->slug); ?>"><?php echo $product->name;?></a></h5>
										<h4 class="polaroid_taille">
											<span itemprop="category" class="category" style="text-align: middle;"><?php echo $prod_categories->taille[0]; ?></span>
										</h4>
										<?php endif;?>
									<?php endif;?>
									-->
									
									<div>
										<div class="price_container">
											<div class="price" itemprop="price">
												<?php if($product->saleprice > 0):?>
													<?php if($status_solde['enum_solde'] != 0):?>
														<span class="price_slash pull-left"><small><?php echo lang('on_original');?>&nbsp;</small><?php echo format_currency($product->price); ?></span>
														<br>
														<span class="price_reg price_slash pull-left"><small><?php echo lang('product_sale');?>&nbsp;</small><?php echo format_currency($product->saleprice); ?></span>
														<br>
														<span class="price_sale pull-left"><small><?php echo lang('product_solde');?>&nbsp;</small><?php echo format_currency($product->saleprice - round($product->saleprice * $status_solde['percent_solde'] / 100, 2)); ?></span>
													<?php else: ?>
														<span class="price_reg price_slash pull-left"><small><?php echo lang('product_price');?>&nbsp;</small><?php echo format_currency($product->price); ?></span>
														<br>
														<span class="price_sale pull-left"><small><?php echo lang('product_sale');?>&nbsp;</small><?php echo format_currency($product->saleprice); ?></span>
													<?php endif; ?>
												<?php else: ?>
													<?php if($status_solde['enum_solde'] != 0):?>
														<span class="price_reg price_slash pull-left"><small><?php echo lang('product_price');?>&nbsp;</small><?php echo format_currency($product->price); ?></span>
														<br>
														<span class="price_sale pull-left"><small><?php echo lang('product_solde');?>&nbsp;</small><?php echo format_currency($product->price - round($product->price * $status_solde['percent_solde'] / 100, 2)); ?></span>
													<?php else: ?>
														<span class="price_reg pull-left"><small><?php echo lang('product_price');?>&nbsp;</small><?php echo format_currency($product->price); ?></span>
													<?php endif; ?>
												<?php endif;?>
											</div>
										</div>
					                    <?php if((bool)$product->track_stock && $product->quantity < 1) { ?>
											<div class="stock_msg"><?php echo lang('out_of_stock');?></div>
										<?php } ?>
									</div>
									<?php if($product->excerpt != ''): ?>
									<div class="excerpt"><?php echo $product->excerpt; ?></div>
									<?php endif; ?>
								</div>
								<!--
								<div>
									<meta itemprop="currency" content="EUR" />
									<span itemprop="description" class="description"><?php echo $product->description; ?></span>
							    	&Eacute;tat: <span itemprop="condition" content="used">En parfait &eacute;tat</span>
							    	Revendeur: <span itemprop="seller">Mom To Mom</span>
						    	</div>
						    	-->
								<div itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer">
									<?php if($product->status_reserver == '1'):?>
										<?php if($product->status_vendu == '0'):?>
											<div class="tag">
											<div class="triangle_1"></div>
											<div class="box"><small>réservé</small></div>
											<div class="triangle_2"></div>
											</div>
										<?php elseif ($product->status_vendu == '1'): ?>
											<div class="tag">
											<div class="triangle_1"></div>
											<div class="box"><small>vendu</small></div>
											<div class="triangle_2"></div>
											</div>
										<?php endif; ?>
										<span itemprop="availability" content="out_of_stock"></span>
									<?php else: ?>
										<span itemprop="availability" content="in_stock"></span>
									<?php endif;?>
								</div>
							</div>
						</li>
					<?php endforeach?>
					</ul>
				</div>
			<?php endif;?>
		</div>
	</div>

<script type="text/javascript">
	window.onload = function(){
		$('.product').equalHeights();
	}
</script>
<?php include('footer.php'); ?>