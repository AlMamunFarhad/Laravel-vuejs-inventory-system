# Laravel Vue.js Inventory System

A full-featured Inventory Management System built with **Laravel** (backend) and **Vue.js** (frontend). This project is designed to handle product stock, sales, employee management, and more — with a clean and modern UI powered by Vue and robust API support via Laravel.

---

## Project Overview

This application includes:

- 🔐 **Login & Authentication (JWT)**
- 🔎 **Search Functionality**
- 📦 **Product Management**
- 📊 **Stock Tracking**
- 🗂️ **Category Management**
- 👨‍💼 **Employee Records**
- 🏬 **Supplier Management**
- 👥 **Customer Management**
- 💸 **Expense Tracking**
- 💰 **Salary Management**
- ✅ And many more useful features...

---

## ⚙️ Technologies Used

### 🧠 Backend
- **Laravel** – PHP framework
- **JWT Token Auth** – API security
- **Postman** – API testing

### 🎨 Frontend
- **Vue.js** – Reactive UI framework
- **Vue Router** – Page navigation
- **Axios** – HTTP requests
- **SweetAlert2** – Stylish alerts

---

## 🛠️ Installation & Setup

### 📥 Clone the Repository
```bash
git clone https://github.com/AlMamunFarhad/laravel-vuejs-inventory-system.git
cd laravel-vuejs-inventory-system
```

### ⚙️ Backend Setup (Laravel)
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan jwt:secret
php artisan serve
```

Set up your `.env` file with database info.

### 🎨 Frontend Setup (Vue.js)
```bash
npm install
npm run dev
```

---

## 🔐 Authentication Info

The system uses **JWT-based API authentication**.  
All protected routes require a valid Bearer token, which is issued on successful login.

---

## 🧪 API Testing

Use **Postman** or any API testing tool to hit routes like:
- `POST /api/auth/login`
- `GET /api/product`
- `POST /api/employee`
- etc.

Make sure to send the `Authorization: Bearer <token>` header with secured requests.

---

## 📂 Folder Structure

```bash
├── backend/         # Laravel codebase
│   └── app/
│   └── routes/api.php
│   └── config/
├── frontend/        # Vue.js SPA
│   └── js/
│       ├── components/
│       ├── router
│       └── app
```

---

## 🤝 Contribution

Pull requests are welcome!  
If you’d like to contribute or suggest features, feel free to open an issue.

---

## 📄 License

This project is open-source and available under the [MIT License](https://opensource.org/licenses/MIT).

---

## 🔗 GitHub Repository

👉 [Laravel-vuejs-inventory-system](https://github.com/AlMamunFarhad/laravel-vuejs-inventory-system)
