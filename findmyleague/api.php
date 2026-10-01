<?php
/* =========================================================
   FindMyLeague — API Backend
   PHP + MySQL + PDO
   ========================================================= */

session_start();

header('Content-Type: application/json; charset=utf-8');


/* =========================================================
   DATABASE CONFIGURATION
   ========================================================= */

$DB_HOST = 'localhost';
$DB_NAME = 'findmyleague';
$DB_USER = 'root';
$DB_PASS = '';


/* =========================================================
   DATABASE CONNECTION
   ========================================================= */

try {

    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

} catch (PDOException $e) {

    echo json_encode([
        'ok' => false,
        'error' => 'Database connection failed'
    ]);

    exit;
}


/* =========================================================
   INPUT
   ========================================================= */

$in = json_decode(
    file_get_contents('php://input'),
    true
) ?: [];

$action = $in['action'] ?? '';

$uid = $_SESSION['user_id'] ?? null;


/* =========================================================
   RESPONSE FUNCTIONS
   ========================================================= */

function out($data)
{
    echo json_encode($data);
    exit;
}


function fail($msg)
{
    out([
        'ok' => false,
        'error' => $msg
    ]);
}


/* =========================================================
   LOGIN REQUIREMENT
   ========================================================= */

function require_login()
{
    global $uid;

    if (!$uid) {
        fail('Please login first');
    }

    return $uid;
}


/* =========================================================
   ADMIN REQUIREMENT
   ========================================================= */

function require_admin()
{
    global $pdo;
    global $uid;

    if (!$uid) {
        fail('Please login first');
    }

    $stmt = $pdo->prepare(
        'SELECT role FROM users WHERE id = ? LIMIT 1'
    );

    $stmt->execute([$uid]);

    $user = $stmt->fetch();

    if (!$user) {
        fail('User not found');
    }

    if (($user['role'] ?? 'member') !== 'admin') {

        http_response_code(403);

        fail('Admin access required');
    }

    return $uid;
}


/* =========================================================
   PUBLIC USER DATA
   ========================================================= */

function user_public($u)
{
    return [

        'id' => (int)$u['id'],

        'name' => $u['name'],

        'email' => $u['email'] ?? '',

        'favSport' => $u['fav_sport'] ?? '-',

        'role' => $u['role'] ?? 'member',

        'createdAt' => $u['created_at'] ?? '',

    ];
}


/* =========================================================
   POST PUBLIC DATA
   ========================================================= */

function post_public($p)
{
    return [

        'id' => (int)$p['id'],

        'userId' => (int)$p['user_id'],

        'author' => $p['author_name'] ?? '',

        'authorRole' => $p['author_role'] ?? 'member',

        'type' => $p['type'],

        'sport' => $p['sport'],

        'sportIcon' => $p['sport_icon'],

        'title' => $p['title'],

        'loc' => $p['loc'],

        'date' => $p['event_date'],

        'fee' => $p['fee'],

        'level' => $p['level'],

        'createdAt' => $p['created_at'],

    ];
}


/* =========================================================
   GET USER PROFILE
   ========================================================= */

function get_user_data($id)
{
    global $pdo;

    $stmt = $pdo->prepare(
        'SELECT
            u.id,
            u.name,
            u.email,
            u.fav_sport,
            u.role,
            u.created_at,
            COUNT(p.id) AS post_count

         FROM users u

         LEFT JOIN posts p
            ON p.user_id = u.id

         WHERE u.id = ?

         GROUP BY
            u.id,
            u.name,
            u.email,
            u.fav_sport,
            u.role,
            u.created_at

         LIMIT 1'
    );

    $stmt->execute([$id]);

    return $stmt->fetch();
}


/* =========================================================
   ACTIONS
   ========================================================= */

