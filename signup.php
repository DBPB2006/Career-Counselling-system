<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register & Login</title>
  <link href="./output.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="min-h-screen bg-gradient-to-br from-white via-indigo-100 to-white flex items-center justify-center">

  <div class="container max-w-md w-full bg-white rounded-lg shadow-lg p-6" id="signup" style="display:none;">
    <h1 class="form-title text-2xl font-bold text-[#1D63FF] text-center mb-4">Signup</h1>
    <form method="post" action="register.php">

      <div class="relative mb-4">
        <i class="fas fa-user absolute left-3 top-1/2 -translate-y-4.5 text-[#1D63FF] cursor-pointer hover:text-yellow-400 transition"></i>
        <input type="text" name="username" id="username" placeholder="Username" required
          class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#1D63FF]" />
        <label for="username" class="text-sm text-gray-600 block mt-1">Username</label>
      </div>
      <div class="relative mb-4">
        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-4.5 text-[#1D63FF] cursor-pointer hover:text-yellow-400 transition"></i>
        <input type="email" name="email" id="email" placeholder="Email" required
          class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#1D63FF]" />
        <label for="email" class="text-sm text-gray-600 block mt-1">Email</label>
      </div>
      <div class="relative mb-4">
        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-4.5 text-[#1D63FF] cursor-pointer hover:text-yellow-400 transition"></i>
        <input type="password" name="password" id="password" placeholder="Password" required
          class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#1D63FF]" />
        <label for="password" class="text-sm text-gray-600 block mt-1">Password</label>
      </div>
      <input type="submit"
        class="w-full bg-[#1D63FF] text-white font-semibold py-2 rounded hover:bg-yellow-400 hover:text-black transition"
        value="Signup" name="signup" />
    </form>

    <p class="text-center text-gray-400 mt-4">----------or--------</p>
    <div class="flex justify-center gap-4 mt-2 text-[#1D63FF] text-xl">
      <i class="fab fa-google cursor-pointer hover:text-yellow-400 transition" aria-hidden="true"></i>
      <i class="fab fa-facebook cursor-pointer hover:text-yellow-400 transition"></i>
    </div>
    <div class="text-center mt-4">
      <p class="text-sm">Already Have Account?</p>
      <button id="loginButton" class="text-[#1D63FF] hover:underline font-medium">Login</button>
    </div>
  </div>

  <div class="container max-w-md w-full bg-white rounded-lg shadow-lg p-6" id="login">
    <h1 class="form-title text-2xl font-bold text-[#1D63FF] text-center mb-4">Login</h1>
    <form method="post" action="register.php">
      <div class="relative mb-4">
        <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-4.5 text-[#1D63FF] cursor-pointer hover:text-yellow-400 transition"></i>
        <input type="email" name="email" id="email" placeholder="Email" required
          class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#1D63FF]" />
        <label for="email" class="text-sm text-gray-600 block mt-1">Email</label>
      </div>
      <div class="relative mb-4">
        <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-4.5 text-[#1D63FF] cursor-pointer hover:text-yellow-400 transition"></i>
        <input type="password" name="password" id="password" placeholder="Password" required
          class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#1D63FF] cursor-pointer hover:text-yellow-400 transition" />
        <label for="password" class="text-sm text-gray-600 block mt-1">Password</label>
      </div>
      <input type="submit"
        class="w-full bg-[#1D63FF] text-white font-semibold py-2 rounded hover:bg-yellow-400 hover:text-black transition cursor-pointer"
        value="Login" name="login" />
    </form>

    <p class="text-center text-gray-400 mt-4">----------or--------</p>
    <div class="flex justify-center gap-4 mt-2 text-[#1D63FF] text-xl">
      <i class="fab fa-google cursor-pointer hover:text-yellow-400 transition"></i>
      <i class="fab fa-facebook cursor-pointer hover:text-yellow-400 transition"></i>
    </div>
    <div class="text-center mt-4">
      <p class="text-sm">Don't have an account yet?</p>
      <button id="signupButton" class="text-[#1D63FF] hover:underline font-medium hover:text-yellow-400">Signup</button>
    </div>
  </div>

  <script>
    const signupButton = document.getElementById('signupButton');
    const loginButton = document.getElementById('loginButton');
    const loginForm = document.getElementById('login');
    const signupForm = document.getElementById('signup');

    signupButton.addEventListener('click', function () {
      loginForm.style.display = "none";
      signupForm.style.display = "block";
    });
    loginButton.addEventListener('click', function () {
      loginForm.style.display = "block";
      signupForm.style.display = "none";
    });
  </script>
</body>

</html>