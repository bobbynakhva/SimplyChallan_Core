<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\FinancialYear;
use App\Models\Challan;
use App\Models\InwardChallan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $fyMap = FinancialYear::all()->pluck('id', 'year')->toArray();

        $getFyId = function($yearStr) use (&$fyMap) {
            if (isset($fyMap[$yearStr])) {
                return $fyMap[$yearStr];
            }
            $fy = FinancialYear::create(['year' => $yearStr]);
            $fyMap[$yearStr] = $fy->id;
            return $fy->id;
        };

        $getFyStringFromDate = function($dateStr) {
            if (!$dateStr) return null;
            $timestamp = strtotime($dateStr);
            if (!$timestamp) return null;
            $year = (int)date('Y', $timestamp);
            $month = (int)date('m', $timestamp);

            if ($month >= 4) {
                $startYear = $year;
                $endYear = $year + 1;
            } else {
                $startYear = $year - 1;
                $endYear = $year;
            }
            return "{$startYear}-{$endYear}";
        };

        foreach (Challan::all() as $challan) {
            $targetFyStr = null;

            if (preg_match('/\/(\d{4}-\d{4})$/', $challan->challan_number, $matches)) {
                $targetFyStr = $matches[1];
            } elseif ($challan->date) {
                $targetFyStr = $getFyStringFromDate($challan->date);
            }

            if ($targetFyStr) {
                $targetFyId = $getFyId($targetFyStr);
                if ($challan->financial_year_id != $targetFyId) {
                    $challan->financial_year_id = $targetFyId;
                    $challan->save();
                }
            }
        }

        foreach (InwardChallan::all() as $inward) {
            $targetFyStr = null;

            if (preg_match('/\/(\d{4}-\d{4})$/', $inward->challan_number, $matches)) {
                $targetFyStr = $matches[1];
            } elseif ($inward->date) {
                $targetFyStr = $getFyStringFromDate($inward->date);
            }

            if ($targetFyStr) {
                $targetFyId = $getFyId($targetFyStr);
                if ($inward->financial_year_id != $targetFyId) {
                    $inward->financial_year_id = $targetFyId;
                    $inward->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed on rollback
    }
};
