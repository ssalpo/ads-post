<?php

namespace Tests\Feature;

use App\Advertising;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvertisingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_failed_validation()
    {
        $response = $this->postJson('/api/advertisings', [
            'title' => 'Some title',
            'description' => 'some description',
            'images' => 'image url',
            'price' => '9999we'
        ]);

        $response->assertStatus(422);
        $response->assertSee('The images must be an array.');
        $response->assertSee('The price format is invalid.');
    }

    public function test_success_creation()
    {
        $response = $this->postJson('/api/advertisings', [
            'title' => 'Some title',
            'description' => 'some description',
            'images' => ['one', 'two'],
            'price' => '9999'
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['status' => true]);
    }

    public function test_see_correct_pagination_fields()
    {
        $response = $this->getJson('/api/advertisings');

        $response->assertStatus(200);
        $response->assertJsonPath('meta.per_page', 10);
        $response->assertJsonPath('meta.total', 50);
    }

    public function test_is_sorting_work_correct()
    {
        $advertising = Advertising::sortByFields(['price' => 'asc'])->get()->first();

        $response = $this->getJson('/api/advertisings?sort[price]=asc');

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.0.price', $advertising->price);
    }

    public function test_show_adverting_page()
    {
        $advertise = factory(Advertising::class)->create();

        $response = $this->getJson('/api/advertisings/' . $advertise->id);

        $response
            ->assertStatus(200)
            ->assertSee('title')
            ->assertJsonPath('data.id', $advertise->id)
            ->assertJsonPath('data.price', $advertise->price)
            ->assertJsonPath('data.main_image_url', $advertise->main_image_url);
    }

    public function test_is_show_adverting_page_has_additional_fields()
    {
        $advertise = factory(Advertising::class)->create();

        $response = $this->getJson("/api/advertisings/{$advertise->id}?fields[]=description&fields[]=images");

        $response
            ->assertStatus(200)
            ->assertSee('title')
            ->assertSee('description')
            ->assertSee('images')
            ->assertJsonPath('data.id', $advertise->id)
            ->assertJsonPath('data.price', $advertise->price)
            ->assertJsonPath('data.main_image_url', $advertise->main_image_url);
    }
}
