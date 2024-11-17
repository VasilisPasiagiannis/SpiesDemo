<?php

namespace App\Domains\Spies\Repositories;

use App\Domains\Spies\Commands\CreateSpyCommand;
use App\Domains\Spies\Models\Spy;
use App\Domains\Spies\Models\SpyDTO;
use Carbon\Carbon;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class SpyRepository implements SpyRepositoryInterface
{
    public function __construct(protected Spy $model)
    {}

    public function get(): array
    {
        $spies = Spy::inRandomOrder()->take(5)->get();
        return SpyDTO::collection($spies)?->resource?->toArray();
    }

    /**
     * @throws Exception
     */
    public function paginated(array $filters = []): LengthAwarePaginator
    {
        $query = Spy::query();

        // Filters
        if ($filters['name'] ?? false) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if ($filters['surname'] ?? false) {
            $query->where('surname', 'like', '%' . $filters['surname'] . '%');
        }

        if ($filters['age'] ?? false) {
            $age = $filters['age'] ;
            $birthdayRange = $this->getAgeRange($age);

            if ($birthdayRange) {
                $query->whereBetween('birthday', [$birthdayRange['start'], $birthdayRange['end']]);
            } else {
                throw new Exception('Invalid age filter');
//                return response()->json(['error' => 'Invalid age filter'], 400);
            }
        }

        // Sorting
        if ($filters['sort'] ?? false) {
            $sortParams = explode(',', $filters['sort']);
            foreach ($sortParams as $param) {
                $direction = str_starts_with($param, '-') ? 'desc' : 'asc';
                $field = ltrim($param, '-');
                if (in_array($field, ['full_name', 'birthday', 'deathday'])) {
                    if ($field == 'full_name') {
                        $query->orderBy('name', $direction)->orderBy('surname', $direction);
                    } else {
                        $query->orderBy($field, $direction);
                    }
                } else {
                    throw new Exception("Sorting by '$field' is not supported");
//                    return response()->json(['error' => "Sorting by '$field' is not supported"], 400);
                }
            }
        }

        return $query->paginate(10);
    }

    public function getById(string $id): ?Spy
    {
        return $this->model->findOrFail($id);
    }

    public function store(CreateSpyCommand $entityCommand): ?Spy
    {
        try{
            $spy = $this->model::create([
                'name' => $entityCommand->name,
                'surname' => $entityCommand->surname,
                'agency' => $entityCommand->agency,
                'country_of_operation' => $entityCommand->countryOfOperation,
                'birthday' => Carbon::parse($entityCommand->birthday)->format('Y-m-d'),
                'deathday' => $entityCommand->deathday ? Carbon::parse($entityCommand->deathday)->format('Y-m-d') : null
            ]);
        }catch (Exception $exception){
            \Log::error($exception->getMessage());
            return null;
        }


        return $spy;
    }

    public function update(CreateSpyCommand $entityCommand, string $id): ?Spy
    {
        $spy = $this->model->findOrFail($id);

        $spy->update([
            'name' => $entityCommand->name,
            'surname' => $entityCommand->surname,
            'agency' => $entityCommand->agency,
            'country_of_operation' => $entityCommand->countryOfOperation,
            'birthday' => Carbon::parse($entityCommand->birthday)->format('Y-m-d'),
            'deathday' => $entityCommand->deathday ? Carbon::parse($entityCommand->deathday)->format('Y-m-d') : null
        ]);

        return $spy;
    }

    public function deleteById(string $id): bool
    {
        $spy = $this->model->findOrFail($id);

        $spy->delete();
        return true;
    }

    /**
     * Get a date range for the given age filter.
     *
     * @param string|array $age
     * @return array|null
     */
    private function getAgeRange($age): ?array
    {
        if (is_array($age)) {
            // Range format: ['min' => 25, 'max' => 30]
            if (isset($age['min'], $age['max'])) {
                $minDate = now()->subYears($age['max'])->format('Y-m-d');
                $maxDate = now()->subYears($age['min'])->format('Y-m-d');

                return ['start' => $minDate, 'end' => $maxDate];
            }
        } elseif (is_numeric($age)) {
            // Exact age format: 25
            $start = now()->subYears($age + 1)->addDay()->format('Y-m-d');
            $end = now()->subYears($age)->format('Y-m-d');

            return ['start' => $start, 'end' => $end];
        }

        return null;
    }

}
