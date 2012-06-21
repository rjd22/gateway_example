<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * @package
 * @author      Paul Schwarz <paulsschwarz@gmail.com>
 * @copyright   2012 Paul Schwarz
 * Date         07/06/12 15:56
 */

class Model_Customer extends Model
{
    protected $_data = array(
        'id' => NULL,
        'first_name' => NULL,
        'last_name' => NULL,
        'email' => NULL,
    );

    protected $_rules = array(
        'email' => array(
            array('not_empty'),
            array('email'),
        ),
        'first_name' => array(
            array('not_empty'),
        ),
        'last_name' => array(
            array('not_empty'),
        ),
    );

    public function name()
    {
        return Arr::get($this->_data, 'first_name').' '.Arr::get($this->_data, 'last_name');
    }

}
