<?php
if (isset($_SESSION['email'])) {
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cope Up Career Counseling</title>
  <link href="./output.css" rel="stylesheet" />
</head>
<body class="bg-gradient-to-r from-[#48A6A7] to-[#9ACBD0] font-['Poppins',sans-serif]">

  <header class="bg-[#006A71] py-5 shadow-md z-50">
    <nav class="max-w-[1440px] mx-auto px-6 flex justify-between items-center">
      <div class="flex items-center">
        <img src="assets/images/realogo.png" alt="Cope Up Logo" class="mr-4 rounded-full w-10 h-10 bg-[#006A71]" />
        <h1 class="text-2xl font-bold text-[#F2EFE7]">Cope Up</h1>
      </div>
    </nav>
  </header>

  <section class="py-12 relative z-10">
    <div class="flex flex-col-reverse md:flex-row mx-auto max-w-[1440px] justify-between items-center px-6 gap-10">
      
      <div class="w-full md:w-[649px] text-center md:text-left">
        <h1 class="text-[#006A71] text-[32px] md:text-[60px] font-extrabold leading-tight">
          Discover Your Ideal Career Path with AI Guidance
        </h1>
        <p class="mt-5 mb-8 md:mb-12 text-yellow-50 text-xl md:text-2xl font-medium leading-[38px]">
          Take personalized assessments and receive smart career suggestions based on your interests, personality, and skills.
        </p>
        <a href="dashboard.php">
          <button class="px-10 py-4 text-[#F2EFE7] text-lg md:text-xl font-semibold uppercase bg-[#006A71] hover:bg-[#48A6A7] rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
            Get Started →
          </button>
        </a>
      </div>

      <!-- Image -->
      <div class="w-full md:w-auto">
        <img 
          class="w-full max-w-[570px] rounded-tl-[80px] rounded-tr-[55px] rounded-br-[80px] rounded-bl-[60px] shadow-2xl mx-auto object-cover"
          src="https://i.pinimg.com/564x/12/b9/c4/12b9c4476b5c584c90ec224a201e6f74.jpg" 
          alt="Student planning career"
        />
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-[#006A71] text-[#F2EFE7] py-8">
    <div class="max-w-[1440px] mx-auto px-6 text-center">
      <p>&copy; 2025 Cope Up. All rights reserved.</p>
      <div class="mt-4 flex justify-center gap-6">
        <a href="#" class="hover:underline hover:text-[#9ACBD0] transition">Privacy Policy</a>
        <a href="#" class="hover:underline hover:text-[#9ACBD0] transition">Terms of Service</a>
        <a href="#" class="hover:underline hover:text-[#9ACBD0] transition">Contact Us</a>
      </div>
    </div>
  </footer>

</body>
</html>
