<?php include('header.php'); ?>
<script type="text/javascript">
	window.onload = function()
	{
		$('.product').equalHeights();
	}
</script>

<?php $prod_categories = simplexml_load_string($product->category_xml_navigation); ?>

<div class="row">
	<div itemscope itemtype="http://data-vocabulary.org/Product">
		<div class="span4">
			<div class="row">
				<div class="span4" id="primary-img">
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
	
						$photo	= '<img class="responsiveImage" src="'.base_url(IMG_UPLOAD_FOLDER.'uploads/images/medium/'.$primary->filename).'" alt="'.$product->seo_title.'"/>';
					}
					echo $photo
					?>
				</div>
			</div>
			
			<?php if(!empty($primary->caption)):?>
			<div class="row">
				<div class="span4" id="product_caption">
					<?php echo $primary->caption;?>
				</div>
			</div>
			<?php endif;?>
			<?php if(count($product->images) > 1):?>
			<br>
			<div class="row">
				<div class="span4 product-images">
					<?php foreach($product->images as $image):?>
					<img class="span1" onclick="$(this).squard('390', $('#primary-img'));" src="<?php echo base_url(IMG_UPLOAD_FOLDER.'uploads/images/medium/'.$image->filename);?>"/>
					<?php endforeach;?>
				</div>
			</div>
			<?php endif;?>
		
			<?php if(!empty($product->related_products)):?>
			<div class="related_products">
				<div class="row">
					<div class="span4">
						<h3 style="margin-top:20px;"><?php echo lang('related_products_title');?></h3>
						<ul class="thumbnails">	
						<?php foreach($product->related_products as $relate):?>
							<li class="span2 product">
								<?php
								$photo	= '<img src="'.base_url(ASSETS_FOLDER.'images/nopicture.png').'" alt="'.lang('no_image_available').'"/>';
						
						
						
								$relate->images	= array_values((array)json_decode($relate->images));
						
								if(!empty($relate->images[0]))
								{
									$primary	= $relate->images[0];
									foreach($relate->images as $photo)
									{
										if(isset($photo->primary))
										{
											$primary	= $photo;
										}
									}

									$photo	= '<img src="'.base_url(IMG_UPLOAD_FOLDER.'uploads/images/thumbnails/'.$primary->filename).'" alt="'.$relate->seo_title.'"/>';
								}
								?>
								<a class="thumbnail" href="<?php echo site_url($relate->slug); ?>">
									<?php echo $photo; ?>
								</a>
								<h5 style="margin-top:5px;"><a href="<?php echo site_url($relate->slug); ?>"><?php echo $relate->name;?></a></h5>

								<div class="price_container">
									<?php if($relate->saleprice > 0):?>
										<?php if($status_solde['enum_solde'] == 1):?>
											<span class="price_slash"><?php echo lang('product_reg');?> <?php echo format_currency($relate->price); ?></span>
											<span class="price_sale"><?php echo lang('product_sale');?> <?php echo format_currency($relate->saleprice - round($relate->saleprice * $status_solde['percent_solde'] / 100, 2)); ?></span>
										<?php else: ?>
											<span class="price_slash"><?php echo lang('product_reg');?> <?php echo format_currency($relate->price); ?></span>
											<span class="price_sale"><?php echo lang('product_sale');?> <?php echo format_currency($relate->saleprice); ?></span>
										<?php endif; ?>
									<?php else: ?>
										<?php if($status_solde['enum_solde'] == 1):?>
											<span class="price_reg"><?php echo lang('product_price');?> <?php echo format_currency($relate->price - round($relate->price * $status_solde['percent_solde'] / 100, 2)); ?></span>
										<?php else: ?>
											<span class="price_reg"><?php echo lang('product_price');?> <?php echo format_currency($relate->price); ?></span>
										<?php endif; ?>
									<?php endif; ?>
								</div>
			                    <?php if((bool)$relate->track_stock && $relate->quantity < 1) { ?>
									<div class="stock_msg"><?php echo lang('out_of_stock');?></div>
								<?php } ?>
							</li>
						<?php endforeach;?>
						</ul>
					</div>
				</div>
			</div>
			<?php endif;?>
		</div>
		<div class="span7 offset1">
			
			<div class="row">
				<div class="span7">
					<div class="page-header">
						<h2 style="font-weight:normal">
							<span itemprop="name" class="fn"><?php echo $product->name;?></span>
							<span class="pull-right">
								<?php if($product->saleprice > 0):?>
									<?php if($status_solde['enum_solde'] != 0):?>
										<span class="price_slash pull-right"><small><?php echo lang('on_original');?>&nbsp;</small><?php echo format_currency($product->price); ?></span>
										<br>
										<span class="price_slash pull-right"><small><?php echo lang('on_sale');?>&nbsp;</small><?php echo format_currency($product->saleprice); ?></span>
										<br>
										<span class="product_price pull-right"><small><?php echo lang('on_solde');?>&nbsp;-&nbsp;<?php echo $status_solde['percent_solde']?>%&nbsp;</small><?php echo format_currency($product->saleprice - round($product->saleprice * $status_solde['percent_solde'] / 100, 2)); ?></span>
									<?php else: ?>
										<span class="price_slash pull-right"><small><?php echo lang('product_price');?>&nbsp;</small><?php echo format_currency($product->price); ?></span>
										<br>
										<span class="product_price pull-right"><small><?php echo lang('on_sale');?>&nbsp;</small><?php echo format_currency($product->saleprice); ?></span>
									<?php endif; ?>
								<?php else: ?>
									<?php if($status_solde['enum_solde'] != 0):?>
										<span class="price_slash pull-right"><small><?php echo lang('product_price');?>&nbsp;</small><?php echo format_currency($product->price); ?></span>
										<br>
										<span class="product_price pull-right"><small><?php echo lang('on_solde');?>&nbsp;-&nbsp;<?php echo $status_solde['percent_solde']?>%&nbsp;</small><?php echo format_currency($product->price - round($product->price * $status_solde['percent_solde'] / 100, 2)); ?></span>
									<?php else: ?>
										<span class="product_price pull-right"><small><?php echo lang('product_price');?>&nbsp;</small><?php echo format_currency($product->price); ?></span>
									<?php endif; ?>
								<?php endif;?>
							</span>
						</h2>
						<?php if($product->saleprice > 0):?>
							<?php if($status_solde['enum_solde'] != 0):?>
								<br>
								<br>
								<br>
								<br>
							<?php else: ?>
								<br>
							<?php endif; ?>
						<?php else: ?>
							<?php if($status_solde['enum_solde'] != 0):?>
								<br>
								<br>
							<?php else: ?>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="span7">
					<?php echo $product->excerpt;?>
				</div>
			</div>
			
			<div class="row" style="margin-top:15px; margin-bottom:15px;">
				<div class="span4 sku-pricing">
					<?php if(!empty($product->sku)):?><div><?php echo lang('sku');?>: <?php echo $product->sku; ?></div><?php endif;?>&nbsp;
				</div>
				<?php if((bool)$product->track_stock && $product->quantity < 1):?>
				<div class="span4 out-of-stock">
					<div>Out of Stock</div>
				</div>
				<?php endif;?>
			</div>
			
			
			<div class="row" style="margin-top:15px;">
				<div class="span7">
					<span class="pull-left">
						<h3 class="polaroid_marque" style="line-height: 20px; vertical-align: center;">
							<span class="brand" itemprop="brand"><?php echo $prod_categories->marque[0]; ?></span>
						</h3>
					</span>
					<span class="pull-right">
						<h4 class="polaroid_taille" style="line-height: 20px; vertical-align: center; padding-top: 1.75px;">
							<span class="category" itemprop="category"><?php echo $prod_categories->taille[0]; ?></span><br>
						</h4>
					</span>
					<br>
					<br>
				</div>
			</div>
			
			
			<div class="row" style="margin-top:15px;">
				<div class="span7">
					<div itemprop="description" class="description">
						<h1 class="Populaire"><?php echo $product->description; ?></h1>
						<br>
						<br>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="span7">
					<div class="product-cart-form">
						<?php echo form_open('cart/add_to_cart', 'class="form-horizontal"');?>
						<input type="hidden" name="cartkey" value="<?php echo $this->session->flashdata('cartkey');?>" />
						<input type="hidden" name="id" value="<?php echo $product->id?>"/>
						<fieldset>
						<?php if(count($options) > 0): ?>
							<?php foreach($options as $option):
								$required	= '';
								if($option->required)
								{
									$required = ' <p class="help-block">Required</p>';
								}
								?>
								<div class="control-group">
									<label class="control-label"><?php echo $option->name;?></label>
									<?php
									/*
									this is where we generate the options and either use default values, or previously posted variables
									that we either returned for errors, or in some other releases of Go Cart the user may be editing
									and entry in their cart.
									*/
	
									//if we're dealing with a textfield or text area, grab the option value and store it in value
									if($option->type == 'checklist')
									{
										$value	= array();
										if($posted_options && isset($posted_options[$option->id]))
										{
											$value	= $posted_options[$option->id];
										}
									}
									else
									{
										$value	= $option->values[0]->value;
										if($posted_options && isset($posted_options[$option->id]))
										{
											$value	= $posted_options[$option->id];
										}
									}
	
									if($option->type == 'textfield'):?>
										<div class="controls">
											<input type="text" name="option[<?php echo $option->id;?>]" value="<?php echo $value;?>" class="span4"/>
											<?php echo $required;?>
										</div>
									<?php elseif($option->type == 'textarea'):?>
										<div class="controls">
											<textarea class="span4" name="option[<?php echo $option->id;?>]"><?php echo $value;?></textarea>
											<?php echo $required;?>
										</div>
									<?php elseif($option->type == 'droplist'):?>
										<div class="controls">
											<select name="option[<?php echo $option->id;?>]">
												<option value=""><?php echo lang('choose_option');?></option>
	
											<?php foreach ($option->values as $values):
												$selected	= '';
												if($value == $values->id)
												{
													$selected	= ' selected="selected"';
												}?>
	
												<option<?php echo $selected;?> value="<?php echo $values->id;?>">
													<?php echo($values->price != 0)?'('.format_currency($values->price).') ':''; echo $values->name;?>
												</option>
	
											<?php endforeach;?>
											</select>
											<?php echo $required;?>
										</div>
									<?php elseif($option->type == 'radiolist'):?>
										<div class="controls">
											<?php foreach ($option->values as $values):
	
												$checked = '';
												if($value == $values->id)
												{
													$checked = ' checked="checked"';
												}?>
												<label class="radio">
													<input<?php echo $checked;?> type="radio" name="option[<?php echo $option->id;?>]" value="<?php echo $values->id;?>"/>
													<?php echo $option->name;?> <?php echo($values->price != 0)?'('.format_currency($values->price).') ':''; echo $values->name;?>
												</label>
											<?php endforeach;?>
											<?php echo $required;?>
										</div>
									<?php elseif($option->type == 'checklist'):
										foreach ($option->values as $values):
	
											$checked = '';
											if(in_array($values->id, $value))
											{
												$checked = ' checked="checked"';
											}?>
											<label class="checkbox">
												<input<?php echo $checked;?> type="checkbox" name="option[<?php echo $option->id;?>][]" value="<?php echo $values->id;?>"/>
												<?php echo($values->price != 0)?'('.format_currency($values->price).') ':''; echo $values->name;?>
											</label>
										<?php endforeach ?>
										<?php echo $required;?>
									<?php endif;?>
									</div>
							<?php endforeach;?>
						<?php endif;?>
						
						<div class="control-group">
							<?php if($product->status_reserver == '1') : ?>
								<div class="controls">
									<h6 style="vertical-align: center; text-align: middle; padding-top: 10px;">DÉSOLÉ ! CET ARTICLE EST DÉJÀ RESERVÉ</h6> 
								</div>
							<?php elseif ($product->status_vendu == '1'): ?>
								<div class="controls">
									<h6 style="vertical-align: center; text-align: middle; padding-top: 10px;">DÉSOLÉ ! CET ARTICLE EST DÉJÀ VENDU</h6> 
								</div>
							<?php elseif ($product->status_vendu != '1' && $product->status_vendu != '1'): ?>
								<?php if(!$product->fixed_quantity) : ?>
									<label class="control-label"><?php echo lang('quantity') ?></label>
								<?php endif; ?>
								<div class="controls">
									<?php if($this->config->item('allow_os_purchase') || !(bool)$product->track_stock || $product->quantity > 0): ?>
										<?php if(!$product->fixed_quantity) : ?>
											<input class="span2" type="text" name="quantity" value=""/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php endif; ?>
										<button class="btn btn-primary btn-large" type="submit" value="submit"><i class="icon-shopping-cart icon-white"></i> <?php echo lang('form_add_to_cart');?></button>
									<?php endif;?>
								</div>
							<?php endif; ?>
						</div>
						</fieldset>
						</form>
					</div>
		
				</div>
			</div>
			<div class="row">
				<br>
				<div class="span7 pull-left">
					<span class="pull-left" style="display: inline; padding-right: 40px; overflow:hidden; height: 100%; width: 100%; vertical-align: baseline;">
						<div class="fb-like" href='<?php echo base_url('/article-' . $product->article_ID . '/shopping-cart/html') ; ?>' data-send="true" data-layout="standard" data-width="450" data-show-faces="true" data-font="lucida grande" ref="<?php echo ('article-' . $product->article_ID) ; ?>"></div>
					</span>
					<span class="pull-left" style="display: inline; padding-right: 40px; overflow:hidden; height: 100%; width: 81px; vertical-align: top;">
						<div class="bubble_twitter">
							<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo base_url('/article-' . $product->article_ID . '/shopping-cart/html'); ?> "data-text="Je viens de consulter <?php echo "l'" . 'Article-' . $product->article_ID;?> chez Mom To Mom" data-via="mom2mom_news" data-lang="fr" data-hashtags="<?php foreach ($prod_categories->marque as $marque) { echo $marque . ','; } ; ?>mom2mom,momtomom,mode,enfant,enfants,modeenfants,vêtements,depotvente,maman,mamans,bébé,paris,style,tendances" data-counturl="http://mom2mom.fr/html">Tweeter</a>
						</div>
					</span>
					<span class="pull-left" style="display: inline; padding-right: 40px; overflow:hidden; height: 100%; width: 41px; vertical-align: top;">
						<div class="bubble_pinterest">
							<a href="<?php echo "http://pinterest.com/pin/create/button/?url=" . urlencode(base_url('/article-' . $product->article_ID . '/shopping-cart/html')) . '&media=' . urlencode(base_url(IMG_UPLOAD_FOLDER.'uploads/images/medium/'.$product->images[0]->filename)) . '&description=' . urlencode($product->description) ; ?>" class="pin-it-button" count-layout="horizontal"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It"/></a>
						</div>
					</span>
					<span class="pull-left" style="display: inline; padding-right: 40px; overflow:hidden; height: 100%; vertical-align: top;">
						<div class="g-plusone" data-size="medium" data-annotation="none" data-href="<?php echo base_url('/article-' . $product->article_ID . '/shopping-cart/html') ; ?>"></div>
					</span>
					<span class="pull-left" style="display: inline; padding-right: 40px; overflow:hidden; height: 100%; vertical-align: top;">
						<div class="bubble_tumblr" id="<?php echo 'tumblr_article_' . $product->article_ID;?>">
							<script type="text/javascript">
								var tumblr_button_<?php echo $product->article_ID;?> = document.createElement("a");
					            tumblr_button_<?php echo $product->article_ID;?>.setAttribute("href", "http://www.tumblr.com/share/photo?source=" + "<?php echo rawurlencode(base_url(IMG_UPLOAD_FOLDER.'uploads/images/medium/'.$product->images[0]->filename)) ;?>" + "&caption=" + "<?php echo rawurlencode($product->description) ;?>" + "&click_thru=" + "<?php echo rawurlencode(base_url('/article-' . $product->article_ID . '/shopping-cart/html')) ;?>");
					            tumblr_button_<?php echo $product->article_ID;?>.setAttribute("title", "Share on Tumblr");
					            tumblr_button_<?php echo $product->article_ID;?>.setAttribute("style", "display:inline-block; text-indent:-9999px; overflow:hidden; width:61px; height:20px; background:url('http://platform.tumblr.com/v1/share_2.png') top left no-repeat transparent;");
					            tumblr_button_<?php echo $product->article_ID;?>.innerHTML = "tumblr";
					            document.getElementById("<?php echo 'tumblr_article_' . $product->article_ID;?>").appendChild(tumblr_button_<?php echo $product->article_ID;?>);
					        </script>
				        </div>
					</span>
				</div>
			</div>
		</div>
	</div>
