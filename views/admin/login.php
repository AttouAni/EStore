<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
      crossorigin="anonymous"
    />

    <style>
      .auth-layout {
        background: linear-gradient(to left, #eef7fd 35%, #01395f 35%);
        position: relative;
        padding-left: 5%;
        padding-right: 8%;
      }

      .branding-section {
        width: 90%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding-left: 3rem;
        text-align: left;
      }

      .login-card {
        position: absolute;
        right: 7%;
        width: 450px;
        border-radius: 20px;
        z-index: 2;
      }

      .login-btn {
        width: 140px;
        font-weight: 500;
        padding: 2px;
        display: block;
        margin: 0 auto;
      }

      .app-logo {
        width: 300px;
        height: 150px;
        text-align: center;
      }

      input:focus {
        outline: none;
        box-shadow: none;
        border-color: #ccc;
        background-color: #ffffff;
      }

      .branding-content {
        max-width: 50%;
        text-align: left;
        display: flex;
        flex-direction: column;
      }

      .branding-content h4 {
        font-size: 25px;
        white-space: nowrap;
      }

      .description-text {
        font-size: 1rem;
        line-height: 1.6;
        color: #ffffffd9;
      }
    </style>
  </head>
  <body>
    <div
      class="auth-layout d-flex align-items-center justify-content-start min-vh-100 flex-wrap"
    >
      
      <div class="login-card bg-white shadow p-5">
        <h3 class="fw-bold text-dark mb-1">WELCOME BACK!</h3>
        <p class="text-muted mb-4">Login here.</p>

        <form action="../../controllers/authController.php" method="POST">
          <div class="mb-3">
            <input type="email" name="email" placeholder="Email" class="form-control" />
          </div>
          <div class="mb-4">
            <input type="password" name ="password" placeholder="Password" class="form-control" />
          </div>
          <button type="submit" name="admin_login" class="btn btn-primary shadow-sm login-btn">
            Login
          </button>
          <p class="text-center mt-2">
            Don't have an account? <a href="register.php">Register Here</a>
          </p>
        </form>
      </div>


      <div class="branding-section text-white d-none d-md-flex">
        <div class="branding-content">
          <h4 class="fw-400">Welcome to our online book store</h4>
          <h3 class="fw-bold text-primary">ESTORE</h3>
          <p class="description-text">
            Login to discover a wide range of books and enjoy a seamless
            shopping experience.
          </p>
        </div>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>
  </body>