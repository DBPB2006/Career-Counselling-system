<?php
include 'includes/auth_check.php';
include 'includes/connect.php';

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
  <title>CopeUp</title>
  <link href="./output.css" rel="stylesheet" />
  <style>
    html {
      scroll-behavior: smooth;
    }
    .hero-image {
      background: linear-gradient(rgba(73, 209, 219, 0.8), rgba(72, 166, 167, 0.8)), url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
      background-size: cover;
      background-position: center;
      min-height: 80vh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
    }
    

    .trending-careers {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      margin: 2rem 0;
    }
    .career-card {
      background: white;
      padding: 1.5rem;
      border-radius: 1rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease;
    }
    .career-card:hover {
      transform: translateY(-5px);
    }
    .resources-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
      margin: 2rem 0;
    }
    .resource-card {
      background: white;
      padding: 1.5rem;
      border-radius: 1rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .animate-on-scroll {
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }
    .animate-on-scroll.visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    
  </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <script>
    function openProfilePage() {
      window.location.href = "pages/profile.php"; 
    }
    document.addEventListener('DOMContentLoaded', function() {
      const counters = document.querySelectorAll('.counter-number');
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            if (entry.target.classList.contains('counter-number')) {
              animateCounter(entry.target);
            }
          }
        });
      }, { threshold: 0.5 });

      document.querySelectorAll('.animate-on-scroll').forEach(el => observer.observe(el));

      function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
          current += step;
          if (current < target) {
            element.textContent = Math.floor(current);
            requestAnimationFrame(updateCounter);
          } else {
            element.textContent = target;
          }
        };

        updateCounter();
      }
    });
  </script>
</head>

