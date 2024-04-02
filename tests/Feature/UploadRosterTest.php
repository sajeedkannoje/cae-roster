<?php

namespace Tests\Feature;

use App\Enum\Platform;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadRosterTest extends TestCase
{

    /**
     * @return void
     */
    public function testUploadRosterWithXlsxFileAndPlatformRosterBuster()
    {
        $file = new UploadedFile(
            "tests/dataProvider/RosterBuster-xlsx.xlsx",
            'RosterBuster-xlsx.xlsx',
            'xlsx', null, true
        );

        $crewId = 1;
        $platform = Platform::RosterBuster->value;
        $response = $this->postJson(route('activity.upload'), [
            'attachment' => $file,
            'crew_id'    => $crewId,
            'platform'   => $platform,
        ]);
        $response->assertSuccessful();
    }

    /**
     * @return void
     */
    public function testUploadRosterWithCsvFileAndPlatformRosterBuster()
    {

        $file = new UploadedFile(
            "tests/dataProvider/RosterBuster-csv.csv",
            'RosterBuster-csv.csv',
            'csv', null, true
        );
        $crewId = 1;
        $platform = Platform::RosterBuster->value;
        $response = $this->postJson(route('activity.upload'), [
            'attachment' => $file,
            'crew_id'    => $crewId,
            'platform'   => $platform,
        ]);
        $response->assertSuccessful();
    }

    /**
     * @return void
     */
    public function testUploadRosterWithXlsxFileAndWithoutPlatform()
    {
        $file = new UploadedFile(
            "tests/dataProvider/RosterBuster-xlsx.xlsx",
            'RosterBuster-xlsx.xlsx',
            'xlsx', null, true
        );

        $crewId = 1;
        $response = $this->postJson(route('activity.upload'), [
            'attachment' => $file,
            'crew_id'    => $crewId,
        ]);
        $response->assertSuccessful();
    }

    /**
     * @return void
     */
    public function testUploadRosterWithCsvFileAndWithoutPlatform()
    {

        $file = new UploadedFile(
            "tests/dataProvider/RosterBuster-csv.csv",
            'RosterBuster-csv.csv',
            'csv', null, true
        );
        $crewId = 1;
        $platform = Platform::RosterBuster->value;
        $response = $this->postJson(route('activity.upload'), [
            'attachment' => $file,
            'crew_id'    => $crewId,
        ]);
        $response->assertSuccessful();
    }

    /**
     * @return void
     */
    public function testUploadRosterWithXlsxFileAndWithoutCrewIdPlatformRosterBuster()
    {
        $file = new UploadedFile(
            "tests/dataProvider/RosterBuster-xlsx.xlsx",
            'RosterBuster-xlsx.xlsx',
            'xlsx', null, true
        );

        $platform = Platform::RosterBuster->value;
        $response = $this->postJson(route('activity.upload'), [
            'attachment' => $file,
            'platform'   => $platform,
        ]);
        $response->assertJsonValidationErrors('crew_id');
    }

    /**
     * @return void
     */
    public function testUploadRosterWithCsvFileAndWithoutCrewIdPlatformRosterBuster()
    {

        $file = new UploadedFile(
            "tests/dataProvider/RosterBuster-csv.csv",
            'RosterBuster-csv.csv',
            'csv', null, true
        );
        $crewId = 1;
        $platform = Platform::RosterBuster->value;
        $response = $this->postJson(route('activity.upload'), [
            'attachment' => $file,
            'platform'   => $platform,
        ]);
        $response->assertJsonValidationErrors('crew_id');
    }

    /**
     * @return void
     */
    public function testUploadRosterWithCsvFileAndWithInvalidPlatform()
    {

        $file = new UploadedFile(
            "tests/dataProvider/RosterBuster-csv.csv",
            'RosterBuster-csv.csv',
            'csv', null, true
        );
        $crewId = 1;
        $platform = "invalid_platform";
        $response = $this->postJson(route('activity.upload'), [
            'attachment' => $file,
            'platform'   => $platform,
        ]);
        $response->assertJsonValidationErrors('platform');
    }

    /**
     * @return void
     */
    public function testUploadRosterWithoutFile()
    {
        $response = $this->postJson(route('activity.upload'), [
            'crew_id' => 1,
        ]);
        $response->assertJsonValidationErrors('attachment');
    }

}
