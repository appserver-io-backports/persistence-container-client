<?php

/**
 * TechDivision\PersistenceContainerClient\Context\Connection\Factory
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

namespace TechDivision\PersistenceContainerClient\Context\Connection;

use TechDivision\PersistenceContainerClient\Context\ContextConnection;

/**
 * Connection factory to create a new context connection.
 * 
 * @category   Appserver
 * @package    TechDivision_PersistenceContainerClient
 * @subpackage Context
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.appserver.io
 */
class Factory
{

    /**
     * The instance as singleton.
     * 
     * @var \TechDivision\PersistenceContainerClient\Interfaces\Connection 
     */
    protected static $instance = null;

    /**
     * Simple factory to create a new context connection 
     * of the requested type.
     * 
     * @return \TechDivision\PersistenceContainerClient\Interfaces\Connection The requested context connection
     */
    public static function createContextConnection()
    {
        if (self::$instance == null) {
            self::$instance = new ContextConnection();
        }
        return self::$instance;
    }
}
