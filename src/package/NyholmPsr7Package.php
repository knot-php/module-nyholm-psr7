<?php
declare(strict_types=1);

namespace knotphp\module\nyholmPsr7\package;

use knotlib\kernel\Module\PackageInterface;

use knotphp\module\knotpipeline\KnotPipelineModule;
use knotphp\module\stk2keventstream\Stk2kEventStreamModule;
use knotphp\module\nyholmPsr7\NyholmPsr7RequestModule;
use knotphp\module\nyholmPsr7\NyholmPsr7ResponseModule;

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