<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Rapport Profit General</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #0f172a;
            margin: 0;
            padding: 0;
        }

        .header {
            border-bottom: 2px solid #1d4ed8;
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

        .kpi-table,
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .kpi-table td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            width: 50%;
        }

        .kpi-label {
            color: #64748b;
            font-size: 10px;
        }

        .kpi-value {
            font-size: 15px;
            font-weight: bold;
            margin-top: 4px;
        }

        .section-title {
            margin-top: 16px;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: bold;
            color: #1e293b;
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
        <h1 class="title">Rapport Profit General - {{ config('app.name', 'Save Me') }}</h1>
        <div class="meta">
            Periode: {{ $periodLabel }} ({{ $periodText }})<br>
            Genere le: {{ $generatedAt->format('d/m/Y H:i') }}
        </div>
    </div>

    <table class="kpi-table">
        <tr>
            <td>
                <div class="kpi-label">Revenu Total</div>
                <div class="kpi-value">{{ number_format((float) $data['totalRevenue'], 2) }} {{ $currency }}</div>
            </td>
            <td>
                <div class="kpi-label">Profit Save Me</div>
                <div class="kpi-value">{{ number_format((float) $data['totalSaveMeProfit'], 2) }} {{ $currency }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="kpi-label">Revenu Enseignes</div>
                <div class="kpi-value">{{ number_format((float) $data['totalEnseigneRevenue'], 2) }} {{ $currency }}</div>
            </td>
            <td>
                <div class="kpi-label">Commandes</div>
                <div class="kpi-value">{{ number_format((int) $data['totalOrders']) }}</div>
            </td>
        </tr>
    </table>

    <div class="section-title">Top Enseignes</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Enseigne</th>
                <th class="text-right">Commandes</th>
                <th class="text-right">Revenu Total</th>
                <th class="text-right">Profit Save Me</th>
                <th class="text-right">Revenu Enseigne</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data['profitByEnseigne'] as $item)
                <tr>
                    <td>{{ $item['enseigne']?->name ?? 'N/A' }}</td>
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
                    <td colspan="5">Aucune donnée</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
