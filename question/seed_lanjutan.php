<?php
include __DIR__ . '/../config/database.php';

$errors = [];

if (!isset($conn) || !($conn instanceof mysqli)) {
    if ($run) {
        $errors[] = 'Koneksi database gagal: $conn tidak valid.';
        // Stop supaya tidak memanggil mysqli_query/mysqli_begin_transaction dengan $conn null.
        $run = false;
    }
}

/**
 * Seeder "Soal Lanjutan"
 * - Preview mode: akses tanpa ?run=1
 * - Execute mode: akses dengan ?run=1
 */

function h($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}

$run = isset($_GET['run']) && $_GET['run'] === '1';

// Support CLI usage:
// php question/seed_lanjutan.php run=1
if (!$run && PHP_SAPI === 'cli') {
    foreach ($argv as $arg) {
        if (trim($arg) === 'run=1') {
            $run = true;
            break;
        }
    }
}

// Ambil kategori untuk mapping nama -> id
$categoriesRes = mysqli_query($conn, "SELECT id, name FROM categories");
$categoriesMap = [];
while ($row = mysqli_fetch_assoc($categoriesRes)) {
    $categoriesMap[$row['name']] = (int)$row['id'];
}

$soalLanjutan = [
    [
        'category_name' => 'Matematika',
        'question_text' => 'Jika 2x + 3 = 11, nilai x adalah?',
        'option_a' => '3',
        'option_b' => '4',
        'option_c' => '5',
        'option_d' => '6',
        'correct_answer' => 'B',
    ],
    [
        'category_name' => 'Matematika',
        'question_text' => 'Nilai dari 5! (faktorial 5) adalah?',
        'option_a' => '60',
        'option_b' => '90',
        'option_c' => '120',
        'option_d' => '150',
        'correct_answer' => 'C',
    ],
    [
        'category_name' => 'Bahasa Indonesia',
        'question_text' => 'Sinonim dari kata "cepat" adalah ...',
        'option_a' => 'Lambat',
        'option_b' => 'Tergesa-gesa',
        'option_c' => 'Ragu-ragu',
        'option_d' => 'Muram',
        'correct_answer' => 'B',
    ],
    [
        'category_name' => 'Logika',
        'question_text' => 'Jika semua A adalah B dan semua B adalah C, maka pernyataan yang benar adalah ...',
        'option_a' => 'Semua C adalah A',
        'option_b' => 'Semua A adalah C',
        'option_c' => 'Sebagian C adalah B',
        'option_d' => 'Tidak ada hubungan antara A dan C',
        'correct_answer' => 'B',
    ],
];

$previewInserted = [];
$skippedExisting = [];
$errors = [];

function findCategoryId($categoriesMap, $categoryName) {
    return $categoriesMap[$categoryName] ?? null;
}

