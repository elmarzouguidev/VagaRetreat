<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Rapport Commandes</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #1e293b;
        }

        h1 {
            margin: 0 0 8px 0;
            font-size: 20px;
        }

        .meta {
            margin-bottom: 12px;
        }

        .meta p {
            margin: 2px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #cbd5e1;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f1f5f9;
            font-weight: bold;
        }

        .right {
            text-align: right;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .logo {
            height: 44px;
        }

        .footer {
            margin-top: 14px;
            border-top: 1px solid #cbd5e1;
            padding-top: 8px;
            font-size: 10px;
            color: #475569;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Rapport des Commandes</h1>
    </div>
    <div class="meta">
        <p><strong>Genere le:</strong> {{ $generatedAt->format('d/m/Y H:i') }}</p>
        <p><strong>Total commandes:</strong> {{ $orders->count() }}</p>
        @if (!empty($filters['search']))
            <p><strong>Recherche:</strong> {{ $filters['search'] }}</p>
        @endif
        @if (!empty($filters['status']))
            <p><strong>Statut:</strong> {{ $filters['status'] }}</p>
        @endif
        @if (!empty($filters['enseigne']))
            <p><strong>Enseigne:</strong> {{ $filters['enseigne'] }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Commande</th>
                <th>Client</th>
                <th>Enseigne</th>
                <th>Panier</th>
                <th>Quantite</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->command_number }}</td>
                    <td>{{ $order->user?->full_name ?? 'N/A' }}</td>
                    <td>{{ $order->panier?->enseigne?->name ?? 'N/A' }}</td>
                    <td>{{ $order->panier?->name ?? 'N/A' }}</td>
                    <td class="right">{{ $order->quantity }}</td>
                    <td class="right">{{ number_format((float) $order->price, 2) }} {{ $currency }}</td>
                    <td>{{ $order->status?->label() ?? 'N/A' }}</td>
                    <td>{{ $order->created_at?->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Aucune commande trouvee.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <strong>Save Me</strong> |
        Website: www.saveme.ma |
        Email: {{ generalSettings()->contact_email }}
    </div>
</body>

</html>
