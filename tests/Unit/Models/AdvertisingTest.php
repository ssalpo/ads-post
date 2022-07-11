<?php

namespace Tests\Unit\Models;

use App\Advertising;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdvertisingTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_new_advertising()
    {
        $advertise = factory(Advertising::class)->create();

        $this->assertNotEquals('', $advertise->title);
    }

    public function test_model_sort_by_fields()
    {
        factory(Advertising::class, 50)->create();

        $advertisersPriceAsc = Advertising::sortByFields(['price' => 'asc'])->get();
        $advertisersPriceDesc = Advertising::sortByFields(['price' => 'desc'])->get();

        $this->assertEquals($advertisersPriceAsc->first()->price, $advertisersPriceDesc->last()->price);
    }
}
