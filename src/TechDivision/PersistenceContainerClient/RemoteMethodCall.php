<?php

/**
 * TechDivision\PersistenceContainerClient\RemoteMethodCall
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @category  Appserver
 * @package   TechDivision_PersistenceContainerClient
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.appserver.io
 */

namespace TechDivision\PersistenceContainerClient;

use TechDivision\PersistenceContainerClient\Interfaces\RemoteMethod;

/**
 * Abstract base class of the Maps.
 * 
 * @category  Appserver
 * @package   TechDivision_PersistenceContainerClient
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.appserver.io
 */
class RemoteMethodCall implements RemoteMethod
{

    /**
     * The class name to invoke the method on.
     * 
     * @var string
     */
    protected $className = null;

    /**
     * The method name to invoke on the class.
     * 
     * @var string
     */
    protected $methodName = null;

    /**
     * Parameters for the method.
     * 
     * @var array
     */
    protected $parameters = array();

    /**
     * The session ID to use for the method call.
     * 
     * @var string
     */
    protected $sessionId = null;

    /**
     * The client's socket server IP address to send the response to.
     * 
     * @var string 
     */
    protected $address = '127.0.0.1';

    /**
     * The client's socket server port to send the response to.
     * 
     * @var integer 
     */
    protected $port = 0;

    /**
     * Initialize the instance with the necessary params.
     * 
     * @param string $className  The class name to invoke the method on
     * @param string $methodName The method name to invoke
     * @param string $sessionId  The session ID to use for the method call
     * 
     * @return void
     */
    public function __construct($className, $methodName, $sessionId = null)
    {
        $this->className = $className;
        $this->methodName = $methodName;
        $this->sessionId = $sessionId;
    }

    /**
     * Adds passed parameter to the array with the parameters.
     * 
     * @param integer $key   The parameter name
     * @param mixed   $value The parameter value
     * 
     * @return void
     */
    public function addParameter($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     * Returns the parameter with the passed key.
     * 
     * @param string $key The name of the parameter to return
     * 
     * @return mixed The parameter's value
     * @see TechDivision\PersistenceContainerClient\Interfaces\RemoteMethod::getParameter()
     */
    public function getParameter($key)
    {
        return $this->parameters[$key];
    }

    /**
     * Returns the parameters for the method.
     * 
     * @return array The method's parameters
     * @see TechDivision\PersistenceContainerClient\Interfaces\RemoteMethod::getParameters()
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Returns the class name to invoke the method on.
     * 
     * @return string The class name
     * @see TechDivision\PersistenceContainerClient\Interfaces\RemoteMethod::getClassName()
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Returns the method name to invoke on the class.
     * 
     * @return string The method name
     * @see TechDivision\PersistenceContainerClient\Interfaces\RemoteMethod::getMethodName()
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * Returns the session ID to use for the method call.
     * 
     * @return string The session ID
     * @see TechDivision\PersistenceContainerClient\Interfaces\RemoteMethod::getSessionId()
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Sets the client's socket server IP address.
     * 
     * @param string $address The client's socket server IP address
     * 
     * @return void
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Returns the client's server socket IP address.
     * 
     * @return string The client's server socket IP address
     * @see TechDivision\PersistenceContainerClient\Interfaces\RemoteMethod::getAddress()
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets the client's socket server port.
     * 
     * @param integer $port The client's socket server port
     * 
     * @return void
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * Returns the client's server socket port.
     * 
     * @return string The client's server socket port
     * @see TechDivision\PersistenceContainerClient\Interfaces\RemoteMethod::getPort()
     */
    public function getPort()
    {
        return $this->port;
    }
}
