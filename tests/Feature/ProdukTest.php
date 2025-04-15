<?php

namespace Tests\Feature;

use App\Livewire\Admin\Produk\Produk;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class ProdukTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreSuccessfully()
    {
        Livewire::test('admin.produk.tambah-produk')
            ->set('nama_produk', 'kaleng')
            ->call('store')
            ->assertRedirect('/produk');

        $this->assertDatabaseHas('produk', [
            'nama_produk' => 'kaleng',
        ]);
    }
}
