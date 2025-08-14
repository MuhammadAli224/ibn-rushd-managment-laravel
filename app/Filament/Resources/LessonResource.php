<?php

namespace App\Filament\Resources;

use App\Enums\LessonStatusEnum;
use App\Enums\RoleEnum;
use App\Filament\Components\CreatorUpdator;
use App\Filament\Resources\LessonResource\Pages;
use App\Filament\Resources\LessonResource\RelationManagers;
use App\Models\Driver;
use App\Models\Guardian;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Date;
use Filament\Tables\Enums\FiltersLayout;


class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    public static function getNavigationBadge(): ?string
    {

        return static::getModel()::today()->count();
    }

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
                            ->nullable(),

                        DatePicker::make('lesson_date')
                            ->label(__('filament-panels::pages/lesson.lesson_date'))
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->weekStartsOnSunday()
                            ->suffixIcon('heroicon-o-calendar-date-range')
                            ->locale('ar')
                            ->timezone('Asia/Qatar')
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
                            ->timezone('Asia/Qatar')
                            ->required(),

                        TimePicker::make('lesson_end_time')
                            ->label(__('filament-panels::pages/lesson.lesson_end_time'))
                            ->seconds(false)
                            ->native(false)
                            ->displayFormat('h:i A')
                            ->timezone('Asia/Qatar')
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
                            ->prefix('QAR')
                            ->nullable()
                            ->readOnly()
                            ->visibleOn('edit'),

                        TextInput::make('lesson_price')
                            ->label(__('filament-panels::pages/lesson.lesson_price'))
                            ->numeric()
                            ->prefix('QR')
                            ->required(),

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
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('subject.name')
                    ->label(__('filament-panels::pages/dashboard.subject'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('teacher.user.name')
                    ->label(__('filament-panels::pages/dashboard.teacher'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('student.name')
                    ->label(__('filament-panels::pages/dashboard.student'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('filament-panels::pages/lesson.status'))
                    ->sortable()
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        LessonStatusEnum::SCHEDULED => 'info',
                        LessonStatusEnum::COMPLETED => 'success',
                        LessonStatusEnum::CANCELLED => 'danger',
                        LessonStatusEnum::IN_PROGRESS => 'warning',
                        default => 'gray',
                    })
                    ->toggleable(),

                TextColumn::make('driver.user.name')
                    ->label(__('filament-panels::pages/dashboard.driver'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('lesson_date')
                    ->label(__('filament-panels::pages/lesson.lesson_date'))
                    ->sortable()
                    ->dateTime('Y-m-d')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('lesson_start_time')
                    ->label(__('filament-panels::pages/lesson.lesson_start_time'))
                    ->sortable()
                    ->dateTime('h:i A')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('lesson_end_time')
                    ->label(__('filament-panels::pages/lesson.lesson_end_time'))
                    ->sortable()
                    ->dateTime('h:i A')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('lesson_duration')
                    ->label(__('filament-panels::pages/lesson.lesson_duration'))
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->formatStateUsing(function ($state) {
                        $hours = floor($state / 60);
                        $minutes = $state % 60;
                        return sprintf('%d:%02d', $hours, $minutes); // e.g., 1:30
                    }),

                TextColumn::make('lesson_location')
                    ->label(__('filament-panels::pages/lesson.lesson_location'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('lesson_price')
                    ->label(__('filament-panels::pages/lesson.lesson_price'))
                    ->sortable()
                    ->money("QAR")
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('commission_rate')
                    ->label(__('filament-panels::pages/lesson.commission_rate'))
                    ->sortable()
                    ->suffix('%')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('uber_charge')
                    ->label(__('filament-panels::pages/lesson.uber_charge'))
                    ->money("QAR")
                    ->toggleable(isToggledHiddenByDefault: true),

                ...CreatorUpdator::columns(),



            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('filament-panels::pages/lesson.status'))
                    ->options(
                        fn() => collect(LessonStatusEnum::cases())
                            ->mapWithKeys(fn($case) => [$case->value => __('filament-panels::pages/lesson.' . $case->value)])
                            ->toArray()
                    ),



                Tables\Filters\Filter::make('lesson_date')
                    ->label(__('filament-panels::pages/wallet.expenses.columns.specific_date'))
                    ->form([
                        Forms\Components\DatePicker::make('lesson_date')
                            ->label(__('filament-panels::pages/wallet.expenses.columns.specific_date')),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when(
                                $data['lesson_date'],
                                fn(Builder $query, $date) => $query->whereDate('lesson_date', $date)
                            );
                    }),


                SelectFilter::make('subject')
                    ->label(__('filament-panels::pages/dashboard.subject'))
                    ->relationship('subject', 'name'),

                SelectFilter::make('teacher')
                    ->label(__('filament-panels::pages/dashboard.teacher'))
                    ->options(
                        fn() => Teacher::with('user')->get()->pluck('user.name', 'id')->toArray()
                    ),

                SelectFilter::make('student')
                    ->label(__('filament-panels::pages/dashboard.student'))
                    ->relationship('student', 'name'),

                SelectFilter::make('driver')
                    ->label(__('filament-panels::pages/dashboard.driver'))
                    ->options(
                        fn() => Driver::with('user')->get()->pluck('user.name', 'id')->toArray()
                    ),

                SelectFilter::make('guardian')
                    ->label(__('filament-panels::pages/dashboard.guardian'))
                    ->options(function () {
                        return Guardian::with('user')
                            ->get()
                            ->mapWithKeys(fn($guardian) => [$guardian->id => $guardian->user->name ?? ''])
                            ->toArray();
                    })
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('student', fn($q) => $q->where('guardian_id', $data['value']));
                        }
                    }),
                ],layout:FiltersLayout::AboveContentCollapsible)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
