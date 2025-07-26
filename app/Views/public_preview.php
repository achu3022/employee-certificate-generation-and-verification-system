<!DOCTYPE html>
<html>
<head>
    <title>Document Preview</title>
    <style>
        body { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f8fafc; }
        .preview-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
            min-width: 80vw;
        }
        .preview-img {
            display: block;
            margin: 0 auto;
            max-width: 90vw;
            max-height: 80vh;
            transition: transform 0.2s;
        }
        .btn { margin: 1rem 0.5rem; }
        #pdf-controls { margin-bottom: 1rem; }
        #pdf-canvas {
            display: block;
            margin: 0 auto;
            border: 1px solid #ccc;
            border-radius: 0.5rem;
        }
        .zoom-controls { margin-bottom: 1rem; }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
</head>
<body>
    <div class="preview-container">
        <?php if (in_array($ext, ['jpg','jpeg','png'])): ?>
            <div class="zoom-controls">
                <button id="zoom-in-img" class="btn btn-secondary btn-sm">Zoom In</button>
                <button id="zoom-out-img" class="btn btn-secondary btn-sm">Zoom Out</button>
            </div>
            <img src="<?= $downloadUrl ?>" class="preview-img" id="preview-img" alt="<?= esc($doc['original_name']) ?>">
            <script>
            let imgZoom = 1.0;
            const img = document.getElementById('preview-img');
            document.getElementById('zoom-in-img').onclick = function() {
                imgZoom = Math.min(imgZoom + 0.2, 5.0);
                img.style.transform = `scale(${imgZoom})`;
            };
            document.getElementById('zoom-out-img').onclick = function() {
                imgZoom = Math.max(imgZoom - 0.2, 0.2);
                img.style.transform = `scale(${imgZoom})`;
            };
            </script>
        <?php elseif ($ext === 'pdf'): ?>
            <div id="pdf-controls">
                <button id="prev-page" class="btn btn-secondary btn-sm">Previous</button>
                <span>Page <span id="page-num">1</span> / <span id="page-count">1</span></span>
                <button id="next-page" class="btn btn-secondary btn-sm">Next</button>
                <button id="zoom-in" class="btn btn-secondary btn-sm">Zoom In</button>
                <button id="zoom-out" class="btn btn-secondary btn-sm">Zoom Out</button>
            </div>
            <canvas id="pdf-canvas" style="max-width:100%;max-height:80vh;"></canvas>
            <script>
            const url = "<?= $downloadUrl ?>";
            let pdfDoc = null,
                pageNum = 1,
                pageRendering = false,
                pageNumPending = null,
                scale = 1.0,
                canvas = document.getElementById('pdf-canvas'),
                ctx = canvas.getContext('2d');

            pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
                pdfDoc = pdfDoc_;
                document.getElementById('page-count').textContent = pdfDoc.numPages;
                renderPage(pageNum);
            });

            function renderPage(num) {
                pageRendering = true;
                pdfDoc.getPage(num).then(function(page) {
                    let viewport = page.getViewport({ scale: scale });
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;
                    let renderContext = {
                        canvasContext: ctx,
                        viewport: viewport
                    };
                    let renderTask = page.render(renderContext);
                    renderTask.promise.then(function() {
                        pageRendering = false;
                        document.getElementById('page-num').textContent = num;
                        if (pageNumPending !== null) {
                            renderPage(pageNumPending);
                            pageNumPending = null;
                        }
                    });
                });
            }

            function queueRenderPage(num) {
                if (pageRendering) {
                    pageNumPending = num;
                } else {
                    renderPage(num);
                }
            }

            document.getElementById('prev-page').addEventListener('click', function() {
                if (pageNum <= 1) return;
                pageNum--;
                queueRenderPage(pageNum);
            });
            document.getElementById('next-page').addEventListener('click', function() {
                if (pageNum >= pdfDoc.numPages) return;
                pageNum++;
                queueRenderPage(pageNum);
            });
            document.getElementById('zoom-in').addEventListener('click', function() {
                scale = Math.min(scale + 0.2, 3.0);
                queueRenderPage(pageNum);
            });
            document.getElementById('zoom-out').addEventListener('click', function() {
                scale = Math.max(scale - 0.2, 0.3);
                queueRenderPage(pageNum);
            });
            </script>
        <?php else: ?>
            <p>Preview not available for this file type.</p>
        <?php endif; ?>
        <div>
            <a href="<?= $downloadUrl ?>" class="btn btn-primary" download>Download</a>
        </div>
    </div>
</body>
</html> 