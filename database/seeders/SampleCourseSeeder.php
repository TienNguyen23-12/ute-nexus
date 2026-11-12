<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\CohortModerationStatus;
use App\Enums\CohortStatus;
use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use App\Enums\LessonStatus;
use App\Enums\LessonType;
use App\Enums\QuestionType;
use App\Enums\ShowScoreType;
use App\Enums\Visibility;
use App\Models\Category;
use App\Models\Cohort;
use App\Models\CohortSchedule;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Section;
use App\Models\User;
use Illuminate\Database\Seeder;

class SampleCourseSeeder extends Seeder
{
    public function run(): void
    {
        $instructor = User::where('username', 'instructor')->first();
        if ($instructor === null) {
            return;
        }

        $webCategory = Category::where('slug', 'lap-trinh-web-backend')->first();
        $ojCategory = Category::where('slug', 'luyen-thi-thuat-toan-oj')->first();

        $this->seedWebCourse($instructor, $webCategory);
        $this->seedJavaCourse($instructor, $webCategory);
        $this->seedOjCourse($instructor, $ojCategory);
    }

    private function seedWebCourse(User $instructor, ?Category $category): void
    {
        $course = Course::updateOrCreate(
            ['slug' => 'lap-trinh-web-co-ban'],
            [
                'code' => 'CS-WEB-01',
                'title' => 'Lập trình Web Cơ bản đến Chuyên sâu (HTML/CSS, JS, Node.js)',
                'headline' => 'Lộ trình toàn diện từ số 0 trở thành Web Developer với HTML5, CSS3, JavaScript ES6+ và Backend Node.js Express.',
                'description' => 'Khóa học được thiết kế theo cấu trúc module hóa linh hoạt. Học viên có thể đăng ký trọn bộ khóa học để nhận ưu đãi hoặc lựa chọn mua lẻ từng module theo nhu cầu bổ trợ kiến thức.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800&auto=format&fit=crop&q=80',
                'level' => CourseLevel::BEGINNER,
                'status' => CourseStatus::PUBLISHED,
                'price' => '699000.00',
                'category_id' => $category?->id,
                'created_by' => $instructor->id,
                'objectives' => [
                    'Thành thạo xây dựng giao diện chuẩn responsive với HTML5 và CSS3',
                    'Làm chủ JavaScript hiện đại, lập trình bất đồng bộ và tương tác DOM',
                    'Xây dựng hệ thống RESTful API hoàn chỉnh với Node.js, Express và PostgreSQL',
                ],
                'requirements' => [
                    'Máy tính cá nhân có kết nối Internet',
                    'Không yêu cầu kiến thức lập trình trước đó',
                ],
            ]
        );

        $modules = [
            [
                'code' => 'MOD-WEB-01',
                'name' => 'Nền tảng Web với HTML5, CSS3 & Responsive Design',
                'price' => '250000.00',
                'order_index' => 1,
                'section_title' => 'Chương 1: Nhập môn Giao diện Web với HTML5 & CSS3',
                'lessons' => [
                    [
                        'title' => '1.1 Kiến trúc Web và Cấu trúc chuẩn của một trang HTML5',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 1,
                        'is_free_preview' => true,
                        'video_url' => 'https://www.youtube.com/watch?v=kUMe1FH4CHE',
                        'duration_seconds' => 900,
                        'document_content' => 'Bài học giới thiệu mô hình Client - Server, vai trò của HTML/CSS/JS và cấu trúc file index.html semantic.',
                    ],
                    [
                        'title' => '1.2 Bố cục linh hoạt với CSS Flexbox và Responsive Media Query',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 2,
                        'is_free_preview' => false,
                        'video_url' => 'https://www.youtube.com/watch?v=JJSoEo8JSnc',
                        'duration_seconds' => 1200,
                        'document_content' => 'Nắm vững main axis, cross axis, justify-content, align-items và media query.',
                    ],
                    [
                        'title' => '1.3 Tài liệu & Thực hành thiết kế Landing Page hoàn chỉnh',
                        'lesson_type' => LessonType::DOCUMENT,
                        'order_index' => 3,
                        'is_free_preview' => false,
                        'video_url' => null,
                        'duration_seconds' => 0,
                        'document_content' => 'Hướng dẫn từng bước thực hành dự án Landing Page giới thiệu sản phẩm.',
                    ],
                ],
            ],
            [
                'code' => 'MOD-WEB-02',
                'name' => 'Lập trình JavaScript Hiện đại & DOM Manipulation',
                'price' => '300000.00',
                'order_index' => 2,
                'section_title' => 'Chương 2: Lập trình JavaScript Cốt lõi & Xử lý Sự kiện',
                'lessons' => [
                    [
                        'title' => '2.1 Cú pháp JavaScript Hiện đại: ES6+, Arrow Function & Destructuring',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 1,
                        'is_free_preview' => false,
                        'video_url' => 'https://www.youtube.com/watch?v=W6NZfCO5SIk',
                        'duration_seconds' => 1100,
                        'document_content' => 'Tìm hiểu let/const, template literals, destructuring assignment và spread/rest.',
                    ],
                    [
                        'title' => '2.2 Tương tác DOM, Bắt sự kiện và Xử lý Form động',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 2,
                        'is_free_preview' => false,
                        'video_url' => 'https://www.youtube.com/watch?v=0ik6X4DJKCc',
                        'duration_seconds' => 1300,
                        'document_content' => 'Thao tác với document.querySelector, addEventListener và validate form.',
                    ],
                ],
            ],
            [
                'code' => 'MOD-WEB-03',
                'name' => 'Lập trình Backend RESTful API với Node.js & Express',
                'price' => '350000.00',
                'order_index' => 3,
                'section_title' => 'Chương 3: Xây dựng RESTful API Backend với Node.js',
                'lessons' => [
                    [
                        'title' => '3.1 Khởi tạo Node.js Project & Thiết kế RESTful API với Express.js',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 1,
                        'is_free_preview' => false,
                        'video_url' => 'https://www.youtube.com/watch?v=f2EqECiTBL8',
                        'duration_seconds' => 1500,
                        'document_content' => 'Tạo server HTTP với Express, middleware và routing GET/POST/PUT/DELETE.',
                    ],
                    [
                        'title' => '3.2 Kết nối PostgreSQL và Bảo mật Xác thực qua JWT',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 2,
                        'is_free_preview' => false,
                        'video_url' => 'https://www.youtube.com/watch?v=mbsmsi7l3r4',
                        'duration_seconds' => 1800,
                        'document_content' => 'Truy vấn dữ liệu PostgreSQL, mã hóa mật khẩu bcrypt và phát hành token JWT.',
                    ],
                ],
            ],
        ];

        $this->seedModulesForCourse($course, $instructor, $modules, 50);
    }

