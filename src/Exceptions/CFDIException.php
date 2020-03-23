<?php

namespace IvanSotelo\CfdiState\Exceptions;

class CFDIException extends \Exception
{
    protected $_data;

    public function __construct($message = '', $code = 0, Exception $previous = null, $_data = null)
    {
        $this->_data = $_data;
        parent::__construct($message, $code, $previous);
    }

    public function getErrors()
    {
        if (is_array($this->_data['errors'])) {
            $message_str = '';
            foreach ($this->_data['errors'] as $message) {
                $message_str .= "{$message}<br>";
            }
            return $message_str;
        }

        if (!isset($this->_data['errors'])) {
            return false;
        }

        $errors = $this->_data['errors'];

        return $errors;
    }
}