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

/* =========================================================
   DASHBOARD / COMMUNITY / USER PROFILE
   ========================================================= */
.dashboard-overlay,.community-overlay{position:fixed;inset:0;z-index:9999;display:none;align-items:center;justify-content:center;padding:24px;background:rgba(0,0,0,.84);backdrop-filter:blur(14px)}
.dashboard-overlay.show,.community-overlay.show{display:flex}
.dashboard-modal,.community-modal{width:min(1050px,100%);max-height:92vh;overflow-y:auto;background:#101010;border:1px solid #292929;box-shadow:0 30px 100px rgba(0,0,0,.8);padding:30px}
.dashboard-header{display:flex;justify-content:space-between;align-items:flex-start;gap:20px;margin-bottom:25px}.dashboard-label{display:block;color:var(--accent);font-size:.66rem;font-weight:900;letter-spacing:.18em;text-transform:uppercase;margin-bottom:6px}.dashboard-header h2{font-size:2.2rem;line-height:1;font-weight:950;text-transform:uppercase;letter-spacing:-.05em}.dashboard-header p{margin-top:8px;color:#777;font-size:.84rem}.dashboard-close{width:40px;height:40px;background:#181818;border:1px solid #333;color:#fff;font-size:1.5rem;cursor:pointer}.dashboard-close:hover{color:var(--accent);border-color:var(--accent)}
.dashboard-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:14px}.dashboard-stat{background:#151515;border:1px solid #292929;padding:20px}.dashboard-stat-number{display:block;color:var(--accent);font-size:2rem;line-height:1;font-weight:950;margin-bottom:8px}.dashboard-stat-label{color:#777;font-size:.68rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em}
.dashboard-panel{background:#151515;border:1px solid #292929;padding:22px;margin-bottom:12px}.dashboard-panel-title{display:flex;justify-content:space-between;align-items:flex-start;gap:15px;margin-bottom:18px}.dashboard-panel-title h3{font-size:1.05rem;text-transform:uppercase;font-weight:900}.dashboard-description{color:#888;font-size:.84rem;line-height:1.7}.role-badge{display:inline-flex;padding:5px 9px;font-size:.6rem;font-weight:950;letter-spacing:.1em;border:1px solid #444}.role-badge.member{color:#aaa;background:#1b1b1b}.role-badge.admin{color:#080808;background:var(--accent);border-color:var(--accent)}
.dashboard-profile{display:flex;align-items:center;gap:18px}.dashboard-avatar{width:68px;height:68px;flex:0 0 68px;display:flex;align-items:center;justify-content:center;background:var(--accent);color:#080808;font-size:1.7rem;font-weight:950;border-radius:50%}.dashboard-profile-info h3{font-size:1.3rem;font-weight:900}.dashboard-profile-info>p{color:#777;font-size:.82rem;margin-top:3px}.dashboard-profile-meta{display:flex;flex-wrap:wrap;gap:18px;margin-top:11px;color:#777;font-size:.74rem}.dashboard-profile-meta b{color:#ddd}
.dashboard-actions{display:grid;grid-template-columns:repeat(3,1fr);gap:9px}.dashboard-action{display:flex;align-items:center;gap:12px;text-align:left;padding:15px;background:#101010;border:1px solid #292929;color:#fff;cursor:pointer;transition:.2s}.dashboard-action:hover{border-color:var(--accent);transform:translateY(-2px)}.action-icon{width:38px;height:38px;display:flex;align-items:center;justify-content:center;background:var(--accent);color:#080808;font-size:1.15rem;font-weight:900;flex-shrink:0}.dashboard-action b{display:block;font-size:.78rem;text-transform:uppercase}.dashboard-action small{display:block;color:#777;font-size:.67rem;margin-top:3px}
.dashboard-small-btn{background:transparent;color:var(--accent);border:1px solid var(--accent);padding:7px 11px;font-size:.65rem;font-weight:800;cursor:pointer}.dashboard-small-btn:hover{background:var(--accent);color:#080808}.admin-user-list,.admin-post-list{display:flex;flex-direction:column;gap:7px}.admin-user,.admin-post{display:flex;justify-content:space-between;align-items:center;gap:15px;padding:13px;background:#101010;border:1px solid #292929}.admin-user-left{display:flex;align-items:center;gap:12px;min-width:0}.admin-user-avatar{width:40px;height:40px;flex:0 0 40px;border-radius:50%;background:var(--accent);color:#080808;display:flex;align-items:center;justify-content:center;font-weight:900}.admin-user-name{font-weight:800;font-size:.82rem}.admin-user-email,.admin-post-meta{color:#666;font-size:.68rem;margin-top:3px}.admin-user-actions{display:flex;gap:7px}.admin-view-btn,.admin-delete-btn{padding:7px 10px;font-size:.62rem;font-weight:900;cursor:pointer}.admin-view-btn{color:var(--accent);background:transparent;border:1px solid var(--accent)}.admin-delete-btn{color:#ff6868;background:transparent;border:1px solid #713535}.admin-delete-btn:hover{background:#ff5050;color:#080808;border-color:#ff5050}.admin-post-title{font-weight:800;font-size:.8rem}.dashboard-loading{color:#666;font-size:.78rem;padding:12px 0}
.community-modal{width:min(900px,100%)}.community-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}.community-card{background:#151515;border:1px solid #292929;padding:17px;transition:.2s}.community-card:hover{border-color:var(--accent);transform:translateY(-2px)}.community-card-top{display:flex;align-items:center;gap:12px;margin-bottom:14px}.community-avatar{width:46px;height:46px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:var(--accent);color:#080808;font-weight:950}.community-name{font-weight:850;font-size:.86rem}.community-sport{color:#777;font-size:.7rem;margin-top:2px}.community-view{width:100%;padding:9px;background:transparent;border:1px solid #333;color:#ddd;cursor:pointer;font-size:.65rem;font-weight:900;text-transform:uppercase;margin-top:10px}.community-view:hover{color:var(--accent);border-color:var(--accent)}
.other-profile{background:#151515;border:1px solid #292929;padding:22px}.other-profile-head{display:flex;align-items:center;gap:15px;margin-bottom:20px}.other-profile-avatar{width:65px;height:65px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:var(--accent);color:#080808;font-weight:950;font-size:1.4rem}.other-profile-head h3{font-size:1.2rem;font-weight:900}.other-profile-head p{color:#777;font-size:.78rem;margin:4px 0 7px}.other-profile-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:20px}.other-profile-stat{padding:14px;background:#101010;border:1px solid #292929;text-align:center}.other-profile-stat b{display:block;color:var(--accent);font-size:1.3rem}.other-profile-stat span{color:#666;font-size:.62rem;text-transform:uppercase}.other-profile-post{padding:13px;border:1px solid #292929;background:#101010;margin-bottom:7px}.other-profile-post strong{display:block;font-size:.78rem}.other-profile-post small{color:#666;font-size:.66rem}
@media(max-width:760px){.dashboard-overlay,.community-overlay{padding:12px}.dashboard-modal,.community-modal{padding:20px;max-height:94vh}.dashboard-stats{grid-template-columns:repeat(2,1fr)}.dashboard-actions,.community-grid{grid-template-columns:1fr}.admin-user,.admin-post{align-items:flex-start;flex-direction:column}.admin-user-actions{width:100%}.admin-view-btn,.admin-delete-btn{flex:1}}


/* =========================================================
   ROUNDED BUTTONS - FINDMYLEAGUE
   ========================================================= */

button,
.btn,
.cta,
.sport-tab,
.sport-chip,
.tab,
.auth-btn,
.dashboard-action,
.dashboard-small-btn,
.admin-view-btn,
.admin-delete-btn,
.community-view {
    border-radius: 8px !important;
}

/* Navbar buttons */
.nav-right button,
.nav-right .btn {
    border-radius: 8px !important;
}

/* Sport selector */
.sport-tab,
.sport-chip {
    border-radius: 8px !important;
}

/* Main homepage CTA */
.cta {
    border-radius: 8px !important;
}

/* Create Post */
#createPostBtn {
    border-radius: 8px !important;
}

/* Login */
#authBtn {
    border-radius: 8px !important;
}

/* Dashboard / Community */
#dashboardNavBtn,
#communityNavBtn {
    border-radius: 8px !important;
}

/* Theme button tetap sedikit rounded */
.theme-btn {
    border-radius: 50% !important;
}

/* =========================================================
   CURSOR PROXIMITY GLOW
   ========================================================= */

button,
.btn,
.chip,
.tab,
.user-menu,
.theme-btn,
a.cta,
input[type="submit"] {
    --proximity: 0;
    --glow-r: 199;
    --glow-g: 255;
    --glow-b: 0;

    position: relative;
    transition:
        box-shadow .15s ease,
        border-color .15s ease,
        background-color .2s ease,
        transform .2s ease;
    
    box-shadow:
        0 0 calc(32px * var(--proximity))
        rgba(
            var(--glow-r),
            var(--glow-g),
            var(--glow-b),
            calc(var(--proximity) * .55)
        );
}


/* Dark mode */

body:not(.light) button,
body:not(.light) .btn,
body:not(.light) .chip,
body:not(.light) .tab,
body:not(.light) .user-menu,
body:not(.light) .theme-btn,
body:not(.light) a.cta {
    --glow-r:199;
    --glow-g:255;
    --glow-b:0;
}


/* Light mode = dark glow */

body.light button,
body.light .btn,
body.light .chip,
body.light .tab,
body.light .user-menu,
body.light .theme-btn,
body.light a.cta {
    --glow-r:0;
    --glow-g:0;
    --glow-b:0;
}


/* Slight border illumination */

button,
.btn,
.chip,
.tab {
    border-color:
        color-mix(
            in srgb,
            var(--line-b) calc(100% - var(--proximity) * 35%),
            var(--accent)
        );
}


/* Don't make the theme button lose its circle */

.theme-btn {
    border-radius:50% !important;
}


/* Accessibility */

@media (prefers-reduced-motion: reduce) {

    button,
    .btn,
    .chip,
    .tab,
    .user-menu,
    .theme-btn,
    a.cta {
        transition:none;
        box-shadow:none;
    }

}

/* =========================================================
   HOMEPAGE LIGHT MODE + CURSOR PROXIMITY GLOW
   Added without replacing the existing homepage
   ========================================================= */

/* Keep dashboard/community readable in light mode */
body.light .dashboard-modal,
body.light .community-modal,
body.light .dashboard-panel,
body.light .dashboard-stat,
body.light .community-card,
body.light .other-profile,
body.light .admin-user,
body.light .admin-post,
body.light .dashboard-action,
body.light .other-profile-stat,
body.light .other-profile-post {
  background:var(--card);
  color:var(--text);
  border-color:var(--line-b);
}
body.light .dashboard-close{
  background:var(--card2);
  color:var(--text);
  border-color:var(--line-b);
}
body.light .dashboard-header p,
body.light .dashboard-description,
body.light .dashboard-profile-info>p,
body.light .dashboard-profile-meta,
body.light .admin-user-email,
body.light .admin-post-meta,
body.light .dashboard-action small,
body.light .community-sport,
body.light .other-profile-head p,
body.light .other-profile-stat span,
body.light .other-profile-post small,
body.light .dashboard-loading{
  color:var(--muted);
}
body.light .dashboard-profile-meta b,
body.light .admin-user-name,
body.light .admin-post-title,
body.light .dashboard-action b,
body.light .community-name,
body.light .other-profile-head h3,
body.light .other-profile-post strong{
  color:var(--text);
}

/* Proximity glow is driven by --proximity from JS */
button,
.btn,
.chip,
.tab,
.user-menu,
.theme-btn,
a.cta,
input[type="submit"]{
  --proximity:0;
  --glow-r:199;
  --glow-g:255;
  --glow-b:0;
  position:relative;
  box-shadow:
    0 0 calc(30px * var(--proximity))
    rgba(var(--glow-r),var(--glow-g),var(--glow-b),calc(var(--proximity) * .48));
  transition:box-shadow .15s ease,border-color .15s ease,background-color .2s ease,transform .2s ease;
}
body.light button,
body.light .btn,
body.light .chip,
body.light .tab,
body.light .user-menu,
body.light .theme-btn,
body.light a.cta{
  --glow-r:0;
  --glow-g:0;
  --glow-b:0;
}

/* Make the glow visible on dark/light borders */
button,
.btn,
.chip,
.tab{
  border-color:color-mix(in srgb,var(--line-b) calc(100% - var(--proximity) * 35%),var(--accent));
}


/* =========================================================
   LIGHT MODE POLISH
   Clear button hierarchy + softer surfaces
   ========================================================= */

/* Navigation */
body.light nav{
  background:rgba(244,244,240,.94);
  border-bottom:1px solid #cfcfc8;
  box-shadow:0 4px 18px rgba(0,0,0,.06);
}
body.light .nav-links a.nav-plain{
  color:#555 !important;
}
body.light .nav-links a.nav-plain:hover{
  color:#111 !important;
}

/* All normal light-mode buttons should be visible against white */
body.light button:not(.btn-accent):not(.theme-btn),
body.light .btn:not(.btn-accent),
body.light .tab:not(.active),
body.light .dashboard-action,
body.light .dashboard-small-btn,
body.light .admin-view-btn,
body.light .community-view{
  background:#e9e9e5 !important;
  color:#161616 !important;
  border:1px solid #c8c8c1 !important;
}

/* Navbar buttons */
body.light #postBtn,
body.light #dashboardNavBtn,
body.light #communityNavBtn{
  background:#e9e9e5 !important;
  color:#171717 !important;
  border-color:#c4c4bc !important;
}
body.light #postBtn:hover,
body.light #dashboardNavBtn:hover,
body.light #communityNavBtn:hover{
  background:#dfff00 !important;
  color:#111 !important;
  border-color:#bfe600 !important;
}

/* Keep the main action clearly lime */
body.light .btn-accent,
body.light #authBtn{
  background:#c7ff00 !important;
  color:#090909 !important;
  border-color:#b8ed00 !important;
}
body.light .btn-accent:hover,
body.light #authBtn:hover{
  background:#d8ff4a !important;
  color:#090909 !important;
}

