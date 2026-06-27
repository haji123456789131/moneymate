<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('/dashboard', 'pages::dashboard')->name('dashboard');
    Route::livewire('categories', 'pages::category.index')->name('category.index');
    Route::livewire('budgets', 'pages::budget.index')->name('budget.index');
    Route::livewire('transactions', 'pages::transaction.index')->name('transaction.index');
    Route::livewire('/saving-goals', 'pages::saving-goal.index')->name('saving-goal.index');
});

require __DIR__.'/settings.php';
