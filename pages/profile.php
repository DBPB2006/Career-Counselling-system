<?php
include '../includes/auth_check.php';
include '../includes/connect.php';

// Initialize variables with default values
$name = "User";
$userEmail = "user@example.com";
$user_grade = "Grade not set";
$profile_picture = null;
$user_about = "No description available.";
$user_location = "Location not set";
$joined_at = date("Y-m-d");
$tests_taken = 0;
$average_score = 0.0;
$user_results = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT username, email, grade, about, location, joined_at FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = htmlspecialchars($row['username']);
        $userEmail = htmlspecialchars($row['email']);
        $user_grade = htmlspecialchars($row['grade'] ?? "Grade not set");
        $user_about = htmlspecialchars($row['about'] ?? "No description available.");
        $user_location = htmlspecialchars($row['location'] ?? "Location not set");
        if (!empty($row['joined_at'])) {
            $joined_at = date("Y-m-d", strtotime($row['joined_at']));
        }
    }
    $stmt->close();
    
    // Fetch test statistics
    $stat_sql = "SELECT COUNT(*) as total_tests, AVG(score) as avg_score FROM user_results WHERE user_id = ?";
    $stat_stmt = $conn->prepare($stat_sql);
    $stat_stmt->bind_param("i", $user_id);
    $stat_stmt->execute();
    $stat_res = $stat_stmt->get_result();
    if ($stat_row = $stat_res->fetch_assoc()) {
        $tests_taken = $stat_row['total_tests'] ?? 0;
        $average_score = number_format($stat_row['avg_score'] ?? 0, 1);
    }
    $stat_stmt->close();
    
    // Fetch recent test results
    $recent_sql = "SELECT test_name, score, taken_at FROM user_results WHERE user_id = ? ORDER BY taken_at DESC LIMIT 3";
    $recent_stmt = $conn->prepare($recent_sql);
    $recent_stmt->bind_param("i", $user_id);
    $recent_stmt->execute();
    $recent_res = $recent_stmt->get_result();
    while ($r = $recent_res->fetch_assoc()) {
        $user_results[] = $r;
    }
    $recent_stmt->close();
} else {
    die("Please log in first.");
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Profile</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="../output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#F2EFE7]">
    <header class="bg-[#006A71] py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="../assets/images/realogo.png" class="w-10 h-10 rounded-full">
                <span class="text-[#F2EFE7] text-xl font-bold tracking-wide">CopeUp</span>
            </div>
            <nav class="hidden md:flex space-x-6 text-[#F2EFE7] text-sm font-medium">
                <a href="../home.php" class="flex items-center gap-2 hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="grade.php" class="flex items-center gap-2 hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">
                    <i class="fas fa-search"></i>
                    <span>Explore Careers</span>
                </a>
                <a href="#about" class="flex items-center gap-2 hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">
                    <i class="fas fa-info-circle"></i>
                    <span>About</span>
                </a>
                <a href="#contact" class="flex items-center gap-2 hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">
                    <i class="fas fa-envelope"></i>
                    <span>Contact</span>
                </a>
            </nav>
            <div class="relative group" aria-label="User profile dropdown">
                <button class="text-[#F2EFE7] border border-[#F2EFE7] px-4 py-2 rounded hover:bg-[#9ACBD0] hover:text-black transition flex items-center gap-2" ondblclick="openProfilePage()">
                    <i class="fas fa-user"></i>
                    <p>Profile</p>
                </button>
                <div class="absolute right-0 mt-2 w-64 bg-[#F2EFE7] text-black rounded-lg shadow-lg opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-opacity duration-200 z-50">
                    <div class="p-4 border-b">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-[#48A6A7] text-white rounded-full flex items-center justify-center text-lg font-semibold">
                                <?php echo strtoupper($name[0]); ?>
                            </div>
                            <div>
                                <p class="font-medium"><?php echo $name; ?></p>
                                <p class="text-sm text-gray-500"><?php echo $userEmail; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <a href="../includes/logout.php" class="block text-center bg-[#48A6A7] hover:bg-[#9ACBD0] text-black font-semibold px-4 py-2 rounded transition">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="profile" class="mt-8 w-1300px">
        <div class="w-full rounded-xl shadow-lg">
            <div class="relative">
                <div class="h-[200px] w-full bg-gradient-to-r from-[#48A6A7] to-[#006A71] rounded-t-xl"></div>
                <div class="absolute bottom-0 left-10 transform translate-y-1/2">
                    <div class="relative group">
                        <?php if ($profile_picture): ?>
                            <div class="w-[150px] h-[150px] rounded-full border-4 border-white bg-blue-200 overflow-hidden shadow-lg group-hover:shadow-xl transition-all duration-300">
                                <img src="<?php echo $profile_picture; ?>" alt="Profile" class="w-full h-full object-cover" />
                            </div>
                        <?php else: ?>
                            <div class="w-[150px] h-[150px] rounded-full bg-[#48A6A7] flex items-center justify-center text-white font-bold text-3xl shadow-lg">
                                <?php echo strtoupper(substr($name, 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="mt-[75px] px-10 py-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold"><?php echo htmlspecialchars($name); ?></h1>
                        <p class="text-neutral-500 mt-1"><?php echo htmlspecialchars($user_grade); ?> Student</p>
                        <div class="flex items-center gap-3 mt-3">
                            <div class="flex items-center gap-1 text-neutral-600">
                                <i class="fas fa-map-marker-alt text-[#48A6A7]"></i>
                                <span><?php echo htmlspecialchars($user_location); ?></span>
                            </div>
                            <div class="flex items-center gap-1 text-neutral-600">
                                <i class="fas fa-envelope text-[#48A6A7]"></i>
                                <span><?php echo htmlspecialchars($userEmail); ?></span>
                            </div>
                            <div class="flex items-center gap-1 text-neutral-600">
                                <i class="fas fa-calendar text-[#48A6A7]"></i>
                                <span>Joined <?php echo htmlspecialchars($joined_at); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center p-3 rounded-lg hover:bg-neutral-50 transition-colors cursor-pointer">
                            <span class="text-xl font-bold text-[#48A6A7]"><?php echo $tests_taken; ?></span>
                            <span class="text-sm text-neutral-500">Tests</span>
                        </div>
                        <div class="flex flex-col items-center p-3 rounded-lg hover:bg-neutral-50 transition-colors cursor-pointer">
                            <span class="text-xl font-bold text-[#48A6A7]">0</span>
                            <span class="text-sm text-neutral-500">Certificates</span>
                        </div>
                        <div class="flex flex-col items-center p-3 rounded-lg hover:bg-neutral-50 transition-colors cursor-pointer">
                            <span class="text-xl font-bold text-[#48A6A7]"><?php echo $average_score; ?></span>
                            <span class="text-sm text-neutral-500">Avg Score</span>
                        </div>
                    </div>
                </div>
                <div class="mt-8 border-b border-neutral-200">
                    <div class="flex space-x-6">
                        <button class="px-4 py-2 text-[#48A6A7] border-b-2 border-[#48A6A7] font-medium">Overview</button>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-6 mt-8">
                    <div class="col-span-2 space-y-6">
                        <div class="bg-white border border-neutral-200 rounded-xl p-6 hover:shadow-md transition-shadow">
                            <h2 class="text-lg font-semibold mb-4">About Me</h2>
                            <p class="text-neutral-600 leading-relaxed">
                                <?php echo htmlspecialchars($user_about); ?>
                            </p>
                        </div>
                        <div class="bg-white border border-neutral-200 rounded-xl p-6 hover:shadow-md transition-shadow">
                            <h2 class="text-lg font-semibold mb-4">Recent Activity</h2>
                            <div class="space-y-4">
                                <?php if (empty($user_results)): ?>
                                    <p class="text-sm text-neutral-500">No recent activity found.</p>
                                <?php else: ?>
                                    <?php foreach ($user_results as $result): ?>
                                    <div class="flex gap-4 p-3 hover:bg-neutral-50 rounded-lg transition-colors">
                                        <div class="w-10 h-10 bg-[#9ACBD0] text-white rounded-full flex items-center justify-center">
                                            <i class="fas fa-clipboard-check"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium">Completed "<?php echo htmlspecialchars($result['test_name'] ?? 'Test'); ?>"</p>
                                            <p class="text-sm text-neutral-500">Score: <?php echo htmlspecialchars($result['score'] ?? 0); ?> • <?php 
                                                $taken = strtotime($result['taken_at']);
                                                echo date("M j, Y", $taken);
                                            ?></p>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-4">
            <a href="../includes/logout.php" class="block text-center bg-[#48A6A7] hover:bg-[#9ACBD0] text-black font-semibold px-4 py-2 rounded transition">
                Logout
            </a>
        </div>
    </div>
</body>
</html>
