<?php

namespace ZendTest\Db\Adapter\Driver\Mysqli;

use Zend\Db\Adapter\Driver\Mysqli\Connection;

/**
 * @group integration
 * @group integration-mysqli
 */
class ConnectionIntegrationTest extends \PHPUnit_Framework_TestCase
{

    protected $variables = [
        'hostname' => 'TESTS_ZEND_DB_ADAPTER_DRIVER_MYSQL_HOSTNAME',
        'username' => 'TESTS_ZEND_DB_ADAPTER_DRIVER_MYSQL_USERNAME',
        'password' => 'TESTS_ZEND_DB_ADAPTER_DRIVER_MYSQL_PASSWORD',
        'database' => 'TESTS_ZEND_DB_ADAPTER_DRIVER_MYSQL_DATABASE',
    ];

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        if (!getenv('TESTS_ZEND_DB_ADAPTER_DRIVER_MYSQL')) {
            $this->markTestSkipped('Mysqli integration test disabled');
        }

        if (!extension_loaded('mysqli')) {
            $this->fail('The phpunit group integration-mysqli was enabled, but the extension is not loaded.');
        }

        foreach ($this->variables as $name => $value) {
            if (!getenv($value)) {
                $this->markTestSkipped('Missing required variable ' . $value . ' from phpunit.xml for this integration test');
            }
            $this->variables[$name] = getenv($value);
        }
    }

    public function testConnectionOk()
    {
        $connection = new Connection($this->variables);
        $connection->connect();

        $this->assertTrue($connection->isConnected());
        $connection->disconnect();
    }
}