if ($run) {
    // Diagnostic: hitung sebelum insert
    $beforeCount = 0;
    $cntRes = mysqli_query($conn, "SELECT COUNT(*) AS cnt FROM questions");
    if ($cntRes) {
        $rowCnt = mysqli_fetch_assoc($cntRes);
        $beforeCount = (int)($rowCnt['cnt'] ?? 0);
    }

    mysqli_begin_transaction($conn);

    $checkSql = "SELECT 1 FROM questions WHERE question_text = ? LIMIT 1";
    $insertSql = "INSERT INTO questions(
        category_id,
        question_text,
        option_a,
        option_b,
        option_c,
        option_d,
        correct_answer
    ) VALUES(?, ?, ?, ?, ?, ?, ?)";

    $checkStmt = mysqli_prepare($conn, $checkSql);
    $insertStmt = mysqli_prepare($conn, $insertSql);

    if (!$checkStmt || !$insertStmt) {
        $errors[] = "Prepare statement gagal: " . mysqli_error($conn);
    } else {
        foreach ($soalLanjutan as $item) {
            $categoryName = $item['category_name'];
            $categoryId = findCategoryId($categoriesMap, $categoryName);

            if (!$categoryId) {
                $errors[] = "Kategori tidak ditemukan: " . $categoryName;
                continue;
            }

            $qText = $item['question_text'];

            mysqli_stmt_bind_param($checkStmt, 's', $qText);
            mysqli_stmt_execute($checkStmt);
            mysqli_stmt_store_result($checkStmt);

            if (mysqli_stmt_num_rows($checkStmt) > 0) {
                $skippedExisting[] = $qText;
                continue;
            }

            mysqli_stmt_bind_param(
                $insertStmt,
                'issssss',
                $categoryId,
                $qText,
                $item['option_a'],
                $item['option_b'],
                $item['option_c'],
                $item['option_d'],
                $item['correct_answer']
            );

            $ok = mysqli_stmt_execute($insertStmt);
            if ($ok) {
                $previewInserted[] = $qText;
            } else {
                $errors[] = "Gagal insert: {$qText}. Error: " . mysqli_error($conn);
            }
        }
    }

    mysqli_commit($conn);
} else {
    // Preview mode: tidak insert apa pun
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Seed Soal Lanjutan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background:#0f172a; color:white; font-family: Arial; }
        .container { margin-top:40px; }
        .card { background:#1e293b; border:none; border-radius:20px; padding:20px; }
        .badge-run { background:#7c3aed; }
        .code { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; }
        .muted { color:#94a3b8; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <h3 class="mb-2">Seed "Soal Lanjutan"</h3>
        <div class="muted mb-3">
            Mode: <?php echo $run ? '<span class="badge badge-run p-2">RUN (insert)</span>' : '<span class="badge bg-secondary p-2">PREVIEW (no insert)</span>'; ?>
        </div>

        <p class="muted">
            Jalankan insert: <span class="code"><?php echo h('question/seed_lanjutan.php?run=1'); ?></span>
        </p>

        <hr class="text-secondary">

        <h5 class="mb-3">Daftar soal yang akan diinsert (jika kategori ada)</h5>

        <div class="row g-3">
            <?php foreach ($soalLanjutan as $i => $item): ?>
                <div class="col-md-6">
                    <div class="p-3 rounded-4" style="background:#0b1220; border:1px solid rgba(148,163,184,.25);">
                        <div class="muted mb-1">Kategori: <b><?php echo h($item['category_name']); ?></b></div>
                        <div class="mb-2"><b><?php echo h($item['question_text']); ?></b></div>
                        <div class="muted">
                            A: <?php echo h($item['option_a']); ?><br>
                            B: <?php echo h($item['option_b']); ?><br>
                            C: <?php echo h($item['option_c']); ?><br>
                            D: <?php echo h($item['option_d']); ?><br>
                            Correct: <?php echo h($item['correct_answer']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($run): ?>
            <hr class="text-secondary">
            <h5 class="mb-3">Hasil</h5>

            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-3 rounded-4" style="background:#0b1220; border:1px solid rgba(148,163,184,.25);">
                        <div class="muted">Inserted</div>
                        <div style="font-size:28px; font-weight:800;">
                            <?php echo count($previewInserted); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded-4" style="background:#0b1220; border:1px solid rgba(148,163,184,.25);">
                        <div class="muted">Skipped (already exists)</div>
                        <div style="font-size:28px; font-weight:800;">
                            <?php echo count($skippedExisting); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded-4" style="background:#0b1220; border:1px solid rgba(148,163,184,.25);">
                        <div class="muted">Errors</div>
                        <div style="font-size:28px; font-weight:800;">
                            <?php echo count($errors); ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (count($skippedExisting) > 0): ?>
                <div class="mt-4">
                    <h6>Skipped</h6>
                    <ul>
                        <?php foreach ($skippedExisting as $t): ?>
                            <li class="code"><?php echo h($t); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (count($errors) > 0): ?>
                <div class="mt-4">
                    <h6 style="color:#fecaca;">Errors</h6>
                    <ul>
                        <?php foreach ($errors as $e): ?>
                            <li><?php echo h($e); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</div>
</body>
</html>
