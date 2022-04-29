<?php


namespace Kikwik\InstantWinBundle\DependencyInjection;


use Doctrine\DBAL\Types\Type;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class KikwikInstantWinExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
        $config = array(
            'dbal' => array('types' => array("InstantWinPeriodUnitType" => 'Kikwik\InstantWinBundle\DBAL\Types\InstantWinPeriodUnitType')),
        );

        $container->prependExtensionConfig('doctrine', $config);
    }

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $instantWinService = $container->getDefinition('kikwik_instantwin.service.instantwin');
        $instantWinService->setArgument('$configurationRepository', new Reference($config['configuration_repository']));
        $instantWinService->setArgument('$leadRepository', new Reference($config['lead_repository']));
    }

}