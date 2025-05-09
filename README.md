
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
   composer update
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
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

9. **🔗 Storage Setup & Cache Clearing**
   ```bash
   php artisan storage:link
   php artisan optimize:clear
   php artisan cache:clear
   ```
   Set appropriate permissions to make storage accessible (if required):

   ```bash
   chmod -R 775 storage/app/public
   ```

9. **Run the app**
   ```bash
   php artisan serve
   ```

---


## ✅ Features

- Admin panel to manage users and ID requests
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
