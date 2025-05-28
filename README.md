Sure! Here's a complete `README.md` file with **step-by-step instructions** for your Laravel 12 project that:

* Creates an order with a job and transaction
* Seeds dummy users and products
* Uses Postman to test inserting data

---

### ✅ `README.md` for Laravel 12 Order Job Project

````md
# Laravel 12 Order Job System

This project demonstrates how to handle order creation in Laravel 12 using database transactions and jobs for asynchronous processing. It also includes dummy seeders and Postman testing steps.

---

## 📦 1. Create Laravel Project

```bash
composer create-project laravel/laravel order-job
cd order-job
````

---

## ⚙️ 2. Set Up Environment

Copy the example `.env` file and set your database config:

```bash
cp .env.example .env
php artisan key:generate
```

In `.env`, configure:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=order_item
DB_USERNAME=root
DB_PASSWORD=****
```

Then create the DB in your MySQL server (e.g., via phpMyAdmin or CLI).

---

## 📥 3. Create Models and Migrations

```bash
php artisan make:model Order -m
php artisan make:model OrderItem -m
php artisan make:model Product -m
```

Edit migration files to define schema:

### `create_orders_table.php`

```php
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');
    $table->timestamps();
});
```

### `create_order_items_table.php`

```php
Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('order_id');
    $table->unsignedBigInteger('product_id');
    $table->integer('quantity');
    $table->decimal('price', 10, 2);
    $table->timestamps();
});
```

### `create_products_table.php`

```php
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->decimal('price', 10, 2);
    $table->timestamps();
});
```

---

## 🛠️ 4. Run Migrations

```bash
php artisan migrate
```

---

## 🚀 5. Create a Job to Handle Orders

```bash
php artisan make:job ProcessOrderJob
```

In `app/Jobs/ProcessOrderJob.php`, implement the order item creation logic.

---

## 🔄 6. OrderController and API Routes

```bash
php artisan make:controller API/OrderController
```

In `routes/api.php`, define:

```php
use App\Http\Controllers\API\OrderController;

Route::post('/orders', [OrderController::class, 'store']);
```

In `OrderController`, handle order creation and dispatch the job.

---

## 🧪 7. Add Fillable Fields in Models

In `Order.php`:

```php
protected $fillable = ['user_id'];
```

In `OrderItem.php`:

```php
protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];
```

In `Product.php`:

```php
protected $fillable = ['name', 'price'];
```

---

## 🌱 8. Create Seeders

```bash
php artisan make:seeder UserSeeder
php artisan make:seeder ProductSeeder
```

### `UserSeeder.php`

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Saurabh V2. Shukla',
    'email' => 'saurabh.shukla+v2@gmail.com',
    'password' => Hash::make('123456'),
]);
```

### `ProductSeeder.php`

```php
use App\Models\Product;

Product::insert([
    ['name' => 'Product A', 'price' => 100],
    ['name' => 'Product B', 'price' => 150],
    ['name' => 'Product C', 'price' => 200],
]);
```

### Register in `DatabaseSeeder.php`:

```php
$this->call([
    UserSeeder::class,
    ProductSeeder::class,
]);
```

Then run:

```bash
composer dump-autoload
php artisan db:seed
```

---

## 🧪 9. Test Order Creation in Postman

### Endpoint: `POST /api/orders`

#### Request Body (JSON):

```json
{
  "user_id": 1,
  "items": [
    {
      "product_id": 1,
      "quantity": 2,
      "price": 100
    },
    {
      "product_id": 2,
      "quantity": 1,
      "price": 150
    }
  ]
}
```

#### Expected Response:

```json
{
  "success": true,
  "message": "Order placed successfully and processing in background"
}
```

---

## 📡 10. Serve the Project

```bash
php artisan serve --port=8080
```

Visit: [http://127.0.0.1:8080](http://127.0.0.1:8080)

---

## 🧯 11. Common Errors & Fixes

* `Add [order_id] to fillable...`:
  ➤ Add `order_id` to `$fillable` in `OrderItem.php`.

* Foreign key error for `products`:
  ➤ Ensure `products` table is migrated **before** `order_items`.

* Seeder class not found:
  ➤ Run `composer dump-autoload` and check the file/class name and namespace.

---

## ✅ Done!

Now you have a full Laravel 12 API with order processing via job, transaction-safe inserts, and dummy data seeding.

---

> Built with ❤️ by Saurabh V2. Shukla

```

---

Let me know if you want me to include actual controller and job code samples too.
```


---

Jobs commands :

# Set up env
QUEUE_CONNECTION=database

# Prepare job table
php artisan queue:table
php artisan migrate

# Create and dispatch job
php artisan make:job ProcessOrderJob

# Run worker
php artisan queue:work
