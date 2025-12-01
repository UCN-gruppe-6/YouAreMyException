<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="utf-8">
    <title>Driftsstatus</title>

    <style>
        body {
            margin: 0;
            background: #f7f3ee; /* lys beige baggrund */
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .page-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 40px;
        }

        .page-title {
            font-size: 34px;
            font-weight: 800;
            letter-spacing: 0.05em;
            color: #05324d; /* mørk blå */
            margin: 32px 0 24px;
        }

        .status-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .status-row {
            background: #ffffff;
            border-radius: 8px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            box-shadow: 0 0 0 1px #ece7df;
        }

        .carrier-logo {
            width: 64px;
            height: 64px;
            border-radius: 6px;
            background: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 24px;
            font-weight: 700;
            color: #444;
            font-size: 18px;
        }

        .carrier-name {
            font-weight: 800;
            color: #05324d;
            width: 180px; /* fast bredde så kolonnerne står pænt */
        }

        .status-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 110px;
            font-size: 14px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
        }

        .status-dot--up {
            background: #1cc461; /* grøn */
        }

        .status-dot--down {
            background: #f04438; /* rød */
        }

        .status-label {
            color: #444;
        }

        .message {
            flex: 1;                /* fylder alt det midterste */
            margin: 0 24px;
        }

        .message-box {
            background: #f3f7fb;
            border-radius: 999px;
            padding: 10px 16px;
            font-size: 14px;
            color: #364152;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .message-icon {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 1px solid #c0cedd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            color: #7b90a8;
        }

        .toggle-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid #c0cedd;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #7b90a8;
            cursor: pointer;
        }

        /* "ekstra info" under hver række (skjult som default) */
        .details {
            display: none;
            padding: 0 24px 12px 112px; /* indryk så det flugter med firmanavn */
            font-size: 14px;
            color: #555;
        }

        .status-row.expanded + .details {
            display: block;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.toggle-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const row = btn.closest('.status-row');
                    row.classList.toggle('expanded');
                    btn.textContent = row.classList.contains('expanded') ? '−' : '+';
                });
            });
        });
    </script>
</head>
<body>
<div class="page-wrapper">
    {{-- Logo / topbar kan vi lave senere – nu kun selve tabellen --}}
    <h1 class="page-title">DRIFTSSTATUS</h1>

    <div class="status-list">
        @foreach($carriers as $carrier)
            <div class="status-row">
                <div class="carrier-logo">
                    {{-- Placeholder for logo – bare første bogstav lige nu --}}
                    {{ substr($carrier['name'], 0, 1) }}
                </div>

                <div class="carrier-name">
                    {{ $carrier['name'] }}
                </div>

                <div class="status-pill">
                    <span class="status-dot {{ $carrier['has_issue'] ? 'status-dot--down' : 'status-dot--up' }}"></span>
                    <span class="status-label">Status</span>
                </div>

                <div class="message">
                    @if($carrier['has_issue'])
                        <div class="message-box">
                            <span class="message-icon">i</span>
                            <span>{{ $carrier['message'] }}</span>
                        </div>
                    @else
                        <div class="message-box" style="opacity: 0.7;">
                            <span class="message-icon">i</span>
                            <span>Ingen kendte problemer</span>
                        </div>
                    @endif
                </div>

                <button type="button" class="toggle-btn">+</button>
            </div>

            <div class="details">
                {{-- Placeholder-tekst – her kan API-data komme senere --}}
                Her kan der senere komme ekstra information for <strong>{{ $carrier['name'] }}</strong>
                (f.eks. mere detaljeret fejlbeskrivelse).
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
