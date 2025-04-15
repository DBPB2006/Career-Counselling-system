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

$futurePath = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $industry = 0;
    $phd = 0;
    $teaching = 0;
    $startup = 0;
    $govt = 0;

    foreach ($_POST as $key => $value) {
        if ($value === 'industry') $industry++;
        if ($value === 'phd') $phd++;
        if ($value === 'teaching') $teaching++;
        if ($value === 'startup') $startup++;
        if ($value === 'govt') $govt++;
    }

    if ($industry >= $phd && $industry >= $teaching && $industry >= $startup && $industry >= $govt) {
        $futurePath = "You seem ready for the <strong>Corporate World</strong>! Explore roles in MNCs, R&D, consultancy or technical industries. 💼💻";
    } elseif ($phd >= $teaching && $phd >= $startup && $phd >= $govt) {
        $futurePath = "You have a strong research mindset! Pursuing a <strong>PhD / Research Fellowship</strong> is the ideal path for you. 🧪🔬";
    } elseif ($teaching >= $startup && $teaching >= $govt) {
        $futurePath = "You seem passionate about knowledge sharing — <strong>Teaching or Academia</strong> suits you best! 👨‍🏫📚";
    } elseif ($startup >= $govt) {
        $futurePath = "Your entrepreneurial mindset shines! Starting your own <strong>Startup</strong> or working in early-stage companies could be your calling. 🚀💡";
    } else {
        $futurePath = "A stable and impactful path awaits you in <strong>Government / Civil Services</strong>. Consider UPSC, State PSC, or similar exams. 🏛️📝";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Postgraduate Career Direction - CopeUp</title>
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
    <h2 class="text-2xl font-bold text-[#006A71] mb-4">Postgraduate Career Direction Test</h2>

    <?php if ($futurePath): ?>
        <div class="p-4 bg-green-100 text-green-800 rounded mb-6 text-lg font-medium shadow">
            <?= $futurePath ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-6">

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">1️⃣ What’s your primary focus after postgraduation?</p>
            <label class="block font-bold"><input type="radio" name="q1" value="industry" required> Get into the Corporate / Private Sector</label>
            <label class="block font-bold"><input type="radio" name="q1" value="phd"> Pursue a PhD / Research Project</label>
            <label class="block font-bold"><input type="radio" name="q1" value="teaching"> Become a Professor / Lecturer</label>
            <label class="block font-bold"><input type="radio" name="q1" value="startup"> Start my own business</label>
            <label class="block font-bold"><input type="radio" name="q1" value="govt"> Prepare for Government Services</label>
        </div>

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">2️⃣ Which environment excites you the most?</p>
            <label class="block font-bold"><input type="radio" name="q2" value="industry" required> Fast-paced corporate offices</label>
            <label class="block font-bold"><input type="radio" name="q2" value="phd"> Research labs and conferences</label>
            <label class="block font-bold"><input type="radio" name="q2" value="teaching"> Classrooms & mentoring students</label>
            <label class="block font-bold"><input type="radio" name="q2" value="startup"> Startup culture / self-driven work</label>
            <label class="block font-bold"><input type="radio" name="q2" value="govt"> Structured roles in administration</label>
        </div>

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">3️⃣ What drives you the most?</p>
            <label class="block font-bold"><input type="radio" name="q3" value="industry" required> Professional growth & high salary</label>
            <label class="block font-bold"><input type="radio" name="q3" value="phd"> Solving unsolved problems</label>
            <label class="block font-bold"><input type="radio" name="q3" value="teaching"> Sharing knowledge</label>
            <label class="block font-bold"><input type="radio" name="q3" value="startup"> Building innovative products</label>
            <label class="block font-bold"><input type="radio" name="q3" value="govt"> Public service & stability</label>
        </div>

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">4️⃣ What’s your work style?</p>
            <label class="block font-bold"><input type="radio" name="q4" value="industry" required> Structured & Team-driven</label>
            <label class="block font-bold"><input type="radio" name="q4" value="phd"> Independent & Research-oriented</label>
            <label class="block font-bold"><input type="radio" name="q4" value="teaching"> Student-focused & explanatory</label>
            <label class="block font-bold"><input type="radio" name="q4" value="startup"> Risk-taker & self-motivated</label>
            <label class="block font-bold"><input type="radio" name="q4" value="govt"> Organized & Rule-driven</label>
        </div>

        <div>
            <p class="font-bold text-lg text-[rgb(242,242,242)]">5️⃣ Your dream title would be:</p>
            <label class="block font-bold"><input type="radio" name="q5" value="industry" required> Project Manager / Lead Engineer</label>
            <label class="block font-bold"><input type="radio" name="q5" value="phd"> Dr. / Research Scientist</label>
            <label class="block font-bold"><input type="radio" name="q5" value="teaching"> Professor / Assistant Professor</label>
            <label class="block font-bold"><input type="radio" name="q5" value="startup"> CEO / Founder</label>
            <label class="block font-bold"><input type="radio" name="q5" value="govt"> IAS / Officer</label>
        </div>

        <button type="submit" class="mt-4 bg-[#006A71] text-white px-6 py-2 rounded hover:bg-[#48A6A7] transition">Submit Test</button>
    </form>
</section>
</body>
</html>
