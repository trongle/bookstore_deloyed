<?php

namespace ZendVN\Model\Entity;

class Order
{
	public $id;
 	public $names;
 	public $books;
 	public $pictures;
 	public $username;
 	public $date;
 	public $status;
 	public $qty;
 	public $prices;
 	

	public function exchangeArray($data){
		$this->id       = (!empty($data['id']))         ? $data['id']              :"";
		$this->names    = (!empty($data['names']))      ? $data['names']           :"";
		$this->books    = (!empty($data['books']))      ? $data['books']           :"";
		$this->pictures = (!empty($data['pictures']))   ? $data['pictures']        :"";
		$this->username = (!empty($data['username']))   ? $data['username']        :"";
		$this->date     = (!empty($data['date']))       ? $data['date']            :"";
		$this->status   = (!empty($data['status']))     ? $data['status']          :"";
		$this->qty      = (!empty($data['qty']))        ? $data['qty']             :"";
		$this->prices   = (!empty($data['prices']))     ? $data['prices']          :"";

	}

}
?>