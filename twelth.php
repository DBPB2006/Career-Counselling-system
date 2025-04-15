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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>twelth</title>
    <link href="./output.css" rel="stylesheet" />
    <script>
         function openProfilePage() {
      
      window.location.href = "profile.php"; 
    }
    </script>
</head>

<body class="bg-[#F2EFE7]">
    <div id="twelth">
        <div class="w-full  font-sans">
            <header class="bg-gradient-to-r from-[#48A6A7] to-[#006A71] py-4">
                <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <img src="realogo.png" class="w-10 h-10 rounded-full">
                        <span class="text-[#F2EFE7] text-xl font-bold tracking-wide">CopeUp</span>
                    </div>
                    <nav class="hidden md:flex space-x-6 text-[#F2EFE7] text-sm font-medium">
                        <a href="home.php"
                            class="hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">Home</a>
                        <a href="grade.php"
                            class="hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">Grade
                            Roadmap</a>
                        <a href="#about"
                            class="hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">About</a>
                        <a href="#contact"
                            class="hover:text-[#9ACBD0] hover:border-b-2 hover:border-[#9ACBD0] active:border-b-2 active:border-[#9ACBD0] transition-all duration-700">Contact</a>
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
            <section class="py-16 px-6">
                <div class="container mx-auto">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold mb-4 text-gray-800">Which Stream Should You Choose?</h2>
                        <p class="text-gray-600 max-w-3xl mx-auto">
                            After pre-university, you'll need to choose an academic stream that aligns with your
                            interests and career goals. Each path offers unique opportunities for growth and
                            development.
                        </p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Science Card -->
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1">
                            <div class="h-3 bg-[#2973B2]"></div>
                            <div class="p-6">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#2973B2]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold mb-2 text-gray-800">🎓 1. B.Sc. (Bachelor of Science)</h3>
                                <p class="text-gray-600 mb-6">
                                    When it comes to choosing a subject for a BSc, it really depends on your interests,
                                    career goals, and strengths. But I can help you explore some options. Here are a few
                                    popular BSc subjects.
                                </p>
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-700 mb-2">Career Paths:</h4>
                                    <ul class="list-disc pl-5 text-gray-600 space-y-1">
                                        <li>Mathematics</li>
                                        <li>Physics</li>
                                        <li>Chemistry</li>
                                        <li>Biology</li>
                                        <li>Computer Science</li>
                                        <li>Environmental Science</li>
                                        <li>Statistics</li>
                                    </ul>
                                </div>
                                <button
                                    class="bg-[#2973B2] text-white px-4 py-2 rounded-md font-medium hover:bg-blue-600 transition-colors duration-200 w-full">
                                    Explore Science Stream
                                </button>
                            </div>
                        </div>

                        <!-- Commerce Card -->
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1">
                            <div class="h-3 bg-[#9ACBD0]"></div>
                            <div class="p-6">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#9ACBD0]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold mb-2 text-gray-800">💻 2. B.Tech / B.E. (Engineering)</h3>
                                <p class="text-gray-600 mb-6">
                                    When it comes to choosing a BTech, the decision largely depends on your interests,
                                    career goals, and future aspirations. I can give you a breakdown of some popular
                                    BTech specializations and what kind of careers they can lead to. Here's a look at
                                    some of the options.
                                </p>
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-700 mb-2">Career Paths:</h4>
                                    <ul class="list-disc pl-5 text-gray-600 space-y-1">
                                        <li>Computer Science Engineering (CSE)</li>
                                        <li>Electronics and Communication Engineering (ECE)</li>
                                        <li>BTech in Mechanical Engineering</li>
                                        <li>Civil Engineering</li>
                                        <li>Electrical Engineering</li>
                                        <li>Information Technology (IT)</li>
                                        <li>Biotechnology</li>
                                        <li>Chemical Engineering</li>
                                        <li>Aerospace Engineering</li>
                                    </ul>
                                </div>
                                <button
                                    class="bg-[#9ACBD0] text-white px-4 py-2 rounded-md font-medium hover:bg-green-600 transition-colors duration-200 w-full">
                                    Explore Engineering Stream
                                </button>
                            </div>
                        </div>

                        <!-- Arts Card -->
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1">
                            <div class="h-3 bg-[#48A6A7]"></div>
                            <div class="p-6">
                                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#48A6A7]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold mb-2 text-gray-800">📈 3. B.Com (Bachelor of Commerce)
                                </h3>
                                <p class="text-gray-600 mb-6">
                                    When it comes to choosing a BCom, the decision largely depends on your interests,
                                    future career aspirations, and where you see yourself excelling. I can give you an
                                    overview of some popular BCom specializations, along with potential career paths.
                                </p>
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-700 mb-2">Career Paths:</h4>
                                    <ul class="list-disc pl-5 text-gray-600 space-y-1">
                                        <li>Financial Accounting</li>
                                        <li>Business Law</li>
                                        <li>Taxation</li>
                                        <li>Auditing</li>
                                        <li>Economics</li>
                                        <li>Cost Accounting</li>
                                        <li>Management Studies</li>
                                    </ul>
                                </div>
                                <button
                                    class="bg-[#48A6A7] text-white px-4 py-2 rounded-md font-medium hover:bg-purple-600 transition-colors duration-200 w-full">
                                    Explore Commerce Stream
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1">
                            <div class="h-3 bg-[#2973B2]"></div>
                            <div class="p-6">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#9ACBD0]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
