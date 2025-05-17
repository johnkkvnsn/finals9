<?php
session_start();
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true || $_SESSION["role"] !== "admin") {
    header("Location: ../pages/login.php");
    exit;
}

require_once '../database/db_connect.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'create') {
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $subject = trim($_POST['subject']);

            if (empty($title) || empty($content)) {
                $error_message = "Title and content are required.";
            } else {
                $stmt = $conn->prepare("INSERT INTO announcements (title, content, subject) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $title, $content, $subject);
                
                if ($stmt->execute()) {
                    $success_message = "Announcement created successfully!";
                } else {
                    $error_message = "Error creating announcement: " . $conn->error;
                }
                $stmt->close();
            }
        } elseif ($_POST['action'] == 'delete' && isset($_POST['id'])) {
            $stmt = $conn->prepare("DELETE FROM announcements WHERE id = ?");
            $stmt->bind_param("i", $_POST['id']);
            
            if ($stmt->execute()) {
                $success_message = "Announcement deleted successfully!";
            } else {
                $error_message = "Error deleting announcement: " . $conn->error;
            }
            $stmt->close();
        }
    }
}

// Get all announcements
$announcements = [];
$result = $conn->query("SELECT * FROM announcements ORDER BY created_at DESC");
while ($row = $result->fetch_assoc()) {
    $announcements[] = $row;
}

// Get subjects for dropdown
$subjects = ['Mathematics', 'Science', 'English'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Announcements - Admin Dashboard</title>
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
        .announcement-form {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 30px;
        }
        .announcement-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            padding: 20px;
        }
        .announcement-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .announcement-title {
            font-size: 1.2em;
            font-weight: bold;
            color: #2c3e50;
        }
        .announcement-meta {
            color: #6c757d;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        .announcement-content {
            color: #2c3e50;
            margin-bottom: 10px;
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
                    <a href="rankings.php"><i class="fas fa-trophy"></i> Rankings</a>
                    <a href="announcements.php" class="active"><i class="fas fa-bullhorn"></i> Announcements</a>
                    <a href="upload.php"><i class="fas fa-file-upload"></i> Upload PDF</a>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content">
                <div class="page-header">
                    <h2><i class="fas fa-bullhorn"></i> Manage Announcements</h2>
                </div>

                <?php if (isset($success_message)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($success_message); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($error_message); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Create Announcement Form -->
                <div class="announcement-form">
                    <h3 class="mb-4">Create New Announcement</h3>
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="create">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <select class="form-control" id="subject" name="subject">
                                <option value="">General</option>
                                <?php foreach ($subjects as $subject): ?>
                                    <option value="<?php echo htmlspecialchars($subject); ?>">
                                        <?php echo htmlspecialchars($subject); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Announcement</button>
                    </form>
                </div>

                <!-- List of Announcements -->
                <div class="announcements-list">
                    <h3 class="mb-4">All Announcements</h3>
                    <?php if (empty($announcements)): ?>
                        <div class="alert alert-info">No announcements yet.</div>
                    <?php else: ?>
                        <?php foreach ($announcements as $announcement): ?>
                            <div class="announcement-card">
                                <div class="announcement-header">
                                    <div class="announcement-title">
                                        <?php echo htmlspecialchars($announcement['title']); ?>
                                    </div>
                                    <form method="POST" action="" style="display: inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $announcement['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Are you sure you want to delete this announcement?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="announcement-meta">
                                    <span><i class="fas fa-clock"></i> <?php echo date('F j, Y g:i a', strtotime($announcement['created_at'])); ?></span>
                                    <?php if ($announcement['subject']): ?>
                                        <span class="ml-3"><i class="fas fa-book"></i> <?php echo htmlspecialchars($announcement['subject']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="announcement-content">
                                    <?php echo nl2br(htmlspecialchars($announcement['content'])); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 