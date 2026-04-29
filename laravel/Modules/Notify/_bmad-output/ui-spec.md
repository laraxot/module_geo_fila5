---
stepsCompleted: ['step-01-init', 'step-02-discovery', 'step-03-spec']
inputDocuments:
  - '_bmad-output/prd.md'
  - '_bmad-output/architecture.md'
  - '_bmad-output/codebase/architecture-analysis.md'
workflowType: 'ux-design'
project_name: 'FixCity Fila5'
user_name: 'Xot'
date: '2026-04-01'
version: '1.0'
---

# UX Design Specification - FixCity Fila5

**Version:** 1.0  
**Date:** 2026-04-01  
**Status:** Complete  

---

## 1. Design System Overview

### 1.1 Design Principles

1. **Mobile-First**: Progettazione partendo da mobile, scaling up
2. **Accessibility**: WCAG 2.1 AA compliance
3. **Consistency**: Design system unificato con Tailwind CSS v4
4. **Performance**: Perceived performance optimization
5. **Clarity**: Visual hierarchy e clear affordances

### 1.2 Color Palette

```css
/* Primary Colors - FixCity Brand */
--color-primary-50: #eff6ff;
--color-primary-100: #dbeafe;
--color-primary-200: #bfdbfe;
--color-primary-300: #93c5fd;
--color-primary-400: #60a5fa;
--color-primary-500: #3b82f6; /* Main brand color */
--color-primary-600: #2563eb;
--color-primary-700: #1d4ed8;
--color-primary-800: #1e40af;
--color-primary-900: #1e3a8a;

/* Status Colors */
--color-success: #10b981;   /* Tickets risolti */
--color-warning: #f59e0b;   /* In lavorazione */
--color-danger: #ef4444;    /* Urgenti/Chiusi */
--color-info: #3b82f6;      /* Informazioni */

/* Neutral Colors */
--color-gray-50: #f9fafb;
--color-gray-100: #f3f4f6;
--color-gray-200: #e5e7eb;
--color-gray-300: #d1d5db;
--color-gray-400: #9ca3af;
--color-gray-500: #6b7280;
--color-gray-600: #4b5563;
--color-gray-700: #374151;
--color-gray-800: #1f2937;
--color-gray-900: #111827;
```

### 1.3 Typography Scale

```css
/* Font Families */
--font-sans: 'Inter', system-ui, -apple-system, sans-serif;
--font-mono: 'Fira Code', monospace;

/* Type Scale */
--text-xs: 0.75rem;     /* 12px */
--text-sm: 0.875rem;    /* 14px */
--text-base: 1rem;      /* 16px */
--text-lg: 1.125rem;    /* 18px */
--text-xl: 1.25rem;     /* 20px */
--text-2xl: 1.5rem;     /* 24px */
--text-3xl: 1.875rem;   /* 30px */
--text-4xl: 2.25rem;    /* 36px */
```

### 1.4 Spacing System

```css
--spacing-0: 0;
--spacing-1: 0.25rem;   /* 4px */
--spacing-2: 0.5rem;    /* 8px */
--spacing-3: 0.75rem;   /* 12px */
--spacing-4: 1rem;      /* 16px */
--spacing-5: 1.25rem;   /* 20px */
--spacing-6: 1.5rem;    /* 24px */
--spacing-8: 2rem;      /* 32px */
--spacing-10: 2.5rem;   /* 40px */
--spacing-12: 3rem;     /* 48px */
--spacing-16: 4rem;     /* 64px */
```

---

## 2. Component Library

### 2.1 Button Components

#### Primary Button
```blade
{{-- Base --}}
<button class="inline-flex items-center justify-center px-4 py-2 
               text-sm font-medium text-white 
               bg-primary-600 border border-transparent 
               rounded-lg shadow-sm 
               hover:bg-primary-700 
               focus:outline-none focus:ring-2 
               focus:ring-offset-2 focus:ring-primary-500 
               disabled:opacity-50 disabled:cursor-not-allowed
               transition-colors duration-200">
    Submit
</button>

{{-- With Icon --}}
<button class="inline-flex items-center gap-2 px-4 py-2 ...">
    <x-heroicon-o-plus class="w-5 h-5" />
    New Ticket
</button>
```

