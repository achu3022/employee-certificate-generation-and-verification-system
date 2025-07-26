<?php
namespace App\Libraries;

class CustomTCPDF extends \TCPDF
{
    protected $logoPath;

    public function setLogoPath($path)
    {
        $this->logoPath = $path;
    }

    public function Header()
    {
        if ($this->logoPath && file_exists($this->logoPath)) {
            $pageWidth = $this->getPageWidth();
            $logoWidth = 50; // mm
            $logoX = ($pageWidth - $logoWidth) / 2;
            $logoY = 12; // mm from top
            $this->Image($this->logoPath, $logoX, $logoY, $logoWidth, 0, 'PNG');
            $this->Ln(40);
        }
    }
} 