/* Theme toggle */
body.light .theme-btn{
  background:#e9e9e5 !important;
  color:#111 !important;
  border-color:#c4c4bc !important;
  box-shadow:0 2px 8px rgba(0,0,0,.06);
}

/* Tabs */
body.light .tab.active{
  background:#c7ff00 !important;
  color:#101010 !important;
  border-color:#b8ed00 !important;
}
body.light .tab:not(.active):hover{
  background:#f5f5f1 !important;
  border-color:#aeb0a7 !important;
}

/* Sport chips / selectors */
body.light .sport-chip,
body.light .sport-tab{
  background:#ededeb !important;
  color:#171717 !important;
  border-color:#c9c9c2 !important;
}
body.light .sport-chip:hover,
body.light .sport-tab:hover{
  background:#f7f7f3 !important;
  border-color:#aeb0a7 !important;
}

/* Search and form controls */
body.light .search-bar input,
body.light .search-bar select,
body.light .form-group input,
body.light .form-group select,
body.light .form-group textarea{
  background:#fff !important;
  color:#111 !important;
  border-color:#c8c8c1 !important;
  box-shadow:0 2px 8px rgba(0,0,0,.035);
}
body.light .search-bar input::placeholder,
body.light .form-group input::placeholder,
body.light .form-group textarea::placeholder{
  color:#888 !important;
}

