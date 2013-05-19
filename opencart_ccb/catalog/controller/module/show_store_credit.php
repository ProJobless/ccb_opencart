<?php
class ControllerModuleShowStoreCredit extends Controller {

	protected function index($setting) {
		$this->name = basename(__FILE__, '.php');

		if ($this->customer->isLogged() && $setting['store_id'] == $this->config->get('config_store_id')) {
		
			$this->data = array_merge($this->data, $this->load->language('module/' . $this->name));
			
      $this->data['heading_title'] = $setting['language_id'][$this->config->get('config_language_id')];
			
			$this->load->model('account/transaction');
			$this->data['total_pedidos'] = $this->currency->format($this->model_account_transaction->getTotalPedidosAmount());
			$this->data['total_gastos'] = $this->currency->format($this->model_account_transaction->getTotalGastosAmount());			
			
			$this->data['balance'] = $this->currency->format($this->customer->getBalance(), $this->currency->getCode());
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/'.$this->name.'.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/'.$this->name.'.tpl';
			} else {
				$this->template = 'default/template/module/'.$this->name.'.tpl';
			}

			$this->render();
		}
  	}

}
?>