<body class="bg-gradient-to-r from-[#006A71] to-[#9ACBD0]">
  <header class="bg-[#006A71] py-4">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
      <div class="flex items-center space-x-2">
        <img src="assets/images/realogo.png" class="w-10 h-10 rounded-full">
        <span class="text-white text-xl font-bold tracking-wide">CopeUp</span>
      </div>
      <nav class="hidden md:flex space-x-6 text-white text-sm font-medium">
        <a href="home.php" class="nav-link hover:text-[#48A6A7] hover:border-b-2 hover:border-[#48A6A7] transition-all duration-300">
          <i class="fas fa-home"></i>
          <span>Home</span>
        </a>
        <a href="#explore-careers" class="nav-link hover:text-[#48A6A7] hover:border-b-2 hover:border-[#48A6A7] transition-all duration-300">
          <i class="fas fa-search"></i>
          <span>Explore Careers</span>
        </a>
        <a href="#about" class="nav-link hover:text-[#48A6A7] hover:border-b-2 hover:border-[#48A6A7] transition-all duration-300">
          <i class="fas fa-info-circle"></i>
          <span>About</span>
        </a>
        <a href="#contact" class="nav-link hover:text-[#48A6A7] hover:border-b-2 hover:border-[#48A6A7] transition-all duration-300">
          <i class="fas fa-envelope"></i>
          <span>Contact</span>
        </a>
      </nav>
      <div class="relative group" aria-label="User profile dropdown">
        <button class="text-white border border-white px-4 py-2 rounded hover:bg-[#006A71] hover:text-white transition flex items-center gap-2" ondblclick="openProfilePage()">
          <i class="fas fa-user"></i>
          <p>Profile</p>
        </button>
        <div class="absolute right-0 mt-2 w-64 bg-white text-[#006A71] rounded-lg shadow-lg opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-opacity duration-200 z-50">
          <div class="p-4 border-b">
            <div class="flex items-center space-x-3">
              <div class="w-12 h-12 bg-[#006A71] text-white rounded-full flex items-center justify-center text-lg font-semibold">
                <?php echo strtoupper($name[0]); ?>
              </div>
              <div>
                <p class="font-medium"><?php echo $name; ?></p>
                <p class="text-sm text-[#48A6A7]"><?php echo $userEmail; ?></p>
              </div>
            </div>
          </div>
          <div class="p-4">
            <a href="includes/logout.php" class="block text-center bg-[#006A71] hover:bg-[#48A6A7] text-white font-semibold px-4 py-2 rounded transition">
              Logout
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
  <section class="hero-image">
    <div class="max-w-7xl mx-auto px-6">
      <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
        Shape Your Future with Smart Career Guidance
      </h1>
      <p class="text-xl text-white max-w-3xl mx-auto mb-8">
        Explore paths, discover your strengths, and find a career that fits your dreams
      </p>
      <a href="pages/grade.php" class="inline-block bg-white text-[#006A71] font-bold px-8 py-4 rounded-lg transition hover:bg-[#48A6A7]">
        Start Your Journey
      </a>
    </div>
  </section>
  <section class="py-24 bg-gradient-to-r from-[#9ACBD0] to-[#72BAA9]" id="explore-careers">
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-4xl font-bold text-center text-white mb-12">Explore Your Career Path</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-[#F2EFE7] p-8 rounded-xl shadow-xl">
          <h3 class="text-2xl font-semibold text-center text-[#006A71] mb-6">Find Your Future Career</h3>
          <form method="POST" action="#career-form-1" class="space-y-6">
            <div>
              <label class="block text-lg font-semibold text-[#006A71] mb-3">Which subjects do you enjoy the most?</label>
              <div class="grid grid-cols-2 gap-4">
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="subjects[]" value="science" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['subjects']) && in_array('science', $_POST['subjects'])) echo 'checked'; ?> />
                  <span>Science</span>
                </label>
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="subjects[]" value="maths" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['subjects']) && in_array('maths', $_POST['subjects'])) echo 'checked'; ?> />
                  <span>Mathematics</span>
                </label>
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="subjects[]" value="computers" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['subjects']) && in_array('computers', $_POST['subjects'])) echo 'checked'; ?> />
                  <span>Computers</span>
                </label>
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="subjects[]" value="arts" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['subjects']) && in_array('arts', $_POST['subjects'])) echo 'checked'; ?> />
                  <span>Arts & Design</span>
                </label>
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="subjects[]" value="commerce" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['subjects']) && in_array('commerce', $_POST['subjects'])) echo 'checked'; ?> />
                  <span>Commerce</span>
                </label>
              </div>
            </div>
            <div>
              <label class="block text-lg font-semibold text-[#006A71] mb-3">What activities do you enjoy?</label>
              <div class="grid grid-cols-2 gap-4">
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="activities[]" value="problemsolving" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['activities']) && in_array('problemsolving', $_POST['activities'])) echo 'checked'; ?> />
                  <span>Solving Puzzles</span>
                </label>
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="activities[]" value="creative" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['activities']) && in_array('creative', $_POST['activities'])) echo 'checked'; ?> />
                  <span>Drawing or Designing</span>
                </label>
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="activities[]" value="leadership" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['activities']) && in_array('leadership', $_POST['activities'])) echo 'checked'; ?> />
                  <span>Leading Teams</span>
                </label>
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="activities[]" value="tech" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['activities']) && in_array('tech', $_POST['activities'])) echo 'checked'; ?> />
                  <span>Exploring Tech</span>
                </label>
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="activities[]" value="helping" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['activities']) && in_array('helping', $_POST['activities'])) echo 'checked'; ?> />
                  <span>Helping Others</span>
                </label>
              </div>
            </div>
            <div>
              <label class="block text-lg font-semibold text-[#006A71] mb-3">What are your future dreams?</label>
              <div class="grid grid-cols-2 gap-4">
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="dreams[]" value="engineer" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['dreams']) && in_array('engineer', $_POST['dreams'])) echo 'checked'; ?> />
                  <span>Engineer</span>
                </label>
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="dreams[]" value="doctor" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['dreams']) && in_array('doctor', $_POST['dreams'])) echo 'checked'; ?> />
                  <span>Doctor</span>
                </label>
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="dreams[]" value="scientist" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['dreams']) && in_array('scientist', $_POST['dreams'])) echo 'checked'; ?> />
                  <span>Scientist</span>
                </label>
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="dreams[]" value="artist" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['dreams']) && in_array('artist', $_POST['dreams'])) echo 'checked'; ?> />
                  <span>Artist / Designer</span>
                </label>
                <label class="text-[#006A71] flex items-center space-x-2">
                  <input type="checkbox" name="dreams[]" value="entrepreneur" class="w-4 h-4 text-[#006A71] border-[#006A71] rounded focus:ring-[#006A71]" <?php if (isset($_POST['dreams']) && in_array('entrepreneur', $_POST['dreams'])) echo 'checked'; ?> />
                  <span>Start a Business</span>
                </label>
              </div>
            </div>
            <input type="hidden" name="form_type" value="career1">
            <div class="text-center">
              <button type="submit" class="mt-6 bg-[#006A71] hover:bg-[#48A6A7] text-white font-bold px-6 py-3 rounded-lg transition">
                Show My Career Suggestions
              </button>
            </div>
          </form>

          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] == 'career1') {
              $subjects = isset($_POST['subjects']) ? $_POST['subjects'] : [];
              $activities = isset($_POST['activities']) ? $_POST['activities'] : [];
              $dreams = isset($_POST['dreams']) ? $_POST['dreams'] : [];

              echo '<div class="mt-8">';
              echo '<h3 class="text-xl font-bold text-center text-[#006A71] mb-4">Your Career Suggestions</h3>';

              if (empty($subjects) && empty($activities) && empty($dreams)) {
                  echo '<p class="text-center text-red-600">Please select at least one option!</p>';
              } else {
                  echo '<ul class="list-disc pl-6 space-y-2 text-[#006A71]">';
                  if (in_array('science', $subjects) && in_array('engineer', $dreams)) {
                      echo '<li>Engineering (Mechanical, Electrical, Computer, Civil)</li>';
                  }
                  if (in_array('doctor', $dreams) || (in_array('science', $subjects) && in_array('helping', $activities))) {
                      echo '<li>Medical Career (Doctor, Nurse, Therapist)</li>';
                  }
                  if (in_array('arts', $subjects) || in_array('creative', $activities)) {
                      echo '<li>Creative Fields (Graphic Designer, Animator, Architect)</li>';
                  }
                  if (in_array('maths', $subjects) && in_array('problemsolving', $activities)) {
                      echo '<li>Data Analyst or Mathematician</li>';
                  }
                  if (in_array('computers', $subjects) || in_array('tech', $activities)) {
                      echo '<li>Software Engineer / Game Developer / IT Specialist</li>';
                  }
                  if (in_array('entrepreneur', $dreams) || in_array('leadership', $activities)) {
                      echo '<li>Entrepreneur / Startup Founder</li>';
                  }
                  if (in_array('scientist', $dreams)) {
                      echo '<li>Research Scientist</li>';
                  }
                  echo '</ul>';
              }
              echo '</div>';
          }
          ?>
        </div>

        <!-- Form 2: Get Career Guidance -->
        <div class="bg-[#F2EFE7] p-8 rounded-xl shadow-xl z-10 relative">
          <h3 class="text-2xl font-semibold text-center text-[#006A71] mb-6">Get Career Guidance</h3>
          <form method="POST" action="#career-form-2" class="space-y-6">
            <div>
              <label class="block text-lg font-semibold text-[#006A71] mb-3">Which subjects do you feel confident in?</label>
              <div class="grid grid-cols-2 gap-4">
                <label class="text-[#006A71]"><input type="checkbox" name="subjects[]" value="physics" <?php if (isset($_POST['subjects']) && in_array('physics', $_POST['subjects'])) echo 'checked'; ?> /> Physics</label>
                <label class="text-[#006A71]"><input type="checkbox" name="subjects[]" value="chemistry" <?php if (isset($_POST['subjects']) && in_array('chemistry', $_POST['subjects'])) echo 'checked'; ?> /> Chemistry</label>
                <label class="text-[#006A71]"><input type="checkbox" name="subjects[]" value="biology" <?php if (isset($_POST['subjects']) && in_array('biology', $_POST['subjects'])) echo 'checked'; ?> /> Biology</label>
                <label class="text-[#006A71]"><input type="checkbox" name="subjects[]" value="computers" <?php if (isset($_POST['subjects']) && in_array('computers', $_POST['subjects'])) echo 'checked'; ?> /> Computer Applications</label>
                <label class="text-[#006A71]"><input type="checkbox" name="subjects[]" value="business" <?php if (isset($_POST['subjects']) && in_array('business', $_POST['subjects'])) echo 'checked'; ?> /> Business Studies</label>
                <label class="text-[#006A71]"><input type="checkbox" name="subjects[]" value="arts" <?php if (isset($_POST['subjects']) && in_array('arts', $_POST['subjects'])) echo 'checked'; ?> /> Arts / Design</label>
              </div>
            </div>
            <div>
              <label class="block text-lg font-semibold text-[#006A71] mb-3">What tasks do you enjoy?</label>
              <div class="grid grid-cols-2 gap-4">
                <label class="text-[#006A71]"><input type="checkbox" name="activities[]" value="building" <?php if (isset($_POST['activities']) && in_array('building', $_POST['activities'])) echo 'checked'; ?> /> Building or Fixing Things</label>
                <label class="text-[#006A71]"><input type="checkbox" name="activities[]" value="coding" <?php if (isset($_POST['activities']) && in_array('coding', $_POST['activities'])) echo 'checked'; ?> /> Writing Code / Puzzles</label>
                <label class="text-[#006A71]"><input type="checkbox" name="activities[]" value="designing" <?php if (isset($_POST['activities']) && in_array('designing', $_POST['activities'])) echo 'checked'; ?> /> Sketching or Designing</label>
                <label class="text-[#006A71]"><input type="checkbox" name="activities[]" value="leading" <?php if (isset($_POST['activities']) && in_array('leading', $_POST['activities'])) echo 'checked'; ?> /> Leading Teams</label>
                <label class="text-[#006A71]"><input type="checkbox" name="activities[]" value="researching" <?php if (isset($_POST['activities']) && in_array('researching', $_POST['activities'])) echo 'checked'; ?> /> Researching Ideas</label>
                <label class="text-[#006A71]"><input type="checkbox" name="activities[]" value="helping" <?php if (isset($_POST['activities']) && in_array('helping', $_POST['activities'])) echo 'checked'; ?> /> Helping People</label>
              </div>
            </div>
            <div>
              <label class="block text-lg font-semibold text-[#006A71] mb-3">What's your future vision?</label>
              <div class="grid grid-cols-2 gap-4">
                <label class="text-[#006A71]"><input type="checkbox" name="dreams[]" value="invent" <?php if (isset($_POST['dreams']) && in_array('invent', $_POST['dreams'])) echo 'checked'; ?> /> Invent or Build Solutions</label>
                <label class="text-[#006A71]"><input type="checkbox" name="dreams[]" value="health" <?php if (isset($_POST['dreams']) && in_array('health', $_POST['dreams'])) echo 'checked'; ?> /> Solve Health Problems</label>
                <label class="text-[#006A71]"><input type="checkbox" name="dreams[]" value="explore" <?php if (isset($_POST['dreams']) && in_array('explore', $_POST['dreams'])) echo 'checked'; ?> /> Explore How the World Works</label>
                <label class="text-[#006A71]"><input type="checkbox" name="dreams[]" value="create" <?php if (isset($_POST['dreams']) && in_array('create', $_POST['dreams'])) echo 'checked'; ?> /> Create Beautiful Designs</label>
                <label class="text-[#006A71]"><input type="checkbox" name="dreams[]" value="startup" <?php if (isset($_POST['dreams']) && in_array('startup', $_POST['dreams'])) echo 'checked'; ?> /> Run a Business</label>
                <label class="text-[#006A71]"><input type="checkbox" name="dreams[]" value="tech" <?php if (isset($_POST['dreams']) && in_array('tech', $_POST['dreams'])) echo 'checked'; ?> /> Develop New Technologies</label>
              </div>
            </div>
            <input type="hidden" name="form_type" value="career2">
            <div class="text-center">
              <button type="submit" class="mt-6 bg-[#006A71] hover:bg-[#48A6A7] text-white font-bold px-6 py-3 rounded-lg transition">
                Show My Career Suggestions
              </button>
            </div>
          </form>

          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] == 'career2') {
              $subjects = isset($_POST['subjects']) ? $_POST['subjects'] : [];
              $activities = isset($_POST['activities']) ? $_POST['activities'] : [];
              $dreams = isset($_POST['dreams']) ? $_POST['dreams'] : [];

              echo '<div class="mt-8">';
              echo '<h3 class="text-xl font-bold text-center text-[#006A71] mb-4">Your Career Suggestions</h3>';

              if (empty($subjects) && empty($activities) && empty($dreams)) {
                  echo '<p class="text-center text-red-600">Please select at least one option!</p>';
              } else {
                  echo '<ul class="list-disc pl-6 space-y-2 text-[#006A71]">';
                  if (in_array('computers', $subjects) || in_array('coding', $activities) || in_array('tech', $dreams)) {
                      echo '<li>Computer Science / Software Engineering</li>';
                  }
                  if ((in_array('physics', $subjects) || in_array('math', $subjects)) && in_array('building', $activities)) {
                      echo '<li>Engineering — Mechanical, Electrical, or Civil</li>';
                  }
                  if (in_array('biology', $subjects) || in_array('health', $dreams)) {
                      echo '<li>Medical Sciences — Doctor, Biotech, Pharmacy</li>';
                  }
                  if (in_array('arts', $subjects) || in_array('designing', $activities) || in_array('create', $dreams)) {
                      echo '<li>Design — Graphic, UI/UX, Animation, Fine Arts</li>';
                  }
                  if (in_array('business', $subjects) || in_array('business', $activities) || in_array('startup', $dreams)) {
                      echo '<li>Business — Management, Entrepreneurship, Commerce</li>';
                  }
                  if (in_array('researching', $activities) || in_array('explore', $dreams)) {
                      echo '<li>Pure Sciences — Physics, Chemistry, Mathematics</li>';
                  }
                  echo '</ul>';
              }
              echo '</div>';
          }
          ?>
        </div>

        <!-- Form 3: Plan Your Next Step -->
        <div class="bg-[#F2EFE7] p-8 rounded-xl shadow-xl">
          <h3 class="text-2xl font-semibold text-center text-[#006A71] mb-6">Plan Your Next Step</h3>
          <form method="POST" action="#career-form-3" class="space-y-6">
            <div>
              <label class="block text-lg font-semibold text-[#006A71] mb-3">Which field did you specialize in?</label>
              <div class="grid grid-cols-2 gap-4">
                <label class="text-[#006A71]"><input type="checkbox" name="degree[]" value="cse" <?php if (isset($_POST['degree']) && in_array('cse', $_POST['degree'])) echo 'checked'; ?> /> Computer Science / IT</label>
                <label class="text-[#006A71]"><input type="checkbox" name="degree[]" value="engineering" <?php if (isset($_POST['degree']) && in_array('engineering', $_POST['degree'])) echo 'checked'; ?> /> Engineering (Non-CS)</label>
                <label class="text-[#006A71]"><input type="checkbox" name="degree[]" value="management" <?php if (isset($_POST['degree']) && in_array('management', $_POST['degree'])) echo 'checked'; ?> /> Business / Management</label>
                <label class="text-[#006A71]"><input type="checkbox" name="degree[]" value="arts" <?php if (isset($_POST['degree']) && in_array('arts', $_POST['degree'])) echo 'checked'; ?> /> Arts / Humanities</label>
                <label class="text-[#006A71]"><input type="checkbox" name="degree[]" value="science" <?php if (isset($_POST['degree']) && in_array('science', $_POST['degree'])) echo 'checked'; ?> /> Pure Sciences</label>
                <label class="text-[#006A71]"><input type="checkbox" name="degree[]" value="medical" <?php if (isset($_POST['degree']) && in_array('medical', $_POST['degree'])) echo 'checked'; ?> /> Medical / Life Sciences</label>
              </div>
            </div>
            <div>
              <label class="block text-lg font-semibold text-[#006A71] mb-3">What activities did you enjoy?</label>
              <div class="grid grid-cols-2 gap-4">
                <label class="text-[#006A71]"><input type="checkbox" name="experience[]" value="projects" <?php if (isset($_POST['experience']) && in_array('projects', $_POST['experience'])) echo 'checked'; ?> /> Real-World Projects</label>
                <label class="text-[#006A71]"><input type="checkbox" name="experience[]" value="research" <?php if (isset($_POST['experience']) && in_array('research', $_POST['experience'])) echo 'checked'; ?> /> Academic Research</label>
                <label class="text-[#006A71]"><input type="checkbox" name="experience[]" value="startup" <?php if (isset($_POST['experience']) && in_array('startup', $_POST['experience'])) echo 'checked'; ?> /> Startup Activities</label>
                <label class="text-[#006A71]"><input type="checkbox" name="experience[]" value="internship" <?php if (isset($_POST['experience']) && in_array('internship', $_POST['experience'])) echo 'checked'; ?> /> Industry Internships</label>
                <label class="text-[#006A71]"><input type="checkbox" name="experience[]" value="design" <?php if (isset($_POST['experience']) && in_array('design', $_POST['experience'])) echo 'checked'; ?> /> Designing or Creative Work</label>
                <label class="text-[#006A71]"><input type="checkbox" name="experience[]" value="community" <?php if (isset($_POST['experience']) && in_array('community', $_POST['experience'])) echo 'checked'; ?> /> Community Service</label>
              </div>
            </div>
            <div>
              <label class="block text-lg font-semibold text-[#006A71] mb-3">What's your next move?</label>
              <div class="grid grid-cols-2 gap-4">
                <label class="text-[#006A71]"><input type="checkbox" name="plans[]" value="pg" <?php if (isset($_POST['plans']) && in_array('pg', $_POST['plans'])) echo 'checked'; ?> /> Pursue Post-Graduation</label>
                <label class="text-[#006A71]"><input type="checkbox" name="plans[]" value="job" <?php if (isset($_POST['plans']) && in_array('job', $_POST['plans'])) echo 'checked'; ?> /> Start Working</label>
                <label class="text-[#006A71]"><input type="checkbox" name="plans[]" value="freelance" <?php if (isset($_POST['plans']) && in_array('freelance', $_POST['plans'])) echo 'checked'; ?> /> Freelancing</label>
                <label class="text-[#006A71]"><input type="checkbox" name="plans[]" value="startup" <?php if (isset($_POST['plans']) && in_array('startup', $_POST['plans'])) echo 'checked'; ?> /> Launch a Startup</label>
                <label class="text-[#006A71]"><input type="checkbox" name="plans[]" value="research" <?php if (isset($_POST['plans']) && in_array('research', $_POST['plans'])) echo 'checked'; ?> /> Enter Research / PhD</label>
              </div>
            </div>
            <input type="hidden" name="form_type" value="career3">
            <div class="text-center">
              <button type="submit" class="mt-6 bg-[#006A71] hover:bg-[#48A6A7] text-white font-bold px-6 py-3 rounded-lg transition">
                Show My Career Path
              </button>
            </div>
          </form>

          <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['form_type']) && $_POST['form_type'] == 'career3') {
              $degree = isset($_POST['degree']) ? $_POST['degree'] : [];
              $experience = isset($_POST['experience']) ? $_POST['experience'] : [];
              $plans = isset($_POST['plans']) ? $_POST['plans'] : [];

              echo '<div class="mt-8">';
              echo '<h3 class="text-xl font-bold text-center text-[#006A71] mb-4">Recommended Path for You</h3>';

              if (empty($degree) && empty($experience) && empty($plans)) {
                  echo '<p class="text-center text-red-600">Please select at least one option!</p>';
              } else {
                  echo '<ul class="list-disc pl-6 space-y-2 text-[#006A71]">';
                  if (in_array('cse', $degree)) {
                      echo '<li>Software Roles: Developer, Data Analyst, or Master\'s in AI/Data Science</li>';
                  }
                  if (in_array('engineering', $degree)) {
                      echo '<li>Core Engineering Jobs, M.Tech, or MBA</li>';
                  }
                  if (in_array('medical', $degree)) {
                      echo '<li>Medical PG (MD/MS), Clinical Research, or Healthcare Analytics</li>';
                  }
                  if (in_array('management', $degree)) {
                      echo '<li>Corporate Roles or MBA for Career Growth</li>';
                  }
                  if (in_array('research', $experience)) {
                      echo '<li>PhD or Research-Oriented Industry Roles</li>';
                  }
                  if (in_array('projects', $experience) && in_array('job', $plans)) {
                      echo '<li>Industry Career with Project Experience</li>';
                  }
                  if (in_array('startup', $experience) || in_array('startup', $plans)) {
                      echo '<li>Entrepreneurship or Early-Stage Startups</li>';
                  }
                  if (in_array('pg', $plans)) {
                      echo "<li>Master's / MBA for Specialization</li>";
                  }
                  if (in_array('freelance', $plans)) {
                      echo '<li>Freelancing with a Strong Portfolio</li>';
                  }
                  echo '</ul>';
              }
              echo '</div>';
          }
          ?>
        </div>
      </div>
    </div>
  </section>  
  <section class="bg-[#9ACBD0] py-20">
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-3xl font-bold text-[#006A71] mb-8 text-center">Trending Careers</h2>
      <div class="trending-careers">
        <div class="career-card animate-on-scroll">
          <div class="w-16 h-16 bg-[#006A71] rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-laptop-code text-white text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-[#006A71] mb-2">AI & Machine Learning</h3>
          <p class="text-gray-600 mb-4">High demand for professionals in artificial intelligence and machine learning.</p>
          <a href="#" class="text-[#006A71] hover:text-[#48A6A7] font-medium">Explore Path →</a>
        </div>
        <div class="career-card animate-on-scroll">
          <div class="w-16 h-16 bg-[#006A71] rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-heartbeat text-white text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-[#006A71] mb-2">Healthcare</h3>
          <p class="text-gray-600 mb-4">Growing opportunities in medical and healthcare fields.</p>
          <a href="#" class="text-[#006A71] hover:text-[#48A6A7] font-medium">Explore Path →</a>
        </div>
        <div class="career-card animate-on-scroll">
          <div class="w-16 h-16 bg-[#006A71] rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-chart-line text-white text-2xl"></i>
          </div>
          <h3 class="text-xl font-bold text-[#006A71] mb-2">Data Science</h3>
          <p class="text-gray-600 mb-4">Exciting career opportunities in data analysis and business intelligence.</p>
          <a href="#" class="text-[#006A71] hover:text-[#48A6A7] font-medium">Explore Path →</a>
        </div>
      </div>
    </div>
  </section>

  <section class="py-20 bg-gradient-to-r from-[#9ACBD0] to-[#72BAA9]">
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-3xl font-bold text-[#006A71] mb-8 text-center">Resources & Guides</h2>
      <div class="resources-grid">
        <div class="resource-card animate-on-scroll">
          <h3 class="text-xl font-bold text-[#006A71] mb-4">Career Planning Guide</h3>
          <p class="text-[#006A71] mb-4">Step-by-step guide to planning your career path and making informed decisions.</p>
          <a href="#" class="text-[#006A71] hover:text-[#48A6A7] font-medium">Read More →</a>
        </div>
        <div class="resource-card animate-on-scroll">
          <h3 class="text-xl font-bold text-[#006A71] mb-4">Skill Development</h3>
          <p class="text-[#006A71] mb-4">Essential skills for future careers and how to develop them.</p>
          <a href="#" class="text-[#006A71] hover:text-[#48A6A7] font-medium">Read More →</a>
        </div>
        <div class="resource-card animate-on-scroll">
          <h3 class="text-xl font-bold text-[#006A71] mb-4">College Selection</h3>
          <p class="text-[#006A71] mb-4">How to choose the right college and program for your career goals.</p>
          <a href="#" class="text-[#006A71] hover:text-[#48A6A7] font-medium">Read More →</a>
        </div>
      </div>
    </div>
  </section>

  <section class="py-20 bg-gradient-to-r from-[#9ACBD0] to-[#72BAA9] text-white">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold mb-6">Ready to Start Your Career Journey?</h2>
      <p class="text-xl mb-8">Take our comprehensive assessment and get personalized career guidance.</p>
      <a href="pages/grade.php" class="inline-block bg-white text-[#006A71] font-bold px-8 py-4 rounded-lg transition hover:bg-[#9ACBD0]">
        Begin Assessment
      </a>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="bg-gradient-to-r from-[#9ACBD0] to-[#72BAA9] py-20">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold text-[#006A71] mb-4">About CopeUp</h2>
      <p class="text-[#006A71] text-lg mb-8">
        Cope Up is a smart career counseling platform designed to help
        students, job seekers, and career changers find their ideal career
        paths using artificial intelligence and expert insights.
      </p>
      <div class="grid md:grid-cols-3 gap-8 text-left">
        <!-- 6 Info Cards -->
        <div class="bg-[#F2EFE7] p-6 rounded-xl hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-[#006A71] mb-2">
            <i class="fas fa-robot text-[#006A71]"></i> What We Do
          </h3>
          <p class="text-[#006A71]">We analyze your interests, skills, personality, and goals to recommend career options, suitable courses, colleges, and industry insights — all on a personalized AI dashboard.</p>
        </div>
        <div class="bg-[#F2EFE7] p-6 rounded-xl hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-[#006A71] mb-2">
            <i class="fas fa-bullseye text-[#006A71]"></i> Our Mission
          </h3>
          <p class="text-[#006A71]">Our mission is to bridge the gap between ambition and action by providing accessible, accurate, and tailored career advice — anytime, anywhere.</p>
        </div>
        <div class="bg-[#F2EFE7] p-6 rounded-xl hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-[#006A71] mb-2">
            <i class="fas fa-users text-[#006A71]"></i> Who It's For
          </h3>
          <p class="text-[#006A71]">Whether you're a high school student choosing a stream, a college student exploring jobs, or a professional switching careers — CareerGuideAI is built for you.</p>
        </div>
        <div class="bg-[#F2EFE7] p-6 rounded-xl hover:shadow-lg transition">
          <h3 class="text-xl special-font font-semibold text-[#006A71] mb-2">
            <i class="fas fa-brain text-[#006A71]"></i> How It Works
          </h3>
          <p class="text-[#006A71] body-font">Through a series of assessments and AI-powered analysis, we generate real-time insights and match you with careers, courses, mentors, and resources that align with your strengths.</p>
        </div>
        <div class="bg-[#F2EFE7] p-6 rounded-xl hover:shadow-lg transition">
          <h3 class="text-xl special-font font-semibold text-[#006A71] mb-2">
            <i class="fas fa-lightbulb text-[#006A71]"></i> Why Choose Us
          </h3>
          <p class="text-[#006A71] body-font">Unlike generic career portals, we offer dynamic guidance that evolves with your growth, giving you control and clarity over your future.</p>
        </div>
        <div class="bg-[#F2EFE7] p-6 rounded-xl hover:shadow-lg transition">
          <h3 class="text-xl special-font font-semibold text-[#006A71] mb-2">
            <i class="fas fa-rocket text-[#006A71]"></i> Future Ready
          </h3>
          <p class="text-[#006A71] body-font">We stay updated with industry trends, future skills, and global job data — so your journey is always aligned with what's next.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="bg-gradient-to-r from-[#9ACBD0] to-[#72BAA9] py-20">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold text-[#006A71] mb-4">Contact Us</h2>
      <p class="text-[#006A71] mb-8">
        Reach out to our support team for questions, assistance, or collaboration.
      </p>
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 text-left">
        <div class="bg-[#F2EFE7] p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-[#006A71] mb-2">
            <i class="fas fa-phone text-[#006A71]"></i> Prem Bhuvan
          </h3>
          <p class="text-[#006A71]">
            <i class="fas fa-phone-alt mr-2 text-[#006A71]"></i>Phone: 
            <a href="tel:+1234567890" class="text-[#006A71] hover:text-[#48A6A7]">+1 234 567 890</a>
          </p>
          <p class="text-[#006A71]">
            <i class="fas fa-envelope mr-2 text-[#006A71]"></i>Email: 
            <a href="mailto:bhuvan@example.com" class="text-[#006A71] hover:text-[#48A6A7]">bhuvan@example.com</a>
          </p>
        </div>
        <div class="bg-[#F2EFE7] p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-[#006A71] mb-2">
            <i class="fas fa-phone text-[#006A71]"></i> Pardhu
          </h3>
          <p class="text-[#006A71]">
            <i class="fas fa-phone-alt mr-2 text-[#006A71]"></i>Phone: 
            <a href="tel:+1987654321" class="text-[#006A71] hover:text-[#48A6A7]">+1 987 654 321</a>
          </p>
          <p class="text-[#006A71]">
            <i class="fas fa-envelope mr-2 text-[#006A71]"></i>Email: 
            <a href="mailto:pardhu@example.com" class="text-[#006A71] hover:text-[#48A6A7]">pardhu@example.com</a>
          </p>
        </div>
        <div class="bg-[#F2EFE7] p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-[#006A71] mb-2">
            <i class="fas fa-phone text-[#006A71]"></i> Bhargav
          </h3>
          <p class="text-[#006A71]">
            <i class="fas fa-phone-alt mr-2 text-[#006A71]"></i>Phone: 
            <a href="tel:+1123456789" class="text-[#006A71] hover:text-[#48A6A7]">+1 123 456 789</a>
          </p>
          <p class="text-[#006A71]">
            <i class="fas fa-envelope mr-2 text-[#006A71]"></i>Email: 
            <a href="mailto:bhargav@example.com" class="text-[#006A71] hover:text-[#48A6A7]">bhargav@example.com</a>
          </p>
        </div>
        <div class="bg-[#F2EFE7] p-6 rounded-xl shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold text-[#006A71] mb-2">
            <i class="fas fa-phone text-[#006A71]"></i> Rohit
          </h3>
          <p class="text-[#006A71]">
            <i class="fas fa-phone-alt mr-2 text-[#006A71]"></i>Phone: 
            <a href="tel:+1098765432" class="text-[#006A71] hover:text-[#48A6A7]">+1 098 765 432</a>
          </p>
          <p class="text-[#006A71]">
            <i class="fas fa-envelope mr-2 text-[#006A71]"></i>Email: 
            <a href="mailto:rohit@example.com" class="text-[#006A71] hover:text-[#48A6A7]">rohit@example.com</a>
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
  
  <script type="module" src="assets/js/main.js"></script>
</body>

</html>