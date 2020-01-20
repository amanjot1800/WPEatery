<?php    

	class menuItem {
		
		private $itemName;
		private $description;
		private $price;
		
		function __construct($itemName, $description, $price){
			$this->itemName = $itemName;
			$this->description = $description;
			$this->price = $price;
		}
		
		function get_itemName() {
			return $this->itemName;
		}
		function get_description() {
			return $this->description;
		}
		function get_price() {
			return $this->price;
		}
		
		
		
	} 
	
?>