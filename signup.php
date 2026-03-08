<?php 
session_start(); 

if (isset($_SESSION['user_id']) && isset($_SESSION['email'])) {
    header("Location: home.php");
    exit();
}

// 1. Fetch and Clear Errors/Success
$signupError = $_SESSION['signup_error'] ?? '';
$loginError  = $_SESSION['login_error'] ?? '';
$successMsg  = $_SESSION['success'] ?? '';

unset($_SESSION['signup_error'], $_SESSION['login_error'], $_SESSION['success']);

// 2. Fetch and Clear Form Data (Persistence)
$signupData = $_SESSION['signup_data'] ?? [];
$loginData  = $_SESSION['login_data'] ?? [];

unset($_SESSION['signup_data'], $_SESSION['login_data']);

// 3. Determine Active Form
$activeForm = $_GET['form'] ?? 'login';

// If there's a specific error, force that form to be active
if ($signupError) $activeForm = 'signup';
if ($loginError)  $activeForm = 'login';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register & Login</title>
  <link href="./output.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    .fade-in {
      animation: fadeIn 0.5s ease-in;
    }
    
    .slide-up {
      animation: slideUp 0.5s ease-out;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
    @keyframes slideUp {
      from {
        transform: translateY(20px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .form-container {
      backdrop-filter: blur(8px);
      background: rgba(255, 255, 255, 0.95);
      transition: all 0.3s ease;
    }

    .form-container:hover {
      transform: translateY(-5px);
    }

    .input-field {
      transition: all 0.3s ease;
    }

    .input-field:focus {
      transform: translateY(-2px);
    }

    .social-icon {
      transition: all 0.3s ease;
    }

    .social-icon:hover {
      transform: scale(1.2) rotate(5deg);
    }
  </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#006A71] via-[#48A6A7] to-[#9ACBD0] flex items-center justify-center p-6">
  
  <!-- Signup Container -->
  <div class="container max-w-md w-full form-container rounded-2xl shadow-2xl p-8" id="signup" 
       style="display: <?php echo $activeForm === 'signup' ? 'block' : 'none'; ?>; opacity: <?php echo $activeForm === 'signup' ? '1' : '0'; ?>;">
    <h1 class="form-title text-3xl font-bold text-[#006A71] text-center mb-6 slide-up">Create Account</h1>

    <?php if ($signupError): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 fade-in" role="alert">
        <span class="block sm:inline"><?php echo $signupError; ?></span>
      </div>
    <?php endif; ?>
    
    <?php if ($successMsg && $activeForm === 'signup'): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 fade-in" role="alert">
        <span class="block sm:inline"><?php echo $successMsg; ?></span>
      </div>
    <?php endif; ?>

    <form method="post" action="includes/register.php" class="space-y-6">
      <div class="relative mb-4 fade-in">
        <i class="fas fa-user absolute left-3 top-1/2 -translate-y-4.5 text-[#48A6A7] cursor-pointer hover:text-[#006A71] transition"></i>
        <input type="text" name="username" id="username" placeholder="Username" required
          value="<?php echo htmlspecialchars($signupData['username'] ?? ''); ?>"
          class="w-full pl-10 pr-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006A71] hover:border-[#9ACBD0] transition-colors" />
        <label for="username" class="text-sm text-gray-600 block mt-1">Username</label>
      </div>

      <div class="relative mb-4 fade-in">
        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-4.5 text-[#48A6A7] cursor-pointer hover:text-[#006A71] transition"></i>
        <input type="email" name="email" id="email" placeholder="Email" required
          value="<?php echo htmlspecialchars($signupData['email'] ?? ''); ?>"
          class="w-full pl-10 pr-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006A71] hover:border-[#9ACBD0] transition-colors" />
        <label for="email" class="text-sm text-gray-600 block mt-1">Email</label>
      </div>

      <div class="relative mb-4 fade-in">
        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-4.5 text-[#48A6A7] cursor-pointer hover:text-[#006A71] transition"></i>
        <input type="password" name="password" id="password" placeholder="Password" required
          class="w-full pl-10 pr-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006A71] hover:border-[#9ACBD0] transition-colors" />
        <label for="password" class="text-sm text-gray-600 block mt-1">Password</label>
      </div>

      <div class="relative mb-4 fade-in">
        <i class="fas fa-map-marker-alt absolute left-3 top-1/2 -translate-y-4.5 text-[#48A6A7] cursor-pointer hover:text-[#006A71] transition"></i>
        <input type="text" name="location" id="location" placeholder="Location"
          value="<?php echo htmlspecialchars($signupData['location'] ?? ''); ?>"
          class="w-full pl-10 pr-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006A71] hover:border-[#9ACBD0] transition-colors" />
        <label for="location" class="text-sm text-gray-600 block mt-1">Location</label>
      </div>

      <div class="fade-in">
        <label for="message" class="text-[#006A71] font-medium block mb-1">About you:</label>
        <textarea name="about" id="message" rows="3" placeholder="Tell us a bit about yourself"
          class="w-full border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006A71] hover:border-[#9ACBD0] transition-colors p-3"><?php echo htmlspecialchars($signupData['about'] ?? ''); ?></textarea>
      </div>

      <div class="fade-in">
        <label for="bio" class="text-[#006A71] font-medium block mb-1">Bio (Short text):</label>
        <textarea name="bio" id="bio" rows="2" placeholder="A short bio"
          class="w-full border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006A71] hover:border-[#9ACBD0] transition-colors p-3"><?php echo htmlspecialchars($signupData['bio'] ?? ''); ?></textarea>
      </div>

      <input type="submit"
        class="w-full bg-[#006A71] text-white font-semibold py-2 rounded-lg hover:bg-[#48A6A7] transition-all duration-300 transform hover:scale-105"
        value="Sign Up" name="signup" />
    </form>

    <div class="relative flex items-center gap-3 my-8">
      <div class="flex-grow border-t border-gray-300"></div>
      <span class="text-gray-500 text-sm">or continue with</span>
      <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <div class="flex justify-center gap-6 mt-2">
      <i class="fab fa-google social-icon text-2xl text-[#006A71] cursor-pointer hover:text-[#48A6A7]"></i>
      <i class="fab fa-facebook social-icon text-2xl text-[#006A71] cursor-pointer hover:text-[#48A6A7]"></i>
    </div>

    <div class="text-center mt-6">
      <p class="text-gray-600">Already have an account?</p>
      <button id="loginButton" class="text-[#006A71] hover:text-[#48A6A7] font-medium mt-1 transition-colors duration-300">Login here</button>
    </div>
  </div>

  <!-- Login Container -->
  <div class="container max-w-md w-full form-container rounded-2xl shadow-2xl p-8" id="login" 
       style="display: <?php echo $activeForm === 'login' ? 'block' : 'none'; ?>; opacity: <?php echo $activeForm === 'login' ? '1' : '0'; ?>;">
    <h1 class="form-title text-3xl font-bold text-[#006A71] text-center mb-6 slide-up">Welcome Back</h1>

    <?php if ($loginError): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 fade-in" role="alert">
        <span class="block sm:inline"><?php echo $loginError; ?></span>
      </div>
    <?php endif; ?>
    
    <?php if ($successMsg && $activeForm === 'login'): ?>
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 fade-in" role="alert">
        <span class="block sm:inline"><?php echo $successMsg; ?></span>
      </div>
    <?php endif; ?>

    <form method="post" action="includes/register.php" class="space-y-6">
      <div class="relative mb-4 fade-in">
        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-4.5 text-[#48A6A7] cursor-pointer hover:text-[#006A71] transition"></i>
        <input type="email" name="email" id="email_login" placeholder="Email" required
          value="<?php echo htmlspecialchars($loginData['email'] ?? ''); ?>"
          class="w-full pl-10 pr-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006A71] hover:border-[#9ACBD0] transition-colors" />
        <label for="email_login" class="text-sm text-gray-600 block mt-1">Email</label>
      </div>

      <div class="relative mb-4 fade-in">
        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-4.5 text-[#48A6A7] cursor-pointer hover:text-[#006A71] transition"></i>
        <input type="password" name="password" id="password_login" placeholder="Password" required
          class="w-full pl-10 pr-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#006A71] hover:border-[#9ACBD0] transition-colors" />
        <label for="password_login" class="text-sm text-gray-600 block mt-1">Password</label>
      </div>

      <input type="submit"
        class="w-full bg-[#006A71] text-white font-semibold py-2 rounded-lg hover:bg-[#48A6A7] transition-all duration-300 transform hover:scale-105"
        value="Login" name="login" />
    </form>

    <div class="relative flex items-center gap-3 my-8">
      <div class="flex-grow border-t border-gray-300"></div>
      <span class="text-gray-500 text-sm">or continue with</span>
      <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <div class="flex justify-center gap-6 mt-2">
      <i class="fab fa-google social-icon text-2xl text-[#006A71] cursor-pointer hover:text-[#48A6A7]"></i>
      <i class="fab fa-facebook social-icon text-2xl text-[#006A71] cursor-pointer hover:text-[#48A6A7]"></i>
    </div>

    <div class="text-center mt-6">
      <p class="text-gray-600">Don't have an account yet?</p>
      <button id="signupButton" class="text-[#006A71] hover:text-[#48A6A7] font-medium mt-1 transition-colors duration-300">Sign up here</button>
    </div>
  </div>

  <script>
    const signupButton = document.getElementById('signupButton');
    const loginButton = document.getElementById('loginButton');
    const loginForm = document.getElementById('login');
    const signupForm = document.getElementById('signup');

    function switchForms(showForm, hideForm) {
      hideForm.style.opacity = '0';
      hideForm.style.transform = 'translateY(20px)';
      setTimeout(() => {
        hideForm.style.display = 'none';
        showForm.style.display = 'block';
        setTimeout(() => {
          showForm.style.opacity = '1';
          showForm.style.transform = 'translateY(0)';
        }, 50);
      }, 300);
    }

    signupButton.addEventListener('click', () => switchForms(signupForm, loginForm));
    loginButton.addEventListener('click', () => switchForms(loginForm, signupForm));

    // Initial setup for transitions
    loginForm.style.transition = 'all 0.3s ease-in-out';
    signupForm.style.transition = 'all 0.3s ease-in-out';
  </script>
</body>

</html>
