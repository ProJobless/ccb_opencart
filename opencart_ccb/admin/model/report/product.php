<?php
class ModelReportProduct extends Model {
	public function getProductsViewed($data = array()) {
		$sql = "SELECT pd.name, p.model, p.viewed FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.viewed > 0 ORDER BY p.viewed DESC";
					
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}	
	
	public function getTotalProductsViewed() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE viewed > 0");
		
		return $query->row['total'];
	}
	
	public function getTotalProductViews() {
      	$query = $this->db->query("SELECT SUM(viewed) AS total FROM " . DB_PREFIX . "product");
		
		return $query->row['total'];
	}
			
	public function reset() {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = '0'");
	}
	
	public function getPurchased($data = array()) {
		$sql = "SELECT op.name, op.model, SUM(op.quantity) AS quantity, SUM(op.total + op.total * op.tax / 100) AS total, manu.name as manuName, wc.title as weight_class, o.currency_code as currency_code 
			from `" . DB_PREFIX . "manufacturer` manu, 
			    `" . DB_PREFIX . "product` p,
			`" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (op.order_id = o.order_id) ,
			`" . DB_PREFIX . "weight_class_description` wc 
			WHERE o.order_status_id > '0'
			and op.product_id = p.product_id
			and p.manufacturer_id = manu.manufacturer_id  
                        and wc.weight_class_id = p.weight_class_id
                        and wc.language_id = 2";
			
		if (isset($data['filter_order_status_id']) && $data['filter_order_status_id']) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}
		
		if (isset($data['filter_date_start']) && $data['filter_date_start']) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (isset($data['filter_date_end']) && $data['filter_date_end']) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if (isset($data['filter_manufacturer']) && !is_null($data['filter_manufacturer'])) {
            $sql .= " AND manu.manufacturer_id = '" . $this->db->escape(strtolower($data['filter_manufacturer'])) . "'";
        }
		
		$sql .= " GROUP BY op.name ORDER BY total DESC";
					
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
		
		//echo "JAJA-->".$sql;
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getTotalPurchased($data) {
      	$sql = "SELECT * 
			FROM `" . DB_PREFIX . "product` p, `" . DB_PREFIX . "manufacturer` manu, `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "order_product` op ON (o.order_id = op.order_id) 
			WHERE op.product_id = p.product_id 
			and p.manufacturer_id = manu.manufacturer_id 
			and o.order_status_id > '0'" ;
			
		if (isset($data['filter_order_status_id']) && $data['filter_order_status_id']) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}
		
		if (isset($data['filter_date_start']) && $data['filter_date_start']) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (isset($data['filter_date_end']) && $data['filter_date_end']) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if (isset($data['filter_manufacturer']) && !is_null($data['filter_manufacturer'])) {
            $sql .= " AND manu.manufacturer_id = '" . $this->db->escape(strtolower($data['filter_manufacturer'])) . "'";
        }
		
		$query = $this->db->query($sql);

		return $query->num_rows;
	}
}
?>