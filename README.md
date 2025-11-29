# Smart Booking Scheduler

A comprehensive appointment scheduling system built with Laravel 12 and Vue 3 (Inertia.js) for service providers like hairdressers and fitness coaches.

## Features

### For Clients (Public Access)
- 📅 Browse available services
- 📆 Select appointment date from interactive calendar
- ⏰ View and choose available time slots
- 📧 Book appointments with email confirmation
- 📬 Receive booking confirmation and reminder emails

### For Admins (Authenticated Access)
- 👥 **Manage Bookings**: View, confirm, complete, or cancel appointments
- 💼 **Manage Services**: Create, edit, and manage service offerings
- 🕐 **Manage Working Hours**: Configure availability schedule by day
- 📊 Dashboard with comprehensive overview
- 🔐 Role-based access control with granular permissions

## Tech Stack

### Backend
- **Laravel 12** - PHP framework
- **PostgreSQL** - Database
- **Spatie Permission** - Role and permission management
- **Queue Jobs** - Asynchronous email processing
- **Console Commands** - Automated booking reminders

### Frontend
- **Vue 3** - JavaScript framework
- **TypeScript** - Type-safe development
- **Inertia.js** - SPA without API complexity
- **Tailwind CSS 4** - Utility-first styling
- **Vite** - Fast build tool

## Installation

### Prerequisites
- PHP 8.4+
- Composer
- Node.js 18+
- PostgreSQL 13+

### Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd quick-slot
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure Environment**
   Update `.env` with your credentials

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

## Running the Application

### Development

1. **Start the Laravel development server**
   ```bash
   php artisan serve
   ```

2. **Start the Vite development server** (in a separate terminal)
   ```bash
   npm run dev
   ```

3. **Start the queue worker** (in a separate terminal)
   ```bash
   php artisan queue:work
   php artisan queue:work --queue=emails
   ```

### Production

1. **Build frontend assets**
   ```bash
   npm run build
   ```

2. **Start the application**
   ```bash
   php artisan serve
   ```

3. **Run queue worker as a daemon**
   ```bash
   php artisan queue:work --daemon
   ```

## Default Admin Credentials

Default admin user created by seeder and their credentials will be stored in env file:

> ⚠️ **Important:** Change these credentials    after first login in production!

## Application URLs

- **Home Page**: http://localhost:8000
- **Public Booking**: http://localhost:8000/bookings
- **Admin Login**: http://localhost:8000/login
- **Admin Dashboard**: http://localhost:8000/dashboard

## Key Features Implementation

### 1. Availability Calculation
The system intelligently calculates available time slots by:
- Checking working hours for the selected day
- Excluding already booked appointments
- Accounting for service duration
- Respecting working hour exceptions (holidays, breaks)

### 2. Booking Flow (4-Step Wizard)
1. **Service Selection** - Choose from available services
2. **Date Selection** - Pick a date from the calendar
3. **Time Slot Selection** - Select from available time slots
4. **Booking Details** - Enter name, email, and optional notes

### 3. Email Notifications
- **Booking Confirmation** - Sent immediately upon booking
- **Booking Reminders** - Automated hourly check for upcoming appointments
- **Cancellation Notices** - Sent when bookings are cancelled

### 4. Admin Management
- **Bookings**: View all bookings with filtering, confirm/complete/cancel actions
- **Services**: Manage service catalog with pricing and duration
- **Working Hours**: Configure weekly schedule with multiple time blocks per day

## API Documentation

The application includes a RESTful API with versioning (v1):

### Public Endpoints
- `GET /api/v1/services/active` - List active services
- `GET /api/v1/availability/dates` - Get available booking dates
- `GET /api/v1/availability/slots` - Get available time slots
- `POST /api/v1/bookings` - Create a new booking

### Protected Endpoints (Require Authentication)
- `GET /api/v1/bookings` - List all bookings
- `PUT /api/v1/bookings/{id}/confirm` - Confirm a booking
- `PUT /api/v1/bookings/{id}/complete` - Mark booking as completed
- `PUT /api/v1/bookings/{id}/cancel` - Cancel a booking
- `DELETE /api/v1/bookings/{id}` - Delete a booking

For full API documentation, visit `/docs/api` when the application is running.

## Testing

### Run Tests
```bash
php artisan test
```

### Run with Coverage
```bash
php artisan test --coverage
```

## Scheduled Tasks

The application includes automated tasks:

**Booking Reminders** - Runs every hour to send reminder emails for upcoming appointments

To enable scheduled tasks in production:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Architecture Highlights

### Backend Patterns
- **Repository Pattern** - Data access abstraction
- **Service Layer** - Business logic separation
- **Observer Pattern** - Model event handling
- **Form Requests** - Validation and authorization
- **API Resources** - Consistent JSON responses
- **Eloquent ORM** - Database relationships and queries

### Frontend Patterns
- **Component-based Architecture** - Reusable Vue components
- **Composables** - Shared logic and state
- **TypeScript Interfaces** - Type-safe development
- **Service Layer** - API communication abstraction
- **Inertia.js** - Server-driven SPA

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Apis/          # API controllers (v1)
│   │   └── Web/           # Inertia controllers
│   ├── Requests/          # Form validation
│   └── Resources/         # API resources
├── Models/                # Eloquent models
├── Repositories/          # Repository pattern
├── Services/              # Business logic
└── Observers/             # Model observers

resources/
├── js/
│   ├── components/        # Vue components
│   ├── pages/             # Inertia pages
│   ├── services/          # API service layer
│   └── types/             # TypeScript types
└── views/                 # Blade templates

routes/
├── api.php                # API routes
├── web.php                # Web routes
└── console.php            # Console commands
```

## Environment Variables

Key environment variables to configure:

```env
# Admin User
SUPER_ADMIN_EMAIL=admin@example.com
SUPER_ADMIN_PASSWORD=secure_password
SUPER_ADMIN_FIRST_NAME=Admin
SUPER_ADMIN_LAST_NAME=User

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@quickslot.com
MAIL_FROM_NAME="${APP_NAME}"

# Queue Configuration
QUEUE_CONNECTION=database
```

## License

This project is proprietary and confidential.

## Support

For issues or questions, please contact the development team.

---

**Built with ❤️ using Laravel and Vue.js**
