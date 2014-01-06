<?php
/**
 * Released under GPL v3 License
 * Developed by Ugo R. Piemontese <http://www.ugopiemontese.eu>
 */

class ControllerShippingCategory extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->load->language('shipping/category');

		//$this->document->title = $this->language->get('heading_title');  SIMPLE WORKAROUND FOR PERMISSIONS ERROR
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('category', $this->request->post);
                        $this->session->data['success'] = $this->language->get('text_success');	
			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/shipping&token=' . $this->session->data['token']);
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_cost'] = $this->language->get('entry_cost');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

  		$this->document->breadcrumbs = array();

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=common/home&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=extension/shipping&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('text_shipping'),
      		'separator' => ' :: '
   		);
		
   		$this->document->breadcrumbs[] = array(
       		'href'      => HTTPS_SERVER . 'index.php?route=shipping/category&token=' . $this->session->data['token'],
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = HTTPS_SERVER . 'index.php?route=shipping/category&token=' . $this->session->data['token'];
		
		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/shipping&token=' . $this->session->data['token'];
		
		if (isset($this->request->post['category_cost'])) {
			$this->data['category_cost'] = $this->request->post['category_cost'];
		} else {
			$this->data['category_cost'] = $this->config->get('category_cost');
		}

		if (isset($this->request->post['category_tax_class_id'])) {
			$this->data['category_tax_class_id'] = $this->request->post['category_tax_class_id'];
		} else {
			$this->data['category_tax_class_id'] = $this->config->get('category_tax_class_id');
		}

		if (isset($this->request->post['category_geo_zone_id'])) {
			$this->data['category_geo_zone_id'] = $this->request->post['category_geo_zone_id'];
		} else {
			$this->data['category_geo_zone_id'] = $this->config->get('category_geo_zone_id');
		}
		
		if (isset($this->request->post['category_status'])) {
			$this->data['category_status'] = $this->request->post['category_status'];
		} else {
			$this->data['category_status'] = $this->config->get('category_status');
		}
		
		if (isset($this->request->post['category_sort_order'])) {
			$this->data['category_sort_order'] = $this->request->post['category_sort_order'];
		} else {
			$this->data['category_sort_order'] = $this->config->get('category_sort_order');
		}				

		$this->load->model('localisation/tax_class');
		
		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		//get all categories
		$this->load->model('catalog/category');
                $this->data['categories']=$this->model_catalog_category->getCategories();

		//set all costs
                foreach($this->data['categories'] as $foo)
                {
                    $val="";
                    $key='category_cost_'.$foo["category_id"];
                    $this->data['category_cost_arr'][$foo["category_id"]]=$this->config->get($key);
                }

                $this->template = 'shipping/category.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}
?>
