@extends('layouts.app')

@section('title', 'Detalle de auditoría')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap');

    .audit-app {
        --ink: #0f172a;
        --ink-2: #475569;
        --ink-3: #94a3b8;
        --surface: #ffffff;
        --surface-2: #f8fafc;
        --surface-3: #f1f5f9;
        --border: #e2e8f0;
        --primary: #4338ca;
        --primary-2: #6366f1;
        --primary-soft: #eef2ff;
        --accent: #0d9488;
        --accent-soft: #ccfbf1;
        --radius: 14px;
        --radius-sm: 9px;
        --shadow-sm: 0 1px 2px rgba(15, 23, 42, .05);
        --shadow-md: 0 8px 24px rgba(15, 23, 42, .07);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        color: var(--ink);
    }

    .audit-app .mono {
        font-family: 'JetBrains Mono', ui-monospace, monospace;
    }

    .audit-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: .8rem;
        color: var(--ink-3);
        margin-bottom: 14px;
    }

    .audit-breadcrumb a {
        color: var(--ink-2);
        text-decoration: none;
        font-weight: 600;
    }

    .audit-breadcrumb a:hover {
        color: var(--primary);
    }

    .audit-detail-header {
        position: relative;
        background: linear-gradient(120deg, #1e1b4b 0%, #312e81 45%, #4338ca 100%);
        color: #fff;
        border-radius: var(--radius);
        padding: 26px 28px;
        margin-bottom: 22px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .audit-detail-header::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 1.5px 1.5px, rgba(255, 255, 255, .14) 1.5px, transparent 0);
        background-size: 22px 22px;
        opacity: .5;
        pointer-events: none;
    }

    .audit-detail-header-inner {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
    }

    .audit-detail-header h1 {
        margin: 0;
        font-size: 1.4rem;
        font-weight: 800;
        letter-spacing: -.01em;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .audit-detail-header p {
        margin: 6px 0 0;
        color: #c7d2fe;
        font-size: .88rem;
    }

    .btn-back-audit {
        border-radius: var(--radius-sm);
        font-weight: 600;
        background: rgba(255, 255, 255, .12);
        border: 1px solid rgba(255, 255, 255, .25);
        color: #fff;
    }

    .btn-back-audit:hover {
        background: rgba(255, 255, 255, .22);
        color: #fff;
    }

    .audit-detail-card {
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        background: var(--surface);
    }

    .audit-section {
        padding: 24px 26px;
        border-bottom: 1px solid var(--surface-3);
    }

    .audit-section:last-child {
        border-bottom: 0;
    }

    .audit-section-title {
        font-size: .82rem;
        font-weight: 800;
        color: var(--ink);
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .audit-section-title i {
        color: var(--primary);
    }

    .audit-field {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 13px 15px;
        height: 100%;
    }

    .audit-field-label {
        display: block;
        font-size: .7rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        font-weight: 700;
        color: var(--ink-3);
        margin-bottom: 5px;
    }

    .audit-field-value {
        color: var(--ink);
        font-size: .9rem;
        font-weight: 600;
        word-break: break-word;
    }

    .audit-user-detail {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .audit-user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 11px;
        background: var(--primary-soft);
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }

    .audit-action-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 20px;
        padding: 6px 13px 6px 10px;
        font-size: .76rem;
        font-weight: 700;
    }

    .audit-action-detail .dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .action-create {
        background: #ecfdf5;
        color: #047857;
    }

    .action-create .dot {
        background: #10b981;
    }

    .action-update {
        background: #fffbeb;
        color: #b45309;
    }

    .action-update .dot {
        background: #f59e0b;
    }

    .action-delete {
        background: #fef2f2;
        color: #b91c1c;
    }

    .action-delete .dot {
        background: #ef4444;
    }

    .action-default {
        background: var(--surface-3);
        color: var(--ink-2);
    }

    .action-default .dot {
        background: var(--ink-3);
    }

    .audit-description {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 16px;
        color: var(--ink-2);
        line-height: 1.6;
        font-size: .92rem;
    }

    /* DIFF VIEWER */
    .diff-toolbar {
        display: flex;
        justify-content: flex-end;
        gap: 6px;
        margin-bottom: 12px;
    }

    .diff-toggle-btn {
        border: 1px solid var(--border);
        background: #fff;
        color: var(--ink-2);
        border-radius: 7px;
        padding: 5px 12px;
        font-size: .76rem;
        font-weight: 600;
        cursor: pointer;
    }

    .diff-toggle-btn.is-active {
        background: var(--ink);
        color: #fff;
        border-color: var(--ink);
    }

    #diffWrapper[data-view="unified"] .diff-col-before,
    #diffWrapper[data-view="unified"] .diff-col-after {}

    #diffWrapper[data-view="side"] .row {
        flex-wrap: nowrap;
    }

    .audit-code-title {
        font-size: .78rem;
        font-weight: 700;
        color: var(--ink-2);
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .audit-copy-json {
        border: none;
        background: transparent;
        color: var(--ink-3);
        cursor: pointer;
        font-size: .72rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .audit-copy-json:hover {
        color: var(--primary);
    }

    .audit-code-box {
        background: #0f172a;
        color: #e2e8f0;
        border-radius: var(--radius-sm);
        padding: 16px 18px;
        margin: 0;
        max-height: 420px;
        overflow: auto;
        font-family: 'JetBrains Mono', monospace;
        font-size: .78rem;
        line-height: 1.7;
    }

    .diff-line {
        white-space: pre-wrap;
        word-break: break-word;
        padding: 1px 6px;
        border-radius: 4px;
    }

    .diff-key {
        color: #93c5fd;
    }

    .diff-val {
        color: #e2e8f0;
    }

    .diff-changed {
        background: rgba(244, 63, 94, .16);
    }

    .diff-col-after .diff-changed {
        background: rgba(16, 185, 129, .16);
    }

    .audit-browser {
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 14px 16px;
        color: var(--ink-2);
        font-size: .84rem;
        word-break: break-word;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .audit-ip-detail {
        font-family: 'JetBrains Mono', monospace;
        background: var(--surface-3);
        border-radius: 7px;
        padding: 5px 9px;
        color: var(--ink);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .audit-copy-inline {
        border: none;
        background: transparent;
        color: var(--ink-3);
        cursor: pointer;
        padding: 0;
        font-size: .8rem;
    }

    .audit-copy-inline:hover {
        color: var(--primary);
    }
</style>

<div class="audit-app container-fluid">

    @php
    $nombreUsuario = $auditoria->usuario->name ?? $auditoria->usuario->username ?? 'Sistema';
    $inicial = strtoupper(substr($nombreUsuario, 0, 1));
    $badge = match($auditoria->accion) {
    'CREAR' => 'action-create',
    'MODIFICAR' => 'action-update',
    'ANULAR', 'ELIMINAR' => 'action-delete',
    default => 'action-default'
    };
    @endphp

    <div class="audit-breadcrumb">
        <a href="{{ route('auditorias.index') }}">Auditoría</a>
        <i class="bi bi-chevron-right" style="font-size:.65rem;"></i>
        <span>Registro #{{ $auditoria->id ?? $auditoria->registro_id }}</span>
    </div>

    {{-- ENCABEZADO --}}
    <div class="audit-detail-header">
        <div class="audit-detail-header-inner">
            <div>
                <h1><i class="bi bi-shield-check"></i> Detalle de auditoría</h1>
                <p>Información completa de la actividad registrada.</p>
            </div>
            <a href="{{ route('auditorias.index') }}" class="btn btn-back-audit">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    {{-- INFORMACIÓN PRINCIPAL --}}
    <div class="card audit-detail-card">

        <div class="audit-section">
            <div class="audit-section-title"><i class="bi bi-info-circle"></i> Información de la actividad</div>

            <div class="row g-3">

                <div class="col-lg-4 col-md-6">
                    <div class="audit-field">
                        <span class="audit-field-label">Usuario</span>
                        <div class="audit-user-detail">
                            <div class="audit-user-avatar">{{ $inicial }}</div>
                            <div class="audit-field-value">{{ $nombreUsuario }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="audit-field">
                        <span class="audit-field-label">Acción</span>
                        <div>
                            <span class="audit-action-detail {{ $badge }}">
                                <span class="dot"></span>{{ $auditoria->accion }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="audit-field">
                        <span class="audit-field-label">Módulo</span>
                        <div class="audit-field-value">{{ strtoupper($auditoria->tabla ?? '-') }}</div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="audit-field">
                        <span class="audit-field-label">Registro</span>
                        <div class="audit-field-value mono">#{{ $auditoria->registro_id ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="audit-field">
                        <span class="audit-field-label">Fecha y hora</span>
                        <div class="audit-field-value mono">{{ $auditoria->created_at?->format('d/m/Y H:i:s') ?? '-' }}</div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="audit-field">
                        <span class="audit-field-label">Dirección IP</span>
                        <div>
                            <span class="audit-ip-detail">
                                {{ $auditoria->ip ?? '-' }}
                                @if($auditoria->ip)
                                <button type="button" class="audit-copy-inline" data-copy="{{ $auditoria->ip }}" title="Copiar IP">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- DESCRIPCIÓN --}}
        <div class="audit-section">
            <div class="audit-section-title"><i class="bi bi-card-text"></i> Descripción de la actividad</div>
            <div class="audit-description">{{ $auditoria->descripcion ?? 'Sin descripción registrada.' }}</div>
        </div>

        {{-- DATOS ANTERIORES Y NUEVOS --}}
        @if($auditoria->datos_anteriores || $auditoria->datos_nuevos)

        <div class="audit-section">
            <div class="audit-section-title"><i class="bi bi-database"></i> Cambios realizados</div>

            <div class="diff-toolbar">
                <button type="button" class="diff-toggle-btn is-active" data-diff-view="side">Lado a lado</button>
                <button type="button" class="diff-toggle-btn" data-diff-view="unified">Solo cambios</button>
            </div>

            <div id="diffWrapper" data-view="side">
                <div class="row g-4">

                    @if($auditoria->datos_anteriores)
                    <div class="col-lg-6 diff-col-before">
                        <div class="audit-code-title">
                            <span><i class="bi bi-arrow-left-circle me-1"></i> Datos anteriores</span>
                            <button type="button" class="audit-copy-json" data-copy-target="jsonBeforeData">
                                <i class="bi bi-clipboard"></i> Copiar
                            </button>
                        </div>
                        <pre class="audit-code-box" id="jsonBefore">{{ json_encode($auditoria->datos_anteriores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                    @endif

                    @if($auditoria->datos_nuevos)
                    <div class="col-lg-6 diff-col-after">
                        <div class="audit-code-title">
                            <span><i class="bi bi-arrow-right-circle me-1"></i> Datos nuevos</span>
                            <button type="button" class="audit-copy-json" data-copy-target="jsonAfterData">
                                <i class="bi bi-clipboard"></i> Copiar
                            </button>
                        </div>
                        <pre class="audit-code-box" id="jsonAfter">{{ json_encode($auditoria->datos_nuevos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    </div>
                    @endif

                </div>
            </div>

            <script type="application/json" id="jsonBeforeData">
                {
                    !!json_encode($auditoria - > datos_anteriores ?? []) !!
                }
            </script>
            <script type="application/json" id="jsonAfterData">
                {
                    !!json_encode($auditoria - > datos_nuevos ?? []) !!
                }
            </script>

        </div>

        @endif

        {{-- NAVEGADOR --}}
        <div class="audit-section">
            <div class="audit-section-title"><i class="bi bi-laptop"></i> Información técnica</div>
            <div class="audit-field" style="background:transparent; border:none; padding:0;">
                <span class="audit-field-label">Navegador / dispositivo</span>
                <div class="audit-browser">
                    <span>{{ $auditoria->user_agent ?? '-' }}</span>
                    @if($auditoria->user_agent)
                    <button type="button" class="audit-copy-inline" data-copy="{{ $auditoria->user_agent }}" title="Copiar">
                        <i class="bi bi-clipboard"></i>
                    </button>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    (function() {
        // Copiar al portapapeles (IP, user agent)
        document.querySelectorAll('[data-copy]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var icon = this.querySelector('i');
                navigator.clipboard.writeText(this.dataset.copy).then(function() {
                    icon.className = 'bi bi-check2';
                    setTimeout(function() {
                        icon.className = 'bi bi-clipboard';
                    }, 1300);
                });
            });
        });

        // Copiar bloques JSON completos
        document.querySelectorAll('[data-copy-target]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var el = document.getElementById(this.dataset.copyTarget);
                if (!el) return;
                navigator.clipboard.writeText(el.textContent).then(function() {
                    var original = btn.innerHTML;
                    btn.innerHTML = '<i class="bi bi-check2"></i> Copiado';
                    setTimeout(function() {
                        btn.innerHTML = original;
                    }, 1300);
                });
            });
        });

        // Resaltado de diferencias entre datos anteriores y nuevos
        var beforeEl = document.getElementById('jsonBefore');
        var afterEl = document.getElementById('jsonAfter');
        var beforeData = document.getElementById('jsonBeforeData');
        var afterData = document.getElementById('jsonAfterData');

        if (beforeEl && afterEl && beforeData && afterData) {
            try {
                var before = JSON.parse(beforeData.textContent || '{}') || {};
                var after = JSON.parse(afterData.textContent || '{}') || {};
                var keys = Array.from(new Set(Object.keys(before).concat(Object.keys(after))));

                var beforeHtml = '';
                var afterHtml = '';

                keys.forEach(function(key) {
                    var b = before[key];
                    var a = after[key];
                    var changed = JSON.stringify(b) !== JSON.stringify(a);
                    var cls = 'diff-line' + (changed ? ' diff-changed' : '');
                    beforeHtml += '<div class="' + cls + '"><span class="diff-key">"' + key + '":</span> <span class="diff-val">' + JSON.stringify(b, null, 0) + '</span></div>';
                    afterHtml += '<div class="' + cls + '"><span class="diff-key">"' + key + '":</span> <span class="diff-val">' + JSON.stringify(a, null, 0) + '</span></div>';
                });

                beforeEl.innerHTML = beforeHtml || beforeEl.textContent;
                afterEl.innerHTML = afterHtml || afterEl.textContent;

                window.__auditChangedKeys = keys.filter(function(key) {
                    return JSON.stringify(before[key]) !== JSON.stringify(after[key]);
                });
            } catch (e) {
                // Si el JSON no se puede parsear, se conserva el formato original.
            }
        }

        // Alternar vista lado a lado / solo cambios
        var toggleBtns = document.querySelectorAll('[data-diff-view]');
        toggleBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                toggleBtns.forEach(function(b) {
                    b.classList.remove('is-active');
                });
                this.classList.add('is-active');

                var mode = this.dataset.diffView;
                document.getElementById('diffWrapper').dataset.view = mode;

                document.querySelectorAll('.diff-line').forEach(function(line) {
                    if (mode === 'unified') {
                        line.style.display = line.classList.contains('diff-changed') ? '' : 'none';
                    } else {
                        line.style.display = '';
                    }
                });
            });
        });
    })();
</script>

@endsection