<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Main extends Controller {

	public function action_index()
    {
        $gateway_customer = new Gateway_Customer(Database::instance());
        $gateway_customer->add_customer($this->request->post());
    }

}
