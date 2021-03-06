<?php
class ControllerReportProductPurchased extends Controller { 
	public function index() {   
		$this->load->language('report/product_purchased');

		$this->document->setTitle($this->language->get('heading_title'));
		
		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}
		
		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}	
		
		// Add
		if (isset($this->request->get['filter_manufacturer'])) {
			$filter_manufacturer = $this->request->get['filter_manufacturer'];
		} else {
			$filter_manufacturer = NULL;
		}
		// End add
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
						
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		// Add
		if (isset($this->request->get['filter_manufacturer'])) {
                $url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
        }
		// End add
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);		
		
		$this->load->model('report/product');
		
		$this->data['products'] = array();
		
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			//Add
			'filter_manufacturer'    => $filter_manufacturer,
			// End
			'filter_order_status_id' => $filter_order_status_id,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
		
		// add
		$this->load->model('catalog/manufacturer');
		
		$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
		
		// End add
		
		$product_total = $this->model_report_product->getTotalPurchased($data);

		$results = $this->model_report_product->getPurchased($data);
		
		if (isset($this->request->get['option'])) {
			$option = $this->request->get['option'] ;
		}else{
			$option = 'filter' ;
		}
		
		
		
		if ($option =='filter'){
		
			foreach ($results as $result) {
				$this->data['products'][] = array(
					'name'       => $result['name'],
					'model'      => $result['model'],
					'quantity'   => $result['quantity'],
					'weight_class'   => $result['weight_class'],
					'manufacturer'   => $result['manuName'],
					'currency_code'   => $result['currency_code'],
					'total'      => $this->currency->format($result['total'], $this->config->get('config_currency'))
				);
			}
					
			$this->data['heading_title'] = $this->language->get('heading_title');
			
			$this->data['text_no_results'] = $this->language->get('text_no_results');
			$this->data['text_all_status'] = $this->language->get('text_all_status');
			
			$this->data['column_name'] = $this->language->get('column_name');
			$this->data['column_model'] = $this->language->get('column_model');
			$this->data['column_manufacturer'] = $this->language->get('column_manufacturer');
			$this->data['column_quantity'] = $this->language->get('column_quantity');
			$this->data['column_total'] = $this->language->get('column_total');
			
			$this->data['entry_date_start'] = $this->language->get('entry_date_start');
			$this->data['entry_date_end'] = $this->language->get('entry_date_end');
			$this->data['entry_status'] = $this->language->get('entry_status');

			// Add
			$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
			$this->data['button_csv'] = $this->language->get('button_csv');
			// End
		
			$this->data['button_filter'] = $this->language->get('button_filter');
			
			$this->data['token'] = $this->session->data['token'];
			
			$this->load->model('localisation/order_status');
			
			$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
			
			$url = '';
							
			if (isset($this->request->get['filter_date_start'])) {
				$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
			}
			
			if (isset($this->request->get['filter_date_end'])) {
				$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
			}

			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}
			
			// Add
			if (isset($this->request->get['filter_manufacturer'])) {
				$url .= '&filter_manufacturer=' . $this->request->get['filter_manufacturer'];
			}
			// End add
			
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('config_admin_limit');
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'] . $url . '&page={page}');
				
			$this->data['pagination'] = $pagination->render();		
			
			$this->data['filter_date_start'] = $filter_date_start;
			$this->data['filter_date_end'] = $filter_date_end;		
			$this->data['filter_order_status_id'] = $filter_order_status_id;
			//Add
			$this->data['filter_manufacturer'] = $filter_manufacturer ;
			// End add
			
			$this->template = 'report/product_purchased.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);
					
			$this->response->setOutput($this->render());
		
		}else{
		
			$csv_output ="<table border=1> ";
			$csv_output .="<tr style='background-color:yellow;'>";
			$csv_output .="<th>".$this->language->get('column_name')."</th> ";
			$csv_output .="<th>".$this->language->get('column_model')."</th> ";
			$csv_output .="<th>".$this->language->get('column_manufacturer')."</th> ";
			$csv_output .="<th>".$this->language->get('column_quantity')."</th> ";
			$csv_output .="<th>".$this->language->get('column_total')."</th> ";
			$csv_output .="</tr> ";

			foreach ($results as $result) {
				$total      = $this->currency->format($result['total'], $this->config->get('config_currency')) ;

			
				$csv_output .="<tr> ";
				$csv_output .= '<td>' .$result['name']."</td>";
				$csv_output .= '<td>' .$result['model']. "</td>";
				$csv_output .= '<td>' .$result['manuName']. "</td>";
				$csv_output .= '<td>' .$result['quantity']. "</td>";				
				$csv_output .= '<td>' .$total."</td>";
				$csv_output .="</tr> ";
			}
			$csv_output .="</table> ";

			$filename = "OC_Product_Purchased_".date("d-m-Y",time());
			header("Content-type: application/vnd.ms-excel");
			//header("Content-disposition: xls" . date("Y-m-d") . ".xls");
			header( "Content-disposition: filename=".$filename.".xls");
			print $csv_output;
			exit;
		
		}
	}	
}
?>