    private function seedJavaCourse(User $instructor, ?Category $category): void
    {
        $course = Course::updateOrCreate(
            ['slug' => 'java-spring-boot-doanh-nghiep'],
            [
                'code' => 'CS-JAVA-01',
                'title' => 'Kiến Trúc Java Backend & Spring Boot Doanh Nghiệp',
                'headline' => 'Xây dựng các hệ thống Enterprise quy mô lớn với Java 21, Spring Boot 3, Spring Data JPA và Security.',
                'description' => 'Lộ trình đào tạo kỹ sư backend chuyên nghiệp theo tiêu chuẩn doanh nghiệp gồm Java OOP nâng cao, REST API với JPA và Spring Security JWT.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=800&auto=format&fit=crop&q=80',
                'level' => CourseLevel::INTERMEDIATE,
                'status' => CourseStatus::PUBLISHED,
                'price' => '990000.00',
                'category_id' => $category?->id,
                'created_by' => $instructor->id,
                'objectives' => [
                    'Thành thạo Java Core và 4 tính chất OOP chuyên sâu',
                    'Thiết kế REST API chuẩn kiến trúc phân tầng với Spring Boot',
                    'Bảo mật hệ thống đa vai trò với Spring Security và JWT',
                ],
                'requirements' => [
                    'Đã có kiến thức lập trình cơ bản về biến, vòng lặp, hàm',
                    'Cài đặt sẵn JDK 17/21 và IDE',
                ],
            ]
        );

        $modules = [
            [
                'code' => 'MOD-JAVA-01',
                'name' => 'Java Core & Lập trình Hướng đối tượng OOP Chuyên sâu',
                'price' => '290000.00',
                'order_index' => 1,
                'section_title' => 'Chương 1: Java Core, OOP & Collections Framework',
                'lessons' => [
                    [
                        'title' => '1.1 4 Trụ cột Lập trình Hướng đối tượng và Design Patterns cơ bản',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 1,
                        'is_free_preview' => true,
                        'video_url' => 'https://www.youtube.com/watch?v=eIrMbAQSU34',
                        'duration_seconds' => 1200,
                        'document_content' => 'Phân tích Encapsulation, Inheritance, Polymorphism, Abstraction và Factory/Singleton pattern.',
                    ],
                    [
                        'title' => '1.2 Làm chủ Java Collections, Generics và Stream API',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 2,
                        'is_free_preview' => false,
                        'video_url' => 'https://www.youtube.com/watch?v=1opIas94CJM',
                        'duration_seconds' => 1400,
                        'document_content' => 'Tối ưu hóa thao tác dữ liệu với List, Set, Map, Lambda và Stream API.',
                    ],
                ],
            ],
            [
                'code' => 'MOD-JAVA-02',
                'name' => 'Xây dựng REST API Doanh nghiệp với Spring Boot & JPA',
                'price' => '450000.00',
                'order_index' => 2,
                'section_title' => 'Chương 2: Spring Boot Architecture & Spring Data JPA',
                'lessons' => [
                    [
                        'title' => '2.1 Dependency Injection & Kiến trúc đa tầng',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 1,
                        'is_free_preview' => false,
                        'video_url' => 'https://www.youtube.com/watch?v=9SGDpanrc8U',
                        'duration_seconds' => 1600,
                        'document_content' => 'Cơ chế Inversion of Control, Controller - Service - Repository và xử lý ngoại lệ.',
                    ],
                    [
                        'title' => '2.2 Tương tác Cơ sở dữ liệu với Spring Data JPA & Transaction',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 2,
                        'is_free_preview' => false,
                        'video_url' => 'https://www.youtube.com/watch?v=8SGI_XS5OPw',
                        'duration_seconds' => 1800,
                        'document_content' => 'Định nghĩa Entity, quan hệ JPA và quản lý giao dịch @Transactional.',
                    ],
                ],
            ],
            [
                'code' => 'MOD-JAVA-03',
                'name' => 'Bảo mật Hệ thống với Spring Security & JWT',
                'price' => '490000.00',
                'order_index' => 3,
                'section_title' => 'Chương 3: Bảo mật Phân quyền với Spring Security',
                'lessons' => [
                    [
                        'title' => '3.1 Cơ chế Filter Chain và Cấu hình Spring Security 6',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 1,
                        'is_free_preview' => false,
                        'video_url' => 'https://www.youtube.com/watch?v=her_7pa0vrg',
                        'duration_seconds' => 1900,
                        'document_content' => 'Kiến trúc SecurityFilterChain, UserDetailsService và bảo vệ route nhạy cảm.',
                    ],
                ],
            ],
        ];

        $createdCohorts = $this->seedModulesForCourse($course, $instructor, $modules, 60);
        if (isset($createdCohorts['MOD-JAVA-01'])) {
            $this->seedSampleQuiz($createdCohorts['MOD-JAVA-01']);
        }
    }

