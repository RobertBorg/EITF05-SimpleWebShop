<?php
class Product {
	private $m_product_id;
	private $m_name;
	private $m_price;
	public function __construct($product_id, $name, $price) {
		$this->m_product_id = $product_id;
		$this->m_name = $name;
		$this->m_price = $price;
	}
}
?>