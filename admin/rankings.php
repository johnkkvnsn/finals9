<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true || $_SESSION["role"] !== "admin") {
    header("Location: ../pages/login.php");
    exit;
}

require_once '../database/db_connect.php';

// First, get all available subjects
$subjects_query = "SELECT DISTINCT subject FROM quiz_scores WHERE subject IS NOT NULL ORDER BY subject";
$subjects_result = $conn->query($subjects_query);
$subjects = [];
while ($row = $subjects_result->fetch_assoc()) {
    $subjects[] = $row['subject'];
}

// If no subjects found, add default subjects
if (empty($subjects)) {
    $subjects = ['Mathematics', 'Science', 'English'];
}

// Get student rankings based on quiz scores, grouped by subject    
$rankings = [];
foreach ($subjects as $subject) {
    $query = "
        SELECT 
            u.username,
            u.email,
            COUNT(qs.id) as quizzes_taken,
            SUM(qs.score) as total_correct_answers,
            SUM(qs.total_questions) as total_quiz_items,
            ROUND((SUM(qs.score) / SUM(qs.total_questions)) * 100, 2) as average_score,
            '$subject' as subject
        FROM users u
        LEFT JOIN quiz_scores qs ON u.username = qs.username AND qs.subject = ?
        WHERE u.role = 'student'
        GROUP BY u.username, u.email
        HAVING quizzes_taken > 0
        ORDER BY average_score DESC, total_correct_answers DESC
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $subject);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $rankings[$subject] = [];
    while ($row = $result->fetch_assoc()) {
        $rankings[$subject][] = $row;
    }
}

// Debug information
echo "<!-- Available subjects: " . implode(", ", $subjects) . " -->";
foreach ($subjects as $subject) {
    echo "<!-- $subject rankings count: " . count($rankings[$subject]) . " -->";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Rankings by Subject - Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .sidebar .active {
            background: #007bff;
        }
        .main-content {
            padding: 20px;
        }
        .page-header {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .page-header h2 {
            color: #2c3e50;
            margin-bottom: 0;
        }
        .rankings-table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .table thead th {
            border-top: none;
            border-bottom: 2px solid #dee2e6;
            color: #2c3e50;
            font-weight: 600;
        }
        .table td {
            vertical-align: middle;
        }
        .rank-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #007bff;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .top-3 {
            font-size: 1.2em;
            font-weight: bold;
        }
        .rank-1 .rank-number {
            background: #ffd700;
        }
        .rank-2 .rank-number {
            background: #c0c0c0;
        }
        .rank-3 .rank-number {
            background: #cd7f32;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .search-box input {
            border-radius: 20px;
            padding-left: 20px;
            border: 1px solid #dee2e6;
        }
        .search-box input:focus {
            box-shadow: none;
            border-color: #007bff;
        }
        .subject-header {
            background: #2c3e50;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .subject-header h3 {
            margin: 0;
            font-size: 1.5em;
        }
        .subject-icon {
            font-size: 1.8em;
            margin-right: 10px;
        }
        .subject-section {
            margin-bottom: 40px;
        }
        .nav-pills {
            margin-bottom: 20px;
        }
        .nav-pills .nav-link {
            color: #2c3e50;
            border-radius: 20px;
            padding: 10px 20px;
            margin: 0 5px;
        }
        .nav-pills .nav-link.active {
            background-color: #2c3e50;
            color: white;
        }
        .tab-content {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <h3 class="text-center mb-4">Admin Panel</h3>
                <nav>
                    <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="users.php"><i class="fas fa-users"></i> Users</a>
                    <a href="rankings.php" class="active"><i class="fas fa-trophy"></i> Rankings</a>
                    <a href="announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a>
                    <a href="upload.php"><i class="fas fa-file-upload"></i> Upload PDF</a>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="page-header">
                    <h2><i class="fas fa-trophy"></i> Student Rankings by Subject</h2>
                </div>

                <!-- Subject Navigation -->
                <ul class="nav nav-pills" id="subjectTabs" role="tablist">
                    <?php foreach ($subjects as $index => $subject): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" 
                           id="<?php echo strtolower($subject); ?>-tab" 
                           data-toggle="pill" 
                           href="#<?php echo strtolower($subject); ?>" 
                           role="tab">
                            <?php echo htmlspecialchars($subject); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Subject Content -->
                <div class="tab-content" id="subjectTabContent">
                    <?php foreach ($subjects as $index => $subject): ?>
                    <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>" 
                         id="<?php echo strtolower($subject); ?>" 
                         role="tabpanel">
                        
                        <div class="subject-header">
                            <h3>
                                <i class="fas <?php 
                                    echo $subject === 'Mathematics' ? 'fa-calculator' : 
                                        ($subject === 'Science' ? 'fa-flask' : 
                                        ($subject === 'English' ? 'fa-book' : 'fa-graduation-cap')); 
                                ?> subject-icon"></i>
                                <?php echo htmlspecialchars($subject); ?> Rankings
                            </h3>
                        </div>

                        <div class="rankings-table">
                            <!-- Search Box -->
                            <div class="row search-box">
                                <div class="col-md-6">
                                    <input type="text" class="form-control search-input" 
                                           placeholder="Search students in <?php echo htmlspecialchars($subject); ?>...">
                                </div>
                            </div>

                            <!-- Rankings Table -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>Student</th>
                                            <th>Quizzes Taken</th>
                                            <th>Average Score</th>
                                            <th>Total Correct Answers</th>
                                            <th>Total Quiz Items</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $rank = 1;
                                        foreach ($rankings[$subject] as $student): 
                                            $rankClass = $rank <= 3 ? "rank-{$rank} top-3" : "";
                                        ?>
                                            <tr class="<?php echo $rankClass; ?>">
                                                <td>
                                                    <div class="rank-number">
                                                        <?php echo $rank; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold"><?php echo htmlspecialchars($student['username']); ?></div>
                                                    <div class="text-muted small"><?php echo htmlspecialchars($student['email']); ?></div>
                                                </td>
                                                <td><?php echo $student['quizzes_taken']; ?></td>
                                                <td><?php echo $student['average_score']; ?>%</td>
                                                <td><?php echo $student['total_correct_answers']; ?></td>
                                                <td><?php echo $student['total_quiz_items']; ?></td>
                                            </tr>
                                        <?php 
                                            $rank++;
                                        endforeach; 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Search functionality for each subject tab
        document.querySelectorAll('.search-input').forEach(input => {
            input.addEventListener('keyup', function() {
                const searchText = this.value.toLowerCase();
                const tableBody = this.closest('.rankings-table').querySelector('tbody');
                const rows = tableBody.querySelectorAll('tr');
                
                rows.forEach(row => {
                    const username = row.querySelector('.font-weight-bold').textContent.toLowerCase();
                    const email = row.querySelector('.text-muted').textContent.toLowerCase();
                    
                    if (username.includes(searchText) || email.includes(searchText)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html> 