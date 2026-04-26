<?php
// إعدادات الاتصال
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cow_food_sales";

// إنشاء الاتصال بدون تحديد قاعدة البيانات
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// إنشاء قاعدة البيانات إذا لم تكن موجودة
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql_create_db) === TRUE) {
    // نجح إنشاء قاعدة البيانات
} else {
    die("خطأ في إنشاء قاعدة البيانات: " . $conn->error);
}

// اختيار قاعدة البيانات
$conn->select_db($dbname);

// إنشاء الجدول إذا لم يكن موجوداً
$sql_create_table = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    food_type VARCHAR(100) NOT NULL,
    quantity INT NOT NULL,
    address TEXT NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conn->query($sql_create_table) === TRUE) {
    // نجح إنشاء الجدول
} else {
    die("خطأ في إنشاء الجدول: " . $conn->error);
}

// الحصول على بيانات النموذج
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$food_type = $_POST['food_type'];
$quantity = $_POST['quantity'];
$address = $_POST['address'];

// التحقق الأساسي من جانب الخادم
if (empty($name) || empty($email) || empty($phone) || empty($food_type) || empty($quantity) || empty($address)) {
    die("جميع الحقول مطلوبة.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("بريد إلكتروني غير صحيح.");
}

if (!preg_match("/^(\+216|216)?[0-9]{8}$/", $phone)) {
    die("رقم هاتف غير صحيح.");
}

if ($quantity < 1) {
    die("كمية غير صحيحة.");
}

// إدراج في قاعدة البيانات
$sql = "INSERT INTO orders (name, email, phone, food_type, quantity, address) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssis", $name, $email, $phone, $food_type, $quantity, $address);

if ($stmt->execute()) {
    // حساب تاريخ التسليم (بعد 48 ساعة)
    $order_date = date('Y-m-d H:i:s');
    $delivery_date = date('Y-m-d H:i:s', strtotime('+48 hours'));
    
    // إنشاء صفحة تأكيد مع رسالة التسليم
    ?>
    <!DOCTYPE html>
    <html lang="ar" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>تأكيد الطلب</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 20px;
                direction: rtl;
                text-align: right;
            }
            .confirmation {
                max-width: 600px;
                margin: 50px auto;
                background-color: white;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            .success {
                color: #4CAF50;
                font-size: 1.5em;
                margin-bottom: 20px;
            }
            .delivery-message {
                background-color: #e8f5e8;
                border-left: 5px solid #4CAF50;
                padding: 15px;
                margin: 20px 0;
                border-radius: 4px;
            }
            .delivery-message h3 {
                color: #2e7d32;
                margin-top: 0;
            }
            .order-details {
                background-color: #f9f9f9;
                padding: 15px;
                margin: 20px 0;
                border-radius: 4px;
            }
            .order-details p {
                margin: 10px 0;
            }
            .back-button {
                background-color: #4CAF50;
                color: white;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 5px;
                display: inline-block;
                margin-top: 20px;
                text-align: center;
            }
            .back-button:hover {
                background-color: #45a049;
            }
        </style>
    </head>
    <body>
        <div class="confirmation">
            <h1 class="success">✓ تم إرسال الطلب بنجاح!</h1>
            
            <div class="order-details">
                <h3>بيانات الطلب:</h3>
                <p><strong>الاسم:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>البريد الإلكتروني:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>الهاتف:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <p><strong>نوع العلف:</strong> <?php echo htmlspecialchars($food_type); ?></p>
                <p><strong>الكمية:</strong> <?php echo htmlspecialchars($quantity); ?> كيلو</p>
                <p><strong>العنوان:</strong> <?php echo htmlspecialchars($address); ?></p>
            </div>
            
            <div class="delivery-message">
                <h3>⏱️ معلومات التسليم</h3>
                <p><strong>تاريخ الطلب:</strong> <?php echo $order_date; ?></p>
                <p><strong>موعد التسليم المتوقع:</strong> <?php echo $delivery_date; ?></p>
                <p style="color: #2e7d32; font-weight: bold;">سيتم توصيل طلبك خلال 48 ساعة من الآن. شكراً لاختيارك!</p>
            </div>
            
            <a href="vente-aliment-bovin.html" class="back-button">العودة إلى الصفحة الرئيسية</a>
        </div>
    </body>
    </html>
    <?php
} else {
    echo "خطأ في الإرسال: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>