</div>


<?php echo form_open('cart/add_to_cart');?>

<div id="product_right">	

	

		
	</form>
	<div class="tabs">
		<ul>
			<!-- <li><a href="#description_tab"><?php echo lang('tab_description');?></a></li> -->
			<?php if(!empty($product->related)):?><li><a href="#related_tab"><?php echo lang('tab_related_products');?></a></li><?php endif;?>
		</ul>

		
		<?php if(!empty($product->related)):?>
		<div id="related_tab">
			<?php
			$cat_counter=1;
			foreach($product->related as $product):
				if($cat_counter == 1):?>

				<div class="category_container">

				<?php endif;?>

				<div class="category_box">
					<div class="thumbnail">
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
						<a href="<?php echo site_url($product->slug); ?>">
							<?php echo $photo; ?>
						</a>
					</div>
					<div class="gc_product_name">
						<a href="<?php echo site_url($product->slug); ?>"><?php echo $product->name;?></a>
					</div>
					<?php if($product->excerpt != ''): ?>
					<div class="excerpt"><?php echo $product->excerpt; ?></div>
					<?php endif; ?>
					<div>
						<?php if($product->saleprice > 0):?>
							<span class="gc_price_slash"><?php echo lang('product_price');?> <?php echo $product->price; ?></span>
							<span class="gc_price_sale"><?php echo lang('product_sale');?> <?php echo $product->saleprice; ?></span>
						<?php else: ?>
							<span class="gc_price_reg"><?php echo lang('product_price');?> <?php echo $product->price; ?></span>
						<?php endif; ?>
	                    <?php if((bool)$product->track_stock && $product->quantity < 1) { ?>
							<div class="gc_stock_msg"><?php echo lang('out_of_stock');?></div>
						<?php } ?>
					</div>
				</div>
			
				<?php 
				$cat_counter++;
				if($cat_counter == 5):?>
			
				
				</div>

				<?php 
				$cat_counter = 1;
				endif;
			endforeach;
		
			if($cat_counter != 1):?>
					<br class="clear"/>
				</div>
			<?php endif;?>
		</div>
		<?php endif;?>
	</div>

</div>

<script type="text/javascript"><!--
$(function(){ 
	$('.category_container').each(function(){
		$(this).children().equalHeights();
	});	
});
//--></script>

<?php include('footer.php'); ?>