<?php
return [
    // SMTP Configuration
    'smtp_host' => 'smtp.gmail.com',          // Gmail: smtp.gmail.com, Outlook: smtp-mail.outlook.com
    'smtp_port' => 587,                       // Usually 587 for TLS
    'smtp_secure' => 'tls',                   // 'tls' or 'ssl'
    'smtp_auth' => true,                      // Enable SMTP authentication
    
    // Email Credentials
    'smtp_username' => 'kencmllop61@gmail.com',     // Replace with your email address
    'smtp_password' => 'sypbwzrlwbbdfxhu',          // Replace with your 16-character app password, ensure no spacing
    
    // Default From Settings
    'from_email' => 'kencmllop61@gmail.com',       // From email address
    'from_name' => 'Darwin Art Store',            // From name
    
    // Email Settings
    'is_html' => true,                            // Send HTML emails
    'charset' => 'UTF-8',                         // Character set
    
    // Debug Settings (set to 0 in production)
    'smtp_debug' => 0,                            // 0 = off, 1 = client messages, 2 = client and server messages
];

// For Gmail:
// - Use your full email address as username
// - If regular password doesn't work, create an App Password:
//   1. Go to https://myaccount.google.com/security
//   2. Enable 2-Step Verification
//   3. Generate an App Password for "Mail"
//   4. Use that 16-character password here

// For Outlook/Hotmail:
// - Change smtp_host to 'smtp-mail.outlook.com'
// - Use your regular Outlook password