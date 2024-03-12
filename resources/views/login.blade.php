<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="../bootstrap-5.0.2-dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />
    <link rel="icon" href="./exceIcon.png" type="favicon/ico" />

    <title>Login Page</title>
    <style>
      .selector-for-some-widget {
        box-sizing: content-box;
      }
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;

        /* font-family: "poppins","san-serif"; */
      }
      form {
        max-width: 540px;
        background: #fff;
        margin: 100px auto 20px;
        padding: 40px 30px 70px;
        border-radius: 10px;
        margin: 0 auto !important;
      }
      .main {
        width: 100%;
        min-height: 100vh;
        background: rgb(2, 58, 2);
        padding: 10px;
      }
    </style>
  </head>
  <body>
    <div class="main">
      <form id="login-form" class="row g-3">
        <h2>Login</h2>
        <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input name="email" type="email" class="form-control" id="email" />
        </div>
        <div class="col-md-6">
          <label for="password" class="form-label">Password</label>
          <input
            min="8"
            name="password"
            type="password"
            class="form-control"
            id="password"
          />
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary" value="Login">
            Sign in
          </button>
        </div>
      </form>
    </div>
  </body>
</html>
