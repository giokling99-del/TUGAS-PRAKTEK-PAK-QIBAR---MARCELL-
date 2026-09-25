<?php
/* =========================================================
   FindMyLeague — API Backend (PHP + MySQL)
   Letakkan file ini SEJAJAR dengan findmyleague.html
   ========================================================= */
session_start();
header('Content-Type: application/json; charset=utf-8');

/* ---------- KONFIGURASI DATABASE (sesuaikan!) ---------- */
$DB_HOST = 'localhost';
$DB_NAME = 'findmyleague';
$DB_USER = 'root';
$DB_PASS = '';

try {
    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER, $DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    echo json_encode(['ok' => false, 'error' => 'Koneksi database gagal']);
    exit;
}

$in     = json_decode(file_get_contents('php://input'), true) ?: [];
$action = $in['action'] ?? '';
$uid    = $_SESSION['user_id'] ?? null;

function out($data){ echo json_encode($data); exit; }
function fail($msg){ out(['ok' => false, 'error' => $msg]); }
function user_public($u){
    return [
        'id'        => $u['id'],
        'name'      => $u['name'],
        'email'     => $u['email'],
        'favSport'  => $u['fav_sport'],
        'createdAt' => $u['created_at'],
    ];
}
function post_public($p){
    return [
        'id'        => $p['id'],
        'userId'    => $p['user_id'],
        'author'    => $p['author_name'],
        'type'      => $p['type'],
        'sport'     => $p['sport'],
        'sportIcon' => $p['sport_icon'],
        'title'     => $p['title'],
        'loc'       => $p['loc'],
        'date'      => $p['event_date'],
        'fee'       => $p['fee'],
        'level'     => $p['level'],
        'createdAt' => $p['created_at'],
    ];
}

switch ($action) {

    /* ---------- AUTH ---------- */
    case 'register': {
        $name  = trim($in['name']  ?? '');
        $email = strtolower(trim($in['email'] ?? ''));
        $pass  = $in['pass'] ?? '';
        if (strlen($name) < 3)            fail('Nama minimal 3 karakter');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) fail('Email tidak valid');
        if (strlen($pass) < 8)            fail('Kata sandi minimal 8 karakter');

        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) fail('Email sudah terdaftar');

        $pdo->prepare('INSERT INTO users (name, email, pass_hash, created_at) VALUES (?,?,?,NOW())')
            ->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT)]);
        $_SESSION['user_id'] = $pdo->lastInsertId();

        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        out(['ok' => true, 'user' => user_public($stmt->fetch())]);
    }

    case 'login': {
        $email = strtolower(trim($in['email'] ?? ''));
        $pass  = $in['pass'] ?? '';
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $u = $stmt->fetch();
        if (!$u || !password_verify($pass, $u['pass_hash'])) fail('Email atau kata sandi salah');
        $_SESSION['user_id'] = $u['id'];
        out(['ok' => true, 'user' => user_public($u)]);
    }

    case 'logout':
        session_destroy();
        out(['ok' => true]);

    case 'me': {
        if (!$uid) fail('Belum login');
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$uid]);
        $u = $stmt->fetch();
        if (!$u) fail('Pengguna tidak ditemukan');
        out(['ok' => true, 'user' => user_public($u)]);
    }

    /* ---------- POSTS ---------- */
    case 'get_posts': {
        $rows = $pdo->query(
            'SELECT p.*, u.name AS author_name FROM posts p
             JOIN users u ON u.id = p.user_id
             ORDER BY p.created_at DESC'
        )->fetchAll();
        out(['ok' => true, 'posts' => array_map('post_public', $rows)]);
    }

    case 'create_post': {
        if (!$uid) fail('Masuk dulu untuk membuat postingan');
        $title = trim($in['title'] ?? '');
        if (!$title) fail('Judul wajib diisi');
        $icons = ['Basket'=>'🏀','Futsal'=>'⚽','Badminton'=>'🏸','Voli'=>'🏐','Lari'=>'🏃','Tenis Meja'=>'🏓','Sepak Bola'=>'⚽','Gym'=>'🏋️'];
        $sport = $in['sport'] ?? 'Lainnya';
        $pdo->prepare(
            'INSERT INTO posts (user_id, type, sport, sport_icon, title, loc, event_date, fee, level, created_at)
             VALUES (?,?,?,?,?,?,?,?,?,NOW())'
        )->execute([
            $uid,
            ($in['type'] === 'sparing') ? 'sparing' : 'turnamen',
            $sport,
            $icons[$sport] ?? '🏅',
            $title,
            $in['loc']   ?? '',
            $in['date']  ?? '',
            $in['fee']   ?? 'Gratis',
            $in['level'] ?? 'Semua Level',
        ]);
        $stmt = $pdo->prepare(
            'SELECT p.*, u.name AS author_name FROM posts p
             JOIN users u ON u.id = p.user_id WHERE p.id = ?'
        );
        $stmt->execute([$pdo->lastInsertId()]);
        out(['ok' => true, 'post' => post_public($stmt->fetch())]);
    }

    case 'delete_post': {
        if (!$uid) fail('Masuk dulu');
        $stmt = $pdo->prepare('SELECT user_id FROM posts WHERE id = ?');
        $stmt->execute([$in['id'] ?? 0]);
        $p = $stmt->fetch();
        if (!$p || $p['user_id'] != $uid) fail('Tidak berhak menghapus postingan ini');
        $pdo->prepare('DELETE FROM posts WHERE id = ?')->execute([$in['id']]);
        out(['ok' => true]);
    }

    default:
        fail('Aksi tidak dikenal');
}