#### Button Variants
```blade
{{-- Secondary --}}
<button class="bg-white border border-gray-300 text-gray-700 
               hover:bg-gray-50 ...">
</button>

{{-- Danger --}}
<button class="bg-red-600 hover:bg-red-700 text-white ...">
</button>

{{-- Ghost --}}
<button class="bg-transparent hover:bg-gray-100 text-gray-700 ...">
</button>
```

### 2.2 Form Components

#### Text Input
```blade
<div class="space-y-1">
    <label class="block text-sm font-medium text-gray-700">
        Title
    </label>
    <input type="text" 
           class="block w-full px-3 py-2 
                  border border-gray-300 rounded-md 
                  shadow-sm focus:ring-primary-500 
                  focus:border-primary-500 
                  disabled:bg-gray-100 
                  disabled:cursor-not-allowed"
           placeholder="Enter ticket title">
    <p class="text-sm text-gray-500">
        Be specific and descriptive
    </p>
</div>
```

#### Select Dropdown
```blade
<div class="space-y-1">
    <label class="block text-sm font-medium text-gray-700">
        Priority
    </label>
    <select class="block w-full px-3 py-2 
                   border border-gray-300 rounded-md 
                   shadow-sm focus:ring-primary-500 
                   focus:border-primary-500">
        <option value="1">Low</option>
        <option value="2">Medium</option>
        <option value="3">High</option>
        <option value="4">Critical</option>
    </select>
</div>
```

#### File Upload
```blade
<div class="mt-1 flex justify-center px-6 pt-5 pb-6 
            border-2 border-gray-300 border-dashed rounded-md 
            hover:border-primary-500 transition-colors">
    <div class="space-y-1 text-center">
        <x-heroicon-o-camera class="mx-auto h-12 w-12 text-gray-400" />
        <div class="flex text-sm text-gray-600">
            <label class="relative cursor-pointer 
                          bg-white rounded-md font-medium 
                          text-primary-600 hover:text-primary-500">
                <span>Upload a file</span>
                <input type="file" class="sr-only">
            </label>
            <p class="pl-1">or drag and drop</p>
        </div>
        <p class="text-xs text-gray-500">
            PNG, JPG, GIF up to 10MB
        </p>
    </div>
</div>
```

### 2.3 Card Components

#### Ticket Card
```blade
<div class="bg-white rounded-lg shadow-md hover:shadow-lg 
            transition-shadow duration-200 overflow-hidden">
    {{-- Header --}}
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">
                {{ $ticket->title }}
            </h3>
            <span class="px-2 py-1 text-xs font-semibold 
                         rounded-full 
                         @if($ticket->priority >= 3) 
                             bg-red-100 text-red-800
                         @else 
                             bg-green-100 text-green-800
                         @endif">
                Priority {{ $ticket->priority }}
            </span>
        </div>
    </div>
    
    {{-- Body --}}
    <div class="px-6 py-4">
        <p class="text-gray-600 line-clamp-3">
            {{ $ticket->description }}
        </p>
        
        <div class="mt-4 flex items-center gap-4">
            <div class="flex items-center gap-2">
                <x-heroicon-o-user class="w-5 h-5 text-gray-400" />
                <span class="text-sm text-gray-600">
                    {{ $ticket->user->name }}
                </span>
            </div>
            <div class="flex items-center gap-2">
                <x-heroicon-o-calendar class="w-5 h-5 text-gray-400" />
                <span class="text-sm text-gray-600">
                    {{ $ticket->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
    </div>
    
    {{-- Footer --}}
    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <span class="text-sm text-gray-500">
                {{ $ticket->comments_count }} comments
            </span>
            <a href="{{ route('tickets.show', $ticket) }}" 
               class="text-sm font-medium text-primary-600 
                      hover:text-primary-500">
                View details →
            </a>
        </div>
    </div>
</div>
```

### 2.4 Status Badge

```blade
{{-- Status Badges --}}
<span class="inline-flex items-center px-2.5 py-0.5 
             rounded-full text-xs font-medium
             @if($status === 'new')
                 bg-blue-100 text-blue-800
             @elseif($status === 'in_progress')
                 bg-yellow-100 text-yellow-800
             @elseif($status === 'resolved')
                 bg-green-100 text-green-800
             @else
                 bg-gray-100 text-gray-800
             @endif">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
```

### 2.5 Modal Components

