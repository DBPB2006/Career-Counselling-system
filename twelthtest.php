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
        $recommendation = "Your aptitude suggests <strong>$main</strong> with a focus on <strong>$sub Engineering</strong>! 💻⚙️";
    } elseif ($architecture >= $agriculture) {
        $main = "Architecture";
        arsort($sub_architecture);
        $sub = array_key_first($sub_architecture);
        $recommendation = "Your aptitude suggests <strong>$main</strong> specializing in <strong>$sub</strong>! 🏙️🎨";
    } else {
        $main = "Agriculture";
        arsort($sub_agriculture);
        $sub = array_key_first($sub_agriculture);
        $recommendation = "Your aptitude suggests <strong>$main</strong> focusing on <strong>$sub</strong>! 🌾🚜";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Career Aptitude Test - CopeUp</title>
    <link href="./output.css" rel="stylesheet" />
</head>
<body class="relative font-sans text-gray-800">
   
<header class="bg-gradient-to-r from-[#48A6A7] to-[#006A71] text-white py-4 z-10 relative">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
       
        <div class="flex items-center space-x-2">
            <img src="realogo.png" class="w-10 h-10 rounded-full object-cover bg-[#006A71]" alt="Logo" />
            <span class="text-xl font-bold tracking-wide">CopeUp</span>
        </div>

        <div class="flex items-center space-x-6">
         
            <nav class="flex space-x-6 items-center">
                <a href="home.php" class="hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">Home</a>
                <a href="grade.php" class="hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">Explore Grades</a>
            </nav>
            <div class="relative group" role="menu" aria-haspopup="true" aria-label="User profile dropdown">
                <button class="text-white border border-white px-4 py-2 rounded hover:bg-white hover:text-[#006A71] transition">
                    Profile
                </button>
                <div class="absolute right-0 mt-2 w-64 bg-[#F2EFE7] text-black rounded-lg shadow-lg opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
                    <div class="p-4 border-b border-[#ccc]">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-[#48A6A7] text-white rounded-full flex items-center justify-center text-lg font-semibold">
                                <?= strtoupper(substr($name, 0, 1)) ?>
                            </div>
                            <div>
                                <p class="font-medium text-[#006A71]"><?= $name ?></p>
                                <p class="text-sm text-gray-600"><?= $userEmail ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <a href="logout.php" class="block text-center bg-[#9ACBD0] hover:bg-[#48A6A7] text-black font-semibold px-4 py-2 rounded transition">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<section class="max-w-3xl mx-auto my-12 bg-white/60 backdrop-blur-lg p-8 rounded-2xl shadow-lg z-10 relative">
    <h2 class="text-2xl font-bold text-[#006A71] mb-4">Career Aptitude Test</h2>

    <?php if ($recommendation): ?>
        <div class="p-4 bg-green-100 text-green-800 rounded mb-6 text-lg font-medium shadow">
            <?= $recommendation ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-6">

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">1️⃣ Which of these sounds more exciting to you?</p>
            <label class="block font-bold"><input type="radio" name="q1" value="btech" required> Designing machines or writing code</label>
            <label class="block font-bold"><input type="radio" name="q1" value="architecture"> Creating building models and city layouts</label>
            <label class="block font-bold"><input type="radio" name="q1" value="agriculture"> Working on farms, growing plants and food</label>
        </div>

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">2️⃣ Pick a favorite type of task:</p>
            <label class="block font-bold"><input type="radio" name="q2" value="Mechanical" required> Fixing, building or understanding machines</label>
            <label class="block font-bold"><input type="radio" name="q2" value="Urban Design"> Planning communities and public spaces</label>
            <label class="block font-bold"><input type="radio" name="q2" value="Agronomy"> Researching soil and crops</label>
        </div>

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">3️⃣ Which of these careers attracts you the most?</p>
            <label class="block font-bold"><input type="radio" name="q3" value="Computer Science" required> Software Engineer / Data Scientist</label>
            <label class="block font-bold"><input type="radio" name="q3" value="Interior"> Interior Designer / Space Planner</label>
            <label class="block font-bold"><input type="radio" name="q3" value="Horticulture"> Horticulturist / Garden Expert</label>
        </div>

        <div>um
            <p class="font-bold text-lg text-[rgb(242,242,242)]">4️⃣ You prefer to work on...</p>
            <label class="block font-bold"><input type="radio" name="q4" value="Civil" required> Infrastructure like bridges and roads</label>
            <label class="block font-bold"><input type="radio" name="q4" value="Landscape"> Designing outdoor parks and eco-friendly spaces</label>
            <label class="block font-bold"><input type="radio" name="q4" value="Animal Sciences"> Animal care, breeding and food production</label>
        </div>

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">5️⃣ Which subject do you like the most?</p>
            <label class="block font-bold"><input type="radio" name="q5" value="btech" required> Physics / Computer Science / Math</label>
            <label class="block font-bold"><input type="radio" name="q5" value="architecture"> Drawing / Design / Geography</label>
            <label class="block font-bold"><input type="radio" name="q5" value="agriculture"> Biology / Environment / Botany</label>
        </div>

        <button type="submit" class="mt-4 bg-[#006A71] text-white px-6 py-2 rounded hover:bg-[#48A6A7] transition">Submit Test</button>
    </form>
</section>
</body>
</html>
