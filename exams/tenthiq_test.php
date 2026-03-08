<?php
session_start();
include '../includes/connect.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../signup.php");
    exit();
}

// Get user information
$email = $_SESSION['email'];
$sqlq = $conn->prepare("SELECT username, email FROM users WHERE email = ?");
$sqlq->bind_param("s", $email);
$sqlq->execute();
$result = $sqlq->get_result();
$user = $result->fetch_assoc();
$sqlq->close();

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Define correct answers
    $correct_answers = [
        'q1' => 'a', // Eating
        'q2' => 'b', // Carrot
        'q3' => 'b', // 32
        'q4' => 'a', // 5
        'q5' => 'a', // Square
        'q6' => 'b', // B
        'q7' => 'b', // Some cats are pets
        'q8' => 'a'  // 7185514
    ];

    // Calculate score
    $score = 0;
    $total_questions = count($correct_answers);
    $answers = [];

    foreach ($correct_answers as $question => $correct_answer) {
        if (isset($_POST[$question]) && $_POST[$question] === $correct_answer) {
            $score++;
        }
        $answers[$question] = isset($_POST[$question]) ? $_POST[$question] : 'unanswered';
    }

    // Calculate IQ score (this is a simplified version)
    $iq_score = ($score / $total_questions) * 100 + 80; // Base IQ of 80 + percentage of correct answers

    // Store results in session
    $_SESSION['iq_test_results'] = [
        'score' => $score,
        'iq_score' => $iq_score,
        'answers' => $answers,
        'test_date' => date('Y-m-d H:i:s')
    ];

    // Redirect to results page
    header("Location: iq_results.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Test - CopeUp</title>
    <link href="../output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .test-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .question-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        .question-card:hover {
            transform: translateY(-2px);
        }
        .timer {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #006A71;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
        }
        .progress-bar {
            height: 10px;
            background: #e2e8f0;
            border-radius: 5px;
            margin-bottom: 2rem;
        }
        .progress {
            height: 100%;
            background: #006A71;
            border-radius: 5px;
            transition: width 0.3s ease;
        }
        .option {
            padding: 1rem;
            margin: 0.5rem 0;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .option:hover {
            background: #f0f9ff;
            border-color: #006A71;
        }
        .option.selected {
            background: #e6fffa;
            border-color: #006A71;
        }
        .question-number {
            font-weight: bold;
            color: #006A71;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#006A71] via-[#48A6A7] to-[#9ACBD0]">
    <header class="bg-[#006A71] py-4">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <img src="../assets/images/realogo.png" class="w-10 h-10 rounded-full">
                <span class="text-[#F2EFE7] text-xl font-bold tracking-wide">CopeUp</span>
            </div>
            <div class="text-[#F2EFE7]">
                <span>Welcome, <?php echo htmlspecialchars($user['username']); ?></span>
            </div>
        </div>
    </header>

    <div class="test-container">
        <h1 class="text-3xl font-bold text-center text-[#006A71] mb-8">IQ Assessment Test</h1>
        
        <div class="progress-bar">
            <div class="progress" id="progress" style="width: 0%"></div>
        </div>

        <div id="timer" class="timer">Time: 30:00</div>

        <form id="iqTestForm" method="POST">
            <!-- Verbal Reasoning Section -->
            <div class="question-card" id="section1">
                <h2 class="text-xl font-semibold text-[#006A71] mb-4">Verbal Reasoning</h2>
                
                <div class="question mb-6">
                    <p class="mb-4"><span class="question-number">1.</span> Complete the analogy: Book is to Reading as Fork is to:</p>
                    <div class="options">
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q1" value="a" class="hidden">
                            <span>Eating</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q1" value="b" class="hidden">
                            <span>Cooking</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q1" value="c" class="hidden">
                            <span>Writing</span>
                        </div>
                    </div>
                </div>

                <div class="question mb-6">
                    <p class="mb-4"><span class="question-number">2.</span> Which word does not belong in this group: Apple, Banana, Carrot, Orange?</p>
                    <div class="options">
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q2" value="a" class="hidden">
                            <span>Apple</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q2" value="b" class="hidden">
                            <span>Carrot</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q2" value="c" class="hidden">
                            <span>Orange</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Numerical Reasoning Section -->
            <div class="question-card" id="section2">
                <h2 class="text-xl font-semibold text-[#006A71] mb-4">Numerical Reasoning</h2>
                
                <div class="question mb-6">
                    <p class="mb-4"><span class="question-number">3.</span> What number comes next in the sequence: 2, 4, 8, 16, ?</p>
                    <div class="options">
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q3" value="a" class="hidden">
                            <span>24</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q3" value="b" class="hidden">
                            <span>32</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q3" value="c" class="hidden">
                            <span>28</span>
                        </div>
                    </div>
                </div>

                <div class="question mb-6">
                    <p class="mb-4"><span class="question-number">4.</span> If 3x + 7 = 22, what is the value of x?</p>
                    <div class="options">
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q4" value="a" class="hidden">
                            <span>5</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q4" value="b" class="hidden">
                            <span>6</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q4" value="c" class="hidden">
                            <span>7</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Spatial Reasoning Section -->
            <div class="question-card" id="section3">
                <h2 class="text-xl font-semibold text-[#006A71] mb-4">Spatial Reasoning</h2>
                
                <div class="question mb-6">
                    <p class="mb-4"><span class="question-number">5.</span> Which shape completes the pattern?</p>
                    <div class="options">
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q5" value="a" class="hidden">
                            <span>Square</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q5" value="b" class="hidden">
                            <span>Circle</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q5" value="c" class="hidden">
                            <span>Triangle</span>
                        </div>
                    </div>
                </div>

                <div class="question mb-6">
                    <p class="mb-4"><span class="question-number">6.</span> If you fold this net into a cube, which face will be opposite to the face marked 'X'?</p>
                    <div class="options">
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q6" value="a" class="hidden">
                            <span>A</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q6" value="b" class="hidden">
                            <span>B</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q6" value="c" class="hidden">
                            <span>C</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logical Reasoning Section -->
            <div class="question-card" id="section4">
                <h2 class="text-xl font-semibold text-[#006A71] mb-4">Logical Reasoning</h2>
                
                <div class="question mb-6">
                    <p class="mb-4"><span class="question-number">7.</span> If all cats are animals, and some animals are pets, then:</p>
                    <div class="options">
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q7" value="a" class="hidden">
                            <span>All cats are pets</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q7" value="b" class="hidden">
                            <span>Some cats are pets</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q7" value="c" class="hidden">
                            <span>No cats are pets</span>
                        </div>
                    </div>
                </div>

                <div class="question mb-6">
                    <p class="mb-4"><span class="question-number">8.</span> If RED is coded as 1854, and BLUE is coded as 212215, how would GREEN be coded?</p>
                    <div class="options">
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q8" value="a" class="hidden">
                            <span>7185514</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q8" value="b" class="hidden">
                            <span>7185513</span>
                        </div>
                        <div class="option" onclick="selectOption(this)">
                            <input type="radio" name="q8" value="c" class="hidden">
                            <span>7185515</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <button type="button" onclick="previousSection()" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <button type="button" onclick="nextSection()" class="bg-[#006A71] hover:bg-[#48A6A7] text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>

            <div class="text-center mt-8">
                <button type="submit" class="bg-[#006A71] hover:bg-[#48A6A7] text-white font-bold py-3 px-6 rounded-lg">
                    Submit Test
                </button>
            </div>
        </form>
    </div>

    <script>
        let currentSection = 1;
        const totalSections = 4;
        let timeLeft = 30 * 60; // 30 minutes in seconds
        const timer = document.getElementById('timer');
        const progress = document.getElementById('progress');

        // Timer functionality
        const timerInterval = setInterval(() => {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timer.textContent = `Time: ${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                document.getElementById('iqTestForm').submit();
            }
        }, 1000);

        // Update progress bar
        function updateProgress() {
            const progressPercentage = (currentSection / totalSections) * 100;
            progress.style.width = `${progressPercentage}%`;
        }

        // Show/hide sections
        function showSection(sectionNumber) {
            document.querySelectorAll('.question-card').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(`section${sectionNumber}`).style.display = 'block';
            currentSection = sectionNumber;
            updateProgress();
        }

        // Navigation functions
        function nextSection() {
            if (currentSection < totalSections) {
                showSection(currentSection + 1);
            }
        }

        function previousSection() {
            if (currentSection > 1) {
                showSection(currentSection - 1);
            }
        }

        // Option selection
        function selectOption(element) {
            const options = element.parentElement.querySelectorAll('.option');
            options.forEach(opt => opt.classList.remove('selected'));
            element.classList.add('selected');
            const radio = element.querySelector('input[type="radio"]');
            radio.checked = true;
        }

        // Initialize first section
        showSection(1);
    </script>
</body>
</html> 