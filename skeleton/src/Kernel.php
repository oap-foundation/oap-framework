<?php

namespace OAP\Kernel;

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use OAP\Kernel\Service\IdentityLoader;
use OAP\Kernel\Repository\TransactionRepositoryInterface;
use OAP\Kernel\Repository\SqliteTransactionRepository;
use OAP\Core\Identity\DIDResolverInterface;
use OAP\Core\Identity\DIDResolver;
use OAP\Core\Security\KeyProviderInterface;
use OAP\Core\Security\SoftwareKeyProvider;
use OAP\Discovery\Interfaces\DiscoveryAdapterInterface;
use OAP\Discovery\Adapters\WebCrawlerAdapter;
use OAP\Transport\TransportFactory;
use OAP\Transport\TransportManager;

class Kernel
{
    private $container;

    public function __construct(string $envFile = '.env')
    {
        // Load Env
        if (file_exists(getcwd() . '/' . $envFile)) {
            $dotenv = Dotenv::createImmutable(getcwd(), $envFile);
            $dotenv->load();
        }

        // Build Container
        $builder = new ContainerBuilder();
        $builder->addDefinitions([
                // Core
            DIDResolverInterface::class => \DI\create(DIDResolver::class),
            KeyProviderInterface::class => function () {
                return IdentityLoader::loadKeyProvider();
            },

                // Discovery
            DiscoveryAdapterInterface::class => \DI\create(WebCrawlerAdapter::class),

                // Transport
            TransportFactory::class => \DI\create(TransportFactory::class),
            TransportManager::class => \DI\autowire(TransportManager::class),

            // Core Services
            \OAP\Core\Session\OAEPSession::class => \DI\autowire(\OAP\Core\Session\OAEPSession::class),
            \OAP\Kernel\Service\Brain::class => \DI\autowire(\OAP\Kernel\Service\Brain::class),

                // Repository
            TransactionRepositoryInterface::class => \DI\create(SqliteTransactionRepository::class),
        ]);

        $this->container = $builder->build();
    }

    public function getService(string $class)
    {
        return $this->container->get($class);
    }
}
