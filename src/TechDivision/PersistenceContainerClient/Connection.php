<?php

/**
 * TechDivision\PersistenceContainerClient\Connection
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
interface Connection
{

    /**
     * Creates the connection to the container.
     *
     * @return void
     */
    public function connect();

    /**
     * Shutdown the connection to the container.
     *
     * @return void
     */
    public function disconnect();

    /**
     * Sends the remote method call to the container instance.
     *
     * @param \TechDivision\PersistenceContainerProtocol\RemoteMethod $remoteMethod The remote method to invoke
     *
     * @return mixed The response from the container
     */
    public function send(RemoteMethod $remoteMethod);

    /**
     * Initializes a new session instance.
     *
     * @return \TechDivision\PersistenceContainerProtocol\Session The session instance
     */
    public function createContextSession();

    /**
     * Returns the socket the connection is based on.
     *
     * @return \TechDivision\Socket\Client The socket instance
     */
    public function getSocket();
}