switch ($action) {


    /* =====================================================
       REGISTER
       ===================================================== */

    case 'register': {

        $name = trim(
            $in['name'] ?? ''
        );

        $email = strtolower(
            trim($in['email'] ?? '')
        );

        $pass = $in['pass'] ?? '';

        $favSport = trim(
            $in['favSport']
            ?? $in['fav_sport']
            ?? '-'
        );


        if (strlen($name) < 3) {

            fail(
                'Name must be at least 3 characters'
            );
        }


        if (!filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )) {

            fail(
                'Invalid email address'
            );
        }


        if (strlen($pass) < 8) {

            fail(
                'Password must be at least 8 characters'
            );
        }


        /* Check existing email */

        $stmt = $pdo->prepare(
            'SELECT id
             FROM users
             WHERE email = ?
             LIMIT 1'
        );

        $stmt->execute([
            $email
        ]);


        if ($stmt->fetch()) {

            fail(
                'Email is already registered'
            );
        }


        /* New accounts are ALWAYS members */

        $role = 'member';


        $stmt = $pdo->prepare(
            'INSERT INTO users
            (
                name,
                email,
                pass_hash,
                fav_sport,
                role,
                created_at
            )

            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                NOW()
            )'
        );


        $stmt->execute([

            $name,

            $email,

            password_hash(
                $pass,
                PASSWORD_DEFAULT
            ),

            $favSport,

            $role

        ]);


        $_SESSION['user_id'] =
            $pdo->lastInsertId();


        $stmt = $pdo->prepare(
            'SELECT *
             FROM users
             WHERE id = ?'
        );

        $stmt->execute([
            $_SESSION['user_id']
        ]);


        $user = $stmt->fetch();


        out([
            'ok' => true,

            'user' => user_public($user)
        ]);

    }


    /* =====================================================
       LOGIN
       ===================================================== */

    case 'login': {

        $email = strtolower(
            trim($in['email'] ?? '')
        );

        $pass = $in['pass'] ?? '';


        $stmt = $pdo->prepare(
            'SELECT *
             FROM users
             WHERE email = ?
             LIMIT 1'
        );

        $stmt->execute([
            $email
        ]);


        $u = $stmt->fetch();


        if (
            !$u ||
            !password_verify(
                $pass,
                $u['pass_hash']
            )
        ) {

            fail(
                'Incorrect email or password'
            );
        }


        $_SESSION['user_id'] =
            $u['id'];


        out([
            'ok' => true,

            'user' => user_public($u)
        ]);

    }


    /* =====================================================
       LOGOUT
       ===================================================== */

    case 'logout': {

        session_destroy();

        out([
            'ok' => true
        ]);

    }


    /* =====================================================
       CURRENT USER
       ===================================================== */

    case 'me': {

        require_login();


        $stmt = $pdo->prepare(
            'SELECT *
             FROM users
             WHERE id = ?
             LIMIT 1'
        );

        $stmt->execute([
            $uid
        ]);


        $u = $stmt->fetch();


        if (!$u) {

            fail(
                'User not found'
            );
        }


        out([
            'ok' => true,

            'user' => user_public($u)
        ]);

    }


    /* =====================================================
       GET POSTS
       ===================================================== */

    case 'get_posts': {

        $rows = $pdo->query(

            'SELECT
                p.*,
                u.name AS author_name,
                u.role AS author_role

             FROM posts p

             JOIN users u
                ON u.id = p.user_id

             ORDER BY
                p.created_at DESC'

        )->fetchAll();


        out([

            'ok' => true,

            'posts' =>
                array_map(
                    'post_public',
                    $rows
                )

        ]);

    }


    /* =====================================================
       CREATE POST
       ===================================================== */

    case 'create_post': {

        require_login();


        $title = trim(
            $in['title'] ?? ''
        );


        if (!$title) {

            fail(
                'Title is required'
            );
        }


        $icons = [

            'Basketball' => 'basketball',

            'Soccer' => 'soccer',

            'Badminton' => 'badminton',

            'Volleyball' => 'volleyball',

            'Running' => 'running',

            'Table Tennis' => 'table-tennis',

            'Gym' => 'gym',

            'Futsal' => 'futsal',

        ];


        $sport =
            $in['sport']
            ?? 'Other';


        $type =
            ($in['type'] ?? '') === 'sparring'
            ? 'sparing'
            : 'turnamen';


        $sportIcon =
            $icons[$sport]
            ?? 'sport';


        $pdo->prepare(

            'INSERT INTO posts

            (
                user_id,
                type,
                sport,
                sport_icon,
                title,
                loc,
                event_date,
                fee,
                level,
                created_at
            )

            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                NOW()
            )'

        )->execute([

            $uid,

            $type,

            $sport,

            $sportIcon,

            $title,

            $in['loc'] ?? '',

            $in['date'] ?? '',

            $in['fee'] ?? 'Free',

            $in['level'] ?? 'All Levels',

        ]);


        $newId =
            $pdo->lastInsertId();


        $stmt = $pdo->prepare(

            'SELECT
                p.*,
                u.name AS author_name,
                u.role AS author_role

             FROM posts p

             JOIN users u
                ON u.id = p.user_id

             WHERE p.id = ?'

        );


        $stmt->execute([
            $newId
        ]);


        out([

            'ok' => true,

            'post' =>
                post_public(
                    $stmt->fetch()
                )

        ]);

    }


    /* =====================================================
       DELETE OWN POST
       ===================================================== */

    case 'delete_post': {

        require_login();


        $id =
            (int)($in['id'] ?? 0);


        $stmt = $pdo->prepare(

            'SELECT user_id
             FROM posts
             WHERE id = ?'

        );

        $stmt->execute([
            $id
        ]);


        $p = $stmt->fetch();


        if (
            !$p ||
            (int)$p['user_id'] !== (int)$uid
        ) {

            fail(
                'You are not allowed to delete this post'
            );
        }


        $pdo->prepare(

            'DELETE FROM posts
             WHERE id = ?'

        )->execute([
            $id
        ]);


        out([
            'ok' => true
        ]);

    }


    /* =====================================================
       GET ALL USERS
       ===================================================== */

    case 'get_users': {

        require_login();


        $rows = $pdo->query(

            'SELECT
                u.id,
                u.name,
                u.fav_sport,
                u.role,
                u.created_at,
                COUNT(p.id) AS post_count

             FROM users u

             LEFT JOIN posts p
                ON p.user_id = u.id

             GROUP BY
                u.id,
                u.name,
                u.fav_sport,
                u.role,
                u.created_at

             ORDER BY
                CASE
                    WHEN u.role = "admin"
                    THEN 0
                    ELSE 1
                END,

                u.name ASC'

        )->fetchAll();


        $users = [];


        foreach ($rows as $row) {

            $users[] = [

                'id' =>
                    (int)$row['id'],

                'name' =>
                    $row['name'],

                'favSport' =>
                    $row['fav_sport'] ?? '-',

                'role' =>
                    $row['role'] ?? 'member',

                'createdAt' =>
                    $row['created_at'],

                'postCount' =>
                    (int)$row['post_count']

            ];

        }


        out([

            'ok' => true,

            'users' => $users

        ]);

    }


    /* =====================================================
       GET USER PROFILE
       ===================================================== */

    case 'get_user_profile': {

        require_login();


        $id =
            (int)($in['userId'] ?? 0);


        if (!$id) {

            fail(
                'Invalid user'
            );
        }


        $user =
            get_user_data($id);


        if (!$user) {

            fail(
                'User not found'
            );
        }


        $stmt = $pdo->prepare(

            'SELECT
                p.*,
                u.name AS author_name,
                u.role AS author_role

             FROM posts p

             JOIN users u
                ON u.id = p.user_id

             WHERE p.user_id = ?

             ORDER BY
                p.created_at DESC'

        );


        $stmt->execute([
            $id
        ]);


        $posts =
            $stmt->fetchAll();


        out([

            'ok' => true,

            'user' => [

                'id' =>
                    (int)$user['id'],

                'name' =>
                    $user['name'],

                'email' =>
                    $user['email'],

                'favSport' =>
                    $user['fav_sport'] ?? '-',

                'role' =>
                    $user['role'] ?? 'member',

                'createdAt' =>
                    $user['created_at'],

                'postCount' =>
                    (int)$user['post_count']

            ],

            'posts' =>
                array_map(
                    'post_public',
                    $posts
                )

        ]);

    }


    /* =====================================================
       MEMBER DASHBOARD
       ===================================================== */

    case 'member_dashboard': {

        require_login();


        $stmt = $pdo->prepare(

            'SELECT

                COUNT(*) AS total_posts,

                COALESCE(
                    SUM(type = "turnamen"),
                    0
                ) AS tournaments,

                COALESCE(
                    SUM(type = "sparing"),
                    0
                ) AS sparring

             FROM posts

             WHERE user_id = ?'

        );


        $stmt->execute([
            $uid
        ]);


        $stats =
            $stmt->fetch();


        $totalUsers =
            $pdo->query(

                'SELECT COUNT(*)
                 AS total
                 FROM users'

            )->fetch()['total'];


        out([

            'ok' => true,

            'dashboard' => [

                'totalUsers' =>
                    (int)$totalUsers,

                'totalPosts' =>
                    (int)($stats['total_posts'] ?? 0),

                'tournaments' =>
                    (int)($stats['tournaments'] ?? 0),

                'sparring' =>
                    (int)($stats['sparring'] ?? 0)

            ]

        ]);

    }


    /* =====================================================
       ADMIN DASHBOARD
       ===================================================== */

    case 'admin_dashboard': {

        require_admin();


        $users =
            $pdo->query(

                'SELECT COUNT(*)
                 AS total
                 FROM users'

            )->fetch()['total'];


        $posts =
            $pdo->query(

                'SELECT COUNT(*)
                 AS total
                 FROM posts'

            )->fetch()['total'];


        $tournaments =
            $pdo->query(

                'SELECT COUNT(*)
                 AS total
                 FROM posts
                 WHERE type = "turnamen"'

            )->fetch()['total'];


        $sparring =
            $pdo->query(

                'SELECT COUNT(*)
                 AS total
                 FROM posts
                 WHERE type = "sparing"'

            )->fetch()['total'];


        out([

            'ok' => true,

            'dashboard' => [

                'users' =>
                    (int)$users,

                'posts' =>
                    (int)$posts,

                'tournaments' =>
                    (int)$tournaments,

                'sparring' =>
                    (int)$sparring

            ]

        ]);

    }


    /* =====================================================
       ADMIN DELETE USER
       ===================================================== */

    case 'admin_delete_user': {

        require_admin();


        $id =
            (int)($in['userId'] ?? 0);


        if (!$id) {

            fail(
                'Invalid user'
            );
        }


        /* Prevent admin from deleting themselves */

        if ($id === (int)$uid) {

            fail(
                'You cannot delete your own admin account'
            );
        }


        /* Check target user */

        $stmt = $pdo->prepare(

            'SELECT id, role
             FROM users
             WHERE id = ?
             LIMIT 1'

        );


        $stmt->execute([
            $id
        ]);


        $target =
            $stmt->fetch();


        if (!$target) {

            fail(
                'User not found'
            );
        }


        /* Admin cannot delete another admin */

        if (
            ($target['role'] ?? 'member')
            === 'admin'
        ) {

            fail(
                'Admin accounts cannot be deleted here'
            );
        }


        $pdo->prepare(

            'DELETE FROM users
             WHERE id = ?'

        )->execute([
            $id
        ]);


        out([

            'ok' => true

        ]);

    }


    /* =====================================================
       ADMIN DELETE POST
       ===================================================== */

    case 'admin_delete_post': {

        require_admin();


        $id =
            (int)($in['id'] ?? 0);


        if (!$id) {

            fail(
                'Invalid post'
            );
        }


        $stmt = $pdo->prepare(

            'SELECT id
             FROM posts
             WHERE id = ?
             LIMIT 1'

        );


        $stmt->execute([
            $id
        ]);


        if (!$stmt->fetch()) {

            fail(
                'Post not found'
            );
        }


        $pdo->prepare(

            'DELETE FROM posts
             WHERE id = ?'

        )->execute([
            $id
        ]);


        out([

            'ok' => true

        ]);

    }


    /* =====================================================
       DEFAULT
       ===================================================== */

    default:

        fail(
            'Unknown action'
        );
}
?>