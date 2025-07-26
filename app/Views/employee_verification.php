<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Verification - SMEC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
    :root {
        --primary: #2563eb;
        --primary-light: #3b82f6;
        --primary-dark: #1d4ed8;
        --primary-bg: #eff6ff;
        --primary-border: #dbeafe;
        --text-primary: #1e40af;
        --text-secondary: #64748b;
    }
    
    body {
        background: #f8fafc;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 20px;
        min-height: 100vh;
    }
    
    .logo {
        max-width: 150px;
        margin: 0 auto 2rem auto;
        display: block;
        filter: drop-shadow(0 4px 8px rgba(37, 99, 235, 0.15));
    }
    
    .search-section {
        max-width: 600px;
        margin: 0 auto 2rem auto;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.1);
        padding: 2rem;
        border: 1px solid var(--primary-border);
    }
    
    .section-header {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--primary);
        background: var(--primary-bg);
        border-radius: 0.8rem;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        border-left: 4px solid var(--primary);
    }
    
    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    
    .form-control {
        border-radius: 0.6rem;
        border: 2px solid var(--primary-border);
        background: #fff;
        font-size: 1rem;
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }
    
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        outline: none;
    }
    
    .btn-primary {
        background: var(--primary);
        border: none;
        font-weight: 600;
        font-size: 1rem;
        border-radius: 0.6rem;
        padding: 0.75rem 1.5rem;
        transition: all 0.2s ease;
    }
    
    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
    
    .btn-secondary {
        background: #64748b;
        border: none;
        font-weight: 500;
        font-size: 1rem;
        border-radius: 0.6rem;
        padding: 0.75rem 1.5rem;
        transition: all 0.2s ease;
    }
    
    .btn-secondary:hover {
        background: #475569;
        transform: translateY(-1px);
    }
    
    .emp-card {
        max-width: 800px;
        margin: 0 auto 2rem auto;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.1);
        padding: 2rem;
        border: 1px solid var(--primary-border);
    }
    
    .list-group-item {
        border: none;
        border-bottom: 1px solid var(--primary-border);
        padding: 1rem 0;
        background: transparent;
        color: var(--text-secondary);
    }
    
    .list-group-item:last-child {
        border-bottom: none;
    }
    
    .list-group-item strong {
        color: var(--text-primary);
        font-weight: 600;
        margin-right: 0.5rem;
    }
    
    .badge {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        border-radius: 1rem;
        font-weight: 600;
    }
    
    .doc-section {
        max-width: 800px;
        margin: 0 auto 2rem auto;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(37, 99, 235, 0.1);
        padding: 2rem;
        border: 1px solid var(--primary-border);
    }
    
    .list-group {
        border-radius: 0.8rem;
        overflow: hidden;
        border: 1px solid var(--primary-border);
    }
    
    .list-group-item {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--primary-border);
        background: #fff;
        transition: background-color 0.2s ease;
    }
    
    .list-group-item:hover {
        background: var(--primary-bg);
    }
    
    .list-group-item a {
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .list-group-item a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }
    
    .footer {
        text-align: center;
        color: var(--text-secondary);
        margin-top: 2rem;
        font-size: 0.9rem;
    }
    
    .alert {
        border-radius: 0.8rem;
        border: none;
        padding: 1rem 1.5rem;
    }
    
    .alert-danger {
        background: #fef2f2;
        color: #dc2626;
        border-left: 4px solid #dc2626;
    }
    
    .alert-warning {
        background: #fffbeb;
        color: #d97706;
        border-left: 4px solid #d97706;
    }
    
    @media (max-width: 768px) {
        body {
            padding: 15px;
        }
        
        .search-section,
        .emp-card,
        .doc-section {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .section-header {
            font-size: 1.2rem;
            padding: 0.8rem 1.2rem;
        }
        
        .logo {
            max-width: 120px;
            margin-bottom: 1.5rem;
        }
    }
    
    @media (max-width: 480px) {
        .search-section,
        .emp-card,
        .doc-section {
            padding: 1rem;
            border-radius: 0.8rem;
        }
        
        .section-header {
            font-size: 1.1rem;
            padding: 0.7rem 1rem;
        }
        
        .btn-primary,
        .btn-secondary {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
    </style>
</head>
<body>
    <a href="/">
        <img src="public/smec_logo.png" alt="SMEC Logo" class="logo">
    </a>
    <div class="search-section">
        <div class="section-header justify-content-center"><i class="bi bi-search"></i> Employee Verification</div>
        <form method="get" action="/">
            <div class="mb-3">
                <label for="employee_id" class="form-label">Employee ID</label>
                <input type="text" class="form-control" id="employee_id" name="employee_id" required value="<?= esc($_GET['employee_id'] ?? '') ?>">
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="text" class="form-control" id="dob" name="dob" required pattern="\d{2}/\d{2}/\d{4}" placeholder="dd/mm/yyyy" value="<?= esc(isset($_GET['dob']) ? (date('d/m/Y', strtotime($_GET['dob']))):'') ?>">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-search"></i> Search</button>
                <a href="/" class="btn btn-secondary btn-lg">Reset</a>
            </div>
        </form>
        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger mt-3 text-center"><?= esc($error) ?></div>
        <?php endif; ?>
    </div>
    <?php if (isset($employee) && $employee): ?>
    <div class="emp-card">
        <div class="section-header"><i class="bi bi-person-badge"></i> Employee Details</div>
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <ul class="list-group list-group-flush mb-0">
                    <li class="list-group-item"><strong>Employee ID:</strong> <?= esc($employee['employee_id']) ?></li>
                    <li class="list-group-item"><strong>Name:</strong> <?= esc($employee['name']) ?></li>
                    <li class="list-group-item"><strong>Designation:</strong> <?= esc($employee['designation']) ?></li>
                    <li class="list-group-item"><strong>Department:</strong> <?= esc($employee['department']) ?></li>
                    <li class="list-group-item"><strong>Contact:</strong> <?= esc($employee['contact']) ?></li>
                    <li class="list-group-item"><strong>Location:</strong> <?= esc($employee['location']) ?></li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-group list-group-flush mb-0">
                    <li class="list-group-item"><strong>Status:</strong> <span class="badge <?= $employee['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>"><?= ucfirst(esc($employee['status'])) ?></span></li>
                    <li class="list-group-item"><strong>Start Date:</strong> <?= esc(date('d-m-Y', strtotime($employee['start_date']))) ?></li>
                    <li class="list-group-item"><strong>End Date:</strong> <?= ($employee['end_date'] && $employee['end_date'] !== '0000-00-00' && $employee['end_date'] !== '0-00-0000') ? esc(date('d-m-Y', strtotime($employee['end_date']))) : '<span class=\'text-success\'>Currently Working</span>' ?></li>
                    <li class="list-group-item"><strong>Date of Birth:</strong> <?= esc(date('d-m-Y', strtotime($employee['dob']))) ?></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="doc-section">
        <div class="section-header"><i class="bi bi-files"></i> Documents</div>
        <?php
        $docModel = new \App\Models\DocumentModel();
        $docs = $docModel->where('employee_id', $employee['id'])->findAll();
        ?>
        <?php if (empty($docs)): ?>
            <div class="alert alert-warning">No documents uploaded.</div>
        <?php else: ?>
            <ul class="list-group">
                <?php foreach ($docs as $doc): ?>
                    <?php
                    $ext = strtolower(pathinfo($doc['file_name'], PATHINFO_EXTENSION));
                    $previewUrl = site_url('/public/preview/' . $doc['id']);
                    $label = ucwords(str_replace('_',' ', $doc['doc_type']));
                    $icon = '<i class="bi bi-file-earmark"></i>';
                    if ($ext === 'pdf') $icon = '<i class="bi bi-file-earmark-pdf text-danger"></i>';
                    elseif (in_array($ext, ['jpg','jpeg','png'])) $icon = '<i class="bi bi-file-earmark-image text-primary"></i>';
                    elseif (in_array($ext, ['doc','docx'])) $icon = '<i class="bi bi-file-earmark-word text-primary"></i>';
                    ?>
                    <li class="list-group-item d-flex align-items-center">
                        <?= $icon ?>
                        <a href="<?= $previewUrl ?>" target="_blank" class="ms-2 text-decoration-underline"> <?= $label ?> </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="footer">
        &copy; <span id="copyright-year"></span> All rights reserved SMEC
    </div>
    <script>
        document.getElementById('copyright-year').textContent = new Date().getFullYear();
    </script>
    <!-- jQuery and jQuery UI for datepicker -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script>
$(function() {
  $('#dob').datepicker({
    dateFormat: 'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    yearRange: '1950:2025',
    maxDate: 0
  });
  // On form submit, convert to dd-mm-yyyy for backend
  $('form').on('submit', function() {
    var dob = $('#dob').val();
    if (dob) {
      var parts = dob.split('/');
      if (parts.length === 3) {
        $('#dob').val(parts[0] + '-' + parts[1] + '-' + parts[2]);
      }
    }
  });
});
</script>
</body>
</html>
