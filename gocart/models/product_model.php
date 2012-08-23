<?php
Class Product_model extends CI_Model
{
		
	// we will store the group discount formula here
	// and apply it to product prices as they are fetched 
	var $group_discount_formula = false;
	
	function __construct()
	{
		parent::__construct();
		
		// check for possible group discount 
		$customer = $this->session->userdata('customer');
		if(isset($customer['group_discount_formula'])) 
		{
			$this->group_discount_formula = $customer['group_discount_formula'];
		}
	}

	function get_products($category_id = false, $limit = false, $offset = false)
	{
		//if we are provided a category_id, then get products according to category
		if ($category_id)
		{
			$result = $this->db->select('category_products.*')->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('category_id'=>$category_id, 'enabled'=>1))->order_by('sequence', 'ASC')->limit($limit)->offset($offset)->get()->result();
			
			//$this->db->order_by('sequence', 'ASC');
			//$result	= $this->db->get_where('category_products', array('enabled'=>1,'category_id'=>$category_id), $limit, $offset);
			//$result	= $result->result();

			$contents	= array();
			$count		= 0;
			foreach ($result as $product)
			{

				$contents[$count]	= $this->get_product($product->product_id);
				$count++;
			}

			return $contents;
		}
		else
		{
			//sort by alphabetically by default
			$this->db->order_by('name', 'ASC');
			$result	= $this->db->get('products');
			//apply group discount
			$return = $result->result();
			if($this->group_discount_formula) 
			{
				foreach($return as &$product) {
					eval('$product->price=$product->price'.$this->group_discount_formula.';');
				}
			}
			return $return;
		}

	}

	function count_products($id)
	{
		return $this->db->select('product_id')->from('category_products')->join('products', 'category_products.product_id=products.id')->where(array('category_id'=>$id, 'enabled'=>1))->count_all_results();
	}

	function get_product($id, $sub=true)
	{
		$result	= $this->db->get_where('products', array('id'=>$id))->row();
		if(!$result)
		{
			return false;
		}
		
		$result->categories = $this->get_product_categories($result->id);
		
		// group discount?
		if($this->group_discount_formula) 
		{
			eval('$result->price=$result->price'.$this->group_discount_formula.';');
		}
		return $result;
	}

	function get_product_categories($id)
	{
		$cats	= $this->db->where('product_id', $id)->get('category_products')->result();
		
		$categories = array();
		foreach ($cats as $c)
		{
			$categories[] = $c->category_id;
		}
		return $categories;
	}

	function get_slug($id)
	{
		return $this->db->get_where('products', array('id'=>$id))->row()->slug;
	}

	function check_slug($str, $id=false)
	{
		$this->db->select('slug');
		$this->db->from('products');
		$this->db->where('slug', $str);
		if ($id)
		{
			$this->db->where('id !=', $id);
		}
		$count = $this->db->count_all_results();

		if ($count > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function save($product, $options=false, $categories=false)
	{
		if ($product['id'])
		{
			//$this->db->where('id', $product['id']);
			//$this->db->update('products', $product);
			//$id	= $product['id'];
			
			$this->db->where('id', $product['id']);
			$this->db->update('products', $product);
			$this->db->set_dbprefix('');
			$this->updateOriginalProduct($product, $product['id']);
			$this->db->set_dbprefix('gc_fr_');
			$id	= $product['id'];
		}
		else
		{
			//$this->db->insert('products', $product);
			//$id	= $this->db->insert_id();
			
			$result_id = $this->insertOriginalProduct($product);
			$product['id'] = $result_id;
			
			$this->db->insert('products', $product);
			
			$this->db->set_dbprefix('');
			$this->db->insert('gc_en_products', $product);
			$this->db->insert('gc_en_routes', array('slug' => $product['slug'], 'route' => "cart/product/" . $result_id));
			$route_id = $this->db->insert_id();
			$this->db->where('id', $result_id);
			$this->db->update('gc_en_products', array('route_id ' => $route_id));
			$this->db->set_dbprefix('gc_fr_');
			
			$id	= $result_id;
		}

		//loop through the product options and add them to the db
		if($options !== false)
		{
			$obj =& get_instance();
			$obj->load->model('Option_model');

			// wipe the slate
			$obj->Option_model->clear_options($id);

			// save edited values
			$count = 1;
			foreach ($options as $option)
			{
				$values = $option['values'];
				unset($option['values']);
				$option['product_id'] = $id;
				$option['sequence'] = $count;

				$obj->Option_model->save_option($option, $values);
				$count++;
			}
		}
		
		if($categories !== false)
		{
			if($product['id'])
			{
				//get all the categories that the product is in
				$cats	= $this->get_product_categories($id);
				
				//eliminate categories that products are no longer in
				foreach($cats as $c)
				{
					if(!in_array($c, $categories))
					{
						$this->db->delete('category_products', array('product_id'=>$id,'category_id'=>$c));
					}
				}
				
				//add products to new categories
				foreach($categories as $c)
				{
					if(!in_array($c, $cats))
					{
						$this->db->insert('category_products', array('product_id'=>$id,'category_id'=>$c));
					}
				}
			}
			else
			{
				//new product add them all
				foreach($categories as $c)
				{
					$this->db->insert('category_products', array('product_id'=>$id,'category_id'=>$c));
				}
			}
		}
		
		//return the product id
		return $id;
	}
	
	function delete_product($id)
	{
		// delete product 
		$this->db->where('id', $id);
		$this->db->delete('products');

		//delete references in the product to category table
		$this->db->where('product_id', $id);
		$this->db->delete('category_products');
		
		// delete coupon reference
		$this->db->where('product_id', $id);
		$this->db->delete('coupons_products');
		
		$this->db->set_dbprefix('');
		$this->db->where('article_ID', $id);
		$this->db->delete('articles');
		$this->db->where('id', $id);
		$this->db->delete('gc_en_products');
		$this->db->set_dbprefix('gc_fr_');
	}

	function add_product_to_category($product_id, $optionlist_id, $sequence)
	{
		$this->db->insert('product_categories', array('product_id'=>$product_id, 'category_id'=>$category_id, 'sequence'=>$sequence));
	}

	function search_products($term, $limit=false, $offset=false)
	{
		$results		= array();

		//I know this is the round about way of doing things and is not the fastest. but it is thus far the easiest.

		//this one counts the total number for our pagination
		$this->db->like('name', $term);
		$this->db->or_like('description', $term);
		$this->db->or_like('excerpt', $term);
		$this->db->or_like('sku', $term);
		$results['count']	= $this->db->count_all_results('products');

		//this one gets just the ones we need.
		$this->db->like('name', $term);
		$this->db->or_like('description', $term);
		$this->db->or_like('excerpt', $term);
		$this->db->or_like('sku', $term);
		$results['products']	= $this->db->get('products', $limit, $offset)->result();
		return $results;
	}

	// Build a cart-ready product array
	function get_cart_ready_product($id, $quantity=false)
	{
		$db_product			= $this->get_product($id);
		if( ! $db_product)
		{
			return false;
		}
		
		$product = array();
		
		if ($db_product->saleprice == 0.00) { 
			$product['price']	= $db_product->price;
		}
		else
		{
			$product['price']	= $db_product->saleprice;
		}
		
		$product['base_price'] 		= $product['price']; // price gets modified by options, show the baseline still...
		$product['id']				= $db_product->id;
		$product['name']			= $db_product->name;
		$product['sku']				= $db_product->sku;
		$product['excerpt']			= $db_product->excerpt;
		$product['weight']			= $db_product->weight;
		$product['shippable']	 	= $db_product->shippable;
		$product['taxable']			= $db_product->taxable;
		$product['fixed_quantity']	= $db_product->fixed_quantity;
		$product['track_stock']		= $db_product->track_stock;
		$product['options']			= array();
		
		// Some products have n/a quantity, such as downloadables	
		if (!$quantity || $quantity <= 0 || $db_product->fixed_quantity==1)
		{
			$product['quantity'] = 1;
		} else {
			$product['quantity'] = $quantity;
		}

		
		// attach list of associated downloadables
		$product['file_list']	= $this->Digital_Product_model->get_associations_by_product($id);
		
		return $product;
	}
	
	function insertOriginalProduct($product)
	{

		date_default_timezone_set('Europe/Paris');
		$dateTime = date('Y-m-d H:i:s');  
		$dateTime_string = strval($dateTime);
		
									$sql  = "INSERT INTO articles (NOM_DEPOSANT, ID_COMPTE_DEPOSANT, DEF_NATURE, DEF_OBJET, DEF_SOUS_OBJET, DEF_MARQUE, DEF_SOUS_MARQUE, DEF_TAILLE, DEF_SOUS_TAILLE, DEF_GAMME_DE_PRIX, DEF_SOUS_GAMME_DE_PRIX, DEF_COULEUR_NAME, DEF_COULEUR_HEX, DEF_COULEUR_DESCRIPT, category_xml, category_xml_navigation, size_image1, image1_data, image2_data, image3_data, prix_deposant, prix_acheteur, prix_deposant_en_baisse, prix_acheteur_en_baisse, poids, mode_livraison_specifique, stockage, description, couleur_dominante, matieres_principales, saison, detail_supplem_1, detail_supplem_2, detail_supplem_3, detail_supplem_4, meta_tags, meta_tags_navigation, date_creation, date_expiration, date_panier, date_vendu, status_info_complete, status_incorporer_newsletter, status_afficher_a_la_vente, status_prix_acheteur_en_baisse, status_reserver, status_vendu, quid_1, quid_2, extra_1, extra_2, extra_3, extra_4) VALUES(";
									//$sql .= $this->db->escape($title);
/*NOM_DEPOSANT*/  					$sql .= " '', ";
/*ID_COMPTE_DEPOSANT*/  			$sql .= " '', ";
/*DEF_NATURE*/  					$sql .= " '', ";
/*DEF_OBJET*/  						$sql .= " '', ";
/*DEF_SOUS_OBJET*/  				$sql .= " '', ";
/*DEF_MARQUE*/ 						$sql .= " '', ";
/*DEF_SOUS_MARQUE*/  				$sql .= " '', ";
/*DEF_TAILLE*/  					$sql .= " '', ";
/*DEF_SOUS_TAILLE*/  				$sql .= " '', ";
/*DEF_GAMME_DE_PRIX*/  				$sql .= " '', ";
/*DEF_SOUS_GAMME_DE_PRIX*/  		$sql .= " '', ";
/*DEF_COULEUR_NAME*/  				$sql .= " '', ";
/*DEF_COULEUR_HEX*/  				$sql .= " '', ";
/*DEF_COULEUR_DESCRIPT*/  			$sql .= " '', ";
/*category_xml*/  					$sql .= " '', ";
/*category_xml_navigation*/  		$sql .= " '', ";
/*size_image1*/  					$sql .= " '', ";
/*image1_data*/  					$sql .= " '', ";
/*image2_data*/  					$sql .= " '', ";
/*image3_data*/  					$sql .= " '', ";
/*prix_deposant*/  					$sql .= 0 . ", ";
/*prix_acheteur*/  					$sql .= intval($product['price']) . ", ";
/*prix_deposant_en_baisse*/  		$sql .= 0 . ", ";
/*prix_acheteur_en_baisse*/  		$sql .= intval($product['saleprice']) . ", ";
/*poids*/  							$sql .= floatval($product['weight'])  . ", ";
/*mode_livraison_specifique*/  		$sql .= " '', ";
/*stockage*/  						$sql .= " '', ";
/*description*/  					$sql .= $this->db->escape($product['description']) . ", ";
/*couleur_dominante*/  				$sql .= " '', ";
/*matieres_principales*/ 			$sql .= " '', ";
/*saison*/  						$sql .= " '', ";
/*detail_supplem_1*/  				$sql .= $this->db->escape($product['name']) . ", ";
/*detail_supplem_2*/  				$sql .= $this->db->escape($product['excerpt']) . ", ";
/*detail_supplem_3*/  				$sql .= $this->db->escape($product['seo_title']) . ", ";
/*detail_supplem_4*/  				$sql .= $this->db->escape($product['meta']) . ", ";
/*meta_tags*/  						$sql .= " '', ";
/*meta_tags_navigation*/  			$sql .= " '', ";
/*date_creation*/  					$sql .= "'" . $dateTime_string . "', ";
/*date_expiration*/  				$sql .= " '', ";
/*date_panier*/  					$sql .= " '', ";
/*date_vendu*/  					$sql .= " '', ";
/*status_info_complete*/  			$sql .= " '0',";
/*status_incorporer_newsletter*/  	$sql .= " '0',";
/*status_afficher_a_la_vente*/  	$sql .= " '0',";
/*status_prix_acheteur_en_baisse*/  $sql .= " '0',";
/*status_reserver*/  				$sql .= " '0',";
/*status_vendu*/  					$sql .= " '0',";
/*quid_1*/  						$sql .= " '', ";
/*quid_2*/  						$sql .= " '', ";
/*extra_1*/  						$sql .= " '', ";
/*extra_2*/  						$sql .= " '', ";
/*extra_3*/  						$sql .= " '', ";
/*extra_4*/  						$sql .= " ''  ";
									$sql .= ")";
		
		$this->db->query($sql);
		$result_id = $this->db->insert_id();
		
		return $result_id;
	}
	
	function updateOriginalProduct($product, $id)
	{
		$arr = array(
	    	//'NOM_DEPOSANT' => '',
			//'ID_COMPTE_DEPOSANT' => '',
			//'DEF_NATURE' => '',
			//'DEF_OBJET' => '',
			//'DEF_SOUS_OBJET' => '',
			//'DEF_MARQUE' => '',
			//'DEF_SOUS_MARQUE' => '',
			//'DEF_TAILLE' => '',
			//'DEF_SOUS_TAILLE' => '',
			//'DEF_GAMME_DE_PRIX' => '',
			//'DEF_SOUS_GAMME_DE_PRIX' => '',
			//'DEF_COULEUR_NAME' => '',
			//'DEF_COULEUR_HEX' => '',
			//'DEF_COULEUR_DESCRIPT' => '',
			//'category_xml' => '',
			//'category_xml_navigation' => '',
			//'size_image1' => '',
			//'image1_data' => '',
			//'image2_data' => '',
			//'image3_data' => '',
			//'prix_deposant' => 1,
			'prix_acheteur' => intval($product['price']),
			//'prix_deposant_en_baisse' => 0,
			'prix_acheteur_en_baisse' => intval($product['saleprice']),
			'poids' => number_format(round(floatval($product['weight']), 3), 3, '.', ''),
			//'mode_livraison_specifique' => '',
			//'stockage' => '',
			'description' => $product['description'],
			//'couleur_dominante' => '',
			//'matieres_principales' => '',
			//'saison' => '',
			'detail_supplem_1' => $product['name'],
			'detail_supplem_2' => $product['excerpt'],
			'detail_supplem_3' => $product['seo_title'],
			'detail_supplem_4' => $product['meta']
			//'meta_tags' => '',
			//'meta_tags_navigation' => '',
			//'date_creation' => '',
			//'date_expiration' => '',
			//'date_panier' => '',
			//'date_vendu' => '',
			//'status_info_complete' => '',
			//'status_incorporer_newsletter' => '',
			//'status_afficher_a_la_vente' => '',
			//'status_prix_acheteur_en_baisse' => '',
			//'status_reserver' => '',
			//'status_vendu' => '',
			//'quid_1' => '',
			//'quid_2' => '',
			//'extra_1' => '',
			//'extra_2' => '',
			//'extra_3' => '',
			//'extra_4' => ''
		);
		
		$arr2 = array(
			'price' => $product['price'],
			'saleprice' => $product['saleprice'],
			'prix_acheteur' => intval($product['price']),
			'prix_acheteur_en_baisse' => intval($product['saleprice']),
			'weight' => strval($product['weight']),
			'images' => $product['images'],
			'sku' => $product['sku'],
			'shippable' => $product['shippable'],
			'fixed_quantity' => $product['fixed_quantity'],
			'track_stock' => $product['track_stock'],
			'taxable' => $product['taxable'],
			'quantity' => $product['quantity'],
			'enabled' => $product['enabled'],
			'related_products' => $product['related_products']
		);
		
		$this->db->set_dbprefix('');
		$this->db->where('article_ID', $id);
		$this->db->update('articles', $arr);
		$this->db->where('article_ID', $id);
		$this->db->update('articles_valides', $arr);
		$this->db->where('id', $id);
		$this->db->update('gc_en_products', $arr2);
		$this->db->set_dbprefix('gc_fr_');   						
									
	}
	
	function updateProductPoids($poids, $article_ID)
	{	
		$connection = array(
			'host_db' => "localhost", // nom de votre serveur
			'user_db' => "webmaster", // nom d'utilisateur de connexion ‡ votre bdd
			'password_db' => "m0rebeer", // mot de passe de connexion ‡ votre bdd
			'bdd_db' => "mom2mom_db" // nom de votre bdd
		);
		
		$mysqli = new mysqli($connection['host_db'], $connection['user_db'], $connection['password_db'], $connection['bdd_db']);
		
		$query = "UPDATE articles SET poids=? WHERE article_ID=?";	
		$stmt = mysqli_prepare($mysqli, $query);
		if (!$stmt) {
			die('mysqli error: ' . mysqli_error($mysqli));
		}
		mysqli_stmt_bind_param($stmt, 'di', $poids, $article_ID);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_free_result($stmt);
		
		$mysqli->close();
		
	}
	
}