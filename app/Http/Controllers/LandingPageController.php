<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Week;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil semua anggota
        $members = Member::with('transaction_members.week')->get();

        // Ambil semua minggu dan kelompokkan berdasarkan bulan
        $weeks = Week::orderBy('start_date')->get();
        
        // Kelompokkan minggu berdasarkan bulan
        $months = [];
        foreach ($weeks as $week) {
            $monthYear = \Carbon\Carbon::parse($week->start_date)->translatedFormat('F Y'); // Contoh: "December 2024"
            
            if (!isset($months[$monthYear])) {
                $months[$monthYear] = [];
            }
            
            $months[$monthYear][] = $week;
        }

        return view('landing', compact('members', 'months'));
    }
}