@extends('layouts.app')

@section('title', 'Auditoría')

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

    .audit-app .mono { font-family: 'JetBrains Mono', ui-monospace, monospace; }

    /* HEADER */
    .audit-hero {
        position: relative;
        background: linear-gradient(120deg, #1e1b4b 0%, #312e81 45%, #4338ca 100%);
        color: #fff;
        border-radius: var(--radius);
        padding: 28px 30px;
        margin-bottom: 22px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .audit-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 1.5px 1.5px, rgba(255,255,255,.14) 1.5px, transparent 0);
        background-size: 22px 22px;
        opacity: .5;
        pointer-events: none;
    }

    .audit-hero-top { position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap; }

    .audit-hero h1 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: -.01em;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .audit-hero p { margin: 6px 0 0; color: #c7d2fe; font-size: .88rem; }

    .audit-clock {
        font-family: 'JetBrains Mono', monospace;
        font-size: .8rem;
        color: #e0e7ff;
        background: rgba(255,255,255,.1);
        border: 1px solid rgba(255,255,255,.18);
        border-radius: 20px;
        padding: 7px 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        backdrop-filter: blur(4px);
    }

    .audit-clock .dot {
        width: 7px; height: 7px; border-radius: 50%;
        background: #34d399;
        box-shadow: 0 0 0 3px rgba(52,211,153,.25);
        animation: pulse 2s infinite;
    }

    @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: .4; } }

    /* STAT CARDS */
    .audit-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 14px; margin-bottom: 22px; }

    .audit-stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 16px 18px;
        box-shadow: var(--shadow-sm);
    }

    .audit-stat-label {
        font-size: .72rem; text-transform: uppercase; letter-spacing: .06em;
        font-weight: 700; color: var(--ink-3); margin-bottom: 6px;
    }

    .audit-stat-value { font-size: 1.5rem; font-weight: 800; color: var(--ink); font-family: 'JetBrains Mono', monospace; }
    .audit-stat-value small { font-size: .85rem; font-weight: 600; color: var(--ink-3); }

    /* CARD SHELL */
    .audit-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .audit-card + .audit-card { margin-top: 20px; }

    /* PROGRESS BAR */
    .audit-progress {
        height: 3px; width: 100%; background: transparent; position: relative; overflow: hidden;
    }
    .audit-progress::before {
        content: ''; position: absolute; top: 0; left: -30%; height: 100%; width: 30%;
        background: linear-gradient(90deg, transparent, var(--accent), transparent);
        transition: opacity .2s ease;
        opacity: 0;
    }
    .audit-progress.is-active::before {
        opacity: 1;
        animation: audit-loading 1s ease-in-out infinite;
    }
    @keyframes audit-loading { 0% { left: -30%; } 100% { left: 100%; } }

    /* FILTERS */
    .audit-filter-header {
        padding: 16px 22px;
        border-bottom: 1px solid var(--border);
        background: var(--surface-2);
        font-weight: 700;
        font-size: .88rem;
        color: var(--ink);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .audit-filter-header .live-toggle {
        display: flex; align-items: center; gap: 8px; font-weight: 500; font-size: .78rem; color: var(--ink-2);
    }

    .audit-switch { position: relative; width: 34px; height: 19px; }
    .audit-switch input { opacity: 0; width: 0; height: 0; }
    .audit-switch .slider {
        position: absolute; cursor: pointer; inset: 0; background: #cbd5e1; border-radius: 20px; transition: .2s;
    }
    .audit-switch .slider::before {
        content: ''; position: absolute; height: 14px; width: 14px; left: 2.5px; top: 2.5px; background: #fff; border-radius: 50%; transition: .2s;
    }
    .audit-switch input:checked + .slider { background: var(--accent); }
    .audit-switch input:checked + .slider::before { transform: translateX(15px); }

    .audit-filter-body { padding: 20px 22px; }

    .audit-app .form-label { font-size: .78rem; font-weight: 700; color: var(--ink-2); margin-bottom: 6px; }

    .audit-app .form-control,
    .audit-app .form-select {
        border-radius: var(--radius-sm);
        border-color: var(--border);
        min-height: 40px;
        font-size: .86rem;
        color: var(--ink);
    }

    .audit-app .form-control:focus,
    .audit-app .form-select:focus {
        border-color: var(--primary-2);
        box-shadow: 0 0 0 .15rem rgba(99,102,241,.15);
    }

    .audit-app .btn-audit {
        border-radius: var(--radius-sm);
        font-weight: 600;
        min-height: 40px;
        padding: 0 20px;
        white-space: nowrap;
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }
    .audit-app .btn-audit:hover { background: var(--primary-2); border-color: var(--primary-2); color: #fff; }

    .audit-app .btn-clear {
        border-radius: var(--radius-sm);
        font-weight: 600;
        min-height: 40px;
        padding: 0 16px;
        white-space: nowrap;
        border: 1px solid var(--border);
        color: var(--ink-2);
        background: #fff;
    }
    .audit-app .btn-clear:hover { background: var(--surface-3); }

    .filter-actions { margin-top: 4px; }

    @media (max-width: 991px) {
        .filter-actions { justify-content: flex-start !important; }
        .filter-actions .btn-audit,
        .filter-actions .btn-clear { flex: 1; }
    }

    /* TABLE */
    .audit-table-wrapper { overflow-x: auto; }
    .audit-table { margin: 0; min-width: 1080px; }

    .audit-table thead th {
        background: var(--surface-2);
        color: var(--ink-2);
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .05em;
        font-weight: 700;
        padding: 13px 16px;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
        position: sticky; top: 0; z-index: 2;
    }

    .audit-table th.sortable { cursor: pointer; user-select: none; }
    .audit-table th.sortable:hover { color: var(--primary); }
    .audit-table th.sortable .bi { font-size: .68rem; opacity: .35; margin-left: 3px; transition: opacity .15s, transform .15s; }
    .audit-table th.sort-asc .bi { opacity: 1; transform: rotate(0deg); }
    .audit-table th.sort-desc .bi { opacity: 1; transform: rotate(180deg); }

    .audit-table tbody td {
        padding: 13px 16px;
        vertical-align: middle;
        font-size: .85rem;
        color: var(--ink);
        border-bottom: 1px solid var(--surface-3);
    }

    .audit-table tbody tr { transition: background .12s ease; }
    .audit-table tbody tr:hover { background: var(--surface-2); }

    .audit-user { display: flex; align-items: center; gap: 10px; white-space: nowrap; }

    .audit-user-icon {
        width: 32px; height: 32px; border-radius: 9px;
        background: var(--primary-soft); color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: .76rem; font-weight: 800;
    }

    .audit-user-name { font-weight: 600; color: var(--ink); font-size: .85rem; }

    .audit-date { white-space: nowrap; color: var(--ink-2); font-size: .82rem; }
    .audit-date small { color: var(--ink-3); font-family: 'JetBrains Mono', monospace; }

    .audit-ip {
        font-family: 'JetBrains Mono', monospace;
        background: var(--surface-3);
        border-radius: 6px;
        padding: 4px 9px;
        font-size: .76rem;
        color: var(--ink-2);
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .audit-copy-btn {
        border: none; background: transparent; color: var(--ink-3); cursor: pointer; padding: 0; line-height: 1;
        font-size: .78rem;
    }
    .audit-copy-btn:hover { color: var(--primary); }

    .audit-module {
        font-size: .74rem; font-weight: 700; color: var(--ink-2);
        letter-spacing: .03em; font-family: 'JetBrains Mono', monospace;
    }

    .audit-record { font-weight: 600; color: var(--ink); font-family: 'JetBrains Mono', monospace; font-size: .83rem; }

    .audit-description {
        max-width: 260px; white-space: nowrap; overflow: hidden;
        text-overflow: ellipsis; color: var(--ink-2); font-size: .84rem;
    }

    .audit-action {
        border-radius: 20px; padding: 5px 11px 5px 8px; font-size: .72rem; font-weight: 700;
        letter-spacing: .02em; display: inline-flex; align-items: center; gap: 6px;
    }
    .audit-action .dot { width: 6px; height: 6px; border-radius: 50%; }

    .audit-action-create { background: #ecfdf5; color: #047857; }
    .audit-action-create .dot { background: #10b981; }

    .audit-action-update { background: #fffbeb; color: #b45309; }
    .audit-action-update .dot { background: #f59e0b; }

    .audit-action-delete { background: #fef2f2; color: #b91c1c; }
    .audit-action-delete .dot { background: #ef4444; }

    .audit-action-view { background: #eff6ff; color: #1d4ed8; }
    .audit-action-view .dot { background: #3b82f6; }

    .audit-action-default { background: var(--surface-3); color: var(--ink-2); }
    .audit-action-default .dot { background: var(--ink-3); }

    .audit-empty { padding: 64px 20px !important; color: var(--ink-3); }
    .audit-empty-icon { font-size: 2.2rem; margin-bottom: 12px; color: var(--ink-3); }
    .audit-empty .fw-semibold { color: var(--ink-2); }

    .audit-footer { background: #fff; border-top: 1px solid var(--surface-3); padding: 14px 20px; }
    .audit-footer .pagination { margin-bottom: 0; }
    .audit-footer .page-link { color: var(--primary); border-color: var(--border); }
    .audit-footer .page-item.active .page-link { background: var(--primary); border-color: var(--primary); }

    .btn-view-audit {
        border-radius: var(--radius-sm);
        font-size: .78rem;
        padding: 6px 12px;
        font-weight: 600;
        background: var(--ink);
        color: #fff;
        border: none;
        display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-view-audit:hover { background: var(--primary); color: #fff; }

    @media (max-width: 767px) {
        .audit-hero { padding: 22px; }
        .audit-hero h1 { font-size: 1.25rem; }
    }
</style>

<div class="audit-app container-fluid">

    {{-- ENCABEZADO --}}
    <div class="audit-hero">
        <div class="audit-hero-top">
            <div>
                <h1><i class="bi bi-shield-check"></i> Auditoría del sistema</h1>
                <p>Registro de actividades realizadas por los usuarios.</p>
            </div>
            <div class="audit-clock">
                <span class="dot"></span>
                <span id="auditClock">--:--:--</span>
            </div>
        </div>
    </div>

    {{-- ESTADÍSTICAS --}}
    <div class="audit-stats" id="auditStats">
        <div class="audit-stat-card">
            <div class="audit-stat-label">Total de registros</div>
            <div class="audit-stat-value">{{ $auditorias->total() }}</div>
        </div>
        <div class="audit-stat-card">
            <div class="audit-stat-label">En esta página</div>
            <div class="audit-stat-value">{{ $auditorias->count() }} <small>de {{ $auditorias->perPage() }}</small></div>
        </div>
        <div class="audit-stat-card">
            <div class="audit-stat-label">Página actual</div>
            <div class="audit-stat-value">{{ $auditorias->currentPage() }} <small>de {{ $auditorias->lastPage() }}</small></div>
        </div>
        <div class="audit-stat-card">
            <div class="audit-stat-label">Último registro</div>
            <div class="audit-stat-value" style="font-size:.95rem;">
                {{ optional($auditorias->first())->created_at?->format('d/m/Y H:i') ?? '—' }}
            </div>
        </div>
    </div>

    {{-- FILTROS --}}
    <div class="card audit-card mb-0">

        <div class="audit-filter-header">
            <span><i class="bi bi-funnel me-2"></i>Filtros de búsqueda</span>
            <label class="live-toggle">
                Actualización automática
                <span class="audit-switch">
                    <input type="checkbox" id="auditAutoRefresh">
                    <span class="slider"></span>
                </span>
            </label>
        </div>

        <div class="audit-progress" id="auditProgress"></div>

        <div class="audit-filter-body">

            <form id="auditFilterForm" method="GET" action="{{ route('auditorias.index') }}">

                <div class="row g-3">

                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">Buscar</label>
                        <input type="text" name="buscar" class="form-control" placeholder="Descripción, IP o registro..." value="{{ request('buscar') }}">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Usuario</label>
                        <select name="user_id" class="form-select">
                            <option value="">Todos</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" @selected(request('user_id') == $usuario->id)>
                                    {{ $usuario->name ?? $usuario->username }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <label class="form-label">Acción</label>
                        <select name="accion" class="form-select">
                            <option value="">Todas</option>
                            @foreach($acciones as $accion)
                                <option value="{{ $accion }}" @selected(request('accion') == $accion)>{{ $accion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Módulo</label>
                        <select name="tabla" class="form-select">
                            <option value="">Todos</option>
                            @foreach($tablas as $tabla)
                                <option value="{{ $tabla }}" @selected(request('tabla') == $tabla)>{{ ucfirst($tabla) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Desde</label>
                        <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Hasta</label>
                        <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                    </div>

                    <div class="col-lg-6 d-flex align-items-end justify-content-end gap-2 filter-actions">
                        <button type="button" id="auditClearFilters" class="btn btn-clear">
                            <i class="bi bi-x-circle me-1"></i> Limpiar filtros
                        </button>
                        <button type="submit" class="btn btn-audit">
                            <i class="bi bi-search me-1"></i> Buscar
                        </button>
                    </div>

                </div>

            </form>

        </div>

    </div>

    {{-- TABLA + PAGINACIÓN (se reemplaza dinámicamente) --}}
    <div id="auditTableContainer">

        <div class="card audit-card">

            <div class="audit-table-wrapper">

                <table class="table audit-table">

                    <thead>
                        <tr>
                            <th class="sortable" data-sort="fecha">Fecha <i class="bi bi-caret-down-fill"></i></th>
                            <th class="sortable" data-sort="usuario">Usuario <i class="bi bi-caret-down-fill"></i></th>
                            <th class="sortable" data-sort="accion">Acción <i class="bi bi-caret-down-fill"></i></th>
                            <th class="sortable" data-sort="modulo">Módulo <i class="bi bi-caret-down-fill"></i></th>
                            <th>Registro</th>
                            <th>Descripción</th>
                            <th>IP</th>
                            <th class="text-center">Detalle</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($auditorias as $auditoria)

                            @php
                                $badge = match($auditoria->accion) {
                                    'CREAR' => 'audit-action-create',
                                    'MODIFICAR' => 'audit-action-update',
                                    'ANULAR', 'ELIMINAR' => 'audit-action-delete',
                                    'CONSULTAR', 'VER' => 'audit-action-view',
                                    default => 'audit-action-default'
                                };
                                $nombreUsuario = $auditoria->usuario->name ?? $auditoria->usuario->username ?? 'Sistema';
                                $inicial = strtoupper(substr($nombreUsuario, 0, 1));
                            @endphp

                            <tr
                                data-fecha="{{ $auditoria->created_at?->timestamp }}"
                                data-usuario="{{ strtolower($nombreUsuario) }}"
                                data-accion="{{ $auditoria->accion }}"
                                data-modulo="{{ strtolower($auditoria->tabla ?? '') }}"
                            >

                                <td>
                                    <div class="audit-date">
                                        <div>{{ $auditoria->created_at?->format('d/m/Y') }}</div>
                                        <small>{{ $auditoria->created_at?->format('H:i:s') }}</small>
                                    </div>
                                </td>

                                <td>
                                    <div class="audit-user">
                                        <div class="audit-user-icon">{{ $inicial }}</div>
                                        <div class="audit-user-name">{{ $nombreUsuario }}</div>
                                    </div>
                                </td>

                                <td>
                                    <span class="audit-action {{ $badge }}">
                                        <span class="dot"></span>{{ $auditoria->accion }}
                                    </span>
                                </td>

                                <td><span class="audit-module">{{ strtoupper($auditoria->tabla ?? '-') }}</span></td>

                                <td><span class="audit-record">#{{ $auditoria->registro_id ?? '-' }}</span></td>

                                <td>
                                    <div class="audit-description" title="{{ $auditoria->descripcion }}">
                                        {{ $auditoria->descripcion ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="audit-ip">
                                        {{ $auditoria->ip ?? '-' }}
                                        @if($auditoria->ip)
                                            <button type="button" class="audit-copy-btn" data-copy="{{ $auditoria->ip }}" title="Copiar IP">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        @endif
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('auditorias.show', $auditoria) }}" class="btn-view-audit">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center audit-empty">
                                    <div class="audit-empty-icon"><i class="bi bi-shield-slash"></i></div>
                                    <div class="fw-semibold">No existen registros de auditoría.</div>
                                    <small>Cuando se realicen acciones en el sistema, aparecerán aquí.</small>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if($auditorias->hasPages())
                <div class="audit-footer">
                    {{ $auditorias->links() }}
                </div>
            @endif

        </div>

    </div>

</div>

<script>
(function(){
    var app = document.querySelector('.audit-app');
    var form = document.getElementById('auditFilterForm');
    var container = document.getElementById('auditTableContainer');
    var progress = document.getElementById('auditProgress');
    var searchInput = form.querySelector('[name="buscar"]');
    var debounceTimer, refreshTimer;

    function showProgress(){ progress.classList.add('is-active'); }
    function hideProgress(){ progress.classList.remove('is-active'); }

    function buildUrl(){
        var params = new URLSearchParams(new FormData(form));
        Array.from(params.keys()).forEach(function(k){ if(!params.get(k)) params.delete(k); });
        var qs = params.toString();
        return form.action + (qs ? ('?' + qs) : '');
    }

    function fetchAndSwap(url, pushState){
        pushState = pushState !== false;
        showProgress();
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function(res){ return res.text(); })
            .then(function(html){
                var doc = new DOMParser().parseFromString(html, 'text/html');
                var newContainer = doc.getElementById('auditTableContainer');
                var newStats = doc.getElementById('auditStats');
                if (newContainer) container.innerHTML = newContainer.innerHTML;
                if (newStats) document.getElementById('auditStats').innerHTML = newStats.innerHTML;
                if (pushState) window.history.pushState({}, '', url);
                initTableInteractions();
            })
            .catch(function(err){ console.error('No se pudo actualizar la tabla', err); })
            .finally(hideProgress);
    }

    form.addEventListener('submit', function(e){ e.preventDefault(); fetchAndSwap(buildUrl()); });

    form.querySelectorAll('select, input[type="date"]').forEach(function(el){
        el.addEventListener('change', function(){ fetchAndSwap(buildUrl()); });
    });

    searchInput.addEventListener('input', function(){
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function(){ fetchAndSwap(buildUrl()); }, 450);
    });

    document.getElementById('auditClearFilters').addEventListener('click', function(){
        form.reset();
        fetchAndSwap(form.action);
    });

    document.addEventListener('click', function(e){
        var link = e.target.closest('.audit-footer a');
        if (link && container.contains(link)) {
            e.preventDefault();
            fetchAndSwap(link.href);
        }
    });

    window.addEventListener('popstate', function(){ fetchAndSwap(window.location.href, false); });

    document.getElementById('auditAutoRefresh').addEventListener('change', function(){
        if (this.checked) {
            refreshTimer = setInterval(function(){ fetchAndSwap(window.location.href, false); }, 20000);
        } else {
            clearInterval(refreshTimer);
        }
    });

    function initTableInteractions(){
        container.querySelectorAll('[data-copy]').forEach(function(btn){
            btn.addEventListener('click', function(){
                var icon = this.querySelector('i');
                navigator.clipboard.writeText(this.dataset.copy).then(function(){
                    icon.className = 'bi bi-check2';
                    setTimeout(function(){ icon.className = 'bi bi-clipboard'; }, 1200);
                });
            });
        });

        var headers = container.querySelectorAll('th.sortable');
        headers.forEach(function(th){
            th.addEventListener('click', function(){
                var key = this.dataset.sort;
                var tbody = container.querySelector('tbody');
                var rows = Array.from(tbody.querySelectorAll('tr[data-' + key + ']'));
                if (!rows.length) return;

                var asc = !this.classList.contains('sort-asc');
                headers.forEach(function(h){ h.classList.remove('sort-asc', 'sort-desc'); });
                this.classList.add(asc ? 'sort-asc' : 'sort-desc');

                rows.sort(function(a, b){
                    var va = a.dataset[key], vb = b.dataset[key];
                    if (key === 'fecha') { va = Number(va); vb = Number(vb); }
                    if (va < vb) return asc ? -1 : 1;
                    if (va > vb) return asc ? 1 : -1;
                    return 0;
                });

                rows.forEach(function(row){ tbody.appendChild(row); });
            });
        });
    }

    initTableInteractions();

    var clockEl = document.getElementById('auditClock');
    function tick(){
        clockEl.textContent = new Date().toLocaleTimeString('es-PE', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    tick();
    setInterval(tick, 1000);
})();
</script>

@endsection