<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Scheduled Report Ready</title>
</head>
<body style="font-family: Arial, sans-serif; color: #1e293b; line-height: 1.8;">
    <h2 style="margin-bottom: 10px;">Scheduled Report Ready</h2>

    <p>Your scheduled report has been generated successfully.</p>

    <p><strong>Report Name:</strong> {{ $reportName }}</p>
    <p><strong>Frequency:</strong> {{ ucfirst($frequency) }}</p>
    <p><strong>Generated At:</strong> {{ $generatedAt }}</p>

    <p>The report PDF is attached to this email.</p>

    <p>Regards,<br>VertexGrad System</p>
</body>
</html>