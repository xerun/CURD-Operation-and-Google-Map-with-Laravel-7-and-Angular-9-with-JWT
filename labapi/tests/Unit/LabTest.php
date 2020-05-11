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
        $this->withoutMiddleware();    
        $response = $this->get('/api/labs');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'name',
                    'location_id',
                    'location_name',
                    'created_at',
                    'updated_at'
                ]]
            ]);
    }

    /** @test */
    public function testShow()
    {
        $this->withoutMiddleware();    
        $response = $this->get('/api/labs/1');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'location_id',
                    'location_name',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /** @test */
    public function testInvalidStore()
    {
        $this->withoutMiddleware();
        $response = $this->post('api/labs', [
            'name'          =>  'Lab-2 Test',
            'location_id'   =>  '0'
        ]);

        $response
            ->assertStatus(403)
            ->assertJsonStructure([
                'error',
                'messages'
            ]);
    }

    /** @test */
    public function testStore()
    {
        $this->withoutMiddleware();
        $response = $this->post('api/labs', [
            'name'          =>  'Lab2 Test',
            'location_id'   =>  '2'
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'location_id',
                    'location_name',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /** @test */
    public function testInvalidUpdate()
    {
        $this->withoutMiddleware();
        $response = $this->put('api/labs/1', [
            'name'          =>  'Lab-1 Test',
            'location_id'   =>  '0'
        ]);

        $response
            ->assertStatus(403)
            ->assertJsonStructure([
                'error',
                'messages'
            ]);
    }

    /** @test */
    public function testUpdate()
    {
        $this->withoutMiddleware();
        $response = $this->put('api/labs/1', [
            'name'          =>  'Lab-1 Test',
            'location_id'   =>  '2'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'location_id',
                    'location_name',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    /** @test */
    public function testInvalidDelete()
    {
        $this->withoutMiddleware();
        $response = $this->delete('api/labs/10');

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'error',
                'message',
            ]);
    }

    /** @test */
    public function testDelete()
    {
        $this->withoutMiddleware();
        $response = $this->delete('api/labs/1');

        $response
            ->assertStatus(204);
    }    
}