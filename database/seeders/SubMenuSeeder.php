<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('submenu')->insert([
            // Transaksi
            [
                'menu_id' => '2',
                'name' => 'Service',
                'url' => '/transaction/service/service'
            ],
            [
                'menu_id' => '2',
                'name' => 'Update WO Service',
                'url' => '/transaction/service/service-form-update-status'
            ],
            [
                'menu_id' => '2',
                'name' => 'Penjualan',
                'url' => '/transaction/sale/sale'
            ],
            [
                'menu_id' => '2',
                'name' => 'Pembelian',
                'url' => '/transaction/purchasing/purchase'
            ],
            [
                'menu_id' => '2',
                'name' => 'Penerimaan',
                'url' => '/transaction/purchasing/reception'
            ],
            [
                'menu_id' => '2',
                'name' => 'Pemasukan',
                'url' => 'javascript:void(0)'
            ],
            [
                'menu_id' => '2',
                'name' => 'Pengeluaran',
                'url' => '/transaction/payment/payment'
            ],
            // Finance
            [
                'menu_id' => '3',
                'name' => 'Sharing Profit',
                'url' => '/finance/sharing-profit/sharing-profit'
            ],
            [
                'menu_id' => '3',
                'name' => 'Pelunasan Service',
                'url' => '/transaction/service/service-payment'
            ],
            [
                'menu_id' => '3',
                'name' => 'Barang Loss Trans',
                'url' => '/finance/loss-items/loss-items'
            ],
            // Master Data
            [
                'menu_id' => '4',
                'name' => 'Barang',
                'url' => route('item.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Karyawan',
                'url' => route('employee.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Pelanggan',
                'url' => route('customer.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Setting Presentase',
                'url' => route('presentase.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Garansi',
                'url' => route('warranty.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Supplier',
                'url' => route('supplier.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Satuan',
                'url' => route('unit.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Tipe',
                'url' => route('type.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Merk',
                'url' => route('branch.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Kategori',
                'url' => route('category.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Biaya',
                'url' => route('cost.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Kas',
                'url' => route('cash.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Hak Akses',
                'url' => 'javascript:void(0)'
            ],
            [
                'menu_id' => '4',
                'name' => 'Cabang',
                'url' => route('branch.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Area',
                'url' => route('area.index')
            ],
            [
                'menu_id' => '4',
                'name' => 'Ikon',
                'url' => 'javascript:void(0)'
            ],
            [
                'menu_id' => '5',
                'name' => 'Stok',
                'url' => route('stock.index')
            ],
            [
                'menu_id' => '5',
                'name' => 'Stok Transaksi',
                'url' => route('stockTransaction.index')
            ],
            [
                'menu_id' => '5',
                'name' => 'Stok Opname',
                'url' => 'javascript:void(0)'
            ],
            [
                'menu_id' => '5',
                'name' => 'Stok Mutasi',
                'url' => route('stockMutation.index')
            ],
            [
                'menu_id' => '6',
                'name' => 'Peraturan',
                'url' => route('regulation.index')
            ],
            [
                'menu_id' => '6',
                'name' => 'Notulen',
                'url' => route('notes.index')
            ],
            [
                'menu_id' => '7',
                'name' => 'Konten',
                'url' => route('contents.index')
            ],
            [
                'menu_id' => '7',
                'name' => 'Pesan',
                'url' => route('message.index')
            ],
            [
                'menu_id' => '8',
                'name' => 'Visi Misi',
                'url' => route('visiMisi')
            ],
            [
                'menu_id' => '8',
                'name' => 'SOP',
                'url' => route('regulationAll')
            ],
        ]);
    }
}
