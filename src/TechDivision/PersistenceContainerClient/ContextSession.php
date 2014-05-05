<?php

/**
 * TechDivision\PersistenceContainerClient\ContextSession
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 * 
 * @category  Library
 * @package   TechDivision_PersistenceContainerClient
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_PersistenceContainerClient
 * @link      http://www.appserver.io
 */

namespace TechDivision\PersistenceContainerClient;

use TechDivision\PersistenceContainerProtocol\Session;
use TechDivision\PersistenceContainerProtocol\RemoteMethod;

/**
 * The interface for the remote connection.
 * 
 * @category  Library
 * @package   TechDivision_PersistenceContainerClient
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_PersistenceContainerClient
 * @link      http://www.appserver.io
 */
class ContextSession implements Session
{

    /**
     * The connection instance.
     *
     * @var \TechDivision\PersistenceContainerClient\Connection
     */
    protected $connection = null;

    /**
     * The session ID used for the connection.
     *
     * @var string
     */
    protected $sessionId = null;

    /**
     * Initializes the session with the connection.
     *
     * @param \TechDivision\PersistenceContainerClient\Connection $connection The connection for the session
     *
     * @return void
     */
    public function __construct(Connection $connection)
    {
        // initialize the connection
        $this->connection = $connection;
        // check if already a session id exists in the session
        if (($this->sessionId = session_id()) == null) {
            // if not, create a unique ID
            $this->sessionId = uniqid();
        }
    }

    /**
     * Returns the ID of the session to use.
     *
     * @return string The session ID
     * @see \TechDivision\PersistenceContainerProtocol\Session::getSessionId()
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }
    
    /**
     * The session ID to use.
     * 
     * @param string $sessionId The session ID to use
     */
    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * Invokes the remote method over the connection.
     *
     * @param \TechDivision\PersistenceContainerProtocol\RemoteMethod $remoteMethod The remote method call to invoke
     *
     * @return mixed the method return value
     * @see TechDivision\PersistenceContainerProtocol\Session::send()
     * @todo Refactor to replace check for 'setSession' method, e. g. check for an interface
     */
    public function send(RemoteMethod $remoteMethod)
    {
        // connect to the container
        $this->connection->connect();
        $response = $this->connection->send($remoteMethod);
        // check if a proxy has been returned
        if (method_exists($response, 'setSession')) {
            $response->setSession($this);
        }
        // close the connection
        $this->connection->disconnect();
        return $response;
    }

    /**
     * Creates a remote inital context instance.
     *
     * @return \TechDivision\PersistenceContainerProtocol\RemoteObject The proxy for the inital context
     * @see \TechDivision\PersistenceContainerProtocol\Session::createInitialContext()
     */
    public function createInitialContext()
    {
        $initialContext = new InitialContext();
        $initialContext->setSession($this);
        return $initialContext;
    }
}
