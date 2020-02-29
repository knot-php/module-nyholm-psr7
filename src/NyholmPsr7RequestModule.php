<?php
declare(strict_types=1);

namespace KnotPhp\Module\NyholmPsr7;

use Throwable;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

use KnotLib\Kernel\Exception\ModuleInstallationException;
use KnotLib\Kernel\Kernel\ApplicationInterface;
use KnotLib\Kernel\Module\ModuleInterface;
use KnotLib\Kernel\Module\ComponentTypes;
use KnotLib\Kernel\EventStream\Channels;
use KnotLib\Kernel\EventStream\Events;

class NyholmPsr7RequestModule implements ModuleInterface
{
    /**
     * Declare dependency on another modules
     *
     * @return array
     */
    public static function requiredModules() : array
    {
        return [];
    }

    /**
     * Declare dependent on components
     *
     * @return array
     */
    public static function requiredComponentTypes() : array
    {
        return [
            ComponentTypes::EVENTSTREAM,
            ComponentTypes::DI,
        ];
    }

    /**
     * Declare component type of this module
     *
     * @return string
     */
    public static function declareComponentType() : string
    {
        return ComponentTypes::REQUEST;
    }

    /**
     * Install module
     *
     * @param ApplicationInterface $app
     *
     * @throws ModuleInstallationException
     */
    public function install(ApplicationInterface $app)
    {
        try{
            $psr17Factory = new Psr17Factory();

            $creator = new ServerRequestCreator(
                $psr17Factory, // ServerRequestFactory
                $psr17Factory, // UriFactory
                $psr17Factory, // UploadedFileFactory
                $psr17Factory  // StreamFactory
            );

            $request = $creator->fromGlobals();
            $app->request($request);

            // fire event
            $app->eventstream()->channel(Channels::SYSTEM)->push(Events::REQUEST_ATTACHED, $app->request());
        }
        catch(Throwable $e)
        {
            throw new ModuleInstallationException(self::class, $e->getMessage(), 0, $e);
        }
    }
}