<?php
Class Category_model extends CI_Model
{

	function get_categories($parent = false)
	{
		if ($parent !== false)
		{
			$this->db->where("parent_id = $parent");
		}
		$this->db->select('id');
		$this->db->order_by('categories.sequence', 'ASC');
		
		//this will alphabetize them if there is no sequence
		$this->db->order_by('name', 'ASC');
		$result	= $this->db->get('categories');
		
		$categories	= array();
		foreach($result->result() as $cat)
		{
			$categories[]	= $this->get_category($cat->id);
		}
		
		return $categories;
	}
	
	function get_categories_drop_down_list_ids($parent = false)
	{
		if ($parent !== false)
		{
			$this->db->where("parent_id = $parent");
		}
		$this->db->select('id');
		$this->db->order_by('categories.sequence', 'ASC');
		
		//this will alphabetize them if there is no sequence
		$this->db->order_by('parent_id', 'ASC');
		//$this->db->order_by('name', 'ASC');
		$this->db->order_by('id', 'ASC');
		$result	= $this->db->get('categories');
		
		$categories	= array();
		foreach($result->result() as $cat)
		{
			$categories[]	= $this->get_category($cat->id);
		}
		
		return $categories;
	}
	
	function get_categories_drop_down_list_names($parent = false)
	{
		$this->db->select('id');
		$this->db->select('name');
		$this->db->select('parent_id');
		$this->db->order_by('parent_id', 'ASC');
		//$this->db->order_by('name', 'ASC');
		$this->db->order_by('id', 'ASC');
		$result	= $this->db->get('categories');
		
		$categories	= array();
		foreach($result->result() as $cat)
		{
			if($cat->parent_id != 0)
			{
				$categories[]	= $this->get_category_parent_name($cat->parent_id) . ' => ' . $cat->name;
			}
			else
			{
				$categories[]	= $cat->name;
			}
		}
		
		return $categories;
	}
	
	//this is for building a menu
	function get_categories_tierd($parent=0)
	{
		$categories	= array();
		$result	= $this->get_categories($parent);
		foreach ($result as $category)
		{
			$categories[$category->id]['category']	= $category;
			$categories[$category->id]['children']	= $this->get_categories_tierd($category->id);
		}
		return $categories;
	}
	
	function get_categories_tierd_ordered_by_parent_id($parent=0)
	{
		$categories	= array();
		$result	= $this->get_categories_drop_down_list_ids($parent);
		foreach ($result as $category)
		{
			$categories[$category->id]['category']	= $category;
			$categories[$category->id]['children']	= $this->get_categories_tierd($category->id);
		}
		return $categories;
	}
	
	function get_category($id)
	{
		return $this->db->get_where('categories', array('id'=>$id))->row();
	}
	
	function get_category_parent_name($parent_id)
	{
		$parent_name = $this->db->select('name')->where('id', $parent_id)->get('categories')->result();
		foreach ($parent_name as $name)
		{
			return $name->name;
		}
	}
	
	function get_category_products_admin($id)
	{
		$this->db->order_by('sequence', 'ASC');
		$result	= $this->db->get_where('category_products', array('category_id'=>$id));
		$result	= $result->result();
		
		$contents	= array();
		foreach ($result as $product)
		{
			$result2	= $this->db->get_where('products', array('id'=>$product->product_id));
			$result2	= $result2->row();
			
			$contents[]	= $result2;	
		}
		
		return $contents;
	}
	
	function get_category_products($id, $limit, $offset)
	{
		$this->db->order_by('sequence', 'ASC');
		$result	= $this->db->get_where('category_products', array('category_id'=>$id), $limit, $offset);
		$result	= $result->result();
		
		$contents	= array();
		$count		= 1;
		foreach ($result as $product)
		{
			$result2	= $this->db->get_where('products', array('id'=>$product->product_id));
			$result2	= $result2->row();
			
			$contents[$count]	= $result2;
			$count++;
		}
		
		return $contents;
	}
	
	function organize_contents($id, $products)
	{
		//first clear out the contents of the category
		$this->db->where('category_id', $id);
		$this->db->delete('category_products');
		
		//now loop through the products we have and add them in
		$sequence = 0;
		foreach ($products as $product)
		{
			$this->db->insert('category_products', array('category_id'=>$id, 'product_id'=>$product, 'sequence'=>$sequence));
			$sequence++;
		}
	}
	
	function save($category)
	{
		if ($category['id'])
		{
			$this->db->where('id', $category['id']);
			$this->db->update('categories', $category);
			
			return $category['id'];
		}
		else
		{
			$this->db->insert('categories', $category);
			return $this->db->insert_id();
		}
	}
	
	function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('categories');
		
		//delete references to this category in the product to category table
		$this->db->where('category_id', $id);
		$this->db->delete('category_products');
	}
	
	function get_base_url_slugs_to_names($base_url_array)
	{
		for($count=0; $count < count($base_url_array); $count+=1)
		{
			$base_ur_string = $this->db->escape_str("$base_url_array[$count]");
			
			$q_base_url_array = $this->db->query("SELECT name, slug FROM " . $this->db->dbprefix('categories') . " WHERE slug = '" . $base_ur_string . "'");
		
			if($q_base_url_array->num_rows() > 0) {
				foreach ($q_base_url_array->result() as $row) {
					$result_data [] = $row;
				}
			}
			
			$q_base_url_array->free_result();
		}
		
		return $result_data;
	}
	
	function get_header_urls()
	{
		$q_nature_array = $this->db->query("SELECT NOM FROM nature");
		if($q_nature_array->num_rows() > 0) {
			foreach ($q_nature_array->result() as $row_nature) {
				$result_nature [] = $row_nature->NOM;
			}
		}
			
		$q_nature_array->free_result();
		
		for($count=0; $count < count($result_nature); $count+=1)
		{
			$base_ur_string = $this->db->escape_str("$result_nature[$count]");
			
			$q_header_url_array = $this->db->query("SELECT name, slug FROM " . $this->db->dbprefix('categories') . " WHERE parent_ID = 0");
			
			$result_data = array();
			if($q_header_url_array->num_rows() > 0) {
				foreach ($q_header_url_array->result() as $row_header) {
					foreach ($result_nature as $name) {
						if($name == strtoupper($this->normalize_string($row_header->name)))
						{
							if (!in_array($row_header, $result_data))
							{
								$result_data [] = $row_header;
							}
						}
					}
				}
			}
			
			$q_header_url_array->free_result();
		}
		
		return $result_data;
	}
	
	
	
	////////////////////////////////////////////////////////////////// HELPER FUNCTIONS //////////////////////////////////////////////////////////////////
	
	function normalize_string($input_string)
	{
		$normalizeChars = array(
            'Á'=>'A', 'À'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Å'=>'A', 'Ä'=>'A', 'Æ'=>'AE', 'Ç'=>'C',
            'É'=>'E', 'È'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Í'=>'I', 'Ì'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ð'=>'Eth',
            'Ñ'=>'N', 'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O',
            'Ú'=>'U', 'Ù'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y',
   
            'á'=>'a', 'à'=>'a', 'â'=>'a', 'ã'=>'a', 'å'=>'a', 'ä'=>'a', 'æ'=>'ae', 'ç'=>'c',
            'é'=>'e', 'è'=>'e', 'ê'=>'e', 'ë'=>'e', 'í'=>'i', 'ì'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'eth',
            'ñ'=>'n', 'ó'=>'o', 'ò'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o',
            'ú'=>'u', 'ù'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y',
           
            'ß'=>'sz', 'þ'=>'thorn', 'ÿ'=>'y'
        );

        return strtr($input_string, $normalizeChars);
	}
	
	function array_flat( $a, $s = array( ), $l = 0 )
    {
        # check if this is an array
        if( !is_array( $a ) )                           return $s;
       
        # go through the array values
        foreach( $a as $k => $v )
        {
            # check if the contained values are arrays
            if( !is_array( $v ) )
            {
                # store the value
                $s[ ]       = $v;
               
                # move to the next node
                continue;
               
            }
           
            # increment depth level
            $l++;
           
            # replace the content of stored values
            $s              = array_flat( $v, $s, $l );
           
            # decrement depth level
            $l--;
           
        }
       
        # get only unique values
        if( $l == 0 ) $s = array_values( array_unique( $s ) );
       
        # return stored values
        return $s;
       
    } # end of function array_flat( ... 
}