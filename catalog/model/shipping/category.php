<?php
/**
 * Released under GPL v3 License
 * Developed by Ugo R. Piemontese <http://www.ugopiemontese.eu>
 */

class ModelShippingCategory extends Model {
	function getQuote($address) {
		$this->load->language('shipping/category');
		
		if ($this->config->get('category_status')) {
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('flat_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		
      		if (!$this->config->get('flat_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
        		$status = TRUE;
      		} else {
        		$status = FALSE;
      		}
		} else {
			$status = FALSE;
		}

		$method_data = array();
	
		if ($status) {
			$quote_data = array();

                //get cart products & category

		$this->load->model('catalog/product');

                $cost=0;
                $cost_arr=array();
                $prods=$this->cart->getProducts();

                foreach($prods as $foo){
                    //get category
                    $obj_prod=$this->model_catalog_product->getProduct($foo["product_id"]);
		    $categories = $this->model_catalog_product->getCategories($foo['product_id']);
		    $cat_cost=$this->config->get('category_cost_'.$categories[0]["category_id"]);
		    $cost_arr[$categories[0]["category_id"]]=$cat_cost;
                }

                //get minimum of all costs
		$cost = 0;
                foreach($cost_arr as $fooid=>$val){
		    if ($cost < $val)  
			$cost = $val;
                }

                $this->config->get('category_cost');

      		$quote_data['category'] = array(
        		'code'         => 'category.category',
        		'title'        => $this->language->get('text_title'),
        		'cost'         => $cost,
        		'tax_class_id' => $this->config->get('category_tax_class_id'),
                        'text'         => $this->currency->format($this->tax->calculate($cost, $this->config->get('category_tax_class_id'), $this->config->get('config_tax')))
      		);

      		$method_data = array(
        		'id'         => 'category',
        		'title'      => $this->language->get('text_title'),
        		'quote'      => $quote_data,
			'sort_order' => $this->config->get('category_sort_order'),
        		'error'      => FALSE
      		);
		}
	
		return $method_data;
	}

}
?>
