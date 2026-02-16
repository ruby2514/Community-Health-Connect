<?php
  $pageTitle = "Hotlines";
  require 'config.php';
  require 'header.php';

  /* ---------- LOAD DATA FROM CSV ---------- */

  $csvPath = __DIR__ . '/hotlines.csv';
  $hotlines = [];

  // helper: normalize text for safer searching
  function norm($s) {
    $s = (string)$s;
    $s = trim($s);
    $s = preg_replace('/\s+/', ' ', $s); // collapse whitespace
    return mb_strtolower($s);
  }

  if (file_exists($csvPath)) {
    if (($handle = fopen($csvPath, 'r')) !== false) {
      $headers = fgetcsv($handle); // first row

      while (($row = fgetcsv($handle)) !== false) {
        $data = array_combine($headers, $row);
        if (empty($data['name'])) continue;

        $hotlines[] = [
          'category'    => strtolower(trim($data['category'])),
          'state'       => trim($data['state']) ?: null,
          'name'        => trim($data['name']),
          'available'   => trim($data['available']),
          'description' => trim($data['description']),
          'phone'       => trim($data['phone']),
          'text'        => trim($data['text']),
          'website'     => trim($data['website']),
        ];
      }
      fclose($handle);
    }
  }

  /* ---------- SPLIT DATA ---------- */

  $nationalHotlines = array_filter($hotlines, fn($h) => $h['category'] === 'national');
  $stateHotlines    = array_filter($hotlines, fn($h) => $h['category'] === 'state');

  /* ---------- FILTER LOGIC ---------- */

  $view          = $_GET['view'] ?? 'national';
  $searchQuery   = trim($_GET['q'] ?? '');
  $selectedState = $_GET['state'] ?? 'all';

  $baseList = ($view === 'state') ? $stateHotlines : $nationalHotlines;

  $filteredHotlines = array_filter($baseList, function ($h) use ($view, $searchQuery, $selectedState) {
    if ($view === 'state' && $selectedState !== 'all' && $h['state'] !== $selectedState) {
      return false;
    }

    if ($searchQuery === '') return true;

    $q = norm($searchQuery);

    // ✅ search across multiple fields (so it always finds what users expect)
    $haystack = implode(' ', [
      norm($h['name'] ?? ''),
      norm($h['description'] ?? ''),
      norm($h['available'] ?? ''),
      norm($h['state'] ?? ''),
      norm($h['phone'] ?? ''),
      norm($h['text'] ?? '')
    ]);

    return str_contains($haystack, $q);
  });

  /* ---------- STATES ---------- */

  $states = array_unique(array_filter(array_map(fn($h) => $h['state'], $stateHotlines)));
  sort($states);
?>

<div class="container my-4">

<!-- HEADER + SEARCH -->
<div class="bg-danger-subtle rounded-4 p-4 mb-4" style="background:#fff5f5;">
  <h2 class="h6 text-danger">Emergency Hotlines & Crisis Support</h2>
  <p class="small text-danger mb-3">Confidential support available 24/7.</p>

  <form id="hotlineForm" method="get" class="bg-white p-3 rounded-4">
    <div class="row g-3">
      <div class="col-md-6">
        <input class="form-control" name="q" id="q"
               placeholder="Search hotlines"
               value="<?= htmlspecialchars($searchQuery) ?>">
      </div>

      <div class="col-md-6">
        <select class="form-select" name="state" id="state">
          <option value="all">All States</option>
          <?php foreach ($states as $s): ?>
            <option value="<?= htmlspecialchars($s) ?>" <?= $s === $selectedState ? 'selected' : '' ?>>
              <?= htmlspecialchars($s) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="mt-3 d-flex gap-2">
      <button name="view" value="national"
        class="btn btn-sm <?= $view==='national'?'btn-dark':'btn-outline-dark' ?>">
        National (<?= count($nationalHotlines) ?>)
      </button>
      <button name="view" value="state"
        class="btn btn-sm <?= $view==='state'?'btn-dark':'btn-outline-dark' ?>">
        State (<?= count($stateHotlines) ?>)
      </button>
    </div>
  </form>
</div>

<!-- CARDS -->
<div class="row g-3">
<?php if (count($filteredHotlines) === 0): ?>
  <div class="col-12">
    <div class="alert alert-light border">
      No hotlines found. Try a different keyword or change the state filter.
    </div>
  </div>
<?php endif; ?>

<?php foreach ($filteredHotlines as $h): ?>
  <div class="col-md-4">
    <div class="card h-100 border-danger-subtle">
      <div class="card-body d-flex flex-column">

        <h5 class="text-danger"><?= htmlspecialchars($h['name']) ?></h5>

        <?php if (!empty($h['available'])): ?>
          <div class="text-end mb-2">
  <span class="badge bg-success"><?= htmlspecialchars($h['available']) ?></span>
</div>
        <?php endif; ?>

        <p class="small text-muted"><?= htmlspecialchars($h['description']) ?></p>

        <div class="mt-auto">
          <?php if (!empty($h['phone'])): ?>
            <a class="btn btn-danger w-100 mb-2" href="tel:<?= preg_replace('/\D+/', '', $h['phone']) ?>">
              📞 <?= htmlspecialchars($h['phone']) ?>
            </a>
          <?php endif; ?>

          <?php if (!empty($h['text'])): ?>
            <a class="btn btn-outline-danger w-100 mb-2"
               href="sms:<?= preg_replace('/\D+/', '', $h['text']) ?>">
              💬 <?= htmlspecialchars($h['text']) ?>
            </a>
          <?php endif; ?>

          <?php if (!empty($h['website'])): ?>
            <a class="btn btn-link w-100" href="<?= htmlspecialchars($h['website']) ?>" target="_blank" rel="noopener">
              🌐 Visit Website
            </a>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

</div>

<script>
  // ✅ auto-submit when user types or changes state (so it "works" like a real search bar)
  const form = document.getElementById('hotlineForm');
  const q = document.getElementById('q');
  const state = document.getElementById('state');

  let t = null;
  q.addEventListener('input', () => {
    clearTimeout(t);
    t = setTimeout(() => form.submit(), 250);
  });

  state.addEventListener('change', () => form.submit());
</script>

<?php require 'footer.php'; ?>