/* Homepage cards */
body.light .card{
  background:#fff;
  border-color:#d0d0c9;
  box-shadow:0 5px 18px rgba(0,0,0,.045);
}
body.light .card:hover{
  box-shadow:0 12px 28px rgba(0,0,0,.10);
}

/* Auth modal */
body.light .modal{
  background:#f7f7f4;
  border-color:#cfcfc8;
  box-shadow:0 25px 70px rgba(0,0,0,.18);
}
body.light .auth-tabs{
  background:#e8e8e3;
  border:1px solid #d0d0c9;
}
body.light .auth-tabs button{
  color:#555 !important;
}
body.light .auth-tabs button.active{
  background:#c7ff00 !important;
  color:#101010 !important;
}
body.light .btn-cancel{
  background:#e9e9e5 !important;
  color:#333 !important;
  border-color:#c8c8c1 !important;
}

/* Dashboard / Community panels */
body.light .dashboard-modal,
body.light .community-modal{
  background:#f5f5f2 !important;
  border-color:#cfcfc8 !important;
  box-shadow:0 30px 90px rgba(0,0,0,.18);
}
body.light .dashboard-panel,
body.light .dashboard-stat,
body.light .community-card{
  box-shadow:0 3px 12px rgba(0,0,0,.035);
}
body.light .dashboard-action:hover,
body.light .community-view:hover,
body.light .dashboard-small-btn:hover{
  background:#c7ff00 !important;
  color:#101010 !important;
  border-color:#b8ed00 !important;
}

