# Hotel Management System

## Overview
The Hotel Management System is a web-based application built with Node.js, Express, and MySQL to manage hotel operations efficiently. It provides role-based access control for Super Admin, Admin, and Staff, enabling them to handle room bookings, billing, staff records, and hotel expenses.

## Features
### User Authentication & Authorization
- User roles: **Super Admin, Admin, and Staff**
- Super Admin assigns permissions to Admin and Staff
- Secure login system with role-based access control

### Admin Panel (Backend Dashboard)
1. **Room Management**
   - Create, update, and delete rooms
   - Manage room availability
2. **Booking System**
   - Handle online room booking requests
   - Book rooms for customers from the backend
   - Check-in and checkout functionality
   - Assign booking to a specific staff/admin
3. **Billing System**
   - Auto-generate bills for bookings
   - Generate laundry and food bills separately
4. **Staff Management**
   - Maintain staff records
   - Manage staff salaries and payment history
5. **Expense Management**
   - Track hotel expenses
   - Generate reports for financial insights
6. **Laundry & Food Services**
   - Handle laundry service billing
   - Manage food service billing

## Tech Stack
- **Backend:** Node.js, Express.js, MySQL2
- **Authentication:** JWT-based authentication
- **Frontend (Optional):** React.js, Bootstrap

## Installation & Setup
### Prerequisites
- Node.js (version 14.17.6 or later)
- MySQL database
- XAMPP (if using local MySQL)

### Steps to Run the Project
1. Clone the repository:
   ```sh
   git clone https://github.com/your-repo/hotel-management.git
   cd hotel-management
   ```
2. Install dependencies:
   ```sh
   npm install
   ```
3. Set up environment variables in a `.env` file:
   ```env
   DB_HOST=localhost
   DB_USER=root
   DB_PASSWORD=yourpassword
   DB_NAME=hotel_management
   JWT_SECRET=your_secret_key
   ```
4. Run database migrations:
   ```sh
   node src/db/migrate.js
   ```
5. Start the server:
   ```sh
   npm start
   ```
6. Access the API at `http://localhost:5000`

## API Endpoints
### Authentication
- `POST /api/auth/login` - Login
- `POST /api/auth/register` - Register new user (Super Admin only)

### Room Management
- `POST /api/rooms` - Create a new room
- `GET /api/rooms` - Get all rooms
- `PUT /api/rooms/:id` - Update room details
- `DELETE /api/rooms/:id` - Delete a room

### Booking
- `POST /api/bookings` - Create a new booking
- `GET /api/bookings` - View all bookings
- `PUT /api/bookings/:id` - Update booking status

## Contribution Guidelines
1. Fork the repository.
2. Create a new branch: `git checkout -b feature-branch`
3. Make changes and commit: `git commit -m 'Add new feature'`
4. Push to the branch: `git push origin feature-branch`
5. Create a Pull Request.

## License
This project is licensed under the MIT License.

## Contact
For any issues, please create an issue in the GitHub repository or contact the development team.

