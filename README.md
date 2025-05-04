# 🏠 Estate Portal | بوابة العقارات

> A dynamic real estate platform that connects property owners and seekers directly — with live chat, dashboards, and full property control.  
> منصة ديناميكية للعقارات تربط بين المالكين والباحثين بشكل مباشر — مع دردشة مباشرة ولوحات تحكم وإدارة كاملة للعقارات.

---

## ✨ Features | الميزات

### 👨‍💼 Admin Panel | لوحة تحكم المدير:
- View and manage users.  
  عرض وإدارة المستخدمين.
- Add and edit website content and settings.  
  إضافة وتعديل محتوى وإعدادات الموقع.

### 👤 User Features | ميزات المستخدم:
- Register and login.  
  تسجيل حساب جديد وتسجيل الدخول.
- Add, edit, delete properties (with SweetAlert notifications).  
  إضافة، تعديل، حذف العقارات (مع تنبيهات SweetAlert).
- Advanced property search.  
  بحث عقاري متقدّم.
- Real-time property chat (AJAX).  
  دردشة مباشرة للعقار (باستخدام Ajax).
- Mark property as sold.  
  إتمام صفقة بيع (تحويل العقار إلى "مُباع").
- Edit profile and password.  
  تعديل الملف الشخصي وكلمة المرور.

---

## ⚙️ Requirements | المتطلبات

- **PHP** – For backend logic  
  PHP – لمعالجة منطق الخادم
- **MySQL** – For storing data  
  MySQL – لتخزين بيانات العقارات والمستخدمين
- **Apache Server** – Recommended via XAMPP  
  خادم Apache – يُفضّل استخدام XAMPP محليًا
- **Visual Studio Code** – As a development environment  
  Visual Studio Code – كبيئة تطوير وكتابة الكود

---

## 🛠 Installation & Setup | التثبيت والتشغيل

### English:

1. Clone the repository or download the ZIP.  
2. Move the project to your local server directory (`htdocs` if using XAMPP).  
3. Create a MySQL database (e.g., `estate_portal`) and import the provided SQL file.  
4. Update the database connection settings in `includes/db_config.php`.  
5. Start Apache and MySQL from XAMPP.  
6. Open the project in your browser:  
   `http://localhost/estate-portal/`

### العربية:

1. قم باستنساخ المشروع أو تحميله كملف مضغوط.  
2. ضع المشروع داخل مجلد السيرفر المحلي (مثلًا: `htdocs` في XAMPP).  
3. أنشئ قاعدة بيانات في MySQL (مثال: `estate_portal`) واستورد ملف SQL المرفق.  
4. عدّل بيانات الاتصال بقاعدة البيانات داخل الملف: `includes/db_config.php`.  
5. شغّل Apache وMySQL من XAMPP.  
6. افتح المشروع من المتصفح:  
   `http://localhost/estate-portal/`

---

## 📸 Screenshots | لقطات شاشة

<img src="https://github.com/user-attachments/assets/f8ba0368-71f4-4d11-902b-9c6078b54a24" width="600" />
<img src="https://github.com/user-attachments/assets/b826a407-0aa2-476b-902d-f45807d063ad" width="600" />
<img src="https://github.com/user-attachments/assets/dbd28745-832d-4b61-ab3e-949501e740c2" width="600" />
<img src="https://github.com/user-attachments/assets/c58e5286-96bc-4c3b-8036-3d7eef531187" width="600" />
<img src="https://github.com/user-attachments/assets/45cfebd3-47e9-43e6-9ca1-2ba7316f9a24" width="600" />



---

## 📌 Notes | ملاحظات

- Real-time features are powered by **AJAX**.  
  الميزات المباشرة تعتمد على **Ajax**.
- Uses **SweetAlert** for better user interaction.  
  استخدام SweetAlert لتنبيهات تفاعلية.
- Easily extendable to include features like maps or payments.  
  قابل للتوسيع لإضافة خرائط أو الدفع الإلكتروني مستقبلًا.

> 🔐 **Security Notice:** Don't forget to sanitize inputs and secure user sessions for production use.  
> ⚠️ تنبيه أمني: تأكد من فحص المُدخلات وتأمين الجلسات عند استخدام المشروع في بيئة حقيقية.
