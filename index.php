<?php
session_start();

require_once __DIR__ . "/lib/models/news.php";
require_once __DIR__ . "/lib/models/customer.php";
require_once __DIR__ . "/lib/models/purchase.php";
require_once __DIR__ . "/lib/models/purchaseitem.php";
require_once __DIR__ . "/lib/models/products.php";
require_once __DIR__ . "/lib/models/testimonial.php";
require_once __DIR__ . "/lib/models/user.php";
require_once __DIR__ . "/lib/mouse.php";
require_once __DIR__ . '/lib/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/lib/PHPMailer/SMTP.php';
require_once __DIR__ . '/lib/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$app     = new Mouse();
$baseUrl = "/online-art-store";

function render(string $view, array $data = []) {
    extract($data, EXTR_SKIP);
    global $baseUrl;
    $content = __DIR__ . "/views/pages/{$view}.php";
    include __DIR__ . "/views/layouts/standard.php";
}

// Admin only authentication middleware
function requireAdmin() {
    if (!User::isAdmin()) {
        header("Location: /online-art-store/admin/login");
        exit;
    }
}

// Home
$app->get("/", function() {
  $newsM = new News();
  $latest = $newsM->get_latest();
  render("home", ["latest" => $latest]);
});

// Admin Login page
$app->get("/admin/login", function() {
    if (User::isAdmin()) {
        header("Location: /online-art-store/admin/testimonials");
        exit;
    }
    render("admin_login");
});

// Process admin login
$app->post("/admin/login", function() {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    
    if ($email === 'admin123@gmail.com' && $password === 'admin123') {
        $userModel = new User();
        $user = $userModel->login($email, 'admin123');
        if (!$user) {
            // Register admin if not exists
            $userModel->register($email, 'admin123');
            $user = $userModel->login($email, 'admin123');
        }
        $_SESSION['user'] = $user;
        header("Location: /online-art-store/admin/testimonials");
        exit;
    } else {
        $_SESSION['login_error'] = "Invalid admin credentials.";
        header("Location: /online-art-store/admin/login");
        exit;
    }
});

// Admin Logout
$app->get("/admin/logout", function() {
    session_destroy();
    header("Location: /online-art-store/");
    exit;
});

// Products - PUBLIC ACCESS
$app->get("/products", function() {
    $m = new Product();
    $r = $m->get_all();
    if (!$r) die("❌ Failed to load products.");
    render("products", ["products" => $r]);
});

// Cart - PUBLIC ACCESS (NO LOGIN REQUIRED)
$app->get("/cart", function() {
    render("cart");
});

// Add to Cart - PUBLIC ACCESS (NO LOGIN REQUIRED)
$app->get("/add-to-cart/:id", function($app) {
    $id = $app->route_var("id");
    $_SESSION["cart"][] = $id;
    header("Location: /online-art-store/cart");
    exit;
});

// Remove from Cart - PUBLIC ACCESS (NO LOGIN REQUIRED)
$app->get("/remove-from-cart/:id", function($app) {
    $id = $app->route_var("id");
    $cart = $_SESSION["cart"] ?? [];
    
    $found = false;
    $newCart = [];
    foreach ($cart as $item) {
        if (!$found && (string)$item === (string)$id) {
            $found = true;
        } else {
            $newCart[] = $item;
        }
    }
    
    $_SESSION["cart"] = $newCart;
    header("Location: /online-art-store/cart");
    exit;
});

// Checkout form - PUBLIC ACCESS (NO LOGIN REQUIRED)
$app->get("/order", function() {
    render("order");
});

