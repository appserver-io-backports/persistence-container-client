<?php

/**
 * TechDivision\PersistenceContainerClient\Proxy
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

use TechDivision\PersistenceContainerClient\Interfaces\Session;
use TechDivision\PersistenceContainerClient\Interfaces\RemoteObject;
use TechDivision\PersistenceContainerClient\Interfaces\RemoteMethod;

/**
 * The proxy is used to create a new remote object of the 
 * class with the requested name.
 * 
 * namespace TechDivision\PersistenceContainerClient;
 * 
 * use TechDivision\PersistenceContainerClient\Context\Connection\Factory;
 * 
 * $connection = Factory::createContextConnection();
 * $session = $connection->createContextSession();
 * $initialContext = $session->createInitialContext();
 *
 * $processor = $initialContext->lookup('Some\ProxyClass');
 * 
 * @category  Appserver
 * @package   TechDivision_PersistenceContainerClient
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      http://www.appserver.io
 */
class Proxy implements RemoteObject
{

    /**
     * Holds the ContextSession for this proxy.
     * 
     * @var TechDivision\PersistenceContainerClient\Interfaces\Session
     */
    protected $session = null;

    /**
     * The class name to proxy.
     * 
     * @var string
     */
    protected $className = null;

    /**
     * Initializes the proxy with the class name to proxy.
     * 
     * @param string $className The name of the class to create the proxy for 
     * 
     * @return void
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * The name of the original object.
     * 
     * @return string The name of the original object
     * @see TechDivision\PersistenceContainerClient\Interfaces\RemoteObject::getClassName()
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Sets the session with the connection instance.
     * 
     * @param TechDivision\PersistenceContainerClient\Interfaces\Session $session The session instance to use
     * 
     * @return \TechDivision\PersistenceContainerClient\Interfaces\RemoteObject The instance itself
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * Returns the session instance.
     * 
     * @return TechDivision\PersistenceContainerClient\Interfaces\Session The session instance
     * @see TechDivision\PersistenceContainerClient\Interfaces\RemoteObject::getSession()
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Invokes the remote execution of the passed remote method.
     * 
     * @param string $method The remote method to call
     * @param array  $params The parameters for the method call
     * 
     * @return mixed The result of the remote method call
     */
    public function __call($method, $params)
    {
        $methodCall = new RemoteMethodCall($this->getClassName(), $method, $this->getSession()->getSessionId());
        foreach ($params as $key => $value) {
            $methodCall->addParameter($key, $value);
        }
        return $this->__invoke($methodCall, $this->getSession());
    }

    /**
     * Invokes the remote execution of the passed remote method.
     * 
     * @param \TechDivision\PersistenceContainerClient\Interfaces\RemoteMethod $methodCall The remote method call instance
     * @param \TechDivision\PersistenceContainerClient\Interfaces\Session      $session    The session with the connection instance to use
     * 
     * @return void
     */
    public function __invoke(RemoteMethod $methodCall, Session $session)
    {
        return $this->setSession($session)->getSession()->send($methodCall);
    }

    /**
     * Factory method to create a new instance of the requested proxy implementation.
     * 
     * @param string $className The name of the class to create the proxy for
     * 
     * @return \TechDivision\PersistenceContainerClient\Interfaces\RemoteObject The proxy instance
     */
    public static function create($className)
    {
        return new Proxy($className);
    }
}
