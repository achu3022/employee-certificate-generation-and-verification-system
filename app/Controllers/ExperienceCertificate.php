<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\EmployeeModel;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class ExperienceCertificate extends Controller
{
    public function generate()
    {
        $employeeId = $this->request->getGet('employee_id');
        $date = $this->request->getGet('date');
        if (!$employeeId || !$date) {
            return $this->response->setStatusCode(400)->setBody('Missing parameters');
        }
        $employeeModel = new EmployeeModel();
        $emp = $employeeModel->find($employeeId);
        if (!$emp) {
            return $this->response->setStatusCode(404)->setBody('Employee not found');
        }
        $refNo = 'SMEC/EXPCRT/2025/' . str_pad($employeeId, 5, '0', STR_PAD_LEFT);
        $content = [
            'ref_no' => $refNo,
            'date' => date('d.m.Y', strtotime($date)),
            'name' => $emp['name'],
            'designation' => $emp['designation'],
            'start_date' => date('jS F Y', strtotime($emp['start_date'])),
            'end_date' => date('jS F Y', strtotime($emp['end_date'])),
            'gender' => $emp['gender'] ?? 'his',
        ];
        // Create verification URL with employee ID and DOB
        $verifyUrl = base_url('/?employee_id=' . $emp['employee_id'] . '&dob=' . $emp['dob']);
        
        // Generate QR code as image (classic approach, version-agnostic)
        $qr = new \Endroid\QrCode\QrCode($verifyUrl);
        if (method_exists($qr, 'setSize')) $qr->setSize(150);
        if (method_exists($qr, 'setMargin')) $qr->setMargin(10);
        $writer = new \Endroid\QrCode\Writer\PngWriter();
        $qrResult = $writer->write($qr);
        $qrPath = WRITEPATH . 'uploads/experience_certificates/qr_' . uniqid() . '.png';
        file_put_contents($qrPath, $qrResult->getString());
        // Load background
        $bgPath = FCPATH . 'exp-backgroung.jpg';
        $im = imagecreatefromjpeg($bgPath);
        $width = imagesx($im);
        $height = imagesy($im);
        // Colors
        $black = imagecolorallocate($im, 34, 34, 34);
        $blue = imagecolorallocate($im, 0, 95, 90);
        // Fonts (adjust path as needed)
        $font = FCPATH . 'fonts/DejaVuSans.ttf'; // If you put it in public/fonts/
        $boldFont = FCPATH . 'fonts/DejaVuSans-Bold.ttf';
        // --- Certificate Layout ---
        $bodyFontSize = intval($height * 0.012);
        $footerFontSize = intval($height * 0.014);
        $leftMargin = intval($width * 0.10);
        $rightMargin = intval($width * 0.10);
        $topPadding = intval($height * 0.18); // 6% of page height as top padding
        $bottomMargin = intval($height * 0.10);

        // Reference and date section (top left)
        $refY = $topPadding;
        $dateY = $refY + intval($bodyFontSize * 2.0);
        $dateSectionBottom = $dateY + intval($bodyFontSize * 1.5); // bottom of date section
        // Heading section (centered, with extra gap above and below)
        $headingSectionTop = $dateSectionBottom + 60; // 60px gap after date section
        $titleFontSize = intval($height * 0.022);
        $titleBox = imagettfbbox($titleFontSize, 0, $font, 'Experience & Relieving Certificate');
        $titleWidth = $titleBox[2] - $titleBox[0];
        $titleX = intval(($width - $titleWidth) / 2);
        $titleY = $headingSectionTop + $titleFontSize; // heading baseline
        $headingSectionBottom = $titleY + intval($titleFontSize * 1.5); // bottom of heading section
        $bodyY = $headingSectionBottom + 30; // 30px gap after heading
        $footerY = intval($height * 0.64) + $topPadding / 2;
        // Draw reference and date
        $refText = 'Ref. No.: ' . $content['ref_no'];
        $dateText = 'Date: ' . $content['date'];
        imagettftext($im, $bodyFontSize, 0, $leftMargin, $refY, $black, $font, $refText);
        imagettftext($im, $bodyFontSize, 0, $leftMargin, $dateY, $black, $font, $dateText);
        // Draw heading (centered, in its own section)
        imagettftext($im, $titleFontSize, 0, $titleX, $titleY, $blue, $font, 'Experience & Relieving Certificate');
        // (Logo placement code removed)
        // Body (multi-paragraph, left-aligned, with bold for name/designation/dates)
        $bodyParagraphs = [
            [
                'prefix1' => "This is to certify that Mr./Ms./Mrs. ",
                'name' => $content['name'],
                'prefix2' => " worked in our organization as ",
                'designation' => $content['designation'],
                'prefix3' => " from ",
                'start_date' => $content['start_date'],
                'prefix4' => " to ",
                'end_date' => $content['end_date'],
                'suffix' => "."
            ],
            "During {$content['gender']} tenure, {$content['gender']} demonstrated strong expertise in {$content['gender']} field, acquiring substantial knowledge and skills. {$content['gender']} has gained valuable exposure and consistently displayed initiative, professionalism, and a positive attitude toward completing assigned tasks within the stipulated time frame. {$content['gender']} conduct and character have been commendable.",
            "We also confirm that {$content['gender']} was relieved unconditionally from {$content['gender']} duties and responsibilities by the end of {$content['end_date']}.",
            "We extend our best wishes for {$content['gender']} future endeavours."
        ];
        // Render the first paragraph with word wrapping and selective bold
        $firstParts = [
            ['text' => "This is to certify that Mr./Ms./Mrs. ", 'font' => $font],
            ['text' => $content['name'] . ' ', 'font' => $boldFont],
            ['text' => "worked in our organization as ", 'font' => $font],
            ['text' => $content['designation'] . ' ', 'font' => $boldFont],
            ['text' => "from ", 'font' => $font],
            ['text' => $content['start_date'] . ' ', 'font' => $boldFont],
            ['text' => "to ", 'font' => $font],
            ['text' => $content['end_date'], 'font' => $boldFont],
            ['text' => ".", 'font' => $font],
        ];
        $maxLineWidth = $width - $leftMargin - $rightMargin;
        $y = $bodyY;
        $x = $leftMargin;
        foreach ($firstParts as $part) {
            $words = explode(' ', $part['text']);
            foreach ($words as $wi => $word) {
                $wordToDraw = $word . ($wi < count($words) - 1 ? ' ' : '');
                $box = imagettfbbox($bodyFontSize, 0, $part['font'], $wordToDraw);
                $wordWidth = $box[2] - $box[0];
                if ($x + $wordWidth > $leftMargin + $maxLineWidth) {
                    $y += intval($bodyFontSize * 2.1);
                    $x = $leftMargin;
                }
                imagettftext($im, $bodyFontSize, 0, $x, $y, $black, $part['font'], $wordToDraw);
                $x += $wordWidth;
            }
        }
        $y += intval($bodyFontSize * 2.1) + intval($bodyFontSize * 1.2);
        // Render only the remaining paragraphs
        for ($i = 1; $i < count($bodyParagraphs); $i++) {
            $para = $bodyParagraphs[$i];
            $lines = ttfWordWrapJustify($para, $font, $bodyFontSize, $width - $leftMargin - $rightMargin, $leftMargin);
            foreach ($lines as $lineData) {
                $line = $lineData['text'];
                imagettftext($im, $bodyFontSize, 0, $leftMargin, $y, $black, $font, trim($line));
                $y += intval($bodyFontSize * 2.1);
            }
            $y += intval($bodyFontSize * 1.2);
        }
        // Footer (multi-line, left-aligned, larger font)
        $footerFontSize = intval($bodyFontSize * 1.0); // footer font same as body
        $footerLines = [
            '',
            'Thanking you',
            'Yours Truly,',
            'For SMEC Automation Pvt. Ltd.',
            // reduced empty lines here
            '',
            'Authorized Signatory',
            'Managing Director',
            'Saiju Mohammed'
        ];
        $footerY = $y + 30; // reduce gap between content and footer
        $fy = $footerY;
        $authSignatoryY = 0;
        foreach ($footerLines as $idx => $fline) {
            if (trim($fline) !== '') {
                imagettftext($im, $footerFontSize, 0, $leftMargin, $fy, $black, $font, $fline);
                if ($fline === 'Thanking you') {
                    $qrSectionY = $fy; // align QR code section with 'Thanking you'
                }
                if ($fline === 'Authorized Signatory') {
                    $authSignatoryY = $fy;
                }
            }
            // Reduce gap after 'For SMEC Automation Pvt. Ltd.'
            if ($fline === 'For SMEC Automation Pvt. Ltd.') {
                $fy += intval($footerFontSize * 1.5); // smaller gap
            } else {
                $fy += intval($footerFontSize * 2.1);
            }
        }
        // (QR code logic removed)
        // Save JPEG
        $filename = 'Experience_Certificate_' . $content['name'] . '_' . date('YmdHis') . '.jpg';
        $folder = WRITEPATH . 'uploads/experience_certificates/';
        if (!is_dir($folder)) mkdir($folder, 0777, true);
        $filepath = $folder . $filename;
        imagejpeg($im, $filepath, 95);

        // Generate thumbnail
        $thumbWidth = 300; // thumbnail width
        $ratio = $height / $width;
        $thumbHeight = intval($thumbWidth * $ratio);
        $thumbnail = imagecreatetruecolor($thumbWidth, $thumbHeight);
        imagecopyresampled($thumbnail, $im, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
        
        // Save thumbnail
        $thumbFilename = 'thumb_' . $filename;
        $thumbPath = $folder . $thumbFilename;
        imagejpeg($thumbnail, $thumbPath, 80);
        
        imagedestroy($thumbnail);
        imagedestroy($im);
        // imagedestroy($qrImg); // Removed as QR code is no longer generated here
        unlink($qrPath);

        // Save to documents table (replace if exists)
        $documentModel = new \App\Models\DocumentModel();
        $oldDoc = $documentModel->where(['employee_id' => $employeeId, 'doc_type' => 'experience_certificate'])->first();
        if ($oldDoc) {
            $oldPath = $folder . $oldDoc['file_name'];
            $oldThumbPath = $folder . 'thumb_' . $oldDoc['file_name'];
            if (is_file($oldPath)) unlink($oldPath);
            if (is_file($oldThumbPath)) unlink($oldThumbPath);
            $documentModel->update($oldDoc['id'], [
                'file_name' => $filename,
                'original_name' => $filename,
                'uploaded_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $documentModel->insert([
                'employee_id' => $employeeId,
                'doc_type' => 'experience_certificate',
                'file_name' => $filename,
                'original_name' => $filename,
                'uploaded_at' => date('Y-m-d H:i:s')
            ]);
        }
        $docId = $documentModel->getInsertID();
        return $this->response->setJSON([
            'doc_id' => $docId,
            'thumbnail_url' => base_url('writable/uploads/experience_certificates/' . $thumbFilename),
            'image_url' => base_url('writable/uploads/experience_certificates/' . $filename),
            'download_url' => site_url('/admin/download/' . $docId)
        ]);
    }
}

function ttfWordWrapJustify($text, $font, $fontSize, $maxWidth, $leftMargin) {
    $lines = [];
    foreach (explode("\n", $text) as $paragraph) {
        $words = explode(' ', $paragraph);
        $line = '';
        foreach ($words as $word) {
            $testLine = $line === '' ? $word : "$line $word";
            $box = imagettfbbox($fontSize, 0, $font, $testLine);
            $lineWidth = $box[2] - $box[0];
            if ($lineWidth > $maxWidth && $line !== '') {
                $lines[] = ['text' => $line, 'justify' => false];
                $line = $word;
            } else {
                $line = $testLine;
            }
        }
        if ($line !== '') $lines[] = ['text' => $line, 'justify' => false];
    }
    return $lines;
} 