# Laravel Project

## Laravel Version: ^11.0 and PHP Version: ^8.3

To set up and run the project, follow these steps:

1. **Install Dependencies**  
   First, install the required dependencies by running the following command:

   ```bash
   composer install

2. **Create .env File**
   ```bash
   cp .env.example .env
3. **Set Environment Variables**
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=url_shortner_rl
   DB_USERNAME=root
   DB_PASSWORD=
4. **Generate Application Encryption Key**
   ```bash
   php artisan key:generate
5. **Run Migrations**
   ```bash
   php artisan migrate
6. **Seed the Database**
   ```bash
   php artisan db:seed
7.**Super Admin Credentials**
  ```bash
   For testing, use the following credentials to log in as the super admin:
   Email: superadmin@gmail.com
   Password: 1234 (same for all users for testing)