#### Base Modal
```blade
<div x-data="{ open: false }">
    {{-- Trigger --}}
    <button @click="open = true" 
            class="inline-flex items-center px-4 py-2 
                   bg-primary-600 text-white rounded-md">
        Open Modal
    </button>
    
    {{-- Modal Overlay --}}
    <div x-show="open" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true">
        
        {{-- Backdrop --}}
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-500 bg-opacity-75 
                    transition-opacity">
        </div>
        
        {{-- Modal Panel --}}
        <div class="flex min-h-full items-center 
                    justify-center p-4 text-center">
            <div x-show="open"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 
                                           translate-y-4 
                                           sm:translate-y-0 
                                           sm:scale-95"
                 x-transition:enter-end="opacity-100 
                                         translate-y-0 
                                         sm:scale-100"
                 class="relative transform overflow-hidden 
                        rounded-lg bg-white text-left 
                        shadow-xl transition-all 
                        sm:my-8 sm:w-full sm:max-w-lg">
                
                {{-- Content --}}
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 
                            sm:pb-4">
                    <h3 class="text-lg font-semibold 
                               text-gray-900" 
                        id="modal-title">
                        Modal Title
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Modal content goes here
                        </p>
                    </div>
                </div>
                
                {{-- Footer --}}
                <div class="bg-gray-50 px-4 py-3 
                            sm:flex sm:flex-row-reverse 
                            sm:px-6">
                    <button type="button" 
                            class="inline-flex w-full justify-center 
                                   rounded-md bg-primary-600 px-3 
                                   py-2 text-sm font-semibold 
                                   text-white shadow-sm 
                                   hover:bg-primary-500 
                                   sm:ml-3 sm:w-auto">
                        Confirm
                    </button>
                    <button type="button" 
                            @click="open = false"
                            class="mt-3 inline-flex w-full 
                                   justify-center rounded-md 
                                   bg-white px-3 py-2 text-sm 
                                   font-semibold text-gray-900 
                                   shadow-sm ring-1 ring-inset 
                                   ring-gray-300 hover:bg-gray-50 
                                   sm:mt-0 sm:w-auto">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
```

---

## 3. Page Layouts

### 3.1 Public Site Layout

```blade
{{-- resources/views/pages/_layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'FixCity' }}</title>
    
    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Flux Styles --}}
    @fluxStyles
    
    {{-- Custom Styles --}}
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    {{-- Header --}}
    <header class="bg-white shadow-sm">
        <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between">
                {{-- Logo --}}
                <div class="flex">
                    <a href="/" class="flex items-center">
                        <img src="/logo.svg" alt="FixCity" 
                             class="h-8 w-auto">
                    </a>
                </div>
                
                {{-- Navigation --}}
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:gap-4">
                    <a href="/" class="text-gray-700 hover:text-primary-600">
                        Home
                    </a>
                    <a href="/tickets" class="text-gray-700 hover:text-primary-600">
                        Tickets
                    </a>
                    <a href="/blog" class="text-gray-700 hover:text-primary-600">
                        Blog
                    </a>
                </div>
                
                {{-- Auth Buttons --}}
                <div class="flex items-center gap-2">
                    @auth
                        <a href="/dashboard" 
                           class="text-gray-700 hover:text-primary-600">
                            Dashboard
                        </a>
                    @else
                        <a href="/login" 
                           class="text-gray-700 hover:text-primary-600">
                            Login
                        </a>
                        <a href="/register" 
                           class="ml-2 inline-flex items-center px-4 py-2 
                                  border border-transparent text-sm 
                                  font-medium rounded-md text-white 
                                  bg-primary-600 hover:bg-primary-700">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>
    
    {{-- Main Content --}}
    <main>
        {{ $slot }}
    </main>
    
    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Company Info --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">
                        FixCity
                    </h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Gestione segnalazioni urbane
                    </p>
                </div>
                
                {{-- Links --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">
                        Links
                    </h3>
                    <ul class="mt-2 space-y-2">
                        <li>
                            <a href="/about" class="text-sm text-gray-600 
                                                    hover:text-primary-600">
                                About
                            </a>
                        </li>
                        <li>
                            <a href="/contact" class="text-sm text-gray-600 
                                                      hover:text-primary-600">
                                Contact
                            </a>
                        </li>
                    </ul>
                </div>
                
                {{-- Legal --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">
                        Legal
                    </h3>
                    <ul class="mt-2 space-y-2">
                        <li>
                            <a href="/privacy" class="text-sm text-gray-600 
                                                      hover:text-primary-600">
                                Privacy
                            </a>
                        </li>
                        <li>
                            <a href="/terms" class="text-sm text-gray-600 
                                                    hover:text-primary-600">
                                Terms
                            </a>
                        </li>
                    </ul>
                </div>
                
                {{-- Social --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-900">
                        Follow Us
                    </h3>
                    <div class="mt-2 flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Facebook</span>
                            <x-heroicon-o-facebook class="w-6 h-6" />
                        </a>
                        <a href="#" class="text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Twitter</span>
                            <x-heroicon-o-twitter class="w-6 h-6" />
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 border-t border-gray-200 pt-8">
                <p class="text-sm text-gray-500 text-center">
                    &copy; {{ date('Y') }} FixCity. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
    
    {{-- Flux Scripts --}}
    @fluxScripts
</body>
</html>
```

