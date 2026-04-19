<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectCategory;

class ProjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_en' => 'Information Technology',
                'name_ar' => 'تقنية المعلومات',
                'slug' => 'information-technology',
                'deck_theme' => 'it-modern',
                'accent_color' => '#2563EB',
                'icon' => 'fas fa-laptop-code',
            ],
            [
                'name_en' => 'Software Engineering',
                'name_ar' => 'هندسة البرمجيات',
                'slug' => 'software-engineering',
                'deck_theme' => 'software-clean',
                'accent_color' => '#0F62FE',
                'icon' => 'fas fa-code',
            ],
            [
                'name_en' => 'Artificial Intelligence & Machine Learning',
                'name_ar' => 'الذكاء الاصطناعي وتعلم الآلة',
                'slug' => 'artificial-intelligence-machine-learning',
                'deck_theme' => 'ai-future',
                'accent_color' => '#7C3AED',
                'icon' => 'fas fa-brain',
            ],
            [
                'name_en' => 'Medical / Health',
                'name_ar' => 'الطب / الصحة',
                'slug' => 'medical-health',
                'deck_theme' => 'medical-clean',
                'accent_color' => '#DC2626',
                'icon' => 'fas fa-heartbeat',
            ],
            [
                'name_en' => 'Electrical Engineering',
                'name_ar' => 'الهندسة الكهربائية',
                'slug' => 'electrical-engineering',
                'deck_theme' => 'electrical-power',
                'accent_color' => '#F59E0B',
                'icon' => 'fas fa-bolt',
            ],
            [
                'name_en' => 'Renewable Energy',
                'name_ar' => 'الطاقة المتجددة',
                'slug' => 'renewable-energy',
                'deck_theme' => 'green-energy',
                'accent_color' => '#16A34A',
                'icon' => 'fas fa-leaf',
            ],
            [
                'name_en' => 'Agriculture',
                'name_ar' => 'الزراعة',
                'slug' => 'agriculture',
                'deck_theme' => 'agri-growth',
                'accent_color' => '#65A30D',
                'icon' => 'fas fa-seedling',
            ],
            [
                'name_en' => 'Education',
                'name_ar' => 'التعليم',
                'slug' => 'education',
                'deck_theme' => 'education-bright',
                'accent_color' => '#0284C7',
                'icon' => 'fas fa-book-open',
            ],
            [
                'name_en' => 'Business / Management',
                'name_ar' => 'الأعمال / الإدارة',
                'slug' => 'business-management',
                'deck_theme' => 'business-corporate',
                'accent_color' => '#1D4ED8',
                'icon' => 'fas fa-briefcase',
            ],
            [
                'name_en' => 'Other',
                'name_ar' => 'أخرى',
                'slug' => 'other',
                'deck_theme' => 'default',
                'accent_color' => '#6B7280',
                'icon' => 'fas fa-folder-open',
            ],
        ];

        foreach ($categories as $category) {
            ProjectCategory::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}