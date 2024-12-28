# store_management

## Admin Seeder

To set up the initial admin user in your database, follow these steps:

### 1. **Run the Admin Seeder**

To seed the database with an admin user, run the admin seeder.

## Application URL

The application's URL for the login page can be accessed via the following route:

- **Login Page URL:** `/admin/login`

#### Admin Credentials:

- **Email**: `admin@store.com`
- **Password**: `password`

#### Steps to Run the Seeder:
1. Ensure that your database is set up and your `.env` file is correctly configured.
2. Run the following Artisan command to execute the seeder and insert the admin user into your database:

   ```bash
   php artisan db:seed 
   
#### Location Permissions:
   - Location permissions are necessary for both **user registration** and **user login** to ensure the application can display nearby stores based on the user's location.