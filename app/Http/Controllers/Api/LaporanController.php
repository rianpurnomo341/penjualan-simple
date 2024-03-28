<?php

namespace App\Http\Controllers\Api;


use Dompdf\Dompdf;
use TCPDF;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        try {
            $Laporan = Laporan::with('pembelian', 'penjualan');

            if ($request->bulan) {
                $Laporan = $Laporan
                    ->whereMonth('created_at', $request->bulan)
                    ->get();
            } else if ($request->tahun) {
                $Laporan = $Laporan
                    ->whereYear('created_at', $request->tahun)
                    ->get();
            } else if ($request->tahun && $request->bulan) {
                $Laporan = $Laporan
                    ->whereYear('created_at', $request->tahun)
                    ->whereMonth('created_at', $request->bulan)
                    ->get();
            } else {
                $Laporan = $Laporan->get();
            }

            return new ApiResource(true, 'Berhasil Menampilkan Data', $Laporan);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function generateBuyButtonImage($stuffBought, $marketName, $slogan, $transactionDate, $totalAllPrice, $width = 400, $font = 'Poppins-Medium.ttf', $textSize = 20, $buttonColor = [0, 0, 255], $fontColor = [255, 255, 255])
    {
        // Calculate height based on the number of lines of text
        $numItems = count($stuffBought);
        $lineHeight = $textSize * 1.5; // Adjust line height as needed
        $numLines = 0; // Initialize to zero
        foreach ($stuffBought as $item) {
            $numLines += count(get_object_vars($item)) + 2; // Count the properties plus two for the item name and the row separator
        }
        $numLines += 6; // Add six lines for the header information: market name, slogan, date, the separating line, table headers, and the totalAllPrice
        $height = $numLines * $lineHeight;

        // Create a blank image with specified width and calculated height
        $image = imagecreatetruecolor($width, $height);

        // Allocate colors
        $backgroundColor = imagecolorallocate($image, 255, 255, 255); // white background
        $buttonColor = imagecolorallocate($image, $buttonColor[0], $buttonColor[1], $buttonColor[2]); // blue button
        $fontColor = imagecolorallocate($image, $fontColor[0], $fontColor[1], $fontColor[2]); // white text

        // Fill the background with white
        imagefilledrectangle($image, 0, 0, $width, $height, $backgroundColor);

        // Draw the button
        imagefilledrectangle($image, 0, 0, $width, $height, $buttonColor);

        // Set the font path
        $fontPath = resource_path('fonts/' . $font);

        // Initialize text position variables
        $textX = 20;
        $textY = 20;

        // Add text - Market Name
        imagettftext($image, $textSize, 0, $textX, $textY, $fontColor, $fontPath, 'Market: ' . $marketName);
        $textY += $lineHeight;

        // Add text - Slogan
        imagettftext($image, $textSize, 0, $textX, $textY, $fontColor, $fontPath, 'Slogan: ' . $slogan);
        $textY += $lineHeight;

        // Add text - Transaction Date
        imagettftext($image, $textSize, 0, $textX, $textY, $fontColor, $fontPath, 'Date: ' . $transactionDate);
        $textY += $lineHeight;

        // Add a horizontal line to separate the header and the stuff bought
        imageline($image, 0, $textY + ($lineHeight / 2), $width, $textY + ($lineHeight / 2), $fontColor);
        $textY += $lineHeight;

        // Add text - Table Headers
        imagettftext($image, $textSize, 0, $textX, $textY, $fontColor, $fontPath, 'Item');
        imagettftext($image, $textSize, 0, $textX + 100, $textY, $fontColor, $fontPath, 'Qty');
        imagettftext($image, $textSize, 0, $textX + 200, $textY, $fontColor, $fontPath, 'Price');
        imagettftext($image, $textSize, 0, $textX + 300, $textY, $fontColor, $fontPath, 'Disc');
        imagettftext($image, $textSize, 0, $textX + 400, $textY, $fontColor, $fontPath, 'Total Price');
        $textY += $lineHeight;

        // Add a horizontal line to separate the header and the table content
        imageline($image, 0, $textY + ($lineHeight / 2), $width, $textY + ($lineHeight / 2), $fontColor);
        $textY += $lineHeight;

        // Add text - Items
        foreach ($stuffBought as $item) {
            // Display item details in table format
            imagettftext($image, $textSize, 0, $textX, $textY, $fontColor, $fontPath, $item->name);
            imagettftext($image, $textSize, 0, $textX + 100, $textY, $fontColor, $fontPath, $item->qty);
            imagettftext($image, $textSize, 0, $textX + 200, $textY, $fontColor, $fontPath, $item->price);
            imagettftext($image, $textSize, 0, $textX + 300, $textY, $fontColor, $fontPath, $item->disc);
            imagettftext($image, $textSize, 0, $textX + 400, $textY, $fontColor, $fontPath, $item->totalPrice);
            $textY += $lineHeight;
        }

        // Add text - Total All Price
        imagettftext($image, $textSize, 0, $textX, $textY, $fontColor, $fontPath, 'Total All Price: ' . $totalAllPrice);

        // Set the content type header so that the browser knows it's an image
        header('Content-Type: image/png');

        // Output the image
        imagepng($image);

        // Free up memory
        imagedestroy($image);
    }


    function generatePdfFromHtml($htmlContent, $outputFilename)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($htmlContent);

        // Set paper size to A3 (which is larger than B3)
        $dompdf->setPaper('A3');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to a file
        $outputFilePath = $outputFilename; // Use the desired file path within the storage directory

        // Save the PDF file to Laravel's storage
        $pdfContent = $dompdf->output(['compress' => 0, 'output_type' => 'S']);
        Storage::put($outputFilePath, $pdfContent);

        // If you need to return the file path for further use, you can return it like this:
        return Storage::url($outputFilePath);
    }


    public function generateImage(Request $request)
    {
        try {
            $stuffBought = [
                (object) ['name' => 'Laptop', 'qty' => 2, 'price' => '$1000', 'disc' => '$200', 'totalPrice' => '$1800'],
                (object) ['name' => 'Mouse', 'qty' => 1, 'price' => '$20', 'disc' => '$0', 'totalPrice' => '$20'],
            ];
            $this->generateBuyButtonImage($stuffBought, 'Toko Muliya', 'Melayani Dengan Sepenuh Hati', '2024-03-29', '$1820', 400);
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }
    public function generatePdf(Request $request)
    {
        try {// Example usage:
            $stuffBought = [
                (object) ['name' => 'Laptop', 'qty' => 2, 'price' => '$1000', 'disc' => '$200', 'totalPrice' => '$1800'],
                (object) ['name' => 'Mouse', 'qty' => 1, 'price' => '$20', 'disc' => '$0', 'totalPrice' => '$20'],
            ];

            // Generate HTML content (same as previous example)
            $htmlContent = '<style>';
            $htmlContent .= 'table { border-collapse: collapse; width: 100%; }';
            $htmlContent .= 'th, td { border: 2px solid black; padding: 8px; text-align: left; }';
            $htmlContent .= 'th { background-color: #f2f2f2; }';
            $htmlContent .= 'footer { position: fixed; bottom: 0; left: 0; width: 100%; background-color: #f2f2f2; padding: 10px; }';
            $htmlContent .= '</style>';
            $htmlContent .= '<h1>Toko Muliya</h1>';
            $htmlContent .= '<p>Your Slogan</p>';
            $htmlContent .= '<p>Date: 2024-03-29</p>';
            $htmlContent .= '<table>';
            $htmlContent .= '<tr><th>Item</th><th>Qty</th><th>Price</th><th>Disc</th><th>Total Price</th></tr>';
            foreach ($stuffBought as $item) {
                $htmlContent .= '<tr>';
                $htmlContent .= '<td>' . $item->name . '</td>';
                $htmlContent .= '<td>' . $item->qty . '</td>';
                $htmlContent .= '<td>' . $item->price . '</td>';
                $htmlContent .= '<td>' . $item->disc . '</td>';
                $htmlContent .= '<td>' . $item->totalPrice . '</td>';
                $htmlContent .= '</tr>';
            }
            $htmlContent .= '</table>';
            $htmlContent .= '<p>Total All Price: $1820</p>';

            // Add footer with greetings and NB note
            $htmlContent .= '<footer>';
            $htmlContent .= '<p>Greetings from Toko Muliya!</p>';
            $htmlContent .= '<p>NB: This is an important note.</p>';
            $htmlContent .= '</footer>';

            // Generate PDF
            $this->generatePdfFromHtml($htmlContent, 'output.pdf');
        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

    public function generatePdfB3(Request $request)
    {
        $stuffBought = [
            (object) ['name' => 'Laptop', 'qty' => 2, 'price' => '$1000', 'disc' => '$200', 'totalPrice' => '$1800'],
            (object) ['name' => 'Mouse', 'qty' => 1, 'price' => '$20', 'disc' => '$0', 'totalPrice' => '$20'],
        ];

        // Generate HTML content (same as previous example)
        $htmlContent = '<style>';
        $htmlContent .= 'table { border-collapse: collapse; width: 100%; }';
        $htmlContent .= 'th, td { border: 2px solid black; padding: 8px; text-align: left; }';
        $htmlContent .= 'th { background-color: #f2f2f2; }';
        $htmlContent .= 'footer { position: fixed; bottom: 0; left: 0; width: 100%; background-color: #f2f2f2; padding: 10px; }';
        $htmlContent .= '</style>';
        $htmlContent .= '<h1>Toko Muliya</h1>';
        $htmlContent .= '<p>Your Slogan</p>';
        $htmlContent .= '<p>Date: 2024-03-29</p>';
        $htmlContent .= '<table>';
        $htmlContent .= '<tr><th><b>Item</b></th><th><b>Qty</b></th><th><b>Price</b></th><th><b>Disc</b></th><th><b>Total Price</b></th></tr>';
        foreach ($stuffBought as $item) {
            $htmlContent .= '<tr>';
            $htmlContent .= '<td>' . $item->name . '</td>';
            $htmlContent .= '<td>' . $item->qty . '</td>';
            $htmlContent .= '<td>' . $item->price . '</td>';
            $htmlContent .= '<td>' . $item->disc . '</td>';
            $htmlContent .= '<td>' . $item->totalPrice . '</td>';
            $htmlContent .= '</tr>';
        }
        $htmlContent .= '</table>';
        $htmlContent .= '<p>Total All Price: $1820</p>';

        // Add footer with greetings and NB note
        $htmlContent .= '<footer>';
        $htmlContent .= '<p>Greetings from Toko Muliya!</p>';
        $htmlContent .= '<p>NB: This is an important note.</p>';
        $htmlContent .= '</footer>';

        // Specify the file path where the PDF will be saved locally
        $outputFilename = 'output.pdf';

        // Generate PDF
        $this->generatePdfB3Proccess($htmlContent, $outputFilename);
    }

    function generatePdfB3Proccess($htmlContent, $outputFilename)
    {
        // Create new TCPDF instance
        $pdf = new MyPDF('P', 'mm', 'B3', true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Your Title');
        $pdf->SetSubject('Your Subject');
        $pdf->SetKeywords('Keywords');
        $pdf->SetFont('helvetica', '', 12);
        // Set default header data
        $pdf->SetHeaderData('', 0, 'Your Header', 'Your Description');

        // Set margins
        $pdf->SetMargins(10, 20, 10);
        $pdf->SetHeaderMargin(0); // Adjust the header margin to create space

        $pdf->setCellPaddings(3, 1, 1, 1);
        // Add a page
        $pdf->AddPage();

        // Set content
        $pdf->writeHTML($htmlContent, true, false, true, false, '');

        // Set footer
        // $pdf->Footer();

        // Output the PDF to a local file
        $outputFilePath = __DIR__ . '/' . $outputFilename;
        $pdf->Output($outputFilePath, 'F');
    }

    public function getAllLaporan(Request $request)
    {
        try {
            $limit = max(1, intval($request->limit));
            $pageNumber = max(0, intval($request->pageNumber));

            $offset = $pageNumber * $limit;

            // Fetch total data count
            $totalDataCount = Laporan::count();

            // Calculate total number of pages
            $totalPages = ceil($totalDataCount / $limit);

            $dataLaporan = Laporan::with('pembelian', 'penjualan')
                ->orderBy('created_at', 'asc')
                ->skip($offset)
                ->take($limit)
                ->get();

            $startIndex = $offset + 1;
            $endIndex = min($offset + $limit, $totalDataCount);

            // Prepare response data including page information
            $responseData = [];
            if ($dataLaporan && $dataLaporan->isNotEmpty()) {
                $responseData = [
                    'totalDataCount' => $totalDataCount,
                    'totalPages' => $totalPages,
                    'startIndex' => $startIndex,
                    'endIndex' => $endIndex,
                    'data' => $dataLaporan,
                ];
            } else {
                $responseData = [
                    'totalDataCount' => 0,
                    'totalPages' => 0,
                    'startIndex' => 0,
                    'endIndex' => 0,
                    'data' => $dataLaporan,
                ];
            }

            // Return the response
            return $responseData;

        } catch (QueryException $e) {
            return new ApiResource(false, $e->getMessage(), []);
        }
    }

}

class MyPDF extends TCPDF
{
    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 12);
        // Page number
        $this->Cell(0, 10, 'terimakasih telah berbelanja di toko kami, barang yang telah dibeli tidak dapat dikembalikan atau ditukar kembali', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
