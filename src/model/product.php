<?php
class Product {
	public $m_product_id;
	public $m_name;
	public $m_price;
	public function __construct($product_id, $name, $price) {
		$this->m_product_id = $product_id;
		$this->m_name = $name;
		$this->m_price = $price;
	}
}
?>