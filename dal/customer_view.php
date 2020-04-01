
<?php 

	include_once(ROOT_PATH. 'db.php'); 
	class CustomerView {

		public function get_customerid($id_type, $id_value) {

			$id = ($id_type == "id") ? $id_value : "";
			$esport_id = ($id_type == "esport_id") ? $id_value : "";
			$other_id = ($id_type == "other_id") ? $id_value : "";

			$sql = "";
			switch ($id_type) {
				case "ID":
				$sql = "SELECT cuid FROM tb_customer WHERE id = ?";
				break;
				case "ESPORT_ID":
				$sql = "SELECT cuid FROM tb_customer WHERE esport_id = ?";
				break;
				case "OTHER_ID":
				$sql = "SELECT cuid FROM tb_customer WHERE other_id = ?";
				break;
				default:
					$sql = "SELECT cuid FROM tb_customer WHERE id = ?";
			}

			$db = new db();
			$customer = $db->query($sql, $id_value)->fetchArray();
			$db->close();

			return $customer == NULL ? NULL : $customer['cuid'];
		}

		public function add_customer($id_type, $id_value) {

			$id = ($id_type == "ID") ? $id_value : "";
			$esport_id = ($id_type == "ESPORT_ID") ? $id_value : "";
			$other_id = ($id_type == "OTHER_ID") ? $id_value : "";

			$db = new db();
			$customer = $db->query('
				INSERT INTO tb_customer(id, esport_id, other_id) VALUES(?, ?, ?)',
				$id, $esport_id, $other_id
			);
			$cuid = $db->lastInsertID();
			$db->close();

			return $cuid;
		}

		public function get_customer_by_id($cuid) {

			$db = new db();
			$customer = $db->query('SELECT * FROM tb_customer WHERE cuid = ?', $cuid)->fetchArray();
			$db->close();

			return $customer;
		}
	}
?>