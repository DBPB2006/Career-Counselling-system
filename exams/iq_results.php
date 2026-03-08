<?php
session_start();

// Check if user is logged in and has test results
if (!isset($_SESSION['email']) || !isset($_SESSION['iq_test_results'])) {
    header("Location: ../signup.php");
    exit();
}

// Get test results from session
$results = $_SESSION['iq_test_results'];
$score = $results['score'];
$iq_score = $results['iq_score'];

// Determine IQ category
function getIqCategory($score) {
    if ($score >= 130) return "Very Superior";
    if ($score >= 120) return "Superior";
    if ($score >= 110) return "High Average";
    if ($score >= 90) return "Average";
    if ($score >= 80) return "Low Average";
    if ($score >= 70) return "Borderline";
    return "Extremely Low";
}

$iq_category = getIqCategory($iq_score);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IQ Test Results - CopeUp</title>
    <link href="../output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .results-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .score-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .score-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #006A71, #48A6A7);
        }
        .iq-score {
            font-size: 4rem;
            font-weight: bold;
            color: #006A71;
            margin: 1rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding: 1rem;
            background: #f0f9ff;
            border-radius: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .category-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            background: #e6fffa;
            color: #006A71;
            font-weight: bold;
            margin: 1rem 0;
        }
        .recommendation-card {
            background: #f0f9ff;
            border-left: 4px solid #006A71;
            padding: 1.5rem;
            margin: 1rem 0;
            border-radius: 0 8px 8px 0;
        }
        .section-icon {
            font-size: 1.5rem;
            margin-right: 0.5rem;
            color: #006A71;
        }
        .recommendation-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .recommendation-list li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0;
            color: #4a5568;
        }
        .recommendation-list li i {
            color: #48A6A7;
        }
        .progress-ring {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }
        .progress-ring__circle {
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
        .progress-ring__circle--background {
            stroke: #e2e8f0;
        }
        .progress-ring__circle--progress {
            stroke: #006A71;
            transition: stroke-dashoffset 0.5s ease;
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
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['email']); ?></span>
            </div>
        </div>
    </header>

    <div class="results-container">
        <h1 class="text-3xl font-bold text-center text-[#006A71] mb-8">
            <i class="fas fa-chart-line section-icon"></i>Your IQ Test Results
        </h1>
        
        <div class="score-card">
            <h2 class="text-2xl font-semibold text-[#006A71] mb-4">
                <i class="fas fa-brain section-icon"></i>Your IQ Score
            </h2>
            <div class="iq-score">
                <i class="fas fa-star"></i>
                <?php echo round($iq_score); ?>
            </div>
            <div class="category-badge">
                <i class="fas fa-medal"></i>
                <?php echo $iq_category; ?>
            </div>
            <p class="text-gray-600">
                <i class="fas fa-check-circle mr-2"></i>You answered <?php echo $score; ?> out of 8 questions correctly
            </p>
        </div>

        <div class="recommendation-card">
            <h3 class="text-xl font-semibold text-[#006A71] mb-4">
                <i class="fas fa-lightbulb section-icon"></i>What This Means
            </h3>
            <p class="text-gray-700 mb-4">
                Your IQ score of <?php echo round($iq_score); ?> places you in the <?php echo strtolower($iq_category); ?> range.
                This indicates your cognitive abilities in various areas including verbal reasoning, numerical reasoning,
                spatial reasoning, and logical thinking.
            </p>
            
            <h3 class="text-xl font-semibold text-[#006A71] mb-4">
                <i class="fas fa-tasks section-icon"></i>Recommendations
            </h3>
            <ul class="recommendation-list">
                <li>
                    <i class="fas fa-puzzle-piece"></i>
                    Continue developing your problem-solving skills through puzzles and brain games
                </li>
                <li>
                    <i class="fas fa-brain"></i>
                    Engage in activities that challenge your logical thinking
                </li>
                <li>
                    <i class="fas fa-book-reader"></i>
                    Read books and articles that stimulate your mind
                </li>
                <li>
                    <i class="fas fa-calculator"></i>
                    Practice mathematical problems to strengthen numerical reasoning
                </li>
                <li>
                    <i class="fas fa-chart-bar"></i>
                    Consider taking more specialized aptitude tests to explore specific areas of interest
                </li>
            </ul>
        </div>

        <div class="text-center mt-8">
            <a href="../pages/tenth.php" class="inline-flex items-center bg-[#006A71] hover:bg-[#48A6A7] text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Return to Grade Selection
            </a>
        </div>
    </div>

   
</body>
</html> 