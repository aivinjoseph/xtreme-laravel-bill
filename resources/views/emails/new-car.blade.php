<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Car Added to Inventory</title>
    <style>
        /* Reset some default styles */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f7f7f7;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            font-weight: bold;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 10px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>New Car Added to Inventory</h2>
        
        <p>Dear Valued Customer,</p>
        
        <p>We are excited to inform you that a new car has been added to our inventory. Below are some details:</p>
        
        <table>
            <tr>
                <th>Make</th>
                <td>{{ $car->make }}</td>
            </tr>
            <tr>
                <th>Model</th>
                <td>{{ $car->model }}</td>
            </tr>
            <tr>
                <th>Year</th>
                <td>{{ $car->year }}</td>
            </tr>
            <tr>
                <th>Price</th>
                <td>${{ $car->price }}</td>
            </tr>
            <!-- Add more attributes as needed -->
        </table>
        
        <p>
            For more details about this car, please visit: 
            <a href="{{ route('cars.show', ['car' => $car->slug]) }}">View Car Details</a>
        </p>
        
        <p>Thank you for subscribing to our updates!</p>
        
        <p class="footer">Best regards,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
