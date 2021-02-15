  <style>
    .kbg-login-image {
      background: url("img/logo.png");
      background-position: center;
      background-size: cover;

    }
  </style>
  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block kbg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">BackOffice BankRuptcy</h1>
                  </div>
                  <form method="post" action="admin.php?cmd=loginDados" class="user">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="user" name="user" aria-describedby="emailHelp" placeholder="Login">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                    </div>
                    <button class="btn btn-primary btn-user btn-block">Login</button>
                    <hr>
                  </form>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>