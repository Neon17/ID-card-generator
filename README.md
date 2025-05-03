
# 🪪 Laravel ID Card Generator

This Laravel 11 application allows dynamic ID card generation and printing.

- 🛡️ **Admin**: Manage users and generate ID cards for any user.
- 👤 **User**: Generate their own ID card only.

---

## 🚀 Getting Started

Follow these steps to set up and run the project locally.

### 🧾 Prerequisites

- PHP 8.2+
- Composer
- Node.js and npm
- MySQL or SQLite

---

### 🛠️ Installation Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/your-repo-name.git
   cd your-repo-name
   ```

2. **Copy and configure the `.env` file**
   ```bash
   cp .env.example .env
   ```

   Then update the following in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

3. **Install PHP dependencies**
   ```bash
   composer install
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Install Laravel Breeze (for scaffolding)**
   ```bash
   php artisan breeze:install
   ```

6. **Install Toast Flash package**
   ```bash
   composer require laracasts/flash
   php artisan vendor:publish --provider="Laracasts\Flash\FlashServiceProvider" --force
   ```

7. **Run npm and build assets**
   ```bash
   npm install
   npm run dev
   npm run build
   ```

8. **Run migrations**
   ```bash
   php artisan migrate
   ```


---

### 🔗 Storage Setup & Cache Clearing

Run the following commands to properly link storage and clear any cached data:

```bash
php artisan storage:link
php artisan optimize:clear
php artisan cache:clear
```

Set appropriate permissions to make storage accessible:

```bash
chmod -R 775 storage/app/public
```

---

## ✅ Features

- Admin panel to manage users
- Dynamic ID card generation
- Print-ready design
- Laravel Breeze auth system
- Flash messages with Laracasts Flash

---

## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you’d like to change.

---

## 📄 License

This project is for personal practice and has no license.
