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

use TechDivision\Server\Sockets\StreamSocket;
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
    protected $transport = 'tcp';

    /**
     * The client socket's IP address.
     *
     * @var string
     */
    protected $address = '127.0.0.1';

    /**
     * The client socket's port.
     *
     * @var integer
     */
    protected $port = 8585;

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
     * The client socket instance.
     *
     * @var \TechDivision\Socket\Client
     */
    protected $client = null;

    /**
     * Parser to process the remote method call.
     *
     * @var \TechDivision\PersistenceContainerProtocol\RemoteMethodCallParser
     */
    protected $parser;

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
     * Sets the servers IP address for the client to connect to.
     *
     * @param string $address The servers IP address to connect to
     *
     * @return void
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Returns the client sockets IP address.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     *  Sets  the servers port for the client to connect to.
     *
     * @param integer $port The servers port to connect to
     *
     * @return void
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * Returns the client port.
     *
     * @return integer The client port
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     *  Sets the transport to use.
     *
     * @param integer $transport The transport to use
     *
     * @return void
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;
    }

    /**
     * Returns the transport to use.
     *
     * @return integer The transport to use.
     */
    public function getTransport()
    {
        return $this->transport;
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

        // connect to the persistence container
        $clientConnection = StreamSocket::getClientInstance(
            $this->getTransport() . '://' . $this->getAddress() . ':' . $this->getPort()
        );

        // load the parser instance
        $parser = $this->getParser();

        // set address + port + appName
        $remoteMethod->setAddress($this->getAddress());
        $remoteMethod->setPort($this->getPort());
        $remoteMethod->setAppName($this->getAppName());

        // serialize the remote method and write it to the socket
        $packed = RemoteMethodProtocol::pack($remoteMethod);

        // invoke the remote method call
        $clientConnection->write(RemoteMethodProtocol::prepareHeaderInvoke($packed));
        $clientConnection->write($packed);

        // read the response
        $contentLength = $parser->parseHeader($clientConnection->readLine());
        $response = $parser->parseBody($clientConnection, $contentLength);

        // if an exception returns, throw it again
        if ($response instanceof \Exception) {
            throw $response;
        }

        // close the connection and return the data
        return $response;
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
