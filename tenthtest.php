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

$stream = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $science = 0;
    $commerce = 0;
    $arts = 0;

    foreach ($_POST as $key => $value) {
        if ($value === 'science') $science++;
        if ($value === 'commerce') $commerce++;
        if ($value === 'arts') $arts++;
    }

    if ($science >= $commerce && $science >= $arts) {
        $stream = "Based on your answers, <strong>Science</strong> stream is recommended! 🔬";
    } elseif ($commerce >= $arts) {
        $stream = "Based on your answers, <strong>Commerce</strong> stream is recommended! 💼";
    } else {
        $stream = "Based on your answers, <strong>Arts</strong> stream is recommended! 🎨";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aptitude Test - CopeUp</title>
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
    <h2 class="text-2xl font-bold text-[#006A71] mb-4">10th Grade Aptitude Test</h2>

    <?php if ($stream): ?>
        <div class="p-4 bg-green-100 text-green-800 rounded mb-6 text-lg font-medium shadow">
            <?= $stream ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-6">
        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">1️⃣ Which subject do you enjoy the most?</p>
            <label class="block font-bold"><input type="radio" name="q1" value="science" required> Mathematics / Science</label>
            <label class="block font-bold"><input type="radio" name="q1" value="commerce"> Economics / Business</label>
            <label class="block font-bold"><input type="radio" name="q1" value="arts"> History / Literature</label>
        </div>

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">2️⃣ What type of activities do you prefer?</p>
            <label class="block font-bold"><input type="radio" name="q2" value="science" required> Experiments, logical puzzles</label>
            <label class="block font-bold"><input type="radio" name="q2" value="commerce"> Analyzing markets or profits</label>
            <label class="block font-bold"><input type="radio" name="q2" value="arts"> Writing stories, drawing or music</label>
        </div>

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">3️⃣ Which career sounds most exciting?</p>
            <label class="block font-bold"><input type="radio" name="q3" value="science" required> Engineer / Doctor / Scientist</label>
            <label class="block font-bold"><input type="radio" name="q3" value="commerce"> Entrepreneur / Accountant / Banker</label>
            <label class="block font-bold"><input type="radio" name="q3" value="arts"> Writer / Designer / Journalist</label>
        </div>

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">4️⃣ How do you solve problems?</p>
            <label class="block font-bold"><input type="radio" name="q4" value="science" required> Using logic and formulas</label>
            <label class="block font-bold"><input type="radio" name="q4" value="commerce"> Understanding risks and profits</label>
            <label class="block font-bold"><input type="radio" name="q4" value="arts"> Creatively and visually</label>
        </div>

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">5️⃣ What kind of books do you prefer?</p>
            <label class="block font-bold"><input type="radio" name="q5" value="science" required> Science fiction / Tech</label>
            <label class="block font-bold"><input type="radio" name="q5" value="commerce"> Business / Self-help</label>
            <label class="block font-bold"><input type="radio" name="q5" value="arts"> Novels / Poetry / Art books</label>
        </div>

        <button type="submit" class="mt-4 bg-[#006A71] text-white px-6 py-2 rounded hover:bg-[#48A6A7] transition">
            Submit Test
        </button>
    </form>
</section>
</body>
</html>
