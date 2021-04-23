<?php
namespace App\Exports;
use App\models\ServiceProvider;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExportView implements FromView
{
    public function view(): View{
  
        return view('admin.service_provider_export_view', [
        'serviceProiders'=> ServiceProvider::all()
        ]);
    }
}

