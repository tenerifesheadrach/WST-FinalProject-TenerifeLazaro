<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us</title>
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


    /* Team Cards */
    .team {
      padding: 2rem;
      text-align: center;
    }

    .team h2 {
      color: #0d47a1;
      margin-bottom: 2rem;
      font-size: 2rem;
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 2rem;
    }

    .card {
      background-color: #ffffff;
      border: 2px solid #0d47a1;
      border-radius: 10px;
      padding: 1.5rem;
      width: 260px;
	  height: 300px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }

    .card:hover {
      transform: scale(1.05);
    }

	  .card img {
	  width: 120px;
	  height: 120px;
	  object-fit: cover;
	  border-radius: 50%;
	  margin-bottom: 1rem;
	  border: 2px solid #0d47a1; 
	}


    .card h3 {
      color: #0d47a1;
      margin-bottom: 0.5rem;
    }

    .card p {
      color: #555;
      font-size: 0.95rem;
    }
	.modal {
	  position: fixed;
	  top: 0;
	  left: 0;
	  width: 100%;
	  height: 100%;
	  background-color: rgba(0,0,0,0.6);
	  display: flex;
	  align-items: center;
	  justify-content: center;
	  z-index: 2000;
	}

	.modal.hidden {
	  display: none;
	}

	.modal-content {
	  background-color: #fff;
	  padding: 1.5rem 2rem;
	  border-radius: 10px;
	  box-shadow: 0 6px 20px rgba(0,0,0,0.3);
	  max-width: 400px;
	  width: 90%;
	  cursor: grab;
	  position: relative;
	}

	.modal-content h3 {
	  color: #0d47a1;
	  margin-bottom: 1rem;
	}

	.modal-content p {
	  margin: 0.5rem 0;
	}

	.close {
	  position: absolute;
	  right: 15px;
	  top: 10px;
	  font-size: 1.5rem;
	  cursor: pointer;
	  color: #aaa;
	}

	.close:hover {
	  color: #000;
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
	  <li><a href="index.php">Log Out</a></li>
    </ul>
  </nav>


  <!-- Team Section -->
  <div class="team">
    <h2>Meet Our Team</h2>
    <div class="card-container">
      <div class="card">
        <img src="yesha.jpg" alt="Yesha Nicole R. Lazaro">
		<h3 style="color: #0d47a1;">Yesha Nicole R. Lazaro</h3>
        <p>Web Developer</p>
      </div>
      <div class="card">
        <img src="sheadrach.png" alt="Sheadrach Joy R. Tenerife">
		<h3 style="color: #0d47a1;">Sheadrach Joy R. Tenerife</h3>
        <p>Web Developer</p>
      </div>
    </div>
  </div>
<!-- Modal Structure -->
<div id="modal" class="modal hidden">
  <div class="modal-content" id="modalContent">
    <span class="close">&times;</span>
    <h3 id="modalName"></h3>
    <p><strong>Role:</strong> <span id="modalRole"></span></p>
    <p><strong>Course:</strong> <span id="modalCourse"></span></p>
    <p><strong>Age:</strong> <span id="modalAge"></span></p>
    <p><strong>Email:</strong> <span id="modalEmail"></span></p>
  </div>
</div>

<script>
  const members = {
    "Yesha Nicole R. Lazaro": {
      role: "Web Developer, UI/UX Designer",
      course: "BSIT",
      age: 20,
      email: "lazaro.yeshanicole.bsit@gmail.com"
    },
    "Sheadrach Joy R. Tenerife": {
      role: "Web Developer",
      course: "BSIT",
      age: 20,
      email: "tenerife.sheadrachjoy.bsit@gmail.com"
    }
  };

  const cards = document.querySelectorAll(".card");
  const modal = document.getElementById("modal");
  const modalContent = document.getElementById("modalContent");
  const modalName = document.getElementById("modalName");
  const modalRole = document.getElementById("modalRole");
  const modalCourse = document.getElementById("modalCourse");
  const modalAge = document.getElementById("modalAge");
  const modalEmail = document.getElementById("modalEmail");
  const closeBtn = document.querySelector(".close");

  cards.forEach(card => {
    card.addEventListener("click", () => {
      const name = card.querySelector("h3").innerText;
      const data = members[name];

      modalName.textContent = name;
      modalRole.textContent = data.role;
      modalCourse.textContent = data.course;
      modalAge.textContent = data.age;
      modalEmail.textContent = data.email;

      modal.classList.remove("hidden");
    });
  });

  closeBtn.onclick = () => modal.classList.add("hidden");
  window.onclick = (e) => {
    if (e.target === modal) modal.classList.add("hidden");
  };

  // Draggable Modal
  let isDragging = false, offsetX, offsetY;
  modalContent.addEventListener("mousedown", e => {
    isDragging = true;
    offsetX = e.clientX - modalContent.getBoundingClientRect().left;
    offsetY = e.clientY - modalContent.getBoundingClientRect().top;
    modalContent.style.cursor = "grabbing";
  });

  document.addEventListener("mousemove", e => {
    if (isDragging) {
      modalContent.style.left = `${e.clientX - offsetX}px`;
      modalContent.style.top = `${e.clientY - offsetY}px`;
      modalContent.style.position = "absolute";
    }
  });

  document.addEventListener("mouseup", () => {
    isDragging = false;
    modalContent.style.cursor = "grab";
  });
</script>

</body>
</html>
