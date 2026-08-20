# โครงสร้างโปรเจกต์ (Project Structure & Technologies)

เอกสารนี้รวบรวมข้อมูลเกี่ยวกับสถาปัตยกรรม เทคโนโลยีที่ใช้ และโครงสร้างของโปรเจกต์ เพื่อเป็นคู่มือสำหรับนักพัฒนาและ AI ในการทำความเข้าใจระบบ

## 🛠 เทคโนโลยีที่ใช้ (Tech Stack)

### โครงสร้างพื้นฐาน (Infrastructure)
*   **Docker & Docker Compose**: ใช้สำหรับจำลองสภาพแวดล้อมการรันแอปพลิเคชัน (Containerization) ทำให้สามารถรันโปรเจกต์ได้ทุกที่โดยไม่ต้องเซ็ตอัปเซิร์ฟเวอร์เอง
*   **Nginx**: เว็บเซิร์ฟเวอร์สำหรับฝั่ง Frontend

### Frontend (หน้าบ้าน)
*   **HTML5 / CSS3 / JavaScript (Vanilla)**: โครงสร้างหลักของหน้าเว็บ
*   **Tailwind CSS (via CDN)**: เฟรมเวิร์ก CSS สำหรับจัดการความสวยงามและ Layout (Utility-First)
*   **FontAwesome (v6)**: จัดการไอคอนต่างๆ ภายในระบบ
*   **Google Fonts (Prompt)**: ฟอนต์หลักของเว็บไซต์

### Backend & API (หลังบ้าน)
*   **PHP 8.2 (Apache)**: ภาษาหลักในการพัฒนาทั้งส่วนของ Admin Panel และ API
*   **PDO (PHP Data Objects)**: ใช้สำหรับเชื่อมต่อและจัดการข้อมูลในฐานข้อมูลอย่างปลอดภัย

### Database (ฐานข้อมูล)
*   **MySQL 8.0**: ระบบจัดการฐานข้อมูลเชิงสัมพันธ์ (RDBMS)
*   **phpMyAdmin**: เครื่องมือแบบ GUI (Web-based) สำหรับจัดการฐานข้อมูล MySQL ได้อย่างง่ายดาย

---

## 📁 โครงสร้างโฟลเดอร์ (Directory Structure)

```text
Project_docker/
│
├── Backend/              # ส่วนจัดการฐานข้อมูลและ API
│   ├── .env              # ไฟล์เก็บ Environment Variables
│   ├── docker-compose.yml# รัน Backend (admin, api, mysql, phpmyadmin)
│   ├── database/         # เก็บไฟล์ SQL 
│   ├── admin/            # โฟลเดอร์ระบบหลังบ้าน (เดิมคือ backend)
│   │   ├── db.php        
│   │   ├── settings.php  
│   │   └── Dockerfile    
│   └── api/              # โฟลเดอร์สำหรับ REST API
│       ├── db.php        
│       ├── get_settings.php
│       └── Dockerfile    
│
└── Frontend/             # ส่วนแสดงผลหน้าเว็บ
    ├── docker-compose.yml# รัน Frontend (Nginx)
    ├── index.html        # ไฟล์หน้าแรก
    ├── app.js            # ดึงข้อมูลผ่าน API
    └── Dockerfile        
```

## 🔄 ภาพรวมการทำงาน (Data Flow)

1.  **Admin** เข้าสู่ระบบ `Backend/admin/settings.php` เพื่อเปลี่ยนข้อมูล ข้อมูลจะบันทึกลง **MySQL** 
2.  ผู้ใช้ทั่วไปเข้าเว็บที่ `Frontend/index.html` (Port 8080)
3.  โค้ด JavaScript (`Frontend/app.js`) จะยิง Request ไปที่ `localhost:8083` แบบเบื้องหลัง
4.  **API** จะไปดึงข้อมูลที่ตั้งค่าไว้จาก **MySQL** แล้วส่งกลับมาในรูปแบบ **JSON**
5.  JavaScript จะนำข้อมูล JSON มาเรนเดอร์ลงบนเว็บไซต์ทันที ทำให้หน้าเว็บเปลี่ยนตามที่ Admin ตั้งค่าไว้แบบอัตโนมัติ
