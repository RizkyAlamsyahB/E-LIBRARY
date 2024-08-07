# Proyek Laravel E-Library

## Deskripsi

Ini adalah proyek Laravel E-Library yang mengimplementasikan [fitur inventory dokumen].

## Prerequisites

Sebelum memulai, pastikan Anda telah menginstal:

-   [PHP](https://www.php.net/downloads) (versi minimal yang direkomendasikan: 8.3)
-   [Composer](https://getcomposer.org/download/)
<!-- Laragon / XAMPP -->
-   [Laragon](https://laragon.org/download/) werver dan database lain yang didukung Laravel
-   [XAMPP](https://www.apachefriends.org/download.html) web server dan database lain yang didukung Laravel
<!-- Laragon / XAMPP -->
-   [Node.js](https://nodejs.org/en/download/) (untuk pengelolaan frontend dependencies)

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan proyek ini di lingkungan lokal Anda:

1.  **Clone repositori:**

    ```bash
    git clone https://github.com/RizkyAlamsyahB/Library.git
    ```

2.  **Masuk ke direktori proyek:**

    ```bash
    cd repository-name
    ```

3.  **Instal dependensi PHP menggunakan Composer:**

    ```bash
    composer install
    ```

4.  **Salin file `.env.example` ke `.env`:**

    ```bash
    cp .env.example .env
    ```

5.  **Generate key aplikasi:**

    ```bash
    php artisan key:generate
    ```

6.  **Atur konfigurasi database dan variabel lingkungan lainnya di file `.env`:**

        Edit `.env` untuk mengatur pengaturan database Anda, misalnya:

        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=nama_database
        DB_USERNAME=username
        DB_PASSWORD=password

        MAIL_MAILER=smtp
        MAIL_HOST=mailpit
        MAIL_PORT=1025
        MAIL_USERNAME=null
        MAIL_PASSWORD=null
        MAIL_ENCRYPTION=null
        MAIL_FROM_ADDRESS="hello@example.com"
        MAIL_FROM_NAME="${APP_NAME}"
        ```

7.  **Jalankan migrasi database (jika diperlukan):**

    ```bash
    php artisan migrate
    ```

8.  **Instal dependensi frontend menggunakan NPM atau Yarn:**

    ```bash
    npm install
    ```

    atau

    ```bash
    yarn install
    ```

9.  **Bangun aset frontend:**

    ```bash
    npm run dev
    ```

    atau

    ```bash
    yarn dev
    ```

10. **Jalankan server lokal Laravel:**

    ```bash
    php artisan serve
    ```
       ```bash
    npm run dev
    ```

    Proyek sekarang dapat diakses di `http://localhost:8000`.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](LICENSE.md).
