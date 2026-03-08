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
    <title>CopeUp - Career Guide</title>
    <link href="../output.css" rel="stylesheet" />
    <link href="../assets/css/style.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        html{
            scroll-behavior: smooth;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-image: url("../assets/images/uu.jpg");
            color: #333;
            background-size: cover;
            background-position: center;
            
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
        }
        .timeline {
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            width: 5px;
            height: 90%;
            background-color: #9ACBD0;
            transform: translateX(-50%);
        }
        .timeline-entry {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            width: 100%;
            position: relative;
        }
        .timeline-entry:nth-child(odd) {
            flex-direction: row-reverse;
        }
        .timeline-entry .node {
            width: 25px;
            height: 25px;
            background-color: #006A71;
            border: 3px solid white;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
        }
        .timeline-entry .content {
            width: 45%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #006A71;
        }
        .timeline-entry:nth-child(odd) .content {
            border-left: none;
            border-right: 5px solid #006A71;
        }
        .timeline-entry h3 {
            margin-top: 0;
            color: #333;
        }
        .timeline-entry p {
            color: #555;
            margin-bottom: 10px;
        }
        .timeline-entry .key-actions {
            color: #48A6A7;
            font-weight: bold;
            font-size: 0.9em;
            cursor: pointer;
        }
        
        
    </style>
    <script>
        function toggleDetails(id) {
            const content = document.querySelector(`#details-${id}`);
            const button = document.querySelector(`#toggle-${id}`);
            if (content.style.display === 'none') {
                content.style.display = 'block';
                button.textContent = 'Click to hide details';
            } else {
                content.style.display = 'none';
                button.textContent = 'Click to see more details';
            }
        }
        function openProfilePage() {
      
      window.location.href = "profile.php"; 
    }
    
    </script>
   
