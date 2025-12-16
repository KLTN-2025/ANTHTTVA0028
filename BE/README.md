# AgoraLearn - Hệ thống Quản lý Học tập Trực tuyến

Hệ thống quản lý học tập trực tuyến với đầy đủ tính năng cho Sinh viên, Giảng viên và Quản trị viên.

## 🚀 Công nghệ sử dụng

### Backend
- **Laravel 12.0** - PHP Framework
- **MySQL** - Database
- **Sanctum** - API Authentication
- **Inertia.js** - Admin Portal

### Frontend
- **React 19.2** - UI Library
- **Vite** - Build Tool
- **TypeScript** - Type Safety
- **Tailwind CSS** - Styling
- **Radix UI** - Component Library
- **React Router** - Routing
- **Axios** - HTTP Client

## 📋 Yêu cầu hệ thống

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.0
- **MySQL** >= 8.0
- **XAMPP** hoặc **Laragon** (khuyến nghị)

## 🔧 Cài đặt

### 1. Clone Repository

```bash
git clone https://gitlab.com/ThanhTruong2311/nhom_10_2025.git
cd nhom_10_2025
```

### 2. Cài đặt Backend (Laravel)

```bash
# Cài đặt dependencies
composer install

# Copy file cấu hình
cp .env.example .env

# Tạo application key
php artisan key:generate

# Cấu hình database trong file .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agoralearn
DB_USERNAME=root
DB_PASSWORD=

# Chạy migrations và seeders
php artisan migrate:fresh --seed

# Khởi động server
php artisan serve
```

Backend sẽ chạy tại: `http://127.0.0.1:8000`

### 3. Cài đặt Frontend (React)

```bash
# Di chuyển vào thư mục frontend
cd AppClientFE

# Cài đặt dependencies
npm install

# Khởi động development server
npm run dev
```

Frontend sẽ chạy tại: `http://localhost:5173`

## 👥 Tài khoản mặc định

### Sinh viên
- **Email**: `hocvien@agoralearn.com`
- **Password**: `password`

### Giảng viên
- **Email**: `giangvien@agoralearn.com`
- **Password**: `password`

### Quản trị viên
- **Email**: `admin@agoralearn.com`
- **Password**: `password`

## 📁 Cấu trúc thư mục

```
nhom_10_2025/
├── app/                      # Laravel application
│   ├── Http/Controllers/Api/ # API Controllers
│   └── Models/              # Eloquent Models
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── routes/
│   └── api.php             # API routes
├── AppClientFE/            # React Frontend
│   ├── src/
│   │   ├── components/     # Reusable components
│   │   ├── pages/         # Page components
│   │   ├── services/      # API services
│   │   └── contexts/      # React contexts
│   └── public/            # Static assets
└── README.md
```

## 🎯 Tính năng chính

### Sinh viên
- ✅ Xem danh sách khóa học đã đăng ký
- ✅ Xem chi tiết khóa học và bài giảng
- ✅ Xem lịch học theo tuần
- ✅ Xem trạng thái bài tập (Chưa nộp, Đã nộp, Đã chấm)
- ✅ Dashboard với thống kê và thông báo
- 🚧 Nộp bài tập
- 🚧 Làm quiz
- 🚧 Xem video bài giảng

### Giảng viên
- 🚧 Quản lý lớp học
- 🚧 Tạo và quản lý bài giảng
- 🚧 Tạo và chấm bài tập
- 🚧 Xem danh sách sinh viên
- 🚧 Thống kê lớp học

### Quản trị viên
- 🚧 Quản lý người dùng
- 🚧 Quản lý khóa học
- 🚧 Quản lý lớp học
- 🚧 Thống kê hệ thống

**Chú thích**: ✅ Đã hoàn thành | 🚧 Đang phát triển

## 🔌 API Endpoints

### Authentication
```
POST   /api/login          # Đăng nhập
POST   /api/logout         # Đăng xuất
GET    /api/user           # Lấy thông tin user
```

### Student APIs
```
GET    /api/student/dashboard        # Dashboard data
GET    /api/student/courses          # Danh sách khóa học
GET    /api/student/courses/{id}     # Chi tiết khóa học
GET    /api/student/schedule         # Lịch học theo tuần
```

## 🐛 Xử lý sự cố

### Lỗi kết nối database
```bash
# Kiểm tra MySQL đã chạy chưa
# Kiểm tra thông tin trong .env
# Tạo database nếu chưa có
mysql -u root -p
CREATE DATABASE agoralearn;
```

### Lỗi CORS
```bash
# Đảm bảo frontend đang chạy ở port 5173
# Kiểm tra config/cors.php trong Laravel
```

### Lỗi 500 khi gọi API
```bash
# Xem log
tail -f storage/logs/laravel.log

# Clear cache
php artisan cache:clear
php artisan config:clear
```

## 📝 Development

### Chạy migrations mới
```bash
php artisan migrate
```

### Reset database và seed lại
```bash
php artisan migrate:fresh --seed
```

### Build frontend cho production
```bash
cd AppClientFE
npm run build
```

## 📚 Tài liệu bổ sung

- [DATABASE_DOCUMENTATION.md](./DATABASE_DOCUMENTATION.md) - Chi tiết cấu trúc database
- [Laravel Documentation](https://laravel.com/docs)
- [React Documentation](https://react.dev)

## 👨‍💻 Nhóm phát triển

**Nhóm 10 - Lập trình Web Nâng cao**

## 📄 License

This project is for educational purposes only.
