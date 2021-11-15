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
                'url' => route('service.index'),
                'hover' => '["' . route('service.create') . '","' . route('service.index') . '"]'
            ],
            [
                'menu_id' => '2',
                'name' => 'Service Return',
                'url' => route('service-return.index'),
                'hover' => '["' . route('service-return.create') . '","' . route('service-return.index') . '"]'
            ],
            [
                'menu_id' => '2',
                'name' => 'Service Update Status',
                'url' => route('service.serviceFormUpdateStatus'),
                'hover' => '["' . route('service.serviceFormUpdateStatus') . '"]'
            ],
            [
                'menu_id' => '2',
                'name' => 'Service Pembyaran',
                'url' => route('service-payment.index'),
                'hover' => '["' . route('service-payment.create') . '","' . route('service-payment.index') . '"]'
            ],
            [
                'menu_id' => '2',
                'name' => 'Penjualan',
                'url' => route('sale.index'),
                'hover' => '["' . route('sale.create') . '","' . route('sale.index') . '"]'
            ],
            [
                'menu_id' => '2',
                'name' => 'Return Penjualan',
                'url' => route('sale-return.index'),
                'hover' => '["' . route('sale-return.create') . '","' . route('sale-return.index') . '"]'
            ],
            [
                'menu_id' => '2',
                'name' => 'Pembelian',
                'url' => route('purchase.index'),
                'hover' => '["' . route('purchase.create') . '","' . route('purchase.index') . '"]'
            ],
            [
                'menu_id' => '2',
                'name' => 'Penerimaan',
                'url' => route('reception.index'),
                'hover' => '["' . route('reception.create') . '","' . route('reception.index') . '"]'
            ],
            [
                'menu_id' => '2',
                'name' => 'Pemasukan',
                'url' => route('income.index'),
                'hover' => '["' . route('income.create') . '","' . route('income.index') . '"]'
            ],
            [
                'menu_id' => '2',
                'name' => 'Pengeluaran',
                'url' => route('payment.index'),
                'hover' => '["' . route('payment.create') . '","' . route('payment.index') . '"]'
            ],
            // Finance
            [
                'menu_id' => '3',
                'name' => 'Sharing Profit',
                'url' => route('sharing-profit.index'),
                'hover' => '["' . route('sharing-profit.create') . '","' . route('sharing-profit.index') . '"]'
            ],
            
            [
                'menu_id' => '3',
                'name' => 'Barang Loss Trans',
                'url' => route('loss-items.index'),
                'hover' => '["' . route('loss-items.create') . '","' . route('loss-items.index') . '"]'
            ],
            [
                'menu_id' => '3',
                'name' => 'Laporan In/Outcome',
                'url' => route('report-income-spending.reportIncomeSpending'),
                'hover' => '["' . route('report-income-spending.reportIncomeSpending') . '"]'
            ],
            // [
            //     'menu_id' => '3',
            //     'name' => 'Laporan Transaksi Kas',
            //     'url' => route('report-income-spending.reportIncomeSpending'),
            //     'hover' => '["' . route('report-income-spending.reportIncomeSpending') . '"]'
            // ],
            // Master Data
            [
                'menu_id' => '4',
                'name' => 'Akun Dasar',
                'url' => route('account-main.index'),
                'hover' => '["' . route('account-main.create') . '","' . route('account-main.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Akun Detail',
                'url' => route('account-main-detail.index'),
                'hover' => '["' . route('account-main-detail.create') . '","' . route('account-main-detail.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Akun Data',
                'url' => route('account-data.index'),
                'hover' => '["' . route('account-data.create') . '","' . route('account-data.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Barang',
                'url' => route('item.index'),
                'hover' => '["' . route('item.create') . '","' . route('item.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Karyawan',
                'url' => route('employee.index'),
                'hover' => '["' . route('employee.create') . '","' . route('employee.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Pelanggan',
                'url' => route('customer.index'),
                'hover' => '["' . route('customer.create') . '","' . route('customer.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Setting Presentase',
                'url' => route('presentase.index'),
                'hover' => '["' . route('presentase.create') . '","' . route('presentase.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Garansi',
                'url' => route('warranty.index'),
                'hover' => '["' . route('warranty.create') . '","' . route('warranty.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Supplier',
                'url' => route('supplier.index'),
                'hover' => '["' . route('supplier.create') . '","' . route('supplier.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Satuan',
                'url' => route('unit.index'),
                'hover' => '["' . route('unit.create') . '","' . route('unit.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Tipe',
                'url' => route('type.index'),
                'hover' => '["' . route('type.create') . '","' . route('type.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Merk',
                'url' => route('brand.index'),
                'hover' => '["' . route('brand.create') . '","' . route('brand.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Kategori',
                'url' => route('category.index'),
                'hover' => '["' . route('category.create') . '","' . route('category.index') . '"]'
            ],
            // [
            //     'menu_id' => '4',
            //     'name' => 'Biaya',
            //     'url' => route('cost.index'),
            //     'hover' => '["' . route('cost.create') . '","' . route('cost.index') . '"]'
            // ],
            // [
            //     'menu_id' => '4',
            //     'name' => 'Kas',
            //     'url' => route('cash.index'),
            //     'hover' => '["' . route('cash.create') . '","' . route('cash.index') . '"]'
            // ],
            [
                'menu_id' => '4',
                'name' => 'Hak Akses',
                'url' => 'javascript:void(0)',
                'hover' => null
            ],
            [
                'menu_id' => '4',
                'name' => 'Cabang',
                'url' => route('branch.index'),
                'hover' => '["' . route('branch.create') . '","' . route('branch.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Area',
                'url' => route('area.index'),
                'hover' => '["' . route('area.create') . '","' . route('area.index') . '"]'
            ],
            [
                'menu_id' => '4',
                'name' => 'Ikon',
                'url' => route('icon.index'),
                'hover' => '["' . route('icon.create') . '","' . route('icon.index') . '"]'
            ],
            // [
            //     'menu_id' => '4',
            //     'name' => 'Menu',
            //     'url' => route('menu.index'),
            //     'hover' => '["' . route('menu.create') . '","' . route('menu.index') . '"]'
            // ],
            [
                'menu_id' => '5',
                'name' => 'Stok',
                'url' => route('stock.index'),
                'hover' => '["' . route('stock.create') . '","' . route('stock.index') . '"]'
            ],
            [
                'menu_id' => '5',
                'name' => 'Stok Transaksi',
                'url' => route('stockTransaction.index'),
                'hover' => '["' . route('stockTransaction.create') . '","' . route('stockTransaction.index') . '"]'
            ],
            [
                'menu_id' => '5',
                'name' => 'Stok Opname',
                'url' => 'javascript:void(0)',
                'hover' => null
            ],
            [
                'menu_id' => '5',
                'name' => 'Stok Mutasi',
                'url' => route('stockMutation.index'),
                'hover' => '["' . route('stockMutation.create') . '","' . route('stockMutation.index') . '"]'
            ],
            [
                'menu_id' => '6',
                'name' => 'Konten',
                'url' => route('contents.index'),
                'hover' => '["' . route('contents.create') . '","' . route('contents.index') . '"]'
            ],
            [
                'menu_id' => '6',
                'name' => 'Pesan',
                'url' => route('message.index'),
                'hover' => '["' . route('message.create') . '","' . route('message.index') . '"]'
            ],
            [
                'menu_id' => '6',
                'name' => 'Produk',
                'url' => route('type-product.index'),
                'hover' => '["' . route('type-product.create') . '","' . route('type-product.index') . '"]'
            ],
            [
                'menu_id' => '7',
                'name' => 'Notulen',
                'url' => route('notes.index'),
                'hover' => '["' . route('notes.create') . '","' . route('notes.index') . '"]'
            ],
            [
                'menu_id' => '7',
                'name' => 'Visi Misi',
                'url' => route('visiMisi'),
                'hover' => '["' . route('visiMisi') . '"]'
            ],
            [
                'menu_id' => '7',
                'name' => 'Setting SOP',
                'url' => route('regulation.index'),
                'hover' => '["' . route('regulation.create') . '","' . route('regulation.index') . '"]'
            ],
            [
                'menu_id' => '7',
                'name' => 'SOP',
                'url' => route('regulationAll'),
                'hover' => '["' . route('regulationAll') . '"]'
            ],
        ]);
    }
}
