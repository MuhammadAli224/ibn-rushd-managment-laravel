<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'name' => [
                    'en' => 'Mathematics',
                    'ar' => 'الرياضيات',
                ],
                'description' => [
                    'en' => 'The study of numbers and equations.',
                    'ar' => 'دراسة الأرقام والمعادلات.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Physics',
                    'ar' => 'الفيزياء',
                ],
                'description' => [
                    'en' => 'The study of matter and energy.',
                    'ar' => 'دراسة المادة والطاقة.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Chemistry',
                    'ar' => 'الكيمياء',
                ],
                'description' => [
                    'en' => 'The science of substances and reactions.',
                    'ar' => 'علم المواد والتفاعلات.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Biology',
                    'ar' => 'الأحياء',
                ],
                'description' => [
                    'en' => 'The study of living organisms.',
                    'ar' => 'دراسة الكائنات الحية.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'English',
                    'ar' => 'اللغة الإنجليزية',
                ],
                'description' => [
                    'en' => 'Language and literature studies.',
                    'ar' => 'دراسات اللغة والأدب.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Arabic',
                    'ar' => 'اللغة العربية',
                ],
                'description' => [
                    'en' => 'Arabic language and grammar.',
                    'ar' => 'اللغة العربية والنحو.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Computer Science',
                    'ar' => 'علوم الحاسوب',
                ],
                'description' => [
                    'en' => 'The study of computing and programming.',
                    'ar' => 'دراسة الحوسبة والبرمجة.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Geography',
                    'ar' => 'الجغرافيا',
                ],
                'description' => [
                    'en' => 'The study of Earth and its features.',
                    'ar' => 'دراسة الأرض وخصائصها.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'History',
                    'ar' => 'التاريخ',
                ],
                'description' => [
                    'en' => 'The study of past events.',
                    'ar' => 'دراسة الأحداث الماضية.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Philosophy',
                    'ar' => 'الفلسفة',
                ],
                'description' => [
                    'en' => 'The study of fundamental nature of knowledge and existence.',
                    'ar' => 'دراسة طبيعة المعرفة والوجود.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Psychology',
                    'ar' => 'علم النفس',
                ],
                'description' => [
                    'en' => 'The study of human behavior and mind.',
                    'ar' => 'دراسة السلوك البشري والعقل.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Economics',
                    'ar' => 'الاقتصاد',
                ],
                'description' => [
                    'en' => 'The study of production and consumption of goods.',
                    'ar' => 'دراسة إنتاج واستهلاك السلع.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Religious Studies',
                    'ar' => 'الدراسات الدينية',
                ],
                'description' => [
                    'en' => 'Study of religions, beliefs, and practices.',
                    'ar' => 'دراسة الأديان والمعتقدات والممارسات.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Physical Education',
                    'ar' => 'التربية البدنية',
                ],
                'description' => [
                    'en' => 'Promotes physical fitness and health.',
                    'ar' => 'تعزيز اللياقة البدنية والصحة.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Art',
                    'ar' => 'الفنون',
                ],
                'description' => [
                    'en' => 'The expression of creativity through various forms.',
                    'ar' => 'التعبير عن الإبداع بأشكال مختلفة.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Music',
                    'ar' => 'الموسيقى',
                ],
                'description' => [
                    'en' => 'The art of arranging sounds in time.',
                    'ar' => 'فن تنظيم الأصوات على مدار الزمن.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Technology',
                    'ar' => 'التكنولوجيا',
                ],
                'description' => [
                    'en' => 'Application of scientific knowledge for practical purposes.',
                    'ar' => 'تطبيق المعرفة العلمية لأغراض عملية.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Business Studies',
                    'ar' => 'دراسات الأعمال',
                ],
                'description' => [
                    'en' => 'Understanding how businesses operate and manage.',
                    'ar' => 'فهم كيفية تشغيل وإدارة الأعمال.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Environmental Science',
                    'ar' => 'العلوم البيئية',
                ],
                'description' => [
                    'en' => 'Study of the environment and solutions to environmental problems.',
                    'ar' => 'دراسة البيئة وحلول المشاكل البيئية.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Civics',
                    'ar' => 'التربية الوطنية',
                ],
                'description' => [
                    'en' => 'Study of the rights and duties of citizenship.',
                    'ar' => 'دراسة حقوق وواجبات المواطنة.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Ethics',
                    'ar' => 'الأخلاق',
                ],
                'description' => [
                    'en' => 'Study of moral principles and decision-making.',
                    'ar' => 'دراسة المبادئ الأخلاقية واتخاذ القرارات.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Drama',
                    'ar' => 'التمثيل المسرحي',
                ],
                'description' => [
                    'en' => 'The art of performing in plays and productions.',
                    'ar' => 'فن الأداء في المسرحيات والعروض.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Computer Science',
                    'ar' => 'علوم الحاسوب',
                ],
                'description' => [
                    'en' => 'Study of computing, programming, and information systems.',
                    'ar' => 'دراسة الحوسبة والبرمجة وأنظمة المعلومات.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Media Studies',
                    'ar' => 'دراسات الإعلام',
                ],
                'description' => [
                    'en' => 'Study of communication and media platforms.',
                    'ar' => 'دراسة وسائل الإعلام والتواصل.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Law',
                    'ar' => 'القانون',
                ],
                'description' => [
                    'en' => 'Study of legal systems and regulations.',
                    'ar' => 'دراسة الأنظمة والقوانين القانونية.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Architecture',
                    'ar' => 'الهندسة المعمارية',
                ],
                'description' => [
                    'en' => 'Design and construction of buildings and spaces.',
                    'ar' => 'تصميم وبناء المباني والمساحات.',
                ],
                'center_id' => 1,
            ],
            [
                'name' => [
                    'en' => 'Astronomy',
                    'ar' => 'علم الفلك',
                ],
                'description' => [
                    'en' => 'Study of celestial objects and the universe.',
                    'ar' => 'دراسة الأجرام السماوية والكون.',
                ],
                'center_id' => 1,
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
