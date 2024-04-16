<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private const CONFIG_EXT = '.{php,yaml}';

    protected function configureContainer(ContainerConfigurator $container): void
    {
        /**
         * Global configs
         */
        $container->import($this->getConfigDir() . '/{packages}/*' . self::CONFIG_EXT);
        $container->import($this->getConfigDir() . '/{packages}/' . $this->environment . '/*' . self::CONFIG_EXT);
        $container->import($this->getConfigDir() . '/{services}' . self::CONFIG_EXT);
        $container->import($this->getConfigDir() . '/{services}_' . $this->environment . self::CONFIG_EXT);

        /**
         * Lib configs
         */
        $container->import($this->getLibDir() . '/{packages}/*' . self::CONFIG_EXT);
        $container->import($this->getLibDir() . '/{services}' . self::CONFIG_EXT);
        $container->import($this->getLibDir() . '/{services}_' . $this->environment . self::CONFIG_EXT);

        /**
         * Modules configs
         */
        $container->import($this->getModulesDir() . '/{packages}/*' . self::CONFIG_EXT);
        $container->import($this->getModulesDir() . '/{services}' . self::CONFIG_EXT);
        $container->import($this->getModulesDir() . '/{services}_' . $this->environment . self::CONFIG_EXT);
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        /**
         * Global routes
         */
        $routes->import($this->getConfigDir() . '/{routes}/*' . self::CONFIG_EXT);
        $routes->import($this->getConfigDir() . '/{routes}' . self::CONFIG_EXT);
        $routes->import($this->getConfigDir() . '/{routes}_' . $this->environment . self::CONFIG_EXT);

        /**
         * Lib routes
         */
        $routes->import($this->getLibDir() . '/{routes}/*' . self::CONFIG_EXT);
        $routes->import($this->getLibDir() . '/{routes}' . self::CONFIG_EXT);
        $routes->import($this->getLibDir() . '/{routes}_' . $this->environment . self::CONFIG_EXT);

        /**
         * Modules routes
         */
        $routes->import($this->getModulesDir() . '/{routes}/*' . self::CONFIG_EXT);
        $routes->import($this->getModulesDir() . '/{routes}' . self::CONFIG_EXT);
        $routes->import($this->getModulesDir() . '/{routes}_' . $this->environment . self::CONFIG_EXT);
    }

    private function getConfigDir(): string
    {
        return $this->getProjectDir() . '/config';
    }

    private function getLibDir(): string
    {
        return $this->getProjectDir() . '/lib/**/*/config';
    }

    private function getModulesDir(): string
    {
        return $this->getProjectDir() . '/modules/**/*/config';
    }
}
