<?php

namespace App\Http\Controllers\AdminWeb;

use App\Http\Controllers\Controller;
use App\Models\CustomerLead;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display a paginated listing of all registered boutique customers.
     */
    public function index(Request $request): View
    {
        $query = User::where('role', User::ROLE_CUSTOMER)->withCount('orders');

        if ($request->filled('q')) {
            $search = $request->string('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhere('preferred_size', 'like', '%' . $search . '%')
                    ->orWhere('notes', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('size')) {
            $query->where('preferred_size', $request->string('size'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $customers = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        $metrics = [
            'total' => User::where('role', User::ROLE_CUSTOMER)->count(),
            'active' => User::where('role', User::ROLE_CUSTOMER)->where('status', User::STATUS_ACTIVE)->count(),
            'with_orders' => User::where('role', User::ROLE_CUSTOMER)->has('orders')->count(),
            'leads_count' => CustomerLead::count(),
        ];

        return view('admin.customers.index', compact('customers', 'metrics'));
    }

    /**
     * Show form to manually add a new customer directly.
     */
    public function create(): View
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created or updated customer directly in the system.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:120'],
            'preferred_size' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'status' => ['nullable', 'string', 'in:active,inactive'],
            'outfit_interest' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:100'],
        ]);

        $phone = trim($validated['phone']);
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        // Check if customer already exists by phone or email
        $customer = User::where('role', User::ROLE_CUSTOMER)
            ->where(function ($q) use ($phone, $cleanPhone, $validated) {
                $q->where('phone', $phone)
                    ->orWhere('phone', $cleanPhone);
                if (!empty($validated['email'])) {
                    $q->orWhere('email', $validated['email']);
                }
            })->first();

        if ($customer) {
            $customer->name = $validated['name'];
            $customer->phone = $phone;
            if (!empty($validated['email'])) {
                $customer->email = $validated['email'];
            }
            if (!empty($validated['preferred_size'])) {
                $customer->preferred_size = $validated['preferred_size'];
            }
            if (!empty($validated['address'])) {
                $customer->address = $validated['address'];
            }
            if (!empty($validated['city'])) {
                $customer->city = $validated['city'];
            }
            if (!empty($validated['notes'])) {
                $customer->notes = ($customer->notes ? $customer->notes . ' | ' : '') . $validated['notes'];
            }
            if (!empty($validated['status'])) {
                $customer->status = $validated['status'];
            }
            $customer->save();

            $flashMessage = "Existing customer {$customer->name} updated successfully in Curves & Tees system!";
        } else {
            $slug = Str::slug($validated['name'], '_') ?: 'customer';
            $uniqueSuffix = substr($cleanPhone, -4) ?: Str::random(4);
            $email = !empty($validated['email'])
                ? $validated['email']
                : ('customer_' . $slug . '_' . $uniqueSuffix . '@curvesandtees.com');

            if (User::where('email', $email)->exists()) {
                $email = 'customer_' . Str::random(8) . '@curvesandtees.com';
            }

            $customer = User::create([
                'name' => $validated['name'],
                'phone' => $phone,
                'email' => $email,
                'password' => Hash::make(Str::random(16)),
                'role' => User::ROLE_CUSTOMER,
                'status' => $validated['status'] ?? User::STATUS_ACTIVE,
                'preferred_size' => $validated['preferred_size'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? 'Madina / Accra',
                'notes' => $validated['notes'] ?? null,
            ]);

            $flashMessage = "Customer {$customer->name} successfully registered in Curves & Tees system!";
        }

        // Also record a lead / marketing touchpoint so campaigns include them immediately
        $source = $validated['source'] ?? 'In-Store Walk-in / Direct';
        CustomerLead::create([
            'name' => $customer->name,
            'phone' => $customer->phone,
            'email' => $customer->email,
            'action_type' => CustomerLead::ACTION_ADMIN_DIRECT,
            'product_name' => $validated['outfit_interest'] ?? null,
            'selected_size' => $customer->preferred_size,
            'user_id' => $customer->id,
            'notes' => "Registered directly via Admin ({$source})" . (!empty($validated['notes']) ? ' | ' . $validated['notes'] : ''),
        ]);

        return redirect()->route('admin.customers.show', $customer)->with('status', $flashMessage);
    }

    /**
     * Display comprehensive details, purchase history, and WhatsApp activity for a customer.
     */
    public function show(User $user): View
    {
        abort_unless($user->isCustomer(), 404);

        $orders = $user->orders()->with(['items', 'payment', 'deliveryInformation'])->orderByDesc('created_at')->get();
        $leads = CustomerLead::where('user_id', $user->id)
            ->orWhere('phone', $user->phone)
            ->orderByDesc('created_at')
            ->get();

        return view('admin.customers.show', compact('user', 'orders', 'leads'));
    }

    /**
     * Show form to edit an existing customer profile.
     */
    public function edit(User $user): View
    {
        abort_unless($user->isCustomer(), 404);

        return view('admin.customers.edit', compact('user'));
    }

    /**
     * Update an existing customer profile.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        abort_unless($user->isCustomer(), 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:120', 'unique:users,email,' . $user->id],
            'preferred_size' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'string', 'in:active,inactive'],
        ]);

        $user->update($validated);

        return redirect()->route('admin.customers.show', $user)->with('status', "Customer {$user->name}'s profile updated successfully!");
    }

    /**
     * Remove or deactivate a customer.
     */
    public function destroy(User $user): RedirectResponse
    {
        abort_unless($user->isCustomer(), 404);

        if ($user->orders()->exists()) {
            $user->update(['status' => User::STATUS_INACTIVE]);
            return back()->with('status', "Customer has past orders; their status was safely marked as Inactive instead of deletion.");
        }

        $user->leads()->delete();
        $user->delete();

        return redirect()->route('admin.customers.index')->with('status', 'Customer record removed successfully.');
    }
}
