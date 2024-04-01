<?php

namespace App\Import;

use Exception;
use App\Enum\Platform;
use App\Patterns\Singleton;
use App\Import\RosterBusterImport\RosterBusterImport;

class ImportManager extends Singleton
{

    /**
     * @throws Exception
     */
    public function getImportInstance(Platform $platform) : RosterBusterImport
    {
        return match ($platform){
            Platform::RosterBuster => new RosterBusterImport(),
            default => throw new Exception('Platform not supported')
        };
    }
}
