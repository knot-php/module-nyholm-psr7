<?php
declare(strict_types=1);

namespace KnotPhp\Module\NyholmPsr7\Package;

use KnotLib\Kernel\Module\PackageInterface;

use KnotPhp\Module\KnotPipeline\KnotPipelineModule;
use KnotPhp\Module\Stk2kEventStream\Stk2kEventStreamModule;

use KnotPhp\Module\NyholmPsr7\NyholmPsr7RequestModule;
use KnotPhp\Module\NyholmPsr7\NyholmPsr7ResponseModule;

class NyholmPsr7Package implements PackageInterface
{
    /**
     * Get package module list
     *
     * @return string[]
     */
    public static function getModuleList() : array
    {
        return [
            KnotPipelineModule::class,
            Stk2kEventStreamModule::class,
            NyholmPsr7RequestModule::class,
            NyholmPsr7ResponseModule::class,
        ];
    }
}