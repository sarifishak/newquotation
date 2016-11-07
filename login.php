<html>
  <head>
    <title>Login Page</title>
  </head>
  <body>
    <p>Login into the system, please....</p>
    <p>Enter Username and Password to Login:</p>
    <form action='login_process.php' method='post'>
      <table border='1'>
        <tr>
          <td>Username:</td>
          <td><input type='text' name='username'></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><input type='password' name='password'></td>
        </tr>
        <tr>
          <td>&nbsp</td>
          <td><input type='submit' value='Login'></td>
        </tr>
      </table> 
    </form>
  </body>
</html>