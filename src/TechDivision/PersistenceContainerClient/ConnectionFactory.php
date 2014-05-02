<?php

/**
 * TechDivision\PersistenceContainerClient\ConnectionFactory
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

/**
 * Connection factory to create a new context connection.
 * 
 * @category  Library
 * @package   TechDivision_PersistenceContainerClient
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_PersistenceContainerClient
 * @link      http://www.appserver.io
 */
class ConnectionFactory
{

    /**
     * The instances as singletons.
     *
     * @var array
     */
    protected static $instance = array();

    /**
     * Simple factory to create a new context connection
     * of the requested type.
     *
     * @param string $appName Name of the webapp using this client connection
     *
     * @return \TechDivision\PersistenceContainerClient\Connection The requested context connection
     */
    public static function createContextConnection($appName)
    {
        if (self::$instance[$appName] == null) {
            self::$instance[$appName] = new ContextConnection($appName);
        }
        return self::$instance[$appName];
    }
}
