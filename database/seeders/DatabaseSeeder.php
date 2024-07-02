<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Package;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Admin 1',
            'email' => 'admin@storease.com',
            'password' => bcrypt('password'),
        ]);
        
        Customer::create([
            'name' => 'Customer 1',
            'email' => 'customer1@storease.com',
            'password' => bcrypt('password'),
            'phone' => '+628123456789',
        ]);

        Customer::create([
            'name' => 'Customer 2',
            'email' => 'customer2@storease.com',
            'password' => bcrypt('password'),
            'phone' => '+628123456789',
        ]);
        
        Vendor::create([
            'name' => 'Vendor 1',
            'email' => 'vendor1@storease.com',
            'password' => bcrypt('password'),
            'phone' => '+628123456789',
        ]);

        Vendor::create([
            'name' => 'Vendor 2',
            'email' => 'vendor2@storease.com',
            'password' => bcrypt('password'),
            'phone' => '+628123456789',
        ]);

        Category::create([
            'name' => 'Category 1',
        ]);

        Category::create([
            'name' => 'Category 2',
        ]);

        Product::create([
            'name' => 'Product 1',
            'price' => '10000',
            'category_id' => '1',
            'vendor_id' => '1',
        ]);

        Product::create([
            'name' => 'Product 2',
            'price' => '20000',
            'category_id' => '2',
            'vendor_id' => '2',
        ]);

        Order::create([
            'uuid' => Uuid::uuid4(),
            'vendor_id' => 1,
            'customer_id' => 1,
            'total_price' => 100000,
        ]);

        Order::create([
            'uuid' => Uuid::uuid4(),
            'vendor_id' => 2,
            'customer_id' => 2,
            'total_price' => 80000,
        ]);

        OrderDetail::create([
            'quantity' => 4,
            'product_id' => 1,
            'order_id' => 1,
        ]);

        OrderDetail::create([
            'quantity' => 3,
            'product_id' => 2,
            'order_id' => 1,
        ]);

        OrderDetail::create([
            'quantity' => 4,
            'product_id' => 2,
            'order_id' => 2,
        ]);

        Package::create([
            'name' => 'Paket Akad Nikah Super Hemat',
            'price' => 7500000,
            'detail' => "<p>1. Rias dan Busana Pengantin Pria dan Wanita</p><p>2. Dekorasi :</p><p>a. Meja akad</p><p>b. Kursi akad 6 Pcs</p><p>c. Backdrop akad nikah</p><p>d. 1 Meja Tamu</p><p>e. 1 Buku Tamu</p><p>3. Dokumentasi</p><p>a. Foto</p><p>b. 1 Album kolase Eksklusif Uk. 20 X 30, 10 Sheet ( 20 Hal )</p><p>c. 1 Flashdisk Isi Foto Master dan Editing</p>",
        ]);

        Package::create([
            'name' => 'Paket Akad Nikah Hemat Lengkap',
            'price' => 14000000,
            'detail' => "<p>1. Prasmanan 100 Pax, Terdiri Dari :</p><p>a. Nasi, Pilih Dua :</p><p>- Nasi Putih</p><p>- Nasi Goreng Jawa (Best Seller 1)</p><p>- Nasi Goreng XO (Best Seller 2)</p><p>- Nasi Goreng Tomyam</p><p>b. Soup, Pilih Salah Satu :</p><p>- Soup Manten &nbsp;(Best Seller 1)</p><p>c. Ayam, Pilih Salah Satu :</p><p>- Ayam Cabai Hijau</p><p>- Ayam Balado</p><p>- Ayam Blackpaper</p><p>d. Ikan, Pilih Salah Satu :</p><p>- Ikan Dori Fillet Asam Manis (Best Seller 1)</p><p>- Ikan Goreng Saus Lemon</p><p>- Ikan Goreng Saus Padang</p><p>- Ikan Goreng Saus Thai</p><p>- Ikan Goreng Cabai Hijau</p><p>e. Salad, Pilih Salah Satu :</p><p>- Asinan Sayuran (Best Seller 1)</p><p>- Salad Bangkok (Best Seller 2)</p><p>salad buah</p><p>2. Rias Busana Pengantin Pria &amp; Wanita</p><p>3. Rias Busana Untuk 4 Orang Tua</p><p>4. Dekorasi</p><p>a. Meja Akad</p><p>b. Kursi Akad 6 Pcs</p><p>c. Backdrop Akad Nikah</p><p>d. 1 Meja Tamu</p><p>e. 1 Buku Tamu</p><p>5. Dokumentasi</p><p>a. Foto dan Video Shooting</p><p>b. 1 Album Kolase Eksklusif Uk. 20 X 30 10 Sheet (20 Hal)</p><p>c. 1 Flasdisk Isi File Foto &amp; Video</p><p>d. Video Klip 1 Menit untuk di Upload ke Sosial Media (Instagram, Facebook, dll)</p>",
        ]);

        Package::create([
            'name' => 'PAKET PERNIKAHAN GEDUNG ANGGREK 300 TAMU',
            'price' => 49490000,
            'detail' => "<p>1. Buffet Utama Lezat 200 Porsi (Tengah) + 50 Porsi (VIP), Terdiri Dari :</p><p>a. Nasi, Pilih Dua :</p><p>- Nasi Putih</p><p>- Nasi Goreng Jawa (Best Seller 1)</p><p>- Nasi Goreng XO (Best Seller 2)</p><p>b. Noodles, Pilih Salah Satu :</p><p>- Mie Goreng Singapore (Best Seller)</p><p>- Mie Goreng</p><p>- Mie goreng sambal XO</p><p>- Kwetiaw</p><p>c. Soup, Pilih Salah Satu :</p><p>- Soup Manten Tiga Dara (Best Seller 1)</p><p>- Soup Tomyam (Best Seller 2)</p><p>- Soup Ayam Dengan Jamur</p><p>d. Ayam, Pilih Salah Satu :</p><p>- Ayam Rica-Rica (Best Seller 1)</p><p>- Ayam Goreng Dengan Bumbu Special Tiga Dara (Best Seller 2)</p><p>- Ayam Bumbu Rujak</p><p>- Ayam Cabai Hijau</p><p>e. Ikan, Pilih Salah Satu :</p><p>- Ikan Dori Fillet Asam Manis (Best Seller 1)</p><p>- Ikan Goreng Saus Lemon (Best Seller 2)</p><p>f. Salad, Pilih Salah Satu :</p><p>- Asinan Sayuran (Best Seller 1)</p><p>- Salad Bangkok (Best Seller 2)</p><p>- Gado-Gado Betawi</p><p>- Pecel Sayuran</p><p>- Rujak Pengantin</p><p>- Karedok</p><p>- Salad Kentang Dengan Sayuran</p><p>g. Aneka Pudding, Dapat Dua-Duanya :</p><p>- Coklat</p><p>- Strawberry</p><p>h. Aneka Soft Drink, Dapat Dua-Duanya :</p><p>- Fanta</p><p>- Coca-Cola</p><p>i. Aneka Buah, Pilih Dua :</p><p>- Semangka</p><p>- Melon</p><p>- Pepaya</p><p>- Nanas</p><p>j. Kerupuk Udang</p><p>k. Mini Cake</p><p>l. Air Mineral</p><p>2. Pondokan Lezat Pilih 2 Item, Masing-Masing 100 Porsi</p><p>a. 1 Ekor Kambing Guling (+ - 50 Porsi)</p><p>b. Aneka Soto</p><p>- Soto Betawi (Best Seller)</p><p>- Soto Ayam</p><p>- Soto Mie</p><p>- Soto Ambengan</p><p>- Rawon Daging</p><p>c. Aneka Sate</p><p>- Sate Ayam + Lontong (Best Seller)</p><p>- Sate Padang + Ketupat</p><p>d. Aneka Minuman</p><p>- Es Krim</p><p>- Es Cendol</p><p>- Es Dawet</p><p>- Es Slendang Mayang</p><p>- Es Cincau</p><p>- Es Doger</p><p>- Es Capucino Cincau</p><p>- Juice Jambu Asli</p><p>- Juice Mangga Asli</p><p>- Juice Jeruk Asli</p><p>e. Jajanan Lainnya,</p><p>- Bakwan Malang (Best Seller)</p><p>- Batagor</p><p>- Tekwan</p><p>- Pempek</p><p>- Siomay</p><p>- Kebab</p><p>- Coklat Fountain</p><p>f. Aneka Bubur</p><p>- Bubur Kacang Ijo</p><p>- Bubur Sum Sum</p><p>g. Aneka Bakso</p><p>- Bakso Urat (Best Seller)</p><p>3. Rias Cantik, Busana Mewah dan Aksesoris Indah</p><p>a. Rias Busana Akad Mempelai Pria Wanita</p><p>b. Rias Busana Resepsi Mempelai Pria Wanita</p><p>c. Rias Busana Resepsi Untuk 4 Orang Tua</p><p>d. Rias Busana Untuk 4 Orang Among Tamu</p><p>e. Rias Busana Untuk 2 Orang Penerima Tamu</p><p>f. Hand Bouquet</p><p>4. Pelaminan Megah Dekorasi Indah</p><p>a. Pelaminan Mewah Dan Indah Sampai Dengan 10 Meter</p><p>b. Kursi Pelaminan Nan Mewah</p><p>c. Meja Dan Kursi Akad Yang di Dekor</p><p>d. 3 Vas Bunga Romantis Di Pelaminan</p><p>e. Taman Depan Pelaminan Nan Indah</p><p>f. Red Carpet</p><p>g. Dekorasi Photobooth Dengan Bunga-Bunga Yg Cantik</p><p>h. Dekorasi Meja Buffet Mewah Standar Hotel Bintang Lima Dengan Bunga Nan Cantik</p><p>i. Dekorasi Meja Desert Dengan Bunga Nan Cantik</p><p>j. 2 Initial Huruf Pasangan Yang Sedang Berbahagia</p><p>k. Dekorasi Untuk Organ Tunggal</p><p>l. 6 Standing Flower Dengan Bunga Hidup Nan Cantik</p><p>m. Pagar Dan Gate VIP Menjaga Privacy Keluarga Terdekat</p><p>n. Round Table Untuk VIP Dengan Standar Hotel Bintang Lima</p><p>o. Dekorasi Meja Buffet Mewah Dan Waiternya Untuk di VIP area</p><p>p. Pergola Di Pintu Masuk Utama</p><p>q. Pergola Dipintu Masuk VIP</p><p>r. 2 Kotak Tempat Souvenir</p><p>s. Colour Lighting</p><p>t. 2 Standing Foto Ukuran Besar</p><p>u. Gazebo Utama Di Pintu Masuk Ukuran 2,5M x 2,5M</p><p>v. Gazebo Buffet Ukuran 2M x 2M (Jika Ruangan Luas)</p><p>w. 2 Meja Gallery Untuk Bingkai Foto</p><p>x. Bingkai-Bingkai Foto</p><p>y. 2 Meja Tamu</p><p>z. 2 Buah Kotak Angpau</p><p>5. Dokumentasi</p><p>a. Foto dan Video Shooting</p><p>b. 1 Album Kolase Eksklusif Uk. 20 X 30 10 Sheet (20 Hal)</p><p>c. 1 Cetak Foto + Frame Uk. 40 X 50</p><p>d. 1 Box Exclusive Tempat Album</p><p>e. Mini Studio</p><p>f. 1 Flasdisk Isi File Foto &amp; Video</p><p>g. Video Klip 1 Menit Untuk di Upload ke Sosial Media (Instagram, Facebook, dll)</p><p>6. Perlengkapan</p><p>a. 150 Pcs Souvenir Utk Tamu, Lucu Dan Kekinian</p><p>b. 2 Janur Yang Romantis + 2 Papan Nama Mempelai</p><p>c. 2 Buku Tamu Dengan Cover Mewah</p><p>7. Entertainment</p><p>a. Master Of Ceremony (MC) Dengan Suara Yang Merdu</p><p>b. Keyboard + Keyboardis</p><p>c. Singer/Penyanyi</p><p>d. Sound System + Mic Untuk Akad Dan Resepsi</p><p>e. Soundman</p><p>f. Team WO Mengatur Seluruh Rangkaian Acara</p><p>a. Semua Crew Tiga Dara Menggunakan Masker</p><p>b. Pengambilan Makanan Dilayani Oleh Waiter</p><p>c. Dipinjamkan 1 Unit Thermo Gun</p><p>d. Free Hand Sanitizer</p><p>e. Stiker Warna Penanda Per Sesi Jam Acara</p><p>f. Perijinan Jika Gedung Dari Tiga Dara</p><p>9. Bonus</p><p>a. Undangan Online Website</p><p>b. Rundown Acara</p><p>c. Makanan Setelah Akad (Nasi Bakar/Snack Box/Lontong Sayur/Bubur Cakalang 30 Porsi)</p><p>d. 15 Nasi Box Untuk Orang Kebersihan Dan Keamanan Gedung</p><p>e. Uang Tip Untuk Orang Kebersihan Dan Keamanan Gedung</p>",
        ]);
    }
}
