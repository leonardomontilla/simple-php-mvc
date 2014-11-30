<?php

/**
 * Description of DoctrineORMProvider
 *
 * @author smartapps
 */

namespace MVC\Providers;

use Doctrine\ORM\Tools\Setup,
 Doctrine\ORM\EntityManager,
    MVC\MVC,
    MVC\ProviderInterface;

class DoctrineORMProvider implements ProviderInterface
{
    public function boot(MVC $app) {
        
    }

    public function register(MVC $app, array $options = array()) {
        $default_options = array(
            'params'       => array(
                'charset'  => null,
                'driver'   => 'pdo_mysql',
                'dbname'   => null,
                'host'     => 'localhost',
                'user'     => 'root',
                'password' => null,
                'port'     => null,
            ),
            'dev_mode'     => false,
            'etities_type' => 'annotations',
            'path_etities' => array(),
            'proxy_dir'    => null
        );
        
        $options = array_merge($default_options, $options);
        
        if (empty($options['path_entities']) || !is_array($options['path_entities'])) {
            throw new \Exception('Option path_entities should be an array of path files entities.');
        }
        
        if ($options['etities_type'] == 'annotations') {
            $config = Setup::createAnnotationMetadataConfiguration($options['path_entities'], $options['dev_mode'], $options['proxy_dir']);
        } elseif ($options['etities_type'] == 'yaml' || $options['etities_type'] == 'yml') {
            $config = Setup::createYAMLMetadataConfiguration($options['path_entities'], $options['dev_mode'], $options['proxy_dir']);
        } elseif ($options['etities_type'] == 'xml') {
            $config = Setup::createXMLMetadataConfiguration($options['path_entities'], $options['dev_mode'], $options['proxy_dir']);
        }
        
        if ($app->keyExists('dbal')) {
            $entityManager = EntityManager::create($app->getKey('dbal'), $config);
        } else {
            $entityManager = EntityManager::create($options['params'], $config);
        }
        
        if (!$app->keyExists('dbal')) {
            $app->setKey('dbal', $entityManager->getConnection());
        }
        $app->setKey('em', $entityManager);
    }

}