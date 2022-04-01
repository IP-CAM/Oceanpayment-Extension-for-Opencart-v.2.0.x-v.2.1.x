<?php 
class ControllerPaymentOPiDEAL extends Controller {
	private $error = array(); 

	public function index() {
		$this->load->language('payment/op_ideal');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('op_ideal', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_pay'] = $this->language->get('text_pay');
		$data['text_test'] = $this->language->get('text_test');	
		$data['text_select_all'] = $this->language->get('text_select_all');
		$data['text_unselect_all'] = $this->language->get('text_unselect_all');
		
		$data['entry_account'] = $this->language->get('entry_account');
		$data['entry_terminal'] = $this->language->get('entry_terminal');
		$data['entry_securecode'] = $this->language->get('entry_securecode');
		$data['entry_countries'] = $this->language->get('entry_countries');
		$data['entry_transaction'] = $this->language->get('entry_transaction');
	
		$data['entry_default_order_status'] = $this->language->get('entry_default_order_status');	
		$data['entry_success_order_status']=$this->language->get('entry_success_order_status');
		$data['entry_failed_order_status']=$this->language->get('entry_failed_order_status');
		$data['entry_pending_order_status']=$this->language->get('entry_pending_order_status');
		
		$data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$data['entry_code'] = $this->language->get('entry_code');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');



 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

 		if (isset($this->error['account'])) {
			$data['error_account'] = $this->error['account'];
		} else {
			$data['error_account'] = '';
		}

		if (isset($this->error['terminal'])) {
			$data['error_terminal'] = $this->error['terminal'];
		} else {
			$data['error_terminal'] = '';
		}		
		
 		if (isset($this->error['securecode'])) {
			$data['error_securecode'] = $this->error['securecode'];
		} else {
			$data['error_securecode'] = '';
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
   			'text' => $this->language->get('text_home'),
       		'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL'),
   		);

   		$data['breadcrumbs'][] = array(
       		'text' => $this->language->get('text_payment'),
   			'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
   		);

   		$data['breadcrumbs'][] = array(
       		'text' => $this->language->get('heading_title'),
   			'href' => $this->url->link('payment/op_ideal', 'token=' . $this->session->data['token'], 'SSL'),
   		);
				
		$data['action'] = $this->url->link('payment/op_ideal', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['op_ideal_account'])) {
			$data['op_ideal_account'] = $this->request->post['op_ideal_account'];
		} else {
			$data['op_ideal_account'] = $this->config->get('op_ideal_account');
		}
		
		if (isset($this->request->post['op_ideal_terminal'])) {
			$data['op_ideal_terminal'] = $this->request->post['op_ideal_terminal'];
		} else {
			$data['op_ideal_terminal'] = $this->config->get('op_ideal_terminal');
		}
		
		if (isset($this->request->post['op_ideal_securecode'])) {
			$data['op_ideal_securecode'] = $this->request->post['op_ideal_securecode'];
		} else {
			$data['op_ideal_securecode'] = $this->config->get('op_ideal_securecode');
		}
		
		
		$data['callback'] = HTTP_CATALOG . 'index.php?route=payment/op_ideal/callback';

		
		if (isset($this->request->post['op_ideal_transaction'])) {
			$data['op_ideal_transaction'] = $this->request->post['op_ideal_transaction'];
		} else {
			$data['op_ideal_transaction'] = $this->config->get('op_ideal_transaction');
		}
		

		if (isset($this->request->post['op_ideal_default_order_status_id'])) {
			$data['op_ideal_default_order_status_id'] = $this->request->post['op_ideal_default_order_status_id'];
		} else {
			$data['op_ideal_default_order_status_id'] = $this->config->get('op_ideal_default_order_status_id'); 
		} 
		/* add status */
		if (isset($this->request->post['op_ideal_success_order_status_id'])) {
			$data['op_ideal_success_order_status_id'] = $this->request->post['op_ideal_success_order_status_id'];
		} else {
			$data['op_ideal_success_order_status_id'] = $this->config->get('op_ideal_success_order_status_id'); 
		} 
		if (isset($this->request->post['op_ideal_failed_order_status_id'])) {
			$data['op_ideal_failed_order_status_id'] = $this->request->post['op_ideal_failed_order_status_id'];
		} else {
			$data['op_ideal_failed_order_status_id'] = $this->config->get('op_ideal_failed_order_status_id'); 
		} 
		if (isset($this->request->post['op_ideal_pending_order_status_id'])) {
			$data['op_ideal_pending_order_status_id'] = $this->request->post['op_ideal_pending_order_status_id'];
		} else {
			$data['op_ideal_pending_order_status_id'] = $this->config->get('op_ideal_pending_order_status_id');
		}
		
		
		$this->load->model('localisation/order_status');
		
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['op_ideal_geo_zone_id'])) {
			$data['op_ideal_geo_zone_id'] = $this->request->post['op_ideal_geo_zone_id'];
		} else {
			$data['op_ideal_geo_zone_id'] = $this->config->get('op_ideal_geo_zone_id'); 
		} 

		$this->load->model('localisation/geo_zone');
										
		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		
		if (isset($this->request->post['op_ideal_status'])) {
			$data['op_ideal_status'] = $this->request->post['op_ideal_status'];
		} else {
			$data['op_ideal_status'] = $this->config->get('op_ideal_status');
		}
		
		if (isset($this->request->post['op_ideal_sort_order'])) {
			$data['op_ideal_sort_order'] = $this->request->post['op_ideal_sort_order'];
		} else {
			$data['op_ideal_sort_order'] = $this->config->get('op_ideal_sort_order');
		}
		
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		
		$this->response->setOutput($this->load->view('payment/op_ideal.tpl', $data));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/op_ideal')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['op_ideal_account']) {
			$this->error['account'] = $this->language->get('error_account');
		}

		if (!$this->request->post['op_ideal_terminal']) {
			$this->error['terminal'] = $this->language->get('error_terminal');
		}		
		
		if (!$this->request->post['op_ideal_securecode']) {
			$this->error['securecode'] = $this->language->get('error_securecode');
		}
		
		return !$this->error;
	}
}
?>
