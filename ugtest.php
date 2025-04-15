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

$careerPath = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tech = 0;
    $management = 0;
    $research = 0;
    $agri = 0;
    $design = 0;

    foreach ($_POST as $key => $value) {
        if ($value === 'tech') $tech++;
        if ($value === 'management') $management++;
        if ($value === 'research') $research++;
        if ($value === 'agriculture') $agri++;
        if ($value === 'design') $design++;
    }

    // Decision Logic
    if ($tech >= $management && $tech >= $research && $tech >= $agri && $tech >= $design) {
        $careerPath = "A tech-oriented future suits you best! Consider pursuing <strong>M.Tech, Data Science, AI Research</strong> or Product Engineering roles. 💻🚀";
    } elseif ($management >= $research && $management >= $agri && $management >= $design) {
        $careerPath = "You seem inclined towards leadership and business! An <strong>MBA</strong> or entrepreneurship could be your ideal next step. 💼📊";
    } elseif ($research >= $agri && $research >= $design) {
        $careerPath = "You seem research-minded! Pursuing an <strong>M.Sc / PhD</strong> in your specialization might be perfect. 🔬📚";
    } elseif ($agri >= $design) {
        $careerPath = "Your passion lies in sustainable living and nature! Consider <strong>M.Sc Agriculture</strong> or roles in Agricultural Technology. 🌱🚜";
    } else {
        $careerPath = "Your creative flair stands out! Consider <strong>Masters in Design (M.Des)</strong> or User Experience careers. 🎨💡";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Career Path Test - CopeUp</title>
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
</header>    <section class="max-w-3xl mx-auto my-12 bg-white/60 backdrop-blur-lg p-8 rounded-2xl shadow-lg z-10 relative">
        <h2 class="text-2xl font-bold text-[#006A71] mb-4">Undergraduate Career Direction Test</h2>

        <?php if ($careerPath): ?>
            <div class="p-4 bg-green-100 text-green-800 rounded mb-6 text-lg font-medium shadow">
                <?= $careerPath ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-6">

            <div>
                <p class="font-bold text-lg text-[rgb(242,242,242)]">1️⃣ What's your current major field?</p>
                <label class="block font-bold"><input type="radio" name="q1" value="tech" required> Engineering / Computer Science</label>
                <label class="block font-bold"><input type="radio" name="q1" value="management"> Business / Commerce</label>
                <label class="block font-bold"><input type="radio" name="q1" value="agriculture"> Agriculture / Environmental Science</label>
                <label class="block font-bold"><input type="radio" name="q1" value="design"> Design / Fine Arts / Architecture</label>
                <label class="block font-bold"><input type="radio" name="q1" value="research"> Basic Sciences / Humanities</label>
            </div>

            <div>
                <p class="font-bold text-lg text-[hsl(189,6%,79%)]">2️⃣ Which career sounds most appealing to you?</p>
                <label class="block font-bold"><input type="radio" name="q2" value="tech" required> Software Developer / Engineer / Analyst</label>
                <label class="block font-bold"><input type="radio" name="q2" value="management"> Business Manager / Startup Founder</label>
                <label class="block font-bold"><input type="radio" name="q2" value="research"> Scientist / Professor</label>
                <label class="block font-bold"><input type="radio" name="q2" value="agriculture"> Farm Consultant / Food Tech Expert</label>
                <label class="block font-bold"><input type="radio" name="q2" value="design"> UX Designer / Architect / Creative Director</label>
            </div>

            <div>
                <p class="font-bold text-lg text-[rgb(223,223,223)]">3️⃣ What motivates you more?</p>
                <label class="block font-bold"><input type="radio" name="q3" value="tech" required> Solving complex technical problems</label>
                <label class="block font-bold"><input type="radio" name="q3" value="management"> Leading people & making strategies</label>
                <label class="block font-bold"><input type="radio" name="q3" value="research"> Discovering new knowledge</label>
                <label class="block font-bold"><input type="radio" name="q3" value="agriculture"> Sustainable living and food security</label>
                <label class="block font-bold"><input type="radio" name="q3" value="design"> Turning ideas into visuals and designs</label>
            </div>

            <div>
                <p class="font-bold text-lg text-[hsl(0,0%,100%)]">4️⃣ Your ideal higher education goal?</p>
                <label class="block font-bold"><input type="radio" name="q4" value="tech" required> M.Tech / MS in Tech Field</label>
                <label class="block font-bold"><input type="radio" name="q4" value="management"> MBA / PGDM</label>
                <label class="block font-bold"><input type="radio" name="q4" value="research"> PhD / Research Fellowship</label>
                <label class="block font-bold"><input type="radio" name="q4" value="agriculture"> M.Sc Agriculture / Agri-Business</label>
                <label class="block font-bold"><input type="radio" name="q4" value="design"> M.Des / Design Specialization</label>
            </div>

            <div>
                <p class="font-bold text-lg">5️⃣ What's your biggest strength?</p>
                <label class="block font-bold "><input type="radio" name="q5" value="tech" required> Analytical Thinking</label>
                <label class="block font-bold"><input type="radio" name="q5" value="management"> Decision Making</label>
                <label class="block font-bold"><input type="radio" name="q5" value="research"> Curiosity & Observation</label>
                <label class="block font-bold"><input type="radio" name="q5" value="agriculture"> Patience & Natural Awareness</label>
                <label class="block font-bold"><input type="radio" name="q5" value="design"> Creativity & Visual Thinking</label>
            </div>

            <button type="submit" class="mt-4 bg-[#006A71] text-white px-6 py-2 rounded hover:bg-[#48A6A7] transition">Submit Test</button>
            
        </form>
    </section>
</body>
</html>
