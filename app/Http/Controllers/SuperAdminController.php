<?php

namespace App\Http\Controllers;

use App\Mail\LoginInvite;
use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SuperAdminController extends Controller
{
    public function testCreate()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'roshanlal0156@gmail.com',
            'password' => bcrypt('adminpassword'),
            'role' => 'super_admin',
            'client_id' => 0
        ]);
    }

    public function dashboard(Request $request)
    {
        $clients = DB::table('clients')
            ->join('users', 'users.client_id', '=', 'clients.id')
            ->leftjoin('short_urls', 'short_urls.created_by', '=', 'users.id')
            ->groupBy('users.client_id', 'clients.name', 'clients.email') // Include all non-aggregated columns in the groupBy
            ->select(
                'clients.name',
                'clients.email',
                DB::raw('COUNT(short_urls.short_url) as total_urls'),
                DB::raw('SUM(short_urls.hits) as total_hits'),
                DB::raw('COUNT(users.id) as total_users')
            )->orderBy('users.created_at', 'desc')
            ->paginate(2);
        $query = DB::table('short_urls')->join('users', 'users.id', '=', 'short_urls.created_by')
            ->join('clients', 'clients.id', '=', 'users.client_id')
            ->select(['clients.name as client_name', 'short_urls.short_url as short_url', 'short_urls.long_url', 'short_urls.hits', 'short_urls.created_at'])
            ->orderBy('short_urls.created_at', 'desc');

        if ($request->has('duration')) {
            $duration = $request->input('duration');
            switch ($duration) {
                case 'today':
                    $query->whereDate('short_urls.created_at', Carbon::today());
                    break;
                case 'last_week':
                    $query->whereBetween('short_urls.created_at', [Carbon::now()->subWeek(), Carbon::now()]);
                    break;
                case 'last_month':
                    $query->whereBetween('short_urls.created_at', [Carbon::now()->subMonth(), Carbon::now()]);
                    break;
            }
        }

        // Handle CSV download
        if ($request->has('download')) {
            return $this->downloadCsv($query->get());
        }

        $shortUrls = $query->paginate(2)->appends(['duration' => $request->input('duration')]);

        return view('pages.super_admin.dashboard', compact('clients', 'shortUrls'));
    }
    public function generatedShortUrls(Request $request)
    {
        $query = DB::table('short_urls')->join('users', 'users.id', '=', 'short_urls.created_by')
            ->join('clients', 'clients.id', '=', 'users.client_id')
            ->select(['clients.name as client_name', 'short_urls.short_url as short_url', 'short_urls.long_url', 'short_urls.hits', 'short_urls.created_at'])
            ->orderBy('short_urls.created_at', 'desc');

        if ($request->has('duration')) {
            $duration = $request->input('duration');
            switch ($duration) {
                case 'today':
                    $query->whereDate('short_urls.created_at', Carbon::today());
                    break;
                case 'last_week':
                    $query->whereBetween('short_urls.created_at', [Carbon::now()->subWeek(), Carbon::now()]);
                    break;
                case 'last_month':
                    $query->whereBetween('short_urls.created_at', [Carbon::now()->subMonth(), Carbon::now()]);
                    break;
            }
        }

        // Handle CSV download
        if ($request->has('download')) {
            return $this->downloadCsv($query->get());
        }

        $shortUrls = $query->paginate(10)->appends(['duration' => $request->input('duration')]);


        return view('pages.super_admin.generated_short_urls', compact('shortUrls'));
    }

    public function clients()
    {
        $clients = DB::table('clients')
            ->join('users', 'users.client_id', '=', 'clients.id')
            ->leftjoin('short_urls', 'short_urls.created_by', '=', 'users.id')
            ->groupBy('users.client_id', 'clients.name', 'clients.email') // Include all non-aggregated columns in the groupBy
            ->select(
                'clients.name',
                'clients.email',
                DB::raw('COUNT(short_urls.short_url) as total_urls'),
                DB::raw('SUM(short_urls.hits) as total_hits'),
                DB::raw('COUNT(users.id) as total_users')
            )->orderBy('users.created_at', 'desc')
            ->paginate(10);

        return view('pages.super_admin.clients', compact('clients'));
    }
    public function getInviteForm()
    {
        return view('pages.super_admin.invite_new_client');
    }

    public function invite(Request $request)
    {
        $data = $request->only('name', 'email');
        Validator::validate($data, ['email' => 'required|email', 'name' => 'required|string']);

        DB::beginTransaction();

        try {
            $pass = rand(99999, 9999999);
            Mail::to($data['email'])->send(new LoginInvite($data['email'], $pass));

            $client = Client::create($data);
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($pass),
                'role' => 'admin',
                'client_id' => $client->id,
            ]);

            DB::commit();

            return redirect()->route('sa.dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in invite process: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Something went wrong, please try again later.']);
        }
    }

    public function clientsList()
    {
        return Client::paginate(10);
    }

    // CSV Export Function
    public function downloadCsv($data)
    {
        $response = new StreamedResponse(function () use ($data) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Client Name', 'Short URL', 'Long URL', 'Hits', 'Created At']); // CSV Headers

            foreach ($data as $row) {
                fputcsv($handle, [
                    $row->client_name,
                    $row->short_url,
                    $row->long_url,
                    $row->hits,
                    $row->created_at,
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="short_urls.csv"');

        return $response;
    }
}
