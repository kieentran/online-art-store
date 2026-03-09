// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {

    // Smooth scroll for anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add to cart button animation
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 100);
        });
    });
    
    // Form validation helper
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#f56565';
                } else {
                    field.style.borderColor = '';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });
    
    // Clear form field error on input
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.style.borderColor === 'rgb(245, 101, 101)') {
                this.style.borderColor = '';
            }
        });
    });
    
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.classList.toggle('active');
        });
    }
    
    // Auto-hide success messages after 5 seconds
    const successMessages = document.querySelectorAll('.success-message');
    successMessages.forEach(message => {
        setTimeout(() => {
            message.style.transition = 'opacity 0.5s';
            message.style.opacity = '0';
            setTimeout(() => {
                message.remove();
            }, 500);
        }, 5000);
    });
    
    // Print order functionality (for confirmation page)
    const printOrderButton = document.querySelector('.print-order');
    if (printOrderButton) {
        printOrderButton.addEventListener('click', function() {
            window.print();
        });
    }

    // Get the navigation element
    const nav = document.querySelector('nav');
    
    // Add scroll event listener for sticky nav
    if (nav) {
        window.addEventListener('scroll', function() {
            // Check if page has been scrolled
            if (window.scrollY > 10) {
                nav.classList.add('scrolled');
            } else {    
                nav.classList.remove('scrolled');
            }
        });
    }
    
    // News preview functionality (Admin news form)
    const titleInput = document.querySelector('input[name="title"]');
    const messageTextarea = document.querySelector('textarea[name="message"]');
    const previewTitle = document.getElementById('preview-title');
    const previewMessage = document.getElementById('preview-message');
    
    if (titleInput && previewTitle) {
        titleInput.addEventListener('input', function(e) {
            previewTitle.textContent = e.target.value || 'Your news title will appear here';
        });
    }
    
    if (messageTextarea && previewMessage) {
        messageTextarea.addEventListener('input', function(e) {
            previewMessage.innerHTML = e.target.value.replace(/\n/g, '<br>') || 'Your news message will appear here...';
        });
    }
});

// Utility function to format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-AU', {
        style: 'currency',
        currency: 'AUD'
    }).format(amount);
}

// Utility function to show temporary notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background: ${type === 'success' ? '#48bb78' : '#667eea'};
        color: white;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        z-index: 1000;
        animation: slideIn 0.3s ease-out;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Add CSS animations for notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);