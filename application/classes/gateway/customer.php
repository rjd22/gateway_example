<?php
/**
 * @package
 * @author      Paul Schwarz <paulsschwarz@gmail.com>
 * @copyright   2012 Paul Schwarz
 * Date         09/06/12 15:55
 */
class Gateway_Customer extends Gateway {

    protected $_table = 'customers';

    public function add_customer($post)
    {
        $customer = new Model_Customer;
        $customer->values($post);
        $this->create($customer);

        return $customer;
    }

    public function find_customer($code)
    {
        $query = DB::select()
            ->from($this->_table)
            ->where('code', '=', $code);

        $values = $query->execute($this->_db);

        if ($values->count())
        {
            return new Model_Customer($values->current());
        }
        else
        {
            throw new Kohana_Exception_ModelNotFound(__('Model not found ":table::id".',
                array(
                    ':table' => $this->_table,
                    ':id' => $code,
                )
            ));
        }
    }

}
