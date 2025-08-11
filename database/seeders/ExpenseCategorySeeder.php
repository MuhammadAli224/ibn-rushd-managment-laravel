<?php

namespace Database\Seeders;

use App\Models\Center;
use App\Models\ExpenseCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $center = Center::first();

        $user = User::first();
          $categories = [
            [
                'name' => 'المواد التعليمية',
                'description' => 'شراء الكتب والمواد التعليمية للمركز',
            ],
            [
                'name' => 'مرتبات الموظفين',
                'description' => 'الرواتب والأجور الشهرية للعاملين',
            ],
            [
                'name' => 'الصيانة والنظافة',
                'description' => 'تكاليف صيانة المبنى والنظافة',
            ],
            [
                'name' => 'المرافق والخدمات',
                'description' => 'تكاليف الكهرباء، المياه، والإنترنت',
            ],
            [
                'name' => 'التسويق والإعلان',
                'description' => 'حملات التسويق والإعلانات للمركز',
            ],
            [
                'name' => 'المستلزمات المكتبية',
                'description' => 'شراء الأدوات المكتبية واللوازم',
            ],
            [
                'name' => 'المواصلات',
                'description' => 'تكاليف نقل الموظفين أو الطلاب',
            ],
             [
                'name' => 'التدريب والتطوير',
                'description' => 'تكاليف الدورات وورش العمل للموظفين',
            ],
            [
                'name' => 'البرمجيات والتراخيص',
                'description' => 'شراء تراخيص البرامج والخدمات التقنية',
            ],
            [
                'name' => 'الأنشطة والفعاليات',
                'description' => 'تكاليف تنظيم الأنشطة والفعاليات الخاصة بالمركز',
            ],
            [
                'name' => 'التأمينات',
                'description' => 'تكاليف التأمين على المبنى أو العاملين',
            ],
            [
                'name' => 'المستلزمات الطبية',
                'description' => 'شراء الأدوية والمستلزمات الطبية إن وجدت',
            ],
            [
                'name' => 'الإيجار',
                'description' => 'تكاليف إيجار المباني والمرافق',
            ],
            [
                'name' => 'الضرائب والرسوم',
                'description' => 'الضرائب والرسوم الحكومية المتعلقة بالمركز',
            ],
            [
                'name' => 'المصاريف الطارئة',
                'description' => 'مصاريف غير متوقعة أو طارئة',
            ],
            [
                'name' => 'المواد الغذائية',
                'description' => 'شراء المواد الغذائية للموظفين أو الطلاب',
            ],
            [
                'name' => 'الترفيه والأنشطة الاجتماعية',
                'description' => 'تكاليف الأنشطة الترفيهية والاجتماعية للموظفين أو الطلاب',
            ],
            [
                'name' => 'المصاريف القانونية',
                'description' => 'تكاليف الاستشارات القانونية أو القضايا',
            ],
            [
                'name' => 'المصاريف البنكية',
                'description' => 'الرسوم البنكية أو تكاليف المعاملات المالية',
            ],
            [
                'name' => 'المصاريف البيئية',
                'description' => 'تكاليف الحفاظ على البيئة أو التبرعات البيئية',
            ],
            [
                'name' => 'المصاريف الثقافية',
                'description' => 'تكاليف الأنشطة الثقافية أو الفنون',
            ],
        ];

        foreach ($categories as $category) {
            ExpenseCategory::updateOrCreate(
                [
                    'name' => $category['name'],
                    'center_id' => $center->id,
                ],
                [
                    'description' => $category['description'],
                    'created_by' => $user?->id,
                    'updated_by' => $user?->id,
                ]
            );
        }
    }
}
