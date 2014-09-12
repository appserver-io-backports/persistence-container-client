<?php

/**
 * TechDivision\PersistenceContainerClient\RemoteConnectionFactory
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

use TechDivision\Collections\ArrayList;
use TechDivision\PersistenceContainerProtocol\RemoteMethodCallParser;

/**
 * Connection factory to create a new remote context connection.
 *
 * @category  Library
 * @package   TechDivision_PersistenceContainerClient
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_PersistenceContainerClient
 * @link      http://www.appserver.io
 */
class RemoteConnectionFactory
{

    /**
     * Private constructor to use class only in static context.
     *
     * @return void
     */
    private function __construct()
    {
    }

    /**
     * Simple factory to create a new context connection
     * of the requested type.
     *
     * @return \TechDivision\PersistenceContainerClient\Connection The requested context connection
     */
    public static function createContextConnection()
    {

        // initialize the remote method call parser and the session storage
        $sessions = new ArrayList();
        $parser = new RemoteMethodCallParser();

        // initialize the remote context connection
        $contextConnection = new RemoteContextConnection();
        $contextConnection->injectParser($parser);
        $contextConnection->injectSessions($sessions);

        // return the initialized connection
        return $contextConnection;
    }
}