    private function seedOjCourse(User $instructor, ?Category $category): void
    {
        $course = Course::updateOrCreate(
            ['slug' => 'luyen-thi-thuat-toan-oj'],
            [
                'code' => 'CS-OJ-01',
                'title' => 'Luyện Thi Thuật Toán & Cấu Trúc Dữ Liệu Online Judge',
                'headline' => 'Rèn luyện tư duy giải thuật đỉnh cao, chinh phục các bài toán khó trên hệ thống Online Judge.',
                'description' => 'Khóa học tập trung giải quyết các bài toán lập trình thi đấu và phỏng vấn kỹ thuật gồm Giải thuật nền tảng và Cấu trúc dữ liệu nâng cao.',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&auto=format&fit=crop&q=80',
                'level' => CourseLevel::ADVANCED,
                'status' => CourseStatus::PUBLISHED,
                'price' => '450000.00',
                'category_id' => $category?->id,
                'created_by' => $instructor->id,
                'objectives' => [
                    'Làm chủ kỹ thuật phân tích độ phức tạp thời gian & không gian Big O',
                    'Thuần thục Two Pointers, Binary Search, Prefix Sum',
                    'Chinh phục các bài toán đồ thị BFS, DFS và quy hoạch động',
                ],
                'requirements' => [
                    'Nắm vững một ngôn ngữ lập trình (C++, Java hoặc Python)',
                ],
            ]
        );

        $modules = [
            [
                'code' => 'MOD-OJ-01',
                'name' => 'Giải thuật Cơ bản, Hai con trỏ & Đệ quy Quay lui',
                'price' => '199000.00',
                'order_index' => 1,
                'section_title' => 'Chương 1: Phân tích Độ phức tạp & Kỹ thuật Hai con trỏ',
                'lessons' => [
                    [
                        'title' => '1.1 Độ phức tạp thuật toán Big O & Tư duy tối ưu bộ nhớ',
                        'lesson_type' => LessonType::DOCUMENT,
                        'order_index' => 1,
                        'is_free_preview' => true,
                        'video_url' => null,
                        'duration_seconds' => 0,
                        'document_content' => 'Tài liệu phân tích cận trên Big O, cận dưới Big Omega và đánh giá số phép toán.',
                    ],
                    [
                        'title' => '1.2 Kỹ thuật Hai con trỏ (Two Pointers) & Cửa sổ trượt',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 2,
                        'is_free_preview' => false,
                        'video_url' => 'https://www.youtube.com/watch?v=On03HWe2tZM',
                        'duration_seconds' => 1500,
                        'document_content' => 'Áp dụng Two Pointers giải quyết bài toán mảng sắp xếp trong O(N).',
                    ],
                ],
            ],
            [
                'code' => 'MOD-OJ-02',
                'name' => 'Cấu trúc Dữ liệu Nâng cao & Quy hoạch Động',
                'price' => '349000.00',
                'order_index' => 2,
                'section_title' => 'Chương 2: Cây, Đồ thị và Quy hoạch Động',
                'lessons' => [
                    [
                        'title' => '2.1 Duyệt đồ thị theo chiều rộng (BFS) và chiều sâu (DFS)',
                        'lesson_type' => LessonType::VIDEO,
                        'order_index' => 1,
                        'is_free_preview' => false,
                        'video_url' => 'https://www.youtube.com/watch?v=TIbUeeksXcI',
                        'duration_seconds' => 1700,
                        'document_content' => 'Cài đặt danh sách kề, tìm đường đi ngắn nhất trên đồ thị không trọng số.',
                    ],
                ],
            ],
        ];

        $this->seedModulesForCourse($course, $instructor, $modules, 50);
    }

