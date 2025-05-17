<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

require_once '../database/db_connect.php';

// Get subject name from URL
$subject_name = basename($_SERVER['PHP_SELF'], '.php');
$subject_name = ucfirst($subject_name); // Capitalize first letter

// Get subject details from database
$stmt = $conn->prepare("SELECT * FROM subjects WHERE name = ?");
$stmt->bind_param("s", $subject_name);
$stmt->execute();
$result = $stmt->get_result();
$subject = $result->fetch_assoc();

if (!$subject) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($subject_name); ?> - EduPlatform</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .announcement-card {
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }
        .pdf-card {
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        .quiz-card {
            margin-bottom: 20px;
            border-left: 4px solid #ffc107;
        }
        .unread {
            background-color: #f8f9fa;
        }
        .subject-header {
            background-color: #f8f9fa;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success fixed-top">
        <a class="navbar-brand" href="dashboard.php">EduPlatform</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="dashboard.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="contacts.php">Contacts</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container" style="margin-top: 80px;">
        <div class="subject-header">
            <h1 class="text-center"><?php echo htmlspecialchars($subject_name); ?></h1>
            <p class="text-center text-muted"><?php echo htmlspecialchars($subject['description']); ?></p>
        </div>

        <div class="row">
            <!-- Announcements Section -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-bullhorn mr-2"></i>Announcements</h5>
                    </div>
                    <div class="card-body" id="announcements-container">
                        <div class="text-center">
                            <div class="spinner-border text-success" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PDF Files Section -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-file-pdf mr-2"></i>Learning Materials</h5>
                    </div>
                    <div class="card-body" id="pdf-files-container">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quizzes Section -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-question-circle mr-2"></i>Quizzes</h5>
                    </div>
                    <div class="card-body" id="quizzes-container">
                        <div class="text-center">
                            <div class="spinner-border text-warning" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Function to load announcements
        function loadAnnouncements() {
            fetch('get_announcements.php?subject=<?php echo urlencode($subject_name); ?>')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('announcements-container');
                    if (data.length === 0) {
                        container.innerHTML = '<p class="text-muted text-center">No announcements yet.</p>';
                        return;
                    }
                    
                    let html = '';
                    data.forEach(announcement => {
                        const unreadClass = announcement.is_read ? '' : 'unread';
                        html += `
                            <div class="card announcement-card ${unreadClass} mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">${announcement.title}</h6>
                                    <p class="card-text">${announcement.content}</p>
                                    <small class="text-muted">Posted on ${announcement.created_at}</small>
                                </div>
                            </div>
                        `;
                    });
                    container.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading announcements:', error);
                    document.getElementById('announcements-container').innerHTML = 
                        '<p class="text-danger text-center">Error loading announcements.</p>';
                });
        }

        // Function to load PDF files
        function loadPDFFiles() {
            fetch('get_pdf_files.php?subject=<?php echo urlencode($subject_name); ?>')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('pdf-files-container');
                    if (data.length === 0) {
                        container.innerHTML = '<p class="text-muted text-center">No PDF files available.</p>';
                        return;
                    }
                    
                    let html = '';
                    data.forEach(pdf => {
                        html += `
                            <div class="card pdf-card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">${pdf.title}</h6>
                                    <p class="card-text">${pdf.description}</p>
                                    <a href="${pdf.filepath}" class="btn btn-primary btn-sm" target="_blank">
                                        <i class="fas fa-download mr-1"></i>Download
                                    </a>
                                </div>
                            </div>
                        `;
                    });
                    container.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading PDF files:', error);
                    document.getElementById('pdf-files-container').innerHTML = 
                        '<p class="text-danger text-center">Error loading PDF files.</p>';
                });
        }

        // Function to load quizzes
        function loadQuizzes() {
            fetch('get_quizzes.php?subject=<?php echo urlencode($subject_name); ?>')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('quizzes-container');
                    if (data.length === 0) {
                        container.innerHTML = '<p class="text-muted text-center">No quizzes available.</p>';
                        return;
                    }
                    
                    let html = '';
                    data.forEach(quiz => {
                        html += `
                            <div class="card quiz-card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">${quiz.title}</h6>
                                    <p class="card-text">${quiz.description}</p>
                                    <a href="quiz.php?quiz_type=${quiz.type}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-play mr-1"></i>Start Quiz
                                    </a>
                                </div>
                            </div>
                        `;
                    });
                    container.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading quizzes:', error);
                    document.getElementById('quizzes-container').innerHTML = 
                        '<p class="text-danger text-center">Error loading quizzes.</p>';
                });
        }

        // Load all content when page loads
        document.addEventListener('DOMContentLoaded', function() {
            loadAnnouncements();
            loadPDFFiles();
            loadQuizzes();
        });
    </script>
</body>
</html> 