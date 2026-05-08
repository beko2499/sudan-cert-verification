# Sudan Certificate Verification System | نظام توثيق الشهادات السودانية

<p align="center">
  <img src="public/images/شعارونا.jpg" width="200" alt="Official Trust">
</p>

## Overview | نظرة عامة
The **Sudan Certificate Verification System** is a robust, secure, and centralized platform designed to modernize the process of verifying academic credentials in Sudan. This system serves as a bridge between universities, graduates, and employers/institutions, ensuring the integrity of academic documents and preventing forgery.

**نظام توثيق الشهادات السودانية** هو منصة قوية وآمنة ومركزية مصممة لتحديث عملية التحقق من الشهادات الأكاديمية في السودان. يعمل هذا النظام كجسر بين الجامعات والخريجين وأصحاب العمل/المؤسسات، مما يضمن سلامة الوثائق الأكاديمية ويمنع التزوير.

---

## Project Goal | هدف المشروع
The primary goal is to provide a unified digital environment where academic certificates can be verified instantly and securely. By digitizing the verification process, we aim to:
- Eliminate the reliance on manual, paper-based verification.
- Provide a reliable tool for employers to confirm candidate credentials.
- Protect the reputation of Sudanese academic institutions.

الهدف الأساسي هو توفير بيئة رقمية موحدة حيث يمكن التحقق من الشهادات الأكاديمية بشكل فوري وآمن. من خلال رقمنة عملية التحقق، نهدف إلى:
- القضاء على الاعتماد على التحقق اليدوي والورقي.
- توفير أداة موثوقة لأصحاب العمل للتأكد من مؤهلات المرشحين.
- حماية سمعة المؤسسات الأكاديمية السودانية.

---

## Vision | الرؤية
To become the definitive national reference for academic verification in Sudan, fostering a culture of transparency and digital excellence in the educational sector.

أن نصبح المرجع الوطني النهائي للتوثيق الأكاديمي في السودان، وتعزيز ثقافة الشفافية والتميز الرقمي في قطاع التعليم.

---

## Project Structure & File Explanation | شرح ملفات المشروع

This project is built using the **Laravel Framework**, following the MVC (Model-View-Controller) architecture.

هذا المشروع مبني باستخدام **إطار عمل Laravel**، متبعاً بنية MVC (الموديل - العرض - المتحكم).

### Core Directories | المجلدات الأساسية:

- **`app/`**: Contains the core logic of the application (Models, Controllers, and Middleware).
  - *يحتوي على المنطق الأساسي للتطبيق (النماذج، المتحكمات، والبرمجيات الوسيطة).*
- **`resources/views/`**: Contains the Blade templates for the UI (Admin dashboard, University portal, and Public verification form).
  - *يحتوي على قوالب Blade لواجهة المستخدم (لوحة تحكم المسؤول، بوابة الجامعة، ونموذج التحقق العام).*
- **`routes/`**: Defines the application's URLs and how they map to controllers.
  - *يحدد روابط التطبيق وكيفية توجيهها للمتحكمات.*
- **`public/`**: Stores public-facing assets like CSS, JavaScript, and Images (e.g., `images/security_privacy.png`).
  - *يخزن الملفات العامة مثل CSS و JavaScript والصور.*
- **`database/`**: Contains database migrations and seeders for initializing the system structure.
  - *يحتوي على تهجير وقواعد بيانات النظام.*
- **`config/`**: Configuration files for the application, database, and services.
  - *ملفات الإعدادات للتطبيق وقاعدة البيانات والخدمات.*

### Documentation Files | ملفات التوثيق:

- **`chapter3_analysis.html`**: Detailed analysis of the system requirements and stakeholders.
  - *تحليل مفصل لمتطلبات النظام وأصحاب المصلحة.*
- **`chapter4_design.html`**: Full technical design, including UML diagrams and architecture patterns.
  - *التصميم التقني الكامل، بما في ذلك مخططات UML وأنماط الهندسة.*

---

## Installation & Setup | التثبيت والإعداد

1. **Clone the repository | استنساخ المستودع**:
   ```bash
   git clone https://github.com/beko2499/sudan-cert-verification.git
   ```
2. **Install dependencies | تثبيت التبعيات**:
   ```bash
   composer install
   npm install
   ```
3. **Configure Environment | إعداد البيئة**:
   - Rename `.env.example` to `.env`.
   - Update database credentials.
4. **Run Migrations | تشغيل التهجير**:
   ```bash
   php artisan migrate
   ```
5. **Start Dev Server | تشغيل الخادم**:
   ```bash
   php artisan serve
   ```

---

## Technologies Used | التقنيات المستخدمة
- **Backend**: Laravel (PHP)
- **Frontend**: Blade, Tailwind CSS, JavaScript
- **Database**: MySQL
- **Documentation**: SVG Icons, HTML/CSS Reports

---

Developed with ❤️ for the future of Sudan.
تم التطوير بكل حب لمستقبل السودان.
