<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'name',
        'customer_id',
        'ip_address',
        'service',
        'composite_data',
    ];


    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            // Mengatur nomor pelanggan
            $lastCustomer = Customer::orderBy('no', 'desc')->first();
            $customer->no = $lastCustomer ? $lastCustomer->no + 1 : 1;

            // Menyimpan kombinasi data
            $customer->composite_data = "{$customer->name} - {$customer->customer_id} - {$customer->ip_address}";
        });

        

        static::deleting(function ($customer) {
            // Logika untuk mengatur nomor jika ada yang dihapus
            // Anda bisa menambahkan logika di sini jika diperlukan

            // Memperbarui nomor pelanggan setelah penghapusan
            $customers = Customer::where('no', '>', $customer->no)->get();
            foreach ($customers as $c) {
                $c->no -= 1; // Mengurangi nomor pelanggan
                $c->save(); // Simpan perubahan
            }
        });
    }
}
