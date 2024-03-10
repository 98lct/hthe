<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Media;


class ProductControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $product = Media::create([
            'media_id' => '1234560,134',
            'ggggg' => 'Product Description',
            'price' => 100,
        ]);

        // Kiểm tra xem sản phẩm đã được tạo thành công hay chưa
        $this->assertNotNull($product);
    }
}
