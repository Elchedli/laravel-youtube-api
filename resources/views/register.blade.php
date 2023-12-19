<h1>register page</h1>
<form action="" method="POST">
    @csrf
    <input type="text" name="username" placeholder="username"><br>
    <input type="email" name="email" placeholder="email"><br>
    <input type="password" name="password" placeholder="password"><br>
    <button type="submit">Submit</button>
</form>