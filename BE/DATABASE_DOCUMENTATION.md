# AgoraLearn - Database Schema Documentation

## Tổng quan
Hệ thống quản lý học tập (LMS) với 21 bảng dữ liệu, hỗ trợ:
- Quản lý khóa học, lớp học, bài giảng
- Điểm danh thông minh với AI
- Theo dõi tương tác và phân tích học tập
- Hệ thống quiz và bài tập
- Thông báo

## Danh sách Migrations

Tất cả migrations đã được tạo theo thứ tự:

1. `0001_01_01_000000_create_users_table.php` - Bảng nguoi_dungs (người dùng)
2. `2025_11_10_142851_create_khoa_hocs_table.php` - Khóa học
3. `2025_11_10_142852_create_lop_hocs_table.php` - Lớp học
4. `2025_11_10_142853_create_bai_giangs_table.php` - Bài giảng
5. `2025_11_10_142854_create_lich_hocs_table.php` - Lịch học
6. `2025_11_10_142855_create_dang_kys_table.php` - Đăng ký học
7. `2025_11_10_142856_create_thiet_bis_table.php` - Thiết bị
8. `2025_11_10_142857_create_phien_hocs_table.php` - Phiên học
9. `2025_11_10_142858_create_su_kien_tuong_tacs_table.php` - Sự kiện tương tác
10. `2025_11_10_142859_create_diem_danhs_table.php` - Điểm danh
11. `2025_11_10_142900_create_nhan_diens_table.php` - Nhận diện AI
12. `2025_11_10_142901_create_tham_gia_phan_tichs_table.php` - Phân tích tham gia
13. `2025_11_10_142902_create_tai_lieus_table.php` - Tài liệu
14. `2025_11_10_142903_create_bai_taps_table.php` - Bài tập
15. `2025_11_10_142904_create_nop_bai_taps_table.php` - Nộp bài tập
16. `2025_11_10_142905_create_bai_kiem_tras_table.php` - Bài kiểm tra
17. `2025_11_10_142906_create_cau_hois_table.php` - Câu hỏi
18. `2025_11_10_142907_create_lua_chons_table.php` - Lựa chọn
19. `2025_11_10_142908_create_bai_lams_table.php` - Bài làm
20. `2025_11_10_142909_create_cau_tra_lois_table.php` - Câu trả lời
21. `2025_11_10_142910_create_thong_baos_table.php` - Thông báo

## Danh sách Models

Tất cả 20 Eloquent Models đã được tạo với đầy đủ relationships:

1. **NguoiDung** (`nguoi_dungs`) - Người dùng, thay thế User
2. **KhoaHoc** (`khoa_hocs`) - Khóa học
3. **LopHoc** (`lop_hocs`) - Lớp học
4. **BaiGiang** (`bai_giangs`) - Bài giảng
5. **LichHoc** (`lich_hocs`) - Lịch học
6. **DangKy** (`dang_kys`) - Đăng ký học
7. **ThietBi** (`thiet_bis`) - Thiết bị
8. **PhienHoc** (`phien_hocs`) - Phiên học
9. **SuKienTuongTac** (`su_kien_tuong_tacs`) - Sự kiện tương tác
10. **DiemDanh** (`diem_danhs`) - Điểm danh
11. **NhanDien** (`nhan_diens`) - Nhận diện khuôn mặt
12. **ThamGiaPhanTich** (`tham_gia_phan_tichs`) - Phân tích tham gia
13. **TaiLieu** (`tai_lieus`) - Tài liệu
14. **BaiTap** (`bai_taps`) - Bài tập
15. **NopBaiTap** (`nop_bai_taps`) - Nộp bài tập
16. **BaiKiemTra** (`bai_kiem_tras`) - Bài kiểm tra/Quiz
17. **CauHoi** (`cau_hois`) - Câu hỏi
18. **LuaChon** (`lua_chons`) - Lựa chọn câu trả lời
19. **BaiLam** (`bai_lams`) - Bài làm của học viên
20. **CauTraLoi** (`cau_tra_lois`) - Câu trả lời
21. **ThongBao** (`thong_baos`) - Thông báo

