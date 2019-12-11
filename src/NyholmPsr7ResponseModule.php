<?php
declare(strict_types=1);

namespace KnotPhp\Module\NyholmPsr7;

use Throwable;

use Nyholm\Psr7\Factory\Psr17Factory;

use KnotLib\Kernel\Exception\ModuleInstallationException;
use KnotLib\Kernel\Kernel\ApplicationInterface;
use KnotLib\Kernel\Module\ComponentModule;
use KnotLib\Kernel\Module\Components;
use KnotLib\Kernel\EventStream\Channels;
use KnotLib\Kernel\EventStream\Events;
use KnotLib\Support\Adapter\PsrResponseAdapter;

class NyholmPsr7ResponseModule extends ComponentModule
{
    /**
     * Declare dependent on components
     *
     * @return array
     */
    public static function requiredComponents() : array
    {
        return [
            Components::EVENTSTREAM,
            Components::DI,
        ];
    }

    /**
     * Declare component type of this module
     *
     * @return string
     */
    public static function declareComponentType() : string
    {
        return Components::RESPONSE;
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

            $app->response(new PsrResponseAdapter($response));

            // fire event
            $app->eventstream()->channel(Channels::SYSTEM)->push(Events::RESPONSE_ATTACHED, $app->response());
        }
        catch(Throwable $e)
        {
            throw new ModuleInstallationException(self::class, $e->getMessage(), 0, $e);
        }
    }
}