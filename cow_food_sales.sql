-- قاعدة بيانات لبيع علف البقر
CREATE DATABASE IF NOT EXISTS cow_food_sales;

USE cow_food_sales;

-- جدول الطلبات
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    food_type VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    address TEXT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- إدراج بيانات عينة (اختياري)
INSERT INTO orders (name, email, phone, food_type, quantity, address) VALUES
('أحمد محمد', 'ahmed@example.com', '+21612345678', 'علف أخضر', 10, 'تونس'),
('فاطمة علي', 'fatima@example.com', '+21687654321', 'حبوب', 5, 'صفاقس');