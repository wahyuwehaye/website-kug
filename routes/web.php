<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FinancialDocumentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/id');

Route::pattern('locale', 'id|en');

Route::middleware('web')->group(function () {
    Route::prefix('{locale}')->group(function () {
        Route::get('/', HomeController::class)->name('home');

        Route::get('programs', [ProgramController::class, 'index'])->name('programs.index');
        Route::get('programs/{program:slug}', [ProgramController::class, 'show'])->name('programs.show');

        Route::get('news', [NewsController::class, 'index'])->name('news.index');
        Route::get('news/{newsPost:slug}', [NewsController::class, 'show'])->name('news.show');

        Route::get('documents', [FinancialDocumentController::class, 'index'])->name('documents.index');
        Route::get('documents/{document:slug}/download', [FinancialDocumentController::class, 'download'])->name('documents.download');

        Route::get('contact', ContactController::class)->name('contact');
    });
});
