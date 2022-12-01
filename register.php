<!DOCTYPE html>
<html>
  <head>
    <title>Page Title</title>
    <link rel="stylesheet" href="styles.css" />
    <meta charset="UTF-8" />
    <meta name="author" content="235967" />
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> -->
  </head>
  <body></body>
</html>

<body>
  <form action="action_page.php">
    <div class="container">
      <h1>Register</h1>
      <p>Please fill in this form to take your career to the next level.</p>
      <hr />

      <label for="name"><b>Name</b></label>
      <input
        type="text"
        placeholder="Enter Name"
        name="name"
        id="name"
        required
      />

      <label for="surname"><b>Surname</b></label>
      <input
        type="text"
        placeholder="Enter Surname"
        name="surname"
        id="surname"
        required
      />

      <label for="\nemail"><b>Email</b></label>
      <input
        type="text"
        placeholder="Enter Email"
        name="email"
        id="email"
        required
      />

      <label for="psw"><b>Password</b></label>
      <input
        type="password"
        placeholder="Enter Password"
        name="psw"
        id="psw"
        required
      />

      <label for="psw-repeat"><b>Repeat Password</b></label>
      <input
        type="password"
        placeholder="Repeat Password"
        name="psw-repeat"
        id="psw-repeat"
        required
      />
      <label for="gender"><b>Choose gender:</b></label>
      <select name="gender" id="sex">
        <option value="Woman">Woman</option>
        <option value="Man">Man</option>
        <option value="Other">Other</option>
      </select>
      <label class="span.psw" for="birthday"><b>Birthday:</b></label>
      <br />
      <input type="date" id="birthday" name="birthday" />
      <hr />

      <button type="submit" class="registerbtn">Register</button>
    </div>

    <div class="container signin">
      <p>Already have an account? <a href="login_page.php">Sign in</a>.</p>
    </div>
  </form>
</body>
