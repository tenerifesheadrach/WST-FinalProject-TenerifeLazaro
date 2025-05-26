<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Employee Records</title>
  <style>
       * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f0f4fa;
      color: #333;
    }

    /* Navbar styles */
    .navbar {
      width: 100%;
      background-color: #0d47a1;
      color: #fff;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .left-section {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .logo {
      height: 50px;
      width: auto;
    }

    .college-name {
      font-size: 1.25rem;
      font-weight: 700;
      white-space: nowrap;
    }

    .navbar ul {
      list-style: none;
      display: flex;
      gap: 1.5rem;
    }

    .navbar ul li a {
      text-decoration: none;
      color: #fff;
      font-weight: 600;
      transition: color 0.3s ease;
    }

    .navbar ul li a:hover {
      color: #90caf9;
      text-decoration: underline;
    }


    /* Main Content Layout */
    .content {
      display: flex;
      padding: 2rem;
      gap: 2rem;
      flex-wrap: wrap;
      justify-content: center;
    }

    /* Carousel */
    .carousel {
      flex: 1;
      max-width: 600px;
      width: 100%;
      height: 400px;
      overflow: hidden;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      position: relative;
    }

    .slides {
      display: flex;
      transition: transform 0.5s ease-in-out;
      width: 300%; /* 3 images = 300% */
    }

    .slides img {
      width: 600px; /* Match carousel width */
      height: 100%;
      object-fit: cover;
      flex-shrink: 0;
    }

    /* Carousel Buttons */
    .carousel-controls {
      position: absolute;
      width: 100%;
      top: 50%;
      display: flex;
      justify-content: space-between;
      transform: translateY(-50%);
      padding: 0 1rem;
    }

    .carousel-controls button {
      background-color: rgba(0,0,0,0.5);
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      cursor: pointer;
      font-size: 1.5rem;
      border-radius: 5px;
    }

    .carousel-controls button:hover {
      background-color: rgba(0,0,0,0.8);
    }

    /* Intro Section */
    .intro {
      flex: 1;
      max-width: 600px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .intro h2 {
      color: #0d47a1;
      margin-bottom: 1rem;
      font-size: 2rem;
    }

    .intro p {
      font-size: 1rem;
      margin-bottom: 2rem;
      line-height: 1.5;
    }

    .intro button {
      width: fit-content;
      padding: 0.75rem 1.5rem;
      background-color: #0d47a1;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
    }

    .intro button:hover {
      background-color: #08306b;
    }

    @media (max-width: 768px) {
      .carousel .slides img {
        width: 100vw;
      }

      .slides {
        width: 300vw;
      }
    }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="left-section">
    <img src="cict.png" alt="Logo" class="logo" />
    <div class="college-name">College of Information and Communications Technology</div>
  </div>
  <ul>
    <li><a href="home.php">Home</a></li>
    <li><a href="aboutus.php">About</a></li>
    <li><a href="index.php">Logout</a></li>
  </ul>
</nav>

<!-- Content Section -->
<div class="content">
  <!-- Carousel / Image Slides -->
  <div class="carousel">
    <div class="slides" id="slides">
      <img src="emp1.jpg" alt="Employee 1">
      <img src="emp2.jpg" alt="Employee 2">
      <img src="emp3.jpg" alt="Employee 3">
    </div>
    <div class="carousel-controls">
      <button onclick="prevSlide()">❮</button>
      <button onclick="nextSlide()">❯</button>
    </div>
  </div>

  <!-- Intro Text -->
  <div class="intro">
    <h2>CICT Faculty Information Management System</h2>
   <p>This system efficiently manages and stores comprehensive information of CICT core faculty, improving data access and enhancing administrative processes within the College of Information and Communications Technology.</p>
    <button onclick="window.location.href='manage_employee.php'">Get Started</button>
  </div>
</div>

<script>
  const slides = document.getElementById("slides");
  let index = 0;

  function showSlide(i) {
    const total = slides.children.length;
    index = (i + total) % total;
    slides.style.transform = `translateX(-${index * 600}px)`; // match image width
  }

  function nextSlide() {
    showSlide(index + 1);
  }

  function prevSlide() {
    showSlide(index - 1);
  }
</script>

</body>
</html>