### 3.2 Dashboard Layout (Filament)

```php
<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard';
    protected static ?int $navigationSort = 0;
    
    public function getWidgets(): array
    {
        return [
            \Modules\Fixcity\Filament\Widgets\TicketStats::class,
            \Modules\Fixcity\Filament\Widgets\RecentTickets::class,
            \Modules\Activity\Filament\Widgets\ActivityLog::class,
        ];
    }
}
```

---

## 4. Key User Flows

### 4.1 Citizen Ticket Creation Flow

```
┌──────────────────────────────────────────────────────────┐
│              TICKET CREATION FLOW                         │
└──────────────────────────────────────────────────────────┘

Step 1: Landing Page
  ┌─────────────────────────────────┐
  │  Hero Section                   │
  │  "Segnala un problema"          │
  │  [CTA: Crea Segnalazione]       │
  └─────────────────────────────────┘
           │
           ▼
Step 2: Login/Register (if not authenticated)
  ┌─────────────────────────────────┐
  │  Login Form                     │
  │  - Email                        │
  │  - Password                     │
  │  [Login] [Register]             │
  └─────────────────────────────────┘
           │
           ▼
Step 3: Ticket Form
  ┌─────────────────────────────────┐
  │  Create Ticket                  │
  │  ┌─────────────────────────┐   │
  │  │ Title *                 │   │
  │  │ Description *           │   │
  │  │ Category [Select]       │   │
  │  │ Priority [Select]       │   │
  │  │ Location [Map]          │   │
  │  │ Upload Photos           │   │
  │  └─────────────────────────┘   │
  │  [Cancel] [Submit]              │
  └─────────────────────────────────┘
           │
           ▼
Step 4: Confirmation
  ┌─────────────────────────────────┐
  │  ✓ Ticket Created!              │
  │  Ticket #12345                  │
  │  [View Ticket] [Create Another] │
  └─────────────────────────────────┘
```

### 4.2 Operator Resolution Flow

```
┌──────────────────────────────────────────────────────────┐
│              OPERATOR RESOLUTION FLOW                     │
└──────────────────────────────────────────────────────────┘

Step 1: Dashboard
  ┌─────────────────────────────────┐
  │  Dashboard                      │
  │  ┌─────────┐ ┌─────────┐       │
  │  │ New     │ │ In      │       │
  │  │ (5)     │ │ Progress│       │
  │  │         │ │ (12)    │       │
  │  └─────────┘ └─────────┘       │
  └─────────────────────────────────┘
           │
           ▼
Step 2: Ticket List
  ┌─────────────────────────────────┐
  │  Tickets                        │
  │  [Filters] [Search] [Export]    │
  │  ┌───────────────────────────┐  │
  │  │ #12345 - Pothole   [View] │  │
  │  │ #12344 - Broken Light     │  │
  │  │ #12343 - Graffiti         │  │
  │  └───────────────────────────┘  │
  └─────────────────────────────────┘
           │
           ▼
Step 3: Ticket Detail
  ┌─────────────────────────────────┐
  │  Ticket #12345                  │
  │  Status: New                    │
  │  Priority: High                 │
  │  Description: ...               │
  │  Photos: [img1] [img2]          │
  │  Map: [location]                │
  │  ┌─────────────────────────┐   │
  │  │ Action: [Assign to Me]  │   │
  │  │         [Change Status] │   │
  │  │         [Add Comment]   │   │
  │  └─────────────────────────┘   │
  └─────────────────────────────────┘
           │
           ▼
Step 4: Resolution
  ┌─────────────────────────────────┐
  │  Update Ticket                  │
  │  Status: [Resolved ▼]           │
  │  Resolution Notes:              │
  │  [Textarea]                     │
  │  [Submit] [Cancel]              │
  └─────────────────────────────────┘
```

