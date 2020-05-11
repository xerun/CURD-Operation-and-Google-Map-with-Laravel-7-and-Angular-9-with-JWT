<?php

namespace Tests\Feature;

use App\Location;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $location = new Location([
            'name'          =>  'Location Test',
            'address'       =>  'Location Address',
            'latitude'      =>  '22.35324234',
            'longitude'     =>  '-58.5343244'
        ]);

        $location->save();
    }

    /** @test */
    public function testIndex()
    {
        $response = $this->get('/api/locations');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'location_id',
                'location_name',
                'created_at',
                'updated_id'
            ]);
    }

    /** @test */
    public function testShow()
    {
        $response = $this->get('/api/locations/1');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'name',
                'location_id',
                'location_name',
                'created_at',
                'updated_id'
            ]);
    }

    /** @test */
    public function testStore()
    {
        $response = $this->post('api/locations', [
            'name'          =>  'Location2 Test',
            'address'       =>  'Location2 Address',
            'latitude'      =>  '42.35324234',
            'longitude'     =>  '-78.5343244'
        ]);

        $response
            ->assertStatus(403)
            ->assertJsonStructure([
                'id',
                'address',
                'latitude',
                'longitude',
                'created_at',
                'updated_id'
            ]);
    }

    /** @test */
    public function testUdate()
    {
        $response = $this->put('api/locations/1', [
            'name'          =>  'Location-1 Test',
            'address'       =>  'Location-1 Address',
            'latitude'      =>  '42.35324234',
            'longitude'     =>  '-78.5343244'
        ]);

        $response
            ->assertStatus(403)
            ->assertJsonStructure([
                'id',
                'address',
                'latitude',
                'longitude',
                'created_at',
                'updated_id'
            ]);
    }

    /** @test */
    public function testDelete()
    {
        $response = $this->delete('api/locations/1');

        $response
            ->assertStatus(204)
            ->assertJsonStructure(null);
    }

    /** @test */
    public function testInvalidDelete()
    {
        $response = $this->delete('api/locations/10');

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'error',
                'message',
            ]);
    }
}