<?php

namespace App\Services;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Data\QRMatrix;

class QrWithLogoService
{
    protected const LOGO_PATH = 'img/logo-1.png';

    protected const LOGO_SCALE_DIVISOR = 4;

    public function generate(string $data): array
    {
        $qrOptions = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_H,
            'addQuietzone' => true,
            'quietzoneSize' => 1,
            'scale' => 12,
            'imageBase64' => false,
        ]);

        $qrPng = (new QRCode($qrOptions))->render($data);

        if (function_exists('imagecreatefromstring') && file_exists(public_path(self::LOGO_PATH))) {
            $QR = imagecreatefromstring($qrPng);

            if ($QR === false) {
                return $this->fallbackSvg($data);
            }

            $logoImage = imagecreatefrompng(public_path(self::LOGO_PATH));

            if ($logoImage !== false) {
                $QR_width = imagesx($QR);
                $QR_height = imagesy($QR);
                $logo_width = imagesx($logoImage);
                $logo_height = imagesy($logoImage);

                $logo_qr_width = (int) round($QR_width / self::LOGO_SCALE_DIVISOR);
                $scale = $logo_width / $logo_qr_width;
                $logo_qr_height = (int) round($logo_height / $scale);

                $center_x = (int) round(($QR_width - $logo_qr_width) / 2);
                $center_y = (int) round(($QR_height - $logo_qr_height) / 2);

                imagecopyresampled(
                    $QR, $logoImage,
                    $center_x, $center_y,
                    0, 0,
                    $logo_qr_width, $logo_qr_height,
                    $logo_width, $logo_height
                );

                imagedestroy($logoImage);
            }

            ob_start();
            imagepng($QR);
            $imageData = ob_get_contents();
            ob_end_clean();
            imagedestroy($QR);

            return [
                'type' => 'png',
                'data' => 'data:image/png;base64,' . base64_encode($imageData),
            ];
        }

        return $this->fallbackSvg($data);
    }

    protected function fallbackSvg(string $data): array
    {
        $qrOptions = new QROptions([
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel' => QRCode::ECC_H,
            'addQuietzone' => true,
            'quietzoneSize' => 1,
            'drawLightModules' => false,
            'outputBase64' => false,
            'svgAddXmlHeader' => false,
            'moduleValues' => [
                QRMatrix::M_DARKMODULE => '#1e293b',
                QRMatrix::M_DATA_DARK => '#1e293b',
                QRMatrix::M_FINDER_DARK => '#1e293b',
                QRMatrix::M_SEPARATOR_DARK => '#1e293b',
                QRMatrix::M_ALIGNMENT_DARK => '#1e293b',
                QRMatrix::M_TIMING_DARK => '#1e293b',
                QRMatrix::M_FORMAT_DARK => '#1e293b',
                QRMatrix::M_VERSION_DARK => '#1e293b',
                QRMatrix::M_QUIETZONE_DARK => '#1e293b',
                QRMatrix::M_LOGO_DARK => '#1e293b',
                QRMatrix::M_FINDER_DOT => '#1e293b',
            ],
        ]);

        $svg = (new QRCode($qrOptions))->render($data);

        return [
            'type' => 'svg',
            'data' => 'data:image/svg+xml;base64,' . base64_encode($svg),
        ];
    }
}
