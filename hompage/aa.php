<div class="form-container">
    <form action="Register-page.php" method="post" class="form-only" style=" margin-bottom: -10%;"
      onsubmit="return myfun()">
      <h3>register</h3>
      <?php
      if (!empty($error)) {
        echo '<span class="error-msg">' . implode("<br>", $error) . '</span>';
      }
      ?>
      <p id="success-message" style="color: green;"></p>

      <label for="">Fullname</label>
      <input type="text" name="name" pattern="^[a-zA-Z]+ [a-zA-Z]+$" required placeholder="enter your name">
      <label for="">Phone</label>
      <input type="text" name="phone" id="phonenumber"> <span id="message" style="color:red;"></span>

      <label for="">Password</label>
      <span id="messages" style="color:red;"></span>
      <input type="password" name="password" id="password">
      <label for="">Confirm_Password</label>
      <span id="messages" style="color:red;"></span>
      <input type="password" name="cpassword" id="passwords">

      <input type="submit" name="submit" value="register now" class="form-btn">
      <a href="login_page.php"></a>
      <p>already have an account? <a href="login_page.php">login here</a></p>
    </form>
  </div>

  