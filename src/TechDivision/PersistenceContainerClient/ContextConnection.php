<?php

/**
 * TechDivision\PersistenceContainerClient\Context\ContextConnection
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


use Guzzle\Http\Client;
use TechDivision\PersistenceContainerClientContextSession;
use TechDivision\PersistenceContainerClientConnection;
use TechDivision\PersistenceContainerProtocol\RemoteMethod;
use TechDivision\PersistenceContainerProtocol\RemoteMethodProtocol;
use TechDivision\PersistenceContainerProtocol\RemoteMethodCallParser;

/**
 * Connection implementation to invoke a remote method call over a socket.
 *
 * @category  Library
 * @package   TechDivision_PersistenceContainerClient
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_PersistenceContainerClient
 * @link      http://www.appserver.io
 */
class ContextConnection implements Connection
{

    /**
     * The default transport to use.
     *
     * @var string
     */
    const DEFAULT_SCHEME = 'http';

    /**
     * The default client sockets IP address.
     *
     * @var string
     */
    const DEFAULT_HOST = '127.0.0.1';

    /**
     * The default client sockets port.
     *
     * @var integer
     */
    const DEFAULT_PORT = 8585;

    /**
     * The name of the webapp using this client connection.
     *
     * @var string
     */
    protected $appName;

    /**
     * The ArrayObject for the sessions.
     *
     * @var \ArrayObject
     */
    protected $sessions = null;

    /**
     * Parser to process the remote method call.
     *
     * @var \TechDivision\PersistenceContainerProtocol\RemoteMethodCallParser
     */
    protected $parser;

    /**
     * The HTTP client we use for connection to the persistence container.
     *
     * @var \Guzzle\Http\Client
     */
    protected $client;

    /**
     * Initializes the connection.
     *
     * @param string $appName Name of the webapp using this client connection
     */
    public function __construct($appName = '')
    {

        // set the application name
        $this->appName = $appName;

        // initialize the remote method call parser and the session
        $this->parser = new RemoteMethodCallParser();
        $this->sessions = new \ArrayObject();

        // initialize the connection base URL
        $this->client = new Client($this->getDefaultBaseUrl());
    }

    /**
     * Returns the parser to process the remote method call.
     *
     * @return \TechDivision\PersistenceContainerProtocol\RemoteMethodCallParser The parser instance
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * Sets the clients webapp name
     *
     * @param string $appName Name of the webapp using this client connection
     *
     * @return void
     */
    public function setAppName($appName)
    {
        $this->appName = $appName;
    }

    /**
     * Returns the name of the webapp this connection is for
     *
     * @return string The webapp name
     */
    public function getAppName()
    {
        return $this->appName;
    }

    /**
     * Creates the connection to the container.
     *
     * @return void
     */
    public function connect()
    {
    }

    /**
     * Shutdown the connection to the container.
     *
     * @return void
     */
    public function disconnect()
    {
    }

    /**
     * Returns the socket the connection is based on.
     *
     * @return \TechDivision\Socket\Client The socket instance
     */
    public function getSocket()
    {
    }

    /**
     * Sends the remote method call to the container instance.
     *
     * @param \TechDivision\PersistenceContainerProtocol\RemoteMethod $remoteMethod The remote method instance
     *
     * @return mixed The response from the container
     * @see TechDivision\PersistenceContainerClient\Connection::send()
     */
    public function send(RemoteMethod $remoteMethod)
    {

        // load the parser instance
        $parser = $this->getParser();

        // set address + port + appName
        $remoteMethod->setAddress(ContextConnection::DEFAULT_HOST);
        $remoteMethod->setPort(ContextConnection::DEFAULT_PORT);
        $remoteMethod->setAppName($this->getAppName());

        // serialize the remote method and write it to the socket
        $packed = RemoteMethodProtocol::pack($remoteMethod);

        // send a POST request
        $request = $this->client->post('/' . $this->appName . '/index.pc');
        $request->setBody($packed);
        $response = $request->send();

        // read the remote method call result
        $result = RemoteMethodProtocol::unpack($response->getBody());

        // if an exception returns, throw it again
        if ($result instanceof \Exception) {
            throw $result;
        }

        // close the connection and return the data
        return $result;
    }

    /**
     * Prepares the default base URL we used for the connection
     * to the persistence container.
     *
     * @return string The default base URL
     */
    protected function getDefaultBaseUrl()
    {
        // initialize the requeste URL with the default connection values
        return ContextConnection::DEFAULT_SCHEME . '://' .
               ContextConnection::DEFAULT_HOST . ':' .
               ContextConnection::DEFAULT_PORT;
    }

    /**
     * Initializes a new session instance.
     *
     * @return \TechDivision\PersistenceContainerProtocol\Session The session instance
     * @see \TechDivision\PersistenceContainerClient\Interfaces\Connection::createContextSession()
     */
    public function createContextSession()
    {
        return $this->sessions[] = new ContextSession($this);
    }
}
