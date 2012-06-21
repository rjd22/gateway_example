<?php
/**
 * @package
 * @author      Paul Schwarz <paulsschwarz@gmail.com>
 * @copyright   2012 Paul Schwarz
 * Date         09/06/12 15:11
 */
abstract class Model extends Kohana_Model {

    protected $_data = array();
    protected $_primary_key = 'id';

    public function __construct($values = NULL)
    {
        if ( ! is_null($values))
            $this->values($values, NULL, TRUE);
    }

    /**
     * Returns this model as an array
     *
     * @return array
     */
    public function as_array()
    {
        return $this->_data;
    }

    public function columns()
    {
        $columns = array_keys($this->_data);
        unset($columns[$this->_primary_key]);
        return $columns;
    }

    /**
     * Set values from an array. This method should be used for loading in post data, etc.
     *
     * @param  array $values   Array of column => val
     * @param  array $expected Array of keys to take from $values
     */
    public function values(array $values, array $expected = NULL, $allow_pk = FALSE)
    {
        // Default to expecting everything except the primary key
        if ($expected === NULL)
        {
            $expected = array_keys($this->_data);

            // Don't set the primary key by default
            if ( ! $allow_pk)
                unset($values[$this->_primary_key]);
        }

        foreach ($expected as $column)
        {
            if (array_key_exists($column, $values))
                $this->value($column, $values[$column]);
        }
    }

    public function value($key, $value = NULL)
    {
        if (isset($value))
        {
            $this->_data[$key] = $value;
        }
        else
        {
            return $this->_data[$key];
        }
    }

    /**
     * Runs business logic validations on this model.
     *
     * You can pass an existing validation object into this method.
     * This will let you add some application specific validations to
     * run on the model. Password validation is a good use case for
     * this.
     *
     * You can use the :model binding in your validation rules to
     * access this model object.
     *
     * @param Validation $validation a previously filled validation obj
     *
     * @return array
     */
    public function valid(Validation $validation = NULL, Validation $default_validation = NULL)
    {
        $data = $validation instanceof Validation
            ? $validation->copy($validation->data() + $this->as_array())
            : $default_validation;

        if ( ! $default_validation)
        {
            $data = new Validation($this->as_array());
        }

        $data->bind(':model', $this);

        foreach ($this->_rules as $field => $rules)
        {
            $data->rules($field, $rules);
        }

        if ($data->check(TRUE))
        {
            return TRUE;
        }
        else
        {
            throw new Validation_Exception($data);
        }
    }

}
