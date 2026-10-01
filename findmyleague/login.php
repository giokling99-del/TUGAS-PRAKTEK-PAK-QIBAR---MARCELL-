<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';
$oldEmail = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $oldEmail = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($oldEmail === '' || $password === '') {
        $error = 'Please enter your email and password.';
    } else {
        $stmt = $conn->prepare('SELECT id, name, email, pass_hash, fav_sport FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $oldEmail);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['pass_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['fav_sport'] = $user['fav_sport'] ?? '-';
            header('Location: index.php');
            exit;
        }

        $error = 'Incorrect email or password.';
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — FindMyLeague</title>
<style>
:root{--lime:#b8ff2c;--black:#070707;--white:#f5f5f5;--gray:#999}
*{box-sizing:border-box;margin:0;padding:0}
body{min-height:100vh;background:var(--black);color:var(--white);font-family:Arial,Helvetica,sans-serif;display:grid;place-items:center;padding:30px}
a{color:inherit;text-decoration:none}
.page{width:min(1050px,100%);min-height:650px;display:grid;grid-template-columns:1fr 1fr;border:1px solid #292929;background:#101010;overflow:hidden}
.visual{position:relative;display:flex;align-items:flex-end;padding:55px;background:linear-gradient(145deg,rgba(184,255,44,.12),transparent 45%),linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.8)),url('https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=1200&q=80') center/cover}
.visual h1{font-size:clamp(55px,7vw,100px);line-height:.82;letter-spacing:-5px;text-transform:uppercase}.visual h1 span{color:var(--lime)}
.visual p{color:#bbb;margin-top:25px;line-height:1.6;max-width:330px}
.form-side{padding:55px;display:flex;flex-direction:column;justify-content:center}.logo{font-size:24px;font-weight:900;letter-spacing:-1.5px;margin-bottom:60px}.logo span{color:var(--lime)}
h2{font-size:42px;letter-spacing:-2px;margin-bottom:10px}.subtitle{color:var(--gray);margin-bottom:35px}
label{display:block;font-size:12px;font-weight:800;margin:20px 0 8px;text-transform:uppercase;letter-spacing:1px}input{width:100%;padding:16px;background:#181818;border:1px solid #333;color:white;outline:none}input:focus{border-color:var(--lime)}
button{width:100%;margin-top:28px;padding:17px;background:var(--lime);border:0;font-weight:900;cursor:pointer}button:hover{filter:brightness(.95)}
.error{padding:12px 14px;border:1px solid #663333;background:#281414;color:#ffb5b5;margin-bottom:20px;font-size:13px}.bottom{text-align:center;color:#888;font-size:13px;margin-top:22px}.bottom a{color:var(--lime);font-weight:800}
.back{position:absolute;top:25px;left:30px;color:#aaa;font-size:13px}.back:hover{color:white}
@media(max-width:750px){.page{grid-template-columns:1fr}.visual{display:none}.form-side{padding:35px 25px}.logo{margin-bottom:45px}}
</style>
</head>
<body>
<a class="back" href="index.php">← Back to FindMyLeague</a>
<div class="page">
    <section class="visual">
        <div><h1>WELCOME<br><span>BACK.</span></h1><p>Log in to find tournaments, teams and sparring partners near you.</p></div>
    </section>
    <section class="form-side">
        <div class="logo">FINDMY<span>LEAGUE</span></div>
        <h2>Welcome back</h2>
        <p class="subtitle">Log in to your account.</p>
        <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="POST">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="<?= htmlspecialchars($oldEmail) ?>" required autocomplete="email">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password">
            <button type="submit">LOG IN →</button>
        </form>
        <p class="bottom">Don't have an account? <a href="register.php">Create one</a></p>
    </section>
</div>
</body>
</html>
