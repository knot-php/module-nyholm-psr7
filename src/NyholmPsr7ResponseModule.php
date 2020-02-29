<?php
declare(strict_types=1);

namespace KnotPhp\Module\NyholmPsr7;

use Throwable;

use Nyholm\Psr7\Factory\Psr17Factory;

use KnotLib\Kernel\Exception\ModuleInstallationException;
use KnotLib\Kernel\Kernel\ApplicationInterface;
use KnotLib\Kernel\Module\ModuleInterface;
use KnotLib\Kernel\Module\ComponentTypes;
use KnotLib\Kernel\EventStream\Channels;
use KnotLib\Kernel\EventStream\Events;

class NyholmPsr7ResponseModule implements ModuleInterface
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
        return ComponentTypes::RESPONSE;
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

            $responseBody = $psr17Factory->createStream('');
            $response = $psr17Factory->createResponse(200)->withBody($responseBody);

            $app->response($response);

            // fire event
            $app->eventstream()->channel(Channels::SYSTEM)->push(Events::RESPONSE_ATTACHED, $app->response());
        }
        catch(Throwable $e)
        {
            throw new ModuleInstallationException(self::class, $e->getMessage(), 0, $e);
        }
    }
}