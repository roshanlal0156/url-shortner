<?php

namespace App\Http\Controllers;

use App\Mail\LoginInvite;
use App\Models\ShortUrl;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // $query = ShortUrl::with('createdBy'); // 10 per page
        $query = DB::table('short_urls')->join('users', 'users.id', '=', 'short_urls.created_by')
        ->where('users.client_id', Auth::user()->client_id);
        // $query->where()

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

        $shortUrls = $query->orderBy('short_urls.created_at', 'desc')->select(['short_urls.long_url', 'short_urls.short_url', 'short_urls.hits', 'short_urls.created_at', 'users.name as created_by'])->paginate(10)->appends(['duration' => $request->input('duration')]);

        $members = DB::table('short_urls')
            ->rightJoin('users', 'users.id', '=', 'short_urls.created_by')  // Corrected join condition
            ->where('users.client_id', Auth::user()->client_id)
            ->groupBy('users.name', 'users.email', 'users.role', 'short_urls.created_by')  // Grouping by user fields
            ->select(
                'users.name',
                'users.email',
                'users.role',
                DB::raw('SUM(short_urls.hits) as total_hits'), // Corrected aggregation
                DB::raw('COUNT(short_urls.id) as total_urls') // Corrected aggregation
            )
            ->paginate(2);

        return view('pages.admin.dashboard', compact('shortUrls', 'members'));
    }
    public function generatedShortUrls(Request $request)
    {
        $query = DB::table('short_urls')->join('users', 'users.id', '=', 'short_urls.created_by')
        ->where('users.client_id', Auth::user()->client_id);

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

        $shortUrls = $query->orderBy('short_urls.created_at', 'desc')->select(['short_urls.long_url', 'short_urls.short_url', 'short_urls.hits', 'short_urls.created_at', 'users.name as created_by'])->paginate(10)->appends(['duration' => $request->input('duration')]);
        return view('pages.admin.generated_short_urls', compact('shortUrls'));
    }
    public function members()
    {
        $members = DB::table('short_urls')
            ->rightJoin('users', 'users.id', '=', 'short_urls.created_by')  // Corrected join condition
            ->where('users.client_id', Auth::user()->client_id)
            ->groupBy('users.name', 'users.email', 'users.role', 'short_urls.created_by')  // Grouping by user fields
            ->select(
                'users.name',
                'users.email',
                'users.role',
                DB::raw('SUM(short_urls.hits) as total_hits'), // Corrected aggregation
                DB::raw('COUNT(short_urls.id) as total_urls') // Corrected aggregation
            )
            ->paginate(10);
        return view('pages.admin.members', compact('members'));
    }

    public function getInviteForm()
    {
        return view('pages.admin.invite_new_member');
    }

    public function invite(Request $request)
    {
        $data = $request->only('name', 'email', 'role');
        Validator::validate($data, ['email' => 'required|email', 'name' => 'required|string', 'role' => 'required|string|in:admin,member']);

        DB::beginTransaction();

        try {
            $pass = rand(99999, 9999999);
            Mail::to($data['email'])->send(new LoginInvite($data['email'], $pass));

            $user = Auth::user();
            $clientId = $user->client_id;
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($pass),
                'role' => $data['role'],
                'client_id' => $clientId,
            ]);

            DB::commit();

            return redirect()->route('home');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in invite process: ' . $e->getMessage());

            return back()->withErrors(['error' => 'Something went wrong, please try again later.']);
        }
    }

    // CSV Export Function
    public function downloadCsv($data)
    {
        $response = new StreamedResponse(function () use ($data) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Short Url', 'Long URL', 'Hits', 'Created By', 'Created At']); // CSV Headers

            foreach ($data as $row) {
                fputcsv($handle, [
                    $row->short_url,
                    $row->long_url,
                    $row->hits,
                    $row->created_by,
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
