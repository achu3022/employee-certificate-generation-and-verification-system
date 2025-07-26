<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details - <?= esc($employee['name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #003583;
            --secondary-color: #00bfae;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        body { 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, #012350ff 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem 1rem 1rem;
            position: fixed;
            left: 0;
            top: 0;
            width: 240px;
            z-index: 100;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .logo {
            max-width: 120px;
            max-height: 80px;
            margin-bottom: 2rem;
            filter: brightness(0) invert(1);
        }

        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
            margin: 0.5rem 0;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
            text-decoration: none;
        }

        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.15);
            transform: translateX(5px);
        }

        .sidebar .logout-link {
            margin-top: auto;
            color: #fff;
            font-weight: 500;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            background: rgba(255,255,255,0.10);
            text-align: center;
            width: 100%;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .sidebar .logout-link:hover {
            background: rgba(255,255,255,0.25);
            color: #fff;
            transform: translateY(-2px);
        }

        .dashboard-navbar {
            position: fixed;
            left: 240px;
            right: 0;
            top: 0;
            height: 70px;
            background: linear-gradient(90deg, var(--primary-color) 0%, #00275a 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            z-index: 101;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .dashboard-navbar .navbar-title {
            font-size: 1.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .dashboard-navbar .navbar-user {
            font-size: 1.5rem;
        }

        .main-content {
            margin-left: 240px;
            padding: 2rem;
            padding-top: 90px;
            min-height: 100vh;
        }

        .action-btn {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            margin-right: 1rem;
            margin-bottom: 1rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-btn:hover {
            background: linear-gradient(90deg, var(--secondary-color) 0%, var(--primary-color) 100%);
            color: #fff;
            box-shadow: var(--hover-shadow);
            transform: translateY(-2px);
        }

        .action-btn:disabled {
            background: #6c757d !important;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        .employee-header {
            background: linear-gradient(135deg, #fff 0%, var(--light-bg) 100%);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .employee-name {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .employee-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 1.5rem;
        }

        .employee-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .employee-badge.active {
            background: linear-gradient(45deg, var(--success-color), #20c997);
            color: white;
        }

        .employee-badge.inactive {
            background: linear-gradient(45deg, #ff3800, #e34234);
            color: white;
        }

        .details-section {
            background: #fff;
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid var(--secondary-color);
            display: inline-block;
        }

        .detail-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .detail-item {
            background: var(--light-bg);
            padding: 1rem;
            border-radius: 0.75rem;
            border-left: 4px solid var(--secondary-color);
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            transform: translateX(5px);
            box-shadow: var(--card-shadow);
        }

        .detail-label {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .detail-value {
            font-size: 1.1rem;
            color: #333;
            font-weight: 500;
        }

        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .doc-container {
            background: #fff;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            text-align: center;
        }

        .doc-container:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .doc-thumb {
            border-radius: 0.75rem !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .doc-thumb:hover {
            transform: scale(1.05);
        }

        .doc-title {
            font-weight: 600;
            color: var(--primary-color);
            margin: 1rem 0 0.5rem 0;
            font-size: 1rem;
        }

        .doc-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 1rem;
        }

        .doc-actions .btn {
            border-radius: 0.5rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .doc-actions .btn:hover {
            transform: translateY(-2px);
        }

        .no-documents {
            background: linear-gradient(135deg, #fff 0%, var(--light-bg) 100%);
            border-radius: 1rem;
            padding: 3rem;
            text-align: center;
            box-shadow: var(--card-shadow);
        }

        .no-documents i {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .no-documents h5 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .no-documents p {
            color: #6c757d;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 100vw;
                min-height: auto;
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                padding: 1rem;
                position: static;
            }
            .dashboard-navbar {
                left: 0;
                padding: 0 1rem;
            }
            .main-content {
                margin-left: 0;
                margin-top: 80px;
                padding: 1rem;
            }
            .employee-name {
                font-size: 2rem;
            }
            .detail-row {
                grid-template-columns: 1fr;
            }
            .documents-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        /* Modal styling */
        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: var(--hover-shadow);
        }

        .modal-header {
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border-radius: 1rem 1rem 0 0;
        }

        .modal-title {
            font-weight: 600;
        }

        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 191, 174, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
<div class="sidebar shadow">
    <img src="/public/smec_white.png" alt="SMEC Logo" class="logo">
    <nav class="nav flex-column w-100 mt-2">
        <a class="nav-link" href="<?= site_url('/admin/dashboard') ?>"><i class="bi bi-people"></i> Employee List</a>
    </nav>
    <a href="<?= site_url('/admin/logout') ?>" class="logout-link mt-auto"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="dashboard-navbar">
    <span class="navbar-title"><i class="bi bi-person-badge"></i> Employee Details</span>
    <span class="navbar-user"><i class="bi bi-person-circle"></i></span>
</div>

<div class="main-content">
    <div class="container-fluid">
        <!-- Action Buttons -->
        <div class="d-flex flex-wrap gap-3 mb-4">
            <?php if ($offerLetterGenerated): ?>
                <button id="generate-offer-letter" class="action-btn" disabled>
                    <i class="bi bi-file-earmark-check"></i> Offer Letter Generated
                </button>
            <?php else: ?>
                <button id="generate-offer-letter" class="action-btn">
                    <i class="bi bi-file-earmark-plus"></i> Generate Offer Letter
                </button>
            <?php endif; ?>
            <a href="#" id="generate-experience-letter" class="action-btn">
                <i class="bi bi-file-earmark-text"></i> Generate Experience Letter
            </a>
            <a href="<?= site_url('/admin/dashboard') ?>" class="action-btn">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Employee Header -->
        <div class="employee-header">
            <h1 class="employee-name"><?= esc($employee['name']) ?></h1>
            <div class="employee-subtitle">
                <i class="bi bi-person-badge"></i> ID: <?= esc($employee['employee_id']) ?> | 
                <span class="employee-badge <?= $employee['status'] === 'active' ? 'active' : 'inactive' ?>">
                    <i class="bi bi-circle-fill"></i> <?= ucfirst($employee['status']) ?>
                </span>
            </div>
        </div>

        <!-- Employee Details -->
        <div class="details-section">
            <h3 class="section-title"><i class="bi bi-info-circle"></i> Employee Information</h3>
            <div class="detail-row">
                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-briefcase"></i> Designation</div>
                    <div class="detail-value"><?= esc($employee['designation']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-building"></i> Department</div>
                    <div class="detail-value"><?= esc($employee['department']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-geo-alt"></i> Location</div>
                    <div class="detail-value"><?= esc($employee['location']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-telephone"></i> Contact</div>
                    <div class="detail-value"><?= esc($employee['contact']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-calendar-event"></i> Start Date</div>
                    <div class="detail-value"><?= esc(date('d/m/Y', strtotime($employee['start_date']))) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-calendar-x"></i> End Date</div>
                    <div class="detail-value"><?= $employee['end_date'] ? esc(date('d/m/Y', strtotime($employee['end_date']))) : 'Present' ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label"><i class="bi bi-gift"></i> Date of Birth</div>
                    <div class="detail-value"><?= esc(date('d/m/Y', strtotime($employee['dob']))) ?></div>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        <div class="details-section">
            <h3 class="section-title"><i class="bi bi-folder2-open"></i> Documents</h3>
            <div class="documents-grid" id="documents-list">
                <?php if (!empty($documents)): ?>
                    <?php foreach ($documents as $doc): ?>
                        <div class="doc-container doc-type-<?= str_replace('_', '-', $doc['doc_type']) ?>">
                            <?php
                            $ext = strtolower(pathinfo($doc['file_name'], PATHINFO_EXTENSION));
                            $downloadUrl = site_url('/admin/download/' . $doc['id']);
                            ?>
                            <?php if ($ext === 'pdf'): ?>
                                <div class="pdf-thumbnail-container" style="position: relative;">
                                    <canvas id="pdf-thumb-<?= $doc['id'] ?>" data-url="<?= $downloadUrl ?>" class="doc-thumb mb-2" style="width:240px;height:330px;border:1px solid #ccc;border-radius:0.5rem;background: #f8f9fa;"></canvas>
                                    <div class="pdf-fallback" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; display: none;">
                                        <i class="bi bi-file-earmark-pdf display-4 text-danger"></i>
                                        <div class="small text-muted mt-2">PDF Preview</div>
                                    </div>
                                </div>
                            <?php elseif (in_array($ext, ['jpg','jpeg','png'])): ?>
                                <img src="<?= $downloadUrl ?>" class="img-thumbnail doc-thumb mb-2" alt="<?= esc($doc['original_name']) ?>" style="width:240px;height:330px;object-fit:cover;border:1px solid #ccc;border-radius:0.5rem;">
                            <?php elseif (in_array($ext, ['doc','docx'])): ?>
                                <div class="doc-thumb mb-2" style="width:240px;height:330px;background: #f8f9fa;display:flex;align-items:center;justify-content:center;border:1px solid #ccc;border-radius:0.5rem;">
                                    <i class="bi bi-file-earmark-word display-4 text-primary"></i>
                                </div>
                            <?php else: ?>
                                <div class="doc-thumb mb-2" style="width:240px;height:330px;background: #f8f9fa;display:flex;align-items:center;justify-content:center;border:1px solid #ccc;border-radius:0.5rem;">
                                    <i class="bi bi-file-earmark display-4 text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="doc-title"><?= ucwords(str_replace('_',' ', $doc['doc_type'])) ?></div>
                            <div class="doc-actions">
                                <a href="<?= $downloadUrl ?>" class="btn btn-outline-primary btn-sm" download>
                                    <i class="bi bi-download"></i> Download
                                </a>
                                <button class="btn btn-outline-danger btn-sm delete-doc-btn" data-doc-id="<?= $doc['id'] ?>">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-documents">
                        <i class="bi bi-folder-x"></i>
                        <h5>No Documents Available</h5>
                        <p>No documents have been uploaded for this employee yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Offer Letter Details Modal -->
<div class="modal fade" id="offerLetterModal" tabindex="-1" aria-labelledby="offerLetterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="offerLetterModalLabel">
            <i class="bi bi-file-earmark-plus"></i> Offer Letter Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="offerLetterForm">
          <div class="mb-3">
            <label for="joining_date" class="form-label">Joining Date</label>
            <input type="text" class="form-control" id="joining_date" name="joining_date" required pattern="\d{2}/\d{2}/\d{4}" placeholder="dd/mm/yyyy">
          </div>
          <div class="mb-3">
            <label for="salary" class="form-label">Salary (INR per month)</label>
            <input type="text" class="form-control" id="salary" name="salary" required>
          </div>
          <div class="mb-3">
            <label for="reporting_manager" class="form-label">Reporting Manager</label>
            <input type="text" class="form-control" id="reporting_manager" name="reporting_manager" value="Shiyas A (Mob: 9656227714)" required>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-file-earmark-plus"></i> Generate Offer Letter
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

        <!-- Add PDF.js CDN -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
        <script>
            // Set PDF.js worker path
            if (typeof pdfjsLib !== 'undefined') {
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
            }
        </script>

<!-- Ensure Bootstrap JS is included before custom JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Offer Letter Modal open
            const offerLetterBtn = document.getElementById('generate-offer-letter');
            const offerLetterModal = document.getElementById('offerLetterModal');
            if (offerLetterBtn && offerLetterModal && !offerLetterBtn.disabled) {
                offerLetterBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var modal = new bootstrap.Modal(offerLetterModal);
                    modal.show();
                });
            }

            // Offer Letter Modal submit
            const offerLetterForm = document.getElementById('offerLetterForm');
            offerLetterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const empId = <?= json_encode($employee['id']) ?>;
                const joining_date = document.getElementById('joining_date').value;
                const salary = document.getElementById('salary').value;
                const reporting_manager = document.getElementById('reporting_manager').value;
                const url = "<?= site_url('/offer-letter/generate') ?>";
                const formData = new FormData();
                formData.append('employee_id', empId);
                formData.append('joining_date', joining_date);
                formData.append('salary', salary);
                formData.append('reporting_manager', reporting_manager);

                const submitBtn = offerLetterForm.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating...';

                fetch(url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) return response.text().then(text => { throw new Error(text); });
                    return response.json();
                })
                .then(data => {
                    if (data.download_url) {
                        const docList = document.querySelector('#documents-list');
                        const canvasId = `pdf-thumb-${data.doc_id}`;
                        const newDocHtml = `
                            <div class="doc-container doc-type-offer-letter">
                                <div class="pdf-thumbnail-container" style="position: relative;">
                                    <canvas id="${canvasId}" class="doc-thumb mb-2" style="width:240px;height:330px;border:1px solid #ccc;border-radius:0.5rem;background: #f8f9fa;"></canvas>
                                    <div class="pdf-fallback" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; display: none;">
                                        <i class="bi bi-file-earmark-pdf display-4 text-danger"></i>
                                        <div class="small text-muted mt-2">PDF Preview</div>
                                    </div>
                                </div>
                                <div class="doc-title">Offer Letter</div>
                                <div class="doc-actions">
                                    <a href="${data.download_url}" class="btn btn-outline-primary btn-sm" download><i class="bi bi-download"></i> Download</a>
                                    <button class="btn btn-outline-danger btn-sm delete-doc-btn" data-doc-id="${data.doc_id}"><i class="bi bi-trash"></i> Delete</button>
                                </div>
                            </div>
                        `;
                        docList.insertAdjacentHTML('beforeend', newDocHtml);
                        
                        // Render PDF thumbnail after a short delay to ensure DOM is updated
                        setTimeout(() => {
                            renderPdfThumbnail(data.download_url, canvasId);
                        }, 100);
                        
                        addDeleteHandlers();
                        
                        // Disable the generate offer letter button
                        const offerLetterBtn = document.getElementById('generate-offer-letter');
                        if (offerLetterBtn) {
                            offerLetterBtn.disabled = true;
                            offerLetterBtn.className = 'action-btn';
                            offerLetterBtn.style.background = '#6c757d';
                            offerLetterBtn.style.cursor = 'not-allowed';
                            offerLetterBtn.innerHTML = '<i class="bi bi-file-earmark-check"></i> Offer Letter Generated';
                        }
                        
                        bootstrap.Modal.getInstance(document.getElementById('offerLetterModal')).hide();
                    } else {
                        alert('Error generating offer letter.');
                    }
                })
                .catch(error => {
                    alert('Error generating offer letter: ' + error.message);
                    console.error('Error generating offer letter:', error.message);
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="bi bi-file-earmark-plus"></i> Generate Offer Letter';
                });
            });

            document.getElementById('generate-experience-letter').addEventListener('click', function(e) {
                e.preventDefault();
                
                const btn = this;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating...';

                // Hide existing experience certificate from the list
                const existingCert = document.querySelector('.doc-type-experience-certificate');
                if (existingCert) {
                    existingCert.style.display = 'none';
                }

                var empId = <?= json_encode($employee['id']) ?>;
                var today = new Date().toISOString().slice(0, 10);
                var url = "<?= site_url('/experience-certificate/generate') ?>?employee_id=" + empId + "&date=" + today;
                
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.download_url) {
                            // Dynamically add the new document to the list
                            const docList = document.querySelector('#documents-list');
                            const newDocHtml = `
                                <div class="doc-container doc-type-experience-certificate">
                                    <img src="${data.download_url}" class="img-thumbnail doc-thumb mb-2" alt="Experience Certificate" style="width:240px;height:330px;object-fit:cover;border:1px solid #ccc;border-radius:0.5rem;">
                                    <div class="doc-title">Experience Certificate</div>
                                    <div class="doc-actions">
                                        <a href="${data.download_url}" class="btn btn-outline-primary btn-sm" download><i class="bi bi-download"></i> Download</a>
                                        <button class="btn btn-outline-danger btn-sm delete-doc-btn" data-doc-id="${data.doc_id}"><i class="bi bi-trash"></i> Delete</button>
                                    </div>
                                </div>
                            `;
                            docList.insertAdjacentHTML('beforeend', newDocHtml);
                            addDeleteHandlers(); // Add delete handler after inserting new document
                        } else {
                            alert('Error generating certificate');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error generating certificate');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-file-earmark-text"></i> Generate Experience Letter';
                    });
            });

            function addDeleteHandlers() {
                document.querySelectorAll('.delete-doc-btn').forEach(btn => {
                    btn.onclick = function() {
                        console.log('Delete clicked for docId:', this.getAttribute('data-doc-id'));
                        if (!confirm('Are you sure you want to delete this document?')) return;
                        const docId = this.getAttribute('data-doc-id');
                        const docContainer = this.closest('.doc-container');
                        const isOfferLetter = docContainer.classList.contains('doc-type-offer-letter');
                        
                        fetch(`<?= site_url('/admin/document/delete/') ?>${docId}`, {
                            method: 'POST',
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                docContainer.remove();
                                
                                // If offer letter was deleted, re-enable the generate button
                                if (isOfferLetter) {
                                    const offerLetterBtn = document.getElementById('generate-offer-letter');
                                    if (offerLetterBtn) {
                                        offerLetterBtn.disabled = false;
                                        offerLetterBtn.className = 'action-btn';
                                        offerLetterBtn.style.background = 'linear-gradient(90deg, #007bff 0%, #00c6ff 100%)';
                                        offerLetterBtn.style.cursor = 'pointer';
                                        offerLetterBtn.innerHTML = '<i class="bi bi-file-earmark-plus"></i> Generate Offer Letter';
                                        
                                        // Re-add click event listener
                                        offerLetterBtn.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            var modal = new bootstrap.Modal(document.getElementById('offerLetterModal'));
                                            modal.show();
                                        });
                                    }
                                }
                            } else {
                                alert('Delete failed: ' + (data.error || 'Unknown error'));
                            }
                        })
                        .catch(() => alert('Delete failed.'));
                    };
                });
            }

            // Ensure handlers are attached after DOM is loaded
            addDeleteHandlers();

            // PDF.js thumbnail rendering function
            function renderPdfThumbnail(pdfUrl, canvasId) {
                // Check if PDF.js is loaded
                if (typeof pdfjsLib === 'undefined') {
                    console.error('PDF.js library not loaded');
                    return;
                }

                const canvas = document.getElementById(canvasId);
                if (!canvas) {
                    console.error('Canvas element not found:', canvasId);
                    return;
                }

                // Set canvas dimensions
                canvas.width = 240;
                canvas.height = 330;

                // Show loading state
                const context = canvas.getContext('2d');
                context.fillStyle = '#f8f9fa';
                context.fillRect(0, 0, canvas.width, canvas.height);
                context.fillStyle = '#6c757d';
                context.font = '14px Arial';
                context.textAlign = 'center';
                context.fillText('Loading PDF...', canvas.width / 2, canvas.height / 2);

                try {
                    // Add timeout to prevent hanging
                    const timeoutPromise = new Promise((_, reject) => {
                        setTimeout(() => reject(new Error('PDF loading timeout')), 10000); // 10 second timeout
                    });

                    const loadingTask = pdfjsLib.getDocument({
                        url: pdfUrl,
                        withCredentials: false
                    });

                    Promise.race([loadingTask.promise, timeoutPromise]).then(function(pdf) {
                        return pdf.getPage(1);
                    }).then(function(page) {
                        const viewport = page.getViewport({ scale: 1.0 });
                        const scale = Math.min(canvas.width / viewport.width, canvas.height / viewport.height);
                        const scaledViewport = page.getViewport({ scale: scale });

                        // Set canvas dimensions to match the scaled viewport
                        canvas.width = scaledViewport.width;
                        canvas.height = scaledViewport.height;

                        const renderContext = {
                            canvasContext: context,
                            viewport: scaledViewport
                        };

                        return page.render(renderContext);
                    }).catch(function(error) {
                        console.error('Error rendering PDF:', error);
                        showPdfFallback(canvasId);
                    });
                } catch (error) {
                    console.error('Error loading PDF:', error);
                    showPdfFallback(canvasId);
                }
            }

            // Show PDF fallback when rendering fails
            function showPdfFallback(canvasId) {
                const canvas = document.getElementById(canvasId);
                if (canvas) {
                    const container = canvas.closest('.pdf-thumbnail-container');
                    if (container) {
                        const fallback = container.querySelector('.pdf-fallback');
                        if (fallback) {
                            fallback.style.display = 'block';
                        }
                    }
                }
            }

            // Initialize PDF thumbnails for existing documents
            function initializePdfThumbnails() {
                document.querySelectorAll('canvas[id^="pdf-thumb-"]').forEach(function(canvas) {
                    var pdfUrl = canvas.getAttribute('data-url');
                    if (pdfUrl) {
                        renderPdfThumbnail(pdfUrl, canvas.id);
                    }
                });
            }

            // Initialize everything after DOM is loaded
            addDeleteHandlers();
            initializePdfThumbnails();
        });
        </script>

        <!-- jQuery and jQuery UI for datepicker -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script>
        $(function() {
            $('#joining_date').datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: '2000:2030',
                maxDate: 0
            });
            $('#offerLetterForm').on('submit', function() {
                var val = $('#joining_date').val();
                if (val) {
                    var parts = val.split('/');
                    if (parts.length === 3) {
                        $('#joining_date').val(parts[0] + '-' + parts[1] + '-' + parts[2]);
                    }
                }
            });
        });
        </script>
    </body>
    </html> 