</div>
                                <h3 class="text-2xl font-bold mb-2 text-gray-800">🖋️ 4. B.A (Bachelor of Arts)</h3>
                                <p class="text-gray-600 mb-6">
                                    In Business Administration (BA), there are several career paths you can take,
                                        depending on your interests, strengths, and long-term goals. Here’s a breakdown
                                        of some popular career paths.
                                </p>
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-700 mb-2">Career Paths:</h4>
                                    <ul class="list-disc pl-5 text-gray-600 space-y-1">
                                     <li>English Literature</li>
                                            <li>History</li>
                                            <li>Political Science</li>
                                            <li>Psychology</li>
                                            <li>Sociology</li>
                                            <li>Economics</li>
                                            <li>Geography</li>
                                    </ul>
                                </div>
                                <button
                                    class="bg-[#2973B2] text-white px-4 py-2 rounded-md font-medium hover:bg-blue-600 transition-colors duration-200 w-full">
                                    Explore Commerece Stream
                                </button>
                            </div>
                        </div>
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1">
                            <div class="h-3 bg-[#9ACBD0]"></div>
                            <div class="p-6">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#9ACBD0]" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold mb-2 text-gray-800">Specializaed courses</h3>
                                <p class="text-gray-600 mb-6">
                                    Specialized courses aren't necessarily for everyone—they're best suited for people
                                    with certain goals or characteristics. Here's a breakdown of who should consider
                                    taking specialized courses.
                                </p>
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-700 mb-2">Career Paths:</h4>
                                    <ul class="list-disc pl-5 text-gray-600 space-y-1">
                                        <li>BBA: Business Administration, Marketing, HR</li>
                                        <li>BCA: Computer Applications</li>
                                        <li>MBBS: Human Anatomy, Physiology, Pathology, etc.</li>


                                    </ul>
                                </div>
                                <button
                                    class="bg-[#9ACBD0] text-white px-4 py-2 rounded-md font-medium hover:bg-green-600 transition-colors duration-200 w-full">
                                    Explore them!
                                </button>
                            </div>
                        </div>
</div>


        <div class="mt-12 text-center">
            <a href=""
                class="inline-flex items-center text-primary-600 font-medium hover:text-primary-700 transition-colors duration-200">
                Take our "Which stream fits you best?" quiz
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </a>
        </div>
    </div>
    </section>
    <section class="py-16 px-6 ">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4 text-gray-800">
                    Discover Your Strengths & Interests
                </h2>
                <p class="text-gray-600 max-w-3xl mx-auto">
                    Understanding your natural abilities and personal interests is crucial in making
                    informed decisions about your future. Our assessment tools can help you gain valuable
                    insights about yourself.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-[#80CBC4] rounded-lg shadow overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div class="relative h-48 bg-primary-100 flex items-center justify-center overflow-hidden">
                        <div
                            class="absolute w-full h-full bg-primary-600 opacity-0 group-hover:opacity-20 transition-opacity duration-300">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-24 w-24 text-primary-600 group-hover:scale-110 transition-transform duration-300"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Aptitude Assessment</h3>
                        <p class="text-gray-600 mb-4">
                            Discover your natural abilities and strengths through our comprehensive aptitude
                            tests. Understand what subjects and careers align with your innate capabilities.
                        </p>
                       <a href="twelthtest.php"><button
                            class="text-primary-600 font-medium hover:text-primary-700 transition-colors duration-200 inline-flex items-center group">
                            Take Aptitude Test
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 ml-1 group-hover:translate-x-1 transition-transform duration-200"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H3a1 1 0 110-2h9.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button></a>
                    </div>
                </div>
                <div
                    class="bg-[#B4EBE6] rounded-lg shadow overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div class="relative h-48 bg-primary-100 flex items-center justify-center overflow-hidden">
                        <div
                            class="absolute w-full h-full bg-primary-600 opacity-0 group-hover:opacity-20 transition-opacity duration-300">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-24 w-24 text-primary-600 group-hover:scale-110 transition-transform duration-300"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Interest Inventory</h3>
                        <p class="text-gray-600 mb-4">
                            Explore what truly excites and motivates you. Our interest inventory helps
                            identify your passions and suggests career paths that match your enthusiasm.
                        </p>
                        <button
                            class="text-primary-600 font-medium hover:text-primary-700 transition-colors duration-200 inline-flex items-center group">
                            Explore Your Interests
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 ml-1 group-hover:translate-x-1 transition-transform duration-200"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H3a1 1 0 110-2h9.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div
                    class="bg-[#9FB3DF] rounded-lg shadow overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div class="relative h-48 bg-primary-100 flex items-center justify-center overflow-hidden">
                        <div
                            class="absolute w-full h-full bg-primary-600 opacity-0 group-hover:opacity-20 transition-opacity duration-300">
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-24 w-24 text-primary-600 group-hover:scale-110 transition-transform duration-300"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z">
                            </path>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Career Journal</h3>
                        <p class="text-gray-600 mb-4">
                            Keep track of your self-discovery journey with guided reflection prompts,
                            goal-setting exercises, and space to document your thoughts about potential
                            career paths.
                        </p>
                        <button
                            class="text-primary-600 font-medium hover:text-primary-700 transition-colors duration-200 inline-flex items-center group">
                            Start Your Journal
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 ml-1 group-hover:translate-x-1 transition-transform duration-200"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H3a1 1 0 110-2h9.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
    </div>

</body>

</html>