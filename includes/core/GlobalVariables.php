<?php


namespace Wp\Core;


final class GlobalVariables implements \ArrayAccess
{

    private static $instance = null;
    private $variables = array();

//+-----------------------------------------------------------------------------------------------------------------+//
/*
 *  Constructor
 */
//+-----------------------------------------------------------------------------------------------------------------+//
        private function __construct()
        {
            return $this;
        }
//+-----------------------------------------------------------------------------------------------------------------+//
/*
 *
 */
//+-----------------------------------------------------------------------------------------------------------------+//
        public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
//+-----------------------------------------------------------------------------------------------------------------+//
    /*
     *
     */
//+-----------------------------------------------------------------------------------------------------------------+//
    /**
     * Whether a offset exists
     * @link https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
        return isset($this->variables[$offset]);
    }
//+-----------------------------------------------------------------------------------------------------------------+//
    /*
     *
     */
//+-----------------------------------------------------------------------------------------------------------------+//
    /**
     * Offset to retrieve
     * @link https://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
        return $this->offsetExists($offset) ? $this->variables[$offset] : null;
    }
//+-----------------------------------------------------------------------------------------------------------------+//
    /*
     *
     */
//+-----------------------------------------------------------------------------------------------------------------+//
    /**
     * Offset to set
     * @link https://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return bool
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
        if (is_null($offset)) {
            $this->variables[] = $value;
            return TRUE;
        } else {
            if(!$this->offsetExists($offset))
            {
                $this->variables[$offset] = $value;
                if($this->offsetGet($offset)===$value)return TRUE;
            }
        }
        return FALSE;
    }
//+-----------------------------------------------------------------------------------------------------------------+//
    /*
     *
     */
//+-----------------------------------------------------------------------------------------------------------------+//
   public function offsetUpdate($offset, $value)
   {
       // TODO: Implement offsetSet() method.

           if($this->offsetExists($offset))$this->variables[$offset] = $value;
           if($this->offsetGet($offset)===$value)return TRUE;
    return FALSE;
   }
//+-----------------------------------------------------------------------------------------------------------------+//
    /*
     *
     */
//+-----------------------------------------------------------------------------------------------------------------+//
    /**
     * Offset to unset
     * @link https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return bool
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
        if($this->offsetExists($offset)) {
            $this->variables[$offset] = null;
            unset($this->variables[$offset]);
        }
        if(!$this->offsetExists($offset)) return TRUE;
        return FALSE;
    }
//+-----------------------------------------------------------------------------------------------------------------+//
/*
 *
 */
//+-----------------------------------------------------------------------------------------------------------------+//

}