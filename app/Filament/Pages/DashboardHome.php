<?php

namespace App\Filament\Pages;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\ProductoStock;
use App\Models\Venta;
use App\Models\VentaPago;
use BackedEnum;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class DashboardHome extends Page
{
    protected string $view = 'filament.pages.dashboard-home';

    protected static ?string $navigationLabel = 'Escritorio';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -999;

    protected ?string $heading = 'Escritorio';

    protected ?string $subheading = 'Resumen general de VentaClick';

    public array $metricas = [];
    public array $ventas7Dias = [];
    public array $metodosPago = [];
    public array $ultimasVentas = [];
    public array $stockBajo = [];

    public function mount(): void
    {
        $hoy = now()->toDateString();

        $ventasHoy = Venta::query()
            ->where('estado', 'COMPLETADA')
            ->whereDate('created_at', $hoy)
            ->sum('total');

        $ticketsHoy = Venta::query()
            ->where('estado', 'COMPLETADA')
            ->whereDate('created_at', $hoy)
            ->count();

        $productosActivos = Producto::query()
            ->where('activo', true)
            ->count();

        $clientesActivos = Cliente::query()
            ->where('activo', true)
            ->count();

        $promedioTicket = $ticketsHoy > 0 ? ($ventasHoy / $ticketsHoy) : 0;

        $stockBajoCount = ProductoStock::query()
            ->join('productos', 'producto_stocks.producto_id', '=', 'productos.id')
            ->whereColumn('producto_stocks.stock_actual', '<=', 'productos.stock_minimo')
            ->count();

        $clientesNuevosMes = Cliente::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $ayer = now()->subDay()->toDateString();

        $ventasAyer = Venta::query()
            ->where('estado', 'COMPLETADA')
            ->whereDate('created_at', $ayer)
            ->sum('total');

        $variacionVsAyer = 0;
        if ($ventasAyer > 0) {
            $variacionVsAyer = (($ventasHoy - $ventasAyer) / $ventasAyer) * 100;
        }

        $this->metricas = [
            'ventas_hoy' => (float) $ventasHoy,
            'tickets_hoy' => (int) $ticketsHoy,
            'productos_activos' => (int) $productosActivos,
            'clientes_activos' => (int) $clientesActivos,
            'promedio_ticket' => (float) $promedioTicket,
            'stock_bajo_count' => (int) $stockBajoCount,
            'clientes_nuevos_mes' => (int) $clientesNuevosMes,
            'variacion_vs_ayer' => round($variacionVsAyer, 1),
        ];

        $this->ventas7Dias = $this->obtenerVentas7Dias();
        $this->metodosPago = $this->obtenerMetodosPago();
        $this->ultimasVentas = $this->obtenerUltimasVentas();
        $this->stockBajo = $this->obtenerStockBajo();
    }

    protected function obtenerVentas7Dias(): array
    {
        $inicio = now()->subDays(6)->startOfDay();
        $fin = now()->endOfDay();

        $ventas = Venta::query()
            ->selectRaw('DATE(created_at) as fecha, COALESCE(SUM(total),0) as total')
            ->where('estado', 'COMPLETADA')
            ->whereBetween('created_at', [$inicio, $fin])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->pluck('total', 'fecha');

        $dias = [];

        for ($i = 6; $i >= 0; $i--) {
            $fecha = now()->subDays($i)->toDateString();
            $dias[] = [
                'label' => now()->subDays($i)->translatedFormat('D'),
                'fecha' => $fecha,
                'total' => (float) ($ventas[$fecha] ?? 0),
            ];
        }

        return $dias;
    }

    protected function obtenerMetodosPago(): array
    {
        $data = VentaPago::query()
            ->select('metodo_pago', DB::raw('COALESCE(SUM(monto),0) as total'))
            ->groupBy('metodo_pago')
            ->pluck('total', 'metodo_pago')
            ->toArray();

        $colores = [
            'EFECTIVO' => 'bg-emerald-500',
            'TARJETA' => 'bg-blue-500',
            'TRANSFERENCIA' => 'bg-amber-500',
            'QR' => 'bg-violet-500',
            'OTRO' => 'bg-slate-500',
        ];

        $suma = array_sum($data);

        $resultado = [];
        foreach ($data as $metodo => $total) {
            $resultado[] = [
                'metodo' => $metodo,
                'total' => (float) $total,
                'porcentaje' => $suma > 0 ? round(($total / $suma) * 100, 1) : 0,
                'color' => $colores[$metodo] ?? 'bg-slate-500',
            ];
        }

        usort($resultado, fn ($a, $b) => $b['total'] <=> $a['total']);

        return $resultado;
    }

    protected function obtenerUltimasVentas(): array
    {
        return Venta::query()
            ->with(['user', 'caja', 'cliente'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($venta) {
                return [
                    'id' => $venta->id,
                    'total' => (float) $venta->total,
                    'estado' => $venta->estado,
                    'fecha' => optional($venta->created_at)?->diffForHumans(),
                    'caja' => $venta->caja?->nombre,
                    'usuario' => $venta->user?->name,
                    'cliente' => $venta->cliente?->nombre,
                ];
            })
            ->toArray();
    }

    protected function obtenerStockBajo(): array
    {
        return ProductoStock::query()
            ->join('productos', 'producto_stocks.producto_id', '=', 'productos.id')
            ->select(
                'producto_stocks.stock_actual',
                'productos.nombre',
                'productos.stock_minimo'
            )
            ->whereColumn('producto_stocks.stock_actual', '<=', 'productos.stock_minimo')
            ->orderBy('producto_stocks.stock_actual')
            ->take(6)
            ->get()
            ->map(function ($item) {
                $porcentaje = 0;

                if ((float) $item->stock_minimo > 0) {
                    $porcentaje = min(100, max(0, ($item->stock_actual / $item->stock_minimo) * 100));
                }

                return [
                    'nombre' => $item->nombre,
                    'stock_actual' => (float) $item->stock_actual,
                    'stock_minimo' => (float) $item->stock_minimo,
                    'porcentaje' => round($porcentaje),
                ];
            })
            ->toArray();
    }

    public function formatoMoneda(float $valor): string
    {
        return '$' . number_format($valor, 2);
    }
}
