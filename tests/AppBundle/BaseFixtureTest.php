<?php

namespace Tests\AppBundle;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class BaseFixtureTest extends WebTestCase
{
    /**
     * @var EntityManager
     */
    protected static $entityManager;

    /**
     * @var Registry
     */
    protected static $doctrine;

    /**
     * @var string
     */
    protected static $fixturesLocation = '@AppBundle/DataFixtures/ORM';

    /**
     * @var Application
     */
    protected static $application;

    /**
     * @var ContainerInterface
     */
    protected static $container;

    /**
     * @var bool
     */
    protected static $fixturesLoaded = false;

    /**
     *
     */
    protected static function setupFixtures()
    {
        // Drop the database
        $command = new DropDatabaseDoctrineCommand();
        static::$application->add($command);
        $command->run(new ArrayInput(['command' => 'doctrine:database:drop', '--force' => true]), new NullOutput());

        // We have to close the connection after dropping the database so we don't get "No database selected" error
        $connection = static::$doctrine->getConnection();
        if ($connection->isConnected()) {
            $connection->close();
        }

        // Create the database
        $command = new CreateDatabaseDoctrineCommand();
        static::$application->add($command);
        $command->run(new ArrayInput(['command' => 'doctrine:database:create']), new NullOutput());

        // Create schema
        $command = new CreateSchemaDoctrineCommand();
        static::$application->add($command);
        $command->run(new ArrayInput(['command' => 'doctrine:schema:create']), new NullOutput());

        // Load the fixtures
        $client = static::createClient();
        $loader = new ContainerAwareLoader($client->getContainer());
        $loader->loadFromDirectory(static::$kernel->locateResource(static::$fixturesLocation));
        $executor = new ORMExecutor(
            static::$entityManager,
            new ORMPurger(static::$entityManager)
        );
        $executor->execute($loader->getFixtures());

        static::$fixturesLoaded = true;
    }

    /**
     *
     */
    public static function setUpBeforeClass()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        static::$application = new Application(static::$kernel);
        static::$container = static::$application->getKernel()->getContainer();
        static::$doctrine = static::$container->get('doctrine');
        static::$entityManager = static::$doctrine->getManager();

        if (!static::$fixturesLoaded) {
            static::setupFixtures();
        }
    }

    /**
     *
     */
    public static function tearDownAfterClass()
    {
        parent::tearDownAfterClass();
        static::$entityManager = null;
        static::$doctrine = null;
        static::$application = null;
        static::$container = null;
    }
}