/* Profile / admin controls */
body.light .admin-delete-btn{
  background:#fff1f1 !important;
  color:#c43b3b !important;
  border-color:#e1aaaa !important;
}
body.light .admin-delete-btn:hover{
  background:#ff5050 !important;
  color:#111 !important;
  border-color:#ff5050 !important;
}

/* CTA remains light but has enough separation */
body.light .cta{
  background:linear-gradient(135deg,#e8f4a7,#f7f7f3) !important;
  border-color:#cfdc89 !important;
  box-shadow:0 8px 24px rgba(0,0,0,.045);
}

/* Make cursor glow subtle in light mode so it doesn't wash out the UI */
body.light button,
body.light .btn,
body.light .chip,
body.light .tab,
body.light .user-menu,
body.light .theme-btn,
body.light a.cta{
  --glow-r:70;
  --glow-g:70;
  --glow-b:70;
}

/* Respect reduced-motion users */
@media (prefers-reduced-motion:reduce){
  button,.btn,.chip,.tab,.user-menu,.theme-btn,a.cta{
    transition:none;
    box-shadow:none;
  }
}

</style>
<base target="_blank">
</head>
<body>

<nav>
  <a class="logo" href="#">Find<span>My</span>League</a>
  <div class="nav-links" id="navLinks">
    <a href="#jelajah" class="nav-plain">Explore</a>
    <button class="theme-btn" id="themeBtn" onclick="toggleTheme()" title="Change theme">☀️</button>
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
      <h3>📋 My Posts</h3>
      <div id="pPostList"></div>
    </div>
    <div class="form-actions">
      <button class="btn btn-cancel" onclick="logout()">Logout</button>
      <button class="btn btn-accent" onclick="closeProfileee()">Close</button>
    </div>
  </div>
</div>


<!-- DASHBOARD -->
<div class="dashboard-overlay" id="dashboardOverlay" onclick="if(event.target===this)closeDashboard()">
  <div class="dashboard-modal">
    <div class="dashboard-header">
      <div><span class="dashboard-label">FindMyLeague</span><h2 id="dashboardTitle">Dashboard</h2><p id="dashboardWelcome">Welcome back.</p></div>
      <button class="dashboard-close" onclick="closeDashboard()">×</button>
    </div>
    <div class="dashboard-stats">
      <div class="dashboard-stat"><span class="dashboard-stat-number" id="dashStat1">0</span><span class="dashboard-stat-label" id="dashLabel1">Posts</span></div>
      <div class="dashboard-stat"><span class="dashboard-stat-number" id="dashStat2">0</span><span class="dashboard-stat-label" id="dashLabel2">Tournaments</span></div>
      <div class="dashboard-stat"><span class="dashboard-stat-number" id="dashStat3">0</span><span class="dashboard-stat-label" id="dashLabel3">Sparring</span></div>
      <div class="dashboard-stat"><span class="dashboard-stat-number" id="dashStat4">0</span><span class="dashboard-stat-label" id="dashLabel4">Community</span></div>
    </div>

    <div id="memberDashboard">
      <div class="dashboard-panel">
        <div class="dashboard-panel-title"><div><span class="dashboard-label">Account</span><h3>My Profile</h3></div><span class="role-badge member">MEMBER</span></div>
        <div class="dashboard-profile"><div class="dashboard-avatar" id="dashboardAvatar">M</div><div class="dashboard-profile-info"><h3 id="dashboardName">User</h3><p id="dashboardEmail">email@example.com</p><div class="dashboard-profile-meta"><span>Sport: <b id="dashboardSport">-</b></span><span>Joined: <b id="dashboardJoined">-</b></span></div></div></div>
      </div>
      <div class="dashboard-panel"><div class="dashboard-panel-title"><div><span class="dashboard-label">Quick Actions</span><h3>What do you want to do?</h3></div></div><div class="dashboard-actions">
        <button class="dashboard-action" onclick="closeDashboard();handlePostClick()"><span class="action-icon">＋</span><span><b>Create Post</b><small>Create a tournament or sparring post.</small></span></button>
        <button class="dashboard-action" onclick="closeDashboard();openCommunity()"><span class="action-icon">◎</span><span><b>Browse Community</b><small>Find other FindMyLeague members.</small></span></button>
        <button class="dashboard-action" onclick="closeDashboard();openProfileee()"><span class="action-icon">◉</span><span><b>View My Profile</b><small>See your profile and your posts.</small></span></button>
      </div></div>
    </div>

    <div id="adminDashboard" style="display:none;">
      <div class="dashboard-panel"><div class="dashboard-panel-title"><div><span class="dashboard-label">Administration</span><h3>Community Management</h3></div><span class="role-badge admin">ADMIN</span></div><p class="dashboard-description">Manage FindMyLeague members and community posts.</p></div>
      <div class="dashboard-panel"><div class="dashboard-panel-title"><div><span class="dashboard-label">Users</span><h3>Registered Members</h3></div><button class="dashboard-small-btn" onclick="loadAdminUsers()">Refresh</button></div><div id="adminUsers" class="admin-user-list"><div class="dashboard-loading">Loading users...</div></div></div>
      <div class="dashboard-panel"><div class="dashboard-panel-title"><div><span class="dashboard-label">Content</span><h3>Community Posts</h3></div></div><div id="adminPosts" class="admin-post-list"><div class="dashboard-loading">Loading posts...</div></div></div>
    </div>
  </div>
</div>

<!-- COMMUNITY -->
<div class="community-overlay" id="communityOverlay" onclick="if(event.target===this)closeCommunity()"><div class="community-modal">
  <div class="dashboard-header"><div><span class="dashboard-label">FindMyLeague</span><h2>Community</h2><p>Meet other sports players.</p></div><button class="dashboard-close" onclick="closeCommunity()">×</button></div>
  <div id="communityGrid" class="community-grid"><div class="dashboard-loading">Loading community...</div></div>
</div></div>

<!-- OTHER USER PROFILE -->
<div class="community-overlay" id="userProfileOverlay" onclick="if(event.target===this)closeUserProfile()"><div class="community-modal">
  <div class="dashboard-header"><div><span class="dashboard-label">Community Profile</span><h2 id="otherProfileName">User</h2></div><button class="dashboard-close" onclick="closeUserProfile()">×</button></div>
  <div id="otherProfileContent"><div class="dashboard-loading">Loading profile...</div></div>
</div></div>

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
  if(!pass) return showAuthError('Password wajib diisi. 🔒');

  if(authMode==='signup'){
    const name = document.getElementById('aName').value.trim();
    const pass2 = document.getElementById('aPass2').value;
    if(name.length<3) return showAuthError('Name minimal 3 karakter. ✍️');
    if(pass.length<8) return showAuthError('Password minimal 8 karakter. 🔒');
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
    if(user.passHash !== await hash(pass)) return showAuthError('Password salah. Coba lagi! 🔒');
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
  addDashboardButtons();
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
  showToast('Post deleted.');
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
    date: dt ? new Date(dt).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'}) : 'Coming soon',
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
  showToast('Post published successfully!');
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
      <button class="del-btn" title="Delete" onclick="event.stopPropagation();deletePost('${p.id}')">🗑️</button>
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


/* ============================================================
   DASHBOARD / COMMUNITY
   ============================================================ */
function openDashboard(){
  if(!currentUser){ showToast('Please login first.',true); return openAuth(); }
  document.getElementById('dashboardOverlay').classList.add('show');
  const isAdmin=String(currentUser.role||'member').toLowerCase()==='admin';
  document.getElementById('dashboardTitle').textContent=isAdmin?'Admin Dashboard':'Member Dashboard';
  document.getElementById('dashboardWelcome').textContent=`Welcome back, ${currentUser.name}.`;
  document.getElementById('memberDashboard').style.display=isAdmin?'none':'block';
  document.getElementById('adminDashboard').style.display=isAdmin?'block':'none';
  if(isAdmin) loadAdminDashboard(); else loadMemberDashboard();
}
function closeDashboard(){document.getElementById('dashboardOverlay').classList.remove('show')}
async function loadMemberDashboard(){
  const r=await api('get_dashboard'); if(!r){showToast('Unable to load dashboard.',true);return;}
  const d=r.dashboard||{};
  document.getElementById('dashStat1').textContent=d.myPosts||0; document.getElementById('dashLabel1').textContent='My Posts';
  document.getElementById('dashStat2').textContent=d.myTournaments||0; document.getElementById('dashLabel2').textContent='Tournaments';
  document.getElementById('dashStat3').textContent=d.mySparring||0; document.getElementById('dashLabel3').textContent='Sparring';
  document.getElementById('dashStat4').textContent=d.users||0; document.getElementById('dashLabel4').textContent='Community';
  const n=currentUser.name||'User'; document.getElementById('dashboardAvatar').textContent=n.charAt(0).toUpperCase(); document.getElementById('dashboardName').textContent=n; document.getElementById('dashboardEmail').textContent=currentUser.email||'-'; document.getElementById('dashboardSport').textContent=currentUser.favSport||'-'; document.getElementById('dashboardJoined').textContent=currentUser.createdAt?new Date(currentUser.createdAt).toLocaleDateString('en-US',{month:'short',year:'numeric'}):'-';
}
async function loadAdminDashboard(){
  const r=await api('get_dashboard'); if(!r){showToast('Unable to load admin dashboard.',true);return;} const d=r.dashboard||{};
  document.getElementById('dashStat1').textContent=d.users||0; document.getElementById('dashLabel1').textContent='Users'; document.getElementById('dashStat2').textContent=d.posts||0; document.getElementById('dashLabel2').textContent='Posts'; document.getElementById('dashStat3').textContent=d.tournaments||0; document.getElementById('dashLabel3').textContent='Tournaments'; document.getElementById('dashStat4').textContent=d.sparring||0; document.getElementById('dashLabel4').textContent='Sparring';
  loadAdminUsers(d.userList||[]); loadAdminPosts(d.postList||[]);
}
async function loadAdminUsers(prefetched=null){
  const box=document.getElementById('adminUsers'); box.innerHTML='<div class="dashboard-loading">Loading users...</div>';
  const r=prefetched?{users:prefetched}:await api('get_users'); if(!r){box.innerHTML='<div class="dashboard-loading">Unable to load users.</div>';return;}
  const users=r.users||[]; if(!users.length){box.innerHTML='<div class="dashboard-loading">No users found.</div>';return;}
  box.innerHTML=users.map(u=>{const initial=(u.name||'U').charAt(0).toUpperCase();const admin=String(u.role||'member').toLowerCase()==='admin';return `<div class="admin-user"><div class="admin-user-left"><div class="admin-user-avatar">${escapeHtml(initial)}</div><div><div class="admin-user-name">${escapeHtml(u.name)} <span class="role-badge ${admin?'admin':'member'}" style="margin-left:6px">${admin?'ADMIN':'MEMBER'}</span></div><div class="admin-user-email">${escapeHtml(u.email||'')} · ${u.postCount||0} posts</div></div></div><div class="admin-user-actions"><button class="admin-view-btn" onclick="openOtherProfile(${Number(u.id)})">VIEW</button>${admin?'':`<button class="admin-delete-btn" onclick="deleteAdminUser(${Number(u.id)})">DELETE</button>`}</div></div>`}).join('');
}
function loadAdminPosts(list=null){
  const box=document.getElementById('adminPosts'); const all=list||posts||[]; if(!all.length){box.innerHTML='<div class="dashboard-loading">No posts found.</div>';return;}
  box.innerHTML=all.slice(0,30).map(p=>`<div class="admin-post"><div><div class="admin-post-title">${escapeHtml(p.title||'Untitled post')}</div><div class="admin-post-meta">${escapeHtml(p.author||'Unknown')} · ${escapeHtml(p.sport||'-')} · ${p.type==='tournament'?'Tournament':'Sparring'}</div></div><button class="admin-delete-btn" onclick="deleteAdminPost(${Number(p.id)})">DELETE</button></div>`).join('');
}
async function deleteAdminUser(id){if(!confirm('Delete this member account? This action cannot be undone.'))return;const r=await api('admin_delete_user',{userId:id});if(!r){showToast('Unable to delete user.',true);return;}showToast('Member deleted.');loadAdminDashboard()}
async function deleteAdminPost(id){if(!confirm('Delete this post?'))return;const r=await api('admin_delete_post',{id});if(!r){showToast('Unable to delete post.',true);return;}posts=posts.filter(p=>String(p.id)!==String(id));render();showToast('Post deleted.');loadAdminDashboard()}
async function openCommunity(){
  if(!currentUser){showToast('Please login first.',true);return openAuth();} const overlay=document.getElementById('communityOverlay'),grid=document.getElementById('communityGrid');overlay.classList.add('show');grid.innerHTML='<div class="dashboard-loading">Loading community...</div>';const r=await api('get_users');if(!r){grid.innerHTML='<div class="dashboard-loading">Unable to load community.</div>';return;}const users=r.users||[];
  grid.innerHTML=users.map(u=>{const initial=(u.name||'U').charAt(0).toUpperCase();const admin=String(u.role||'member').toLowerCase()==='admin';return `<div class="community-card"><div class="community-card-top"><div class="community-avatar">${escapeHtml(initial)}</div><div><div class="community-name">${escapeHtml(u.name)}</div><div class="community-sport">${escapeHtml(u.favSport||'No favorite sport')}</div></div></div><span class="role-badge ${admin?'admin':'member'}">${admin?'ADMIN':'MEMBER'}</span><div style="color:#666;font-size:.68rem;margin:9px 0">${u.postCount||0} posts</div><button class="community-view" onclick="openOtherProfile(${Number(u.id)})">View Profile →</button></div>`}).join('');
}
function closeCommunity(){document.getElementById('communityOverlay').classList.remove('show')}
async function openOtherProfile(id){
  const overlay=document.getElementById('userProfileOverlay'),content=document.getElementById('otherProfileContent');overlay.classList.add('show');content.innerHTML='<div class="dashboard-loading">Loading profile...</div>';const r=await api('get_user_profile',{userId:id});if(!r){content.innerHTML='<div class="dashboard-loading">Unable to load profile.</div>';return;}const u=r.user||{}, ps=r.posts||[], initial=(u.name||'U').charAt(0).toUpperCase(), admin=String(u.role||'member').toLowerCase()==='admin', tournaments=ps.filter(p=>p.type==='tournament').length, sparring=ps.filter(p=>p.type==='sparring').length;document.getElementById('otherProfileName').textContent=u.name||'User';content.innerHTML=`<div class="other-profile"><div class="other-profile-head"><div class="other-profile-avatar">${escapeHtml(initial)}</div><div><h3>${escapeHtml(u.name||'User')}</h3><p>Favorite sport: ${escapeHtml(u.favSport||'-')}</p><span class="role-badge ${admin?'admin':'member'}">${admin?'ADMIN':'MEMBER'}</span></div></div><div class="other-profile-stats"><div class="other-profile-stat"><b>${u.postCount||0}</b><span>Posts</span></div><div class="other-profile-stat"><b>${tournaments}</b><span>Tournaments</span></div><div class="other-profile-stat"><b>${sparring}</b><span>Sparring</span></div></div><span class="dashboard-label">Posts</span>${ps.length?ps.map(p=>`<div class="other-profile-post"><strong>${escapeHtml(p.title||'Untitled')}</strong><small>${p.type==='tournament'?'Tournament':'Sparring'} · ${escapeHtml(p.sport||'-')} · ${escapeHtml(p.loc||'-')}</small></div>`).join(''):'<div class="dashboard-loading">This user has no posts yet.</div>'}</div>`;
}
function closeUserProfile(){document.getElementById('userProfileOverlay').classList.remove('show')}
function addDashboardButtons(){
  const nav=document.getElementById('navLinks'); if(!nav||document.getElementById('dashboardNavBtn'))return;
  const c=document.createElement('button');c.id='communityNavBtn';c.className='btn btn-ghost';c.textContent='Community';c.onclick=openCommunity;
  const d=document.createElement('button');d.id='dashboardNavBtn';d.className='btn btn-ghost';d.textContent='Dashboard';d.onclick=openDashboard;
  const theme=document.getElementById('themeBtn'); if(theme){nav.insertBefore(c,theme);nav.insertBefore(d,theme)}else{nav.appendChild(c);nav.appendChild(d)}
}


/* ============ CURSOR PROXIMITY GLOW ============ */
function initProximityGlow(){
  const selector = 'button,.btn,.chip,.tab,.user-menu,.theme-btn,a.cta,input[type="submit"]';
  const maxDistance = 180;
  const update = (el, x, y) => {
    const r = el.getBoundingClientRect();
    const px = Math.max(r.left, Math.min(x, r.right));
    const py = Math.max(r.top, Math.min(y, r.bottom));
    const dx = x - px, dy = y - py;
    const distance = Math.sqrt(dx*dx + dy*dy);
    const proximity = Math.max(0, 1 - distance / maxDistance);
    el.style.setProperty('--proximity', proximity.toFixed(3));
  };

  document.addEventListener('mousemove', e => {
    document.querySelectorAll(selector).forEach(el => update(el, e.clientX, e.clientY));
  }, {passive:true});

  document.addEventListener('mouseleave', () => {
    document.querySelectorAll(selector).forEach(el => el.style.setProperty('--proximity','0'));
  });
}

/* ============ INIT ============ */
(async function init(){
  setTheme(localStorage.getItem('fml_theme') || 'dark');
  initProximityGlow();

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