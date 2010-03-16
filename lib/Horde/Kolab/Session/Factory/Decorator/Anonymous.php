<?php
/**
 * A factory decorator that adds an anonymous user to the generated instances.
 *
 * PHP version 5
 *
 * @category Kolab
 * @package  Kolab_Session
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Kolab_Session
 */

/**
 * A factory decorator that adds an anonymous user to the generated instances.
 *
 * Copyright 2009-2010 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @category Kolab
 * @package  Kolab_Session
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Kolab_Session
 */
class Horde_Kolab_Session_Factory_Decorator_Anonymous
implements Horde_Kolab_Session_Factory_Interface
{
    /**
     * The factory setup resulting from the configuration.
     *
     * @var Horde_Kolab_Session_Factory_Interface
     */
    private $_factory;

    /**
     * Anonymous user ID.
     *
     * @var string
     */
    private $_anonymous_id;

    /**
     * Anonymous password.
     *
     * @var string
     */
    private $_anonymous_pass;

    /**
     * Constructor.
     *
     * @param Horde_Kolab_Session_Factory_Interface $factory The base factory.
     * @param string                                $user    ID of the anonymous
     *                                                       user.
     * @param string                                $pass    Password of the
     *                                                       anonymous user.
     */
    public function __construct(
        Horde_Kolab_Session_Factory_Interface $factory,
        $user,
        $pass
    ) {
        $this->_factory        = $factory;
        $this->_anonymous_id   = $user;
        $this->_anonymous_pass = $pass;
    }

    /**
     * Return the kolab user db connection.
     *
     * @return Horde_Kolab_Server_Interface The server connection.
     */
    public function getServer()
    {
        return $this->_factory->getServer();
    }

    /**
     * Return the auth handler for sessions.
     *
     * @return Horde_Kolab_Session_Auth_Interface The authentication handler.
     */
    public function getSessionAuth()
    {
        return $this->_factory->getSessionAuth();
    }

    /**
     * Return the configuration parameters for the session.
     *
     * @return array The configuration values.
     */
    public function getSessionConfiguration()
    {
        return $this->_factory->getSessionConfiguration();
    }

    /**
     * Return the session storage driver.
     *
     * @return Horde_Kolab_Session_Storage_Interface The driver for storing sessions.
     */
    public function getSessionStorage()
    {
        return $this->_factory->getSessionStorage();
    }

    /**
     * Return the session validation driver.
     *
     * @return Horde_Kolab_Session_Valid_Interface The driver for validating
     *                                             sessions.
     */
    public function getSessionValidator(
        Horde_Kolab_Session_Interface $session,
        Horde_Kolab_Session_Auth_Interface $auth
    ) {
        return $this->_factory->getSessionValidator($session, $auth);
    }

    /**
     * Validate the given session.
     *
     * @param Horde_Kolab_Session_Interface $session The session to validate.
     *
     * @return boolean True if the given session is valid.
     */
    public function validate(
        Horde_Kolab_Session_Interface $session
    ) {
        return $this->_factory->validate($session);
    }

    /**
     * Returns a new session handler.
     *
     * @return Horde_Kolab_Session_Interface The concrete Kolab session reference.
     */
    public function createSession()
    {
        $session = $this->_factory->createSession();
        $session = new Horde_Kolab_Session_Decorator_Anonymous(
            $session,
            $this->_anonymous_id,
            $this->_anonymous_pass
        );
        return $session;
    }

    /**
     * Returns either a reference to a session handler with data retrieved from
     * the session or a new session handler.
     *
     * @return Horde_Kolab_Session_Interface The concrete Kolab session reference.
     */
    public function getSession()
    {
        return $this->_factory->getSession();
    }
}
