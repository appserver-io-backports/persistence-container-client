<?php

/**
 * TechDivision\PersistenceContainerClient\ContextConnectionTest
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
 * Test for the context connection instance.
 *
 * @category  Library
 * @package   TechDivision_PersistenceContainerClient
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_PersistenceContainerClient
 * @link      http://www.appserver.io
 */
class ContextConnectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * The application name for testing purposes.
     *
     * @var string
     */
    const APP_NAME = 'testApp';

    /**
     * An IP address for testing purposes.
     *
     * @var string
     */
    const ADDRESS = '127.0.0.1';

    /**
     * A port number for testing purposes.
     *
     * @var integer
     */
    const PORT = 1234;

    /**
     * Tests the constructor of the context connection.
     *
     * @return void
     */
    public function testConstructor()
    {
        $contextConnection = $this->getMock(ContextConnection::class, null, array(ContextConnectionTest::APP_NAME));
        $this->assertEquals(ContextConnectionTest::APP_NAME, $contextConnection->getAppName());
    }

    /**
     * Tests the setter/getter for the IP address.
     *
     * @return void
     */
    public function testSetterAndGetterForAddress()
    {
        $contextConnection = $this->getMock(ContextConnection::class, null, array(ContextConnectionTest::APP_NAME));
        $contextConnection->setAddress(ContextConnectionTest::ADDRESS);
        $this->assertSame(ContextConnectionTest::ADDRESS, $contextConnection->getAddress());
    }

    /**
     * Tests the setter/getter for the port.
     *
     * @return void
     */
    public function testSetterAndGetterForPort()
    {
        $contextConnection = $this->getMock(ContextConnection::class, null, array(ContextConnectionTest::APP_NAME));
        $contextConnection->setPort(ContextConnectionTest::PORT);
        $this->assertSame(ContextConnectionTest::PORT, $contextConnection->getPort());
    }
}