</head>
<body class=" bg-cover font-sans text-gray-800 ">
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
    

    <div class="container ">


        <div class="timeline">
            <div class="timeline-entry">
                <div class="node"></div>
                <div class="content">
                    <img src="../assets/images/10th.png" class="w-30 h-20" alt="High School">
                    <h3 class="ml-2">High School</h3>
                    <p>Start exploring your interests, subjects you enjoy, and begin understanding potential career paths.</p>
                    <button id="toggle-1" class="key-actions" onclick="toggleDetails(1)">Click to see more details</button>
                    <div id="details-1" style="display: none;">
                        <ul>
                            <li>Take interest and aptitude tests</li>
                            <li>Attend career awareness workshops</li>
                            <li>Explore subjects through projects and reading</li>
                        </ul>
                        <form action="../includes/add_grade.php" method="POST">
                <input type="hidden" name="grade" value="High School">
                <label class="text-sm text-[#006A71]">
                    <input type="checkbox" name="agree" class="form-checkbox text-teal-500" required>
                    Continue as Tenth Grade
                </label>
                <br>
                <button type="submit" class="mt-2 text-white bg-teal-500 hover:bg-teal-600 px-3 py-1 rounded">Submit</button>
            </form>
                        <a class=" text-teal-500 hover:underline" href="tenth.php">Learn More</a>

                    </div>
                </div>
            </div>
            <div class="timeline-entry">
                <div class="node"></div>
                <div class="content">
                    <img src="../assets/images/twelth.png" class="w-30 h-20">
                    <h3 class="ml-2">Pre-University</h3>
                    <p>Build a strong academic foundation and identify fields of study for higher education.</p>
                    <button id="toggle-2" class="key-actions" onclick="toggleDetails(2)">Click to see more details</button>
                    <div id="details-2" style="display: none;">
                        <ul>
                            <li>Research degrees and professional courses</li>
                            <li>Participate in internships or mentorship programs</li>
                            <li>Prepare for entrance exams (if applicable)</li>
                        </ul>
                        <form action="../includes/add_grade.php" method="POST">
                <input type="hidden" name="grade" value="Pre-university">
                <label class="text-sm text-[#006A71]">
                    <input type="checkbox" name="agree" class="form-checkbox text-teal-500" required>
                    Continue as Pre-University student
                </label>
                <br>
                <button type="submit" class="mt-2 text-white bg-teal-500 hover:bg-teal-600 px-3 py-1 rounded">Submit</button>
            </form>
                        <a   href="twelth.php" class=" text-teal-500 hover:underline">Learn More</a>
                    </div>

                </div>
            </div>
            <div class="timeline-entry">
                <div class="node"></div>
                <div class="content"><img src="uni.png" class="w-30 h-20">
                <h3 class="ml-2">Undergraduate (UG)</h3>
                    <p>Specialize in your field, gain practical experience, and plan career entry or further studies.</p>
                    <button id="toggle-3" class="key-actions" onclick="toggleDetails(3)">Click to see more details</button>
                    <div id="details-3" style="display: none;">
                        <ul>
                            <li>Choose major/minor wisely based on interests</li>
                            <li>Intern with industry experts</li>
                            <li>Build a professional network and resume</li>
                        </ul>
                        <form action="../includes/add_grade.php" method="POST">
                <input type="hidden" name="grade" value="UG">
                <label class="text-sm text-[#006A71]">
                    <input type="checkbox" name="agree" class="form-checkbox text-teal-500" required>
                    Continue as Under-Graduate
                </label>
                <br>
                <button type="submit" class="mt-2 text-white bg-teal-500 hover:bg-teal-600 px-3 py-1 rounded">Submit</button>
            </form>
                        <a class=" text-teal-500 hover:underline" href="ug.php">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="timeline-entry">
                <div class="node"></div>
                <div class="content"><img src="pg.png" class="w-30 h-20">
                <h3 class="ml-2">Postgraduate (PG)</h3>
                    <p>Develop deep expertise, pursue research or high-level roles, and refine long-term career goals.</p>
                    <button id="toggle-4" class="key-actions" onclick="toggleDetails(4)">Click to see more details</button>
                    <div id="details-4" style="display: none;">
                        <ul>
                            <li>Focus on specialization and thesis work</li>
                            <li>Publish papers or contribute to research</li>
                            <li>Attend conferences and pursue professional certifications</li>
                        </ul>
                        <form action="../includes/add_grade.php" method="POST">
                <input type="hidden" name="grade" value="PG">
                <label class="text-sm text-[#006A71]">
                    <input type="checkbox" name="agree" class="form-checkbox text-teal-500" required>
                    Continue as Postgraduate
                </label>
                <br>
                <button type="submit" class="mt-2 text-white bg-teal-500 hover:bg-teal-600 px-3 py-1 rounded">Submit</button>
            </form>
                        
                        <a class=" text-teal-500 hover:underline" href="../exams/pgtest.php">Learn More</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <section id="contact" class="py-10 bg-[#9ACBD0]">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold text-[#1D63FF] mb-4">Contact Us</h2>
      <p class="text-gray-700 mb-8">
        Reach out to our support team for questions, assistance, or
        collaboration.
      </p>
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 text-left">
        <div class="bg-[#F2EFE7]  p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-[#1D63FF] mb-2">
            <i class="fas fa-phone"></i> Prem Bhuvan
          </h3>
          <p class="text-gray-600">
            <i class="fas fa-phone-alt"></i> Phone:
            <a href="tel:+1234567890" class="text-blue-600 hover:underline">+91 447855570</a>
          </p>
          <p class="text-gray-600">
            <i class="fas fa-envelope"></i> Email:
            <a href="mailto:john@example.com" class="text-blue-600 hover:underline">bhuvan@example.com</a>
          </p>
        </div>
        <div class="bg-[#F2EFE7] p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-[#1D63FF] mb-2">
            <i class="fas fa-phone"></i> Pardhu
          </h3>
          <p class="text-gray-600">
            <i class="fas fa-phone-alt"></i> Phone:
            <a href="tel:+1987654321" class="text-blue-600 hover:underline">+91 447855570</a>
          </p>
          <p class="text-gray-600">
            <i class="fas fa-envelope"></i> Email:
            <a href="mailto:jane@example.com" class="text-blue-600 hover:underline">pardhu@example.com</a>
          </p>
        </div>
        <div class="bg-[#F2EFE7] p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-[#1D63FF] mb-2">
            <i class="fas fa-phone"></i> Bhargav
          </h3>
          <p class="text-gray-600">
            <i class="fas fa-phone-alt"></i> Phone:
            <a href="tel:+1123456789" class="text-blue-600 hover:underline">+91 447855570</a>
          </p>
          <p class="text-gray-600">
            <i class="fas fa-envelope"></i> Email:
            <a href="mailto:alex@example.com" class="text-blue-600 hover:underline">bhargav@example.com</a>
          </p>
        </div>
        <div class="bg-[#F2EFE7] p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-[#1D63FF] mb-2">
            <i class="fas fa-phone"></i> Rohit
          </h3>
          <p class="text-gray-600">
            <i class="fas fa-phone-alt"></i> Phone:
            <a href="tel:+1098765432" class="text-blue-600 hover:underline">+91 447855570</a>
          </p>
          <p class="text-gray-600">
            <i class="fas fa-envelope"></i> Email:
            <a href="mailto:priya@example.com" class="text-blue-600 hover:underline">rohit@example.com</a>
          </p>
        </div>
      </div>
    </div>
  </section>
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
  
  <script type="module" src="../assets/js/main.js"></script>
</body>
</html>
