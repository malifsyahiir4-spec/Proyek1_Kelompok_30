<?php
include '../config/database.php';

$limit = 200;
$questionsRes = mysqli_query(
    $conn,
    "SELECT 
        q.id,
        q.question_text,
        q.option_a, q.option_b, q.option_c, q.option_d,
        q.correct_answer,
        c.name AS category_name
     FROM questions q
     LEFT JOIN categories c ON c.id = q.category_id
     ORDER BY q.id DESC
     LIMIT {$limit}"
);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Questions - MindClash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{background:#0f172a;color:white;font-family:Arial;}
        .sidebar{width:260px;height:100vh;background:#111827;position:fixed;padding:30px 20px;}
        .content{margin-left:280px;padding:30px;}
        .card-box{background:#1e293b;border-radius:20px;padding:25px;box-shadow:0 0 20px rgba(0,0,0,0.3);}
        .muted{color:#94a3b8;}
        .q-title{color:#e2e8f0;margin-bottom:10px;font-weight:700;}
        .options{display:grid;grid-template-columns:1fr;gap:8px;}
        .opt{background:#0b1220;border:1px solid rgba(148,163,184,.25);border-radius:12px;padding:10px 12px;}
        .badge-cat{background:#7c3aed;}
    </style>
</head>
<body>
<?php
// Optional: reuse existing sidebar if session exists, but keep it simple and consistent with the existing app layout.
include '../layouts/sidebar.php';
?>
<div class="content">
    <div class="mb-4">
        <h1 class="mb-1">Questions</h1>
        <div class="muted">Total: <?php echo $questionsRes ? mysqli_num_rows($questionsRes) : 0; ?></div>
    </div>

    <?php if (!$questionsRes || mysqli_num_rows($questionsRes) === 0): ?>
        <div class="card-box">
            <div class="muted">No questions found.</div>
            <div class="mt-2 muted">Tip: run <span class="text-light">question/seed_lanjutan.php?run=1</span> and/or add questions from <span class="text-light">question/create.php</span>.</div>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php while ($q = mysqli_fetch_assoc($questionsRes)): ?>
                <div class="col-md-6">
                    <div class="card-box h-100">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <div class="q-title">
                                <?php echo htmlspecialchars($q['question_text'], ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        </div>

                        <div class="muted mb-3">
                            Category: <span class="badge rounded-pill badge-cat px-3 py-2"><?php echo htmlspecialchars($q['category_name'] ?? '-', ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>

                        <div class="options">
                            <div class="opt">A: <?php echo htmlspecialchars($q['option_a'] ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
                            <div class="opt">B: <?php echo htmlspecialchars($q['option_b'] ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
                            <div class="opt">C: <?php echo htmlspecialchars($q['option_c'] ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
                            <div class="opt">D: <?php echo htmlspecialchars($q['option_d'] ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
                        </div>

                        <div class="mt-3 muted">
                            Correct Answer: <b><?php echo htmlspecialchars($q['correct_answer'] ?? '', ENT_QUOTES, 'UTF-8'); ?></b>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