    private function seedModulesForCourse(Course $course, User $instructor, array $modules, int $capacity): array
    {
        $cohortsByCode = [];

        foreach ($modules as $module) {
            $cohort = Cohort::updateOrCreate(
                ['code' => $module['code']],
                [
                    'course_id' => $course->id,
                    'created_by' => $instructor->id,
                    'name' => $module['name'],
                    'enrollment_start' => now()->subDays(10),
                    'enrollment_end' => now()->addDays(60),
                    'study_start' => now()->subDays(5),
                    'study_end' => now()->addDays(120),
                    'max_capacity' => $capacity,
                    'price' => $module['price'],
                    'status' => CohortStatus::ENROLLING,
                    'moderation_status' => CohortModerationStatus::APPROVED,
                    'visibility' => Visibility::PUBLIC,
                    'order_index' => $module['order_index'],
                ]
            );

            $cohortsByCode[$module['code']] = $cohort;

            $section = Section::firstOrCreate(
                ['course_id' => $course->id, 'order_index' => $module['order_index']],
                ['cohort_id' => $cohort->id, 'title' => $module['section_title']]
            );

            foreach ($module['lessons'] as $lessonData) {
                $lesson = Lesson::firstOrCreate(
                    ['section_id' => $section->id, 'order_index' => $lessonData['order_index']],
                    [
                        'title' => $lessonData['title'],
                        'lesson_type' => $lessonData['lesson_type'],
                        'is_free_preview' => $lessonData['is_free_preview'],
                        'video_url' => $lessonData['video_url'],
                        'duration_seconds' => $lessonData['duration_seconds'],
                        'document_content' => $lessonData['document_content'],
                        'is_public_for_cohorts' => true,
                        'status' => LessonStatus::PUBLISHED,
                    ]
                );

                CohortSchedule::firstOrCreate(
                    ['cohort_id' => $cohort->id, 'lesson_id' => $lesson->id],
                    [
                        'unlock_at' => now()->subDays(5),
                        'show_score_type' => ShowScoreType::IMMEDIATELY,
                        'is_score_published' => true,
                        'allow_review_answers' => true,
                    ]
                );
            }
        }

        return $cohortsByCode;
    }