---

## 5. Responsive Design

### 5.1 Breakpoints

```css
/* Mobile First Approach */
/* Base styles apply to mobile */

/* sm: Small devices (tablets) */
@media (min-width: 640px) { }

/* md: Medium devices (laptops) */
@media (min-width: 768px) { }

/* lg: Large devices (desktops) */
@media (min-width: 1024px) { }

/* xl: Extra large devices */
@media (min-width: 1280px) { }

/* 2xl: 2X Extra large devices */
@media (min-width: 1536px) { }
```

### 5.2 Mobile Navigation

```blade
{{-- Mobile Menu Button --}}
<button type="button" 
        @click="mobileMenuOpen = !mobileMenuOpen"
        class="inline-flex items-center justify-center 
               p-2 rounded-md text-gray-700 
               hover:text-primary-600 hover:bg-gray-100 
               focus:outline-none focus:ring-2 
               focus:ring-inset focus:ring-primary-500">
    <span class="sr-only">Open main menu</span>
    <x-heroicon-o-bars-3 class="w-6 h-6" />
</button>

{{-- Mobile Menu Panel --}}
<div x-show="mobileMenuOpen"
     x-cloak
     class="md:hidden">
    <div class="space-y-1 px-2 pb-3 pt-2">
        <a href="/" 
           class="block rounded-md px-3 py-2 
                  text-base font-medium text-gray-700 
                  hover:text-primary-600 hover:bg-gray-50">
            Home
        </a>
        <a href="/tickets" 
           class="block rounded-md px-3 py-2 
                  text-base font-medium text-gray-700 
                  hover:text-primary-600 hover:bg-gray-50">
            Tickets
        </a>
    </div>
</div>
```

---

## 6. Accessibility

### 6.1 ARIA Labels

```blade
{{-- Icon Buttons --}}
<button aria-label="Close modal" 
        class="...">
    <x-heroicon-o-x-mark class="w-6 h-6" />
</button>

{{-- Form Errors --}}
<div role="alert" 
     aria-live="polite"
     class="mt-2 text-sm text-red-600">
    {{ $error }}
</div>

{{-- Loading States --}}
<div role="status" 
     aria-live="polite">
    <span class="sr-only">Loading...</span>
    <svg class="animate-spin ..." />
</div>
```

### 6.2 Focus Management

```blade
{{-- Skip to Content --}}
<a href="#main-content" 
   class="sr-only focus:not-sr-only 
          focus:absolute focus:top-4 
          focus:left-4 focus:z-50 
          focus:px-4 focus:py-2 
          focus:bg-white focus:text-gray-900">
    Skip to main content
</a>

{{-- Main Content --}}
<main id="main-content">
    {{ $slot }}
</main>
```

### 6.3 Color Contrast

Tutti i colori devono rispettare WCAG 2.1 AA:
- **Normal text**: 4.5:1 contrast ratio
- **Large text**: 3:1 contrast ratio
- **UI components**: 3:1 contrast ratio

---

## 7. Animation & Motion

### 7.1 Transition Classes

```blade
{{-- Fade In --}}
<div class="transition-opacity duration-300 ease-in-out 
            opacity-0 hover:opacity-100">
</div>

{{-- Slide Up --}}
<div class="transform transition-transform duration-300 
            translate-y-4 hover:translate-y-0">
</div>

{{-- Scale --}}
<div class="transform transition-transform duration-200 
            scale-95 hover:scale-100">
</div>
```

### 7.2 Loading States

```blade
{{-- Skeleton Loader --}}
<div class="animate-pulse space-y-4">
    <div class="h-4 bg-gray-200 rounded w-3/4"></div>
    <div class="h-4 bg-gray-200 rounded"></div>
    <div class="h-4 bg-gray-200 rounded w-5/6"></div>
</div>

{{-- Spinner --}}
<svg class="animate-spin h-5 w-5 text-primary-600" 
     xmlns="http://www.w3.org/2000/svg" 
     fill="none" 
     viewBox="0 0 24 24">
    <circle class="opacity-25" 
            cx="12" cy="12" r="10" 
            stroke="currentColor" 
            stroke-width="4"></circle>
    <path class="opacity-75" 
          fill="currentColor" 
          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
</svg>
```

