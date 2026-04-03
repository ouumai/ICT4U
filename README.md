# ICT4U System (Modernized Version) 🚀

**ICT4U** is a centralized service portal designed specifically for **Warga UKM**. This system serves as a one-stop center for various ICT-related services, offering a more streamlined, faster and user-friendly experience compared to the previous iteration.

## 🌟 Project Evolution & Credits
This project is a major enhancement and overhaul of the existing ICT4U website.
* **Supervised by:** Encik Noorulfaiz bin Ateman
* **Original Version:** Developed by **Shafiq** (Previous Industrial Trainee).
* **Current Version:** Fully refactored and modernized by **Umairah** to meet current web standards and high-performance requirements.

## 🛠 Tech Stack
* **Framework:** CodeIgniter 4.7.0 (Latest Stable)
* **Language:** PHP 8.4
* **Database:** MySQL
* **Target Audience:** Warga UKM (Staff & Students)

## ⚡ Key Improvements
* **Upgraded Core:** Migrated from legacy code to the latest CodeIgniter 4.7.0 & PHP 8.4 for better security and speed.
* **Enhanced UI/UX:** Improved service listing and navigation for a better user experience.
* **Optimized Performance:** Faster page loads and cleaner database queries.
* **Scalability:** Better folder structure for future feature expansions.

## 📌 Features
* **Service Catalog:** Browse all available ICT services for Warga UKM.
* **Centralized Dashboard:** Easy access to key resources and tools.
* **Modern Security:** Built-in protection against CSRF, XSS and SQL Injection.

## 🚀 Installation & Setup
1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/your-username/ict4u.git](https://github.com/your-username/ict4u.git)
    ```
2.  **Dependencies:**
    ```bash
    composer install
    ```
3.  **Environment Config:**
    * Copy `env` to `.env`
    * Update `database.default.hostname`, `database.default.database`, etc.
    * Set `CI_ENVIRONMENT = development` (for debugging).
4.  **Database Setup:**
    Import the SQL file or run migrations:
    ```bash
    php spark migrate
    ```
5.  **Run System:**
    ```bash
    php spark serve
    ```

---
