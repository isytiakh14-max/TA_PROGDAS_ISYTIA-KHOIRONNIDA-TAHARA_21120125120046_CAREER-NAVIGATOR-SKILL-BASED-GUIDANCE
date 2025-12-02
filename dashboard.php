<?php
session_start();
require "classes.php";
require "config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user
$stmt_user = $conn->prepare("SELECT name, age, interest FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$res_user = $stmt_user->get_result();
$user = $res_user->fetch_assoc();
$stmt_user->close();

// Daftar skill (label tampilan)
$skills_list = [
    "Komunikasi","Creativity","Problem Solving","Manajemen Waktu","Digital Literacy",
    "Analisis Data","Leadership","Organisasi","Koding Dasar","Design Grafis",
    "Marketing","Public Speaking","Negosiasi","Teamwork","Bahasa Inggris"
];

$career_paths = [

    /* ----------------- 1. DIGITAL MARKETING ----------------- */
    "Digital Marketing Specialist" => [
        "skills" => ["Komunikasi","Marketing","Digital Literacy"],
        "playlist" => "https://www.youtube.com/playlist?list=PLFIM0718LjIVknj6sgsSceMqlq242-jNf",
        "resources" => [
            "HubSpot Academy – Digital Marketing Course" => "https://academy.hubspot.com",
            "Google Digital Garage – Fundamentals of Digital Marketing" => "https://learndigital.withgoogle.com",
            "SEMrush Academy – SEO & Content Marketing" => "https://www.semrush.com/academy",
            "Mailchimp Academy – Email Marketing Basics" => "https://mailchimp.com/resources/mailchimp-academy",
            "WordStream PPC University" => "https://www.wordstream.com/learn",
            "Moz SEO Guide" => "https://moz.com/beginners-guide-to-seo",
            "Ahrefs Blog" => "https://ahrefs.com/blog",
            "Neil Patel Guides" => "https://neilpatel.com/blog"
        ]
    ],

    /* ----------------- 2. SOFTWARE DEVELOPER ----------------- */
    "Software Developer" => [
        "skills" => ["Koding Dasar","Problem Solving","Digital Literacy"],
        "playlist" => "https://www.youtube.com/playlist?list=PLFIM0718LjIWXagluzROrA-iBY9eeUt4w",
        "resources" => [
            "freeCodeCamp Full Curriculum" => "https://www.freecodecamp.org",
            "The Odin Project – Full Stack Bootcamp" => "https://www.theodinproject.com",
            "MDN Web Docs (HTML, CSS, JS)" => "https://developer.mozilla.org/en-US/docs/Learn",
            "W3Schools Developer Tutorial" => "https://www.w3schools.com",
            "Codecademy Free Courses" => "https://www.codecademy.com/catalog/all?free=true",
            "JavaScript.info" => "https://javascript.info",
            "Python Docs" => "https://docs.python.org/3/tutorial",
            "GeeksForGeeks" => "https://www.geeksforgeeks.org"
        ]
    ],

    /* ----------------- 3. UX DESIGNER ----------------- */
    "UX Designer" => [
        "skills" => ["Creativity","Design Grafis","Digital Literacy"],
        "playlist" => "https://youtube.com/playlist?list=PLkaFTR_oezJ7txRw0AKPgqnmMAfO67cmT&si=A-MKFHw7-GtyG_a1",
        "resources" => [
            "Google UX Design (Coursera audit)" => "https://www.coursera.org/professional-certificates/google-ux-design",
            "Figma Learn Center" => "https://www.figma.com/resource-library",
            "Interaction Design Foundation" => "https://www.interaction-design.org",
            "Adobe XD Tutorials" => "https://helpx.adobe.com/xd/tutorials.html",
            "CareerFoundry UX Blog" => "https://careerfoundry.com/en/blog/ux-design/",
            "UX Planet" => "https://uxplanet.org",
            "Nielsen Norman Group Articles" => "https://www.nngroup.com/articles"
        ]
    ],

    /* ----------------- 4. DATA ANALYST ----------------- */
    "Data Analyst" => [
        "skills" => ["Analisis Data","SQL","Manajemen Waktu"],
        "playlist" => "https://youtube.com/playlist?list=PLUaB-1hjhk8FE_XZ87vPPSfHqb6OcM0cF&si=pken2g5xwQFMQiE8",
        "resources" => [
            "Google Data Analytics (Coursera audit)" => "https://www.coursera.org/professional-certificates/google-data-analytics",
            "Kaggle Learn" => "https://www.kaggle.com/learn",
            "DataCamp (Free Intro)" => "https://www.datacamp.com",
            "Mode SQL Tutorial" => "https://mode.com/sql-tutorial",
            "IBM SkillsBuild – Data Fundamentals" => "https://skillsbuild.org",
            "w3schools SQL" => "https://www.w3schools.com/sql",
            "Pandas Docs" => "https://pandas.pydata.org/docs"
        ]
    ],

    /* ----------------- 5. GRAPHIC DESIGNER ----------------- */
    "Graphic Designer" => [
        "skills" => ["Creativity","Design Grafis","Digital Literacy"],
        "playlist" => "https://youtube.com/playlist?list=PLSMxWLILbTyyQzaKxB2xdZ5wADor4OzIH&si=se2MyHfFuunNpeD6",
        "resources" => [
            "Canva Design School" => "https://www.canva.com/designschool",
            "Figma Design Tutorial (Help)" => "https://help.figma.com/hc/en-us",
            "Gravit Designer Tutorials" => "https://documentation.designer.io",
            "GIMP User Guide" => "https://docs.gimp.org",
            "Adobe Illustrator Tutorials" => "https://helpx.adobe.com/illustrator/tutorials.html",
            "Envato Tuts+ Design" => "https://design.tutsplus.com",
            "Dribbble Learn" => "https://dribbble.com/stories"
        ]
    ],

    /* ----------------- 6. PROJECT MANAGER ----------------- */
    "Project Manager" => [
        "skills" => ["Leadership","Manajemen Waktu","Teamwork"],
        "playlist" => "https://youtu.be/VFQtSqChlsk?si=Hy_Rp40bQkPmLNoZ",
        "resources" => [
            "Google Project Management (Coursera audit)" => "https://www.coursera.org/professional-certificates/google-project-management",
            "PMI Project Management Basics" => "https://www.pmi.org/learning",
            "OpenLearn – Project Management" => "https://www.open.edu/openlearn",
            "edX – Intro to Project Management" => "https://www.edx.org",
            "Scrum Guide (Official)" => "https://scrumguides.org"
        ]
    ],

    /* ----------------- 7. VIDEO EDITOR ----------------- */
    "Video Editor" => [
        "skills" => ["Creativity","Digital Literacy","Teamwork"],
        "playlist" => "https://youtube.com/playlist?list=PL2HeOArLswsXnZf2r1JIE1hAhdI6jmzt_&si=L1XDOM5FaQIYAfHo",
        "resources" => [
            "DaVinci Resolve Official Training" => "https://www.blackmagicdesign.com/products/davinciresolve/training",
            "Shotcut Documentation" => "https://shotcut.org/tutorials",
            "HitFilm Express User Guide" => "https://fxhome.com/learn",
            "Blender VSE Docs" => "https://docs.blender.org/manual/en/latest/video_editing",
            "Kapwing Learn – Editing Basics" => "https://www.kapwing.com/resources"
        ]
    ]

];

// Ambil nilai skill terakhir
$stmt = $conn->prepare("SELECT * FROM skills WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$last_skills = $res->fetch_assoc() ?? null;
$stmt->close();

/* Helper: get skill value from last_skills row */
function get_skill_value($row, $skillLabel) {
    $col = strtolower(str_replace(" ", "_", $skillLabel));
    return intval($row[$col] ?? 0);
}

$analyzer = new CareerAnalyzer();
$queue = new CareerQueue();

// Masukkan career ke dalam object Career dan Queue
foreach ($career_paths as $name => $info) {
    $careerObj = new Career(
        $name,
        $info['skills'],
        $info['playlist'],
        $info['resources']
    );

    $analyzer->addCareer($careerObj);
    $queue->enqueue($careerObj->getName()); // queue untuk daftar urut
}

// Ambil nilai skill dalam bentuk array untuk analisa
$skillValues = [];
foreach ($last_skills as $k => $v) {
    if ($k != "id" && $k != "user_id" && $k != "created_at" && $k != "total_points") {
        $skillValues[$k] = intval($v);
    }
}

// Hitung skor menggunakan POLYMORPHISM
$scores = $analyzer->evaluate($skillValues);

// Order career dari Queue (struktur data)
$ordered = [];
while (!$queue->isEmpty()) {
    $c = $queue->dequeue();
    $ordered[] = $c;
}

// Sort berdasarkan skor
usort($ordered, function($a, $b) use ($scores) {
    return $scores[$b] <=> $scores[$a];
});

$best_career = $ordered[0] ?? null;
$THRESHOLD = 70; // untuk skill gap

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">

    <style>
    /* ===================== ANIMATED BACKGROUND ===================== */

    .animated-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background: linear-gradient(45deg, #a18cd1, #fbc2eb, #fad0c4, #ffd1ff);
        background-size: 400% 400%;
        animation: auroraMove 18s ease infinite;
        filter: blur(40px);
    }

    @keyframes auroraMove {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* ================================================================ */
    /* BUTTON PLAYLIST + RESOURCE */
    .btn-row { display:flex; flex-wrap:wrap; gap:8px; margin-top:10px; }
    .playlist-btn, .resource-btn {
        display:inline-flex;
        align-items:center;
        gap:8px;
        padding:8px 12px;
        border-radius:8px;
        text-decoration:none;
        font-weight:700;
        font-size:0.93rem;
        box-shadow:0 6px 18px rgba(0,0,0,0.12);
    }
    .playlist-btn { background:#FF0000; color:#fff; }
    .resource-btn { background:#0b72ff; color:#fff; }
    .resource-btn.secondary { background:#3a3f47; color:#fff; font-weight:600; }

    .btn-icon { font-size:1.05rem; opacity:0.95; }

    /* CARD HOVER EFFECT */
    .rec.card { position: relative; transition: transform .12s ease; }
    .rec.card:hover { transform: translateY(-4px); }
    .rec.best { border: 2px solid #f5d76e; background: linear-gradient(180deg, rgba(245,215,110,0.04), rgba(255,255,255,0.01)); }
    .badge-best { position: absolute; right: 16px; top: 16px; background: #f5d76e; color: #111; padding: 6px 10px; border-radius: 999px; font-weight:800; font-size:0.85rem; }

    /* SKILL BAR */
    .small {
    color: #7B3BA8;
    font-weight: 600;
}
    .skill-bar {
    height: 10px;
    background: rgba(120, 60, 160, 0.18); /* ungu muda transparan */
    border-radius: 6px;
    overflow: hidden;
    width: 100%;
}
.skill-fill {
    height: 100%;
    background: linear-gradient(90deg, #A04BFF, #FF70D7); /* ungu → pink neon lembut */
    width: 0%;
}
.muted {
    color: rgba(60, 0, 90, 0.65); /* ungu gelap soft, readable */
    font-size: 0.95rem;
}
input::placeholder {
    color: rgba(74, 23, 110, 0.55);
}
.brand {
    color: #4A176E !important;
    font-weight: 700;
}

.card h2, h2.title, h2 {
    color: #4A176E;
    font-weight: 700;
}

label {
    color: #4A176E;
    font-weight: 600;
}

input::placeholder {
    color: rgba(74, 23, 110, 0.55);
}

    /* RESPONSIVE */
    @media(max-width:700px){
        .btn-row { gap:6px; }
        .playlist-btn, .resource-btn { font-size:0.85rem; padding:7px 10px; }
    }

/* === Career Title Colors === */
.rec.card h3 {
    color: #4A176E !important;
    font-weight: 800;
}
.rec.card.best h3 {
    color: #A67C2D !important;
}

/* ================= BEST MATCH GOLD DARK + SHIMMER ================= */

/* Badge Best Match */
.badge-best {
    background: #C89B3C !important;
    color: white !important;
    font-weight: 700;
    position: relative;
    overflow: hidden;
}

/* shimmer diagonal pada badge */
.badge-best::after {
    content: "";
    position: absolute;
    top: -100%;
    left: -100%;
    width: 250%;
    height: 250%;
    background: linear-gradient(
        120deg,
        transparent,
        rgba(255, 255, 255, 0.4),
        transparent
    );
    transform: rotate(25deg);
    animation: shimmerBadge 3s infinite;
}

@keyframes shimmerBadge {
    0% { transform: translate(-150%, -150%) rotate(25deg); }
    100% { transform: translate(150%, 150%) rotate(25deg); }
}
/* ================= CARD BEST MATCH ================= */

.rec.best {
    border: 2.5px solid #A67C2D !important;
    background: linear-gradient(
        135deg,
        rgba(200, 155, 60, 0.12),
        rgba(255, 225, 160, 0.18)
    ) !important;
    position: relative;
    overflow: hidden;
}

/* shimmer lembut di seluruh card */
.rec.best::before {
    content: "";
    position: absolute;
    top: -150%;
    left: -150%;
    width: 300%;
    height: 300%;
    background: radial-gradient(
        circle,
        rgba(255, 255, 255, 0.25) 0%,
        transparent 60%
    );
    animation: cardGlow 6s infinite linear;
}

@keyframes cardGlow {
    0% { transform: translate(-30%, -30%); }
    50% { transform: translate(30%, 30%); }
    100% { transform: translate(-30%, -30%); }
}
/* ================= SPARKLES (TITIK KERLAP-KERLIP) ================= */

.rec.best::after {
    content: "";
    position: absolute;
    width: 4px;
    height: 4px;
    background: radial-gradient(circle, #fff 0%, transparent 70%);
    top: 20%;
    left: 70%;
    border-radius: 50%;
    opacity: 0.8;
    animation: sparkle 1.4s infinite alternate;
}

@keyframes sparkle {
    0%   { transform: scale(0.5); opacity: 0.3; }
    50%  { transform: scale(1.4); opacity: 1; }
    100% { transform: scale(0.4); opacity: 0.2; }
}
.rec.card li,
.rec.card ul li,
.rec.card .small,
.rec.card li small,
.skill-item,
.rec .skill-item,
.rec .skill-label {
    color: #4A176E !important;
}
.rec.card li div {
    color: #4A176E !important;
}

    </style>
</head>

<body>

<!-- Background animasi -->
<div class="animated-bg"></div>

<header class="topbar">
    <div class="brand">Career Navigator</div>
    <div class="nav-right">
        <span>Hai, <?= htmlspecialchars($user['name']) ?></span> |
        <a href="profile.php">Profil</a> |
        <a href="logout.php">Logout</a>
    </div>
</header>

<main class="container">
    <section class="hero-grid">

        <aside class="card left">
            <h2>Rencanakan Karirmu</h2>

            <form method="post" action="process.php">

                <div class="user-info-grid">

    <div class="form-group">
        <label>Nama</label>
        <input name="name" value="<?= htmlspecialchars($user['name']) ?>">
    </div>

    <div class="form-group">
        <label>Umur</label>
        <input name="age" value="<?= htmlspecialchars($user['age']) ?>">
    </div>

    <div class="form-group">
        <label>Bidang Minat</label>
        <input name="interest" value="<?= htmlspecialchars($user['interest']) ?>">
    </div>

</div>

                <h4>Nilai Skill (0–100)</h4>

                <?php foreach ($skills_list as $s):
                    $db = strtolower(str_replace(" ", "_", $s));
                    $v = $last_skills[$db] ?? 0;
                ?>
                    <label><?= htmlspecialchars($s) ?></label>
                    <input type="range"
                           name="<?= htmlspecialchars($db) ?>"
                           min="0" max="100"
                           value="<?= htmlspecialchars($v) ?>"
                           oninput="document.getElementById('val_<?= htmlspecialchars($db) ?>').innerText=this.value">

                    <div class="small">
                        <span id="val_<?= htmlspecialchars($db) ?>"><?= htmlspecialchars($v) ?></span>/100
                    </div>
                <?php endforeach; ?>

                <button class="btn" type="submit">Lihat Rekomendasi</button>
            </form>
        </aside>

        <figure class="hero-image">
            <img src="images/hero.png?v=<?php echo time(); ?>" alt="Hero">
        </figure>

    </section>

    <!-- ================= REKOMENDASI ================= -->
<section class="recommendations">
<?php if ($last_skills && $last_skills['total_points'] > 0): ?>

    <?php
    $rank = 0;
    foreach ($ordered as $career):
        $rank++;
        $score = $scores[$career];
        $info = $career_paths[$career];
        $is_best = ($career === $best_career);
    ?>
        <div class="rec card <?= $is_best ? 'best' : '' ?>" aria-label="rec-<?= $rank ?>">
            <?php if ($is_best): ?><div class="badge-best">Best Match</div><?php endif; ?>

            <h3><?= htmlspecialchars($career) ?> — Score: <?= intval($score) ?></h3>

            <div class="btn-row">   
                <?php if (!empty($info['playlist'])): ?>
                    <a class="playlist-btn" href="<?= htmlspecialchars($info['playlist']) ?>" target="_blank">
                        <span class="btn-icon">▶</span> Playlist YouTube
                    </a>
                <?php endif; ?>

                <?php
                $shown = 0;
                if (!empty($info['resources'])):
                    foreach ($info['resources'] as $title => $link):
                        if ($shown >= 3) break;
                        $shown++;
                ?>
                        <a class="resource-btn" href="<?= htmlspecialchars($link) ?>" target="_blank">  
                            <span class="btn-icon">📚</span> <?= htmlspecialchars($title) ?>
                        </a>
                <?php endforeach; endif; ?>
            </div>

            <div style="margin-top:12px;">
                <strong>Skill yang perlu ditingkatkan (threshold <?= $THRESHOLD ?>):</strong>

                <?php
                $gaps = [];
                foreach ($info['skills'] as $req) {
                    $val = get_skill_value($last_skills, $req);
                    if ($val < $THRESHOLD) $gaps[$req] = $val;
                }
                ?>

                <?php if (empty($gaps)): ?>
                    <div class="muted" style="margin-top:8px;">Semua skill utama sudah baik. 🎉</div>
                <?php else: ?>
                    <ul style="margin-top:8px;">
                        <?php foreach ($gaps as $gname => $gval): ?>
                            <li style="margin-bottom:8px;">
                                <div style="font-size:13px;color:#dbe6ff;margin-bottom:6px;">
                                    <?= htmlspecialchars($gname) ?> — <?= intval($gval) ?>/100
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-fill" style="width:<?= intval($gval) ?>%;"></div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <?php if (!empty($info['resources'])): ?>
                <div style="margin-top:12px;">
                    <strong>Semua Sumber Belajar:</strong>
                    <ul style="margin:8px 0 0 18px;">
                        <?php foreach ($info['resources'] as $title => $link): ?>
                            <li style="margin-bottom:6px;">
                                <a href="<?= htmlspecialchars($link) ?>" target="_blank"><?= htmlspecialchars($title) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>

<?php else: ?>
    <div class="card">Belum ada data skill. Isi form dan submit untuk melihat rekomendasi.</div>
<?php endif; ?>
</section>

    <section style="margin-top:20px;">
        <img src="images/hero2.png" alt="Extra" style="width:360px;border-radius:10px;">
        <p>Tips: ikuti langkah videonya dan jangan menyerah!</p>
    </section>

</main>

<footer>© <?= date("Y") ?> Career Navigator</footer>

</body>
</html>