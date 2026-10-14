# NOVA NEWS — Đề 19: Website tin tức / Cổng thông tin

**Môn:** Triển khai và Quản trị Hệ thống Phần mềm  
**Môi trường demo:** Windows 11 + Docker Desktop + Docker Compose  
**Trạng thái:** Mốc 1 (website, MySQL, phpMyAdmin, Nginx cơ bản). Chưa có hệ thống Prometheus/Grafana/Loki/Promtail; sẽ bổ sung các mốc tiếp theo.

## 1. Cấu trúc hệ thống mốc 1

```text
Browser (http://localhost:8080)
    |
    v
Nginx (:80 trong container)
    |
    v
WordPress (Apache :80 trong container) ----> MySQL (:3306)
                                               ^
                                               |
                    phpMyAdmin (127.0.0.1:8081)
```

- `nginx`: reverse proxy nhận request và bổ sung security headers cơ bản.
- `wordpress`: CMS với theme NOVA NEWS tự phát triển.
- `mysql`: database, **không công bố cổng ra host**.
- `phpmyadmin`: công cụ quản trị database, chỉ bind cổng localhost trên laptop.
- `database`: mạng Docker có `internal: true`; WordPress nằm trên cả `frontend` và `database`.

## 2. Yêu cầu máy tính

- Windows 11, Docker Desktop bật Linux Containers / WSL 2.
- Có kết nối internet **khi tải Docker images lần đầu**.
- Nên dành tối thiểu 5–10 GB trống; dự án cuối cùng sẽ có thêm nhiều dịch vụ.

## 3. Khởi tạo lần đầu (PowerShell)

Mở thư mục `nova-news-starter` bằng **File → Open Folder** trong VS Code. Sau đó Terminal → New Terminal (PowerShell).

```powershell
docker --version
docker compose version
git --version
Copy-Item .env.example .env
notepad .env
```

Trong `.env`, sửa **cả hai mật khẩu** thành hai chuỗi dài, độc lập. Có thể tạo từng chuỗi bằng PowerShell:

```powershell
[Convert]::ToHexString([Security.Cryptography.RandomNumberGenerator]::GetBytes(24))
```

Chạy **hai lần**, dùng mỗi kết quả cho một biến. Không đăng `.env` lên GitHub hoặc chụp màn hình chứa mật khẩu.

```powershell
docker compose config --services
docker compose pull
docker compose up -d
docker compose ps
```

Lần đầu có thể phải chờ MySQL khởi tạo 1–3 phút. `docker compose ps` nên hiển thị 4 services `nginx`, `wordpress`, `mysql`, `phpmyadmin` đang chạy; riêng MySQL health hiển thị `healthy`.

## 4. Cài WordPress trong trình duyệt

1. Vào `http://localhost:8080`.
2. Nếu hiện trang cài đặt WordPress: chọn ngôn ngữ **Tiếng Việt**, nhập tên website `NOVA NEWS – Cổng thông tin`, tạo admin và mật khẩu mạnh. **Không dùng tên đăng nhập `admin` nếu có lựa chọn tốt hơn.**
3. Đăng nhập tại `http://localhost:8080/wp-admin`.
4. Vào **Giao diện → Giao diện (Themes) → Nova News → Kích hoạt**.
5. Vào **Cài đặt → Đường dẫn tĩnh (Permalinks) → Tên bài viết → Lưu thay đổi**.
6. Tại **Bài viết → Chuyên mục (Categories)**, tạo: Công nghệ, Giáo dục, Đời sống, Kinh tế, Thể thao, Giải trí.
7. Tại **Bài viết → Viết bài mới**, tạo ít nhất 6 bài viết của riêng bạn (tiêu đề, nội dung, danh mục, ảnh đại diện nếu có), rồi bấm **Đăng**.
8. Tại **Giao diện → Menu**, tạo menu các chuyên mục, gán vào vị trí **Menu chính**. Nếu giao diện WP không có mục Menu do phiên bản, có thể dùng menu chuyên mục mặc định do theme hiển thị.
9. Làm mới `http://localhost:8080`: trang chủ sẽ hiển thị tin nổi bật, tiêu điểm, tin mới và chuyên mục từ **database**.

Lưu ý: Ảnh thumbnail không bắt buộc để trang trông gọn gàng — giao diện có ảnh gradient dự phòng. Với bài thi, nên tự tải ảnh bạn có quyền sử dụng và ghi rõ nguồn.

## 5. Kiểm tra MySQL & phpMyAdmin

