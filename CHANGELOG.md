# Version 0.7.0

## Bugfixes

* Add Guzzle dependency to composer.json
* Remove wrong and invalid use statements from ContextConnection class

## Features

* Add PHPUnit test class for ContextConnection
* Add LocalContextConnection and LocalConnectionFactory
* Remove connect(), disconnect() and getSocket() methods from Connection interface
* Rename ContextConnection to RemoteContextConnection and ConnectionFactory to RemoteConnectionFactory

# Version 0.6.1

## Bugfixes

* None

## Features

* Refactoring ANT PHPUnit execution process
* Composer integration by optimizing folder structure (move bootstrap.php + phpunit.xml.dist => phpunit.xml)
* Switch to new appserver-io/build build- and deployment environment