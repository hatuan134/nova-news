# NOVA NEWS – Website Tin tức / Cổng thông tin

**Môn học:** Triển khai và Quản trị Hệ thống Phần mềm  
**Đề tài:** 19 – Website Tin tức / Cổng thông tin  
**Môi trường:** Windows 11, Docker Desktop, Docker Compose

## 1. Giới thiệu

NOVA NEWS là website tin tức xây dựng bằng WordPress và MySQL. Hệ thống cho phép người dùng đọc, tìm kiếm bài viết theo danh mục và người quản trị quản lý nội dung.

Dự án sử dụng Docker Compose để triển khai website, Nginx làm Reverse Proxy, Prometheus và Grafana để giám sát, Loki và Promtail để thu thập log tập trung.

## 2. Các công nghệ sử dụng

| Công nghệ | Chức năng |
|---|---|
| WordPress | Xây dựng và quản lý website |
| MySQL | Lưu trữ dữ liệu |
| phpMyAdmin | Quản lý cơ sở dữ liệu |
| Nginx | Reverse Proxy và Security Headers |
| Docker Compose | Quản lý các dịch vụ container |
| Prometheus | Thu thập metrics |
| Grafana | Hiển thị dashboard |
| cAdvisor | Giám sát tài nguyên container |
| Nginx Exporter | Giám sát Nginx |
| MySQL Exporter | Giám sát MySQL |
| Loki và Promtail | Thu thập và lưu trữ log |
| LogQL | Truy vấn log |

Hệ thống gồm 11 dịch vụ được khai báo trong `compose.yaml`.

## 3. Hướng dẫn cài đặt và chạy

### 3.1. Yêu cầu

Máy tính cần cài đặt Docker Desktop (Linux Containers), Docker Compose và Git. Cần kết nối Internet khi tải Docker images lần đầu.

### 3.2. Tải mã nguồn

Mở PowerShell và thực hiện:

`git clone https://github.com/hatuan134/nova-news.git`

`cd nova-news`

### 3.3. Cấu hình môi trường

Tạo file `.env` từ file mẫu:

`Copy-Item .env.example .env`

Mở `.env` và thiết lập các biến:

- `MYSQL_DATABASE`: Tên database.
- `MYSQL_USER`: Tài khoản WordPress kết nối MySQL.
- `MYSQL_PASSWORD`: Mật khẩu tài khoản MySQL.
- `MYSQL_ROOT_PASSWORD`: Mật khẩu quản trị MySQL.
- `GRAFANA_ADMIN_PASSWORD`: Mật khẩu Grafana.
- `MYSQL_EXPORTER_PASSWORD`: Mật khẩu tài khoản giám sát MySQL.

Sử dụng mật khẩu mạnh, không đưa file `.env` lên GitHub.

### 3.4. Khởi động các dịch vụ

Kiểm tra cấu hình:

`docker compose config --quiet`

Khởi động các dịch vụ ban đầu:

`docker compose up -d mysql wordpress nginx phpmyadmin prometheus grafana cadvisor nginx-exporter loki promtail`

Kiểm tra trạng thái:

`docker compose ps`

### 3.5. Tạo tài khoản MySQL Exporter

Đăng nhập MySQL:

`docker compose exec mysql mysql -u root -p`

Thực hiện các câu lệnh SQL:

`CREATE USER 'nova_exporter'@'%' IDENTIFIED BY 'MAT_KHAU_RIENG' WITH MAX_USER_CONNECTIONS 3;`

`GRANT PROCESS, REPLICATION CLIENT, SELECT ON *.* TO 'nova_exporter'@'%';`

`EXIT;`

Thay `MAT_KHAU_RIENG` bằng đúng mật khẩu đã đặt trong biến `MYSQL_EXPORTER_PASSWORD`.

Sau đó khởi động exporter:

`docker compose up -d mysql-exporter`

### 3.6. Hoàn tất cấu hình

- Cài đặt WordPress và kích hoạt theme Nova News.
- Tạo các danh mục và bài viết hoặc khôi phục dữ liệu từ bản sao lưu riêng.
- Trong Grafana, thêm Prometheus với URL `http://prometheus:9090`.
- Thêm Loki với URL `http://loki:3100`.
- Tạo dashboard giám sát hoặc nhập dashboard JSON đã xuất trước đó.

Lưu ý: Repository chứa mã nguồn và cấu hình. Dữ liệu bài viết, ảnh tải lên và dashboard đã tạo trực tiếp trên Grafana được lưu trong Docker volumes, không tự động xuất hiện khi clone repository.

## 4. Địa chỉ truy cập

| Thành phần | Địa chỉ |
|---|---|
| Website | http://localhost:8080 |
| WordPress Admin | http://localhost:8080/wp-admin |
| phpMyAdmin | http://localhost:8081 |
| Prometheus | http://localhost:9090 |
| Prometheus Targets | http://localhost:9090/targets |
| Grafana | http://localhost:3000 |
| Loki Ready | http://localhost:3100/ready |

## 5. Kiểm tra hệ thống

**Kiểm tra container:**

`docker compose ps`

**Kiểm tra Nginx:**

`docker compose exec nginx nginx -t`

`curl.exe -I http://localhost:8080`

**Kiểm tra Prometheus:**

Mở trang Targets và kiểm tra 4 target `prometheus`, `cadvisor`, `nginx`, `mysql` ở trạng thái UP.

Các truy vấn PromQL:

- `container_memory_working_set_bytes`
- `nginx_up`
- `mysql_up`

**Kiểm tra log trong Grafana Explore:**

Truy vấn LogQL:

1. Xem log Nginx: `{service="nginx"}`
2. Lọc yêu cầu GET: `{service="nginx"} |= "GET"`
3. Thống kê log: `sum(count_over_time({service="nginx"}[5m]))`

## 6. Bảo mật hệ thống

Các biện pháp đã triển khai:

- Security Headers cơ bản trên Nginx.
- Ẩn thông tin phiên bản PHP trong HTTP Header.
- Mạng Docker `database` có `internal: true`.
- Grafana và Prometheus chạy với UID khác 0.
- Tài khoản MySQL Exporter chỉ được cấp các quyền phục vụ giám sát.
- Mật khẩu được quản lý bằng file `.env`, không lưu trực tiếp trong repository.

Hệ thống được xây dựng phục vụ thực hành trên máy cá nhân, chưa cấu hình HTTPS và chưa được hardening đầy đủ cho môi trường production.

