<?php
session_start();
include 'connect.php';

$name = "User";
$userEmail = "user@example.com";

if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];
  $sqlq = $conn->prepare("SELECT username, email FROM users WHERE email = ?");
  $sqlq->bind_param("s", $email);
  $sqlq->execute();
  $result = $sqlq->get_result();
  if ($row = $result->fetch_assoc()) {
    $name = htmlspecialchars($row['username']);
    $userEmail = htmlspecialchars($row['email']);
  }
  $sqlq->close();
}

if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT username, email, grade FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_name = $row['username'];
    $user_email = $row['email'];
    $user_grade = $row['grade'] ?? "Grade not set";
    $profile_picture = $row['profile_picture'] ?? null;
} else {
    die("User not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Profile</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="./output.css" rel="stylesheet">
</head>

<body class="bg-[#F2EFE7]">
    
<body class="bg-[#F2EFE7]">
    
    <header class="bg-[#006A71] py-4">
      <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
        <div class="flex items-center space-x-2">
          <img src="realogo.png" class="w-10 h-10 rounded-full">
          <span class="text-[#F2EFE7] text-xl font-bold tracking-wide">CopeUp</span>
        </div>
        <nav class="hidden md:flex space-x-6 text-[#F2EFE7] text-sm font-medium">
          <a href="home.php" class="hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">Home</a>
          <a href="grade.php" class="hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">Explore Careers</a>
          <a href="#about" class="hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">About</a>
          <a href="#contact" class="hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">Contact</a>
        </nav>
        <div class="relative group" aria-label="User profile dropdown">
          <button
            class="text-[#F2EFE7] border border-[#F2EFE7] px-4 py-2 rounded hover:bg-[#9ACBD0] hover:text-black transition"
            ondblclick="openProfilePage()">
            <p>Profile</p>
          </button>
          <div
            class="absolute right-0 mt-2 w-64 bg-[#F2EFE7] text-black rounded-lg shadow-lg opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-opacity duration-200 z-50">
            <div class="p-4 border-b">
              <div class="flex items-center space-x-3">
                <div
                  class="w-12 h-12 bg-[#48A6A7] text-white rounded-full flex items-center justify-center text-lg font-semibold">
                  <?php echo strtoupper($name[0]); ?>
                </div>
                <div>
                  <p class="font-medium"><?php echo $name; ?></p>
                  <p class="text-sm text-gray-500"><?php echo $userEmail; ?></p>
                </div>
              </div>
            </div>
            <div class="p-4">
              <a href="logout.php"
                class="block text-center bg-[#48A6A7] hover:bg-[#9ACBD0] text-black font-semibold px-4 py-2 rounded transition">
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
                                <?php echo strtoupper(substr($user_name, 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="mt-[75px] px-10 py-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold"><?php echo htmlspecialchars($user_name); ?></h1>
                        <p class="text-neutral-500 mt-1">Computer Science Student </p>
                        <div class="flex items-center gap-3 mt-3">
                            <div class="flex items-center gap-1 text-neutral-600">
                                <span class="material-icons-outlined text-sm">location_on</span>
                                <span>San Francisco, CA</span>
                            </div>
                            <div class="flex items-center gap-1 text-neutral-600">
                                <span class="material-icons-outlined text-sm">mail</span>
                                <span><?php echo htmlspecialchars($user_email); ?></span>
                            </div>
                            <div class="flex items-center gap-1 text-neutral-600">
                                <span class="material-icons-outlined text-sm">calendar_month</span>
                                <span>Joined Jan 2023</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="flex flex-col items-center p-3 rounded-lg hover:bg-neutral-50 transition-colors cursor-pointer">
                            <span class="text-xl font-bold text-[#48A6A7]">24</span>
                            <span class="text-sm text-neutral-500">Courses</span>
                        </div>
                        <div class="flex flex-col items-center p-3 rounded-lg hover:bg-neutral-50 transition-colors cursor-pointer">
                            <span class="text-xl font-bold text-[#48A6A7]">8</span>
                            <span class="text-sm text-neutral-500">Certificates</span>
                        </div>
                        <div class="flex flex-col items-center p-3 rounded-lg hover:bg-neutral-50 transition-colors cursor-pointer">
                            <span class="text-xl font-bold text-[#48A6A7]">4.7</span>
                            <span class="text-sm text-neutral-500">Rating</span>
                        </div>
                    </div>
                </div>
                <div class="mt-8 border-b border-neutral-200">
                    <div class="flex space-x-6">
                        <button class="px-4 py-2 text-[#48A6A7] border-b-2 border-[#48A6A7] font-medium">
                            Overview
                        </button>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-6 mt-8">
                    <div class="col-span-2 space-y-6">
                        <div class="bg-white border border-neutral-200 rounded-xl p-6 hover:shadow-md transition-shadow">
                            <h2 class="text-lg font-semibold mb-4">About Me</h2>
                            <p class="text-neutral-600 leading-relaxed">
                                Computer Science student with a focus on AI and machine learning. Passionate about
                                creating innovative solutions that can help people. Currently seeking internship
                                opportunities in software development to apply my skills in a real-world setting.
                            </p>
                        </div>
                        <div class="bg-white border border-neutral-200 rounded-xl p-6 hover:shadow-md transition-shadow">
                            <h2 class="text-lg font-semibold mb-4"><?php echo htmlspecialchars($user_grade); ?></h2>
                            <div class="space-y-4">
                                <div class="flex gap-4 p-3 hover:bg-neutral-50 rounded-lg transition-colors">
                                    <span class="material-icons-outlined p-2 bg-[#9ACBD0] text-white rounded-full">school</span>
                                    <div>
                                        <p class="font-medium">Completed &quot;Introduction to AI&quot; course</p>
                                        <p class="text-sm text-neutral-500">2 days ago</p>
                                    </div>
                                </div>
                                <div class="flex gap-4 p-3 hover:bg-neutral-50 rounded-lg transition-colors">
                                    <span class="material-icons-outlined p-2 bg-[#9ACBD0] text-white rounded-full">event</span>
                                    <div>
                                        <p class="font-medium">Scheduled career counseling session</p>
                                        <p class="text-sm text-neutral-500">1 week ago</p>
                                    </div>
                                </div>
                                <div class="flex gap-4 p-3 hover:bg-neutral-50 rounded-lg transition-colors">
                                    <span class="material-icons-outlined p-2 bg-[#9ACBD0] text-white rounded-full">badge</span>
                                    <div>
                                        <p class="font-medium">Earned &quot;Python Developer&quot; certificate</p>
                                        <p class="text-sm text-neutral-500">2 weeks ago</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="p-4">
              <a href="logout.php"
                class="block text-center bg-[#48A6A7] hover:bg-[#9ACBD0] text-black font-semibold px-4 py-2 rounded transition">
                Logout
              </a>
            </div>
  </body>

</html>
