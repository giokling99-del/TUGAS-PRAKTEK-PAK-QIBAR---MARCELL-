<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FindMyLeague — Find Tournaments & Sparring Partners</title>
<style>
  :root{
    --bg:#080808; --card:#111111; --card2:#171717;
    --accent:#c7ff00; --accent2:#eaff8a;
    --text:#f5f5f5; --muted:#9b9b9b;
    --radius:0px;
    --line-a:#2a2a2a; --line-b:#343434; --line-c:#242424; --line-d:#3a3a3a;
  }
  *{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Arial,system-ui,sans-serif;}
  body{background:var(--bg);color:var(--text);line-height:1.6;transition:background .3s,color .3s;}
  a{color:inherit;text-decoration:none;}
  body.light{
    --bg:#f4f4f0; --card:#fff; --card2:#ecece7;
    --text:#111; --muted:#626262;
    --line-a:#d8d8d2; --line-b:#c9c9c2; --line-c:#deded8; --line-d:#c3c3bc;
  }
  body.light nav{background:rgba(244,244,240,.92);}
  body.light .cta{background:linear-gradient(135deg,#e9f5a8,#f7f7f2);border-color:#d2df8b;}
  body.light header{background:radial-gradient(circle at 15% 20%,rgba(199,255,0,.22),transparent 30%),linear-gradient(135deg,#f4f4f0,#ffffff 52%,#eef2d8);}
  .card{transition:transform .25s,border-color .25s,box-shadow .25s,background .3s;}
  .theme-btn{background:var(--card);border:1px solid var(--line-b);border-radius:50%;
    width:38px;height:38px;cursor:pointer;font-size:1.05rem;display:flex;
    align-items:center;justify-content:center;transition:.2s;}
  .theme-btn:hover{border-color:var(--accent);transform:rotate(20deg);}

  /* NAVBAR */
  nav{display:flex;justify-content:space-between;align-items:center;
      padding:16px 6%;position:sticky;top:0;background:rgba(8,8,8,.92);
      backdrop-filter:blur(12px);z-index:50;border-bottom:1px solid var(--line-a);}
  .logo{font-size:1.4rem;font-weight:900;letter-spacing:-.04em;}
  .logo span{color:var(--accent);}
  .nav-links{display:flex;gap:24px;align-items:center;font-size:.95rem;}
  .nav-links a{color:var(--muted);transition:.2s;}
  .nav-links a:hover{color:var(--accent);}
  .btn{display:inline-block;padding:10px 22px;border-radius:2px;font-weight:700;
       cursor:pointer;border:none;transition:.25s;font-size:.95rem;}
  .btn-accent{background:var(--accent);color:#080808;}
  .btn-accent:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(199,255,0,.22);}
  .btn-ghost{background:transparent;color:var(--accent);border:1px solid var(--accent);}
  .btn-ghost:hover{background:rgba(199,255,0,.08);}

  /* USER MENU */
  .user-menu{display:flex;align-items:center;gap:10px;cursor:pointer;
    background:var(--card);border:1px solid var(--line-b);padding:6px 14px 6px 6px;border-radius:2px;}
  .avatar{width:32px;height:32px;border-radius:50%;background:var(--accent);
    display:flex;align-items:center;justify-content:center;font-weight:900;color:#080808;font-size:.9rem;}
  .user-menu span{font-size:.9rem;font-weight:700;}

  /* HERO */
  header{padding:100px 6% 75px;text-align:center;position:relative;overflow:hidden;isolation:isolate;
    background:radial-gradient(circle at 15% 20%,rgba(199,255,0,.14),transparent 28%),
      radial-gradient(circle at 85% 75%,rgba(199,255,0,.09),transparent 30%),
      linear-gradient(135deg,#080808 0%,#111111 48%,#080808 100%);}
  header::before{content:'';position:absolute;inset:-35%;z-index:-1;pointer-events:none;
    background:repeating-linear-gradient(115deg,transparent 0 70px,rgba(199,255,0,.055) 71px,transparent 73px 145px);
    animation:heroDrift 18s linear infinite;transform:rotate(-8deg);}
  header::after{content:'';position:absolute;inset:0;z-index:-1;pointer-events:none;
    background:linear-gradient(90deg,transparent,rgba(255,255,255,.035),transparent);
    transform:translateX(-100%);animation:heroSweep 9s ease-in-out infinite;}
  @keyframes heroDrift{from{transform:translate3d(-4%,0,0) rotate(-8deg)}to{transform:translate3d(4%,3%,0) rotate(-8deg)}}
  @keyframes heroSweep{0%,35%{transform:translateX(-100%)}70%,100%{transform:translateX(100%)}}
  @media (prefers-reduced-motion:reduce){header::before,header::after{animation:none;}}
  header h1{font-size:clamp(2.2rem,5vw,3.8rem);line-height:1.05;max-width:900px;margin:0 auto 20px;
    font-weight:900;letter-spacing:-.05em;text-transform:uppercase;}
  header h1 .grad{background:linear-gradient(90deg,var(--accent),#f0ffad);
    -webkit-background-clip:text;background-clip:text;color:transparent;}
  header p{color:var(--muted);max-width:560px;margin:0 auto 34px;font-size:1.05rem;}
  .search-bar{display:flex;gap:10px;max-width:680px;margin:0 auto;flex-wrap:wrap;justify-content:center;}
  .search-bar input,.search-bar select{
    padding:13px 18px;border-radius:2px;border:1px solid var(--line-b);background:var(--card);
    color:var(--text);font-size:.95rem;outline:none;min-width:180px;flex:1;}
  .search-bar input:focus,.search-bar select:focus{border-color:var(--accent);}

  /* SPORTS CHIP */
  .sports{padding:26px 6%;display:flex;gap:10px;flex-wrap:wrap;justify-content:center;}
  .chip{padding:9px 20px;border-radius:2px;background:var(--card);border:1px solid var(--line-b);
        cursor:pointer;transition:.2s;font-size:.9rem;color:var(--muted);}
  .chip:hover,.chip.active{border-color:var(--accent);color:var(--accent);background:rgba(199,255,0,.07);}

  /* SECTION */
  section{padding:55px 6%;}
  .section-title{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;flex-wrap:wrap;gap:14px;}
  .section-title h2{font-size:1.6rem;font-weight:850;letter-spacing:-.03em;text-transform:uppercase;}
  .section-title p{color:var(--muted);font-size:.92rem;width:100%;margin-top:-8px;}
  .tabs{display:flex;gap:8px;}
  .tab{padding:9px 20px;border-radius:2px;background:var(--card);border:1px solid var(--line-b);
       cursor:pointer;color:var(--muted);font-size:.9rem;}
  .tab.active{background:var(--accent);color:#080808;font-weight:800;border-color:var(--accent);}

  /* CARDS */
  .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;}
  .card{background:var(--card);border:1px solid var(--line-c);border-radius:var(--radius);
        padding:22px;transition:.25s;cursor:pointer;position:relative;}
  .card:hover{transform:translateY(-4px);border-color:var(--accent);box-shadow:0 12px 30px rgba(0,0,0,.45);}
  .card .top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;}
  .badge{padding:4px 12px;border-radius:2px;font-size:.75rem;font-weight:800;}
  .badge-tourney{background:rgba(199,255,0,.12);color:var(--accent);}
  .badge-spar{background:rgba(255,255,255,.08);color:#ddd;}
  .card h3{font-size:1.15rem;margin-bottom:6px;}
  .card .meta{color:var(--muted);font-size:.86rem;display:flex;flex-direction:column;gap:5px;margin:12px 0;}
  .meta div::before{margin-right:8px;}
  .meta .loc::before{content:'📍';}
  .meta .date::before{content:'📅';}
  .meta .fee::before{content:'💰';}
  .card .bottom{display:flex;justify-content:space-between;align-items:center;margin-top:14px;}
  .card .lvl{font-size:.78rem;color:var(--muted);background:var(--card2);padding:4px 12px;border-radius:2px;}
  .join{font-size:.85rem;color:var(--accent);font-weight:800;}
  .author-tag{font-size:.78rem;color:var(--muted);margin-top:10px;border-top:1px dashed var(--line-b);padding-top:8px;}
  .del-btn{position:absolute;top:14px;right:14px;background:rgba(255,82,82,.12);color:#ff6b6b;
    border:none;border-radius:2px;width:28px;height:28px;cursor:pointer;font-size:.9rem;display:none;}
  .card.mine .del-btn{display:block;}
  .empty{grid-column:1/-1;text-align:center;color:var(--muted);padding:40px;}

  /* CTA */
  .cta{margin:40px 6% 60px;background:linear-gradient(135deg,#151a0a,#111);
       border:1px solid #343d18;border-radius:2px;padding:44px 6%;display:flex;
       justify-content:space-between;align-items:center;gap:24px;flex-wrap:wrap;}
  .cta h2{font-size:1.6rem;margin-bottom:8px;font-weight:850;}
  .cta p{color:var(--muted);max-width:520px;}

  /* MODAL */
  .modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.78);display:none;
    justify-content:center;align-items:center;z-index:100;padding:20px;}
  .modal-overlay.show{display:flex;}
  .modal{background:var(--card2);border:1px solid var(--line-b);border-radius:2px;
         padding:32px;max-width:460px;width:100%;max-height:90vh;overflow-y:auto;}
  .modal h2{margin-bottom:6px;font-size:1.4rem;}
  .modal .sub{color:var(--muted);font-size:.88rem;margin-bottom:20px;}

  /* AUTH */
  .auth-tabs{display:flex;background:var(--bg);border-radius:2px;padding:4px;margin-bottom:22px;}
  .auth-tabs button{flex:1;padding:10px;border:none;border-radius:2px;background:transparent;
    color:var(--muted);font-weight:600;cursor:pointer;font-size:.95rem;}
  .auth-tabs button.active{background:var(--accent);color:#080808;}
  .pw-wrap{position:relative;}
  .pw-toggle{position:absolute;right:12px;top:50%;transform:translateY(-50%);
    background:none;border:none;color:var(--muted);cursor:pointer;font-size:1rem;}
  .error-msg{background:rgba(255,82,82,.12);color:#ff6b6b;padding:10px 14px;border-radius:2px;
    font-size:.85rem;margin-bottom:14px;display:none;}
  .strength{height:5px;border-radius:2px;background:var(--bg);margin-top:8px;overflow:hidden;}
  .strength div{height:100%;width:0;transition:.3s;border-radius:2px;}

  .form-group{margin-bottom:16px;}
  .form-group label{display:block;font-size:.85rem;color:var(--muted);margin-bottom:6px;}
  .form-group input,.form-group select,.form-group textarea{
    width:100%;padding:11px 14px;border-radius:2px;border:1px solid var(--line-d);
    background:var(--bg);color:var(--text);font-size:.95rem;outline:none;}
  .form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:var(--accent);}
  .form-actions{display:flex;gap:12px;margin-top:22px;}
  .form-actions .btn{flex:1;}
  .btn-cancel{background:var(--card);color:var(--muted);border:1px solid var(--line-d);}

  /* PROFILE */
  .profile-head{display:flex;gap:18px;align-items:center;margin-bottom:24px;}
  .profile-head .avatar{width:64px;height:64px;font-size:1.6rem;}
  .profile-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px;}
  .stat-box{background:var(--bg);border:1px solid var(--line-b);border-radius:2px;padding:14px;text-align:center;}
  .stat-box b{font-size:1.3rem;color:var(--accent);display:block;}
  .stat-box span{font-size:.78rem;color:var(--muted);}
  .profile-posts h3{font-size:1rem;margin-bottom:12px;color:var(--muted);}
  .p-item{background:var(--bg);border:1px solid var(--line-b);border-radius:2px;padding:12px 16px;
    margin-bottom:8px;display:flex;justify-content:space-between;align-items:center;font-size:.9rem;}
  .p-item small{color:var(--muted);display:block;font-size:.78rem;}

  /* TOAST */
  .toast{position:fixed;bottom:24px;left:50%;transform:translateX(-50%) translateY(100px);
    background:var(--accent);color:#080808;padding:13px 26px;border-radius:2px;
    font-weight:800;transition:.35s;z-index:300;opacity:0;white-space:nowrap;}
  .toast.show{transform:translateX(-50%) translateY(0);opacity:1;}
  .toast.err{background:#ff5252;color:#fff;}

  footer{border-top:1px solid var(--line-a);padding:34px 6%;text-align:center;color:var(--muted);font-size:.88rem;}
  footer .logo{display:block;margin-bottom:8px;}

  @media(max-width:640px){
    .nav-links a.nav-plain{display:none;}
    header{padding:60px 6% 50px;}
    .toast{white-space:normal;text-align:center;max-width:90vw;}
  }

/* Premium sport selector icons */
.chip{display:inline-flex;align-items:center;gap:9px}
.sport-icon{width:17px;height:17px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 17px}
.sport-icon svg{width:17px;height:17px;fill:none;stroke:currentColor;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}
.chip.active .sport-icon{filter:drop-shadow(0 0 7px rgba(199,255,0,.35))}


.card-sport-icon{display:inline-flex;width:24px;height:24px;align-items:center;justify-content:center}
.card-sport-icon svg{width:22px;height:22px;fill:none;stroke:currentColor;stroke-width:1.6;stroke-linecap:round;stroke-linejoin:round}
.sport-icon{width:17px;height:17px;display:inline-flex;align-items:center;justify-content:center;flex:0 0 17px}
.sport-icon svg{width:17px;height:17px;fill:none;stroke:currentColor;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}
.chip{display:inline-flex;align-items:center;gap:9px}
.chip.active .sport-icon{filter:drop-shadow(0 0 7px rgba(199,255,0,.35))}
</style>
<base target="_blank">
</head>
<body>

<nav>
  <a class="logo" href="#">Find<span>My</span>League</a>
  <div class="nav-links" id="navLinks">
    <a href="#jelajah" class="nav-plain">Explore</a>
    <button class="theme-btn" id="themeBtn" onclick="toggleTheme()" title="Ganti tema">☀️</button>
    <button class="btn btn-ghost" id="postBtn" onclick="handlePostClick()">+ Create Post</button>
    <button class="btn btn-accent" id="authBtn" onclick="openAuth()">Login</button>
  </div>
</nav>

<header>
  <h1>Find <span class="grad">Tournaments</span> & <span class="grad">Sparring Partners</span> Near You</h1>
  <p>Stop scrolling through endless group chats. One platform for all your sports needs — tournaments, partners, and matches.</p>
  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search tournaments or sparring..." oninput="render()">
    <select id="citySelect" onchange="render()">
      <option value="">All Cities</option>
      <option>Jakarta</option><option>Bandung</option><option>Surabaya</option>
      <option>Yogyakarta</option><option>Bali</option><option>Medan</option>
    </select>
  </div>
</header>

<div class="sports" id="sportsChips"></div>

<section id="jelajah">
  <div class="section-title">
    <h2>Browse Nearby</h2>
    <p>Find the closest events first, so you do not waste time going back and forth.</p>
    <div class="tabs">
      <button class="tab active" data-type="all" onclick="setType('all',this)">All</button>
      <button class="tab" data-type="tournament" onclick="setType('tournament',this)">Tournaments</button>
      <button class="tab" data-type="sparring" onclick="setType('sparring',this)">Sparring</button>
    </div>
  </div>
  <div class="grid" id="cardGrid"></div>
</section>

<div class="cta">
  <div>
    <h2>Haven’t found the right opponent yet?</h2>
    <p>Create your own sparring or tournament post. Thousands of sports lovers are ready to join.</p>
  </div>
  <button class="btn btn-accent" onclick="handlePostClick()">+ Create Post Free</button>
</div>

<!-- AUTH MODAL -->
<div class="modal-overlay" id="authOverlay" onclick="if(event.target===this)closeAuth()">
  <div class="modal">
    <h2 id="authTitle">Welcome Back </h2>
    <p class="sub" id="authSub">Login to continue your sports journey.</p>
    <div class="auth-tabs">
      <button id="tabLogin" class="active" onclick="switchAuth('login')">Login</button>
      <button id="tabSignup" onclick="switchAuth('signup')">Register</button>
    </div>
    <div class="error-msg" id="authError"></div>
    <div class="form-group" id="nameGroup" style="display:none;">
      <label>Full Name</label>
      <input id="aName" placeholder="Example: Budi Santoso">
    </div>
    <div class="form-group">
      <label>Email</label>
      <input id="aEmail" type="email" placeholder="you@email.com">
    </div>
    <div class="form-group">
      <label>Password</label>
      <div class="pw-wrap">
        <input id="aPass" type="password" placeholder="Minimum 8 characters" oninput="checkStrength()">
        <button class="pw-toggle" onclick="togglePw()">👁️</button>
      </div>
      <div class="strength" id="pwStrength" style="display:none;"><div></div></div>
    </div>
    <div class="form-group" id="pass2Group" style="display:none;">
      <label>Confirm Password</label>
      <input id="aPass2" type="password" placeholder="Re-enter your password">
    </div>
    <div class="form-actions">
      <button class="btn btn-cancel" onclick="closeAuth()">Cancel</button>
      <button class="btn btn-accent" id="authSubmit" onclick="submitAuth()">Login</button>
    </div>
  </div>
</div>

<!-- POST MODAL -->
<div class="modal-overlay" id="modalOverlay" onclick="if(event.target===this)closeModal()">
  <div class="modal">
    <h2>Create New Post</h2>
    <p class="sub">Posted by <b id="postAs" style="color:var(--accent)"></b></p>
    <div class="form-group">
      <label>Post Type</label>
      <select id="fType"><option value="tournament">Tournaments</option><option value="sparring">Sparring</option></select>
    </div>
    <div class="form-group"><label>Title</label><input id="fTitle" placeholder="Example: Neighborhood Futsal Tournament"></div>
    <div class="form-group"><label>Sport</label>
      <select id="fSport"><option>Basketball</option><option>Soccer</option><option>Badminton</option><option>Volleyball</option><option>Running</option><option>Table Tennis</option><option>Gym</option></select>
    </div>
    <div class="form-group"><label>Location</label><input id="fLoc" placeholder="Example: Bandung, 5 km away"></div>
    <div class="form-group"><label>Date & Time</label><input id="fDate" type="datetime-local"></div>
    <div class="form-group"><label>Fee (Rp)</label><input id="fFee" type="number" placeholder="0 = Free"></div>
    <div class="form-group"><label>Skill Level</label>
      <select id="fSkill Level"><option>Beginner</option><option>Intermediate</option><option>Advanced</option><option>All Skill Level</option></select>
    </div>
    <div class="form-group"><label>Description</label><textarea id="fDecc" rows="3" placeholder="Tell us about your event..."></textarea></div>
    <div class="form-actions">
      <button class="btn btn-cancel" onclick="closeModal()">Cancel</button>
      <button class="btn btn-accent" onclick="submitPost()">Publish </button>
    </div>
  </div>
</div>

<!-- PROFILE MODAL -->
<div class="modal-overlay" id="profileOverlay" onclick="if(event.target===this)closeProfileee()">
  <div class="modal">
    <div class="profile-head">
      <div class="avatar" id="pAvatar">B</div>
      <div>
        <h2 id="pName" style="font-size:1.3rem;">Name</h2>
        <p style="color:var(--muted);font-size:.88rem;" id="pEmail">email</p>
      </div>
    </div>
    <div class="profile-stats">
      <div class="stat-box"><b id="pPosts">0</b><span>Posts</span></div>
      <div class="stat-box"><b id="pJoined">0</b><span>Joined</span></div>
      <div class="stat-box"><b id="pSport">-</b><span>Sport</span></div>
    </div>
    <div class="profile-posts">
      <h3>📋 Postsku</h3>
      <div id="pPostList"></div>
    </div>
    <div class="form-actions">
      <button class="btn btn-cancel" onclick="logout()">Logout</button>
      <button class="btn btn-accent" onclick="closeProfileee()">Close</button>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>

<footer>
  <span class="logo">Find<span style="color:var(--accent)">My</span>League</span>
  <p>Made with ❤️ for sports lovers — © 2026</p>
</footer>

<script>
/* ============================================================
   FindMyLeague — Frontend
   Mode ganda:
   • PHP_ENABLED = true  → pakai api.php + MySQL (hosting PHP)
   • PHP_ENABLED = false / api.php tidak ditemukan
     → otomatis fallback ke localStorage (offline/demo)
============================================================ */
const PHP_ENABLED = true;

/* ============ API (PHP) ============ */
async function api(action, data = {}){
  if(!PHP_ENABLED) return null;
  try{
    const r = await fetch('api.php', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify({action, ...data})
    });
    const j = await r.json();
    return (j && j.ok) ? j : null;
  }catch(e){ return null; }
}

/* ============ DATABASE LOKAL (fallback) ============ */
const DB = {
  read(k, f){ try{ return JSON.parse(localStorage.getItem(k)) ?? f; }catch{ return f; } },
  write(k, v){ localStorage.setItem(k, JSON.stringify(v)); }
};
const SEED_POSTS = [
  {id:'s1',userId:null,author:'Admin FML', type:'tournament', sport:'Futsal',      title:'Futsal Cup 2026 — University League',   loc:'Jakarta, 3 km',    date:'2 Oct 2026, 09.00', fee:'Rp 500K/team',   level:'All Skill Level', sportIcon:'⚽'},
  {id:'s2',userId:null,author:'Admin FML', type:'sparring',  sport:'Badminton',   title:'Mixed Doubles Sparring — Saturday Morning', loc:'Bandung, 2 km',    date:'27 Sep 2026, 07.00', fee:'Free',      level:'Intermediate',    sportIcon:'🏸'},
  {id:'s3',userId:null,author:'Admin FML', type:'tournament', sport:'Basketball',      title:'Streetball 3x3 Championship',      loc:'Surabaya, 5 km',   date:'11 Oct 2026, 15.00', fee:'Rp 350K/team', level:'Advanced',    sportIcon:'🏀'},
  {id:'s4',userId:null,author:'Admin FML', type:'sparring',  sport:'Volleyball',        title:'Indoor Volleyball Sparring Partner',   loc:'Yogyakarta, 4 km', date:'30 Sep 2026, 19.00', fee:'Rp 15K/person',level:'All Skill Level', sportIcon:'🏐'},
  {id:'s5',userId:null,author:'Admin FML', type:'tournament', sport:'Running',        title:'10K Community Fun Run',        loc:'Bali, 8 km',       date:'18 Oct 2026, 06.00', fee:'Rp 150K',     level:'Beginner',      sportIcon:'🏃'},
  {id:'s6',userId:null,author:'Admin FML', type:'sparring',  sport:'Table Tennis',  title:'Night Table Tennis Sparring',    loc:'Medan, 6 km',      date:'28 Sep 2026, 20.00', fee:'Rp 10K/person',level:'Intermediate',    sportIcon:'🏓'},
  {id:'s7',userId:null,author:'Admin FML', type:'tournament', sport:'Soccer',  title:'RW 05 Community Soccer Cup',         loc:'Jakarta, 7 km',    date:'5 Oct 2026, 16.00',  fee:'Rp 1M/team',  level:'All Skill Level', sportIcon:'⚽'},
  {id:'s8',userId:null,author:'Admin FML', type:'sparring',  sport:'Gym',         title:'Gym Buddy — Program Bulking',      loc:'Bandung, 1 km',    date:'Every Day',        fee:'Free',      level:'Beginner',      sportIcon:'🏋️'},
];
if(!localStorage.getItem('fml_posts')) DB.write('fml_posts', SEED_POSTS);
if(!localStorage.getItem('fml_users')) DB.write('fml_users', []);

/* ============ TEMA (DARK / LIGHT) ============ */
function setTheme(t){
  document.body.classList.toggle('light', t === 'light');
  localStorage.setItem('fml_theme', t);
  const b = document.getElementById('themeBtn');
  if(b) b.textContent = t === 'light' ? '🌙' : '☀️';
}
function toggleTheme(){
  setTheme(document.body.classList.contains('light') ? 'dark' : 'light');
  showToast(document.body.classList.contains('light') ? 'Mode terang ☀️' : 'Mode gelap 🌙');
}

/* ============ STATE ============ */
const SPORTS = ['Soccer','Basketball','Badminton','Volleyball','Running','Table Tennis','Gym'];
const SPORT_ICONS = {
  'Futsal':'<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 8.5l3 2.2-1.1 3.6h-3.8L9 10.7z"/><path d="M12 3.5v5M20.1 9l-5.1 1.7M17 19l-3.1-4.7M7 19l3.1-4.7M3.9 9L9 10.7"/></svg>',
  'Soccer':'<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 8.5l3 2.2-1.1 3.6h-3.8L9 10.7z"/><path d="M12 3.5v5M20.1 9l-5.1 1.7M17 19l-3.1-4.7M7 19l3.1-4.7M3.9 9L9 10.7"/></svg>',
  'Basketball':'<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M12 3.5c2.2 2.1 3.4 5 3.4 8.5S14.2 18.4 12 20.5M3.5 12h17M5.5 6.2c2.1 1.7 4.5 2.5 7.2 2.5s5.1-.8 7.2-2.5M5.5 17.8c2.1-1.7 4.5-2.5 7.2-2.5s5.1.8 7.2 2.5"/></svg>',
  'Badminton':'<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14.5 14.5L7 22"/><path d="M13.5 13.5c-3.7 1-7.2-1.5-7.5-5.2-.2-2.4 1.1-4.8 3.3-6.1 3.1-1.8 7.2-.7 9 2.4 1.7 3 .8 6.7-2.1 8.4l-2.7.5z"/><path d="M7 4l-3-1.5M9.5 3.2L7 1M12 3.2L10.5 1"/></svg>',
  'Volleyball':'<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><path d="M4.7 7.5c3.5-.2 6.5 1.2 8.4 4M9.2 20c.2-3.5 1.7-6.3 4.6-8.1M18.9 5.9c-2.9 1.2-4.8 3.5-5.8 6.4"/></svg>',
  'Running':'<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="15.5" cy="4.5" r="2"/><path d="M13.5 8l-3 3 3 2.5-2 4.5M10.5 11L6 10M11.5 18l-2.5 3M14.5 13.5l4 2.5 1.5 3"/></svg>',
  'Table Tennis':'<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4h8v6.5a4 4 0 0 1-4 4H5z"/><path d="M9 14.5L5 21M14 4l5 5M18.5 9.5l-2 2"/></svg>',
  'Gym':'<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 9v6M7 7v10M10 10h4M14 7v10M17 9v6M20 10v4"/></svg>'
};
let activeSport='', activeType='all', authMode='login';
let posts = DB.read('fml_posts', []);
let currentUser = null;
let usingPHP = false;

/* ============ AUTH ============ */
async function hash(text){
  const buf = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(text));
  return [...new Uint8Array(buf)].map(b=>b.toString(16).padStart(2,'0')).join('');
}
function getLocalUser(){
  const s = DB.read('fml_session', null); if(!s) return null;
  return DB.read('fml_users', []).find(u=>u.id===s.userId) || null;
}
function setCurrentUser(u){
  currentUser = u;
  if(u) DB.write('fml_session', {userId:u.id, php:usingPHP});
  else localStorage.removeItem('fml_session');
}

function openAuth(){ document.getElementById('authOverlay').classList.add('show'); clearAuthError(); }
function closeAuth(){ document.getElementById('authOverlay').classList.remove('show'); }

function switchAuth(mode){
  authMode = mode;
  document.getElementById('tabLogin').classList.toggle('active', mode==='login');
  document.getElementById('tabSignup').classList.toggle('active', mode==='signup');
  document.getElementById('nameGroup').style.display = mode==='signup' ? 'block':'none';
  document.getElementById('pass2Group').style.display = mode==='signup' ? 'block':'none';
  document.getElementById('authTitle').textContent = mode==='login' ? 'Welcome Back ' : 'Join FindMyLeague ';
  document.getElementById('authSub').textContent = mode==='login' ? 'Login to continue your sports journey.' : 'Register and start finding your next match.';
  document.getElementById('authSubmit').textContent = mode==='login' ? 'Login' : 'Register Sekarang ✨';
  clearAuthError();
}
function clearAuthError(){ const e=document.getElementById('authError'); e.style.display='none'; e.textContent=''; }
function showAuthError(msg){ const e=document.getElementById('authError'); e.textContent=msg; e.style.display='block'; }

function togglePw(){
  const p = document.getElementById('aPass');
  p.type = p.type==='password' ? 'text' : 'password';
}
function checkStrength(){
  const v = document.getElementById('aPass').value;
  const bar = document.getElementById('pwStrength');
  bar.style.display = v ? 'block':'none';
  const fill = bar.firstElementChild;
  let s = 0;
  if(v.length>=8) s++; if(/[A-Z]/.test(v)) s++; if(/\d/.test(v)) s++; if(/[^A-Za-z0-9]/.test(v)) s++;
  const colors = ['#ff5252','#ff9800','#00b0ff','#00e676'];
  fill.style.width = (s*25)+'%'; fill.style.background = colors[s-1]||'#ff5252';
}

async function submitAuth(){
  const email = document.getElementById('aEmail').value.trim().toLowerCase();
  const pass = document.getElementById('aPass').value;

  if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return showAuthError('Please enter a valid email address.');
  if(!pass) return showAuthError('Kata sandi wajib diisi. 🔒');

  if(authMode==='signup'){
    const name = document.getElementById('aName').value.trim();
    const pass2 = document.getElementById('aPass2').value;
    if(name.length<3) return showAuthError('Name minimal 3 karakter. ✍️');
    if(pass.length<8) return showAuthError('Kata sandi minimal 8 karakter. 🔒');
    if(pass!==pass2) return showAuthError('Passwords do not match.');

    // Coba PHP dulu
    const res = await api('register', {name, email, pass});
    if(res){
      usingPHP = true;
      setCurrentUser(res.user);
      afterAuth(`Welcome, ${res.user.name.split(' ')[0]}! 🎉`);
      return;
    }
    // Fallback local
    const users = DB.read('fml_users', []);
    if(users.some(u=>u.email===email)) return showAuthError('Email is already registered. Try logging in instead.');
    const user = { id:'u'+Date.now(), name, email, passHash: await hash(pass), favSport:'-', createdAt:new Date().toISOString() };
    users.push(user); DB.write('fml_users', users);
    setCurrentUser(user);
    afterAuth(`Welcome, ${user.name.split(' ')[0]}! 🎉`);

  } else {
    const res = await api('login', {email, pass});
    if(res){
      usingPHP = true;
      setCurrentUser(res.user);
      afterAuth(`Halo lagi, ${res.user.name.split(' ')[0]}! `);
      return;
    }
    const users = DB.read('fml_users', []);
    const user = users.find(u=>u.email===email);
    if(!user) return showAuthError('Email is not registered. Please register first.');
    if(user.passHash !== await hash(pass)) return showAuthError('Kata sandi salah. Coba lagi! 🔒');
    setCurrentUser(user);
    afterAuth(`Halo lagi, ${user.name.split(' ')[0]}! `);
  }
}

function afterAuth(msg){
  closeAuth(); updateNav();
  ['aName','aEmail','aPass','aPass2'].forEach(id=>document.getElementById(id).value='');
  checkStrength();
  showToast(msg);
}

async function logout(){
  await api('logout');
  setCurrentUser(null);
  usingPHP = false;
  closeProfileee(); updateNav();
  showToast('See you next time. Keep moving!');
}

function updateNav(){
  const btn = document.getElementById('authBtn');
  if(currentUser){
    const initial = currentUser.name.charAt(0).toUpperCase();
    if(btn.classList.contains('btn')){
      btn.outerHTML = `<div class="user-menu" id="authBtn" onclick="openProfileee()">
        <div class="avatar">${initial}</div><span>${currentUser.name.split(' ')[0]}</span></div>`;
    }
  } else {
    const el = document.getElementById('authBtn');
    if(!el.classList.contains('btn')){
      el.outerHTML = `<button class="btn btn-accent" id="authBtn" onclick="openAuth()">Login</button>`;
    } else el.onclick = openAuth;
  }
  render();
}

/* ============ PROFILE ============ */
function openProfileee(){
  if(!currentUser) return openAuth();
  document.getElementById('pName').textContent = currentUser.name;
  document.getElementById('pEmail').textContent = currentUser.email;
  document.getElementById('pAvatar').textContent = currentUser.name.charAt(0).toUpperCase();
  const mine = posts.filter(p=>String(p.userId)===String(currentUser.id));
  document.getElementById('pPosts').textContent = mine.length;
  document.getElementById('pJoined').textContent = currentUser.createdAt
    ? new Date(currentUser.createdAt).toLocaleDateString('id-ID',{month:'short',year:'numeric'}) : '-';
  document.getElementById('pSport').textContent = currentUser.favSport || '-';
  document.getElementById('pPostList').innerHTML = mine.length
    ? mine.map(p=>`<div class="p-item"><div>${SPORT_ICONS[p.sport]||''} ${p.title}<small>${p.type==='tournament'?'Tournaments':'Sparring'} • ${p.loc} • ${p.date}</small></div>
       <button class="del-btn" style="display:block;position:static;" onclick="event.stopPropagation();deletePost('${p.id}')">🗑️</button></div>`).join('')
    : '<p style="color:var(--muted);font-size:.88rem;">No posts yet. Be the first to create one!</p>';
  document.getElementById('profileOverlay').classList.add('show');
}
function closeProfileee(){ document.getElementById('profileOverlay').classList.remove('show'); }

/* ============ POSTS ============ */
function handlePostClick(){
  if(!currentUser){ showToast('Login to create a post.', true); return openAuth(); }
  document.getElementById('postAs').textContent = currentUser.name;
  document.getElementById('modalOverlay').classList.add('show');
}
function openModal(){ handlePostClick(); }
function closeModal(){ document.getElementById('modalOverlay').classList.remove('show'); }

async function deletePost(id){
  const res = await api('delete_post', {id});
  if(res){
    posts = posts.filter(p=>String(p.id)!==String(id));
  } else {
    posts = posts.filter(p=>String(p.id)!==String(id));
    DB.write('fml_posts', posts);
  }
  closeProfileee(); render();
  showToast('Posts dihapus. 🗑️');
}

async function submitPost(){
  const title = document.getElementById('fTitle').value.trim();
  if(!title){ showToast('Please enter a title.', true); return; }
  const sport = document.getElementById('fSport').value;
  const dt = document.getElementById('fDate').value;
  const payload = {
    type: document.getElementById('fType').value, sport,
    title,
    loc: document.getElementById('fLoc').value || 'Location not provided',
    date: dt ? new Date(dt).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'}) : 'Segera',
    fee: document.getElementById('fFee').value ? 'Rp '+Number(document.getElementById('fFee').value).toLocaleString('id-ID') : 'Free',
    level: document.getElementById('fSkill Level').value,
  };
  const res = await api('create_post', payload);
  if(res){
    posts.unshift(res.post);
  } else {
    posts.unshift({
      id:'p'+Date.now(), userId:currentUser.id, author:currentUser.name,
      sportIcon: SPORT_ICONS[sport]||'🏅', ...payload, createdAt:new Date().toISOString()
    });
    DB.write('fml_posts', posts);
  }
  closeModal();
  ['fTitle','fLoc','fDate','fFee','fDecc'].forEach(id=>document.getElementById(id).value='');
  activeType='all'; activeSport='';
  document.querySelectorAll('.tab').forEach(x=>x.classList.toggle('active', x.dataset.type==='all'));
  renderChips(); render();
  showToast('Posts berhasil dipublikasikan! 🎉');
  document.getElementById('jelajah').scrollIntoView({behavior:'smooth'});
}

/* ============ RENDER ============ */
const grid = document.getElementById('cardGrid');
const chipsEl = document.getElementById('sportsChips');

function renderChips(){
  const allIcon = '<svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="2.2"/><path d="M12 3.5v4M20.5 12h-4M12 20.5v-4M3.5 12h4"/></svg>';
  chipsEl.innerHTML = `<div class="chip ${activeSport===''?'active':''}" onclick="setSport('')"><span class="sport-icon">${allIcon}</span>All</div>` +
    SPORTS.map(s => `<div class="chip ${activeSport===s?'active':''}" onclick="setSport('${s}')"><span class="sport-icon">${SPORT_ICONS[s]||''}</span>${s}</div>`).join('');
}
function setSport(s){ activeSport = s; renderChips(); render(); }
function setType(t, el){ activeType = t; document.querySelectorAll('.tab').forEach(x=>x.classList.remove('active')); el.classList.add('active'); render(); }

function render(){
  const q = document.getElementById('searchInput').value.toLowerCase();
  const city = document.getElementById('citySelect').value;
  const filtered = posts.filter(p => {
    const matchType = activeType==='all' || p.type===activeType;
    const matchSport = !activeSport || (p.sportIcon+' '+p.sport)===activeSport || activeSport.includes(p.sport);
    const matchCity = !city || p.loc.toLowerCase().includes(city.toLowerCase());
    const matchQ = !q || p.title.toLowerCase().includes(q) || p.sport.toLowerCase().includes(q) || p.loc.toLowerCase().includes(q);
    return matchType && matchSport && matchCity && matchQ;
  });
  if(!filtered.length){
    grid.innerHTML = '<div class="empty">No results. Try changing the filters or <a href="#" onclick="handlePostClick()" style="color:var(--accent)">create your own post</a>! 💪</div>';
    return;
  }
  grid.innerHTML = filtered.map(p => `
    <div class="card ${currentUser&&String(p.userId)===String(currentUser.id)?'mine':''}">
      <button class="del-btn" title="Hapus" onclick="event.stopPropagation();deletePost('${p.id}')">🗑️</button>
      <div class="top">
        <span class="badge ${p.type==='tournament'?'badge-tourney':'badge-spar'}">${p.type==='tournament'?'TOURNAMENT':'SPARRING'}</span>
        <span class="card-sport-icon">${SPORT_ICONS[p.sport]||''}</span>
      </div>
      <h3>${p.title}</h3>
      <div class="meta">
        <div class="loc">${p.loc}</div>
        <div class="date">${p.date}</div>
        <div class="fee">${p.fee}</div>
      </div>
      <div class="bottom">
        <span class="lvl">${p.sport} • ${p.level}</span>
        <span class="join">Gabung →</span>
      </div>
      <div class="author-tag">👤 ${p.author||'Anonim'}</div>
    </div>`).join('');
}

/* ============ TOAST ============ */
let toastTimer;
function showToast(msg, isErr=false){
  const t = document.getElementById('toast');
  t.textContent = msg;
  t.classList.toggle('err', !!isErr);
  t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(()=>t.classList.remove('show'), 2800);
}

/* ============ INIT ============ */
(async function init(){
  setTheme(localStorage.getItem('fml_theme') || 'dark');

  // Coba ambil sesi dari PHP
  const me = await api('me');
  if(me){
    usingPHP = true;
    currentUser = me.user;
    const gp = await api('get_posts');
    if(gp) posts = gp.posts;
  } else {
    currentUser = getLocalUser();
    posts = DB.read('fml_posts', []);
  }
  updateNav();
  renderChips();
})();
</script>
</body>
</html>