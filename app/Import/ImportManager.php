<?php

namespace App\Import;

use Exception;
use App\Enum\Platform;
use App\Patterns\Singleton;
use App\Http\Requests\ActivityImportRequest;
use App\Import\RosterBusterImport\RosterBusterImport;

class ImportManager extends Singleton
{

    /**
     * @throws Exception
     */
    public function getImportInstance(Platform $platform, ActivityImportRequest $activityImportRequest) : RosterBusterImport
    {
        return match ($platform){
            Platform::RosterBuster => new RosterBusterImport($activityImportRequest),
            default => throw new Exception('Platform not supported')
        };
    }
}
