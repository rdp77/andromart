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
                'url' => route('service.index')
            ],
            [
                'menu_id' => '2',
                'name' => 'Update WO Service',
                'url' => route('service.serviceFormUpdateStatus')
            ],
            [
                'menu_id' => '2',
                'name' => 'Penjualan',
                'url' => route('sale.index')
            ],
            [
                'menu_id' => '2',
                'name' => 'Pembelian',
                'url' => route('purchase.index')
            ],
            [
                'menu_id' => '2',
                'name' => 'Penerimaan',
                'url' => route('reception.index')
            ],
            [
                'menu_id' => '2',
                'name' => 'Pemasukan',
                'url' => 'javascript:void(0)'
            ],
            [
                'menu_id' => '2',
                'name' => 'Pengeluaran',
                'url' => route('payment.index')
            ],
            // Finance
            [
                'menu_id' => '3',
                'name' => 'Sharing Profit',
                'url' => route('sharing-profit.index')
            ],
            [
                'menu_id' => '3',
                'name' => 'Pelunasan Service',
                'url' => route('service-payment.index')
            ],
            [
                'menu_id' => '3',
                'name' => 'Barang Loss Trans',
                'url' => route('loss-items.index')
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
                'name' => 'Konten',
                'url' => route('contents.index')
            ],
            [
                'menu_id' => '6',
                'name' => 'Pesan',
                'url' => route('message.index')
            ],
            [
                'menu_id' => '7',
                'name' => 'Notulen',
                'url' => route('notes.index')
            ],
            [
                'menu_id' => '7',
                'name' => 'Visi Misi',
                'url' => route('visiMisi')
            ],
            [
                'menu_id' => '7',
                'name' => 'Setting SOP',
                'url' => route('regulation.index')
            ],
            [
                'menu_id' => '7',
                'name' => 'SOP',
                'url' => route('regulationAll')
            ],
        ]);
    }
}