// Process order - PUBLIC ACCESS (NO LOGIN REQUIRED)
$app->post("/order", function() {
    $cart = $_SESSION["cart"] ?? [];
    if (empty($cart)) {
        $_SESSION['order_error'] = "Your cart is empty. Add some items first.";
        header("Location: /online-art-store/order");
        exit;
    }
    
    $email    = trim($_POST["email"] ?? "");
    $first    = trim($_POST["first_name"] ?? "");
    $last     = trim($_POST["last_name"] ?? "");
    $phone    = trim($_POST["phone"] ?? "");
    $address  = trim($_POST["address"] ?? "");
    $state    = trim($_POST["state"] ?? "");
    $postcode = trim($_POST["postcode"] ?? "");

    // Validate required fields
    if (!$first || !$last || !$email || !$address || !$state || !$postcode) {
        $_SESSION['order_error'] = "Please complete all required fields.";
        $_SESSION['order_data'] = $_POST;
        header("Location: /online-art-store/order");
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['order_error'] = "Please enter a valid email address format.";
        $_SESSION['order_data'] = $_POST;
        header("Location: /online-art-store/order");
        exit;
    }

    // Check for fake/placeholder domains
$fake_domains = ['@test.com', '@asdasd.com', '@email.com', '@example.com', '@fake.com', '@test.net', '@dummy.com'];
$email_lower = strtolower($email);
$is_fake = false;

foreach ($fake_domains as $fake_domain) {
    if (str_ends_with($email_lower, $fake_domain)) {
        $is_fake = true;
        break;
    }
}

if ($is_fake) {
    $_SESSION['order_error'] = "❌ The email address appears to be invalid or fake. Please use a real email to receive your order confirmation.";
    $_SESSION['order_data'] = $_POST;
    header("Location: /online-art-store/order");
    exit;
}
    // Update/Create customer info
    $C = new Customer();
    if (!$C->find_by_email($email)) {
        $C->create([
            "email"      => $email,
            "first_name" => $first,
            "last_name"  => $last,
            "phone"      => $phone,
            "address"    => $address,
            "state"      => $state,
            "postcode"   => $postcode,
        ]);
    }

    // Create purchase
    $P = new Purchase();
    $purchaseNo = $P->create($email);

    // Group cart items by product ID
    $cart_items = [];
    foreach ($cart as $id) {
        if (!isset($cart_items[$id])) {
            $cart_items[$id] = 0;
        }
        $cart_items[$id]++;
    }

    // Add items and build email
    $PI    = new PurchaseItem();
    $PrM   = new Product();
    $total = 0;

    // Build HTML email body 
    $html_body = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--[if mso]>
        <noscript>
            <xml>
                <o:OfficeDocumentSettings>
                    <o:PixelsPerInch>96</o:PixelsPerInch>
                </o:OfficeDocumentSettings>
            </xml>
        </noscript>
        <![endif]-->
        <style>
            /* Reset styles */
            body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
            table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
            img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
            
            /* Email container */
            body {
                margin: 0 !important;
                padding: 0 !important;
                background-color: #f5f5f5;
                font-family: Arial, sans-serif;
            }
            
            @media only screen and (max-width: 640px) {
                .container { width: 100% !important; }
                .content { padding: 20px !important; }
            }
        </style>
    </head>
    <body style="margin: 0; padding: 0; background-color: #f5f5f5;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f5f5f5;">
            <tr>
                <td align="center" style="padding: 40px 0;">
                    <!-- Main Container -->
                    <table class="container" border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                        <!-- Header -->
                        <tr>
                            <td align="center" style="padding: 40px 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px 20px 0 0;">
                                <!-- Logo -->
                                <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="center" style="background-color: #ffffff; width: 80px; height: 80px; border-radius: 50%; font-size: 40px; line-height: 80px;">
                                            <span style="color: #667eea;">🎨</span>
                                        </td>
                                    </tr>
                                </table>
                                <h1 style="color: #ffffff; font-size: 32px; margin: 20px 0 10px 0;">Darwin Art Store</h1>
                                <p style="color: #ffffff; font-size: 16px; margin: 0;">Order Confirmation</p>
                            </td>
                        </tr>
                        
                        <!-- Order Info -->
                        <tr>
                            <td class="content" style="padding: 40px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td style="background-color: #f7fafc; padding: 25px; border-radius: 10px; margin-bottom: 30px;">
                                            <h2 style="color: #333; font-size: 24px; margin: 0 0 10px 0;">Thank you for your order!</h2>
                                            <p style="color: #666; font-size: 16px; margin: 0;"><strong>Order Number:</strong> #' . $purchaseNo . '</p>
                                            <p style="color: #666; font-size: 16px; margin: 0;"><strong>Date:</strong> ' . date('F j, Y') . '</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- Order Details -->
                        <tr>
                            <td class="content" style="padding: 0 40px 40px 40px;">
                                <h3 style="color: #333; font-size: 20px; margin-bottom: 20px;">Order Details:</h3>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;">
                                    <thead>
                                        <tr>
                                            <th style="background-color: #667eea; color: #ffffff; padding: 15px; text-align: left; font-size: 14px;">Item</th>
                                            <th style="background-color: #667eea; color: #ffffff; padding: 15px; text-align: left; font-size: 14px;">Artist</th>
                                            <th style="background-color: #667eea; color: #ffffff; padding: 15px; text-align: center; font-size: 14px;">Price</th>
                                            <th style="background-color: #667eea; color: #ffffff; padding: 15px; text-align: center; font-size: 14px;">Qty</th>
                                            <th style="background-color: #667eea; color: #ffffff; padding: 15px; text-align: right; font-size: 14px;">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

    // Enhanced text body for store file
    $text_body = "========================================\n";
    $text_body .= "        DARWIN ART STORE\n";
    $text_body .= "        Order Confirmation\n";
    $text_body .= "========================================\n\n";
    $text_body .= "Thank you for your order!\n\n";
    $text_body .= "Order Number: #$purchaseNo\n";
    $text_body .= "Date: " . date('F j, Y') . "\n\n";
    $text_body .= "========================================\n";
    $text_body .= "ORDER DETAILS:\n";
    $text_body .= "========================================\n\n";
    $text_body .= sprintf("%-30s %-20s %10s %5s %10s\n", "Item", "Artist", "Price", "Qty", "Subtotal");
    $text_body .= str_repeat("-", 80) . "\n";

    foreach ($cart_items as $pid => $quantity) {
        $p = $PrM->get_by_id((int)$pid);
        if (!$p) continue;
        $PI->create($purchaseNo, (int)$pid, $quantity);
        $subtotal = $p["Price"] * $quantity;
        $total += $subtotal;
        
        // Add to HTML email
        $html_body .= '
                                        <tr>
                                            <td style="padding: 15px; border-bottom: 1px solid #e2e8f0; color: #333;">' . htmlspecialchars($p['Description']) . '</td>
                                            <td style="padding: 15px; border-bottom: 1px solid #e2e8f0; color: #666;">' . htmlspecialchars($p['Artist']) . '</td>
                                            <td style="padding: 15px; border-bottom: 1px solid #e2e8f0; color: #666; text-align: center;">$' . number_format($p['Price'], 2) . '</td>
                                            <td style="padding: 15px; border-bottom: 1px solid #e2e8f0; color: #666; text-align: center;">' . $quantity . '</td>
                                            <td style="padding: 15px; border-bottom: 1px solid #e2e8f0; color: #333; text-align: right;">$' . number_format($subtotal, 2) . '</td>
                                        </tr>';
        
        // Add to text body (formatted)
        $text_body .= sprintf("%-30s %-20s $%9.2f %5d $%9.2f\n", 
            substr($p['Description'], 0, 30), 
            substr($p['Artist'], 0, 20), 
            $p['Price'], 
            $quantity, 
            $subtotal
        );
    }

    $text_body .= str_repeat("-", 80) . "\n";
    $text_body .= sprintf("%56s TOTAL: $%9.2f\n", "", $total);

    $html_body .= '
                                        <tr>
                                            <td colspan="4" style="padding: 20px; background-color: #f7fafc; font-weight: bold; font-size: 18px;">Total</td>
                                            <td style="padding: 20px; background-color: #f7fafc; text-align: right; font-weight: bold; font-size: 18px; color: #667eea;">$' . number_format($total, 2) . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- Delivery Information -->
                        <tr>
                            <td class="content" style="padding: 0 40px 40px 40px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f7fafc; border-radius: 10px; padding: 25px;">
                                    <tr>
                                        <td>
                                            <h3 style="color: #333; font-size: 20px; margin: 0 0 15px 0;">Delivery Information:</h3>
                                            <p style="color: #666; font-size: 14px; margin: 5px 0;"><strong>Name:</strong> ' . htmlspecialchars($first . ' ' . $last) . '</p>
                                            <p style="color: #666; font-size: 14px; margin: 5px 0;"><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>
                                            <p style="color: #666; font-size: 14px; margin: 5px 0;"><strong>Address:</strong> ' . htmlspecialchars($address) . '</p>
                                            <p style="color: #666; font-size: 14px; margin: 5px 0;"><strong>State:</strong> ' . htmlspecialchars($state) . '</p>
                                            <p style="color: #666; font-size: 14px; margin: 5px 0;"><strong>Postcode:</strong> ' . htmlspecialchars($postcode) . '</p>
                                            ' . ($phone ? '<p style="color: #666; font-size: 14px; margin: 5px 0;"><strong>Phone:</strong> ' . htmlspecialchars($phone) . '</p>' : '') . '
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- Footer -->
                        <tr>
                            <td align="center" style="padding: 40px; background-color: #f7fafc; border-radius: 0 0 20px 20px;">
                                <p style="color: #666; font-size: 14px; margin: 0 0 10px 0;">Thank you for shopping with Darwin Art Store!</p>
                                <p style="color: #666; font-size: 14px; margin: 0;">If you have any questions, please contact us at<br>
                                <a href="mailto:info@darwinartstore.com.au" style="color: #667eea; text-decoration: none;">info@darwinartstore.com.au</a></p>
                                <div style="margin-top: 20px;">
                                    <span style="font-size: 30px; margin: 0 5px;">🎨</span>
                                    <span style="font-size: 30px; margin: 0 5px;">📦</span>
                                    <span style="font-size: 30px; margin: 0 5px;">🚚</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>';

    // Complete the text body
    $text_body .= "\n========================================\n";
    $text_body .= "DELIVERY INFORMATION:\n";
    $text_body .= "========================================\n\n";
    $text_body .= "Name: $first $last\n";
    $text_body .= "Email: $email\n";
    $text_body .= "Address: $address\n";
    $text_body .= "State: $state\n";
    $text_body .= "Postcode: $postcode\n";
    if ($phone) {
        $text_body .= "Phone: $phone\n";
    }
    $text_body .= "\n========================================\n";
    $text_body .= "Thank you for shopping with Darwin Art Store!\n";
    $text_body .= "If you have any questions, please contact us at\n";
    $text_body .= "info@darwinartstore.com.au\n";
    $text_body .= "========================================\n";

    // Send email using PHPMailer
    $email_sent = false;
    $email_error = '';
    
    // Load email configuration
    $config = include __DIR__ . '/lib/email_config.php';
    
    // Create PHPMailer instance
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $config['smtp_host'];
        $mail->SMTPAuth   = $config['smtp_auth'];
        $mail->Username   = $config['smtp_username'];
        $mail->Password   = $config['smtp_password'];
        $mail->SMTPSecure = $config['smtp_secure'];
        $mail->Port       = $config['smtp_port'];
        
        // Recipients
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addAddress($email, $first . ' ' . $last);
        $mail->addReplyTo($config['from_email'], $config['from_name']);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = "Order Confirmation #$purchaseNo - Darwin Art Store";
        $mail->Body    = $html_body;
        $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $html_body));
        
        // Send email
        $mail->send();
        $email_sent = true;
        
    } catch (Exception $e) {
        $email_error = $mail->ErrorInfo;
        error_log("PHPMailer Error: " . $email_error);
    }
    x
    // Always save text file for store
    file_put_contents("mail_to_store_$purchaseNo.txt", $text_body);
    
    // Also save HTML email to file as backup
    file_put_contents("mail_to_customer_$purchaseNo.html", $html_body);

    // Store the customer email for confirmation page
    $_SESSION["customer_email"] = $email;
    
    unset($_SESSION["cart"]);
    unset($_SESSION['order_data']);
    $_SESSION["last_order_no"] = $purchaseNo;
    $_SESSION["email_sent"] = $email_sent;
    $_SESSION["email_error"] = $email_error;

    header("Location: /online-art-store/confirm");
    exit;
});