    private function seedSampleQuiz(Cohort $cohort): void
    {
        $section = $cohort->sections()->first();
        if ($section === null) {
            return;
        }

        $quizLesson = Lesson::firstOrCreate(
            ['section_id' => $section->id, 'order_index' => 99],
            [
                'title' => 'Bài kiểm tra Đánh giá Năng lực OOP & Java Core',
                'lesson_type' => LessonType::QUIZ,
                'is_free_preview' => false,
                'is_public_for_cohorts' => true,
                'status' => LessonStatus::PUBLISHED,
            ]
        );

        CohortSchedule::firstOrCreate(
            ['cohort_id' => $cohort->id, 'lesson_id' => $quizLesson->id],
            [
                'unlock_at' => now(),
                'show_score_type' => ShowScoreType::IMMEDIATELY,
                'is_score_published' => true,
                'allow_review_answers' => true,
            ]
        );

        $quiz = Quiz::firstOrCreate(
            ['lesson_id' => $quizLesson->id],
            [
                'title' => 'Bài kiểm tra Đánh giá Năng lực OOP & Java Core',
                'duration_minutes' => 15,
                'passing_score' => '5.00',
                'max_attempts' => 3,
                'shuffle_questions' => true,
                'allow_review' => true,
            ]
        );

        $questions = [
            [
                'order_index' => 1,
                'question_type' => QuestionType::SINGLE_CHOICE,
                'content' => 'Trong ngôn ngữ Java, từ khóa nào được sử dụng để một lớp kế thừa từ một lớp cha?',
                'points' => '2.50',
                'explanation' => "Từ khóa 'extends' dùng để kế thừa class, còn 'implements' dùng để triển khai interface.",
                'options' => [
                    ['id' => 'opt_1', 'text' => 'extends', 'isCorrect' => true],
                    ['id' => 'opt_2', 'text' => 'implements', 'isCorrect' => false],
                    ['id' => 'opt_3', 'text' => 'inherits', 'isCorrect' => false],
                    ['id' => 'opt_4', 'text' => 'super', 'isCorrect' => false],
                ],
            ],
            [
                'order_index' => 2,
                'question_type' => QuestionType::MULTI_SELECT,
                'content' => 'Những tính chất nào sau đây là các trụ cột cốt lõi của Lập trình Hướng đối tượng (OOP)?',
                'points' => '2.50',
                'explanation' => '4 tính chất cốt lõi của OOP gồm: Đóng gói, Kế thừa, Đa hình và Trừu tượng.',
                'options' => [
                    ['id' => 'opt_1', 'text' => 'Đóng gói (Encapsulation)', 'isCorrect' => true],
                    ['id' => 'opt_2', 'text' => 'Kế thừa (Inheritance)', 'isCorrect' => true],
                    ['id' => 'opt_3', 'text' => 'Đa hình (Polymorphism)', 'isCorrect' => true],
                    ['id' => 'opt_4', 'text' => 'Đồng quy đa luồng (Concurrency)', 'isCorrect' => false],
                ],
            ],
            [
                'order_index' => 3,
                'question_type' => QuestionType::TRUE_FALSE,
                'content' => 'Trong Java, một lớp có thể cùng lúc kế thừa trực tiếp từ nhiều lớp cha khác nhau.',
                'points' => '2.50',
                'explanation' => 'Java không hỗ trợ đa kế thừa trực tiếp giữa các class để tránh Diamond Problem.',
                'options' => [
                    ['id' => 'opt_1', 'text' => 'Đúng', 'isCorrect' => false],
                    ['id' => 'opt_2', 'text' => 'Sai', 'isCorrect' => true],
                ],
            ],
            [
                'order_index' => 4,
                'question_type' => QuestionType::FILL_BLANK,
                'content' => 'Môi trường thực thi của Java chịu trách nhiệm nạp bytecode và chuyển đổi thành mã máy gọi tắt là gì?',
                'points' => '2.50',
                'explanation' => 'JVM viết tắt của Java Virtual Machine (Máy ảo Java).',
                'options' => [
                    ['id' => 'opt_1', 'text' => 'JVM', 'isCorrect' => true],
                    ['id' => 'opt_2', 'text' => 'Java Virtual Machine', 'isCorrect' => true],
                ],
            ],
        ];

        foreach ($questions as $q) {
            Question::firstOrCreate(
                ['quiz_id' => $quiz->id, 'order_index' => $q['order_index']],
                [
                    'content' => $q['content'],
                    'question_type' => $q['question_type'],
                    'points' => $q['points'],
                    'explanation' => $q['explanation'],
                    'options' => $q['options'],
                ]
            );
        }
    }
}
