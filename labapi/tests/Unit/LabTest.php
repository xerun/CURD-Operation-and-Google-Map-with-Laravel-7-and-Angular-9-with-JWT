<?php

namespace Tests\Feature;

use App\Lab;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LabTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $lab = new Lab([
            'name'          =>  'Lab Test',
            'location_id'   =>  '1'
        ]);

        $lab->save();
    }

    /** @test */
    public function testIndex()
    {
        $response = $this->get('/api/labs');
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
        $response = $this->get('/api/labs/1');
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
    public function testInvalidStore()
    {
        $response = $this->post('api/labs', [
            'name'          =>  'Lab-2 Test',
            'location_id'   =>  '0'
        ]);

        $response
            ->assertStatus(403)
            ->assertJsonStructure([
                'error',
                'message'
            ]);
    }

    /** @test */
    public function testStore()
    {
        $response = $this->post('api/labs', [
            'name'          =>  'Lab2 Test',
            'location_id'   =>  '2'
        ]);

        $response
            ->assertStatus(201)
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
    public function testInvalidUpdate()
    {
        $response = $this->put('api/labs/1', [
            'name'          =>  'Lab-1 Test',
            'location_id'   =>  '0'
        ]);

        $response
            ->assertStatus(403)
            ->assertJsonStructure([
                'error',
                'message'
            ]);
    }

    /** @test */
    public function testUpdate()
    {
        $response = $this->put('api/labs/1', [
            'name'          =>  'Lab-1 Test',
            'location_id'   =>  '2'
        ]);

        $response
            ->assertStatus(201)
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
    public function testDelete()
    {
        $response = $this->delete('api/labs/2');

        $response
            ->assertStatus(204)
            ->assertJsonStructure(null);
    }

    /** @test */
    public function testInvalidDelete()
    {
        $response = $this->delete('api/labs/10');

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'error',
                'message',
            ]);
    }
}