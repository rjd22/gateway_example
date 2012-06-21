<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Gateway base class. All Gateways should extend this.
 *
 * @package
 * @author      Paul Schwarz <paulsschwarz@gmail.com>
 * @copyright   2012 Paul Schwarz
 * Date         09/06/12 15:54
 */
abstract class Gateway {

    protected $_db;
    protected $_table;

    /**
     * Create a new gateway instance.
     *
     *     $model = Gateway::factory($name);
     *
     * @param   string  gateway name
     * @return  Gateway
     */
    public static function factory($name, $db)
    {
        // Add the model prefix
        $class = 'Gateway_'.$name;

        return new $class($db);
    }

    public function __construct(Database $db)
    {
        $this->_db = $db;
    }

    public function create(Model $model, Validation $validation = NULL, Validation $default_validation = NULL)
    {
        $model->valid($validation, $default_validation);
        return DB::insert($this->_table)
            ->columns($model->columns())
            ->values($model->as_array())
            ->execute($this->_db);
    }


} // End Gateway