// Confirmation - PUBLIC ACCESS (NO LOGIN REQUIRED)
$app->get("/confirm", function() {
    $no = $_SESSION["last_order_no"] ?? null;
    render("confirm", ["orderNo" => $no]);
});

// Contact page
$app->get("/contact", function() {
    render("contact");
});

// PUBLIC TESTIMONIALS
$app->get("/testimonials", function() use($baseUrl) {
    $approved = (new Testimonial())->get_approved();
    render("testimonials", [
      "testimonials" => $approved,
      "baseUrl"      => $baseUrl,
    ]);
});

// PUBLIC testimonial submission
$app->post("/testimonials", function() use($baseUrl) {
    $first_name = trim($_POST["first_name"] ?? "");
    $last_name = trim($_POST["last_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $content = trim($_POST["content"] ?? "");

    // Validate required fields
    if (!$first_name || !$last_name || !$email || !$content) {
        $_SESSION['testimonial_error'] = "Please fill in all required fields.";
        header("Location: {$baseUrl}/testimonials");
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['testimonial_error'] = "Please enter a valid email address.";
        header("Location: {$baseUrl}/testimonials");
        exit;
    }

    // Check if customer exists, if not create
    $C = new Customer();
    if (!$C->find_by_email($email)) {
        $C->create([
            "email"      => $email,
            "first_name" => $first_name,
            "last_name"  => $last_name,
            "phone"      => "",
            "address"    => "",
            "state"      => "",
            "postcode"   => "",
        ]);
    }

    // Create testimonial
    (new Testimonial())->create($email, $content);

    header("Location: {$baseUrl}/testimonials?submitted=1");
    exit;
});

// ADMIN TESTIMONIALS
$app->get("/admin/testimonials", function() use($baseUrl) {
    requireAdmin();
    
    $pending = (new Testimonial())->get_pending();
    $approved = (new Testimonial())->get_approved();
    
    render("admin_testimonials", [
      "pending" => $pending,
      "approved" => $approved,
      "baseUrl" => $baseUrl,
    ]);
});

// approve action
$app->post("/admin/testimonials/approve/:id", function($app) use($baseUrl) {
    requireAdmin();
    $id = (int)$app->route_var("id");
    (new Testimonial())->approve($id);
    header("Location: {$baseUrl}/admin/testimonials");
    exit;
});

// reject action
$app->post("/admin/testimonials/reject/:id", function($app) use($baseUrl) {
    requireAdmin();
    $id = (int)$app->route_var("id");
    (new Testimonial())->reject($id);
    header("Location: {$baseUrl}/admin/testimonials");
    exit;
});

// ADMIN NEWS MANAGEMENT
$app->get("/admin/news", function() use($baseUrl) {
    requireAdmin();
    
    $newsModel = new News();
    $news = $newsModel->get_all();
    
    render("admin_news", [
        "news" => $news,
        "baseUrl" => $baseUrl,
    ]);
});

// Add news form
$app->get("/admin/news/add", function() use($baseUrl) {
    requireAdmin();
    
    render("admin_news_form", [
        "news" => null,
        "isEdit" => false,
        "baseUrl" => $baseUrl,
    ]);
});

// Process new news
$app->post("/admin/news/add", function() use($baseUrl) {
    requireAdmin();
    
    $title = trim($_POST["title"] ?? "");
    $message = trim($_POST["message"] ?? "");
    $isActive = isset($_POST["is_active"]);
    
    // Validate
    if (!$title || !$message) {
        $_SESSION['news_error'] = "Please fill in all required fields.";
        header("Location: {$baseUrl}/admin/news/add");
        exit;
    }
    
    if (strlen($title) > 200) {
        $_SESSION['news_error'] = "Title must be 200 characters or less.";
        header("Location: {$baseUrl}/admin/news/add");
        exit;
    }
    
    $newsModel = new News();
    if ($newsModel->create($title, $message, $isActive)) {
        $_SESSION['news_message'] = "News item created successfully!";
        header("Location: {$baseUrl}/admin/news");
    } else {
        $_SESSION['news_error'] = "Failed to create news item. Please try again.";
        header("Location: {$baseUrl}/admin/news/add");
    }
    exit;
});

// Edit news form
$app->get("/admin/news/edit/:id", function($app) use($baseUrl) {
    requireAdmin();
    
    $id = (int)$app->route_var("id");
    $newsModel = new News();
    $news = $newsModel->get_by_id($id);
    
    if (!$news) {
        $_SESSION['news_error'] = "News item not found.";
        header("Location: {$baseUrl}/admin/news");
        exit;
    }
    
    render("admin_news_form", [
        "news" => $news,
        "isEdit" => true,
        "baseUrl" => $baseUrl,
    ]);
});

// Process news update
$app->post("/admin/news/edit/:id", function($app) use($baseUrl) {
    requireAdmin();
    
    $id = (int)$app->route_var("id");
    $title = trim($_POST["title"] ?? "");
    $message = trim($_POST["message"] ?? "");
    $isActive = isset($_POST["is_active"]);
    
    // Validate
    if (!$title || !$message) {
        $_SESSION['news_error'] = "Please fill in all required fields.";
        header("Location: {$baseUrl}/admin/news/edit/{$id}");
        exit;
    }
    
    if (strlen($title) > 200) {
        $_SESSION['news_error'] = "Title must be 200 characters or less.";
        header("Location: {$baseUrl}/admin/news/edit/{$id}");
        exit;
    }
    
    $newsModel = new News();
    if ($newsModel->update($id, $title, $message, $isActive)) {
        $_SESSION['news_message'] = "News item updated successfully!";
        header("Location: {$baseUrl}/admin/news");
    } else {
        $_SESSION['news_error'] = "Failed to update news item. Please try again.";
        header("Location: {$baseUrl}/admin/news/edit/{$id}");
    }
    exit;
});

// Toggle news active status
$app->post("/admin/news/toggle/:id", function($app) use($baseUrl) {
    requireAdmin();
    
    $id = (int)$app->route_var("id");
    $newsModel = new News();
    
    if ($newsModel->toggle_active($id)) {
        $_SESSION['news_message'] = "News status updated successfully!";
    } else {
        $_SESSION['news_error'] = "Failed to update news status.";
    }
    
    header("Location: {$baseUrl}/admin/news");
    exit;
});

// Delete news
$app->post("/admin/news/delete/:id", function($app) use($baseUrl) {
    requireAdmin();
    
    $id = (int)$app->route_var("id");
    $newsModel = new News();
    
    if ($newsModel->delete($id)) {
        $_SESSION['news_message'] = "News item deleted successfully!";
    } else {
        $_SESSION['news_error'] = "Failed to delete news item.";
    }
    
    header("Location: {$baseUrl}/admin/news");
    exit;
});

$app->run();
?>