<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>GSI Pocket API</title>

    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, sans-serif;
            background: #0f172a;
            color: #e5e7eb;
        }

        .container {
            max-width: 900px;
            margin: auto;
            padding: 40px 20px;
        }

        h1 {
            margin-bottom: 5px;
        }

        h2 {
            margin-top: 40px;
            border-bottom: 1px solid #1f2937;
            padding-bottom: 8px;
        }

        .card {
            background: #111827;
            padding: 18px;
            border-radius: 6px;
            margin-top: 15px;
        }

        .endpoint {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .method {
            color: #22c55e;
            margin-right: 8px;
        }

        pre {
            background: #020617;
            padding: 12px;
            border-radius: 4px;
            overflow-x: auto;
            font-size: 14px;
        }

        .desc {
            color: #9ca3af;
            margin-bottom: 10px;
        }

        footer {
            text-align: center;
            margin-top: 50px;
            color: #6b7280;
            font-size: 14px;
        }

    </style>
</head>

<body>

    <div class="container">

        <h1>GSI Pocket API</h1>
        <p class="desc">Pocket management backend service</p>

        <h2>Authentication</h2>

        <div class="card">
            <div class="endpoint"><span class="method">POST</span>/api/auth/login</div>
            <pre>{
  "email": "example@mail.net",
  "password": "password"
}</pre>
        </div>

        <div class="card">
            <div class="endpoint"><span class="method">GET</span>/api/auth/profile</div>
            <pre>{
  "full_name": "User",
  "email": "example@mail.net"
}</pre>
        </div>

        <h2>Pocket</h2>

        <div class="card">
            <div class="endpoint"><span class="method">POST</span>/api/pockets</div>
            <pre>{
  "name": "Pocket 1",
  "initial_balance": 2000000
}</pre>
        </div>

        <div class="card">
            <div class="endpoint"><span class="method">GET</span>/api/pockets</div>
            <pre>[
  {
    "id": "uuid",
    "name": "Pocket 1",
    "current_balance": 2000000
  }
]</pre>
        </div>

        <div class="card">
            <div class="endpoint"><span class="method">GET</span>/api/pockets/total-balance</div>
            <pre>{
  "total": 300000
}</pre>
        </div>

        <h2>Income</h2>

        <div class="card">
            <div class="endpoint"><span class="method">POST</span>/api/incomes</div>
            <pre>{
  "pocket_id": "uuid",
  "amount": 300000,
  "notes": "Income note"
}</pre>
        </div>

        <h2>Expense</h2>

        <div class="card">
            <div class="endpoint"><span class="method">POST</span>/api/expenses</div>
            <pre>{
  "pocket_id": "uuid",
  "amount": 200000,
  "notes": "Expense note"
}</pre>
        </div>

        <h2>Report</h2>

        <div class="card">
            <div class="endpoint"><span class="method">POST</span>/api/pockets/{id}/create-report</div>
            <pre>{
  "type": "INCOME",
  "date": "2026-01-01"
}</pre>
        </div>

        <div class="card">
            <div class="endpoint"><span class="method">GET</span>/reports/{file}</div>
            <p class="desc">Download generated excel report</p>
        </div>

        <footer>
            GSI Pocket API • Laravel 12
        </footer>

    </div>

</body>

</html>