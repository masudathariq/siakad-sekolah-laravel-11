<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Surat {{ $surat->nomor_surat }}</title>
    <style>
        body, html { margin:0; height:100%; }
        iframe { width:100%; height:100%; border:none; }
    </style>
</head>
<body>
    <iframe src="data:application/pdf;base64,{{ $pdfBase64 }}"></iframe>
</body>
</html>