---

## 8. Design Tokens (Tailwind Config)

```javascript
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        mono: ['Fira Code', 'monospace'],
      },
      animation: {
        'fade-in': 'fadeIn 0.3s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
        'slide-down': 'slideDown 0.3s ease-out',
        'scale-up': 'scaleUp 0.2s ease-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(1rem)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        slideDown: {
          '0%': { transform: 'translateY(-1rem)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        scaleUp: {
          '0%': { transform: 'scale(0.95)', opacity: '0' },
          '100%': { transform: 'scale(1)', opacity: '1' },
        },
      },
    },
  },
}
```

---

## 9. Component Inventory

### 9.1 Filament Resources

Ogni modulo ha i seguenti resources Filament:

| Module | Resources | Widgets | Actions |
|--------|-----------|---------|---------|
| **Fixcity** | TicketResource, CategoryResource | TicketStats, RecentTickets | AssignTicket, ChangeStatus |
| **User** | UserResource, RoleResource | UserStats, ActiveUsers | CreateUser, AssignRole |
| **Cms** | PageResource, MenuResource | PageViews, TopPages | PublishPage, PreviewPage |
| **Blog** | PostResource, CategoryResource | PostStats, RecentComments | PublishPost, SchedulePost |
| **Geo** | ZoneResource, MapResource | ZoneStats, MapViews | CreateZone, UpdateBounds |
| **Media** | MediaResource, FolderResource | MediaStats, StorageUsage | UploadMedia, CreateFolder |
| **Notify** | TemplateResource, LogResource | NotificationStats, DeliveryRate | SendTest, PreviewTemplate |

### 9.2 Flux UI Components

Componenti Flux UI utilizzati:

- `<flux:button>` - Primary, secondary, danger variants
- `<flux:input>` - Text, email, password, search
- `<flux:select>` - Single/multi select
- `<flux:textarea>` - Rich text editing
- `<flux:file-upload>` - Drag & drop upload
- `<flux:modal>` - Confirmation dialogs
- `<flux:dropdown>` - Menu dropdowns
- `<flux:badge>` - Status indicators
- `<flux:avatar>` - User avatars
- `<flux:table>` - Data tables
- `<flux:card>` - Content containers

---

## 10. UX Metrics & Success Criteria

### 10.1 Usability Metrics

| Metric | Target | Measurement |
|--------|--------|-------------|
| **Task Success Rate** | > 95% | User testing |
| **Time on Task** | < 2 min | Analytics |
| **Error Rate** | < 5% | Error tracking |
| **SUS Score** | > 80 | User surveys |
| **NPS** | > 50 | User feedback |

### 10.2 Accessibility Metrics

| Metric | Target | Standard |
|--------|--------|----------|
| **WCAG Level** | AA | WCAG 2.1 |
| **Color Contrast** | 4.5:1 | WCAG AA |
| **Keyboard Navigation** | 100% | WCAG AA |
| **Screen Reader** | 100% compatible | WCAG AA |

### 10.3 Performance Metrics

| Metric | Target | Tool |
|--------|--------|------|
| **LCP** | < 2.5s | Lighthouse |
| **FID** | < 100ms | Lighthouse |
| **CLS** | < 0.1 | Lighthouse |
| **FCP** | < 1.8s | Lighthouse |

---

## Appendix: Design Resources

### A.1 Figma Files

- **Design System**: [Link to Figma design system]
- **Component Library**: [Link to component library]
- **Page Templates**: [Link to page templates]
- **User Flow Diagrams**: [Link to flow diagrams]

### A.2 Inspiration

- **Tailwind UI**: https://tailwindui.com
- **Filament Components**: https://filamentphp.com
- **Flux UI**: https://fluxui.co
- **Heroicons**: https://heroicons.com

### A.3 Tools

- **Figma**: Design & prototyping
- **Tailwind CSS**: Utility-first CSS
- **Alpine.js**: Lightweight JavaScript
- **Lighthouse**: Performance auditing

---

**Document Status:** ✅ Complete

**Next Steps:**
1. ✅ UX Design specifications created
2. ⏳ Epics and stories breakdown (next)
3. ⏳ Sprint planning
