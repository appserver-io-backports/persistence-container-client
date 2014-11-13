<?php

/**
 * TechDivision\PersistenceContainerClient\Context\LocalContextConnection
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

use TechDivision\Collections\Collection;
use TechDivision\PersistenceContainerProtocol\RemoteMethod;
use TechDivision\PersistenceContainerProtocol\RemoteMethodProtocol;
use TechDivision\PersistenceContainerProtocol\RemoteMethodCallParser;
use TechDivision\PersistenceContainerProtocol\BeanContext;
use TechDivision\Application\Interfaces\ApplicationInterface;

/**
 * Connection implementation to invoke a local method call.
 *
 * @category  Library
 * @package   TechDivision_PersistenceContainerClient
 * @author    Tim Wagner <tw@techdivision.com>
 * @copyright 2014 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_PersistenceContainerClient
 * @link      http://www.appserver.io
 */
class LocalContextConnection implements Connection
{

    /**
     * The storage for the sessions.
     *
     * @var \TechDivision\Collections\Collection
     */
    protected $sessions = null;

    /**
     * The application instance.
     *
     * @var \TechDivision\Application\Interfaces\ApplicationInterface
     */
    protected $application;

    /**
     * Injects the application instance for the local connection.
     *
     * @param \TechDivision\Application\Interfaces\ApplicationInterface $application The application instance
     *
     * @return void
     */
    public function injectApplication(ApplicationInterface $application)
    {
        $this->application = $application;
    }

    /**
     * Returns the application instance.
     *
     * @return \TechDivision\Application\Interfaces\ApplicationInterface The application instance
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Injects the collection for the sessions.
     *
     * @param \TechDivision\Collections\Collection $sessions The collection for the sessions
     *
     * @return void
     */
    public function injectSessions(Collection $sessions)
    {
        $this->sessions = $sessions;
    }

    /**
     * Returns the collection with the sessions.
     *
     * @return \TechDivision\Collections\Collection The collection with the sessions
     */
    public function getSessions()
    {
        return $this->sessions;
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

        // load the application context and the bean manager
        $application = $this->getApplication();

        // prepare method name and parameters and invoke method
        $className = $remoteMethod->getClassName();
        $methodName = $remoteMethod->getMethodName();
        $parameters = $remoteMethod->getParameters();
        $sessionId = $remoteMethod->getSessionId();

        // load the bean manager and the bean instance
        $beanManager = $application->getNamingDirectory()->search(BeanContext::IDENTIFIER);
        $instance = $application->getNamingDirectory()->search($className, array($sessionId, array($application)));

        // invoke the remote method call on the local instance
        $response = call_user_func_array(array($instance, $methodName), $parameters);

        // reattach the bean instance in the container and unlock it
        $beanManager->attach($instance, $sessionId);

        // return the response to the client
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
        $this->sessions->add($session = new ContextSession($this));
        return $session;
    }
}
