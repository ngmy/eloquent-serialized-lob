<?php

namespace Ngmy\EloquentSerializedLob\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Database\DatabaseManager;

abstract class TestCase extends OrchestraTestCase
{
    protected $useDatabase = false;

    protected $db;

    public function setUp()
    {
        parent::setUp();

        if ($this->useDatabase === true) {
            $this->setUpDatabase();

            $this->db = new DatabaseManager($this->app, $this->app['db.factory']);
            $this->db->connection('testbench');
        }
    }

    public function tearDown()
    {
        if ($this->useDatabase === true) {
            $this->db->disconnect('testbench');

            $this->tearDownDatabase();
        }

        parent::tearDown();
    }

    protected function setUpDatabase()
    {
        $this->artisan('migrate', [
            '--database' => 'testbench',
            '--realpath' => realpath(__DIR__.'/database/migrations'),
        ]);
    }

    protected function tearDownDatabase()
    {
        $this->artisan('migrate:rollback');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'eloquent_serialized_lob_test',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ]);
    }
}
