<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Rapport Profit par Enseigne</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #0f172a;
            margin: 0;
            padding: 0;
        }

        .header {
            border-bottom: 2px solid #0f766e;
            padding: 10px 0 12px;
            margin-bottom: 14px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 4px;
        }

        .meta {
            color: #334155;
            font-size: 10px;
        }

        .summary-table,
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .summary-table td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            width: 33%;
        }

        .summary-label {
            color: #64748b;
            font-size: 10px;
        }

        .summary-value {
            font-size: 15px;
            font-weight: bold;
            margin-top: 4px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #cbd5e1;
            padding: 6px;
            text-align: left;
        }

        .data-table th {
            background: #e2e8f0;
            font-size: 10px;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1 class="title">Rapport Profit par Enseigne - {{ config('app.name', 'Save Me') }}</h1>
        <div class="meta">
            Periode: {{ $periodLabel }} ({{ $periodText }})<br>
            Genere le: {{ $generatedAt->format('d/m/Y H:i') }}
        </div>
    </div>

    <table class="summary-table">
        <tr>
            <td>
                <div class="summary-label">Enseignes</div>
                <div class="summary-value">{{ number_format((int) ($totals['enseignes'] ?? 0)) }}</div>
            </td>
            <td>
                <div class="summary-label">Commandes</div>
                <div class="summary-value">{{ number_format((int) ($totals['orders'] ?? 0)) }}</div>
            </td>
            <td>
                <div class="summary-label">Profit Save Me</div>
                <div class="summary-value">{{ number_format((float) ($totals['save_me_profit'] ?? 0), 2) }}
                    {{ $currency }}</div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>Enseigne</th>
                <th>Code</th>
                <th class="text-right">Commandes</th>
                <th class="text-right">Revenu Total</th>
                <th class="text-right">Profit Save Me</th>
                <th class="text-right">Revenu Enseigne</th>
            </tr>
        </thead>
        <tbody>
            @forelse($enseigneStats as $item)
                <tr>
                    <td>{{ $item['enseigne']?->name ?? 'N/A' }}</td>
                    <td>{{ $item['enseigne']?->code ?? 'N/A' }}</td>
                    <td class="text-right">{{ number_format((int) ($item['orders'] ?? 0)) }}</td>
                    <td class="text-right">{{ number_format((float) ($item['total_revenue'] ?? 0), 2) }} {{ $currency }}
                    </td>
                    <td class="text-right">{{ number_format((float) ($item['save_me_profit'] ?? 0), 2) }} {{ $currency }}
                    </td>
                    <td class="text-right">{{ number_format((float) ($item['enseigne_revenue'] ?? 0), 2) }}
                        {{ $currency }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Aucune donnée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
