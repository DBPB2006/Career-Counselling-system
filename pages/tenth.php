<?php
include '../includes/auth_check.php';
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>tenth</title>
    <link href="../output.css" rel="stylesheet" /> <link href="../assets/css/style.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<body class="bg-[#F2EFE7]">
    <div id="tenth">
        <div class="w-full  font-sans">
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
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
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
                            After 10th grade, you'll need to choose an academic stream that aligns with your
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
                                    <i class="fas fa-flask text-[#2973B2] text-3xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold mb-2 text-gray-800">Science</h3>
                                <p class="text-gray-600 mb-6">
                                    Ideal for those interested in medicine, engineering, research, technology, and
                                    innovation. Strong foundation in physics, chemistry, biology, and mathematics.
                                </p>
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-700 mb-2">Career Paths:</h4>
                                    <ul class="list-disc pl-5 text-gray-600 space-y-1">
                                        <li><i class="fas fa-user-md mr-2"></i>Doctor / Medical Professional</li>
                                        <li><i class="fas fa-cogs mr-2"></i>Engineer (All Disciplines)</li>
                                        <li><i class="fas fa-microscope mr-2"></i>Research Scientist</li>
                                        <li><i class="fas fa-laptop-code mr-2"></i>IT & Technology</li>
                                    </ul>
                                </div>
                                <button
                                    class="bg-[#2973B2] text-white px-4 py-2 rounded-md font-medium hover:bg-blue-600 transition-colors duration-200 w-full">
                                    <i class="fas fa-arrow-right mr-2"></i>Explore Science Stream
                                </button>
                            </div>
                        </div>
                        <!-- Commerce Card -->
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1">
                            <div class="h-3 bg-[#9ACBD0]"></div>
                            <div class="p-6">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-chart-line text-[#9ACBD0] text-3xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold mb-2 text-gray-800">Commerce</h3>
                                <p class="text-gray-600 mb-6">
                                    Perfect for those with interests in business, finance, accounting, economics,
                                    and entrepreneurship. Focuses on commercial applications and financial literacy.
                                </p>
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-700 mb-2">Career Paths:</h4>
                                    <ul class="list-disc pl-5 text-gray-600 space-y-1">
                                        <li><i class="fas fa-calculator mr-2"></i>Chartered Accountant</li>
                                        <li><i class="fas fa-chart-bar mr-2"></i>Business Analyst</li>
                                        <li><i class="fas fa-money-bill-wave mr-2"></i>Investment Banker</li>
                                        <li><i class="fas fa-briefcase mr-2"></i>Entrepreneur</li>
                                    </ul>
                                </div>
                                <button
                                    class="bg-[#9ACBD0] text-white px-4 py-2 rounded-md font-medium hover:bg-green-600 transition-colors duration-200 w-full">
                                    <i class="fas fa-arrow-right mr-2"></i>Explore Commerce Stream
                                </button>
                            </div>
                        </div>
                        <!-- Arts Card -->
                        <div
                            class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 transform hover:-translate-y-1">
                            <div class="h-3 bg-[#48A6A7]"></div>
                            <div class="p-6">
                                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-palette text-[#48A6A7] text-3xl"></i>
                                </div>
                                <h3 class="text-2xl font-bold mb-2 text-gray-800">Arts/Humanities</h3>
                                <p class="text-gray-600 mb-6">
                                    Great for creative minds interested in literature, history, psychology, law,
                                    design, journalism, and social sciences. Develops critical thinking and
                                    communication skills.
                                </p>
                                <div class="mb-6">
                                    <h4 class="font-semibold text-gray-700 mb-2">Career Paths:</h4>
                                    <ul class="list-disc pl-5 text-gray-600 space-y-1">
                                        <li><i class="fas fa-gavel mr-2"></i>Lawyer / Legal Professional</li>
                                        <li><i class="fas fa-brain mr-2"></i>Psychologist / Counselor</li>
                                        <li><i class="fas fa-newspaper mr-2"></i>Journalist / Writer</li>
                                        <li><i class="fas fa-paint-brush mr-2"></i>Designer / Artist</li>
                                    </ul>
                                </div>
                                <button
                                    class="bg-[#48A6A7] text-white px-4 py-2 rounded-md font-medium hover:bg-purple-600 transition-colors duration-200 w-full">
                                    <i class="fas fa-arrow-right mr-2"></i>Explore Arts Stream
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12 text-center">
                        <a href="../exams/tenthtest.php"
                            class="inline-flex items-center text-primary-600 font-medium hover:text-primary-700 transition-colors duration-200">
                            <i class="fas fa-question-circle mr-2"></i>Take our "Which stream fits you best?" quiz
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </section>
            <section class="py-16 px-6 ">
                <div class="container mx-auto">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold mb-4 text-gray-800">
                            Discover Your Strengths &amp; Interests
                        </h2>
                        <p class="text-gray-600 max-w-3xl mx-auto">
                            Understanding your natural abilities and personal interests is crucial in making
                            informed decisions about your future. Our assessment tools can help you gain valuable
                            insights about yourself.
                        </p>
                    </div>
                    <a href="../exams/tenthiq_test.php">
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
                                <button
                                    class="text-primary-600 font-medium hover:text-primary-700 transition-colors duration-200 inline-flex items-center group">
                                    Take Aptitude Test
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 ml-1 group-hover:translate-x-1 transition-transform duration-200"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H3a1 1 0 110-2h9.586l-2.293-2.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div></a>
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
    <section class="chat-window">
  <button class="close" aria-label="Close chat">
    <span class="text-lg font-bold">&times;</span>
  </button>

  <div class="chat">
    <div class="model">
      <p>Hi, how can I help you?</p>
    </div>
  </div>

  <div class="input-area">
    <input placeholder="Ask me anything..." type="text">
    <button aria-label="Send">
      <i class="fas fa-paper-plane text-white text-lg pointer-events-none"></i>
    </button>
  </div>
</section>

<div class="chat-button" aria-label="Open chat">
  <i class="fas fa-comments text-white text-lg"></i>
</div>

  <script type="importmap">
    {
      "imports": {
        "@google/generative-ai": "https://esm.run/@google/generative-ai"
      }
    }
  </script>
  
  <script type="module" src="try.js"></script>
    <script>
    function openProfilePage() {
      
      window.location.href = "profile.php"; 
    }
  </script>
</body>
</html>