1. Mở `http://localhost:8081`.
2. Đăng nhập bằng tài khoản `MYSQL_USER` và `MYSQL_PASSWORD` trong `.env`, **không dùng tài khoản WordPress**.
3. Chọn database `nova_news` → bảng `wp_posts` (tiền tố mặc định, có thể khác nếu thay đổi config).
4. Tab SQL, chạy:

```sql
SELECT ID, post_title, post_status, post_date
FROM wp_posts
WHERE post_type = 'post'
ORDER BY post_date DESC
LIMIT 10;
```

Kết quả phải có ít nhất một bài viết bạn vừa đăng. Tuyệt đối không sửa trực tiếp bảng khi chưa hiểu ý nghĩa dữ liệu.

## 6. Kiểm tra Nginx

```powershell
curl.exe -I http://localhost:8080
```

Mong đợi có `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `Referrer-Policy: strict-origin-when-cross-origin`.

```powershell
docker compose exec nginx nginx -t
```

Mong đợi kiểm tra cú pháp Nginx thành công. Với bài báo cáo, chụp ảnh hiển thị lệnh + kết quả, không chỉ chụp file cấu hình.

## 7. Kiểm tra tình trạng & xử lý sự cố

```powershell
docker compose ps
docker compose logs --tail=100 mysql
docker compose logs --tail=100 wordpress
docker compose logs --tail=100 nginx
```

- `Cannot connect to Docker daemon`: mở Docker Desktop, chờ Engine chạy.
- `port is already allocated`: một phần mềm khác đang dùng 8080 hoặc 8081; kiểm tra tiến trình trước khi đổi cổng. Nếu đổi 8080, đồng thời chỉnh `WP_HOME` và `WP_SITEURL` ở `compose.yaml`.
- MySQL `unhealthy`: kiểm tra `.env`, logs; lần đầu cần chờ khởi tạo.
- WordPress không tải được theme: xem container mount `./wordpress/themes/nova-news` và tên thư mục.
- 404 khi mở bài viết: vào WP-admin → Cài đặt → Đường dẫn tĩnh → Lưu thay đổi.
- Đổi mật khẩu `.env` sau khi đã tạo `mysql_data` **không đổi mật khẩu MySQL hiện có**; đừng sửa `.env` tùy tiện sau khi khởi tạo.

Dừng mà vẫn **giữ dữ liệu**:

```powershell
docker compose down
```

⚠️ **KHÔNG chạy `docker compose down -v` nếu không chủ ý xóa dữ liệu** (xóa các volume MySQL và WordPress).

## 8. GitHub — lịch sử commit có ý nghĩa

Sau khi tự chạy thành công và kiểm tra, làm lần đầu:

```powershell
git init
git add .
git status
git commit -m "feat: deploy news portal via Nginx with WordPress and MySQL"
```

Thêm remote bằng URL repository GitHub **của bạn** và push (chỉ làm sau khi bạn đã tạo repository, không tự đặt URL):

```powershell
git branch -M main
git remote add origin <URL_REPO_GITHUB_CUA_BAN>
git push -u origin main
```

Commit đầu tiên ở trên là **commit 1 - mốc Nginx**, chỉ tạo sau khi kiểm tra website, database và proxy thật sự chạy. Khi tích hợp xong Prometheus/Grafana, tạo **commit 2**; khi tích hợp xong Loki/Promtail, tạo **commit 3**. **Không tạo commit rỗng chỉ để đủ số.**

Tên tài khoản GitHub của bạn đã tồn tại, nhưng đề bài yêu cầu tên theo MSSV; nên xác nhận với giảng viên rằng tài khoản đang dùng được chấp nhận. Repo có thể đặt tên chứa MSSV, nhưng tên repo **không tự động thay thế** điều kiện về tên tài khoản.

## 9. Phạm vi repository

Repository này chỉ quản lý mã nguồn, cấu hình triển khai và tài liệu hướng dẫn chạy. **Ảnh minh chứng và báo cáo môn học được lưu riêng, không đưa vào repository.** Báo cáo sử dụng kết quả kiểm tra thực tế của hệ thống.

## 10. Việc chưa có trong mốc 1

- Prometheus, exporters, Grafana dashboards
- Loki, Promtail, LogQL
- Thử nghiệm non-root container, giới hạn quyền hệ thống và kiểm thử hardening đầy đủ
- Gói demo dữ liệu có thể tái tạo ở máy khác, backup/restore, full security review

Các tính năng trên là tiêu chí bắt buộc của đề và sẽ được triển khai ở mốc kế tiếp.
