<?php

namespace App\Filament\Resources;

use App\Enums\LessonStatusEnum;
use App\Enums\RoleEnum;
use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\Driver;
use App\Models\Lesson;
use App\Models\Teacher;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    public static function getModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.lesson');
    }
    public static function getPluralModelLabel(): string
    {
        return  __('filament-panels::pages/dashboard.lessons');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->columns(3)
                    ->schema([
                        Hidden::make("center_id")
                            ->default(\auth()->user()->center->id),

                        Select::make('subject_id')
                            ->label(__('filament-panels::pages/dashboard.subject'))
                            ->relationship('subject', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive(),

                        Select::make('teacher_id')
                            ->label(__('filament-panels::pages/dashboard.teacher'))
                            // ->options(

                            //     function (callable $get) {
                            //         $subjectId = $get('subject_id');

                            //         if (!$subjectId) {
                            //             return Teacher::whereHas(
                            //                 'user.roles',
                            //                 fn($q) =>
                            //                 $q->where('name', RoleEnum::TEACHER->value)
                            //             )->with('user')->get()->pluck('user.name', 'id');
                            //         }

                            //         return Teacher::whereHas(
                            //             'user.roles',
                            //             fn($q) =>
                            //             $q->where('name', RoleEnum::TEACHER->value)
                            //         )
                            //             ->whereHas(
                            //                 'subjects',
                            //                 fn($query) =>
                            //                 $query->where('subjects.id', $subjectId)
                            //             )
                            //             ->with('user')
                            //             ->get()
                            //             ->pluck('user.name', 'id');
                            //     }
                            // )
                            ->options(fn(callable $get) => Teacher::query()
                                ->when(
                                    $get('subject_id'),
                                    fn($q, $subjectId) =>
                                    $q->whereHas('subjects', fn($subQ) => $subQ->where('subjects.id', $subjectId))
                                )
                                ->whereHas('user.roles', fn($q) => $q->where('name', RoleEnum::TEACHER->value))
                                ->with('user')
                                ->get()
                                ->pluck('user.name', 'id'))
                            ->afterStateUpdated(
                                fn($state, $set) =>
                                optional(Teacher::find($state), fn($teacher) =>
                                $set('commission_rate', $teacher->commission))
                            )
                            ->required()
                            ->preload()
                            ->reactive(),

                        Select::make('student_id')
                            ->label(__('filament-panels::pages/dashboard.student'))
                            ->relationship('student', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->afterStateUpdated(
                                fn($state, $set) =>
                                optional(\App\Models\Student::find($state), fn($student) =>
                                $set('lesson_location', $student->address))
                            )
                            ->reactive(),

                        Select::make('driver_id')
                            ->label(__('filament-panels::pages/dashboard.driver'))
                           
                            ->searchable()
                            ->options(
                                Driver::whereHas(
                                    'user.roles',
                                    fn($q) =>
                                    $q->where('name', RoleEnum::DRIVER->value)
                                )->with('user')->get()->pluck('user.name', 'id')
                            )
                            ->preload()
                            ->required(),

                        DatePicker::make('lesson_date')
                            ->label(__('filament-panels::pages/lesson.lesson_date'))
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->weekStartsOnSunday()
                            ->suffixIcon('heroicon-o-calendar-date-range')
                            ->locale('ar')
                            ->closeOnDateSelection()
                            ->minDate(now()->subDays(5))
                            ->default(Carbon::now()->addDay())
                            ->required(),

                        TimePicker::make('lesson_start_time')
                            ->label(__('filament-panels::pages/lesson.lesson_start_time'))
                            ->seconds(false)
                            ->native(false)
                            ->displayFormat('h:i A')
                            ->default(now()->format('h:i A'))
                            ->required(),

                        TimePicker::make('lesson_end_time')
                            ->label(__('filament-panels::pages/lesson.lesson_end_time'))
                            ->seconds(false)
                            ->native(false)
                            ->displayFormat('h:i A')
                            ->default(now()->addHour()->format('h:i A'))
                            ->required(),


                        TextInput::make('lesson_location')
                            ->label(__('filament-panels::pages/lesson.lesson_location'))
                            ->required(),



                        Select::make('status')
                            ->label(__('filament-panels::pages/lesson.status'))
                            ->options(
                                collect(LessonStatusEnum::cases())->mapWithKeys(fn($case) => [$case->value => __('filament-panels::pages/lesson.' . $case->value)])
                            )
                            ->default(LessonStatusEnum::SCHEDULED->value)
                            ->required(),

                        TextInput::make('lesson_duration')
                            ->label(__('filament-panels::pages/lesson.lesson_duration'))
                            ->numeric()
                            ->nullable()
                            ->readOnly()
                            ->visibleOn('edit'),

                        DateTimePicker::make('check_in_time')
                            ->label(__('filament-panels::pages/lesson.check_in_time'))
                            ->nullable()
                            ->readOnly()
                            ->visibleOn('edit'),

                        DateTimePicker::make('check_out_time')
                            ->label(__('filament-panels::pages/lesson.check_out_time'))
                            ->nullable()

                            ->readOnly()
                            ->visibleOn('edit'),

                        TextInput::make('uber_charge')
                            ->label(__('filament-panels::pages/lesson.uber_charge'))
                            ->numeric()
                            ->prefix('QR')
                            ->nullable()
                            ->readOnly()
                            ->visibleOn('edit'),

                        TextInput::make('lesson_price')
                            ->label(__('filament-panels::pages/lesson.lesson_price'))
                            ->numeric()
                            ->prefix('QR')
                            ->nullable(),

                        TextInput::make('commission_rate')
                            ->label(__('filament-panels::pages/lesson.commission_rate'))
                            ->numeric()
                            ->suffix('%')
                            ->disabled()
                            ->nullable(),

                        Textarea::make('lesson_notes')
                            ->label(__('filament-panels::pages/lesson.lesson_notes'))
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
