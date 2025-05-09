<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Launching Soon - Blast It Now</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;
      color: white;
      min-height: 100vh;
      position: relative;
      z-index: 1;
    }

    body::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background: rgba(0, 0, 0, 0.6);
      z-index: -1;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
    }

    .social-icons a {
      color: white;
      margin-left: 15px;
      font-size: 20px;
      text-decoration: none;
    }

    .centered-content {
      max-width: 800px;
      margin: 0 auto;
      text-align: center;
      padding: 60px 20px 40px;
    }

    .centered-content h1 {
      font-size: 48px;
      font-weight: 700;
    }

    .subtitle {
      margin-top: 10px;
      font-size: 18px;
      font-weight: 500;
      letter-spacing: 2px;
    }

    .highlight {
      margin-top: 20px;
      font-size: 20px;
      background: #2B4C7E;
      color:#fff;
      display: inline-block;
      padding: 10px 50px;
      font-weight: 600;
      letter-spacing: 1px;
      text-decoration: none;
    }

    .description {
      margin-top: 15px;
      font-size: 16px;
      color: #ddd;
    }

    .video-container {
      margin-top: 30px;
      position: relative;
      display: inline-block;
      box-shadow: 0 0 15px 3px rgba(255, 255, 255, 0.5);
      border-radius: 12px;
      overflow: hidden;
    }

    .video-container img {
      width: 100%;
      max-width: 600px;
      display: block;
    }

    .play-button {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: rgba(0, 0, 0, 0.6);
      padding: 12px 24px;
      border-radius: 30px;
      font-weight: 600;
      font-size: 16px;
      cursor: pointer;
      border: 2px solid white;
      text-shadow: 0 0 3px white;
    }

    .mission {
      margin-top: 40px;
      font-size: 18px;
      color: #ccc;
      max-width: 700px;
      margin-inline: auto;
    }

    section.info-wrapper {
      width: 100%;
      background-color: #152C4F;
    }

    .info-section {
      max-width: 1000px;
      margin: 0 auto;
      background-color: rgba(21, 44, 79, 0.9);
      padding: 60px 20px;
      text-align: center;
    }

    .info-section h3 {
      font-size: 24px;
      font-weight: 600;
      color: white;
    }

    .info-section p {
      color: #ddd;
      margin-top: 10px;
    }

    .signup-form {
      margin-top: 30px;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 15px;
    }

    .signup-form input {
      padding: 12px 15px;
      border-radius: 5px;
      border: none;
      width: 200px;
      font-size: 14px;
    }

    .signup-form button {
      padding: 12px 25px;
      background-color: white;
      color: #152C4F;
      border: none;
      border-radius: 25px;
      font-weight: 600;
      cursor: pointer;
    }

    .footer-note {
      margin-top: 20px;
      font-size: 14px;
      color: #aaa;
    }

    @media screen and (max-width: 768px) {
      .signup-form {
        flex-direction: column;
        align-items: center;
      }

      .signup-form input, .signup-form button {
        width: 90%;
        max-width: 300px;
      }

      .centered-content h1 {
        font-size: 36px;
      }
    }
  </style>
</head>
<body>

  <header>
    <img src="https://i.ibb.co/6WwqLZF/logo.png" alt="Blast It Now Logo" height="60"/>
    <div class="social-icons">
      <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/2111/2111393.png" width="20" /></a>
      <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/145/145802.png" width="20" /></a>
      <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" width="20" /></a>
      <a href="#"><img src="https://cdn-icons-png.flaticon.com/512/3670/3670151.png" width="20" /></a>
    </div>
  </header>

  <div class="centered-content">
    <h1>LAUNCHING SOON</h1>
    <p class="subtitle">THE ULTIMATE DIGITAL MARKETING EXPERIENCE</p>

    <a href="#" class="highlight">SOMETHING BIG IS COMING</a>
    <p class="description">
      We're thrilled to announce that our official launch is just around the corner! Be the first to
      experience Blast It Now — where innovation meets simplicity.
    </p>

    <div class="video-container">
      <img src="https://img.freepik.com/free-photo/businessman-using-digital-tablet-office_53876-101927.jpg" alt="Intro Video" />
      <div class="play-button">▶ INTRO VIDEO</div>
    </div>

    <p class="mission">
      Our mission is to help small businesses grow through smart, result-driven digital marketing
      solutions — from creative digital campaigns to innovative powerful integrated tools that increase
      customer engagement and promote brand visibility.
    </p>
  </div>

  <!-- NEW SEPARATE SECTION -->
  <section class="info-wrapper">
    <div class="info-section">
      <h3>STAY INFORMED. STAY AHEAD.</h3>
      <p>Sign up to join our launch, receive updates, early access opportunities, and industry insights.</p>

      <form class="signup-form">
        <input type="text" placeholder="Name" required>
        <input type="email" placeholder="Email" required>
        <button type="submit">Join Launch</button>
      </form>

      <div class="footer-note">
        Elevate your digital presence with a partner you can trust.
      </div>
    </div>
  </section>

</body>
</html>
