<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Prediction;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['user', 'prediction.match'])
            ->orderByDesc('created_at')
            ->paginate(30);

        $lastSync = cache('football_api_last_sync');

        return view('admin.payments.index', compact('payments', 'lastSync'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $predictions = Prediction::with('match')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.payments.create', compact('users', 'predictions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'pronostico_id' => 'required|exists:pronosticos,id',
            'monto' => 'required|numeric|min:0',
            'estado' => 'required|string|in:pendiente,pagado,cancelado',
            'metodo' => 'nullable|string|max:100',
            'nota' => 'nullable|string|max:500',
            'pagado_en' => 'nullable|date',
        ]);

        if ($data['estado'] === 'pagado' && empty($data['pagado_en'])) {
            $data['pagado_en'] = now();
        }

        Payment::create($data);

        return redirect()->route('admin.payments.index')->with('success', 'Pago creado.');
    }

    public function edit(Payment $payment)
    {
        return view('admin.payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'estado' => 'required|string|in:pendiente,pagado,cancelado',
            'metodo' => 'nullable|string|max:100',
            'nota' => 'nullable|string|max:500',
            'pagado_en' => 'nullable|date',
        ]);

        $payment->fill($data);

        if ($data['estado'] === 'pagado' && ! $payment->pagado_en) {
            $payment->pagado_en = now();
        }

        $payment->save();

        return redirect()->route('admin.payments.index')->with('success', 'Pago actualizado.');
    }
}
