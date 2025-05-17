<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - EduPlatform</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            padding-top: 80px;
            background-color: #f8f9fa;
            color: #333;
        }
        .contact-section {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        .contact-section:hover {
            transform: translateY(-5px);
        }
        .contact-info {
            padding: 30px;
            background: linear-gradient(145deg, #28a745, #218838);
            border-radius: 15px;
            color: white;
            height: 100%;
        }
        .contact-info i {
            color: #fff;
            font-size: 28px;
            margin-right: 15px;
            width: 40px;
            text-align: center;
        }
        .contact-info p {
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }
        .contact-info a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }
        .contact-info a:hover {
            opacity: 0.8;
            text-decoration: none;
            color: white;
        }
        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.1);
            color: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            font-size: 20px;
        }
        .social-links a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-5px);
        }
        .form-control {
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
        }
        .btn-success {
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        .page-title {
            font-weight: 700;
            color: #1a5928;
            margin-bottom: 0.5rem;
        }
        .page-description {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }
        label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        select.form-control {
            height: 50px;
        }
        #successMessage {
            border-radius: 10px;
            padding: 15px;
            border: none;
            background-color: #d4edda;
            border-left: 5px solid #28a745;
        }
        .contact-info-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }
        .contact-form-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a5928;
            margin-bottom: 2rem;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease forwards;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
        <a class="navbar-brand" href="dashboard.php">EduPlatform</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="contacts.php">Contacts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="text-center page-title animate-fadeInUp">Contact Us</h1>
                <p class="text-center page-description animate-fadeInUp">Have questions about our educational platform? We're here to help!</p>

                <div class="row">
                    <!-- Contact Information -->
                    <div class="col-lg-4 mb-4">
                        <div class="contact-info animate-fadeInUp">
                            <h4 class="contact-info-title">Get in Touch</h4>
                            
                            <p>
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:educationsite@gmail.com">educationsite@gmail.com</a>
                            </p>
                            
                            <p>
                                <i class="fas fa-phone"></i>
                                +63 912 345 6789
                            </p>
                            
                            <p>
                                <i class="fas fa-map-marker-alt"></i>
                                123 Education Street, Manila, Philippines
                            </p>

                            <h5 class="text-center mt-5 mb-4">Follow Us</h5>
                            <div class="social-links">
                                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                                <a href="#" target="_blank"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-lg-8 mb-4">
                        <div class="contact-section animate-fadeInUp">
                            <h4 class="contact-form-title">Send us a Message</h4>
                            <form id="contactForm">
                                <div class="form-group">
                                    <label for="name">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label for="message">Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>

                                <button type="submit" class="btn btn-success btn-block">Send Message</button>
                            </form>

                            <!-- Success Message -->
                            <div class="alert alert-success mt-4" id="successMessage" style="display: none;">
                                Thank you for your message! We'll get back to you soon.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();
                
                // Disable submit button to prevent double submission
                const submitButton = $(this).find('button[type="submit"]');
                submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sending...');
                
                // Get form data
                const formData = new FormData(this);
                
                // Send form data to server
                fetch('send_email.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#successMessage')
                            .removeClass('alert-danger')
                            .addClass('alert-success')
                            .html(data.message)
                            .fadeIn();
                        this.reset();
                    } else {
                        $('#successMessage')
                            .removeClass('alert-success')
                            .addClass('alert-danger')
                            .html(data.message)
                            .fadeIn();
                    }
                })
                .catch(error => {
                    $('#successMessage')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .html('An error occurred. Please try again later.')
                        .fadeIn();
                })
                .finally(() => {
                    // Re-enable submit button
                    submitButton.prop('disabled', false).html('Send Message');
                    
                    // Hide message after 5 seconds
                    setTimeout(function() {
                        $('#successMessage').fadeOut();
                    }, 5000);
                });
            });
        });
    </script>
</body>
</html>
