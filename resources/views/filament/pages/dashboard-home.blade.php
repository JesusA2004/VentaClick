<x-filament-panels::page>
    @php
        $ventasMax = max(array_column($ventas7Dias, 'total')) ?: 1;
        $pagoTotal = collect($metodosPago)->sum('total');
    @endphp

    <div class="space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Panel general
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Resumen operativo de VentaClick
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ url('/admin/ventas') }}"
                    class="inline-flex items-center rounded-xl bg-amber-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-500">
                    Ver ventas
                </a>

                <a href="{{ url('/admin/productos') }}"
                    class="inline-flex items-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200 dark:hover:bg-gray-800">
                    Ver productos
                </a>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ventas del día</p>
                        <h3 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $this->formatoMoneda($metricas['ventas_hoy']) }}
                        </h3>
                    </div>
                    <div class="rounded-xl bg-emerald-100 p-3 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                        💵
                    </div>
                </div>
                <p class="mt-3 text-sm {{ $metricas['variacion_vs_ayer'] >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                    {{ $metricas['variacion_vs_ayer'] >= 0 ? '+' : '' }}{{ $metricas['variacion_vs_ayer'] }}% vs ayer
                </p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tickets del día</p>
                        <h3 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $metricas['tickets_hoy'] }}</h3>
                    </div>
                    <div class="rounded-xl bg-sky-100 p-3 text-sky-600 dark:bg-sky-500/10 dark:text-sky-400">
                        🧾
                    </div>
                </div>
                <p class="mt-3 text-sm text-sky-600 dark:text-sky-400">
                    Promedio: {{ $this->formatoMoneda($metricas['promedio_ticket']) }}
                </p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Productos activos</p>
                        <h3 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($metricas['productos_activos']) }}</h3>
                    </div>
                    <div class="rounded-xl bg-violet-100 p-3 text-violet-600 dark:bg-violet-500/10 dark:text-violet-400">
                        📦
                    </div>
                </div>
                <p class="mt-3 text-sm text-violet-600 dark:text-violet-400">
                    {{ $metricas['stock_bajo_count'] }} con stock bajo
                </p>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Clientes</p>
                        <h3 class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($metricas['clientes_activos']) }}</h3>
                    </div>
                    <div class="rounded-xl bg-amber-100 p-3 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                        👥
                    </div>
                </div>
                <p class="mt-3 text-sm text-amber-600 dark:text-amber-400">
                    {{ $metricas['clientes_nuevos_mes'] }} nuevos este mes
                </p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-5 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-white">Ventas semanales</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Últimos 7 días</p>
                    </div>
                    <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700 dark:bg-amber-500/10 dark:text-amber-400">
                        Datos reales
                    </span>
                </div>

                <div class="flex h-72 items-end gap-3">
                    @foreach ($ventas7Dias as $dia)
                        @php
                            $altura = max(8, ($dia['total'] / $ventasMax) * 100);
                        @endphp

                        <div class="flex flex-1 flex-col items-center justify-end gap-2">
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                {{ $this->formatoMoneda($dia['total']) }}
                            </div>

                            <div class="flex h-56 w-full items-end rounded-2xl bg-gray-100 p-2 dark:bg-gray-800">
                                <div
                                    class="w-full rounded-xl bg-gradient-to-t from-amber-600 to-amber-400 transition-all"
                                    style="height: {{ $altura }}%;"
                                ></div>
                            </div>

                            <div class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                                {{ $dia['label'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Métodos de pago</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Distribución acumulada</p>
                </div>

                <div class="space-y-4">
                    @forelse ($metodosPago as $metodo)
                        <div>
                            <div class="mb-1 flex items-center justify-between text-sm">
                                <span class="font-medium text-gray-700 dark:text-gray-200">
                                    {{ $metodo['metodo'] }}
                                </span>
                                <span class="text-gray-500 dark:text-gray-400">
                                    {{ $metodo['porcentaje'] }}%
                                </span>
                            </div>

                            <div class="h-3 rounded-full bg-gray-100 dark:bg-gray-800">
                                <div
                                    class="h-3 rounded-full {{ $metodo['color'] }}"
                                    style="width: {{ $metodo['porcentaje'] }}%;"
                                ></div>
                            </div>

                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                {{ $this->formatoMoneda($metodo['total']) }}
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Aún no hay pagos registrados.
                        </p>
                    @endforelse

                    <div class="pt-4 text-sm font-semibold text-gray-900 dark:text-white">
                        Total: {{ $this->formatoMoneda($pagoTotal) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Últimas ventas</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Movimientos recientes del sistema</p>
                </div>

                <div class="space-y-4">
                    @forelse ($ultimasVentas as $venta)
                        <div class="flex items-start gap-3 rounded-xl border border-gray-100 p-4 dark:border-gray-800">
                            <div class="rounded-xl bg-emerald-100 p-2 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400">
                                ✔
                            </div>

                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                    Venta #{{ $venta['id'] }} por {{ $this->formatoMoneda($venta['total']) }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Caja: {{ $venta['caja'] ?? 'N/D' }}
                                    · Usuario: {{ $venta['usuario'] ?? 'N/D' }}
                                    @if($venta['cliente'])
                                        · Cliente: {{ $venta['cliente'] }}
                                    @endif
                                </p>
                            </div>

                            <span class="text-xs text-gray-400">
                                {{ $venta['fecha'] }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            No hay ventas recientes.
                        </p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Stock bajo</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Productos por revisar</p>
                </div>

                <div class="space-y-4">
                    @forelse ($stockBajo as $item)
                        @php
                            $color = $item['porcentaje'] <= 30 ? 'bg-red-500' : 'bg-amber-500';
                        @endphp

                        <div>
                            <div class="mb-1 flex items-center justify-between text-sm">
                                <span class="font-medium text-gray-700 dark:text-gray-200">
                                    {{ $item['nombre'] }}
                                </span>
                                <span class="{{ $item['porcentaje'] <= 30 ? 'text-red-500' : 'text-amber-500' }}">
                                    {{ $item['stock_actual'] }} pzas
                                </span>
                            </div>

                            <div class="h-2 rounded-full bg-gray-100 dark:bg-gray-800">
                                <div
                                    class="h-2 rounded-full {{ $color }}"
                                    style="width: {{ max(8, $item['porcentaje']) }}%;"
                                ></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            No hay productos con stock bajo.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
