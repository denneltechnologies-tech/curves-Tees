<?php

namespace App\Http\Controllers\AdminWeb;

use App\Http\Controllers\Controller;
use App\Models\CustomerLead;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadController extends Controller
{
    /**
     * Display captured customer leads & marketing campaigns dashboard.
     */
    public function index(Request $request): View
    {
        $query = CustomerLead::query()->with(['product', 'order', 'user'])->latest();

        if ($request->filled('q')) {
            $q = $request->string('q');
            $query->where(function ($b) use ($q) {
                $b->where('name', 'like', "%{$q}%")
                  ->orWhere('phone', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('product_name', 'like', "%{$q}%")
                  ->orWhere('selected_size', 'like', "%{$q}%")
                  ->orWhere('notes', 'like', "%{$q}%");
            });
        }

        if ($request->filled('action_type')) {
            $query->where('action_type', $request->string('action_type'));
        }

        if ($request->filled('size')) {
            $query->where('selected_size', 'like', '%' . $request->string('size') . '%');
        }

        $leads = $query->paginate(20)->withQueryString();

        $stats = [
            'total' => CustomerLead::count(),
            'whatsapp_inquiries' => CustomerLead::where('action_type', CustomerLead::ACTION_WHATSAPP_INQUIRY)->count(),
            'cart_adds' => CustomerLead::where('action_type', CustomerLead::ACTION_ADD_TO_CART)->count(),
            'checkouts' => CustomerLead::where('action_type', CustomerLead::ACTION_CHECKOUT)->count(),
            'admin_direct' => CustomerLead::where('action_type', CustomerLead::ACTION_ADMIN_DIRECT)->count(),
            'unique_phones' => CustomerLead::distinct('phone')->count('phone'),
        ];

        return view('admin.leads.index', compact('leads', 'stats'));
    }

    /**
     * Export leads to CSV for SMS/WhatsApp campaign broadcasting.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $fileName = 'curves_and_tees_customer_leads_' . now()->format('Y-m-d_His') . '.csv';

        $leads = CustomerLead::latest()->get();

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['ID', 'Name', 'Phone', 'WhatsApp Number', 'Action / Source', 'Product Name', 'Price (GHS)', 'Size', 'Date Captured'];

        $callback = function () use ($leads, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($leads as $lead) {
                fputcsv($file, [
                    $lead->id,
                    $lead->name ?: 'Shopper',
                    $lead->phone,
                    $lead->getWhatsAppNumber(),
                    str_replace('_', ' ', ucfirst($lead->action_type)),
                    $lead->product_name ?: '—',
                    $lead->product_price ? number_format((float) $lead->product_price, 2) : '—',
                    $lead->selected_size ?: '—',
                    $lead->created_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Delete a single lead record.
     */
    public function destroy(CustomerLead $lead)
    {
        $lead->delete();
        return back()->with('status', 'Customer lead removed.');
    }
}