## Các Enum Types

Tất cả enum đã được định nghĩa trong migrations:

- **vai_tro**: quan_tri, giang_vien, hoc_vien
- **cap_do**: co_ban, trung_binh, nang_cao
- **hinh_thuc_khoa**: tu_hoc, live, blended
- **loai_noi_dung**: video, live, tai_lieu, bai_tap, quiz
- **trang_thai_lop**: len_ke_hoach, dang_hoc, ket_thuc
- **hinh_thuc_lich**: online, offline, hybrid
- **trang_thai_dang_ky**: dang_ky, huy, hoan_thanh
- **nguon_phien**: web, mobile, desktop
- **loai_su_kien**: play, pause, seek, hoan_thanh, click, chat, reaction, quiz_tra_loi, mo_tai_lieu, scroll
- **trang_thai_diem_danh**: co_mat, vang, tre
- **phuong_thuc_diem_danh**: ai, thu_cong, qr
- **loai_tai_lieu**: pdf, slide, link, khac
- **chinh_sach_cham**: diem_cao_nhat, lan_cuoi
- **loai_cau_hoi**: trac_nghiem, dung_sai, tu_luan
- **trang_thai_bai_lam**: dang_lam, nop, het_han

## Foreign Key Relationships

Tất cả relationships đã được thiết lập với cascade delete hoặc set null:

### Khóa học & Lớp học
- KhoaHoc → LopHoc (1:N)
- KhoaHoc → BaiGiang (1:N)
- LopHoc → LichHoc (1:N)
- LopHoc → DangKy (1:N)

### Người dùng
- NguoiDung → LopHoc (giảng viên) (1:N)
- NguoiDung → DangKy (học viên) (1:N)
- NguoiDung → ThietBi (1:N)
- NguoiDung → PhienHoc (1:N)
- NguoiDung → DiemDanh (học viên) (1:N)

### Học tập & Tương tác
- PhienHoc → SuKienTuongTac (1:N)
- LichHoc → DiemDanh (1:N)
- DiemDanh → NhanDien (1:N)

### Nội dung
- BaiGiang → TaiLieu (1:N)
- BaiGiang → BaiTap (1:N)
- BaiGiang → BaiKiemTra (1:N)

### Quiz System
- BaiKiemTra → CauHoi (1:N)
- CauHoi → LuaChon (1:N)
- BaiKiemTra → BaiLam (1:N)
- BaiLam → CauTraLoi (1:N)

## Indexes đã tạo

Tất cả các foreign keys và các cột thường xuyên query đã có index:
- Foreign key columns
- Email fields (unique)
- Timestamp fields (thoi_gian_bat_dau, thoi_diem, etc.)
- Status fields (da_doc, trang_thai)
- Composite unique indexes cho các bảng many-to-many

## Cấu hình Laravel đã cập nhật

1. **config/auth.php**: Model authentication chuyển sang `NguoiDung`
2. **database/factories/UserFactory.php**: Factory cho model NguoiDung
3. **database/seeders/DatabaseSeeder.php**: Tạo 3 tài khoản mẫu (admin, giảng viên, học viên)

## Chạy Migrations

```bash
# Chạy migrations
php artisan migrate

# Hoặc fresh migrate (xóa tất cả và tạo lại)
php artisan migrate:fresh

# Chạy với seeder
php artisan migrate:fresh --seed
```

## Tài khoản mặc định (sau khi seed)

- **Admin**: admin@agoralearn.com / password
- **Giảng viên**: giangvien@agoralearn.com / password
- **Học viên**: hocvien@agoralearn.com / password

## Lưu ý quan trọng

1. Tất cả models đã có relationships đầy đủ
2. Casts đã được thiết lập cho datetime, decimal, boolean, array
3. Foreign keys có onDelete cascade hoặc set null phù hợp
4. Unique constraints cho các cặp khóa quan trọng (dang_kys, diem_danhs, nop_bai_taps)
5. Model NguoiDung extends Authenticatable để hỗ trợ authentication Laravel
