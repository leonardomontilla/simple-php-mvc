<?php 

namespace MVC\controllers;

/**
* Description of NewController
*/
class NewController extends \MVC\Controller
{

	public function index( $app )
	{
		$m = new \MVC\models\;
		$values = $m->all();
		return array("key" => $values);
	}

}
	