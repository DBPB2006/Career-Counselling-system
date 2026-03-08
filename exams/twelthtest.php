<?php
session_start();
include '../includes/connect.php';

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

$recommendation = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $btech = 0;
    $architecture = 0;
    $agriculture = 0;

    $sub_btech = ['Mechanical' => 0, 'Computer Science' => 0, 'Civil' => 0];
    $sub_architecture = ['Urban Design' => 0, 'Interior' => 0, 'Landscape' => 0];
    $sub_agriculture = ['Agronomy' => 0, 'Horticulture' => 0, 'Animal Sciences' => 0];

    foreach ($_POST as $key => $value) {
        if ($value === 'btech') $btech++;
        if ($value === 'architecture') $architecture++;
        if ($value === 'agriculture') $agriculture++;

        if (isset($sub_btech[$value])) $sub_btech[$value]++;
        if (isset($sub_architecture[$value])) $sub_architecture[$value]++;
        if (isset($sub_agriculture[$value])) $sub_agriculture[$value]++;
    }

    // Choose main stream
    if ($btech >= $architecture && $btech >= $agriculture) {
        $main = "B.Tech (Engineering)";
        arsort($sub_btech);
        $sub = array_key_first($sub_btech);
        $recommendation = "Your aptitude suggests <strong>$main</strong> with a focus on <strong>$sub Engineering</strong>!";
    } elseif ($architecture >= $agriculture) {
        $main = "Architecture";
        arsort($sub_architecture);
        $sub = array_key_first($sub_architecture);
        $recommendation = "Your aptitude suggests <strong>$main</strong> specializing in <strong>$sub</strong>!";
    } else {
        $main = "Agriculture";
        arsort($sub_agriculture);
        $sub = array_key_first($sub_agriculture);
        $recommendation = "Your aptitude suggests <strong>$main</strong> focusing on <strong>$sub</strong>!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Career Aptitude Test - CopeUp</title>
    <link href="../output.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-[#F2EFE7]">
    <div class="w-full font-sans">
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
                    <a href="../pages/grade.php" class="flex items-center gap-2 hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">
                        <i class="fas fa-search"></i>
                        <span>Explore Careers</span>
                    </a>
                </nav>
                <div class="relative group" aria-label="User profile dropdown">
                    <button class="text-[#F2EFE7] border border-[#F2EFE7] px-4 py-2 rounded hover:bg-[#9ACBD0] hover:text-black transition flex items-center gap-2" onclick="openProfilePage()">
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
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="py-16 px-6">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold text-[#006A71] mb-4">
                                <i class="fas fa-graduation-cap mr-2"></i>Career Options
                            </h2>
                            <p class="text-gray-600">
                                Answer these questions to discover which stream aligns best with your interests and strengths.
                            </p>
                        </div>

                        <?php if ($recommendation): ?>
                            <div class="p-6 bg-green-50 border border-green-200 rounded-lg mb-8">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 text-2xl mr-3"></i>
                                    <div class="text-green-800 text-lg">
                                        <?= $recommendation ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST" class="space-y-8">
                            <!-- Question 1 -->
                            <div class="bg-white/80 p-6 rounded-lg shadow-sm">
                                <p class="text-lg font-semibold text-[#006A71] mb-4">
                                    <i class="fas fa-question-circle mr-2"></i>Which of these sounds more exciting to you?
                                </p>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q1" value="science" required class="mr-3">
                                        <div>
                                            <span class="font-medium">Conducting experiments and research</span>
                                            <p class="text-sm text-gray-500">For those who love scientific inquiry</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q1" value="btech" required class="mr-3">
                                        <div>
                                            <span class="font-medium">Designing machines or writing code</span>
                                            <p class="text-sm text-gray-500">For those who love technology and innovation</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q1" value="commerce" required class="mr-3">
                                        <div>
                                            <span class="font-medium">Analyzing business and finance</span>
                                            <p class="text-sm text-gray-500">For those interested in commerce and trade</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q1" value="arts" required class="mr-3">
                                        <div>
                                            <span class="font-medium">Creating art or studying humanities</span>
                                            <p class="text-sm text-gray-500">For those passionate about creativity and culture</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 2 -->
                            <div class="bg-white/80 p-6 rounded-lg shadow-sm">
                                <p class="text-lg font-semibold text-[#006A71] mb-4">
                                    <i class="fas fa-question-circle mr-2"></i>Pick a favorite type of task:
                                </p>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q2" value="Mechanical" required class="mr-3">
                                        <div>
                                            <span class="font-medium">Fixing, building or understanding machines</span>
                                            <p class="text-sm text-gray-500">For those who enjoy hands-on technical work</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q2" value="Urban Design" class="mr-3">
                                        <div>
                                            <span class="font-medium">Planning communities and public spaces</span>
                                            <p class="text-sm text-gray-500">For those who enjoy urban planning and design</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q2" value="Agronomy" class="mr-3">
                                        <div>
                                            <span class="font-medium">Researching soil and crops</span>
                                            <p class="text-sm text-gray-500">For those who enjoy agricultural research</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 3 -->
                            <div class="bg-white/80 p-6 rounded-lg shadow-sm">
                                <p class="text-lg font-semibold text-[#006A71] mb-4">
                                    <i class="fas fa-question-circle mr-2"></i>Which of these careers attracts you the most?
                                </p>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q3" value="Computer Science" required class="mr-3">
                                        <div>
                                            <span class="font-medium">Software Engineer / Data Scientist</span>
                                            <p class="text-sm text-gray-500">For those interested in technology and data</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q3" value="Interior" class="mr-3">
                                        <div>
                                            <span class="font-medium">Interior Designer / Space Planner</span>
                                            <p class="text-sm text-gray-500">For those interested in design and aesthetics</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q3" value="Horticulture" class="mr-3">
                                        <div>
                                            <span class="font-medium">Horticulturist / Garden Expert</span>
                                            <p class="text-sm text-gray-500">For those interested in plants and gardening</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 4 -->
                            <div class="bg-white/80 p-6 rounded-lg shadow-sm">
                                <p class="text-lg font-semibold text-[#006A71] mb-4">
                                    <i class="fas fa-question-circle mr-2"></i>You prefer to work on...
                                </p>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q4" value="Civil" required class="mr-3">
                                        <div>
                                            <span class="font-medium">Infrastructure like bridges and roads</span>
                                            <p class="text-sm text-gray-500">For those interested in civil engineering</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q4" value="Landscape" class="mr-3">
                                        <div>
                                            <span class="font-medium">Designing outdoor parks and eco-friendly spaces</span>
                                            <p class="text-sm text-gray-500">For those interested in landscape design</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q4" value="Animal Sciences" class="mr-3">
                                        <div>
                                            <span class="font-medium">Animal care, breeding and food production</span>
                                            <p class="text-sm text-gray-500">For those interested in animal sciences</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Question 5 -->
                            <div class="bg-white/80 p-6 rounded-lg shadow-sm">
                                <p class="text-lg font-semibold text-[#006A71] mb-4">
                                    <i class="fas fa-question-circle mr-2"></i>Which subject do you like the most?
                                </p>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q5" value="btech" required class="mr-3">
                                        <div>
                                            <span class="font-medium">Physics / Computer Science / Math</span>
                                            <p class="text-sm text-gray-500">For those who excel in technical subjects</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q5" value="architecture" class="mr-3">
                                        <div>
                                            <span class="font-medium">Drawing / Design / Geography</span>
                                            <p class="text-sm text-gray-500">For those who excel in creative subjects</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition cursor-pointer">
                                        <input type="radio" name="q5" value="agriculture" class="mr-3">
                                        <div>
                                            <span class="font-medium">Biology / Environment / Botany</span>
                                            <p class="text-sm text-gray-500">For those who excel in life sciences</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="bg-[#006A71] text-white px-8 py-3 rounded-lg font-medium hover:bg-[#48A6A7] transition flex items-center justify-center gap-2 mx-auto">
                                    <i class="fas fa-paper-plane"></i>
                                    Submit Test
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        function openProfilePage() {
            window.location.href = "profile.php";
        }
    </script>
</body>
</html>
