<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - EduPlatform</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            padding-top: 80px;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }
        .about-section {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }
        .about-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, #28a745, #20c997);
        }
        .feature-card {
            border-left: 4px solid #28a745;
            padding: 25px;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .section-title {
            color: #1a5928;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
        }
        .section-title::after {
            content: '';
            display: block;
            width: 50%;
            height: 3px;
            background: #28a745;
            margin: 10px auto 0;
        }
        .lead {
            font-size: 1.25rem;
            font-weight: 300;
            line-height: 1.8;
            color: #495057;
        }
        .icon-circle {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #28a745, #20c997);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }
        .icon-circle i {
            color: white;
            font-size: 1.5rem;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .container {
            max-width: 1000px;
        }
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .gradient-text {
            background: linear-gradient(45deg, #28a745, #20c997);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: gradientBG 3s ease infinite;
            background-size: 200% 200%;
        }
        .message-box {
            background: linear-gradient(145deg, #f8f9fa, #ffffff);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        .team-info {
            text-align: left;
            padding: 10px;
        }
        .team-info h5 {
            color: #1a5928;
            text-align: center;
            font-weight: 600;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }
        .team-member {
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .team-member:hover {
            background: rgba(40, 167, 69, 0.05);
            transform: translateX(10px);
        }
        .team-member strong {
            color: #28a745;
            font-size: 1.1rem;
        }
        .team-member small {
            display: block;
            color: #666;
            margin-top: 5px;
            padding-left: 20px;
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
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Home</a></li>
                <li class="nav-item active"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="contacts.php">Contacts</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Project Introduction -->
        <div class="about-section" data-aos="fade-up">
            <h1 class="text-center mb-4 gradient-text">About Our Project</h1>
            <div class="row mb-5">
                <div class="col-md-8 mx-auto">
                    <div class="icon-circle mx-auto">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <p class="lead text-center">
                        This educational website was developed as part of a school project to help students learn and practice different academic subjects in a fun and interactive way.
                    </p>
                </div>
            </div>
        </div>

        <!-- Purpose and Goals -->
        <div class="about-section" data-aos="fade-up">
            <h2 class="text-center mb-4 section-title">Purpose and Goals</h2>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="feature-card">
                        <div class="icon-circle mx-auto">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <p>The main goal is to provide accessible learning materials and quizzes for students in subjects like Math, Science, and English.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Target Audience -->
        <div class="about-section" data-aos="fade-up">
            <h2 class="text-center mb-4 section-title">Target Audience</h2>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="feature-card">
                        <div class="icon-circle mx-auto">
                            <i class="fas fa-users"></i>
                        </div>
                        <p>This site is designed for elementary students looking to improve their understanding of key academic topics.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Creators / Team Information -->
        <div class="about-section" data-aos="fade-up">
            <h2 class="text-center mb-4 section-title">Creators / Team Information</h2>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="feature-card">
                        <div class="icon-circle mx-auto">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="team-info">
                            <h5 class="mb-4">Bachelor of Science Information Technology 2-A<br>Laguna State Polytechnic University</h5>
                            
                            <div class="team-member mb-3">
                                <strong>John Lloyd E. Apao</strong> – Web Developer<br>
                                <small>Responsible for organizing the project, designing the website layout, and coding the main features.</small>
                            </div>
                            
                            <div class="team-member mb-3">
                                <strong>Justin D. Duca</strong> – Content Writer / Researcher<br>
                                <small>Created and organized educational content for subjects like Math, English, and Science.</small>
                            </div>
                            
                            <div class="team-member mb-3">
                                <strong>Nicole D. Bautista</strong> – Quiz & Assessment Designer<br>
                                <small>Designed quizzes and exercises to test users' knowledge and support learning.</small>
                            </div>
                            
                            <div class="team-member">
                                <strong>Justin Rain B. Bundalian</strong> – UI/UX Designer<br>
                                <small>Handled the visual design, color scheme, and ensured the site is user-friendly.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tools and Technologies -->
        <div class="about-section" data-aos="fade-up">
            <h2 class="text-center mb-4 section-title">Tools and Technologies Used</h2>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="feature-card">
                        <div class="icon-circle mx-auto">
                            <i class="fas fa-tools"></i>
                        </div>
                        <p>Built using HTML, CSS, JavaScript, PHP, and MySQL for a robust and dynamic educational platform with quiz management capabilities.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Future Plans -->
        <div class="about-section" data-aos="fade-up">
            <h2 class="text-center mb-4 section-title">Future Plans</h2>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="feature-card">
                        <div class="icon-circle mx-auto">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <p>In the future, we hope to add more subjects, interactive games, and progress tracking.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message to Users -->
        <div class="about-section" data-aos="fade-up">
            <h2 class="text-center mb-4 section-title">Message to Users</h2>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="message-box">
                        <div class="icon-circle mx-auto">
                            <i class="fas fa-heart"></i>
                        </div>
                        <p class="lead mb-0">We hope this website helps you in your studies. Thank you for visiting!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            offset: 100,
            once: true
        });
    </script>
</body>
</html>
