<?php

/**
 * TechDivision\PersistenceContainerClient\Interfaces\RemoteObject
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

namespace TechDivision\PersistenceContainerClient\Interfaces;

/**
 * Interface for all remote objects.
 *
 * @category   Appserver
 * @package    TechDivision_PersistenceContainerClient
 * @subpackage Interfaces
 * @author     Tim Wagner <tw@techdivision.com>
 * @copyright  2014 TechDivision GmbH <info@techdivision.com>
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link       http://www.appserver.io
 */
interface RemoteObject
{

    /**
     * Returns the session instance.
     *
     * @return \TechDivision\PersistenceContainerClient\Interfaces\Session The session instance
     */
    public function getSession();

    /**
     * The name of the original object.
     *
     * @return string The name of the original object
     */
    public function getClassName();
}
